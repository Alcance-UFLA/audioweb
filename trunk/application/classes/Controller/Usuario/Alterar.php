<?php
defined ('SYSPATH') or die ('No direct script access.');

class Controller_Usuario_Alterar extends Controller_Geral {

	/**
	 * Chama a página alterar do usuário
	 * @return void
	 */
	public function action_index()
	{
		$this->definir_title('Alterar Usúario');
		$this->adicionar_meta(array('name' => 'robots', 'content' => 'noindex, nofollow'));

		$id = $this->request->param('id');
		$usuario = ORM::Factory('usuario', $id);
		$view = View::Factory('usuario/alterar');
		$view->set('usuario', $usuario);
		$this->template->content = $view;
	}

	/**
	 * Salvar dados do usuário
	 * @return void
	 */
	public function action_salvar()
	{
		$dados = $this->request->post();
		$usuario = ORM::Factory('usuario', $dados['id']);
	
		$usuario->values($dados);
		$usuario->save();
	
		HTTP::redirect('usuario/index/index');
	}
}
