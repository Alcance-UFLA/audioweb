<?php
/**
 * Action para exibir uma aula
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Exibir extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Exibir Aula');

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('nome' => 'Exibir Aula', 'icone' => 'eye-open')
		);
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());

		$dados['aula'] = $this->obter_dados_aula();

		$this->template->content = View::Factory('audioaula/exibir/index', $dados);
	}

	/**
	 * Obtem os dados de uma aula
	 * @return array
	 */
	private function obter_dados_aula()
	{
		$aula = ORM::Factory('Aula', array('id_aula' => $this->request->param('id')));
		if ( ! $aula->loaded()) {
			throw HTTP_Exception::factory(404, 'Aula inválida');
		}
		/*
		if ($aula->id_usuario != Auth::instance()->get_user()->pk()) {
			throw HTTP_Exception::factory(404, 'Usuário sem permissão de acesso');
		}
		*/

		$dados_aula = $aula->as_array();

		$secoes = ORM::Factory('Secao')
			->where('id_aula', '=', $aula->pk())
			->order_by('posicao')
			->find_all();

		$dados_aula['secoes'] = array();

		$numero = array(
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0
		);
		$ultima_secao = null;
		foreach ($secoes as $secao) {
			if ($ultima_secao && $ultima_secao->nivel > $secao->nivel) {
				for ($i = $secao->nivel + 1; $i <= 6; $i++) {
					$numero[$i] = 0;
				}
			}

			$numero[$secao->nivel] += 1;

			$dados_secao = $secao->as_array();
			$dados_secao['numero'] = implode(
				'.',
				array_slice($numero, 0, $secao->nivel)
			) . '.';
			$dados_secao['itens'] = $this->obter_itens_secao($secao);

			$dados_aula['secoes'][] = $dados_secao;

			$ultima_secao = $secao;
		}

		return $dados_aula;
	}

	private function obter_itens_secao($secao)
	{
		$itens = $secao->obter_itens();

		$dados_itens = array();
		foreach ($itens as $item) {
			switch (get_class($item)) {
			case 'Model_Secao_Texto':
				$dados_item = $item->as_array();
				$dados_item['tipo'] = get_class($item);
				$dados_itens[$item->posicao] = $dados_item;
				break;
			case 'Model_Secao_Imagem':
				$dados_item = $item->as_array();
				$dados_item['imagem'] = $item->imagem->as_array();
				$dados_item['imagem']['id_conta'] = $item->imagem->usuario->id_conta;
				$dados_item['tipo'] = get_class($item);
				$dados_itens[$item->posicao] = $dados_item;
				break;
			case 'Model_Secao_Formula':
				$dados_item = $item->as_array();
				$dados_item['tipo'] = get_class($item);
				$dados_itens[$item->posicao] = $dados_item;
				break;
			}
		}

		return $dados_itens;
	}

}
