<?php
/**
 * Action para listar usuários
 * @author Gustavo Araújo <kustavo@gmail.com>
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Usuario_Listar extends Controller_Geral {

	public function action_index()
	{
		$this->definir_title('Lista de Usuários');
		$this->adicionar_script(array('src' => URL::site('js/usuario/listar.js')));

		$usuarios = ORM::Factory('Usuario')->find_all();
		$mensagens = Session::instance()->get_once('flash_message', array());

		$view = View::Factory('usuario/listar/index');
		$view->set('usuarios', $usuarios);
		$view->set('mensagens', $mensagens);
		$this->template->content = $view;
	}

}
