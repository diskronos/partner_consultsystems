ALTER TABLE `users`
	ADD COLUMN `money_paidout` INT(10) NOT NULL DEFAULT '0' AFTER `money_earned`;