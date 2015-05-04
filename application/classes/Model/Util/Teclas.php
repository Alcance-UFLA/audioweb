<?php
/**
 * Classe responsavel por retornar as teclas de atalho do AudioWeb
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Util_Teclas {
	public static function obter_teclas_atalho()
	{
		return array(
			'alternar_modo_exibicao' => array(
				'tecla'  => 'alt + j',
				'acao'   => 'Muda modo de exibição da imagem: ou cego, ou vidente.',
				'codigo' => ord('J'),
				'alt'    => true,
			),
			'falar_nome_imagem' => array(
				'tecla'  => 'alt + z',
				'acao'   => 'Descrição curta da imagem.',
				'codigo' => ord('Z'),
				'alt'    => true,
			),
			'falar_descricao_imagem' => array(
				'tecla'  => 'alt + w',
				'acao'   => 'Descrição longa da imagem.',
				'codigo' => ord('W'),
				'alt'    => true,
			),
			'falar_nome_regiao' => array(
				'tecla'  => 'z',
				'acao'   => 'Descrição curta da área marcada.',
				'codigo' => ord('Z'),
			),
			'falar_descricao_regiao' => array(
				'tecla'  => 'w',
				'acao'   => 'Descrição longa da área marcada.',
				'codigo' => ord('W'),
			),
			'falar_posicao' => array(
				'tecla'  => 'alt + p',
				'acao'   => 'Posição do cursor dentro ou fora da imagem.',
				'codigo' => ord('P'),
				'alt'    => true,
			),
			'parar_bip' => array(
				'tecla'  => 'ctrl',
				'acao'   => 'Pára o bip momentaneamente.',
				'codigo' => 17,
				'ctrl'   => true,
			),
			'falar_ajuda' => array(
				'tecla'  => 'alt + a',
				'acao'   => 'Ajuda.',
				'codigo' => ord('A'),
				'alt'    => true,
			)
		);
	}
}
