<?php
/**
 * Action para deslogar o usuário.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Autenticacao_Sair extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao(false);
		Auth::instance()->logout(TRUE, TRUE);
		HTTP::redirect('');
	}
}