ALTER TABLE `users`
	ADD COLUMN `fullname` VARCHAR(255) NULL DEFAULT NULL AFTER `name`;