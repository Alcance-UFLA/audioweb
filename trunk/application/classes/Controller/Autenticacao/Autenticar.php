<?php
/**
 * Action para realizar autenticação do usuário
 * @author Gustavo Araújo <kustavo@gmail.com>
 */
class Controller_Autenticacao_Autenticar extends Controller_Geral {

	public function action_index()
	{
		$this->definir_title('Autenticação do Usuário');
		$this->definir_description('Página para logar usuários no sistema AudioWeb.');
		$this->definir_canonical(URL::site('autenticacao/autenticar'));

		$mensagens = Session::instance()->get_once('flash_message', array());

		$this->template->content = View::Factory('autenticacao/autenticar/index');
		$this->template->content->set('mensagens', $mensagens);
	}

	public function action_login()
	{
		if ($this->request->method() != 'POST')
		{
			HTTP::redirect('autenticacao/autenticar' . HTTP::query(array()));
		}

		$usuario = Auth::instance()->login(
			$this->request->post('email'),
			$this->request->post('senha'),
			(bool)$this->request->post('lembrar')
		);

		if ( ! $usuario)
		{
			$mensagens = array('erro' => 'Usuário ou senha estão incorretos.');
			Session::instance()->set('flash_message', $mensagens);
			HTTP::redirect('autenticacao/autenticar');
		}

		HTTP::redirect('principal');
	}

}