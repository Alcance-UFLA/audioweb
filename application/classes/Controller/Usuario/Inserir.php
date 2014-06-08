<?php
/**
 * Action para inserir usuários
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Usuario_Inserir extends Controller_Geral {

	public function action_index()
	{
		$this->definir_title('Adicionar Usuário');

		$view = View::Factory('usuario/inserir/index');
		$this->template->content = $view;
	}

	/**
	 * Salvar dados do usuário
	 * @return void
	 */
	public function action_salvar()
	{
		$dados = $this->request->post();
		$usuario = ORM::Factory('usuario');

		$usuario->values($dados);
		$usuario->save();

		HTTP::redirect('usuario/listar');
	}
}