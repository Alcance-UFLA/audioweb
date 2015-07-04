<?php
/**
 * Action para remover uma imagem de uma secao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Secoes_Imagens_Remover extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao();

		$imagem_secao = $this->obter_imagem_secao();

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('url' => Route::url('listar_secoes', array('id_aula' => $imagem_secao->secao->aula->id_aula)), 'nome' => 'Preparar aula', 'icone' => 'list-alt'),
			array('nome' => 'Remover Imagem de Seção', 'icone' => 'trash')
		);
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());

		$dados['imagem_secao'] = $imagem_secao->as_array();
		$dados['imagem_secao']['imagem'] = $imagem_secao->imagem->as_array();
		$dados['imagem_secao']['imagem']['id_conta'] = $imagem_secao->imagem->usuario->id_conta;
		$dados['imagem_secao']['secao'] = $imagem_secao->secao->as_array();
		$dados['imagem_secao']['secao']['aula'] = $imagem_secao->secao->aula->as_array();

		$this->template->content = View::Factory('audioaula/secoes/imagens/remover/index', $dados);
	}

	public function action_salvar()
	{
		$this->requerer_autenticacao();

		$imagem_secao = $this->obter_imagem_secao();
		$secao = $imagem_secao->secao;
		$aula = $secao->aula;

		$bd = Database::instance();
		$bd->begin();
		try {
			$imagem_secao->delete();
			$secao->atualizar_posicoes_itens();
			$bd->commit();
		} catch (Exception $e) {
			$bd->rollback();
			$this->mensagens['erro'][] = 'Erro inesperado ao remover imagem da seção. Por favor, tente novamente mais tarde.';
			Session::instance()->set('flash_message', $this->mensagens);
			HTTP::redirect(Route::url('remover_imagem_secao', array('id_aula' => $aula->pk(), 'id_secao' => $secao->pk(), 'id_imagem_secao' => $imagem_secao->pk())));
		}

		$this->mensagens['sucesso'][] = 'Imagem removida da seção com sucesso.';
		Session::instance()->set('flash_message', $this->mensagens);
		HTTP::redirect(Route::url('listar_secoes', array('id_aula' => $aula->pk())));
	}

	/**
	 * Obtem o objeto da imagem de secao que deve ser removida.
	 * @return Model_Secao_Imagem
	 */
	private function obter_imagem_secao()
	{
		$id = $this->request->param('id_secao_imagem');

		$imagem_secao = ORM::factory('Secao_Imagem', $id);
		if ( ! $imagem_secao->loaded()) {
			throw new RuntimeException('Imagem da Seção inválida');
		}
		if ($imagem_secao->id_secao != $this->request->param('id_secao')) {
			throw new RuntimeException('Imagem nao pertence à seção informada.');
		}
		if ($imagem_secao->secao->id_aula != $this->request->param('id_aula')) {
			throw new RuntimeException('Seção nao pertence à aula informada.');
		}
		/*
		if ($imagem_secao->secao->aula->id_usuario != Auth::instance()->get_user()->pk()) {
			throw new RuntimeException('Aula nao pertence ao usuario logado');
		}
		*/
		return $imagem_secao;
	}

	private function obter_imagens()
	{
		$imagens = ORM::factory('Imagem')
			->cached(20)
			//->where('id_usuario', '=', Auth::instance()->get_usar()->pk())
			->find_all()
			->as_array();

		$lista = array();
		foreach ($imagens as $imagem) {
			$lista[] = array(
				'id_imagem' => $imagem->pk(),
				'nome'      => $imagem->nome,
				'arquivo'   => $imagem->arquivo,
				'id_conta'  => $imagem->usuario->id_conta,
				'altura'    => $imagem->altura,
				'largura'   => $imagem->largura
			);
		}
		return $lista;
	}
}
