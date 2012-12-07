CREATE TABLE `message_types` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NULL,
	`title` VARCHAR(100) NULL,
	`template` VARCHAR(50) NULL,
	`variables` VARCHAR(50) NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;