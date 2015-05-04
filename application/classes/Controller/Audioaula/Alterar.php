<?php
/**
 * Action para alterar dados de uma aula.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Alterar extends Controller_Geral {

	/**
	 * Action para exibir o formulário de alterar aulas.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Alterar Aula');

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('nome' => 'Alterar Aula', 'icone' => 'pencil')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['form_aula'] = array();
		$dados['form_aula']['dados'] = isset($flash_data['aula']) ? $flash_data['aula'] : $this->obter_dados_aula();

		$this->template->content = View::Factory('audioaula/alterar/index', $dados);
	}

	/**
	 * Salvar dados da aula.
	 * @return void
	 */
	public function action_salvar()
	{
		$this->requerer_autenticacao();

		$id = $this->request->param('id');

		if ($this->request->method() != 'POST')
		{
			HTTP::redirect('audioaula/alterar/' . $id . URL::query(array()));
		}

		$dados_aula_atual = $this->obter_dados_aula();

		$dados_aula = array(
			'id_aula'   => $id,
			'nome'      => $this->request->post('nome'),
			'descricao' => $this->request->post('descricao'),
			'rotulos'   => $this->request->post('rotulos')
		);

		$rules = ORM::Factory('Aula')->rules();
		$post = Validation::factory($this->request->post())
			->rules('nome', $rules['nome'])
			->rules('descricao', $rules['descricao'])
			->rules('rotulos', $rules['rotulos']);

		if ( ! $post->check())
		{
			$mensagens = array('atencao' => $post->errors('models/aula'));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('aula' => $dados_aula);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioaula/alterar/' . $id . URL::query(array()));
		}

		$bd = Database::instance();
		$bd->begin();

		$mensagens_sucesso = array();
		try
		{
			$aula = $this->obter_aula();
			$aula->nome      = $this->request->post('nome');
			$aula->descricao = $this->request->post('descricao');
			$aula->rotulos   = $this->request->post('rotulos');
			$aula->save();
			$mensagens_sucesso[] = 'Aula alterada com sucesso.';

			$bd->commit();
		}
		catch (ORM_Validation_Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('aula' => $dados_aula);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioaula/alterar/' . $id . URL::query(array()));
		}
		catch (Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao alterar a aula. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('aula' => $dados_aula);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioaula/alterar/' . $id . URL::query(array()));
		}

		$mensagens = array('sucesso' => $mensagens_sucesso);
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect('audioaula/listar');
	}

	/**
	 * Obtem o objeto da aula que deve ser alterada.
	 * @return Model_Aula
	 */
	private function obter_aula()
	{
		$id = $this->request->param('id');

		$aula = ORM::factory('Aula', $id);
		if ( ! $aula->loaded())
		{
			throw new RuntimeException('Aula invalida');
		}
		if ($aula->id_usuario != Auth::instance()->get_user()->pk())
		{
			//throw new RuntimeException('Aula nao pertence ao usuario logado');
		}
		return $aula;
	}

	/**
	 * Retorna os dados da aula que deve ser alterada, para usar no formulario.
	 * @return array
	 */
	private function obter_dados_aula()
	{
		$aula = $this->obter_aula();
		$dados_aula = array();
		$dados_aula['id_aula']   = $aula->pk();
		$dados_aula['nome']      = $aula->nome;
		$dados_aula['descricao'] = $aula->descricao;
		$dados_aula['rotulos']   = $aula->rotulos;

		return $dados_aula;
	}
}
