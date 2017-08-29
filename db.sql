-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.50 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных test
CREATE DATABASE IF NOT EXISTS `test` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `test`;


-- Дамп структуры для таблица test.movie
CREATE TABLE IF NOT EXISTS `movie` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `year` year(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы test.movie: ~23 rows (приблизительно)
/*!40000 ALTER TABLE `movie` DISABLE KEYS */;
INSERT INTO `movie` (`id`, `title`, `year`) VALUES
	(1, 'Титаник', '1998'),
	(2, 'Побег из Шоушенка', '2001'),
	(3, 'Муви 43', '2007'),
	(4, 'Зеленая миля', '1994'),
	(5, 'Бэтмен', '2004'),
	(7, 'Пираты карибского моря', '2003'),
	(8, 'Властелин колец', '2000'),
	(9, 'Мстители', '2014'),
	(10, 'Рокки', '1986'),
	(11, 'Светлячок', '1992'),
	(12, 'Белое солнце пустыни', '1970'),
	(13, 'Престиж', '2004'),
	(14, 'Воин', '2131'),
	(15, 'Ужасы Амитивиля', '2002'),
	(16, 'Миллионер из трущоб', '2002'),
	(17, 'Один в доме', '2000'),
	(19, 'Викинг', '2001'),
	(20, 'Горько', '2006'),
	(21, 'Молчание ягнят', '1991'),
	(29, 'Трансформеры', '2004'),
	(30, 'Американский пирог', '1999'),
	(31, 'Няньки', '1992'),
	(36, 'Рокки', '2006');
/*!40000 ALTER TABLE `movie` ENABLE KEYS */;


-- Дамп структуры для таблица test.movie_tags
CREATE TABLE IF NOT EXISTS `movie_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `movie_tags_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`),
  CONSTRAINT `movie_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы test.movie_tags: ~38 rows (приблизительно)
/*!40000 ALTER TABLE `movie_tags` DISABLE KEYS */;
INSERT INTO `movie_tags` (`id`, `movie_id`, `tag_id`) VALUES
	(18, 2, 3),
	(25, 1, 2),
	(27, 1, 3),
	(31, 7, 2),
	(32, 11, 1),
	(33, 4, 9),
	(34, 1, 9),
	(44, 14, 4),
	(45, 14, 2),
	(51, 19, 1),
	(58, 29, 2),
	(59, 29, 11),
	(66, 31, 1),
	(67, 31, 12),
	(68, 31, 9),
	(72, 20, 2),
	(73, 20, 1),
	(80, 17, 9),
	(81, 17, 1),
	(82, 17, 2),
	(85, 30, 12),
	(87, 16, 9),
	(91, 5, 2),
	(92, 5, 11),
	(93, 10, 5),
	(95, 3, 4),
	(96, 3, 13),
	(97, 3, 1),
	(98, 8, 1),
	(109, 36, 5),
	(114, 21, 2),
	(115, 21, 13),
	(116, 21, 4),
	(127, 12, 9),
	(128, 12, 1),
	(129, 12, 12),
	(137, 13, 5),
	(138, 13, 9);
/*!40000 ALTER TABLE `movie_tags` ENABLE KEYS */;


-- Дамп структуры для таблица test.tag
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы test.tag: ~10 rows (приблизительно)
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` (`id`, `title`) VALUES
	(20, 'Аниме'),
	(5, 'Боевик'),
	(3, 'Детектив'),
	(9, 'Драма'),
	(1, 'Комедия'),
	(12, 'Мелодрама'),
	(2, 'Приключения'),
	(13, 'Триллер'),
	(4, 'Ужасы'),
	(11, 'Фэнтези');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
