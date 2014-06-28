<?php
/**
 * Action para listar usuários
 * @author Gustavo Araújo <kustavo@gmail.com>
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Usuario_Listar extends Controller_Geral {

	const ITENS_PAGINA = 10;

	public function action_index()
	{
		$this->definir_title('Lista de Usuários');
		$this->adicionar_script(array('src' => URL::site('js/usuario/listar.js')));

		$total_registros = ORM::Factory('Usuario')->count_all();

		$pagina = $this->request->param('pagina') ? $this->request->param('pagina') : 1;

		if ($pagina > ceil($total_registros / self::ITENS_PAGINA))
		{
			HTTP::redirect('usuario/listar');
		}

		$paginacao = array(
			'pagina'          => $pagina,
			'total_registros' => $total_registros,
			'itens_pagina'    => self::ITENS_PAGINA,
			'controller'      => 'usuario'
		);

		$usuarios = ORM::Factory('Usuario')
			->limit(self::ITENS_PAGINA)
			->offset(($pagina - 1) * self::ITENS_PAGINA)
			->order_by('id_usuario')
			->find_all();

		$mensagens = Session::instance()->get_once('flash_message', array());

		$view = View::Factory('usuario/listar/index');
		$view->set('usuarios', $usuarios);
		$view->set('paginacao', $paginacao);
		$view->set('mensagens', $mensagens);
		$this->template->content = $view;
	}

}
