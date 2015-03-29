<?php
/**
 * Classe responsavel por retornar as teclas de atalho do AudioWeb
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Util_Teclas {
	public static function obter_teclas_atalho()
	{
		return array(
			'falar_ajuda' => array(
				'tecla'  => 'alt + a',
				'codigo' => ord('a'),
				'alt'    => true,
				'acao'   => 'Fala a ajuda.'
			),
			'falar_nome_imagem' => array(
				'tecla'  => 'z',
				'codigo' => ord('z'),
				'acao'   => 'Fala o nome curto da imagem.',
			),
			'falar_descricao_imagem' => array(
				'tecla'  => 'w',
				'codigo' => ord('w'),
				'acao'   => 'Fala a descrição longa da imagem.',
			),
			'falar_nome_regiao' => array(
				'tecla'  => 'alt + z',
				'codigo' => ord('z'),
				'alt'    => true,
				'acao'   => 'Fala o nome curto da região onde está o cursor.'
			),
			'falar_descricao_regiao' => array(
				'tecla'  => 'alt + w',
				'codigo' => ord('w'),
				'alt'    => true,
				'acao'   => 'Fala a descrição longa da região onde está o cursor.'
			),
			'falar_posicao' => array(
				'tecla'  => 'p',
				'codigo' => ord('p'),
				'acao'   => 'Fala a posição do cursor dentro ou fora da imagem.'
			),
			'alternar_modo_exibicao' => array(
				'tecla'  => 'y',
				'codigo' => ord('y'),
				'acao'   => 'Alterna entre o modo de exibição para videntes ou para cegos.'
			),
			'parar_bip' => array(
				'tecla'  => 'espaço',
				'codigo' => ord(' '),
				'acao'   => 'Pára o bip momentaneamente.'
			)
		);
	}
}