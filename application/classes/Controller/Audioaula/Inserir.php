<?php
/**
 * Action para usuários cadastrarem aulas no sistema.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Inserir extends Controller_Geral {

	/**
	 * Action para exibir o formulário de cadastro de aulas.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Inserir Aula');

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('nome' => 'Inserir Aula', 'icone' => 'plus')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['form_aula'] = array();
		$dados['form_aula']['dados'] = isset($flash_data['aula']) ? $flash_data['aula'] : array();

		$this->template->content = View::Factory('audioaula/inserir/index', $dados);
	}

	/**
	 * Salvar dados da aula.
	 * @return void
	 */
	public function action_salvar()
	{
		$this->requerer_autenticacao();
		if ($this->request->method() != 'POST')
		{
			HTTP::redirect('audioaula/inserir' . URL::query(array()));
		}

		$dados_aula = array(
			'nome'           => $this->request->post('nome'),
			'descricao'      => $this->request->post('descricao'),
			'rotulos'        => $this->request->post('rotulos')
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

			HTTP::redirect('audioaula/inserir' . URL::query(array()));
		}

		$bd = Database::instance();
		$bd->begin();

		try
		{
			$aula = ORM::Factory('Aula');
			$aula->nome        = $this->request->post('nome');
			$aula->descricao   = $this->request->post('descricao');
			$aula->rotulos     = $this->request->post('rotulos');
			$aula->id_usuario  = Auth::instance()->get_user()->pk();
			$aula->create();

			$bd->commit();
		}
		catch (ORM_Validation_Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('aula' => $dados_aula);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioaula/inserir' . URL::query(array()));
		}
		catch (Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao cadastrar aula. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('aula' => $dados_aula);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('audioaula/inserir' . URL::query(array()));
		}

		$mensagens = array('sucesso' => 'Aula cadastrada com sucesso.');
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect('audioaula/listar');
	}
}