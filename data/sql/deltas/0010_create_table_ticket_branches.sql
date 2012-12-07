CREATE TABLE `ticket_branches` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`topic` VARCHAR(250) NOT NULL,
	`starter_id` INT(10) UNSIGNED NOT NULL,
	`status` ENUM('open','closed') NOT NULL DEFAULT 'open',
	`new_messages_admin` INT UNSIGNED NOT NULL DEFAULT '0',
	`new_messages_user` INT UNSIGNED NOT NULL DEFAULT '0',
	`created_at` INT(10) UNSIGNED NOT NULL,
	`updated_at` INT(10) UNSIGNED NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
