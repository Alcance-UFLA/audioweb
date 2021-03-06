<?php
/**
 * Action para usuários se cadastrarem no sistema.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Informacoes_Politicaprivacidade extends Controller_Geral {

	/**
	 * Action para exibir o texto da Política de Privacidade
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao(false);
		$this->definir_title('Política de Privacidade');
		$this->definir_description('Política de Privacidade do sistema AudioWeb');
		$this->definir_robots('index,follow');
		$this->definir_canonical(Route::url('politica_de_privacidade'));

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('default'), 'nome' => 'Apresentação', 'icone' => 'bullhorn'),
			array('nome' => 'Política de privacidade', 'icone' => 'lock')
		);

		$this->template->content = View::Factory('informacoes/politicaprivacidade/index', $dados);
	}
}