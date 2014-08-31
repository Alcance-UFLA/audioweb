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
		$this->definir_title('Cadastrar Usuário');
		$this->definir_description('Cadastro de usuários no sistema AudioWeb. Cadastre-se gratuitamente.');
		$this->definir_robots('index,follow');
		$this->definir_canonical(URL::site('usuario/cadastrar'));

		$dados = array();
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$flash_data = Session::instance()->get_once('flash_data', array());
		$dados['form_usuario'] = isset($flash_data['usuario']) ? $flash_data['usuario'] : array();

		$this->template->content = View::Factory('usuario/cadastrar/index', $dados);
	}

	/**
	 * Salvar dados do usuário
	 * @return void
	 */
	public function action_salvar()
	{
		if ($this->request->method() != 'POST')
		{
			HTTP::redirect('usuario/cadastrar' . URL::query(array()));
		}

		$dados_usuario = array(
			'nome' => $this->request->post('nome'),
			'email' => $this->request->post('email'),
			'concordar' => $this->request->post('concordar')
		);

		if ( ! $this->request->post('concordar'))
		{
			$mensagens = array('atencao' => 'Para se cadastrar no sistema, você precisa concordar com a Política de Privacidade do AudioWeb.');
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('usuario' => $dados_usuario);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('usuario/cadastrar' . URL::query(array()));
		}

		$bd = Database::instance();
		$bd->begin();

		try
		{
			// Obter licenca publica
			$licenca = ORM::Factory('Licenca', 2);

			$conta = ORM::Factory('Conta');
			$conta->id_licenca = $licenca->pk();
			$conta->create();

			$usuario = ORM::Factory('Usuario');
			$usuario->nome = $this->request->post('nome');
			$usuario->email = $this->request->post('email');
			$usuario->senha = Auth::instance()->hash($this->request->post('senha'));
			$usuario->id_conta = $conta->pk();
			$usuario->create();

			$bd->commit();

		}
		catch (ORM_Validation_Exception $e)
		{
			$bd->rollback();

			$mensagens = array('erro' => $e->errors('models', TRUE));
			Session::instance()->set('flash_message', $mensagens);
			$flash_data = array('usuario' => $dados_usuario);
			Session::instance()->set('flash_data', $flash_data);

			HTTP::redirect('usuario/cadastrar' . URL::query(array()));
		}

		$mensagens = array('sucesso' => 'Usuário cadastrado com sucesso.');
		Session::instance()->set('flash_message', $mensagens);

		Auth::instance()->force_login($usuario, TRUE);

		HTTP::redirect('principal');
	}
}