-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 07 2013 г., 08:22
-- Версия сервера: 5.5.34-0ubuntu0.13.04.1
-- Версия PHP: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `uc_blog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `uc_categories`
--

DROP TABLE IF EXISTS `uc_categories`;
CREATE TABLE IF NOT EXISTS `uc_categories` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `table_lang_id` int(11) NOT NULL,
  `sef` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `order` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `uc_categories_langs`
--

DROP TABLE IF EXISTS `uc_categories_langs`;
CREATE TABLE IF NOT EXISTS `uc_categories_langs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_lang_id` int(11) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `uc_comments`
--

DROP TABLE IF EXISTS `uc_comments`;
CREATE TABLE IF NOT EXISTS `uc_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `uc_comments`
--

INSERT INTO `uc_comments` (`id`, `post_id`, `name`, `url`, `email`, `comment`, `time`, `status`) VALUES
(7, 12, 'funivan', 'funivan.com', 'dev@funivan.com', 'Цікава стаття ;)', 1365171200, 1),
(8, 11, 'Іван', 'ukrcms.com', 'devteam@ukrcms.com', 'тестовий коментар', 1368002628, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `uc_metatags`
--

DROP TABLE IF EXISTS `uc_metatags`;
CREATE TABLE IF NOT EXISTS `uc_metatags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sef` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `uc_metatags`
--

INSERT INTO `uc_metatags` (`id`, `id_sef`) VALUES
(1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `uc_metatags_langs`
--

DROP TABLE IF EXISTS `uc_metatags_langs`;
CREATE TABLE IF NOT EXISTS `uc_metatags_langs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_lang_id` int(11) NOT NULL,
  `lang` varchar(2) CHARACTER SET utf8 NOT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `meta_description` text CHARACTER SET utf8 NOT NULL,
  `meta_keywords` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `uc_pages`
--

DROP TABLE IF EXISTS `uc_pages`;
CREATE TABLE IF NOT EXISTS `uc_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sef` varchar(255) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `template` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `uc_pages`
--

INSERT INTO `uc_pages` (`id`, `sef`, `date`, `published`, `template`) VALUES
(1, 'about-us', NULL, 1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `uc_pages_langs`
--

DROP TABLE IF EXISTS `uc_pages_langs`;
CREATE TABLE IF NOT EXISTS `uc_pages_langs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_lang_id` int(11) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` longtext,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `uc_pages_langs`
--

INSERT INTO `uc_pages_langs` (`id`, `table_lang_id`, `lang`, `title`, `text`, `meta_description`, `meta_keywords`) VALUES
(1, 1, 'ua', 'Про нас', 'СТорінка Про нас', '', ''),
(2, 1, 'en', 'About us', 'Page about us', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `uc_posts`
--

DROP TABLE IF EXISTS `uc_posts`;
CREATE TABLE IF NOT EXISTS `uc_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sef` varchar(255) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `category_id` int(8) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `uc_posts_langs`
--

DROP TABLE IF EXISTS `uc_posts_langs`;
CREATE TABLE IF NOT EXISTS `uc_posts_langs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_lang_id` int(11) NOT NULL,
  `lang` varchar(2) CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `shorttext` text CHARACTER SET utf8 NOT NULL,
  `text` longtext CHARACTER SET utf8 NOT NULL,
  `imageData` text CHARACTER SET utf8 NOT NULL,
  `meta_description` text CHARACTER SET utf8 NOT NULL,
  `meta_keywords` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `uc_settings`
--

DROP TABLE IF EXISTS `uc_settings`;
CREATE TABLE IF NOT EXISTS `uc_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `uc_settings`
--

INSERT INTO `uc_settings` (`id`, `key`, `value`) VALUES
(1, 'slogan', 'UkrCms старається завоювати український вебпрості своєю швидкістю'),
(2, 'blogTitle', 'Мій блог - моя фортеця');

-- --------------------------------------------------------

--
-- Структура таблицы `uc_user`
--

DROP TABLE IF EXISTS `uc_user`;
CREATE TABLE IF NOT EXISTS `uc_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Користувач, параметри користувача' AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `uc_user`
--

INSERT INTO `uc_user` (`id`, `login`, `name`, `password`) VALUES
(1, 'admin', 'Адміністратор', '$2a$10$39a3599d19c24b648c96bOIaErWa7QA5ece.JVBxCMGEMUWDMXw4u');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
