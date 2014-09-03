<?php
/**
 * Action para tela principal do sistema
 * @author Gustavo Araújo <kustavo@gmail.com>
 */
class Controller_Principal extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->adicionar_style(URL::site('css/principal/principal.min.css'));

		$this->template->content = View::Factory('principal/index');
	}
}