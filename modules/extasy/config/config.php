<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

return array(
	'reload_time' => 60,
	'form' => array(
		'priorities' => array(
			'Авторизация' => 100
		),
		'fieldgroups' => array(
			'Авторизация' => array(
				'auth_ban.max_login_attempts' => array(
					'label' => 'Кол-во попыток логина',
					'field' => new CM_Field_Int(),
				),
				'auth_ban.base_time' => array(
					'label' => 'Время бана при исчерпании попыток, сек.',
					'field' => new CM_Field_Int(),
				),
				'auth_ban.time_multiplier' => array(
					'label' => 'Множитель времени бана',
					'field' => new CM_Field_Int(),
				)
			)
		)
	)
);