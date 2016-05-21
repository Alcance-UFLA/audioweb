<?php
/**
 * Controller Geral
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Geral extends Controller_Template {
	public $template = 'template_geral';

	/**
	 * Flag que garante que a action especificou se precisa de autenticação ou não.
	 * @var bool
	 */
	public $action_requer_autenticacao;

	/**
	 * Flag para compactar o HTML enviado para o cliente.
	 * 0 = nao remove nada
	 * 1 = remove apenas espacos/quebras de linha em sequencia
	 * 2 = remove quebras de linha
	 * @var int
	 */
	public $compactar;

	/**
	 * Flag para usar ETag para minimizar trafego de dados repetidos.
	 * @var bool | string
	 */
	public $etag;

	/**
	 * Flag para usar exibir os scripts no head do documento
	 * @var bool
	 */
	public $exibir_scripts_head = false;

	/**
	 * {@inheritdoc}
	 */
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);

		$this->compactar = Kohana::$config->load('audioweb.compactar_html');
		$this->etag = Kohana::$config->load('audioweb.usar_etag');
	}

	/**
	 * {@inheritdoc}
	 */
	public function before()
	{
		$this->auto_render = ! $this->request->is_ajax();
		if ($this->auto_render) {
			parent::before();
			$this->template->set_global('request_time', $_SERVER['REQUEST_TIME']);
			$this->template->set_global('usuario_logado', Auth::instance()->logged_in() ? Auth::instance()->get_user()->as_array() : null);
			$this->template->set_global('debug', Kohana::$environment == Kohana::DEVELOPMENT);

			$this->template->pagina = array();
			$this->template->pagina['titulo'] = '';
			$this->template->pagina['tipo'] = 'WebPage';

			$this->template->head = array();
			$this->template->head['title']   = '';
			$this->template->head['metas']   = array();
			$this->template->head['links']   = array();
			$this->template->head['scripts'] = array();
			$this->template->head['exibir_scripts_head'] = $this->exibir_scripts_head;

			$this->template->content = '';

			$lang = preg_replace_callback(
				'/^([a-z]+?)(\-[a-z]+)?$/i',
				function($matches) {
					return $matches[1] . (isset($matches[2]) ? strtoupper($matches[2]) : '');
				},
				I18n::$lang
			);
			$this->adicionar_meta_schema('inLanguage', $lang);
			$this->adicionar_meta_schema('accessibilityAPI', 'ARIA');

			$this->adicionar_meta(array('name' => 'Content-Type', 'content' => 'text/html; charset=' . Kohana::$charset));
			$this->adicionar_meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0'));
			$this->adicionar_meta(array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge,chrome=1'));
			$this->adicionar_meta(array('name' => 'MobileOptimized', 'content' => '320'));
			$this->adicionar_meta(array('name' => 'HandheldFriendly', 'content' => 'True'));

			$this->adicionar_style(URL::cdn('css/tb.min.css'));
			$this->adicionar_script(URL::cdn('js/tb.min.js'));
			$this->adicionar_link(array('rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => URL::cdn('favicon.ico')));
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function after()
	{
		if ($this->action_requer_autenticacao === NULL) {
			throw new LogicException('Action nao especificou se precisa de autenticacao');
		}

		$type = $this->response->headers('content-type');
		if (is_string($type) && $type != 'text/html') {
			$this->auto_render = false;
		}

		// Definir title
		if ($this->auto_render) {
			if (empty($this->template->head['title'])) {
				$this->template->head['title'] = 'AudioWeb';
			} else {
				$this->template->head['title'] .= ' - AudioWeb';
			}
		}

		parent::after();

		// Compactar
		if ($this->auto_render) {
			switch ($this->compactar) {
			case 1:
				$body = $this->response->body();
				$body = preg_replace('/(\s)\s+/m', '$1', $body);
				$this->response->body($body);
				unset($body);
				break;

			case 2:
				$body = $this->response->body();
				$pos = strpos($body, "\n");
				if ($pos !== false) {
					$body = substr($body, 0, $pos + 1) .
							strtr(preg_replace('/(\s)\s+/m', '$1', substr($body, $pos + 1)), array("\r" => '', "\n" => ''));
				} else {
					$body = strtr(preg_replace('/(\s)\s+/m', '$1', $body), array("\r" => '', "\n" => ''));
				}
				$this->response->body($body);
				unset($body);
				break;
			}
		}

		// ETAG
		if ($this->etag) {
			$etag_request = trim($this->request->headers('if-none-match'), '"');
			if (is_string($this->etag)) {
				$etag_response = $this->etag;
			} elseif ($this->auto_render) {
				$etag_response = sha1(
					Kohana::$config->load('audioweb.versao') .
					'#' .
					Kohana::VERSION .
					'#' .
					serialize($this->template)
				);
			} else {
				$etag_response = sha1(
					Kohana::$config->load('audioweb.versao') .
					'#' .
					Kohana::VERSION .
					'#' .
					$this->response->body()
				);
			}

			$this->response->headers('ETag', sprintf('"%s"', $etag_response));
			if ($etag_request === $etag_response) {
				$this->response->body('');
				$this->response->status(304);
				$this->response->send_headers();
				exit(0);
			}
		}
	}

	/**
	 * Redireciona o usuario para a tela de login, caso nao esteja autenticado
	 * @return void
	 */
	public function requerer_autenticacao($action_requer_autenticacao = true)
	{
		$this->action_requer_autenticacao = (bool)$action_requer_autenticacao;
		if ($this->action_requer_autenticacao && ! Auth::instance()->logged_in()) {
			if ($this->request->is_ajax()) {
				throw new RuntimeException('Ação requer usuário autenticado.');
			}
			$mensagens = array('atencao' => 'Você acessou uma página que requer autenticação. Informe seu usuário e senha ou então efetue um cadastro.');
			Session::instance()->set('flash_message', $mensagens);
			HTTP::redirect('autenticacao/autenticar' . URL::query(array()));
		}
	}

	/**
	 * Define o tipo de pagina de acordo com o schema.org
	 * @param string $tipo
	 * @see <https://schema.org/WebPage>
	 * @return void
	 */
	public function definir_tipo_pagina($tipo)
	{
		$this->template->pagina['tipo'] = $tipo;
	}

	/**
	 * Define o title da pagina
	 * @param string $title
	 * @return void
	 */
	public function definir_title($title)
	{
		$this->template->head['title'] = $title;
		$this->template->pagina['meta']['name'] = $title;
	}

	/**
	 * Adiciona uma meta tag relacionada ao schema.org
	 * @param string $itemprop Propriedade da pagina
	 * @param string $content Conteudo da propriedade
	 * @param bool $sobrescrever Flag para sobrescrever a propriedade ou incluir uma nova (colecao)
	 * @return void
	 */
	public function adicionar_meta_schema($itemprop, $content, $sobrescrever = true)
	{
		if ($sobrescrever) {
			$this->template->pagina['meta'][$itemprop] = $content;
		} else {
			if ( ! isset($this->template->pagina['meta'][$itemprop])) {
				$this->template->pagina['meta'][$itemprop] = array();
			}
			$this->template->pagina['meta'][$itemprop][] = $content;
		}
	}

	/**
	 * Define a description da pagina.
	 * @param string $description
	 * @return void
	 */
	public function definir_description($description)
	{
		$this->adicionar_meta(array(
			'name' => 'description',
			'content' => $description
		));
	}

	/**
	 * Define a meta robots da pagina.
	 * @param string $robots
	 * @return void
	 */
	public function definir_robots($robots)
	{
		$this->adicionar_meta(array(
			'name' => 'robots',
			'content' => $robots
		));
	}

	/**
	 * Define a url canonica da pagina
	 * @param string $url_canonical
	 * @return void
	 */
	public function definir_canonical($url_canonical)
	{
		$this->adicionar_link(array(
			'rel' => 'canonical',
			'href' => $url_canonical
		));
	}

	/**
	 * Adiciona uma folha de estilo
	 * @param array | string $link Tupla contendo os atributos da tag LINK ou uma string com a URL
	 * @return void
	 */
	public function adicionar_style($link)
	{
		if (is_string($link)) {
			$link = array('href' => $link);
		}

		if ( ! isset($link['rel'])) {
			$link['rel'] = 'stylesheet';
		}
		if ( ! isset($link['type'])) {
			$link['type'] = 'text/css';
		}
		if ( ! isset($link['href'])) {
			throw new InvalidArgumentException();
		}

		// Checar se ja incluiu a folha de estilo
		foreach ($this->template->head['links'] as $l) {
			if (isset($l['rel']) && $l['rel'] == 'stylesheet' && $l['href'] == $link['href']) {
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
	public function adicionar_link($link)
	{
		if ( ! isset($link['href'])) {
			throw new InvalidArgumentException();
		}
		$this->template->head['links'][] = $link;
	}

	/**
	 * Adiciona um script no documento
	 * @param array | string $script Tupla contendo os atributos da tag SCRIPT ou uma string com a URL
	 * @return void
	 */
	public function adicionar_script($script)
	{
		if (is_string($script)) {
			$script = array('src' => $script);
		}

		if ( ! isset($script['type'])) {
			$script['type'] = 'text/javascript';
		}
		if ( ! isset($script['src'])) {
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
	public function adicionar_meta($meta, $substituir = TRUE)
	{
		if ($substituir) {
			if (isset($meta['name'])) {
				$chave = 'name';
			} elseif (isset($meta['http-equiv'])) {
				$chave = 'http-equiv';
			} elseif (isset($meta['property'])) {
				$chave = 'property';
			} else {
				$chave = FALSE;
			}

			if ($chave) {
				foreach ($this->template->head['metas'] as $i => $m) {
					if (isset($m[$chave]) && $m[$chave] == $meta[$chave]) {
						$this->template->head['metas'][$i] = $meta;
						return;
					}
				}
			}
		}
		$this->template->head['metas'][] = $meta;
	}
}