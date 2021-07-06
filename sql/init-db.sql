-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema compracertadb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema compracertadb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `compracertadb` DEFAULT CHARACTER SET utf8 ;
-- -----------------------------------------------------
-- Schema new_schema1
-- -----------------------------------------------------
USE `compracertadb` ;

-- -----------------------------------------------------
-- Table `compracertadb`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(128) NOT NULL,
  `first_name` VARCHAR(128) NOT NULL,
  `last_name` VARCHAR(128) NOT NULL,
  `phone` VARCHAR(32) NULL,
  `cpf` VARCHAR(32) NOT NULL,
  `password` VARCHAR(128) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  `user_type` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`customer` (
  `user_id` INT UNSIGNED NOT NULL,
  `total_spent` DECIMAL UNSIGNED NOT NULL DEFAULT 0,
  `total_bought` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  INDEX `fk_User_copy2_User1_idx` (`user_id` ASC) VISIBLE,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_Customer_User`
    FOREIGN KEY (`user_id`)
    REFERENCES `compracertadb`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`provider`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`provider` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`price_history`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`price_history` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` INT UNSIGNED NOT NULL,
  `value` DECIMAL UNSIGNED NOT NULL,
  `expired_at` DATETIME NULL,
  `divided_max` TINYINT NOT NULL,
  `payment_discount` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_price_history_Product1_idx` (`product_id` ASC) VISIBLE,
  CONSTRAINT `fk_price_history_Product1`
    FOREIGN KEY (`product_id`)
    REFERENCES `compracertadb`.`product` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`product_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`product_type` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`product` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) NOT NULL,
  `provider_id` INT UNSIGNED NOT NULL,
  `rating` TINYINT NOT NULL DEFAULT 0,
  `description` TINYTEXT NULL,
  `sold_qnt` INT NOT NULL DEFAULT 0,
  `active_price_id` INT UNSIGNED NOT NULL,
  `stock` SMALLINT UNSIGNED NOT NULL,
  `product_type_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_Product_seller1_idx` (`provider_id` ASC) VISIBLE,
  INDEX `fk_Product_price_history1_idx` (`active_price_id` ASC) VISIBLE,
  INDEX `fk_product_product_type1_idx` (`product_type_id` ASC) VISIBLE,
  CONSTRAINT `fk_Product_seller1`
    FOREIGN KEY (`provider_id`)
    REFERENCES `compracertadb`.`provider` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Product_price_history1`
    FOREIGN KEY (`active_price_id`)
    REFERENCES `compracertadb`.`price_history` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_product_type1`
    FOREIGN KEY (`product_type_id`)
    REFERENCES `compracertadb`.`product_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`payment_option`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`payment_option` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `default` TINYINT NOT NULL DEFAULT 0,
  `payment_method` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_payment_options_Customer1_idx` (`customer_id` ASC) VISIBLE,
  CONSTRAINT `fk_payment_options_Customer1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `compracertadb`.`customer` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`payment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`payment` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `total` DECIMAL UNSIGNED NOT NULL,
  `payment_options_id` INT UNSIGNED NOT NULL,
  `payment_status` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`, `payment_options_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_Payment_payment_options1_idx` (`payment_options_id` ASC) VISIBLE,
  CONSTRAINT `fk_Payment_payment_options1`
    FOREIGN KEY (`payment_options_id`)
    REFERENCES `compracertadb`.`payment_option` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`address`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`address` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` INT UNSIGNED NOT NULL,
  `street` VARCHAR(64) NOT NULL,
  `neighbour` VARCHAR(64) NOT NULL,
  `number` VARCHAR(16) NOT NULL,
  `zipcode` VARCHAR(32) NOT NULL,
  `city` VARCHAR(64) NOT NULL,
  `state` VARCHAR(64) NOT NULL,
  `country` VARCHAR(64) NOT NULL,
  `owner_name` VARCHAR(128) NOT NULL,
  `owner_phone` VARCHAR(32) NOT NULL,
  `details` VARCHAR(128) NULL,
  `default` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_Address_Customer1_idx` (`customer_id` ASC) VISIBLE,
  CONSTRAINT `fk_Address_Customer1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `compracertadb`.`customer` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`order` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Payment_id` INT UNSIGNED NOT NULL,
  `customer_id` INT UNSIGNED NOT NULL,
  `ordered_at` DATETIME NULL,
  `address_id` INT UNSIGNED NOT NULL,
  `active` TINYINT NOT NULL DEFAULT 1,
  `received` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_Order_Payment1_idx` (`Payment_id` ASC) VISIBLE,
  INDEX `fk_Order_Customer1_idx` (`customer_id` ASC) VISIBLE,
  INDEX `fk_Order_Address1_idx` (`address_id` ASC) VISIBLE,
  CONSTRAINT `fk_Order_Payment1`
    FOREIGN KEY (`Payment_id`)
    REFERENCES `compracertadb`.`payment` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_Customer1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `compracertadb`.`customer` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_Address1`
    FOREIGN KEY (`address_id`)
    REFERENCES `compracertadb`.`address` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`employee`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`employee` (
  `user_id` INT UNSIGNED NOT NULL,
  `total_requests` INT NOT NULL DEFAULT 0,
  `hired_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fired_at` DATETIME NULL DEFAULT NULL,
  INDEX `fk_User_copy2_User1_idx` (`user_id` ASC) VISIBLE,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `User_id_UNIQUE` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_User_copy2_User10`
    FOREIGN KEY (`user_id`)
    REFERENCES `compracertadb`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`admin` (
  `user_id` INT UNSIGNED NOT NULL,
  `expire_at` DATETIME NULL,
  INDEX `fk_User_copy2_User1_idx` (`user_id` ASC) VISIBLE,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_User_copy2_User100`
    FOREIGN KEY (`user_id`)
    REFERENCES `compracertadb`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`employee_orders_assigned`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`employee_orders_assigned` (
  `employee_id` INT UNSIGNED NOT NULL,
  `order_id` INT UNSIGNED NOT NULL,
  `at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`employee_id`, `order_id`),
  INDEX `fk_Employee_has_Order_Order1_idx` (`order_id` ASC) VISIBLE,
  INDEX `fk_Employee_has_Order_Employee1_idx` (`employee_id` ASC) VISIBLE,
  CONSTRAINT `fk_Employee_has_Order_Employee1`
    FOREIGN KEY (`employee_id`)
    REFERENCES `compracertadb`.`employee` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Employee_has_Order_Order1`
    FOREIGN KEY (`order_id`)
    REFERENCES `compracertadb`.`order` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`product_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`product_category` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`payment_method`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`payment_method` (
  `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`order_status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`order_status` (
  `int` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`int`),
  UNIQUE INDEX `int_UNIQUE` (`int` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`order_tracking`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`order_tracking` (
  `id` INT NOT NULL,
  `enter_time` DATETIME NOT NULL,
  `location_zipcode` VARCHAR(16) NOT NULL,
  `order_status` VARCHAR(16) NOT NULL,
  `order_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_order_tracking_order1_idx` (`order_id` ASC) VISIBLE,
  CONSTRAINT `fk_order_tracking_order1`
    FOREIGN KEY (`order_id`)
    REFERENCES `compracertadb`.`order` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`order_products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`order_products` (
  `order_id` INT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL,
  `rating` FLOAT UNSIGNED NULL,
  PRIMARY KEY (`order_id`, `product_id`),
  INDEX `fk_Order_has_Product_Product1_idx` (`product_id` ASC) VISIBLE,
  INDEX `fk_Order_has_Product_Order1_idx` (`order_id` ASC) VISIBLE,
  CONSTRAINT `fk_Order_has_Product_Order1`
    FOREIGN KEY (`order_id`)
    REFERENCES `compracertadb`.`order` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_has_Product_Product1`
    FOREIGN KEY (`product_id`)
    REFERENCES `compracertadb`.`product` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`media`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`media` (
  `Product_id` INT UNSIGNED NOT NULL,
  `path` VARCHAR(45) NOT NULL,
  `ext` VARCHAR(45) NOT NULL,
  `main` TINYINT NOT NULL DEFAULT 0,
  INDEX `fk_media_Product1_idx` (`Product_id` ASC) VISIBLE,
  UNIQUE INDEX `path_UNIQUE` (`path` ASC) VISIBLE,
  CONSTRAINT `fk_media_Product1`
    FOREIGN KEY (`Product_id`)
    REFERENCES `compracertadb`.`product` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`credit_card`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`credit_card` (
  `payment_options_id` INT UNSIGNED NOT NULL,
  `owner_name` VARCHAR(128) NOT NULL,
  `last_digits` VARCHAR(8) NOT NULL,
  `due_date` VARCHAR(8) NOT NULL,
  INDEX `fk_credit_card_payment_options1_idx` (`payment_options_id` ASC) VISIBLE,
  PRIMARY KEY (`payment_options_id`),
  CONSTRAINT `fk_credit_card_payment_options1`
    FOREIGN KEY (`payment_options_id`)
    REFERENCES `compracertadb`.`payment_option` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`account_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`account_type` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`account` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_type_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_account_account_type1_idx` (`account_type_id` ASC) VISIBLE,
  INDEX `fk_account_user1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_account_account_type1`
    FOREIGN KEY (`account_type_id`)
    REFERENCES `compracertadb`.`account_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_account_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `compracertadb`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`user_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`user_type` (
  `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(16) NOT NULL,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`session`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`session` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` VARCHAR(256) NULL,
  `device` VARCHAR(32) NULL,
  `trusted` TINYINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`account_sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`account_sessions` (
  `session_id` INT UNSIGNED NOT NULL,
  `account_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`session_id`, `account_id`),
  INDEX `fk_session_has_account_account1_idx` (`account_id` ASC) VISIBLE,
  INDEX `fk_session_has_account_session1_idx` (`session_id` ASC) VISIBLE,
  CONSTRAINT `fk_session_has_account_session1`
    FOREIGN KEY (`session_id`)
    REFERENCES `compracertadb`.`session` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_session_has_account_account1`
    FOREIGN KEY (`account_id`)
    REFERENCES `compracertadb`.`account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`payment_status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`payment_status` (
  `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`newsletter`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`newsletter` (
  `id` INT NOT NULL,
  `email` VARCHAR(128) NOT NULL,
  `name` VARCHAR(128) NULL,
  `allowed` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`wishlist`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`wishlist` (
  `customer_id` INT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`customer_id`, `product_id`),
  INDEX `fk_Customer_has_Product_Product1_idx` (`product_id` ASC) VISIBLE,
  INDEX `fk_Customer_has_Product_Customer1_idx` (`customer_id` ASC) VISIBLE,
  CONSTRAINT `fk_Customer_has_Product_Customer1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `compracertadb`.`customer` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Customer_has_Product_Product1`
    FOREIGN KEY (`product_id`)
    REFERENCES `compracertadb`.`product` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`product_has_product_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`product_has_product_category` (
  `product_id` INT UNSIGNED NOT NULL,
  `product_category_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`product_id`, `product_category_id`),
  INDEX `fk_product_has_product_category_product_category1_idx` (`product_category_id` ASC) VISIBLE,
  INDEX `fk_product_has_product_category_product1_idx` (`product_id` ASC) VISIBLE,
  CONSTRAINT `fk_product_has_product_category_product1`
    FOREIGN KEY (`product_id`)
    REFERENCES `compracertadb`.`product` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_has_product_category_product_category1`
    FOREIGN KEY (`product_category_id`)
    REFERENCES `compracertadb`.`product_category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `compracertadb`.`token`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compracertadb`.`token` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` VARCHAR(128) NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_token_user1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_token_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `compracertadb`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
