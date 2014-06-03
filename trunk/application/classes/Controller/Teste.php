<?php
/**
 * Controller de teste
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Teste extends Controller_Geral {

	/**
	 * Teste
	 * @return void
	 */
	public function action_testar()
	{
		$this->definir_title('Teste Inicial');
		$this->adicionar_meta(array(
			'name'    => 'robots',
			'content' => 'index,follow'
		));

		$view = View::Factory('teste/testar');
		$this->template->content = $view;
	}
}