<?php
/**
 * Action para alterar dados de um usuário
 * @author Gustavo Araújo <kustavo@gmail.com>
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Usuario_Alterar extends Controller_Geral {

	private $usuario;
	private $mensagens;

	public function action_index()
	{
		$id = $this->request->param('id');
		$this->usuario = ORM::Factory('Usuario', $id);
		$this->mensagens = array();

		if ( ! $this->usuario->loaded())
		{
			throw HTTP_Exception::factory(404, 'Usuário não encontrado');
		}

		$this->exibir_form();
	}

	private function exibir_form()
	{
		$this->definir_title('Alterar Usuário');

		$view = View::Factory('usuario/alterar/index');
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
		$id = $this->request->param('id');
		$this->usuario = ORM::Factory('Usuario', $id);
		$this->mensagens = array();

		if ( ! $this->usuario->loaded())
		{
			throw HTTP_Exception::factory(404, 'Usuário não encontrado');
		}

		$dados = $this->request->post();

		try
		{
			$this->usuario->values($dados, array('nome', 'email'));
			$this->usuario->save();

			$this->mensagens['sucesso'][] = 'Usuário alterado com sucesso.';
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
