<?php
/**
 * Classe responsavel por retornar as teclas de atalho do AudioWeb
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Util_Teclas {

	/**
	 * Obtem as teclas de atalho do AudioImagem
	 * @return array
	 */
	public static function obter_teclas_atalho()
	{
		$teclas = array();

		// Obter teclas de atalho padrão
		$teclas_padrao = ORM::Factory('Operacao')->cached(3600)->find_all();
		foreach ($teclas_padrao as $tecla) {
			$teclas[$tecla->chave] = array(
				'id_operacao' => $tecla->pk(),
				'acao'        => $tecla->nome,
				'codigo'      => (int)$tecla->tecla_padrao,
				'shift'       => (bool)$tecla->shift,
				'alt'         => (bool)$tecla->alt,
				'ctrl'        => (bool)$tecla->ctrl
			);
			$teclas[$tecla->chave]['tecla'] = self::montar_ajuda_tecla($teclas[$tecla->chave]);
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
				$teclas[$chave]['tecla'] = self::montar_ajuda_tecla($teclas[$chave]);
			}
		}

		return $teclas;
	}

	/**
	 * Monta o texto de ajuda de uma tecla de atalho
	 * @param array $dados_tecla
	 * @return string
	 */
	public static function montar_ajuda_tecla($dados_tecla)
	{
		$lista = self::obter_lista_teclas();

		$ajuda = array();
		if ($dados_tecla['shift']) {
			$ajuda['16'] = 'shift';
		}
		if ($dados_tecla['ctrl']) {
			$ajuda['17'] = 'ctrl';
		}
		if ($dados_tecla['alt']) {
			$ajuda['18'] = 'alt';
		}
		$ajuda[$dados_tecla['codigo']] = $lista[$dados_tecla['codigo']];
		return implode(' + ', $ajuda);
	}

	/**
	 * Obtem a lista de teclas disponiveis para servir de atalho
	 * @return array
	 */
	public static function obter_lista_teclas()
	{
		$lista = array();
		$lista['20'] = 'espaço';
		$lista['16'] = 'shift';
		$lista['17'] = 'ctrl';
		$lista['18'] = 'alt';
		for ($ord = ord('A'); $ord <= ord('Z'); $ord++) {
			$lista[$ord] = strtolower(chr($ord));
		}
		for ($ord = ord('0'); $ord <= ord('9'); $ord++) {
			$lista[$ord] = chr($ord);
		}
		return $lista;
	}
}
