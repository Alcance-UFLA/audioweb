<?php
/**
 * Action para exibir informações sobre o funcionamento do AudioWeb.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Informacoes_Funcionamento extends Controller_Geral {

	/**
	 * Action para exibir informações sobre o funcionamento do AudioWeb
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao(false);
		$this->definir_title('Funcionamento do AudioWeb');
		$this->definir_description('Página que apresenta as informações sobre o funcionamento do AudioWeb.');
		$this->definir_robots('index,follow');

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('default'), 'nome' => 'Apresentação', 'icone' => 'bullhorn'),
			array('nome' => 'Funcionamento do AudioWeb', 'icone' => 'cog')
		);

		$this->template->content = View::Factory('informacoes/funcionamento/index', $dados);
	}
}