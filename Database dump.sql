-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.19-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for vacation_module
CREATE DATABASE IF NOT EXISTS `vacation_module` /*!40100 DEFAULT CHARACTER SET latin2 */;
USE `vacation_module`;

-- Dumping structure for table vacation_module.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('employee','admin') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin2;

-- Dumping data for table vacation_module.users: ~2 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
	(1, 'user', '$2y$10$JAwxBCjIBsWVsb8xE63zVOucH/NmT0d.w1Zo69eaL/WjgrYc3NJZu', 'employee'),
	(2, 'admin', '$2y$10$JAwxBCjIBsWVsb8xE63zVOucH/NmT0d.w1Zo69eaL/WjgrYc3NJZu', 'admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table vacation_module.vacations
CREATE TABLE IF NOT EXISTS `vacations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `status` enum('pending','approved','denied') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `FK_vacation_users` (`user_id`),
  CONSTRAINT `FK_vacation_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin2;

-- Dumping data for table vacation_module.vacations: ~1 rows (approximately)
DELETE FROM `vacations`;
/*!40000 ALTER TABLE `vacations` DISABLE KEYS */;
/*!40000 ALTER TABLE `vacations` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
