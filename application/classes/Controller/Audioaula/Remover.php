<?php
/**
 * Action para remover uma aula
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Remover extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao();

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('nome' => 'Remover Aula', 'icone' => 'trash')
		);
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());

		$aula = $this->obter_aula();
		$dados['aula'] = $aula->as_array();

		$this->template->content = View::Factory('audioaula/remover/index', $dados);
	}

	public function action_salvar()
	{
		$this->requerer_autenticacao();

		$aula = $this->obter_aula();

		$bd = Database::instance();
		$bd->begin();
		try {
			$aula->delete();
			$bd->commit();
		} catch (Exception $e) {
			$bd->rollback();
			$this->mensagens['erro'][] = 'Erro inesperado ao remover aula. Por favor, tente novamente mais tarde.';
			Session::instance()->set('flash_message', $this->mensagens);
			HTTP::redirect(Route::url('acao_id', array('directory' => 'audioaula', 'controller' => 'remover', 'id' => $aula->pk())));
		}

		$this->mensagens['sucesso'][] = 'Aula removida com sucesso.';
		Session::instance()->set('flash_message', $this->mensagens);
		HTTP::redirect(Route::url('listar', array('directory' => 'audioaula')));
	}

	/**
	 * Obtem o objeto da aula que deve ser removida.
	 * @return Model_Aula
	 */
	private function obter_aula()
	{
		$id = $this->request->param('id');

		$aula = ORM::factory('Aula', $id);
		if ( ! $aula->loaded()) {
			throw new RuntimeException('Aula invalida');
		}
		/*
		if ($aula->id_usuario != Auth::instance()->get_user()->pk()) {
			throw new RuntimeException('Aula nao pertence ao usuario logado');
		}
		*/
		return $aula;
	}
}
