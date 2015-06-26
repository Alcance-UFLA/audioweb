<?php
/**
 * Action para remover um texto de uma secao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Secoes_Textos_Remover extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao();

		$aula = $this->obter_aula();
		$secao = $this->obter_secao();
		$texto_secao = $this->obter_texto_secao();

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('url' => Route::url('listar_secoes', array('id_aula' => $aula->id_aula)), 'nome' => 'Preparar aula', 'icone' => 'list-alt'),
			array('nome' => 'Remover Texto de Seção', 'icone' => 'trash')
		);
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());

		$dados['aula'] = $aula->as_array();
		$dados['secao'] = $secao->as_array();
		$dados['texto_secao'] = $texto_secao->as_array();

		$this->template->content = View::Factory('audioaula/secoes/textos/remover/index', $dados);
	}

	public function action_salvar()
	{
		$this->requerer_autenticacao();

		$aula = $this->obter_aula();
		$secao = $this->obter_secao();
		$texto_secao = $this->obter_texto_secao();

		$bd = Database::instance();
		$bd->begin();
		try {
			$texto_secao->delete();
			$secao->atualizar_posicoes_itens();
			$bd->commit();
		} catch (Exception $e) {
			$bd->rollback();
			$this->mensagens['erro'][] = 'Erro inesperado ao remover texto da seção. Por favor, tente novamente mais tarde.';
			Session::instance()->set('flash_message', $this->mensagens);
			HTTP::redirect(Route::url('remover_texto_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk(), 'id_texto_secao' => $texto_secao->pk())));
		}

		$this->mensagens['sucesso'][] = 'Texto removido da seção com sucesso.';
		Session::instance()->set('flash_message', $this->mensagens);
		HTTP::redirect(Route::url('listar_secoes', array('id_aula' => $aula->pk())));
	}

	/**
	 * Obtem o objeto da aula
	 * @return Model_Aula
	 */
	private function obter_aula()
	{
		$id = $this->request->param('id_aula');

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

	/**
	 * Obtem o objeto da secao da aula
	 * @return Model_Secao
	 */
	private function obter_secao()
	{
		$id = $this->request->param('id_secao');

		$secao = ORM::factory('Secao', $id);
		if ( ! $secao->loaded()) {
			throw new RuntimeException('Seção inválida');
		}
		if ($secao->id_aula != $this->obter_aula()->pk()) {
			throw new RuntimeException('Seção nao pertence à aula informada.');
		}
		return $secao;
	}

	/**
	 * Obtem o objeto do texto da secao que deve ser removido.
	 * @return Model_Secao_Texto
	 */
	private function obter_texto_secao()
	{
		$id = $this->request->param('id_secao_texto');

		$texto_secao = ORM::factory('Secao_Texto', $id);
		if ( ! $texto_secao->loaded()) {
			throw new RuntimeException('Texto da Seção inválida');
		}
		if ($texto_secao->id_secao != $this->obter_secao()->pk()) {
			throw new RuntimeException('Texto nao pertence à seção informada.');
		}
		return $texto_secao;
	}
}
