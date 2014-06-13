<?php
/**
 * Action para verificar a autenticação do usuário
 * @author Gustavo Araújo <kustavo@gmail.com>
 */
class Controller_Autenticacao_Verificar extends Controller_Geral {
	
	public function action_index()
	{
		// carregar dados do User
		$usuario = Auth::instance()->get_user();
	
		// se o usuário não está logado, redirecionar para tela de autenticação
		if (!$usuario )
		{
			HTTP::redirect('autenticacao/login');
		}
	}
}