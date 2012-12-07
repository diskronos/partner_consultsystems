CREATE TABLE `individual_requisites` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`partner_id` INT(10) UNSIGNED NOT NULL,
	`wmz_purse_number` VARCHAR(50) NOT NULL,
	`confirmed` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`),
	CONSTRAINT `individual_requisites_partner_fk1` FOREIGN KEY (`partner_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
