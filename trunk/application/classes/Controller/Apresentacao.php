<?php
/**
 * Action para apresentacao do sistema
 * @author Gustavo Araújo <kustavo@gmail.com>
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Apresentacao extends Controller_Geral {

	public function action_index()
	{
		$this->adicionar_style(array('href' => URL::site('css/apresentacao/apresentacao.css')));

		$view = View::Factory('apresentacao/index');
		$this->template->content = $view;
	}
}