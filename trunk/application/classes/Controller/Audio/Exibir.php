<?php
/**
 * Action para retornar o arquivo de audio de um texto.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audio_Exibir extends Controller_Geral {

	/**
	 * Obtem o arquivo MP3 de um audio dinamico
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao();

		$texto = $this->request->query('texto');
		$chave = $this->request->query('chave');

		if ($chave != md5(Cookie::$salt . $texto))
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

		$cache = Cache::instance('file');
		$id_cache = sprintf(
			'audio#driver-%s#config-%s#texto-%s',
			$driver,
			md5(json_encode($config_pessoal)),
			md5($texto)
		);
		$conteudo_arquivo_mp3 = $cache->get($id_cache);
		if ( ! $conteudo_arquivo_mp3)
		{
			$sintetizador = Sintetizador::instance($driver);
			$sintetizador->definir_config($config_pessoal);
			$conteudo_arquivo_mp3 = $sintetizador->converter_texto_audio($texto);
			$cache->set($id_cache, $conteudo_arquivo_mp3);
		}

		$this->etag = sha1($conteudo_arquivo_mp3);
		$this->response->headers('Content-Type', 'audio/mpeg');
		$this->response->body($conteudo_arquivo_mp3);
	}
}