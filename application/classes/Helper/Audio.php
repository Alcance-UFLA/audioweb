<?php

class Helper_Audio {

	/**
	 * Monta a URL para o audio de um conjunto de elementos (texto ou sons prontos)
	 * @param array $elementos Array de tuplas contendo a chave "texto" ou "url"
	 * @param array $sintetizador
	 * @return string
	 */
	public static function montar_url_audio(array $elementos, array $sintetizador)
	{
		$json = json_encode($elementos);
		$chave = self::montar_chave($json);

		$query_array = array(
			'elementos' => $json,
			'chave'     => $chave,
			'driver'    => $sintetizador['driver'],
			'config'    => $sintetizador['config']
		);

		$url = Route::url('acao_padrao', array('directory' => 'audio', 'controller' => 'exibir'));
		$query_string = http_build_query($query_array, null, '&');
		return $url . '?' . $query_string;
	}

	/**
	 * Monta a Chave para o texto
	 * @param string $string
	 * @return string
	 */
	public static function montar_chave($string)
	{
		return md5(Cookie::$salt . $string);
	}

	/**
	 * Junta o conteúdo dos arquivos MP3 em um único arquivo
	 * @param array $conteudos_arquivos_mp3
	 * @return string
	 */
	public static function juntar_arquivos_mp3(array $conteudos_arquivos_mp3)
	{
		if (count($conteudos_arquivos_mp3) == 1) {
			return current($conteudos_arquivos_mp3);
		}

		// Checar se possui ffmpeg e lame para padronizar o mp3
		exec('type -P ffmpeg', $saida, $retorno);
		$caminho_ffmpeg = current($saida);
		$possui_ffmpeg = $retorno == 0 && is_executable($caminho_ffmpeg);
		$saida = $retorno = null;

		exec('type -P lame', $saida, $retorno);
		$caminho_lame = current($saida);
		$possui_lame = $retorno == 0 && is_executable($caminho_lame);
		$saida = $retorno = null;

		if ($possui_ffmpeg && $possui_lame) {
			// Gerar conteudo de arquivo MP3 padronizado
			$dir = '/tmp/mp3' . md5(microtime(true)) . rand(1000, 9999);
			mkdir($dir);
			$i = 1;
			$conteudo = '';
			foreach ($conteudos_arquivos_mp3 as $conteudo_arquivo_mp3) {
				$arq = $dir . '/' . $i . '.mp3';
				$arq_padronizado = $dir . '/' . $i . 'padrao.mp3';
				file_put_contents($arq, $conteudo_arquivo_mp3);

				$cmd = sprintf(
					'%s -i %s -f mp3 -ab 128k -ar 44100 -ac 2 %s',
					escapeshellcmd($caminho_ffmpeg),
					escapeshellarg($arq),
					escapeshellarg($arq_padronizado)
				);
				exec($cmd, $saida, $retorno);

				if ($retorno != 0) {
					throw new RuntimeException('Erro ao executar comando: ' . $cmd . ' (Saida: ' . $retorno . ')');
				}
				$saida = $retorno = null;

				$conteudo .= file_get_contents($arq_padronizado);

				unlink($arq);
				unlink($arq_padronizado);
				$i += 1;
			}

			rmdir($dir);

			// Usar o lame para ajustar cabecalhos do MP3
			$arq_temp = '/tmp/audio' . md5(microtime(true)) . rand(1000, 9999) . '.mp3';
			$arq_temp2 = '/tmp/audio2' . md5(microtime(true)) . rand(1000, 9999) . '.mp3';
			file_put_contents($arq_temp, $conteudo);

			$cmd = sprintf(
				'%s %s %s',
				escapeshellcmd($caminho_lame),
				escapeshellarg($arq_temp),
				escapeshellarg($arq_temp2)
			);
			exec($cmd, $saida, $retorno);
			if ($retorno != 0) {
				throw new RuntimeException('Erro ao executar comando: ' . $cmd . ' (Saida: ' . $retorno . ')');
			}
			$saida = $retorno = null;

			$conteudo_final = file_get_contents($arq_temp2);

			unlink($arq_temp);
			unlink($arq_temp2);

			return $conteudo_final;
		} else {
			return implode('', $conteudos_arquivos_mp3);
		}
	}
}