<?php
/**
 * Classe para auxiliar na criacao de HTML
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class HTML extends Kohana_HTML {

	private static $nivel_cabecalho = 0;

	/**
	 * Cria um cabecalho em determinado nivel
	 * @param string $conteudo
	 * @return string
	 */
	public static function header($conteudo, array $atributos = array())
	{
		return sprintf('%s%s%s',
			self::start_header($atributos),
			$conteudo,
			self::end_header()
		);
	}

	/**
	 * Retorna o inicio de uma tag de cabecalho
	 * @param array $atributos
	 * @return string
	 */
	public static function start_header(array $atributos = array())
	{
		return sprintf('<h%d%s>',
			min(6, self::$nivel_cabecalho),
			self::attributes($atributos)
		);
	}

	/**
	 * Retorna o fim de uma tag de cabecalho
	 * @return string
	 */
	public static function end_header()
	{
		return sprintf('</h%d>',
			min(6, self::$nivel_cabecalho)
		);
	}

	/**
	 * Delimita o inicio de um bloco de conteudo
	 * @return void
	 */
	public static function start_block()
	{
		self::$nivel_cabecalho += 1;
	}

	/**
	 * Delimita o fim de um bloco de conteudo
	 * @return void
	 */
	public static function end_block()
	{
		self::$nivel_cabecalho -= 1;
	}

	/**
	 * Delimita o inicio de um bloco de ajuda da pagina 
	 * @return string
	 */
	public static function start_help()
	{
		return <<<HTML
<a accesskey="0" class="btn btn-link btn-sm" data-toggle="collapse" href="#ajuda-pagina" aria-expanded="false" aria-controls="ajuda-pagina">
	<i class="glyphicon glyphicon-info-sign"></i> <span class="sr-only">Ajuda desta página</span>
</a>
<div class="collapse" id="ajuda-pagina">
	<div class="alert alert-info" role="alert">
HTML;
	}

	/**
	 * Encerra um bloco de ajuda
	 * @return string
	 */
	public static function end_help()
	{
		return <<<HTML
	</div>
</div>
HTML;
	}
}
