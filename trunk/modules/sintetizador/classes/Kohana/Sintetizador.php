<?php
/**
 * Classe responsavel por gerar um objeto text-to-speech.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
abstract class Kohana_Sintetizador {

	/**
	 * Instancia singleton
	 * @var Kohana_Sintetizador
	 */
	protected static $_instance;

	/**
	 * Configuracoes para o sintetizador
	 * @var Config_Group
	 */
	protected $_config;

	public static function instance()
	{
		if (self::$_instance === NULL)
		{
			$config = Kohana::$config->load('sintetizador');
			$tipo = $config->get('driver');
			$classe = 'Sintetizador_'.ucfirst($tipo);
			self::$_instance = new $classe($config);
		}
		return self::$_instance;
	}

	/**
	 * Construtor padrao
	 * @param Config_Group $config Configuracoes para o sintetizador
	 */
	public function __construct($config = array())
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
	public function definir_config(array $config)
	{
		$definicao_campos_config = $this->obter_definicao_campos_config();
		foreach ($config as $parametro => $valor)
		{
			if ( ! isset($definicao_campos_config[$parametro]))
			{
				throw new InvalidArgumentException('Parametro invalido: ' . $parametro);
			}
			$this->_config[$parametro] = $valor;
		}
	}

	/**
	 * Converte um texto em um arquivo de som MP3.
	 * @param string $texto
	 * @param string $arquivo_saida
	 * @return void
	 */
	abstract public function converter_texto_arquivo($texto, $arquivo_saida);

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