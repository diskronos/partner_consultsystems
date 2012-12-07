ALTER TABLE `users`
	ADD COLUMN `status` ENUM('legal','individual') NULL DEFAULT 'individual' AFTER `reset_password_code`,
	ADD COLUMN `referrer_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `status`,
	ADD COLUMN `company_name` VARCHAR(255) NULL DEFAULT NULL AFTER `status`;