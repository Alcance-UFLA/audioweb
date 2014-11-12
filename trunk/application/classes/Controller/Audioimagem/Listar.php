<?php
/**
 * Action para listar as imagens da conta do usuario
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioimagem_Listar extends Controller_Geral {

	const ITENS_PAGINA = 10;

	public function action_index()
	{
		$this->requerer_autenticacao();
		$this->definir_title('Lista de Imagens');

		$dados = array();

		$dados['trilha'] = array(
			array('url' => Route::url('principal'), 'nome' => 'Início', 'icone' => 'home'),
			array('nome' => 'AudioImagem', 'icone' => 'picture')
		);

		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());

		$pagina = $this->request->param('pagina') ? $this->request->param('pagina') : 1;

		$imagens = ORM::Factory('Imagem');
			//->where('imagem.id_usuario', '=', Auth::instance()->get_user()->pk());

		$imagens_total_registros = clone($imagens);
		$total_registros = $imagens_total_registros->cached(5)->count_all();
		if ($total_registros && $pagina > ceil($total_registros / self::ITENS_PAGINA))
		{
			HTTP::redirect('audioimagem/listar');
		}

		$lista_imagens = array();
		$lista = $imagens
			->with('usuario')
			->limit(self::ITENS_PAGINA)
			->offset(($pagina - 1) * self::ITENS_PAGINA)
			->order_by('imagem.id_imagem')
			->find_all();

		foreach ($lista as $imagem)
		{
			$lista_imagens[] = array(
				'id_imagem'     => $imagem->pk(),
				'id_conta'      => $imagem->usuario->id_conta,
				'arquivo'       => $imagem->arquivo,
				'nome'          => $imagem->nome,
				'data_cadastro' => $imagem->data_cadastro
			);
		}

		$dados['imagens'] = array(
			'lista' => $lista_imagens,
			'paginacao' => array(
				'pagina'          => $pagina,
				'total_registros' => $total_registros,
				'itens_pagina'    => self::ITENS_PAGINA,
				'directory'       => 'audioimagem'
			)
		);

		Helper_Paginacao::adicionar_links_head($this, $dados['imagens']['paginacao']);
		$this->template->content = View::Factory('audioimagem/listar/index', $dados);
	}
}