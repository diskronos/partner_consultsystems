ALTER TABLE `payments_client`
	ADD COLUMN `transaction_id` INT(10) NULL DEFAULT NULL AFTER `client_id`;