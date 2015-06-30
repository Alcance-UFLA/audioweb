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
		if (Auth::instance()->logged_in()) {
			HTTP::redirect('principal');
		}

		$this->requerer_autenticacao(false);
		$this->definir_title('Autenticação do Usuário');
		$this->definir_description('Página para logar usuários no sistema AudioWeb.');
		$this->definir_canonical(URL::site('autenticacao/autenticar', 'https'));

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('default'), 'nome' => 'Apresentação', 'icone' => 'bullhorn'),
			array('nome' => 'Acessar o AudioWeb', 'icone' => 'log-in')
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
		if ($this->request->method() != 'POST') {
			HTTP::redirect('autenticacao/autenticar' . URL::query(array()));
		}

		$usuario = Auth::instance()->login(
			$this->request->post('email'),
			$this->request->post('senha'),
			(bool)$this->request->post('lembrar')
		);

		if ( ! $usuario) {
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

	/**
	 * Realiza a autenticação especial de um usuário, através de um hash
	 * @return void
	 */
	public function action_especial()
	{
		$this->requerer_autenticacao(false);

		// Obter acesso especial no banco, pelo hash e valida-lo
		$acesso = ORM::factory('Acesso_Especial')
			->where('hash', '=', $this->request->param('opcao1'))
			->find();

		if ( ! $acesso->loaded() || ! $acesso->usuario->loaded()) {
			throw HTTP_Exception::factory(404, 'Acesso inválido (chave inválida).');
		}
		if (strtotime($acesso->validade) < $_SERVER['REQUEST_TIME']) {
			$acesso->delete();
			throw HTTP_Exception::factory(404, 'Acesso inválido (validade expirada).');
		}

		// Autenticar
		$usuario = $acesso->usuario;
		$acesso->delete();
		Auth::instance()->force_login($usuario, TRUE);

		// Redirecionar para pagina de definir nova senha
		HTTP::redirect(Route::url('acao_padrao', array('directory' => 'preferencias', 'controller' => 'alterar')) . '#aba-senha');
	}

}
