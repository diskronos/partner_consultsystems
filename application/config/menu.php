<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

return array
(
	Application::NAME => array
	(
		'Войти' => 'admin-auth:login',
		'Сбросить пароль' => 'admin-auth:reset_password_step_1',
		'Служебное' => array(
			'Настройки' => 'admin-config',
			'Пользователи' => 'admin-user',
		),
	)
);