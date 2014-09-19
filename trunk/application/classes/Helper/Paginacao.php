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
		$paginacao_default = array(
			'pagina'        => 1,
			'itens_pagina'  => 10
		);
		$paginacao = array_merge($paginacao_default, $paginacao);

		$paginacao['ultima_pagina'] = (int)ceil($paginacao['total_registros'] / $paginacao['itens_pagina']);
		if ( ! isset($paginacao['callback_link']))
		{
			$paginacao['callback_link'] = function ($pagina) use ($paginacao) {
				$params = array();
				if (isset($paginacao['directory']))
				{
					$params['directory'] = $paginacao['directory'];
				}
				$params['controller'] = 'listar';
				if ($pagina > 1)
				{
					$params['pagina'] = number_format($pagina, 0, '.', '');
				}
				return Route::url('listar', $params);
			};
		}

		$estilos_default = array(
			'class' => 'pagination'
		);
		$estilos = array_merge($estilos_default, $estilos);

		if ($paginacao['ultima_pagina'] <= 1)
		{
			return '';
		}

		$html = '<div>';
		$html .= '<span class="sr-only">Paginação:</span>';
		$html .= sprintf('<div class="%s">', $estilos['class']);
		if ($paginacao['pagina'] > 1)
		{
			$html .= sprintf(
				'<li><a rel="prev" href="%s" title="Página Anterior">&laquo;</a></li>',
				call_user_func($paginacao['callback_link'], $paginacao['pagina'] - 1)
			);
		}
		else
		{
			$html .= '<li class="disabled"><span title="Página Anterior">&laquo;</span></li>';
		}

		$html .= sprintf(
			'<li class="active"><span>%s</span></li>',
			number_format($paginacao['pagina'], 0, ',', '.')
		);

		if ($paginacao['pagina'] < $paginacao['ultima_pagina'])
		{
			$html .= sprintf(
				'<li><a rel="next" href="%s" title="Página Seguinte">&raquo;</a></li>',
				call_user_func($paginacao['callback_link'], $paginacao['pagina'] + 1)
			);
		}
		else
		{
			$html .= '<li class="disabled"><span title="Página Seguinte">&raquo;</span></li>';
		}
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
}