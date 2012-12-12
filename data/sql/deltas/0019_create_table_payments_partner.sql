CREATE TABLE `payments_partner` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`client_payment_id` INT(10) UNSIGNED NULL DEFAULT NULL,
	`partner_id` INT(10) UNSIGNED NOT NULL,
	`payment_sum` INT(10) UNSIGNED NOT NULL,
	`status` ENUM('active','holded','reverted') NOT NULL DEFAULT 'holded',
	`commentary` VARCHAR(255) NULL DEFAULT NULL,
	`created_at` INT(10) UNSIGNED NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `client_partner_fk_1` (`client_payment_id`),
	CONSTRAINT `client_partner_fk_1` FOREIGN KEY (`client_payment_id`) REFERENCES `payments_client` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
