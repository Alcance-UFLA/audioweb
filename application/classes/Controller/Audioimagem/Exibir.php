<?php
/**
 * Action para exibir uma imagem.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioimagem_Exibir extends Controller_Geral {

	const BIP_INTERNO = 'som/bip.mp3';
	const BIP_BORDA   = 'som/bip3.mp3';

	public $exibir_scripts_head = true;

	/**
	 * Action para exibir imagens audiodescritas.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Exibir Imagem');
		$this->adicionar_style(URL::cdn('css/audioimagem/exibir.min.css'));
		$this->adicionar_script(URL::cdn('js/audioimagem/exibir.min.js'));
		$this->adicionar_style(array(
			'href'  => URL::cdn('css/audioimagem/modo-cego.min.css'),
			'rel'   => 'prefetch alternate stylesheet',
			'title' => 'Modo',
			'id'    => 'estilo-modo-cego'
		));
		$this->adicionar_style(array(
			'href'  => URL::cdn('css/audioimagem/modo-vidente.min.css'),
			'rel'   => 'prefetch alternate stylesheet',
			'title' => 'Modo',
			'id'    => 'estilo-modo-vidente'
		));

		$configuracoes_usuario = Model_Util_Configuracoes::obter_configuracoes_usuario();
		$sintetizador = $configuracoes_usuario['SINTETIZADOR']['valor'];

		$dados = array();
		$dados['trilha'] = array();
		$dados['trilha'][] = array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home');
		if ($this->request->query('id_aula')) {
			$dados['trilha'][] = array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education');
			$dados['trilha'][] = array('url' => Route::url('acao_id', array('directory' => 'audioaula', 'controller' => 'exibir', 'id' => $this->request->query('id_aula'))), 'nome' => 'Exibir Aula', 'icone' => 'eye-open');
		} else {
			$dados['trilha'][] = array('url' => Route::url('listar', array('directory' => 'audioimagem')), 'nome' => 'AudioImagem', 'icone' => 'picture');
		}
		$dados['trilha'][] = array('nome' => 'Exibir Imagem', 'icone' => 'eye-open');

        $dados['id_aula'] = $this->request->query('id_aula');

		$dados['modo_exibicao'] = 'vidente'; // "vidente" | "cego"
		$dados['imagem'] = $this->obter_dados_imagem();
		$dados['sintetizador'] = array(
			'driver' => $sintetizador,
			'config' => isset($configuracoes_usuario[strtoupper($sintetizador)]['valor']) ?: null
		);
		$dados['teclas'] = Model_Util_Teclas::obter_teclas_atalho();
		$dados['audio_auxiliar'] = self::obter_audio_auxiliar($dados);
        $dados['debug'] = $this->request->query('debug');

		$this->template->content = View::Factory('audioimagem/exibir/index', $dados);
	}

	/**
	 * Acoes especificas para as regioes:
	 * /audioimagem/<id_imagem>/exibir/regiao/<id_imagem_regiao>
	 * /audioimagem/<id_imagem>/exibir/regiao/<id_imagem_regiao>/audio/nome.mp3
	 * /audioimagem/<id_imagem>/exibir/regiao/<id_imagem_regiao>/audio/descricao.mp3
	 * @return void
	 */
	public function action_regiao()
	{
		$this->requerer_autenticacao();

		$imagem = $this->obter_imagem();

		$id_imagem_regiao = $this->request->param('opcao1');
		$regiao = ORM::factory('Imagem_Regiao', $id_imagem_regiao);

		$acao = $this->request->param('opcao2');

		switch ($acao) {
		// Retorna um JSON com os dados da regiao
		case '':
			$json = json_encode($regiao->as_array());
			$this->etag = sha1($json);
			$this->response->headers('Content-Type', 'application/json');
			$this->response->body($json);
			break;

		// Retorna o audio MP3 de uma regiao (nome ou descricao)
		case 'audio':
			try {
				$tipo_retorno = $this->request->param('opcao3');
				switch ($tipo_retorno) {
				case 'nome.mp3':
				default:
					$texto = $regiao->nome;
					break;
				case 'descricao.mp3':
					$texto = $regiao->descricao;
					break;
				default:
					throw HTTP_Exception::factory(404, 'Opção inválida.');
					break;
				}

				if ($this->request->query('driver')) {
					$driver = $this->request->query('driver');
				} else {
					$driver = Kohana::$config->load('sintetizador.driver');
				}
				$config_pessoal = $this->request->query('config');
				if ( ! $config_pessoal) {
					$config_pessoal = array();
				}

				Controller_Audio_Exibir::retornar_audio($this, $driver, $config_pessoal, $texto);
			} catch (LogicException $e) {
				throw HTTP_Exception::factory(400, $e->getMessage());
			} catch (RuntimeException $e) {
				throw HTTP_Exception::factory(500, $e->getMessage());
			}
			break;
		default:
			throw HTTP_Exception::factory(404, 'Ação inválida.');
			break;
		}
	}

	/**
	 * Obtem o objeto da imagem que deve ser exibida.
	 * @return Model_Imagem
	 */
	private function obter_imagem()
	{
		$id = $this->request->param('id');

		$imagem = ORM::factory('Imagem', $id);
		if ( ! $imagem->loaded()) {
			throw HTTP_Exception::factory(404, 'Imagem não encontrada');
		}
		/*
		if ($imagem->id_usuario != Auth::instance()->get_user()->pk()) {
			throw new RuntimeException('Imagem nao pertence ao usuario logado');
		}
		*/
		return $imagem;
	}

	/**
	 * Retorna os dados da imagem que deve ser exibida.
	 * @return array
	 */
	private function obter_dados_imagem()
	{
		$imagem = $this->obter_imagem();
		$dados_imagem = array();
		$dados_imagem['id_imagem'] = $imagem->pk();
		$dados_imagem['id_conta']  = $imagem->usuario->id_conta;
		$dados_imagem['nome']      = $imagem->nome;
		$dados_imagem['descricao'] = $imagem->descricao;
		$dados_imagem['arquivo']   = $imagem->arquivo;
		$dados_imagem['mime_type'] = $imagem->mime_type;
		$dados_imagem['altura']    = $imagem->altura;
		$dados_imagem['largura']   = $imagem->largura;
		$dados_imagem['rotulos']   = preg_split('/\s*,\s*/u', $imagem->rotulos);

		$dados_imagem['tipo_imagem'] = array();
		$dados_imagem['tipo_imagem']['id_tipo_imagem'] = $imagem->id_tipo_imagem;
		$dados_imagem['tipo_imagem']['nome']           = $imagem->tipo_imagem->nome;

		$dados_imagem['publicos_alvos'] = array();
		foreach ($imagem->publicos_alvos->find_all() as $publico_alvo) {
			$dados_publico_alvo = array();
			$dados_publico_alvo['id_publico_alvo'] = $publico_alvo->id_publico_alvo;
			$dados_publico_alvo['nome']            = $publico_alvo->nome;
			$dados_imagem['publicos_alvos'][] = $dados_publico_alvo;
		}

		$dados_imagem['regioes'] = array();
		foreach ($imagem->regioes->order_by('posicao')->find_all() as $regiao) {
			$dados_regiao = array();
			$dados_regiao['id_imagem_regiao'] = $regiao->pk();
			$dados_regiao['nome']             = $regiao->nome;
			$dados_regiao['descricao']        = $regiao->descricao;
			$dados_regiao['tipo_regiao']      = $regiao->tipo_regiao;
			$dados_regiao['coordenadas']      = $regiao->coordenadas;
			$dados_regiao['caracteristicas']  = $regiao->obter_caracteristicas();
			$dados_imagem['regioes'][] = $dados_regiao;
		}

		$tamanho_borda = 10;
		$coordenadas_borda = array(
			0, 0,
			0, $imagem->altura,
			$imagem->largura, $imagem->altura,
			$imagem->largura, 0,
			0, 0,
			0 + $tamanho_borda, 0 + $tamanho_borda,
			$imagem->largura - $tamanho_borda, 0 + $tamanho_borda,
			$imagem->largura - $tamanho_borda, $imagem->altura - $tamanho_borda,
			0 + $tamanho_borda, $imagem->altura - $tamanho_borda,
			0 + $tamanho_borda, 0 + $tamanho_borda
		);
		$dados_imagem['coordenadas_borda'] = implode(',', $coordenadas_borda);
		return $dados_imagem;
	}

	/**
	 * Gera a lista de audio auxiliar
	 * @param array $dados
	 * @return array
	 */
	public static function obter_audio_auxiliar(array $dados)
	{
		$teclas = Model_Util_Teclas::obter_teclas_atalho();

		$ajuda_teclas = "Teclas de atalho:\n";
		foreach ($teclas as $tecla) {
			$ajuda_teclas .= "Tecla: " . $tecla['tecla'] . ". Ação: " . $tecla['acao'] . "\n";
		}

		$lista = array(
			// Avisos
			'aviso-pagina-carregando' => array(
				'texto' => 'Aguarde o carregamento da página',
				'class' => ''
			),

			// Bips
			'audio-bip-interno' => array(
				'url'   => URL::site(self::BIP_INTERNO),
				'class' => 'audio-bip',
				'loop'  => true
			),
			'audio-bip-borda' => array(
				'url'   => URL::site(self::BIP_BORDA),
				'class' => 'audio-bip',
				'loop'  => true
			),

			// Regioes externas
			'audio-regiao-externa-cima' => array(
				'texto' => 'Acima da imagem',
				'class' => 'audio-regiao-externa',
			),
			'audio-regiao-externa-baixo' => array(
				'texto' => 'Abaixo da imagem',
				'class' => 'audio-regiao-externa'
			),
			'audio-regiao-externa-direita' => array(
				'texto' => 'À direita da imagem',
				'class' => 'audio-regiao-externa'
			),
			'audio-regiao-externa-esquerda' => array(
				'texto' => 'À esquerda da imagem',
				'class' => 'audio-regiao-externa'
			),
			'audio-regiao-externa-cima-direita' => array(
				'texto' => 'Acima e à direita da imagem',
				'class' => 'audio-regiao-externa'
			),
			'audio-regiao-externa-cima-esquerda'  => array(
				'texto' => 'Acima e à esquerda da imagem',
				'class' => 'audio-regiao-externa'
			),
			'audio-regiao-externa-baixo-direita' => array(
				'texto' => 'Abaixo e à direita da imagem',
				'class' => 'audio-regiao-externa'
			),
			'audio-regiao-externa-baixo-esquerda' => array(
				'texto' => 'Abaixo e à esquerda da imagem',
				'class' => 'audio-regiao-externa'
			),

			// Regioes internas
			'audio-regiao-interna-cima-centro' => array(
				'texto' => 'Dentro e acima da imagem',
				'class' => 'audio-regiao-interna'
			),
			'audio-regiao-interna-baixo-centro' => array(
				'texto' => 'Dentro e abaixo da imagem',
				'class' => 'audio-regiao-interna'
			),
			'audio-regiao-interna-centro-direita' => array(
				'texto' => 'Dentro e à direita da imagem',
				'class' => 'audio-regiao-interna'
			),
			'audio-regiao-interna-centro-esquerda' => array(
				'texto' => 'Dentro e à esquerda da imagem',
				'class' => 'audio-regiao-interna'
			),
			'audio-regiao-interna-cima-direita' => array(
				'texto' => 'Dentro, acima e à direita da imagem',
				'class' => 'audio-regiao-interna'
			),
			'audio-regiao-interna-cima-esquerda' => array(
				'texto' => 'Dentro, acima e à esquerda da imagem',
				'class' => 'audio-regiao-interna'
			),
			'audio-regiao-interna-baixo-direita' => array(
				'texto' => 'Dentro, abaixo e à direita da imagem',
				'class' => 'audio-regiao-interna'
			),
			'audio-regiao-interna-baixo-esquerda' => array(
				'texto' => 'Dentro, abaixo e à esquerda da imagem',
				'class' => 'audio-regiao-interna'
			),
			'audio-regiao-interna-centro-centro' => array(
				'texto' => 'Dentro e no centro da imagem',
				'class' => 'audio-regiao-interna'
			),

			// Audios auxiliares
			'audio-ajuda' => array(
				'url' => URL::site('som/ajuda.mp3'),
/*
				'elementos' => array(
					array('texto' => $ajuda_teclas),
					array('texto' => 'Sons emitidos pelo sistema:'),
					array('texto' => 'Bip quando o cursor fica sobre uma região mapeada da imagem:'),
					array('audio' => DOCROOT . self::BIP_INTERNO),
					array('audio' => DOCROOT . self::BIP_INTERNO),
					array('audio' => DOCROOT . self::BIP_INTERNO),
					array('texto' => 'Bip quando o cursor fica sobre a borda da imagem:'),
					array('audio' => DOCROOT . self::BIP_BORDA),
					array('audio' => DOCROOT . self::BIP_BORDA),
					array('audio' => DOCROOT . self::BIP_BORDA),
				),
*/
				'class' => ''
			),
			'audio-nome-imagem' => array(
				'texto' => isset($dados['imagem']) ? $dados['imagem']['nome'] : '',
				'class' => ''
			),
			'audio-descricao-imagem' => array(
				'texto' => isset($dados['imagem']) ? $dados['imagem']['descricao'] : '',
				'class' => ''
			),
			'audio-modo-vidente' => array(
				'texto' => 'Modo vidente',
				'class' => ''
			),
			'audio-modo-cego' => array(
				'texto' => 'Modo cego',
				'class' => ''
			),
			'aviso-pagina-carregada' => array(
				'texto' => 'Página carregada. Para ouvir a ajuda, aperte ' . $teclas['falar_ajuda']['tecla'] . '.',
				'class' => ''
			),
		);

		foreach ($lista as $id => $dados_audio) {
			if (isset($dados_audio['url'])) {
				continue;
			}
			if (isset($dados_audio['texto'])) {
				$elementos = array(
					array('texto' => $dados_audio['texto'])
				);
			} elseif (isset($dados_audio['elementos'])) {
				$elementos = $dados_audio['elementos'];
			} else {
				throw new LogicException('Lista invalida (registro sem chave texto ou elementos): ' . $id . ' = ' . var_export($dados_audio, true));
			}

			$dados_audio['url'] = Helper_Audio::montar_url_audio($elementos, $dados['sintetizador']);
			$lista[$id] = $dados_audio;
		}
		return $lista;
	}
}
