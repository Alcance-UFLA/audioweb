<?php
/**
 * Driver text-to-speach que usa o programa espeak + lame.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
abstract class Kohana_Sintetizador_Espeak extends Kohana_Sintetizador {

	/**
	 * {@inheritdoc}
	 */
	public function obter_definicao_campos_config()
	{
		return array(
			'amplitude' => array(
				'type'     => 'int',
				'min'      => 0,
				'max'      => 20,
				'required' => false
			),
			'word_gap' => array(
				'type'     => 'int',
				'min'      => 0,
				'required' => false
			),
			'capital_letters' => array(
				'type'     => 'int',
				'min'      => 1,
				'required' => false
			),
			'line_length' => array(
				'type'     => 'int',
				'min'      => 0,
				'required' => false
			),
			'pitch' => array(
				'type'     => 'int',
				'min'      => 0,
				'max'      => 99,
				'required' => false
			),
			'voice' => array(
				'type'     => 'string',
				'options'  => $this->obter_voices(),
				'required' => false
			),
			'sentence_pause' => array(
				'type'     => 'bool',
				'required' => false
			),
			'punctuation' => array(
				'type'     => 'string',
				'required' => false
			),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function converter_texto_arquivo_audio($texto, $arquivo_saida)
	{
		try
		{
			$arquivo_wave = $this->gerar_wave($texto);
			$this->converter_wave_mp3($arquivo_wave, $arquivo_saida);
			unlink($arquivo_wave);
		}
		catch (Exception $e)
		{
			if (isset($arquivo_wave))
			{
				unlink($arquivo_wave);
			}
			throw $e;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	protected function validar_ambiente()
	{
		if ( ! is_dir(sys_get_temp_dir()))
		{
			throw new RuntimeException('Diretorio para arquivos temporarios nao eh valido');
		}
		if ( ! is_writeable(sys_get_temp_dir()))
		{
			throw new RuntimeException('Diretorio para arquivos temporarios nao permite escrita');
		}
		if ( ! is_file($this->_config['path_espeak']))
		{
			throw new RuntimeException('Caminho do espeak nao eh valido');
		}
		if ( ! is_executable($this->_config['path_espeak']))
		{
			throw new RuntimeException('Caminho do espeak nao eh executavel');
		}
		if ( ! is_file($this->_config['path_lame']))
		{
			throw new RuntimeException('Caminho do lame nao eh valido');
		}
		if ( ! is_executable($this->_config['path_lame']))
		{
			throw new RuntimeException('Caminho do lame nao eh executavel');
		}
	}

	/**
	 * Gera um arquivo wave a partir de um texto
	 * @param string $texto Texto a ser convertido em fala.
	 * @return string Nome do arquivo wave gerado
	 */
	protected function gerar_wave($texto)
	{
		// Preparar parametros para o comando espeak
		$arquivo_wave = tempnam(sys_get_temp_dir(), 'wave');

		$parametros = array();
		$parametros['-a %s']      = $this->_config['amplitude'];
		$parametros['-g %s']      = $this->_config['word_gap'];
		$parametros['-k %s']      = $this->_config['capital_letters'];
		$parametros['-l %s']      = $this->_config['line_length'];
		$parametros['-p %s']      = $this->_config['pitch'];
		$parametros['-s %s']      = $this->_config['speed'];
		$parametros['-v %s']      = $this->_config['voice'];
		$parametros['-z']         = $this->_config['sentence_pause'];
		$parametros['--punct=%s'] = $this->_config['punctuation'];

		$str_parametros = '';
		foreach ($parametros as $parametro => $valor)
		{
			if ($valor === null)
			{
				continue;
			}
			$str_parametros .= sprintf(' ' . $parametro, escapeshellarg($valor));
		}

		// Preparar comando espeak
		$comando = sprintf(
			'%s %s --stdout',
			escapeshellcmd($this->_config['path_espeak']),
			$str_parametros
		);

		$especificacoes = array(
			0 => array('pipe', 'r'),                // stdin
			1 => array('file', $arquivo_wave, 'w'), // stdout
			2 => array('pipe', 'w')                 // stderr
		);

		$pipes = array();

		// Abrir processo do espeak
		$processo = proc_open($comando, $especificacoes, $pipes);

		if ( ! is_resource($processo))
		{
			$erro = sprintf('Erro inesperado ao executar comando: %s', $comando);
			throw new RuntimeException($erro);
		}

		// Passar o texto a ser convertido no STDIN e obter retornos
		fwrite($pipes[0], $texto . "\n");
		fclose($pipes[0]);

		$stderr = stream_get_contents($pipes[2]);
		fclose($pipes[2]);

		$retorno = proc_close($processo);

		// Validar retorno
		if ($retorno != 0)
		{
			$erro = sprintf(
				'Erro inesperado ao executar comando: %s (retorno=%s / stderr=%s)',
				$comando,
				var_export($retorno, true),
				var_export($stderr, true)
			);
			throw new RuntimeException($erro);
		}
		if (filesize($arquivo_wave) == 0)
		{
			throw new RuntimeException('Arquivo wave gerado vazio');
		}

		return $arquivo_wave;
	}

	/**
	 * Converte um arquivo WAVE para MP3
	 * @param string $arquivo_wave
	 * @param string $arquivo_mp3
	 * @return void
	 */
	protected function converter_wave_mp3($arquivo_wave, $arquivo_mp3)
	{
		// Preparar comando lame
		$comando = sprintf(
			'%s %s %s',
			escapeshellcmd($this->_config['path_lame']),
			escapeshellarg($arquivo_wave),
			escapeshellarg($arquivo_mp3)
		);

		$especificacoes = array(
			1 => array('pipe', 'w'), // stdout
			2 => array('pipe', 'w')  // stderr
		);

		$pipes = array();

		// Abrir processo do lame
		$processo = proc_open($comando, $especificacoes, $pipes);

		if ( ! is_resource($processo))
		{
			throw new RuntimeException(sprintf('Erro inesperado ao executar comando: %s', $comando));
		}

		$stdout = stream_get_contents($pipes[1]);
		fclose($pipes[1]);

		$stderr = stream_get_contents($pipes[2]);
		fclose($pipes[2]);

		$retorno = proc_close($processo);

		// Validar retorno
		if ($retorno != 0)
		{
			$erro = sprintf(
				'Erro inesperado ao executar comando: %s (retorno=%s / stdout=%s / stderr=%s)',
				$comando,
				var_export($retorno, true),
				var_export($stdout, true),
				var_export($stderr, true)
			);
			throw new RuntimeException($erro);
		}
	}

	/**
	 * Obtem as opcoes de voice disponiveis
	 * @return array
	 */
	protected function obter_voices()
	{
		$comando = sprintf(
			'%s --voices',
			$this->_config['path_espeak']
		);

		$output = array();
		$retorno = null;
		exec($comando, $output, $retorno);

		if ($retorno != 0)
		{
			$erro = sprintf(
				'Erro ao executar comando: %s (retorno=%s / stdout=%s)',
				$comando,
				var_export($retorno, true),
				var_export(implode("\n", $output), true)
			);
			throw new RuntimeException($erro);
		}

		$voices = array();
		$count = count($output);
		for ($i = 1; $i < $count; $i++)
		{
			$linha = $output[$i];
			if (preg_match('/^\s*(\d+)\s+([a-z]+)\s+([MF\-])\s+([^[\s]+])\s+/', $linha, $matches))
			{
				switch ($matches[3])
				{
					case 'M':
						$sexo = 'Masculino';
					break;
					case 'F':
						$sexo = 'Feminino';
					break;
					default:
						$sexo = 'Indefinido';
					break;
				}
				$voices[$matches[2]] = sprintf(
					'%s (%s)',
					$matches[4],
					$sexo
				);
			}
		}

		if (empty($voices))
		{
			throw new RuntimeException('Erro ao obter lista de vozes disponiveis');
		}

		return $voices;
	}

}