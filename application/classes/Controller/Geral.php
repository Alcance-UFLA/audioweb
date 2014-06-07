<?php
/**
 * Controller Geral
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Geral extends Controller_Template {
	public $template = 'template_geral';

	/**
	 * {@inheritdoc}
	 */
	public function before()
	{
		parent::before();
		if ($this->auto_render)
		{
			$this->template->head = array();
			$this->template->head['title']   = '';
			$this->template->head['metas']   = array();
			$this->template->head['links']   = array();
			$this->template->head['scripts'] = array();

			$this->adicionar_meta(array('name' => 'Content-Type', 'content' => 'text/html; charset=' . Kohana::$charset));
			$this->adicionar_meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0'));
			$this->adicionar_meta(array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge,chrome=1'));
			$this->adicionar_meta(array('name' => 'MobileOptimized', 'content' => '320'));
			$this->adicionar_meta(array('name' => 'HandheldFriendly', 'content' => 'True'));
			$this->adicionar_style(array('href' => URL::site('css/tb.css')));
			$this->adicionar_script(array('src' => URL::site('js/tb.js')));
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function after()
	{
		if ($this->auto_render)
		{
			if (empty($this->template->head['title']))
			{
				$this->template->head['title'] = 'Audio Imagem';
			}
			else
			{
				$this->template->head['title'] .= ' - Audio Imagem';
			}
		}
		parent::after();
	}

	/**
	 * Define o title da pagina
	 * @param string $title
	 * @return void
	 */
	protected function definir_title($title)
	{
		$this->template->head['title'] = $title;
	}

	/**
	 * Adiciona uma folha de estilo
	 * @param array $link Tupla contendo os atributos da tag LINK
	 * @return void
	 */
	protected function adicionar_style($link)
	{
		if ( ! isset($link['rel']))
		{
			$link['rel'] = 'stylesheet';
		}
		if ( ! isset($link['type']))
		{
			$link['type'] = 'text/css';
		}
		if ( ! isset($link['href']))
		{
			throw new InvalidArgumentException();
		}

		// Checar se ja incluiu a folha de estilo
		foreach ($this->template->head['links'] as $l)
		{
			if (isset($l['rel']) && $l['rel'] == 'stylesheet' && $l['href'] == $link['href'])
			{
				return;
			}
		}

		$this->adicionar_link($link);
	}

	/**
	 * Adiciona um link no HEAD do documento
	 * @param array $link Tupla contendo os atributos da tag LINK
	 * @return void
	 */
	protected function adicionar_link($link)
	{
		if ( ! isset($link['href']))
		{
			throw new InvalidArgumentException();
		}
		$this->template->head['links'][] = $link;
	}

	/**
	 * Adiciona um script no documento
	 * @param array $script Tupla contendo os atributos da tag SCRIPT
	 * @return void
	 */
	protected function adicionar_script($script)
	{
		if ( ! isset($script['type']))
		{
			$script['type'] = 'text/javascript';
		}
		if ( ! isset($script['src']))
		{
			throw new InvalidArgumentException();
		}
		$this->template->head['scripts'][] = $script;
	}

	/**
	 * Adiciona uma meta tag no HEAD do documento
	 * @param array $meta Tupla contendo os atributos da tag META
	 * @param bool $substituir Flag para substituir a meta definida anteriormente com mesma chave.
	 * @return void
	 */
	protected function adicionar_meta($meta, $substituir = TRUE)
	{
		if ($substituir)
		{
			if (isset($meta['name']))
			{
				$chave = 'name';
			}
			elseif (isset($meta['http-equiv']))
			{
				$chave = 'http-equiv';
			}
			elseif (isset($meta['property']))
			{
				$chave = 'property';
			}
			else
			{
				$chave = FALSE;
			}

			if ($chave)
			{
				foreach ($this->template->head['metas'] as $i => $m)
				{
					if (isset($m[$chave]) && $m[$chave] == $meta[$chave])
					{
						$this->template->head['metas'][$i] = $meta;
						return;
					}
				}
			}
		}
		$this->template->head['metas'][] = $meta;
	}
}