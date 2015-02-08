<?php

class Helper_Audio {

	/**
	 * Monta a URL para o audio
	 * @param string $texto
	 * @param array $sintetizador
	 * @return string
	 */
	public static function montar_url_audio($texto, array $sintetizador)
	{
		$chave = self::montar_chave_texto($texto);
		$query_array = array(
			'texto' => $texto,
			'chave' => $chave,
			'driver' => $sintetizador['driver'],
			'config' => $sintetizador['config']
		);

		$url = Route::url('acao_padrao', array('directory' => 'audio', 'controller' => 'exibir'));
		$query_string = http_build_query($query_array, null, '&');
		return $url . '?' . $query_string;
	}

	/**
	 * Monta a Chave para o texto
	 * @param string $texto
	 * @return string
	 */
	public static function montar_chave_texto($texto)
	{
		return md5(Cookie::$salt . $texto);
	}
}