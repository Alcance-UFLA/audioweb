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
		$mensagens = Session::instance()->get_once('flash_message', array());

		$view = View::Factory('usuario/listar/index');
		$view->set('usuarios', $usuarios);
		$view->set('mensagens', $mensagens);
		$this->template->content = $view;
	}

}
