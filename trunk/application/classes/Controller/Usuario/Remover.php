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
		$mensagens = array();

		if ( ! $usuario->loaded())
		{
			throw HTTP_Exception::factory(404, 'Usuário não encontrado');
		}

		try
		{
			$usuario->delete();
			$mensagens['sucesso'][] = 'Usuário removido com sucesso.';
			Session::instance()->set('flash_message', $mensagens);
		}
		catch (Exception $e)
		{
			$mensagens['erros'][] = 'Erro ao remover usuario';
			Session::instance()->set('flash_message', $mensagens);
		}
		HTTP::redirect('usuario/listar');
	}
}
