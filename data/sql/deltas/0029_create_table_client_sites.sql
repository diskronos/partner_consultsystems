CREATE TABLE `client_sites` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`client_id` INT(10) UNSIGNED NULL DEFAULT NULL,
	`url` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `client_site_fk1` (`client_id`),
	CONSTRAINT `client_site_fk1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
