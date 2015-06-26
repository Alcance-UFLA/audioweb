<?php
/**
 * Action para listar as aulas da conta do usuario
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioaula_Listar extends Controller_Geral {

	const ITENS_PAGINA = 10;

	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Lista de Aulas');

		$dados = array();
		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('nome' => 'AudioAula', 'icone' => 'education')
		);
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());

		$pagina = Helper_Paginacao::obter_pagina();

		$aulas = ORM::Factory('Aula');
			//->where('aula.id_usuario', '=', Auth::instance()->get_user()->pk());

		$aulas_total_registros = clone($aulas);
		$total_registros = $aulas_total_registros->cached(5)->count_all();
		if ($total_registros && $pagina > ceil($total_registros / self::ITENS_PAGINA)) {
			HTTP::redirect(Route::url('listar', array('directory' => 'audioaula', 'pagina' => '1')) . URL::query(array()));
		}

		$lista_aulas = array();
		$lista = $aulas
			->with('usuario')
			->limit(self::ITENS_PAGINA)
			->offset(($pagina - 1) * self::ITENS_PAGINA)
			->order_by('aula.id_aula')
			->find_all();

		foreach ($lista as $aula) {
			$lista_aulas[] = array(
				'id_aula'       => $aula->pk(),
				'id_conta'      => $aula->usuario->id_conta,
				'nome'          => $aula->nome,
				'data_cadastro' => $aula->data_cadastro
			);
		}

		$dados['aulas'] = array(
			'lista' => $lista_aulas,
			'paginacao' => array(
				'pagina'            => $pagina,
				'total_registros'   => $total_registros,
				'itens_pagina'      => self::ITENS_PAGINA,
				'quantidade_botoes' => 5,
				'directory'         => 'audioaula'
			)
		);

		Helper_Paginacao::adicionar_links_head($this, $dados['aulas']['paginacao']);

		$this->template->content = View::Factory('audioaula/listar/index', $dados);
	}

}
