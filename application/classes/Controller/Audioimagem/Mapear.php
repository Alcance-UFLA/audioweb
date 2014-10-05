<?php
/**
 * Action para mapear uma imagem.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioimagem_Mapear extends Controller_Geral {

	/**
	 * Action para exibir o formulário de mapear imagens.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Mapear Imagem');
		$this->adicionar_script(URL::site('js/audioimagem/mapear.min.js'));

		$dados = array();
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['form_imagem'] = array();
		$dados['form_imagem']['dados'] = isset($flash_data['imagem']) ? $flash_data['imagem'] : $this->obter_dados_imagem();
		$dados['form_imagem']['lista_tipo_regiao'] = array(
			'poly'   => 'Polígono',
			'rect'   => 'Retângulo',
			'circle' => 'Círculo'
		);

		$this->template->content = View::Factory('audioimagem/mapear/index', $dados);
	}

	/**
	 * Salvar dados de mapeamento da imagem.
	 * @return void
	 */
	public function action_salvar()
	{
		$this->requerer_autenticacao();

		$id = $this->request->param('id');

		if ($this->request->method() != 'POST')
		{
			HTTP::redirect('audioimagem/mapear/' . $id . URL::query(array()));
		}

		$dados_imagem = $this->obter_dados_imagem();
		$dados_imagem['regiao'] = array(
			'nome'        => $this->request->post('nome'),
			'descricao'   => $this->request->post('descricao'),
			'tipo_regiao' => $this->request->post('tipo_regiao'),
			'coordenadas' => $this->request->post('coordenadas')
		);

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
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioimagem/mapear/' . $id . URL::query(array()));
		}

		try
		{
			$regiao = ORM::factory('Imagem_Regiao');
			$regiao->nome        = $this->request->post('nome');
			$regiao->descricao   = $this->request->post('descricao');
			$regiao->tipo_regiao = $this->request->post('tipo_regiao');
			$regiao->coordenadas = $this->request->post('coordenadas');
			$regiao->id_imagem   = (int)$dados_imagem['imagem']['id_imagem'];
			$regiao->posicao     = count($dados_imagem['regioes']) + 1;
			$regiao->save();
		}
		catch (ORM_Validation_Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioimagem/mapear/' . $id . URL::query(array()));
		}
		catch (Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao salvar a região. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('imagem' => $dados_imagem);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioimagem/mapear/' . $id . URL::query(array()));
		}

		$mensagens = array('sucesso' => 'Região salva com sucesso.');
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect('audioimagem/mapear/' . $id . URL::query(array()));

	}

	/**
	 * Obtem o objeto da imagem que deve ser alterada.
	 * @return Model_Imagem
	 */
	private function obter_imagem()
	{
		$id = $this->request->param('id');

		$imagem = ORM::factory('Imagem', $id);
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
	 * Retorna os dados da imagem que deve ser alterada, para usar no formulario.
	 * @return array
	 */
	private function obter_dados_imagem()
	{
		$imagem = $this->obter_imagem();

		$dados_imagem['imagem'] = array(
			'id_imagem' => $imagem->pk(),
			'nome'      => $imagem->nome,
			'arquivo'   => $imagem->arquivo,
			'largura'   => $imagem->largura,
			'altura'    => $imagem->altura,
			'id_conta'  => $imagem->usuario->id_conta
		);
		$dados_imagem['regiao'] = array();
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

		return $dados_imagem;
	}
}
