<?php
/**
 * Classe para auxiliar na criacao de URLs
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class URL extends Kohana_URL {

	/**
	 * Cria uma URL para ser buscada em algum dominio CDN
	 * (Content Delivery Network)
	 * @param string $path
	 * @param string $protocol
	 * @return string
	 */
	public static function cdn($path, $protocol = NULL)
	{
		// Start with the configured base URL
		$base_url = Kohana::$config->load('audioweb.cdn');

		$url_parts = parse_url($base_url);

		if ($protocol)
		{
			$url_parts['scheme'] = $protocol;
		}

		if ( ! isset($url_parts['path']))
		{
			$url_parts['path'] = '';
		}
		$url_parts['path'] = rtrim($url_parts['path'], '/') . '/' . ltrim($path, '/');

		return self::build_url($url_parts);
	}

	/**
	 * Montar uma URL a partir de suas partes
	 * @param array $url_parts
	 * @return string
	 */
	public static function build_url($url_parts)
	{
		$url = '';
		if (isset($url_parts['scheme']))
		{
			$url .= $url_parts['scheme'] . '://';
		}
		if (isset($url_parts['user']) && isset($url_parts['pass']))
		{
			$url .= $url_parts['user'] . ':' . $url_parts['pass'] . '@';
		}
		if (isset($url_parts['host']))
		{
			$url .= $url_parts['host'];
		}
		if (isset($url_parts['port']))
		{
			$url .= ':' . $url_parts['port'];
		}
		if (isset($url_parts['path']))
		{
			$url .= $url_parts['path'];
		}
		if (isset($url_parts['query']))
		{
			$url .= '?' . $url_parts['query'];
		}
		if (isset($url_parts['fragment']))
		{
			$url .= '#' . $url_parts['fragment'];
		}
		return $url;
	}
}