<?php
/**
 * Action para apresentacao do sistema
 * @author Gustavo Araújo <kustavo@gmail.com>
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Apresentacao extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao(false);
		$this->definir_title('A Web Audiodescrita');
		$this->definir_description('AudioWeb é um sistema com conteúdos audiodescritos, por uma Web mais acessível para usuários com ou sem deficiência.');
		$this->adicionar_style(URL::site('css/apresentacao/apresentacao.min.css'));
		$this->definir_canonical(Route::url('default'));
		$this->definir_robots('index,follow');

		$this->template->content = View::Factory('apresentacao/index');
	}
}