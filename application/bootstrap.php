<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

Cookie::$salt = 'cookie_salt';

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
	'index_file' => '',
	'profile' => Kohana::$environment != Kohana::PRODUCTION
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'static_page' => MODPATH.'static_page',
	'docx' => MODPATH.'docx',
	'image'      => MODPATH.'image',
	'imagemagick_driver'      => MODPATH.'imagemagick_driver',
	'email'      => MODPATH.'email',
	'extasy'     => MODPATH.'extasy',
	'pagination' => MODPATH.'pagination',
	'auth'       => MODPATH.'auth',       // Basic authentication
	'cache'      => MODPATH.'cache',      // Caching with multiple backends
	'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	'database'   => MODPATH.'database',   // Database access
	'image'      => MODPATH.'image',      // Image manipulation
	'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	'unittest'   => MODPATH.'unittest',   // Unit testing
	'logger' => MODPATH.'logger',
	'downloader' => MODPATH.'downloader',
	'grabber' => MODPATH.'grabber',
));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
//---------------------Админка{-------------------------------------------------
Route::set('admin-ticket_branch', Kohana::$config->load('extasy.admin_path_prefix').'ticket(/<action>(/<id>))')
	->defaults(array(
		'directory' => 'admin',
		'controller' => 'ticket_branch',
		'action' => 'index',
	));


Route::set('admin-promo', Kohana::$config->load('extasy.admin_path_prefix').'promo(/<action>)')
	->defaults(array(
		'directory' => 'admin',
		'controller' => 'promo',
		'action' => 'edit',
	));

Route::set('admin-message_type', Kohana::$config->load('extasy.admin_path_prefix').'message/type(/<action>(/<id>))')
	->defaults(array(
		'directory' => 'admin',
		'controller' => 'message_type',
		'action' => 'index',
	));


Route::set('admin-partner_requisites_moderate', Kohana::$config->load('extasy.admin_path_prefix').'partner/requisites/moderate(/<action>(/<id>))')
	->defaults(array(
		'directory' => 'admin',
		'controller' => 'partner_requisites_moderate',
		'action' => 'index',
	));

Route::set('admin-partner_requisites_edit', Kohana::$config->load('extasy.admin_path_prefix').'partner/requisites/<id>/edit')
	->defaults(array(
		'directory' => 'admin',
		'controller' => 'partner_requisites_edit',
		'action' => 'edit',
	));

Route::set('admin-partner_group', Kohana::$config->load('extasy.admin_path_prefix') . 'partner/group(/<action>(/<id>))')
	->defaults(array(
		'directory' => 'admin',
		'controller' => 'partner_group',
		'action' => 'index',
	));
//---------------------}Админка-------------------------------------------------

//---------------------Кабинет{-------------------------------------------------
Route::set('site-cabinet_statistics', 'cabinet/statistics(/<action>)')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'cabinet_statistics',
		'action' => 'index',
	));

Route::set('site-cabinet_clients', 'cabinet/clients(/<action>)')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'cabinet_clients',
		'action' => 'index',
	));

Route::set('site-cabinet_accounting', 'cabinet/accounting(/<action>)')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'cabinet_accounting',
		'action' => 'index',
	));

Route::set('site-cabinet_support', 'cabinet/support(/<action>(/<id>))')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'cabinet_support',
		'action' => 'index',
	));
//---------------------}Кабинет-------------------------------------------------
//----------------------Шаблоны-------------------------------------------------

Route::set('site-template_doc', 'documents/<name>.doc')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'template',
		'action' => 'generate_doc'
	));

//----------------------Шаблоны-------------------------------------------------

//-----------------------------------------------------------------------------
Route::set('site-additional', 'additional(/<action>)')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'additional',
	));

//---------------------Регистрация{---------------------------------------------
Route::set('site-registration_remp', 'remember_password/<code>')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'registration',
		'action' => 'reset_password_2'
	));

Route::set('site-registration', 'registration(/<action>)')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'registration',
	));

//Route::set('site-signup', 'signup')
//	->defaults(array(
//		'directory' => 'site',
//		'controller' => 'registration',
//		'action' => 'signup'
//	));
Route::set('site-profile', 'profile')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'profile',
		'action' => 'index',
	));

//---------------------}Регистрация---------------------------------------------

//---------------------Глобальные{----------------------------------------------
Route::set('site-cabinet', 'cabinet(/<action>)')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'cabinet',
		'action' => 'index'
	));

Route::set('site-index', '')
	->defaults(array(
		'directory' => 'site',
		'controller' => 'index',
		'action' => 'index'
	));
//---------------------}Глобальные----------------------------------------------

Route::set('files', '<file>', array('file' => '.*'))
	->defaults(array(
		'directory' => 'extasy',
		'controller' => 'file',
		'action' => 'get'
	));