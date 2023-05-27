drop database if exists bank;
create database bank;
use bank;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- Create the address table
CREATE TABLE IF NOT EXISTS `address`  (
  `postcode` CHAR(4) NOT NULL,
  `city` VARCHAR(255) NOT NULL,
  `street` VARCHAR(255) NOT NULL,
  `street_number` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`postcode`, `city`)
);

-- Create the user table
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `surname` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone_number` VARCHAR(20),
  `address_postcode` CHAR(4),
  `address_city` VARCHAR(255),
  `password_hash` VARCHAR(255) NOT NULL,
  FOREIGN KEY (`address_postcode`, `address_city`) REFERENCES address(`postcode`, `city`)
);

ALTER TABLE user AUTO_INCREMENT = 1000;

CREATE TABLE IF NOT EXISTS `account` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `assets` BIGINT NOT NULL,
  PRIMARY KEY (`id`, `name`),
  FOREIGN KEY (`id`, `name`) REFERENCES `user`(`id`, `name`)
);


CREATE TABLE IF NOT EXISTS 'subaccount' (

    
);



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;