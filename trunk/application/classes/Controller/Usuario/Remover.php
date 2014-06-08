<?php
/**
 * Action para remover um usuário
 * @author Gustavo Araújo <kustavo@gmail.com>
 */
class Controller_Usuario_Remover extends Controller_Geral {

	public function action_index()
	{
		$id = $this->request->param('id');
		$usuario = ORM::Factory('usuario', $id);
		$usuario->delete();
		HTTP::redirect('usuario/listar');
	}
}
