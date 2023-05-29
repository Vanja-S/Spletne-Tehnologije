drop database if exists bank;
create database bank;
use bank;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `user` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `surname` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone_number` VARCHAR(20),
  `address_postcode` INT(4),
  `address_city` VARCHAR(255),
  `address_street` CHAR(255),
  `password_hash` VARCHAR(255) NOT NULL
);

ALTER TABLE user AUTO_INCREMENT = 1000;

CREATE TABLE IF NOT EXISTS `account` (
  `id` INT NOT NULL,
  `assets` BIGINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `user`(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` BIGINT AUTO_INCREMENT,
  `receiver_id` INT NOT NULL,
  `sender_id` INT NOT NULL,
  `amount` BIGINT NOT NULL,
  `date` DATE NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`receiver_id`) REFERENCES `user`(`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`sender_id`) REFERENCES `user`(`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

ALTER TABLE transaction AUTO_INCREMENT = 100000;

INSERT INTO `user`(`name`, `surname`, `email`, `password_hash`) VALUES("Jože", "Oblak", "joze.oblak@gmail.com", "88122a178462e9f08693dcfe7ca97fae180a6b7f6f32127799d7ef8291944396");
INSERT INTO `user`(`name`, `surname`, `email`, `password_hash`) VALUES("Jure", "Smole", "jure.smole@gmail.com", "79261cd27ba032f51dc17b179361597c6fad79f6b0a5a824994aaaae601934e6");

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;