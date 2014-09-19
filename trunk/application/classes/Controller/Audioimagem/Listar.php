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
		$dados['mensagens'] = Session::instance()->get_once('flash_message', array());

		$pagina = $this->request->param('pagina') ? $this->request->param('pagina') : 1;

		$imagens = ORM::Factory('Imagem')
			->where('id_usuario', '=', Auth::instance()->get_user()->pk())
			->limit(self::ITENS_PAGINA)
			->offset(($pagina - 1) * self::ITENS_PAGINA)
			->order_by('id_imagem');

		$total_registros = $imagens->count_all();

		if ($pagina > 1 && $pagina > ceil($total_registros / self::ITENS_PAGINA))
		{
			HTTP::redirect('audioimagem/listar');
		}

		$dados['paginacao'] = array(
			'pagina'          => $pagina,
			'total_registros' => $total_registros,
			'itens_pagina'    => self::ITENS_PAGINA,
			'controller'      => 'audioimagem'
		);

		$dados['imagens'] = $imagens->find_all();

		$this->template->content = View::Factory('audioimagem/listar/index', $dados);
	}
}