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
				'acao'   => 'Ajuda.'
			),
			'falar_nome_imagem' => array(
				'tecla'  => 'alt + z',
				'codigo' => ord('z'),
				'alt'    => true,
				'acao'   => 'Descrição curta da imagem.',
			),
			'falar_descricao_imagem' => array(
				'tecla'  => 'alt + w',
				'codigo' => ord('w'),
				'alt'    => true,
				'acao'   => 'Descrição longa da imagem.',
			),
			'falar_nome_regiao' => array(
				'tecla'  => 'z',
				'codigo' => ord('z'),
				'acao'   => 'Descrição curta da área marcada.'
			),
			'falar_descricao_regiao' => array(
				'tecla'  => 'w',
				'codigo' => ord('w'),
				'acao'   => 'Descrição longa da área marcada.'
			),
			'falar_posicao' => array(
				'tecla'  => 'alt + p',
				'codigo' => ord('p'),
				'alt'    => true,
				'acao'   => 'Posição do cursor dentro ou fora da imagem.'
			),
			'alternar_modo_exibicao' => array(
				'tecla'  => 'alt + j',
				'codigo' => ord('j'),
				'alt'    => true,
				'acao'   => 'Muda modo de exibição da imagem: ou cego, ou vidente.'
			),
			'parar_bip' => array(
				'tecla'  => 'espaço',
				'codigo' => ord(' '),
				'acao'   => 'Pára o bip momentaneamente.'
			)
		);
	}
}