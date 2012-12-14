<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'alpha'         => ':field must contain only letters',
	'alpha_dash'    => ':field must contain only numbers, letters and dashes',
	'alpha_numeric' => ':field must contain only letters and numbers',
	'color'         => ':field must be a color',
	'credit_card'   => ':field must be a credit card number',
	'date'          => ':field must be a date',
	'decimal'       => ':field must be a decimal with :param2 places',
	'digit'         => ':field must be a digit',
	'email'         => 'Поле ":field" должно содержать email адрес',
	'email_domain'  => ':field must contain a valid email domain',
	'equals'        => ':field must equal :param2',
	'exact_length'  => ':field must be exactly :param2 characters long',
	'in_array'      => ':field must be one of the available options',
	'ip'            => ':field must be an ip address',
	'matches'       => 'Поле ":field" должно совпадать с полем ":param2"',
	'min_length'    => 'Поле ":field" должно содержать не менее :param2 символов',
	'max_length'    => 'Поле ":field" должно содержать не более :param2 символов',
	'not_empty'     => 'Поле ":field" должно быть заполнено',
	'numeric'       => 'Поле ":field" должно быть числом',
	'phone'         => ':field must be a phone number',
	'range'         => 'Поле ":field" должно содержать число в пределах от :param2 до :param3',
	'regex'         => 'Поле ":field" не удовлетворяет указанному формату',
	'url'           => ':field must be a url',
	'user' => array(
		'name' => array(
			'unique' => "Превед"
		)
	),
);
