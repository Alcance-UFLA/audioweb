<?php
/**
 * Action para retornar o arquivo de audio de um texto.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audio_Exibir extends Controller_Geral {
	/**
	 * Tempo de cache em arquivo
	 */
	const TEMPO_CACHE = 31536000;

	/**
	 * Obtem o arquivo MP3 de um audio dinamico
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();

		$texto = $this->request->query('texto');
		$chave = $this->request->query('chave');

		if ($chave != Helper_Audio::montar_chave_texto($texto))
		{
			throw HTTP_Exception::factory(403, 'Chave inválida.');
		}

		if ($this->request->query('driver'))
		{
			$driver = $this->request->query('driver');
		}
		else
		{
			$driver = Kohana::$config->load('sintetizador.driver');
		}
		$config_pessoal = $this->request->query('config');
		if ( ! $config_pessoal)
		{
			$config_pessoal = array();
		}

		self::retornar_audio($this, $driver, $config_pessoal, $texto);
	}

	/**
	 * Retorna a requisicao por um audio
	 * @param Controller $controller
	 * @param string $driver
	 * @param array $config
	 * @param string $texto
	 * @return void
	 */
	public static function retornar_audio($controller, $driver, $config, $texto)
	{
		$cache = Cache::instance('file');
		$id_cache = sprintf(
			'audio#driver-%s#config-%s#texto-%s',
			$driver,
			md5(json_encode($config)),
			md5($texto)
		);
		$conteudo_arquivo_mp3 = $cache->get($id_cache);
		if ( ! $conteudo_arquivo_mp3)
		{
			$sintetizador = Sintetizador::instance($driver);
			$sintetizador->definir_config($config);
			$conteudo_arquivo_mp3 = $sintetizador->converter_texto_audio($texto);
			$cache->set($id_cache, $conteudo_arquivo_mp3, self::TEMPO_CACHE);
		}

		$encoding = Http_Header::parse_encoding_header($controller->request->headers('accept-encoding'));

		$compressao = null;
		if (isset($encoding['gzip']) && $encoding['gzip'])
		{
			$conteudo_arquivo_mp3 = gzencode($conteudo_arquivo_mp3, 9, FORCE_GZIP);
			$controller->response->headers('Content-Encoding', 'gzip');
		}
		elseif (isset($encoding['deflate']) && $encoding['deflate'])
		{
			$conteudo_arquivo_mp3 = gzencode($conteudo_arquivo_mp3, 9, FORCE_DEFLATE);
			$controller->response->headers('Content-Encoding', 'deflate');
		}

		$controller->etag = sha1($conteudo_arquivo_mp3);
		$controller->response->headers('Content-Type', 'audio/mpeg');
		$controller->response->headers('Content-Length', strlen($conteudo_arquivo_mp3));
		$controller->response->body($conteudo_arquivo_mp3);
	}
}