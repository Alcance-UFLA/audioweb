<?php
/**
 * Classe para auxiliar a geracao das trilhas das paginas
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Helper_Trilha {

	/**
	 * Exibe uma trilha de navegacao (breadcrumb)
	 * @param array $trilha Array contendo dados sobre os links para colocar na trilha
	 * @param array $atributos Atributos da tag NAV
	 * @return string
	 */
	public static function exibir(array $trilha, array $atributos = array())
	{
		$indice_ultima_pagina = count($trilha) - 1;

		$atributos['id'] = 'trilha-pagina';

		$html = '<nav' . HTML::attributes($atributos) . '>';
		$html .= '<span class="sr-only">Trilha de navegação:</span>';
		$html .= '<ol class="breadcrumb" itemprop="breadcrumb">';
		foreach ($trilha as $i => $pagina) {
			$atributos_pagina = array();
			if ( ! isset($pagina['url'])) {
				$atributos_pagina['class'] = 'active';
			}

			$seta = ($i < $indice_ultima_pagina) ? ' <span role="separator" class="sr-only">&rarr;</span>' : '';

			$html .= sprintf(
				'<li%s>%s%s</li>',
				HTML::attributes($atributos_pagina),
				self::exibir_link_pagina_trilha($pagina),
				$seta
			);
		}
		$html .= '</ol>';
		$html .= '</nav>';

		return $html;
	}

	/**
	 * Exibe o link de uma pagina da trilha de navegacao
	 * @param array $pagina Array contendo dados sobre a pagina
	 * @return string
	 */
	public static function exibir_link_pagina_trilha(array $pagina)
	{
		$atributos = array();
		if (isset($pagina['url'])) {
			$atributos['href'] = $pagina['url'];
		}
		if (isset($pagina['titulo'])) {
			$atributos['title'] = $pagina['titulo'];
		}

		$icone = '';
		if (isset($pagina['icone'])) {
			$icone = sprintf('<i class="glyphicon glyphicon-%s"></i> ', $pagina['icone']);
		}

		if ( ! isset($pagina['url'])) {
			return sprintf(
				'<span%s>%s%s</span>',
				HTML::attributes($atributos),
				$icone,
				HTML::chars($pagina['nome'])
			);
		}
		return sprintf(
			'<a%s>%s%s</a>',
			HTML::attributes($atributos),
			$icone,
			HTML::chars($pagina['nome'])
		);
	}
}