<?php
/**
 * Action para mapear uma imagem.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioimagem_Mapear extends Controller_Geral {

	/**
	 * Action para exibir a ferramenta para mapear imagens.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Mapear Imagem');
		$this->adicionar_style(URL::site('css/jquery-ui/jquery-ui.min.css'));
		$this->adicionar_style(URL::site('css/audioimagem/mapear.min.css'));
		$this->adicionar_script(URL::site('js/jquery-ui/jquery-ui.min.js'));
		$this->adicionar_script(URL::site('js/jquery.cookie.min.js'));
		$this->adicionar_script(URL::site('js/audioimagem/mapear.min.js'));

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioimagem')), 'nome' => 'AudioImagem', 'icone' => 'picture'),
			array('nome' => 'Mapear Imagem', 'icone' => 'tag')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['form_imagem'] = array();
		$dados['form_imagem']['dados'] = isset($flash_data['imagem_mapear']) ? $flash_data['imagem_mapear'] : $this->obter_dados_imagem();
		$dados['form_imagem']['lista_tipo_regiao'] = array(
			'poly'   => 'Polígono',
			'rect'   => 'Retângulo',
			'circle' => 'Círculo'
		);

		$this->template->content = View::Factory('audioimagem/mapear/index', $dados);
	}

	/**
	 * Realiza operacoes relacionadas a uma regiao da imagem
	 * /audioimagem/<id_imagem>/mapear/regiao/inserir
	 * /audioimagem/<id_imagem>/mapear/regiao/inserir/salvar
	 * /audioimagem/<id_imagem>/mapear/regiao/alterar/<id_imagem_regiao>
	 * /audioimagem/<id_imagem>/mapear/regiao/alterar/<id_imagem_regiao>/salvar
	 * /audioimagem/<id_imagem>/mapear/regiao/remover/<id_imagem_regiao>/salvar
	 * /audioimagem/<id_imagem>/mapear/regiao/posicoes/salvar
	 * @return void
	 */
	public function action_regiao()
	{
		$this->requerer_autenticacao();

		$id_imagem = $this->request->param('id');
		$opcao1    = $this->request->param('opcao1');
		$opcao2    = $this->request->param('opcao2');
		$opcao3    = $this->request->param('opcao3');

		$imagem = $this->obter_imagem($id_imagem);

		switch ($opcao1)
		{
			case 'inserir':
				$acao = $opcao1;
				$sub_acao = $opcao2;
			break;
			case 'posicoes':
				$acao = $opcao1;
				$sub_acao = $opcao2;
			break;
			case 'alterar':
			case 'remover':
				$acao = $opcao1;
				$id_imagem_regiao = $opcao2;
				$sub_acao = $opcao3;
				$regiao = $this->obter_imagem_regiao($imagem, $id_imagem_regiao);
			break;
		}

		switch ($acao)
		{
			case 'posicoes':
				return $this->salvar_posicoes_regioes($imagem, $sub_acao);
			case 'inserir':
				return $this->inserir_regiao($imagem, $sub_acao);
			case 'alterar':
				return $this->alterar_regiao($imagem, $regiao, $sub_acao);
			case 'remover':
				return $this->remover_regiao($imagem, $regiao, $sub_acao);
			default:
				throw HTTP_Exception::factory(404, 'Ação inválida.');
		}
	}

	/**
	 * Action para inserir uma nova regiao
	 * @param Model_Imagem $imagem
	 * @param string $sub_acao
	 * @return void
	 */
	private function inserir_regiao(Model_Imagem $imagem, $sub_acao)
	{
		$id_imagem = $imagem->pk();

		// Obter dados da imagem e da regiao
		$dados_imagem = $this->obter_dados_imagem($id_imagem);

		if ($sub_acao != 'salvar')
		{
			$flash_data = Session::instance()->get('flash_data', array());
			$dados_imagem = isset($flash_data['imagem_mapear']) ? $flash_data['imagem_mapear'] : $dados_imagem;
			$dados_imagem['acao'] = 'inserir';
			$flash_data = array('imagem_mapear' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);
			return $this->action_index();
		}

		$url_inserir_imagem = sprintf(
			'%s%s',
			Route::url('alterar', array(
				'directory' => 'audioimagem',
				'controller' => 'mapear',
				'id' => $id_imagem,
				'action' => 'regiao',
				'opcao1' => 'inserir'
			)),
			URL::query(array())
		);
		if ($this->request->method() != 'POST')
		{
			HTTP::redirect($url_inserir_imagem);
		}

		$dados_imagem['regiao'] = array(
			'id_imagem_regiao' => null,
			'nome'             => $this->request->post('nome'),
			'descricao'        => $this->request->post('descricao'),
			'tipo_regiao'      => $this->request->post('tipo_regiao'),
			'coordenadas'      => $this->request->post('coordenadas')
		);

		// Validar dados da regiao
		$rules = ORM::factory('Imagem_Regiao')->rules();
		$post = Validation::factory($this->request->post())
			->rules('nome', $rules['nome'])
			->rules('descricao', $rules['descricao'])
			->rules('tipo_regiao', $rules['tipo_regiao'])
			->rules('coordenadas', $rules['coordenadas']);

		if ( ! $post->check())
		{
			$mensagens = array('atencao' => $post->errors('models/imagem/regiao'));
			Session::instance()->set('flash_message', $mensagens);
			$dados_imagem['acao'] = 'inserir';
			$flash_data = array('imagem_mapear' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect($url_inserir_imagem);
		}

		// Inserir regiao
		$bd = Database::instance();
		$bd->begin();

		try
		{
			$regiao = ORM::factory('Imagem_Regiao');
			$regiao->nome        = $this->request->post('nome');
			$regiao->descricao   = $this->request->post('descricao');
			$regiao->tipo_regiao = $this->request->post('tipo_regiao');
			$regiao->coordenadas = $this->request->post('coordenadas');
			$regiao->posicao     = count($dados_imagem['regioes']) + 1;
			$regiao->imagem      = $imagem;
			$regiao->save();

			$bd->commit();
		}
		catch (ORM_Validation_Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$dados_imagem['acao'] = 'inserir';
			$flash_data = array('imagem_mapear' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect($url_inserir_imagem);
		}
		catch (Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao salvar a região. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$dados_imagem['acao'] = 'inserir';
			$flash_data = array('imagem_mapear' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect($url_inserir_imagem);
		}

		$mensagens = array('sucesso' => 'Região salva com sucesso.');
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect('audioimagem/mapear/' . $id_imagem . URL::query(array()));
	}

	/**
	 * Action para atualizar os dados de uma regiao
	 * @param Model_Imagem $imagem
	 * @param Model_Imagem_regiao $regiao
	 * @param string $sub_acao
	 * @return void
	 */
	private function alterar_regiao(Model_Imagem $imagem, Model_Imagem_Regiao $regiao, $sub_acao)
	{
		$id_imagem = $imagem->pk();

		// Obter dados da imagem e da regiao
		$dados_imagem = $this->obter_dados_imagem($id_imagem, $regiao->pk());

		if ($sub_acao != 'salvar')
		{
			$flash_data = Session::instance()->get('flash_data', array());
			$dados_imagem = isset($flash_data['imagem_mapear']) ? $flash_data['imagem_mapear'] : $dados_imagem;
			$dados_imagem['acao'] = 'alterar';
			$flash_data = array('imagem_mapear' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);
			return $this->action_index();
		}

		$url_alterar_imagem = sprintf(
			'%s%s',
			Route::url('alterar', array(
				'directory' => 'audioimagem',
				'controller' => 'mapear',
				'id' => $id_imagem,
				'action' => 'regiao',
				'opcao1' => 'alterar',
				'opcao2' => $regiao->pk()
			)),
			URL::query(array())
		);
		if ($this->request->method() != 'POST')
		{
			HTTP::redirect($url_alterar_imagem);
		}

		$dados_imagem['regiao'] = array(
			'id_imagem_regiao' => $regiao->pk(),
			'nome'             => $this->request->post('nome'),
			'descricao'        => $this->request->post('descricao'),
			'tipo_regiao'      => $this->request->post('tipo_regiao'),
			'coordenadas'      => $this->request->post('coordenadas')
		);

		// Validar dados da regiao
		$rules = ORM::factory('Imagem_Regiao')->rules();
		$post = Validation::factory($this->request->post())
			->rules('nome', $rules['nome'])
			->rules('descricao', $rules['descricao'])
			->rules('tipo_regiao', $rules['tipo_regiao'])
			->rules('coordenadas', $rules['coordenadas']);

		if ( ! $post->check())
		{
			$mensagens = array('atencao' => $post->errors('models/imagem/regiao'));
			Session::instance()->set('flash_message', $mensagens);
			$dados_imagem['acao'] = 'alterar';
			$flash_data = array('imagem_mapear' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect($url_alterar_imagem);
		}

		// Atualizar regiao
		$bd = Database::instance();
		$bd->begin();

		try
		{
			$regiao->nome        = $this->request->post('nome');
			$regiao->descricao   = $this->request->post('descricao');
			$regiao->tipo_regiao = $this->request->post('tipo_regiao');
			$regiao->coordenadas = $this->request->post('coordenadas');
			$regiao->save();

			$bd->commit();

			$dados_imagem['acao'] = '';
			$dados_imagem['regiao'] = array(
				'id_imagem_regiao' => null,
				'nome'             => null,
				'descricao'        => null,
				'tipo_regiao'      => null,
				'coordenadas'      => null
			);
		}
		catch (ORM_Validation_Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$dados_imagem['acao'] = 'alterar';
			$flash_data = array('imagem_mapear' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect($url_alterar_imagem);
		}
		catch (Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao salvar a região. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$dados_imagem['acao'] = 'alterar';
			$flash_data = array('imagem_mapear' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect($url_alterar_imagem);
		}

		$mensagens = array('sucesso' => 'Região salva com sucesso.');
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect('audioimagem/mapear/' . $id_imagem . URL::query(array()));
	}

	/**
	 * Action para remover uma regiao da imagem
	 * @param Model_Imagem $imagem
	 * @param Model_Imagem_regiao $regiao
	 * @param string $sub_acao
	 * @return void
	 */
	private function remover_regiao(Model_Imagem $imagem, Model_Imagem_Regiao $regiao, $sub_acao)
	{
		$id_imagem = $imagem->pk();

		// Obter dados da imagem e da regiao
		$dados_imagem = $this->obter_dados_imagem($id_imagem, $regiao->pk());

		if ($sub_acao != 'salvar')
		{
			$dados_imagem['acao'] = 'remover';
			$flash_data = array('imagem_mapear' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);
			return $this->action_index();
		}

		$url_remover_imagem = sprintf(
			'%s%s',
			Route::url('alterar', array(
				'directory' => 'audioimagem',
				'controller' => 'mapear',
				'id' => $id_imagem,
				'action' => 'regiao',
				'opcao1' => 'remover',
				'opcao2' => $regiao->pk()
			)),
			URL::query(array())
		);
		if ($this->request->method() != 'POST')
		{
			HTTP::redirect($url_remover_imagem);
		}

		// Validar confirmacao
		if ( ! $this->request->post('confirmar'))
		{
			$mensagens = array('atencao' => array('Para remover a região é necessário marcar a confirmação.'));
			Session::instance()->set('flash_message', $mensagens);
			$dados_imagem['acao'] = 'remover';
			$flash_data = array('imagem_mapear' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect($url_remover_imagem);
		}

		// Remover regiao
		$bd = Database::instance();
		$bd->begin();

		try
		{
			$regiao->delete();

			// Atualizar as posicoes das regioes restantes
			$posicao = 1;
			foreach ($imagem->regioes->find_all() as $regiao_ajustar)
			{
				$regiao_ajustar->posicao = $posicao;
				$regiao_ajustar->save();
				$posicao += 1;
			}

			$bd->commit();

			$dados_imagem['acao'] = '';
			$dados_imagem['regiao'] = array(
				'id_imagem_regiao' => null,
				'nome'             => null,
				'descricao'        => null,
				'tipo_regiao'      => null,
				'coordenadas'      => null
			);
		}
		catch (Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao remover a região. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$dados_imagem['acao'] = 'remover';
			$flash_data = array('imagem_mapear' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect($url_remover_imagem);
		}

		$mensagens = array('sucesso' => 'Região removida com sucesso.');
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect('audioimagem/mapear/' . $id_imagem . URL::query(array()));
	}

	/**
	 * Action que recebe dados via AJAX para atualizar a ordem das regioes
	 * @param Model_Imagem $imagem
	 * @param string $sub_acao
	 * @return void
	 */
	private function salvar_posicoes_regioes(Model_Imagem $imagem, $sub_acao)
	{
		$resposta = array();

		$bd = Database::instance();
		$bd->begin();

		try {

			// Validar requisicao
			if ( ! $this->request->is_ajax())
			{
				throw new RuntimeException('Requisição inválida.');
			}
			if ($this->request->method() != 'POST')
			{
				throw new RuntimeException('Método de requisição inválido.');
			}

			$total_regioes = $imagem->regioes->count_all();

			// Atualizar as regioes
			foreach ($this->request->post('mudancas') as $id_imagem_regiao => $nova_posicao)
			{
				if ($nova_posicao <= 0 || $nova_posicao > $total_regioes)
				{
					throw new RuntimeException('Posição inválida.');
				}

				$regiao = $this->obter_imagem_regiao($imagem, $id_imagem_regiao);
				$regiao->posicao = $nova_posicao;
				$regiao->save();
			}

			$bd->commit();
			$resposta['sucesso'] = true;
		}
		catch (Exception $e)
		{
			$bd->rollback();

			$resposta['sucesso'] = false;
			$resposta['erro'] = $e->getMessage();
		}

		// Retornar JSON
		$this->response->headers('Content-type','application/json; charset='.Kohana::$charset);
		$this->response->body(json_encode($resposta));
	}

	/**
	 * Obtem o objeto da imagem que deve ser alterada.
	 * @return Model_Imagem
	 */
	private function obter_imagem($id_imagem = null)
	{
		if ($id_imagem === null)
		{
			$id_imagem = $this->request->param('id');
		}

		$imagem = ORM::factory('Imagem', $id_imagem);
		if ( ! $imagem->loaded())
		{
			throw new RuntimeException('Imagem invalida');
		}
		if ($imagem->id_usuario != Auth::instance()->get_user()->pk())
		{
			throw new RuntimeException('Imagem nao pertence ao usuario logado');
		}
		return $imagem;
	}


	/**
	 * Obtem o objeto da regiao que deve ser alterada.
	 * @return Model_Imagem_Regiao
	 */
	private function obter_imagem_regiao(Model_Imagem $imagem, $id_imagem_regiao)
	{
		$regiao = ORM::factory('Imagem_Regiao', $id_imagem_regiao);
		if ( ! $imagem->loaded())
		{
			throw new RuntimeException('Regiao invalida');
		}
		if ($regiao->id_imagem != $imagem->pk())
		{
			throw new RuntimeException('Regiao nao pertence a imagem atual');
		}
		return $regiao;
	}

	/**
	 * Retorna os dados da imagem que deve ser alterada, para usar no formulario.
	 * @param int | null $id_imagem
	 * @param int | null $id_imagem_regiao
	 * @return array
	 */
	private function obter_dados_imagem($id_imagem = null, $id_imagem_regiao = null)
	{
		$dados_imagem = array();

		// Acao
		$dados_imagem['acao'] = '';

		// Dados da imagem
		$imagem = $this->obter_imagem($id_imagem);
		$dados_imagem['imagem'] = array(
			'id_imagem' => $imagem->pk(),
			'nome'      => $imagem->nome,
			'arquivo'   => $imagem->arquivo,
			'largura'   => $imagem->largura,
			'altura'    => $imagem->altura,
			'id_conta'  => $imagem->usuario->id_conta
		);

		// Dados das regioes da imagem
		$dados_imagem['regioes'] = array();
		foreach ($imagem->regioes->order_by('posicao')->find_all() as $regiao)
		{
			$dados_imagem['regioes'][] = array(
				'id_imagem_regiao' => $regiao->pk(),
				'nome'             => $regiao->nome,
				'descricao'        => $regiao->descricao,
				'posicao'          => $regiao->posicao,
				'tipo_regiao'      => $regiao->tipo_regiao,
				'coordenadas'      => $regiao->coordenadas
			);
		}

		// Dados da regiao
		if ($id_imagem_regiao !== null)
		{
			$regiao = $this->obter_imagem_regiao($imagem, $id_imagem_regiao);
			$dados_imagem['regiao'] = array(
				'id_imagem_regiao' => $regiao->pk(),
				'nome'             => $regiao->nome,
				'descricao'        => $regiao->descricao,
				'tipo_regiao'      => $regiao->tipo_regiao,
				'coordenadas'      => $regiao->coordenadas,
			);
		}
		else
		{
			$dados_imagem['regiao'] = array(
				'id_imagem_regiao' => null,
				'nome'             => null,
				'descricao'        => null,
				'tipo_regiao'      => null,
				'coordenadas'      => null,
			);
		}

		return $dados_imagem;
	}
}
