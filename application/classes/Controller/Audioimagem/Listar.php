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
			->where('id_usuario', '=', Auth::instance()->get_user()->pk());

		$imagens_total_registros = clone($imagens);
		$total_registros = $imagens_total_registros->cached(5)->count_all();
		if ($total_registros && $pagina > ceil($total_registros / self::ITENS_PAGINA))
		{
			HTTP::redirect('audioimagem/listar');
		}

		$dados['imagens'] = array(
			'lista' => $imagens
				->limit(self::ITENS_PAGINA)
				->offset(($pagina - 1) * self::ITENS_PAGINA)
				->order_by('id_imagem')
				->find_all()
				->as_array(),
			'paginacao' => array(
				'pagina'          => $pagina,
				'total_registros' => $total_registros,
				'itens_pagina'    => self::ITENS_PAGINA,
				'directory'       => 'audioimagem'
			)
		);
		$this->template->content = View::Factory('audioimagem/listar/index', $dados);
	}
}