ALTER TABLE `payments_client`
	ADD CONSTRAINT `client_fk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
