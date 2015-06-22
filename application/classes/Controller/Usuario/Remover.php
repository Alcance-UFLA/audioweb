<?php
/**
 * Action para remover um usuário
 * @author Gustavo Araújo <kustavo@gmail.com>
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Usuario_Remover extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao();
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
		$this->definir_title('Remover Usuário');

		$view = View::Factory('usuario/remover/index');
		$view->set('usuario', $this->usuario);
		$view->set('mensagens', $this->mensagens);
		$this->template->content = $view;
	}

	public function action_salvar()
	{
		$id = $this->request->param('id');
		$this->usuario = ORM::Factory('Usuario', $id);
		$this->mensagens = array();

		if ( ! $this->usuario->loaded())
		{
			throw HTTP_Exception::factory(404, 'Usuário não encontrado');
		}

		try
		{
			$this->usuario->delete();
			$this->mensagens['sucesso'][] = 'Usuário removido com sucesso.';
			Session::instance()->set('flash_message', $this->mensagens);
		}
		catch (Exception $e)
		{
			$this->mensagens['erros'][] = 'Erro ao remover usuario';
			Session::instance()->set('flash_message', $this->mensagens);
		}
		HTTP::redirect('usuario/listar');
	}
}
