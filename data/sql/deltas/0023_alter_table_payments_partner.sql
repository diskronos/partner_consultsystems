ALTER TABLE `payments_partner`
	CHANGE COLUMN `payment_sum` `payment_sum` INT(10) NOT NULL AFTER `partner_id`;