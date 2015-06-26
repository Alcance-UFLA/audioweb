<?php
/**
 * Action para remover uma secao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Secoes_Remover extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao();

		$secao = $this->obter_secao();

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('url' => Route::url('listar_secoes', array('id_aula' => $secao->aula->id_aula)), 'nome' => 'Preparar aula', 'icone' => 'list-alt'),
			array('nome' => 'Remover Seção', 'icone' => 'trash')
		);
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());

		$dados['secao'] = $secao->as_array();
		$dados['secao']['aula'] = $secao->aula->as_array();

		$this->template->content = View::Factory('audioaula/secoes/remover/index', $dados);
	}

	public function action_salvar()
	{
		$this->requerer_autenticacao();

		$secao = $this->obter_secao();
		$aula = $secao->aula;

		$bd = Database::instance();
		$bd->begin();
		try {
			$secao->delete_cascade();
			$aula->atualizar_posicoes_secoes();
			$bd->commit();
		} catch (Exception $e) {
			$bd->rollback();
			$this->mensagens['erro'][] = 'Erro inesperado ao remover seção. Por favor, tente novamente mais tarde.';
			Session::instance()->set('flash_message', $this->mensagens);
			HTTP::redirect(Route::url('remover_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk())));
		}

		$this->mensagens['sucesso'][] = 'Seção removida com sucesso.';
		Session::instance()->set('flash_message', $this->mensagens);
		HTTP::redirect(Route::url('listar_secoes', array('id_aula' => $aula->pk())));
	}

	/**
	 * Obtem o objeto da secao que deve ser removida.
	 * @return Model_Secao
	 */
	private function obter_secao()
	{
		$id = $this->request->param('id_secao');

		$secao = ORM::factory('Secao', $id);
		if ( ! $secao->loaded()) {
			throw new RuntimeException('Seção inválida');
		}
		if ($secao->id_aula != $this->request->param('id_aula')) {
			throw new RuntimeException('Seção nao pertence à aula informada.');
		}
		/*
		if ($secao->aula->id_usuario != Auth::instance()->get_user()->pk()) {
			throw new RuntimeException('Aula nao pertence ao usuario logado');
		}
		*/
		return $secao;
	}
}
