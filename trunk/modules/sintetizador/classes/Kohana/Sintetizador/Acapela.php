<?php
/**
 * Driver text-to-speach que usa a API Acapela.
 * @see <http://www.acapela-vaas.com/>
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
abstract class Kohana_Sintetizador_Acapela extends Kohana_Sintetizador {

	/**
	 * {@inheritdoc}
	 */
	public function obter_definicao_campos_config()
	{
		return array(
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function converter_texto_arquivo_audio($texto, $arquivo_saida)
	{
		$params = array(
			'cl_app' => $this->_config['cl_app'],
			'cl_env' => 'audioweb' . Kohana::$config->load('audioweb.versao'),
			'cl_login' => $this->_config['cl_login'],
			'cl_pwd' => $this->_config['cl_pwd'],
			'cl_vers' => '1-1',
			'prot_vers' => 2,
			'req_type' => 'NEW',
			'req_asw_type' => 'SOUND',
			'req_echo' => 'ON',
			'req_text' => $texto,
			'req_voice' => $this->_config['req_voice'],
			'req_alt_snd_ext' => null,
			'req_alt_snd_kbps' => null,
			'req_alt_snd_type' => null,
			'req_asw_as_alt_snd' => null,
			'req_asw_redirect_url' => null,
			'req_bp' => null,
			'req_comment' => null,
			'req_eq1' => null,
			'req_eq2' => null,
			'req_eq3' => null,
			'req_eq4' => null,
			'req_err_as_id3' => null,
			'req_mp' => null,
			'req_snd_ext' => null,
			'req_snd_id' => null,
			'req_snd_kbps' => null,
			'req_snd_type' => null,
			'req_spd' => null,
			'req_start_time' => null,
			'req_timeout' => null,
			'req_vct' => null,
			'req_vol' => null,
			'req_wp' => null,
		);
		$params_post = http_build_query($params);
		$url = 'http://vaas.acapela-group.com/Services/Synthesizer';
		$context = stream_context_create(array(
			'http' => array(
				'method'  => 'POST',
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
				             "Content-length: " . strlen($params_post) . "\r\n",
				'content' => $params_post,
			)
		));
		$conteudo_mp3 = file_get_contents($url, false, $context);
		if ( ! $conteudo_mp3)
		{
			throw new RuntimeException('Erro ao gerar arquivo MP3');
		}
		file_put_contents($arquivo_saida, $conteudo_mp3);
	}

}