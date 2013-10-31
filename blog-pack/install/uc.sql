-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2013 at 11:29 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uc`
--

-- --------------------------------------------------------

--
-- Table structure for table `uc_categories`
--

DROP TABLE IF EXISTS `uc_categories`;
CREATE TABLE IF NOT EXISTS `uc_categories` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `sef` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `order` smallint(6) NOT NULL DEFAULT '0',
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `uc_categories`
--

INSERT INTO `uc_categories` (`id`, `title`, `sef`, `description`, `status`, `order`, `meta_description`, `meta_keywords`) VALUES
(1, 'Новини', 'news', 'Новини - це наче ковток свіжого повітря, саме вони підтримують Вас у тонусі.', 1, 0, 'Новини - це наче ковток свіжого повітря, саме вони підтримують Вас у тонусі.', 'новини, популярні новини'),
(5, 'Цікаво знати', 'cikavo-znatu', 'Тестові дані важлива штука. Вони допомагають показати красу дизайну', 1, 0, 'Тестові дані важлива штука. Вони допомагають показати красу дизайну', 'тестова категорія, тестові дані, метатеги');

-- --------------------------------------------------------

--
-- Table structure for table `uc_comments`
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
-- Dumping data for table `uc_comments`
--

INSERT INTO `uc_comments` (`id`, `post_id`, `name`, `url`, `email`, `comment`, `time`, `status`) VALUES
(7, 12, 'funivan', 'funivan.com', 'dev@funivan.com', 'Цікава стаття ;)', 1365171200, 1),
(8, 11, 'Іван', 'ukrcms.com', 'devteam@ukrcms.com', 'тестовий коментар', 1368002628, 1);

-- --------------------------------------------------------

--
-- Table structure for table `uc_metatags`
--

DROP TABLE IF EXISTS `uc_metatags`;
CREATE TABLE IF NOT EXISTS `uc_metatags` (
  `id` varchar(40) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uc_metatags`
--

