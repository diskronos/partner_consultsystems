<?php

defined('SYSPATH') or die('No direct script access.');

class Webconsult_Transaction
{
//CREATE TABLE `transactions` (
//	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
//	`payer_id` INT(10) UNSIGNED NULL DEFAULT NULL,
//	`beneficiary_id` INT(10) UNSIGNED NULL DEFAULT NULL,
//	`parent_transaction_id` INT(10) UNSIGNED NULL DEFAULT NULL,
//	`payer_account_balance` BIGINT(20) NOT NULL,
//	`beneficiary_account_balance` BIGINT(20) NOT NULL,
//	`beneficiary_account_hold_balance` BIGINT(20) NOT NULL,
//	`status` ENUM('active','reverted','revert') NOT NULL DEFAULT 'active',
//	`type` ENUM('client_payment','company_payment') NOT NULL DEFAULT 'client_payment',
//	`commentary` VARCHAR(255) NULL DEFAULT NULL,
//	`created_at` INT(10) UNSIGNED NOT NULL,
//	PRIMARY KEY (`id`),
//	INDEX `parent_transaction_id` (`parent_transaction_id`),
//	CONSTRAINT `parent_transaction_id` FOREIGN KEY (`parent_transaction_id`) REFERENCES `transactions` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
//)
//COLLATE='utf8_general_ci'
//ENGINE=InnoDB

	
	
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

	static function client_payment($client_id, $payment_sum)
	{
		$db = Database::instance();
		$db->begin();
		$client = ORM::factory('user', $client_id);
		try {
			$transaction_client_to_company = ORM::factory('money_transaction')
					->values(
							array(
								'payer_id' => $client->id,
								'payer_account_balance' => '-' . $payment_sum,
								'beneficiary_account_balance' => $payment_sum,
								'beneficiary_account_hold_balance' => 0,
								'type' => 'client_payment'
							))
					->save();

			$client->balance -=$payment_sum;
			$client->save();

			if ($client->partner->loaded())
			{
				$parner_sum = $payment_sum * $client->partner->partner_group->payout_ratio / 100;
				$transaction_company_to_partner = ORM::factory('money_transaction')
						->values(
								array(
									'beneficiary_id' => $client->partner->id,
									'payer_account_balance' => '-' . $parner_sum,
									'beneficiary_account_balance' => 0,
									'beneficiary_account_hold_balance' => $parner_sum,
									'parent_transaction_id' => $transaction_client_to_company->id,
									'type' => 'company_payment',
									'commentary' => $client->id,
								))
						->save();

				$client->partner->balance += $parner_sum;
				$client->partner->save();
				
			}
			$db->commit();
		}
		catch (Database_Exception $e)
		{
//			var_dump($e);die();
			$db->rollback();
		}
		
	}
	
	static function money_back($transaction_id)
	{
		$db = Database::instance();
		$db->begin();
		try {
			$db->commit();
		}
		catch (Database_Exception $e)
		{
			$db->rollback();
		}

	}

	static function money_payout_query($partner_id, $payout_sum)
	{
		$partner = ORM::factory('user', $partner_id);
		$parent_payout = ORM::factory('money_payout')
					->values(
							array(
								'partner_id' => $partner->id,
								'payout_sum' => $payout_sum,
							))
					->save();
	}
}