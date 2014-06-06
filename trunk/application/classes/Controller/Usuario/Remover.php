<?php
defined ('SYSPATH') or die ('No direct script access.');

class Controller_Usuario_Remover extends Controller_Geral {

	/**
	 * Chama a página remover do usuário
	 * @return void
	 */
	public function action_index()
	{
		$id = $this->request->param('id');
		ORM::Factory('usuario', $id)->delete();
		HTTP::redirect('usuario/index');
	}
}
