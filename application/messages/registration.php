<?php

defined('SYSPATH') or die('No direct script access.');

return array(
	'login' => array(
		'not_empty' => 'Это поле не может быть пустым',
		'min_length' => 'В логине от 3 до 16 символов',
		'max_length' => 'В логине от 3 до 16 символов',
		'regex' => 'Используйте только латинские буквы и цифры',
		'in_use' => 'Логин уже используется',
	),
	'password' => array(
		'not_empty' => 'Это поле не может быть пустым',
		'min_length' => 'В пароле от 6 до 18 символов',
		'max_length' => 'В пароле от 6 до 18 символов',
	),
	'password_confirm' => array(
		'not_empty' => 'Это поле не может быть пустым',
		'min_length' => 'В пароле от 6 до 18 символов',
		'max_length' => 'В пароле от 6 до 18 символов',
		'matches' => 'Пароли должны совпадать',
	),
	'email' => array(
		'not_empty' => 'Это поле не может быть пустым',
		'email' => 'Неверно задан адрес email',
	),
	'name' => array(
		'not_empty' => 'Это поле не может быть пустым',
	),
	
);