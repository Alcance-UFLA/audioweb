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
		if (Auth::instance()->logged_in())
		{
			HTTP::redirect('principal');
		}

		$this->requerer_autenticacao(false);
		$this->definir_title('Autenticação do Usuário');
		$this->definir_description('Página para logar usuários no sistema AudioWeb.');
		$this->definir_canonical(URL::site('autenticacao/autenticar'));

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('default'), 'nome' => 'Início'),
			array('nome' => 'Acessar o AudioWeb')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());

		$flash_data = Session::instance()->get_once('flash_data', array());
		$dados['form_autenticacao'] = array();
		$dados['form_autenticacao']['dados'] = isset($flash_data['autenticacao']) ? $flash_data['autenticacao'] : array();

		$this->template->content = View::Factory('autenticacao/autenticar/index', $dados);
	}

	/**
	 * Recebe os dados de autenticação e redireciona para a página principal.
	 * @return void
	 */
	public function action_login()
	{
		$this->requerer_autenticacao(false);
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
			$flash_data = array(
				'autenticacao' => array(
					'email' => $this->request->post('email'),
					'lembrar' => $this->request->post('lembrar') ? '1' : NULL
				)
			);

			$mensagens = array('erro' => 'Usuário ou senha estão incorretos.');
			Session::instance()->set('flash_message', $mensagens);
			Session::instance()->set('flash_data', $flash_data);
			HTTP::redirect('autenticacao/autenticar' . URL::query(array()));
		}

		HTTP::redirect('principal');
	}

}