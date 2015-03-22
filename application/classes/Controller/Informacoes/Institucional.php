<?php
/**
 * Action para exibir informações institucionais sobre o AudioWeb.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Informacoes_Institucional extends Controller_Geral {

	/**
	 * Action para exibir o texto Institucional
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao(false);
		$this->definir_title('Institucional');
		$this->definir_description('Página que apresenta as informações sobre os desenvolvedores e parceiros do AudioWeb.');
		$this->definir_robots('index,follow');

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('default'), 'nome' => 'Apresentação', 'icone' => 'bullhorn'),
			array('nome' => 'Institucional', 'icone' => 'globe')
		);

		$this->template->content = View::Factory('informacoes/institucional/index', $dados);
	}
}