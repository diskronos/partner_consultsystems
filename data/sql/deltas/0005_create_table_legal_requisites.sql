CREATE TABLE `legal_requisites` (
	`id` INT(10) UNSIGNED NULL AUTO_INCREMENT,
	`partner_id` INT(10) UNSIGNED NOT NULL,
	`individual_number` VARCHAR(15) NOT NULL,
	`reason_registration_code` VARCHAR(15) NOT NULL,
	`bank` VARCHAR(100) NOT NULL,
	`bank_identification_code` VARCHAR(20) NOT NULL,
	`payment_account` VARCHAR(20) NOT NULL,
	`legal_address` VARCHAR(100) NOT NULL,
	`represented` VARCHAR(50) NOT NULL,
	`on_authority` VARCHAR(50) NOT NULL,
	`fullname` VARCHAR(50) NOT NULL,
	`confirmed` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	CONSTRAINT `legal_requisites_partner_fk1` FOREIGN KEY (`partner_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
