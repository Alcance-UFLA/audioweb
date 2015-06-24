<?php
/**
 * Action para usuários se cadastrarem no sistema.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Usuario_Cadastrar extends Controller_Geral {

	/**
	 * Action para exibir o formulário de cadastro de usuários.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao(false);
		$this->definir_title('Cadastrar Usuário');
		$this->definir_description('Cadastro de usuários no sistema AudioWeb. Cadastre-se gratuitamente.');
		$this->definir_robots('index,follow');
		$this->definir_canonical(URL::site('usuario/cadastrar'));

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('default'), 'nome' => 'Apresentação', 'icone' => 'bullhorn'),
			array('nome' => 'Cadastrar usuário', 'icone' => 'plus')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());

		$dados['form_usuario'] = array();
		$dados['form_usuario']['dados'] = isset($flash_data['usuario']) ? $flash_data['usuario'] : array();

		$this->template->content = View::Factory('usuario/cadastrar/index', $dados);
	}

	/**
	 * Salvar dados do usuário
	 * @return void
	 */
	public function action_salvar()
	{
		$this->requerer_autenticacao(false);
		if ($this->request->method() != 'POST') {
			HTTP::redirect('usuario/cadastrar' . URL::query(array()));
		}

		$dados_usuario = array(
			'nome' => $this->request->post('nome'),
			'email' => $this->request->post('email'),
			'concordar' => $this->request->post('concordar')
		);

		$rules = ORM::Factory('Usuario')->rules();
		$post = Validation::factory($this->request->post())
			->rules('nome', $rules['nome'])
			->rules('email', $rules['email'])
			->rules('senha', $rules['senha'])
			->rule('concordar', 'not_empty');

		if ( ! $post->check()) {
			$mensagens = array('atencao' => $post->errors('models/usuario'));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('usuario' => $dados_usuario);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('usuario/cadastrar' . URL::query(array()));
		}

		$bd = Database::instance();
		$bd->begin();

		try {
			// Obter licenca publica
			$licenca = ORM::Factory('Licenca', 2);

			$conta = ORM::Factory('Conta');
			$conta->licenca = $licenca;
			$conta->create();

			$usuario = ORM::Factory('Usuario');
			$usuario->nome  = $this->request->post('nome');
			$usuario->email = $this->request->post('email');
			$usuario->senha = $this->request->post('senha');
			$usuario->conta = $conta;
			$usuario->create();

			Auth::instance()->force_login($usuario, TRUE);

			$bd->commit();

		} catch (ORM_Validation_Exception $e) {
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('usuario' => $dados_usuario);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('usuario/cadastrar' . URL::query(array()));
		} catch (Exception $e) {
			$bd->rollback();

			$mensagens = array('erro' => 'Erro inesperado ao cadastrar usuário. Por favor, tente novamente mais tarde.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('usuario' => $dados_usuario);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('usuario/cadastrar' . URL::query(array()));
		}

		$mensagens = array('sucesso' => 'Usuário cadastrado com sucesso.');
		Session::instance()->set('flash_message', $mensagens);

		HTTP::redirect('principal');
	}
}