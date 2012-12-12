CREATE TABLE `payments_client` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`client_id` INT(10) UNSIGNED NOT NULL,
	`payment_sum` INT(10) UNSIGNED NOT NULL,
	`status` ENUM('active','holded','reverted') NULL DEFAULT 'holded',
	`commentary` VARCHAR(255) NULL DEFAULT NULL,
	`created_at` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
