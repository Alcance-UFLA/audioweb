<?php
/**
 * Action para listar as sessoes de uma aula
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Secoes_Listar extends Controller_Geral {

	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Preparar Aula');

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('url' => Route::url('listar', array('directory' => 'audioaula')), 'nome' => 'AudioAula', 'icone' => 'education'),
			array('nome' => 'Preparar Aula', 'icone' => 'list-alt')
		);
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());

		$aula = $this->obter_aula();

		$lista_secoes = $this->obter_lista_secoes($aula->id_aula);

		$dados['aula'] = $aula->as_array();
		$dados['secoes'] = array(
			'lista' => $lista_secoes
		);

		$this->template->content = View::Factory('audioaula/secoes/listar/index', $dados);
	}

	/**
	 * Obtem a lista de secoes de uma aula
	 * @param int $id_aula
	 * @return array
	 */
	private function obter_lista_secoes($id_aula)
	{
		$secoes = ORM::Factory('Secao')
			->where('id_aula', '=', $id_aula)
			->order_by('posicao');

		$lista_secoes = array();
		$lista = $secoes->find_all();

		$numero = array(
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0
		);
		$ultima_secao = null;
		foreach ($lista as $secao)
		{
			if ($ultima_secao && $ultima_secao->nivel > $secao->nivel)
			{
				for ($i = $secao->nivel + 1; $i <= 6; $i++)
				{
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

			$lista_secoes[] = $dados_secao;

			$ultima_secao = $secao;
		}
		return $lista_secoes;
	}

	private function obter_itens_secao($secao)
	{
		$itens = array();
		$textos = ORM::Factory('Secao_Texto')
			->where('id_secao', '=', $secao->pk())
			->order_by('posicao')
			->find_all();
		$imagens = ORM::Factory('Secao_Imagem')
			->where('id_secao', '=', $secao->pk())
			->order_by('posicao')
			->find_all();
		$formulas = ORM::Factory('Secao_Formula')
			->where('id_secao', '=', $secao->pk())
			->order_by('posicao')
			->find_all();
		foreach ($textos as $texto) {
			$itens[$texto->posicao] = array_merge(
				$texto->as_array(),
				array('tipo' => 'texto')
			);
		}
		foreach ($imagens as $imagem) {
			$itens[$imagem->posicao] = array_merge(
				$imagem->as_array(),
				array('tipo' => 'imagem')
			);
		}
		foreach ($formulas as $formula) {
			$itens[$formula->posicao] = array_merge(
				$formula->as_array(),
				array('tipo' => 'formula')
			);
		}
		return $itens;
	}

	private function obter_aula()
	{
		$aula = ORM::Factory('Aula', array('id_aula' => $this->request->param('id_aula')));
		if ( ! $aula->loaded())
		{
			throw HTTP_Exception::factory(404, 'Aula inválida');
		}
		/*
		if ($aula->id_usuario != Auth::instance()->get_user()->pk())
		{
			throw HTTP_Exception::factory(404, 'Usuário sem permissão de acesso');
		}
		*/
		return $aula;
	}
}
