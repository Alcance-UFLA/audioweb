<?php

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT)) {
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
} else {
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

// Load vendor autoload
if (is_file(APPPATH.'vendor/autoload.php')) {
	require APPPATH.'vendor/autoload.php';
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

if (isset($_SERVER['SERVER_PROTOCOL'])) {
	// Replace the default protocol.
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
//Kohana::$environment = Kohana::PRODUCTION;

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
	'base_url'   => 'http://localhost/audioweb/',
	'index_file' => FALSE,
	'profile'    => TRUE,
	'caching'    => FALSE,
	'errors'     => TRUE,
	'expose'     => FALSE,
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
	'auth'         => MODPATH.'auth',         // Basic authentication
	'cache'        => MODPATH.'cache',        // Caching with multiple backends
	//'codebench'    => MODPATH.'codebench',    // Benchmarking tool
	'database'     => MODPATH.'database',     // Database access
	'image'        => MODPATH.'image',        // Image manipulation
	'minion'       => MODPATH.'minion',       // CLI Tasks
	'orm'          => MODPATH.'orm',          // Object Relationship Mapping
	'sintetizador' => MODPATH.'sintetizador', // Sintetizador de fala
	//'unittest'     => MODPATH.'unittest',     // Unit testing
	//'userguide'    => MODPATH.'userguide',    // User guide and API documentation
	));

if (file_exists(__DIR__ . '/segredo.php')) {
	Cookie::$salt = include(__DIR__ . '/segredo.php');
}

require APPPATH.'config/routes'.EXT;