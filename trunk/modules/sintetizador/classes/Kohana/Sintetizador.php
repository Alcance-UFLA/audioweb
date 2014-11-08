<?php
/**
 * Classe responsavel por gerar um objeto text-to-speech.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
abstract class Kohana_Sintetizador {

	/**
	 * Instancias
	 * @var array[self]
	 */
	protected static $_instancias;

	/**
	 * Configuracoes para o sintetizador
	 * @var Config_Group
	 */
	protected $_config;

	/**
	 * Gera uma instancia com o driver escolhido, ou o driver padrao.
	 * @param string $driver Driver especifico
	 * @return self
	 */
	final public static function instance($driver = NULL)
	{
		$config = Kohana::$config->load('sintetizador');
		if ($driver === NULL)
		{
			$driver = $config['driver'];
		}
		if ( ! isset(self::$_instancias[$driver]))
		{
			if ( ! isset($config[$driver]))
			{
				throw new LogicException('Driver inválido');
			}
			$config_driver =  $config[$driver];
			$classe = $config_driver['classe'];
			self::$_instancias[$driver] = new $classe($config_driver);
		}
		return self::$_instancias[$driver];
	}

	/**
	 * Construtor padrao
	 * @param Config_Group $config Configuracoes para o sintetizador
	 */
	final protected function __construct($config = array())
	{
		$this->_config = $config;
		$this->validar_ambiente();
	}

	/**
	 * Verifica se o ambiente esta preparado para realizar as operacoes
	 * e solta uma exception caso encontre algum problema
	 */
	protected function validar_ambiente()
	{
		//void
	}

	/**
	 * Sobrescreve as configuracoes padrao para o sintetizador
	 * para que parametros possam ser ajustados pelo usuario final.
	 * @param array $config
	 * @return void
	 */
	final public function definir_config(array $config)
	{
		$definicao_campos_config = $this->obter_definicao_campos_config();
		foreach ($config as $parametro => $valor)
		{
			if ( ! isset($definicao_campos_config[$parametro]))
			{
				throw new InvalidArgumentException('Parâmetro inválido: ' . $parametro);
			}
			$this->_config[$parametro] = $valor;
		}
	}

	/**
	 * Converte um texto em um arquivo de som MP3.
	 * @param string $texto Texto a ser convertido
	 * @param string $arquivo_saida Nome do arquivo de saida MP3
	 * @return void
	 */
	abstract public function converter_texto_arquivo_audio($texto, $arquivo_saida);

	/**
	 * Converte um texto em som MP3, retornando o conteudo binario do arquivo MP3.
	 * @param string $texto Texto a ser convertido
	 * @return string Conteudo binario do arquivo MP3
	 */
	public function converter_texto_audio($texto)
	{
		$arquivo_mp3_tmp = tempnam(sys_get_temp_dir(), 'mp3');
		$this->converter_texto_arquivo_audio($texto, $arquivo_mp3_tmp);
		$conteudo = file_get_contents($arquivo_mp3_tmp);
		unlink($arquivo_mp3_tmp);
		return $conteudo;
	}

	/**
	 * Retorna a definicao das configuracoes que podem ser ajustadas
	 * pelo usuario final, para que possam ser criados formularios
	 * genericos e passados para a classe pelo metodo definir_config.
	 * @return array
	 */
	public function obter_definicao_campos_config()
	{
		return array();
	}

}