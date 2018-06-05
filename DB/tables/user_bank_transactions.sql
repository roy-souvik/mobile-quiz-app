CREATE TABLE `quiz_competition`.`tbl_user_bank_transactions` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `request_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `request_amount` INT NOT NULL ,
  `transaction_date` TIMESTAMP NULL DEFAULT NULL ,
  `transaction_amount` INT NULL DEFAULT NULL ,
  `transaction_status`  TINYINT(6) NOT NULL DEFAULT '0' ,
  `comment` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
