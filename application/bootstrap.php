<?php

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('America/Sao_Paulo');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'pt_BR.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('pt-br');

if (isset($_SERVER['SERVER_PROTOCOL']))
{
	// Replace the default protocol.
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if ($_SERVER['HTTP_HOST'] === 'aw.polarisweb.com.br')
{
	Kohana::$environment = Kohana::PRODUCTION;
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url'   => Kohana::$environment === Kohana::PRODUCTION ?  'http://aw.polarisweb.com.br/' : '/audioweb/',
	'index_file' => FALSE,
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);
Kohana::$config->load('audioweb');

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'auth'       => MODPATH.'auth',       // Basic authentication
	// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	'database'   => MODPATH.'database',   // Database access
	'image'      => MODPATH.'image',      // Image manipulation
	'minion'     => MODPATH.'minion',     // CLI Tasks
	'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	));

if (file_exists(__DIR__ . '/segredo.php')) {
	Cookie::$salt = include(__DIR__ . '/segredo.php');
}

// Controller principal
Route::set('principal', 'principal')
	->defaults(array(
		'directory'  => '',
		'controller' => 'principal',
		'action'     => 'index'
	));

// Diretorio de informacoes
Route::set('politica_de_privacidade', 'politica-de-privacidade')
	->defaults(array(
		'directory'  => 'informacoes',
		'controller' => 'politica_privacidade',
		'action'     => 'index'
	));

// Imagens
Route::set('exibir_imagem', 'imagens/<conta>/<nome>(/<tamanho>)', array('conta' => '\d+', 'nome' => '[^\/]+', 'tamanho' => '\d+x\d+'))
	->defaults(array(
		'directory'  => 'audioimagem',
		'controller' => 'imagem',
		'action'     => 'index',
		'tamanho'    => '0x0'
	));

// Listar registros recebendo a pagina
Route::set('listar', '<directory>(/listar(/<pagina>(/<action>)))', array('pagina' => '\d+'))
	->defaults(array(
		'controller' => 'listar',
		'action'     => 'index',
		'pagina'     => 1
	));

// Alterar registro recebendo ID
Route::set('alterar', '<directory>/<controller>/<id>(/<action>)', array('id' => '\d+'))
	->defaults(array(
		'action'     => 'index'
	));

// Acao que nao recebe ID
Route::set('acao_padrao', '<directory>/<controller>(/<action>)')
	->defaults(array(
		'action'     => 'index'
	));

// Default
Route::set('default', '')
	->defaults(array(
		'directory'  => '',
		'controller' => 'apresentacao',
		'action'     => 'index'
	));
