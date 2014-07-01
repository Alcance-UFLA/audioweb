<?php
/**
 * Action para tela principal do sistema
 * @author Gustavo Araújo <kustavo@gmail.com>
 */
class Controller_Principal extends Controller_Geral {

	public function action_index()
	{
		
		$usuario = Auth::instance()->get_user();
		if (!$usuario )
		{
			HTTP::redirect('apresentacao');
		}
		
		$this->adicionar_style(array('href' => URL::site('css/principal/principal.css')));

		$view = View::Factory('principal/index');
		$this->template->content = $view;
	}
}