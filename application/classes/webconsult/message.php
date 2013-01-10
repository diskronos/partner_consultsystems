<?php

defined('SYSPATH') or die('No direct script access.');

class Webconsult_Message
{
	static $_types = array(
		'new_ticket'=> 'Новое сообщение из поддержки', 
		'new_payout' => 'Проведена выплата', 
		'new_payment' => 'Новый платеж', 
		'new_level' => 'Новый уровень', 
		'new_client' => 'Зарегистрирован новый клиент'
		);

	static function send($partner_id, $type, $params)
	{
		$user = ORM::factory('user', $partner_id);
		if (!$user->loaded()) return;
		$to = $user->email;
		$from = Kohana::$config->load('mailer.from');
		$template = DOCROOT.
				'data'.DIRECTORY_SEPARATOR.
				'templates'.DIRECTORY_SEPARATOR.
				'messages'.DIRECTORY_SEPARATOR .
				$type . '.html';
		$message = file_get_contents($template);
		foreach ($params as $param_name => $param_value)
		{
			$message = str_replace("%%$param_name%%", $param_value, $message);
		}
		try
		{
			Email::send(
					$to, 
					$from,
					'WebConsult - ' . self::$_types[$type],
					$message,
					true
			);
		}
		catch (ErrorException $e){}
	}
}