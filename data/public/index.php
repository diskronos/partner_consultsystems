<?php

error_reporting(%ERROR_REPORTING%);

define('EXT', '.php');

define('DOCROOT', '%DOCROOT%/');

define('APPPATH', DOCROOT.'application/');
define('MODPATH', DOCROOT.'modules/');
define('SYSPATH', DOCROOT.'system/');

define('PUBLIC_ROOT', '%PUBLIC_ROOT%/');

define('DOMAIN', '%DOMAIN%');

date_default_timezone_set('%DEFAULT_TIMEZONE%');

if ( ! defined('KOHANA_START_TIME'))
{
	define('KOHANA_START_TIME', microtime(TRUE));
}

if ( ! defined('KOHANA_START_MEMORY'))
{
	define('KOHANA_START_MEMORY', memory_get_usage());
}

require APPPATH.'bootstrap.php';

/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
try
{
$response = Request::factory()
	->execute()
	->send_headers()
	->body();
}
catch (HTTP_Exception $e)
{
	if (Kohana::$environment != Kohana::PRODUCTION)
	{
		throw $e;
	}
	$response = Request::factory(url::url_to_route('error?code='.$e->getCode()))->execute()->send_headers()->body();
}
catch (Exception $e)
{
	if (Kohana::$environment != Kohana::PRODUCTION)
	{
		throw $e;
	}
	$response = Request::factory(url::url_to_route('error?code=500'))->execute()->send_headers()->body();
}

echo $response;