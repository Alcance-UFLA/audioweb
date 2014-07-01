<?php
/**
 * Action para realizar autenticação do usuário
* @author Gustavo Araújo <kustavo@gmail.com>
*/
class Controller_Autenticacao_Autenticar extends Controller_Geral {

	private $mensagens;

	public function action_index()
	{
		$this->mensagens = array();
		$this->exibir_form();
	}

	private function exibir_form()
	{
		$this->definir_title('Autenticação do Usuário');

		$view = View::Factory('autenticacao/autenticar/index');
		$view->set('mensagens', $this->mensagens);
		$this->template->content = $view;
	}

	public function action_login()
	{

		$dados = $this->request->post();

		$lembrar = array_key_exists('lembrar', $dados) ? (bool) $this->request->post('lembrar') : FALSE;
		$usuario = Auth::instance()->login($dados['email'], $dados['senha'], $lembrar);

		if ($usuario)
		{
			HTTP::redirect('principal');
		}
		else
		{
			$this->mensagens['erro'] = 'Usuário ou senha estão incorretos';
			$this->exibir_form();
		}

	}

	public function action_logout()
	{

		Auth::instance()->logout();
		HTTP::redirect('apresentacao');
	}


}