<?php
/**
 * Classe responsavel por retornar as teclas de atalho do AudioWeb
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Util_Teclas {
	public static function obter_teclas_atalho()
	{
		$teclas = array();

		// Obter teclas de atalho padrão
		$teclas_padrao = ORM::Factory('Operacao')->find_all();
		foreach ($teclas_padrao as $tecla) {
			$teclas[$tecla->chave] = array(
				'tecla'  => $tecla->ajuda_tecla,
				'acao'   => $tecla->nome,
				'codigo' => (int)$tecla->tecla_padrao,
				'shift'  => (bool)$tecla->shift,
				'alt'    => (bool)$tecla->alt,
				'ctrl'   => (bool)$tecla->ctrl
			);
		}

		if (Auth::instance()->get_user()) {
			$teclas_usuario = ORM::Factory('Usuario_Operacao')
				->where('id_usuario', '=', Auth::instance()->get_user()->pk())
				->find_all();
			foreach ($teclas_usuario as $tecla) {
				$chave = $tecla->operacao->chave;
				$teclas[$chave]['codigo'] = (int)$tecla->tecla_personalizada;
				$teclas[$chave]['shift'] = (bool)$tecla->shift;
				$teclas[$chave]['alt'] = (bool)$tecla->alt;
				$teclas[$chave]['ctrl'] = (bool)$tecla->ctrl;
			}
		}

		return $teclas;
	}
}
