ALTER TABLE `payments_partner`
	DROP FOREIGN KEY `client_partner_fk_1`;
ALTER TABLE `payments_partner`
	ADD CONSTRAINT `client_partner_fk_1` FOREIGN KEY (`client_payment_id`) REFERENCES `payments_client` (`id`) ON UPDATE CASCADE ON DELETE SET NULL;
