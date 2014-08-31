<?php
/**
 * Action para realizar autenticação do usuário
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Autenticacao_Autenticar extends Controller_Geral {

	/**
	 * Exibe o formulário de autenticação.
	 * @return void
	 */
	public function action_index()
	{
		$this->definir_title('Autenticação do Usuário');
		$this->definir_description('Página para logar usuários no sistema AudioWeb.');
		$this->definir_canonical(URL::site('autenticacao/autenticar'));

		$dados = array();
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());
		$dados['form_autenticacao'] = $this->request->query('form_autenticacao');

		$this->template->content = View::Factory('autenticacao/autenticar/index', $dados);
	}

	/**
	 * Recebe os dados de autenticação e redireciona para a página principal.
	 * @return void
	 */
	public function action_login()
	{
		if ($this->request->method() != 'POST')
		{
			HTTP::redirect('autenticacao/autenticar' . URL::query(array()));
		}

		$usuario = Auth::instance()->login(
			$this->request->post('email'),
			$this->request->post('senha'),
			(bool)$this->request->post('lembrar')
		);

		if ( ! $usuario)
		{
			$form_autenticacao = array(
				'email' => $this->request->post('email'),
				'lembrar' => $this->request->post('lembrar') ? '1' : NULL
			);

			$mensagens = array('erro' => 'Usuário ou senha estão incorretos.');
			Session::instance()->set('flash_message', $mensagens);
			HTTP::redirect('autenticacao/autenticar' . URL::query(array('form_autenticacao' => $form_autenticacao)));
		}

		HTTP::redirect('principal');
	}

}