INSERT INTO `uc_metatags` (`id`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
('mainpage', 'UkrCms - швидко і красиво', 'UkrCms - швидко і красиво', 'цмс, українська цмс');

-- --------------------------------------------------------

--
-- Table structure for table `uc_pages`
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
-- Dumping data for table `uc_pages`
--

INSERT INTO `uc_pages` (`id`, `sef`, `date`, `published`, `template`) VALUES
(1, 'abouts-as', NULL, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `uc_pages_langs`
--

DROP TABLE IF EXISTS `uc_pages_langs`;
CREATE TABLE IF NOT EXISTS `uc_pages_langs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `uc_posts`
--

DROP TABLE IF EXISTS `uc_posts`;
CREATE TABLE IF NOT EXISTS `uc_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `sef` varchar(255) DEFAULT NULL,
  `shorttext` text NOT NULL,
  `text` longtext,
  `imageData` text NOT NULL,
  `date` int(11) DEFAULT NULL,
  `category_id` int(8) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `uc_posts`
--

INSERT INTO `uc_posts` (`id`, `title`, `sef`, `shorttext`, `text`, `imageData`, `date`, `category_id`, `published`, `meta_description`, `meta_keywords`) VALUES
(9, 'Україна - чудова країна', 'ukraine', '<p>Украї́на — держава у Східній Європі, у південно-західній частині Східноєвропейської рівнини. Площа становить 603 628 км². Друга країна за величиною на європейському континенті після Росії та найбільша країна, чия територія повністю лежить в Європі[3]. Межує з Росією на сході і північному сході, Білоруссю на півночі, Польщею, Словаччиною та Угорщиною — на заході, Румунією та Молдовою — на південному заході. На півдні і південному сході омивається Чорним й Азовським морями.</p>', '<p>Украї́на — держава у Східній Європі, у південно-західній частині Східноєвропейської рівнини. Площа становить 603 628 км². Друга країна за величиною на європейському континенті після Росії та найбільша країна, чия територія повністю лежить в Європі[3]. Межує з Росією на сході і північному сході, Білоруссю на півночі, Польщею, Словаччиною та Угорщиною — на заході, Румунією та Молдовою — на південному заході. На півдні і південному сході омивається Чорним й Азовським морями.</p>\r\n\r\n<p>\r\nНа території сучасної України віддавна існували держави скіфів, готів, гунів та інших народів. Проте відправним пунктом української державності і культури вважається Київська Русь 9—13 століття[4]. Її спадкоємцем стало Галицько-Волинське князівство 13—14 століття[4], що було поглинуте сусідніми Литвою та Польщею. Формування сучасної української нації припало на часи визвольної війни 1648–1657 років під проводом Богдана Хмельницького. Її результатом стало заснування в Україні козацької держави Війська Запорозького, яка однак, через міжусобиці, опинилася розділеною між Польщею та Росією. На початку 20 століття маніфестацією національної свідомості українців, що проживали під владою двох імперій — Російської та Австро-Угорської — були українські держави: Українська Народна Республіка, Українська Держава, Західно-Українська Народна Республіка, Кубанська народна республіка[5] та інші. В результаті поразки українських визвольних змагань 1917–1921 років ці держави були поглинуті сусідами: Радянською Росією, Польщею, Румунією і Чехословаччиною. На російській території була створена більшовицька маріонеткова держава Українська Радянська Соціалістична Республіка (УРСР), яка 1922 року увійшла до складу СРСР. Відлунням визвольних змагань стало проголошення незалежності Карпатської України в 1939 році, що була окупована Угорщиною. В ході Другої світової війни до УРСР була приєднана Західна Україна, а 1954 року — Крим. Сучасна держава Україна утворилося в результаті розпаду СРСР, скріпленого результатом волевиявлення української нації 1 грудня 1991 року.\r\n</p>\r\n<p>Текст було запозичено із сайту http://uk.wikipedia.org</p>', 'a:6:{s:3:"uid";s:32:"27c9bba000e79940de9f05decd306db7";s:4:"name";s:2:"UA";s:9:"extension";s:3:"jpg";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:400;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:200;}}}', 1365157316, 5, 1, '', ''),
(10, 'Ще один пост', 'test', 'короткий текст<br>', 'повний текст<br>', 'a:6:{s:3:"uid";s:32:"09f3e0e2a897b12a1d9cc43ad7cb6c08";s:4:"name";s:1:"3";s:9:"extension";s:3:"jpg";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:400;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:200;}}}', 1365158030, 1, 1, '', ''),
(11, 'Прапор України', 'flag', '<p>Жовтий (золотий) і синій кольори використовувалися на гербі Руського королівства 14 століття. Вони також вживалися на гербах руських земель, князів, шляхти і міст середньовіччя і раннього нового часу. У 18 столітті козацькі прапори Війська Запорозького часто вироблялися з синього полотнища із лицарем у золотих чи червлених шатах, із золотим орнаментом та арматурою. 1848 року українці Галичини використовували синьо-жовтий стяг як національний прапор. В 1917–1921 роках, під час української революції, цей стяг був державним прапором Української Народної Республіки й Української Держави. <br></p>', '<p>Впродовж 20 столітті жовто-блакитний прапор слугував символом \r\nукраїнського національного опору проти комуністично-радянської та \r\nнацистської окупацій. 1991 року, після розвалу СРСР, цей прапор де-факто\r\n використовувався як державний стяг незалежної України. 18 вересня 1991 \r\nроку Президія Верховної Ради України юридично закріпила за синьо-жовтим \r\nбіколором статус офіційного прапора країни[2][3]. 23 серпня в Україні \r\nщорічно відзначають День державного прапора.</p>', 'a:6:{s:3:"uid";s:32:"ee01e454b6d17ee944c9e6459ce0cbb9";s:4:"name";s:1:"2";s:9:"extension";s:3:"png";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:400;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:200;}}}', 1365158188, 5, 1, '', ''),
(12, 'Київ', 'kiev', '<p>Заснований наприкінці 5 — початку 6 століття. Був столицею полян, Русі, Української Народної Республіки, Української Держави та Української Радянської Соціалістичної Республіки. Також був адміністративним центром однойменного князівства, литовсько-польського воєводства, козацького полку, російської губернії та радянської області.</p>', '<p>Місто розташоване на півночі України, на межі Полісся і лісостепу по обидва береги Дніпра в його середній течії. Площа міста 836 км². Довжина вздовж берега — понад 20 км. Київ здавна знаходився на перетині важливих шляхів. Ще за Київської Русі таким шляхом був легендарний «Шлях із варягів у греки». На сьогодні місто перетинають міжнародні автомобільні та залізничні шляхи. Рельєф Києва сформувався на межі Придніпровської височини, а також Поліської та Придніпровської низовин. Більша частина міста лежить на високому (до 196 метрів над рівнем моря) правому березі Дніпра — Київському плато, порізаному густою сіткою ярів на окремі височини: Печерські пагорби, гори Щекавицю, Хоревицю, Батиєву та інші. Менша частина лежить на низинному лівому березі Дніпра. Житлові квартали міста оточує суцільне кільце лісових масивів.\r\n</p>', 'a:6:{s:3:"uid";s:32:"2b6b24fdd50e3b83b2ddd133b322d7d7";s:4:"name";s:3:"ua2";s:9:"extension";s:3:"jpg";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:400;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:200;}}}', 1365158323, 5, 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `uc_settings`
--

DROP TABLE IF EXISTS `uc_settings`;
CREATE TABLE IF NOT EXISTS `uc_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `uc_settings`
--

INSERT INTO `uc_settings` (`id`, `key`, `value`) VALUES
(1, 'slogan', 'UkrCms старається завоювати український вебпрості своєю швидкістю'),
(2, 'blogTitle', 'Мій блог - моя фортеця');

-- --------------------------------------------------------

--
-- Table structure for table `uc_user`
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
-- Dumping data for table `uc_user`
--

INSERT INTO `uc_user` (`id`, `login`, `name`, `password`) VALUES
(1, 'admin', 'Адміністратор', '$2a$10$39a3599d19c24b648c96bOIaErWa7QA5ece.JVBxCMGEMUWDMXw4u');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
