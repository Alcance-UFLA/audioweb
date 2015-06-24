<?php
/**
 * Helper para montar paginacao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Helper_Paginacao {

	/**
	 * Retorna a paginacaoa de forma formatada
	 * @param array[string => mixed] $paginacao Array com os dados da paginacao
	 * @param array[string => mixed] $estilos Array com os estilos da paginacao
	 * @return string
	 */
	public static function exibir(array $paginacao, array $estilos = array())
	{
		$paginacao = self::montar_paginacao($paginacao);

		// Calcular quantidade de botoes na esquerda e direita
		if (isset($paginacao['quantidade_botoes']) && $paginacao['quantidade_botoes'] > 0) {
			$quantidade_botoes = min($paginacao['quantidade_botoes'], $paginacao['ultima_pagina']);

			$esquerda = intval($quantidade_botoes / 2);
			$direita  = $esquerda;
			if ($quantidade_botoes % 2 == 0) {
				$direita -= 1;
			}

			if ($paginacao['pagina'] - $esquerda < 1) {
				$dif = $esquerda + 1 - $paginacao['pagina'];
				$esquerda -= $dif;
				$direita  += $dif;
			} elseif ($paginacao['pagina'] + $direita >= $paginacao['ultima_pagina']) {
				$dif = $paginacao['pagina'] + $direita - $paginacao['ultima_pagina'];
				$direita  -= $dif;
				$esquerda += $dif;
			}
		} else {
			$quantidade_botoes = 0;
			$esquerda = 0;
			$direita = 0;
		}

		// Preparar estilos
		$estilos_default = array(
			'class' => 'pagination'
		);
		$estilos = array_merge($estilos_default, $estilos);

		// Exibir paginacao
		if ($paginacao['ultima_pagina'] <= 1) {
			return '';
		}

		$html = '<div>';
		$html .= '<span class="sr-only">Paginação:</span>';
		$html .= sprintf('<div class="%s">', $estilos['class']);

		// Pagina anterior
		if ($paginacao['pagina'] > 1) {
			$html .= sprintf(
				'<li><a rel="prev" href="%s">&laquo; Página Anterior</a></li>',
				call_user_func($paginacao['callback_link'], $paginacao, $paginacao['pagina'] - 1)
			);
		} else {
			$html .= '<li class="disabled"><span>&laquo; Página Anterior</span></li>';
		}

		// Primeira pagina
		if ($paginacao['pagina'] - $esquerda > 1) {
			$html .= sprintf(
				'<li><a href="%s" title="Primeira página"><span class="sr-only">Página</span> %s</a></li>',
				call_user_func($paginacao['callback_link'], $paginacao, 1),
				number_format(1, 0, ',', '.')
			);
			if ($paginacao['pagina'] - $esquerda > 2) {
				$html .= '<li class="disabled"><span>&hellip;</span></li>';
			}
		}

		// Paginas anteriores a corrente
		for ($i = $esquerda; $i > 0; $i--) {
			$p = $paginacao['pagina'] - $i;
			$html .= sprintf(
				'<li><a href="%s"><span class="sr-only">Página</span> %s</a></li>',
				call_user_func($paginacao['callback_link'], $paginacao, $p),
				number_format($p, 0, ',', '.')
			);
		}

		// Pagina corrente
		$html .= sprintf(
			'<li class="active"><span><span class="sr-only">Página</span> %s</span></li>',
			number_format($paginacao['pagina'], 0, ',', '.')
		);

		// Paginas posteiores a corrente
		for ($i = 1; $i <= $direita; $i++) {
			$p = $paginacao['pagina'] + $i;
			$html .= sprintf(
				'<li><a href="%s"><span class="sr-only">Página</span> %s</a></li>',
				call_user_func($paginacao['callback_link'], $paginacao, $p),
				number_format($p, 0, ',', '.')
			);
		}

		// Ultima pagina
		if ($paginacao['pagina'] + $direita < $paginacao['ultima_pagina']) {
			if ($paginacao['pagina'] + $direita < $paginacao['ultima_pagina'] - 1) {
				$html .= '<li class="disabled"><span>&hellip;</span></li>';
			}
			$html .= sprintf(
				'<li><a href="%s" title="Última página"><span class="sr-only">Página</span> %s</a></li>',
				call_user_func($paginacao['callback_link'], $paginacao, $paginacao['ultima_pagina']),
				number_format($paginacao['ultima_pagina'], 0, ',', '.')
			);
		}

		// Pagina seguinte
		if ($paginacao['pagina'] < $paginacao['ultima_pagina']) {
			$html .= sprintf(
				'<li><a rel="next" href="%s">Próxima Página &raquo;</a></li>',
				call_user_func($paginacao['callback_link'], $paginacao, $paginacao['pagina'] + 1)
			);
		} else {
			$html .= '<li class="disabled"><span>Próxima Página &raquo;</span></li>';
		}
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Adiciona os links de next/prev no head da pagina
	 * @param Controller_Geral $controller
	 * @param array $paginacao
	 * @return void
	 */
	public static function adicionar_links_head(Controller_Geral $controller, array $paginacao)
	{
		$paginacao = self::montar_paginacao($paginacao);

		if ($paginacao['pagina'] > 1) {
			$controller->adicionar_link(array(
				'rel' => 'prev',
				'href' => call_user_func($paginacao['callback_link'], $paginacao, $paginacao['pagina'] - 1)
			));
		}

		if ($paginacao['pagina'] < $paginacao['ultima_pagina']) {
			$controller->adicionar_link(array(
				'rel' => 'next',
				'href' => call_user_func($paginacao['callback_link'], $paginacao, $paginacao['pagina'] + 1)
			));
		}
	}

	/**
	 * Monta a paginacao com os dados passados
	 * @param array $paginacao
	 * @return array
	 */
	private static function montar_paginacao(array $paginacao)
	{
		$paginacao_default = array(
			'pagina'        => 1,
			'itens_pagina'  => 10
		);
		$paginacao = array_merge($paginacao_default, $paginacao);

		$paginacao['ultima_pagina'] = (int)ceil($paginacao['total_registros'] / $paginacao['itens_pagina']);
		if ( ! isset($paginacao['callback_link'])) {
			$paginacao['callback_link'] = function ($paginacao, $pagina) {
				$params = array();
				if (isset($paginacao['directory'])) {
					$params['directory'] = $paginacao['directory'];
				}
				$params['controller'] = 'listar';
				if ($pagina >= 1) {
					$params['pagina'] = number_format($pagina, 0, '.', '');
				}
				return Route::url('listar', $params);
			};
		}
		return $paginacao;
	}

	/**
	 * Obtem a pagina recebida pela URL
	 * @param HTTP_Request $request
	 * @return int
	 */
	public static function obter_pagina(HTTP_Request $request = NULL)
	{
		if ($request === NULL) {
			$request = Request::current();
		}
		$id = sprintf('paginacao.%s.%s.%s',
			$request->directory(),
			$request->controller(),
			$request->action()
		);
		if ($request->param('pagina') > 0) {
			$pagina = (int)$request->param('pagina');
			if ( ! isset($_SERVER['HTTP_X_MOZ']) || $_SERVER['HTTP_X_MOZ'] != 'prefetch') {
				Session::instance()->set($id, $pagina);
			}
		} elseif (Session::instance()->get($id)) {
			$pagina = Session::instance()->get($id);
		} else {
			$pagina = 1;
		}
		return $pagina;
	}
}