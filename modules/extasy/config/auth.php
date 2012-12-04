<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */
return array(
	'driver' => 'extasy',
	'hash_method'  => 'sha256',
	'hash_key'     => 'hash_key', // TODO: Вынести в настройки куда-либо
	'roles' => array(
		'admin'   => 1,
	),
	'roles_labels' => array(
		'admin' => 'Администратор',
	),
	'form_plugins' => array(
		'admin' => 'Form_Plugin_Auth_Admin'
	)
);