<?php

defined('SYSPATH') or die('No direct script access.');
//CREATE TABLE `payments` (
//	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
//	`client_id` INT(10) UNSIGNED NULL DEFAULT NULL,			плательщик
//	`partner_id` INT(10) UNSIGNED NOT NULL,					партнер-получатель
//	`total_payment_sum` BIGINT(20) UNSIGNED NOT NULL,		сумма платежа
//	`partner_payment_ratio` BIGINT(20) UNSIGNED NOT NULL,	процент партнера
//	`partner_payment_sum` BIGINT(20) UNSIGNED NOT NULL,		сумма партнеру
//	`type` ENUM('payment','input','output') NOT NULL,		тип платежа (вывод с баланса, заброс на баланс)
//	`created_at` INT(10) UNSIGNED NOT NULL,					
//	PRIMARY KEY (`id`)
//)
//COLLATE='utf8_general_ci'
//ENGINE=InnoDB;

class Webconsult_Payment
{
	static function pay($client_id, $payment_sum)
	{
		$partner = ORM::factory('user', $client_id)->
		$db = Database::instance();
		
		$db->begin();
		try {
			DB::insert('users', array())
					->values(
							array(
								'client_id' => $client_id,
								'partner_id' => $partner_id,
				//				'total_payment_sum' => 
									
							)
						);
			DB::insert('users')->values($user2);
			$db->commit();
		}
		catch (Database_Exception $e)
		{
			$db->rollback();
		}	
	}
	
	static function output_money($partner_id, $output_sum)
	{
		
	}
	static function input_money($partner_id, $output_sum)
	{
		
	}
}