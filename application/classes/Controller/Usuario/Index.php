<?php
defined ('SYSPATH') or die ('No direct script access.');

class Controller_Usuario_Index extends Controller_Geral {

	/**
	 * Chama a página inicial do usuário
	 * @return void
	 */
	public function action_index()
	{
		$this->definir_title('Lista de Usuários');
		$this->adicionar_meta(array('name' => 'robots', 'content' => 'noindex, nofollow'));

		$usuarios = ORM::Factory('usuario')->find_all();
		$view = View::Factory('usuario/index');
		$view->set('usuarios', $usuarios);
		$this->template->content = $view;
	}

}
