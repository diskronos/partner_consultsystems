ALTER TABLE users 
	ADD column `partner_group_id` INT(10) UNSIGNED NOT NULL DEFAULT '1' AFTER `referrer_id`,
	ADD column `balance` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `partner_group_id`;

