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
		$this->adicionar_style(URL::cdn('css/jquery-ui/jquery-ui.min.css'));
		$this->adicionar_script(URL::cdn('js/jquery-ui/jquery-ui.min.js'));
		$this->adicionar_script(URL::cdn('js/audioaula/secoes/listar.min.js'));

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
		foreach ($lista as $secao) {
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
		if ( ! $aula->loaded()) {
			throw HTTP_Exception::factory(404, 'Aula inválida');
		}
		/*
		if ($aula->id_usuario != Auth::instance()->get_user()->pk()) {
			throw HTTP_Exception::factory(404, 'Usuário sem permissão de acesso');
		}
		*/
		return $aula;
	}

	public function action_salvarposicoes()
	{
		$this->requerer_autenticacao();

		$resposta = array();

		$bd = Database::instance();
		$bd->begin();

		try {
			$aula = $this->obter_aula();

			// Validar requisicao
			if ( ! $this->request->is_ajax()) {
				throw new RuntimeException('Requisição inválida.');
			}
			if ($this->request->method() != 'POST') {
				throw new RuntimeException('Método de requisição inválido.');
			}

			$total_secoes = $aula->secoes->count_all();

			// Atualizar as secoes
			foreach ($this->request->post('mudancas') as $id_secao => $nova_posicao) {
				if ($nova_posicao <= 0 || $nova_posicao > $total_secoes) {
					throw new RuntimeException('Posição inválida.');
				}
				$secao = ORM::Factory('secao', $id_secao);
				$secao->posicao = $nova_posicao;
				$secao->save();
			}

			$bd->commit();

			$secoes = $this->obter_lista_secoes($aula->id_aula);

			$resposta['sucesso'] = true;
			$resposta['secoes'] = array();
			foreach ($secoes as $secao) {
				$resposta['secoes'][$secao['id_secao']] = $secao['numero'];
			}
		} catch (Exception $e) {
			$bd->rollback();

			$resposta['sucesso'] = false;
			$resposta['erro'] = $e->getMessage();
		}

		// Retornar JSON
		$this->response->headers('Content-type','application/json; charset='.Kohana::$charset);
		$this->response->body(json_encode($resposta));
	}

	public function action_salvarposicoesitens()
	{
		$this->requerer_autenticacao();

		$resposta = array();

		$bd = Database::instance();
		$bd->begin();

		try {
			$aula = $this->obter_aula();
			$secao = ORM::Factory('Secao', $this->request->post('id_secao'));
			$itens_secao = $this->obter_itens_secao($secao);
			$total_itens = count($itens_secao);

			// Validar requisicao
			if ($secao->id_aula != $aula->pk()) {
				throw new RuntimeException('Seção inválida');
			}
			if ( ! $this->request->is_ajax()) {
				throw new RuntimeException('Requisição inválida.');
			}
			if ($this->request->method() != 'POST') {
				throw new RuntimeException('Método de requisição inválido.');
			}

			// Atualizar os itens da secao
			foreach ($this->request->post('mudancas') as $id_item_secao => $nova_posicao) {
				if ($nova_posicao <= 0 || $nova_posicao > $total_itens) {
					throw new RuntimeException('Posição inválida.');
				}
				if (preg_match('/^(texto|imagem|formula)(\d)$/', $id_item_secao, $matches)) {
					$tipo = $matches[1];
					$id = $matches[2];
					switch ($tipo) {
					case 'texto':
						$item = ORM::factory('Secao_Texto', $id);
						break;
					case 'imagem':
						$item = ORM::factory('Secao_Imagem', $id);
						break;
					case 'formula':
						$item = ORM::factory('Secao_Formula', $id);
						break;
					}
					$item->posicao = $nova_posicao;
					$item->save();
				}
			}

			$bd->commit();

			$resposta['sucesso'] = true;
		} catch (Exception $e) {
			$bd->rollback();

			$resposta['sucesso'] = false;
			$resposta['erro'] = $e->getMessage();
		}

		// Retornar JSON
		$this->response->headers('Content-type','application/json; charset='.Kohana::$charset);
		$this->response->body(json_encode($resposta));
	}
}
