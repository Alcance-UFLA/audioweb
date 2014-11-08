<?php
/**
 * Driver text-to-speach que usa a API ispeech.
 * @see <http://www.ispeech.org/>
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
abstract class Kohana_Sintetizador_Ispeech extends Kohana_Sintetizador {

	/**
	 * {@inheritdoc}
	 */
	public function obter_definicao_campos_config()
	{
		return array(
			'voice' => array(
				'type'     => 'string',
				'options'  => array('brportuguesefemale'),
				'required' => true,
			),
			'frequency' => array(
				'type'     => 'int',
				'min'      => 0,
				'required' => false
			),
			'bitrate' => array(
				'type'     => 'int',
				'min'      => 0,
				'required' => false
			),
			'speed' => array(
				'type'     => 'int',
				'min'      => -10,
				'max'      => 10,
				'required' => false
			),
			'startpadding' => array(
				'type'     => 'int',
				'min'      => 0,
				'required' => false
			),
			'endpadding' => array(
				'type'     => 'int',
				'min'      => 0,
				'required' => false
			),
			'pitch' => array(
				'type'     => 'int',
				'min'      => 0,
				'max'      => 200,
				'required' => false
			),
			'bitdepth' => array(
				'type'     => 'int',
				'options'  => array(8, 16),
				'required' => false
			)
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function converter_texto_arquivo_audio($texto, $arquivo_saida)
	{
		$params = array(
			'action'       => 'convert',
			'format'       => 'mp3',
			'apikey'       => $this->_config['apikey'],
			'voice'        => $this->_config['voice'],
			'frequency'    => $this->_config['frequency'],
			'bitrate'      => $this->_config['bitrate'],
			'speed'        => $this->_config['speed'],
			'startpadding' => $this->_config['startpadding'],
			'endpadding'   => $this->_config['endpadding'],
			'pitch'        => $this->_config['pitch'],
			'bitdepth'     => $this->_config['bitdepth'],
			'text'         => $texto
		);
		$url = 'http://api.ispeech.org/api/rest?' . http_build_query($params);
		$conteudo_mp3 = file_get_contents($url);
		if ( ! $conteudo_mp3)
		{
			throw new RuntimeException('Erro ao gerar arquivo MP3');
		}
		file_put_contents($arquivo_saida, $conteudo_mp3);
	}

}