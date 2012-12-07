CREATE TABLE `ticket_messages` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`author_id` INT(10) UNSIGNED NOT NULL,
	`message_text` TEXT NOT NULL,
	`branch_id` INT UNSIGNED NOT NULL,
	`created_at` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `ticket_branch_fk` FOREIGN KEY (`branch_id`) REFERENCES `ticket_branches` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
