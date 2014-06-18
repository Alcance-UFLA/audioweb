<?php
/**
 * Action para inserir usuários
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Usuario_Inserir extends Controller_Geral {

	private $usuario;
	private $mensagens;

	public function action_index()
	{
		$this->usuario = ORM::Factory('Usuario');
		$this->mensagens = array();
		$this->exibir_form();
	}

	private function exibir_form()
	{
		$this->definir_title('Adicionar Usuário');

		$view = View::Factory('usuario/inserir/index');
		$view->set('usuario', $this->usuario);
		$view->set('mensagens', $this->mensagens);
		$this->template->content = $view;
	}

	/**
	 * Salvar dados do usuário
	 * @return void
	 */
	public function action_salvar()
	{
		$this->usuario = ORM::Factory('Usuario');
		$this->mensagens = array();

		$dados = $this->request->post();

		try
		{
			$this->usuario->nome = $dados['nome'];
			$this->usuario->email = $dados['email'];
			$this->usuario->senha = Auth::instance()->hash($dados['senha']);
			$this->usuario->perfil = 'P';
			$this->usuario->create();

			$this->mensagens['sucesso'][] = 'Usuário cadastrado com sucesso.';
			Session::instance()->set('flash_message', $this->mensagens);

			HTTP::redirect('usuario/listar');
		}
		catch (ORM_Validation_Exception $e)
		{
			$this->mensagens['erro'] = $e->errors('models', TRUE);
			$this->exibir_form();
		}
	}
}