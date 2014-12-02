<?php
/**
 * Action para exibir uma imagem.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioimagem_Exibir extends Controller_Geral {

	/**
	 * Action para exibir imagens audiodescritas.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Exibir Imagem');
		$this->adicionar_style(URL::site('css/audioimagem/exibir.min.css'));
		$this->adicionar_script(URL::site('js/audioimagem/exibir.min.js'));

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioimagem')), 'nome' => 'AudioImagem', 'icone' => 'picture'),
			array('nome' => 'Exibir Imagem', 'icone' => 'eye-open')
		);

		$dados['modo_exibicao'] = 'vidente'; // "vidente" | "cego"
		$dados['imagem'] = $this->obter_dados_imagem();
		$dados['sintetizador'] = array(
			'driver' => $this->request->query('driver') ? $this->request->query('driver') : Kohana::$config->load('sintetizador.driver'),
			'config' => null
		);
		$dados['teclas'] = $this->obter_teclas_atalho();
		$dados['audio_auxiliar'] = $this->obter_audio_auxiliar($this->request->param('id'));

		$this->template->content = View::Factory('audioimagem/exibir/index', $dados);
	}

	/**
	 * Acoes especificas para as regioes:
	 * /audioimagem/exibir/<id_imagem>/regiao/<id_imagem_regiao>
	 * /audioimagem/exibir/<id_imagem>/regiao/<id_imagem_regiao>/audio/nome.mp3
	 * /audioimagem/exibir/<id_imagem>/regiao/<id_imagem_regiao>/audio/descricao.mp3
	 * @return void
	 */
	public function action_regiao()
	{
		$this->requerer_autenticacao();

		$imagem = $this->obter_imagem();

		$id_imagem_regiao = $this->request->param('opcao1');
		$regiao = ORM::factory('Imagem_Regiao', $id_imagem_regiao);

		$acao = $this->request->param('opcao2');

		switch ($acao)
		{
			// Retorna um JSON com os dados da regiao
			case '':
				$json = json_encode($regiao->as_array());
				$this->etag = sha1($json);
				$this->response->headers('Content-Type', 'application/json');
				$this->response->body($json);
			break;

			// Retorna o audio MP3 de uma regiao (nome ou descricao)
			case 'audio':
				try
				{
					$tipo_retorno = $this->request->param('opcao3');
					switch ($tipo_retorno)
					{
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

					if ($this->request->query('driver'))
					{
						$driver = $this->request->query('driver');
					}
					else
					{
						$driver = Kohana::$config->load('sintetizador.driver');
					}
					$config_pessoal = $this->request->query('config');
					if ( ! $config_pessoal)
					{
						$config_pessoal = array();
					}

					$cache = Cache::instance('file');
					$id_cache = sprintf(
						'audio#driver-%s#regiao-%d#retorno-%s#config-%s',
						$driver,
						$id_imagem_regiao,
						$tipo_retorno,
						md5(json_encode($config_pessoal))
					);
					$conteudo_arquivo_mp3 = $cache->get($id_cache);
					if ( ! $conteudo_arquivo_mp3)
					{
						$sintetizador = Sintetizador::instance($driver);
						$sintetizador->definir_config($config_pessoal);
						$conteudo_arquivo_mp3 = $sintetizador->converter_texto_audio($texto);
						$cache->set($id_cache, $conteudo_arquivo_mp3);
					}

					$this->etag = sha1($conteudo_arquivo_mp3);
					$this->response->headers('Content-Type', 'audio/mpeg');
					$this->response->body($conteudo_arquivo_mp3);
				}
				catch (LogicException $e)
				{
					throw HTTP_Exception::factory(400, $e->getMessage());
				}
				catch (RuntimeException $e)
				{
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
		if ( ! $imagem->loaded())
		{
			throw HTTP_Exception::factory(404, 'Imagem não encontrada');
		}
		if ($imagem->id_usuario != Auth::instance()->get_user()->pk())
		{
			//throw new RuntimeException('Imagem nao pertence ao usuario logado');
		}
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
		foreach ($imagem->publicos_alvos->find_all() as $publico_alvo)
		{
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
		return $dados_imagem;
	}

	/**
	 * Obtem a lista de teclas de atalho
	 * @return array
	 */
	private function obter_teclas_atalho()
	{
		//TODO obter do BD
		return array(
			'falar_nome_regiao' => array(
				'tecla'  => 'c',
				'codigo' => ord('c'),
				'acao'   => 'Fala o nome curto da região onde está o mouse.'
			),
			'falar_descricao_regiao' => array(
				'tecla'  => 'l',
				'codigo' => ord('l'),
				'acao'   => 'Fala a descrição longa da região onde está o mouse.'
			),
			'alternar_modo_exibicao' => array(
				'tecla'  => 'm',
				'codigo' => ord('m'),
				'acao'   => 'Alterna entre o modo de exibição para videntes ou para cegos.'
			),
		);
	}

	/**
	 * Gera a lista de audio auxiliar
	 * @return array
	 */
	private function obter_audio_auxiliar()
	{
		$retorno = array();

		$lista = array(
			'saiu-cima'     => 'Saiu por cima',
			'saiu-baixo'    => 'Saiu por baixo',
			'saiu-direita'  => 'Saiu pela direita',
			'saiu-esquerda' => 'Saiu pela esquerda'
		);
		foreach ($lista as $id => $texto)
		{
			$retorno[$id] = array(
				'texto' => $texto,
				'chave' => md5(Cookie::$salt . $texto)
			);
		}
		return $retorno;
	}
}
