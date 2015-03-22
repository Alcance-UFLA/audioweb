<?php
/**
 * Action para exibir informações sobre o AudioWeb.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Informacoes_Audioweb extends Controller_Geral {

	/**
	 * Action para exibir informações sobre o AudioWeb
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao(false);
		$this->definir_title('Sobre o AudioWeb');
		$this->definir_description('Página que apresenta as informações básicas sobre o AudioWeb.');
		$this->definir_robots('index,follow');

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('default'), 'nome' => 'Apresentação', 'icone' => 'bullhorn'),
			array('nome' => 'Sobre o AudioWeb', 'icone' => 'info-sign')
		);

		$this->template->content = View::Factory('informacoes/audioweb/index', $dados);
	}
}