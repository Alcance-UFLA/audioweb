<?php
/**
 * Action para alterar dados de um usuário
 * @author Gustavo Araújo <kustavo@gmail.com>
 */
class Controller_Usuario_Alterar extends Controller_Geral {

	public function action_index()
	{
		$this->definir_title('Alterar Usuário');

		$id = $this->request->param('id');
		$usuario = ORM::Factory('usuario', $id);
		$view = View::Factory('usuario/alterar/index');
		$view->set('usuario', $usuario);
		$this->template->content = $view;
	}

	/**
	 * Salvar dados do usuário
	 * @return void
	 */
	public function action_salvar()
	{
		$id = $this->request->param('id');
		$dados = $this->request->post();

		$usuario = ORM::Factory('usuario', $id);
		$usuario->values($dados);
		$usuario->save();

		HTTP::redirect('usuario/listar');
	}
}
