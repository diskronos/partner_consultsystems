CREATE TABLE `payouts` (
	`id` INT(10) UNSIGNED NULL AUTO_INCREMENT,
	`partner_id` INT(10) UNSIGNED NOT NULL,
	`payout_sum` INT(10) UNSIGNED NOT NULL,
	`status` ENUM('pending','paid') NOT NULL DEFAULT 'pending',
	`commentary` VARCHAR(255) NULL DEFAULT NULL,
	`created_at` INT UNSIGNED NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
