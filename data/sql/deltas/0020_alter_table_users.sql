ALTER TABLE `users`
	ADD COLUMN `money_earned` INT(10) NOT NULL DEFAULT '0' AFTER `balance`;
