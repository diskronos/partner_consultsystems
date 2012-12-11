ALTER TABLE `transactions`
	ADD COLUMN `status` ENUM('active','reverted','revert') NOT NULL DEFAULT 'active' AFTER `beneficiary_account_hold_balance`,
	ADD COLUMN `type` ENUM('client_payment','company_payment') NOT NULL DEFAULT 'client_payment' AFTER `status`;