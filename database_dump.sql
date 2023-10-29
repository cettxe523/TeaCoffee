-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.1.48-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных coffee-shop
CREATE DATABASE IF NOT EXISTS `coffee-shop` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `coffee-shop`;

-- Дамп структуры для таблица coffee-shop.carts
CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catalog_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `catalog_id` (`catalog_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_catalog_id` FOREIGN KEY (`catalog_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы coffee-shop.carts: ~0 rows (приблизительно)

-- Дамп структуры для таблица coffee-shop.catalog
CREATE TABLE IF NOT EXISTS `catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `img` longtext NOT NULL,
  `description` varchar(191) NOT NULL DEFAULT '',
  `price` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы coffee-shop.catalog: ~4 rows (приблизительно)
INSERT INTO `catalog` (`id`, `title`, `img`, `description`, `price`) VALUES
	(1, 'Латте', 'https://grizly.club/uploads/posts/2023-02/1675666685_grizly-club-p-stakanchik-kofe-klipart-7.png', 'Вкусный латте', 199),
	(2, 'Капучино', 'https://clipart-library.com/img/1403777.png', 'Вкусный капучино', 229),
	(3, 'Мокачино', 'https://grizly.club/uploads/posts/2023-02/1675666685_grizly-club-p-stakanchik-kofe-klipart-7.png', 'Вкусный Мокачино', 249),
	(4, 'Эспрессо', 'https://clipart-library.com/img/1403777.png', 'Вкусный Эспрессо', 199);

-- Дамп структуры для таблица coffee-shop.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `articles` varchar(50) NOT NULL DEFAULT '',
  `sum` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_user_id_orders` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы coffee-shop.orders: ~0 rows (приблизительно)

-- Дамп структуры для таблица coffee-shop.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(191) DEFAULT '',
  `fio` varchar(191) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы coffee-shop.users: ~0 rows (приблизительно)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
