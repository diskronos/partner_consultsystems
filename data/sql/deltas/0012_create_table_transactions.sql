CREATE TABLE `transactions` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`payer_id` INT(10) UNSIGNED NULL DEFAULT NULL,
	`beneficiary_id` INT(10) UNSIGNED NULL DEFAULT NULL,
	`parent_transaction_id` INT(10) UNSIGNED NULL DEFAULT NULL,
	`payer_account_balance` BIGINT(20) NOT NULL,
	`beneficiary_account_balance` BIGINT(20) NOT NULL,
	`beneficiary_account_hold_balance` BIGINT(20) NOT NULL,
	`commentary` VARCHAR(255) NULL DEFAULT NULL,
	`created_at` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `parent_transaction_id` FOREIGN KEY (`parent_transaction_id`) REFERENCES `transactions` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
