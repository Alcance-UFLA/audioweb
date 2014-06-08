<?php
/**
 * Action para listar usuários
 * @author Gustavo Araújo <kustavo@gmail.com>
 */
class Controller_Usuario_Listar extends Controller_Geral {

	public function action_index()
	{
		$this->definir_title('Lista de Usuários');

		$usuarios = ORM::Factory('usuario')->find_all();
		$view = View::Factory('usuario/listar/index');
		$view->set('usuarios', $usuarios);
		$this->template->content = $view;
	}

}
