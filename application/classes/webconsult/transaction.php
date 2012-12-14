<?php

defined('SYSPATH') or die('No direct script access.');

class Webconsult_Transaction
{
//CREATE TABLE `payments_client` (
//	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
//	`client_id` INT(10) UNSIGNED NOT NULL,
//	`payment_sum` INT(10) UNSIGNED NOT NULL,
//	`status` ENUM('active','holded','reverted') NULL DEFAULT 'holded',
//	`commentary` VARCHAR(255) NULL DEFAULT NULL,
//	`created_at` INT(10) UNSIGNED NOT NULL,
//	PRIMARY KEY (`id`)
//)
//COLLATE='utf8_general_ci'
//ENGINE=InnoDB;

//CREATE TABLE `payments_partner` (
//	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
//	`client_payment_id` INT(10) UNSIGNED NULL DEFAULT NULL,
//	`partner_id` INT(10) UNSIGNED NOT NULL,
//	`payment_sum` INT(10) UNSIGNED NOT NULL,
//	`status` ENUM('active','holded','reverted') NOT NULL DEFAULT 'holded',
//	`commentary` VARCHAR(255) NULL DEFAULT NULL,
//	`created_at` INT(10) UNSIGNED NULL DEFAULT NULL,
//	PRIMARY KEY (`id`),
//	INDEX `client_partner_fk_1` (`client_payment_id`),
//	CONSTRAINT `client_partner_fk_1` FOREIGN KEY (`client_payment_id`) REFERENCES `payments_client` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
//)
//COLLATE='utf8_general_ci'
//ENGINE=InnoDB;
	
	
//CREATE TABLE `payouts` (
//	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
//	`partner_id` INT(10) UNSIGNED NOT NULL,
//	`payout_sum` INT(10) UNSIGNED NOT NULL,
//	`status` ENUM('pending','paid') NOT NULL DEFAULT 'pending',
//	`commentary` VARCHAR(255) NULL DEFAULT NULL,
//	`created_at` INT(10) UNSIGNED NOT NULL,
//	PRIMARY KEY (`id`)
//)
//COLLATE='utf8_general_ci'
//ENGINE=InnoDB;

	static function client_payment($client_id, $payment_sum, $partner_share = TRUE, $status = 'holded', $transaction_id = NULL)
	{
		$db = Database::instance();
		$db->begin();
		$client = ORM::factory('client', $client_id);
		$partner = $client->partner;

		try {
			$transaction_client_to_company = ORM::factory('money_payment_client')
					->values(
							array(
								'client_id' => $client->id,
								'payment_sum' => $payment_sum,
								'commentary' => 'Клиентский платеж',
								'status' => $status,
								'transaction_id' => $transaction_id,
							))
					->save();

			if ($partner->loaded() AND $partner_share)
			{
				$partner_sum = $payment_sum * $partner->partner_group->payout_ratio / 100;
				$transaction_company_to_partner = ORM::factory('money_payment_partner')
						->values(
								array(
									'partner_id' => $partner->id,
									'payment_sum' => $partner_sum,
									'client_payment_id' => $transaction_client_to_company->id,
									'commentary' => $partner->partner_group->payout_ratio . '% процентов за оплату (логин ' . $client->name . ')',
									'status' => $status,
								))
						->save();
				Webconsult_Balance::factory($partner)->set_new_balance();
			}
	//		Webconsult_Balance::factory($client)->set_new_balance();
			$db->commit();
		}
		catch (Database_Exception $e)
		{
			$db->rollback();
			return false;
		}
		return true;
	}
	
	static function money_back($transaction_id)
	{
		$db = Database::instance();
		$db->begin();
		try {
			$transaction_client_to_company = ORM::factory('money_payment_client', $transaction_id);
			$transaction_client_to_company->status = 'reverted';
			$transaction_client_to_company->save();
			$transaction_company_to_partner = $transaction_client_to_company->partner_payment;
			$client = $transaction_client_to_company->client;
			if ($transaction_company_to_partner->loaded())
			{
				$transaction_company_to_partner->status = 'reverted';
				$transaction_company_to_partner->save();
				$partner = $transaction_company_to_partner->partner;
				Webconsult_Balance::factory($partner)->set_new_balance();
			}
	//		Webconsult_Balance::factory($client)->set_new_balance();

			$db->commit();
		}
		catch (Database_Exception $e)
		{
			$db->rollback();
			return false;
		}
		return true;
	}

	static function money_payout_query($partner_id, $payout_sum)
	{
		$db = Database::instance();
		$db->begin();
		$partner = ORM::factory('user', $partner_id);
		try 
		{
			$parent_payout = ORM::factory('money_payout')
						->values(
								array(
									'partner_id' => $partner->id,
									'payout_sum' => $payout_sum,
									'commentary' => 'Вывод средств с баланса (на ' . $partner->requisites->name .')',
								))
						->save();
			Webconsult_Balance::factory($partner)->set_new_balance();
			$db->commit();
		}
		catch (Database_Exception $e)
		{
			$db->rollback();
			return false;
		}
		return true;
	}

	
}