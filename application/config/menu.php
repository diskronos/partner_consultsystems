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
			'Промо' => 'admin-promo',
		),
		'Партнеры' => array(
			'Группы' => 'admin-partner_group',
			'Реквизиты на модерации' => 'admin-partner_requisites_moderate',
		),
		'Сообщения' => array(
			'Типы сообщений' => 'admin-message_type:index',
			'Поддержка' => 'admin-ticket_branch'
		),
		'Финансы' => array(
			'Выплаты' => 'admin-money_payout',
			'Клиентские платежи' => 'admin-money_payment_client',
		//	'Партнерские отчисления' => 'admin-money_payment_partner',
		),
	),
);