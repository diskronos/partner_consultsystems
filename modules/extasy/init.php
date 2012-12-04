<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

Kohana::$config->attach(new Extasy_Config_Database(), TRUE);

Route::set('admin-index', trim(Kohana::$config->load('extasy.admin_path_prefix'), '/'))
	->defaults(array(
		'directory' => 'admin',
		'controller' => 'index',
		'action'     => 'index',
	));

Route::set('admin-auth', Kohana::$config->load('extasy.admin_path_prefix').'auth/<action>(/<code>)')
	->defaults(array(
		'directory' => 'admin',
		'controller' => 'auth'
	));

Route::set('admin-user', Kohana::$config->load('extasy.admin_path_prefix').'user(/<action>(/<id>))')
	->defaults(array(
		'directory' => 'admin',
		'controller' => 'user',
		'action'     => 'index',
	));

Route::set('admin-config', Kohana::$config->load('extasy.admin_path_prefix').'config(/<action>)')
	->defaults(array(
		'directory' => 'admin',
		'controller' => 'config',
		'action'     => 'index',
	));

Route::set('ajex-file-manager-index', 'ajexFileManager/index.html')
	->defaults(array(
		'controller' => 'ajexfilemanager',
		'action' => 'index'
	));

Route::set('ajex-file-manager-ajax', 'ajexFileManager/ajax/php/ajax.php')
	->defaults(array(
		'controller' => 'ajexfilemanager',
		'action' => 'ajax'
	));

Route::set('error', '__error__/<code>')
	->defaults(array(
		'controller' => 'error',
		'action' => 'index'
	));

Route::set('deploy', 'deploy/<action>')
	->defaults(array(
		'controller' => 'deploy',
	));

Route::set('captcha', 'captcha')
	->defaults(array(
		'controller' => 'captcha',
		'action' => 'index'
	));

function tep_not_null($value)
{
	if (is_array($value))
	{
		if (sizeof($value) > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	else
	{
		if (($value != '') AND (strtolower($value) != 'null') AND (strlen(trim($value)) > 0))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}


if ( ! function_exists('checkdnsrr'))
{
	function checkdnsrr($host, $type)
	{
		if(tep_not_null($host) AND tep_not_null($type))
		{
			@exec("nslookup -type=$type $host", $output);
			while(list($k, $line) = each($output))
			{
				if(eregi("^$host", $line))
				{
					return TRUE;
				}
			}
		}
		return FALSE;
	}
}