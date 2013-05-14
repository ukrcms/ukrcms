-- MySQL dump 10.13  Distrib 5.5.31, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: uc
-- ------------------------------------------------------
-- Server version	5.5.31-0ubuntu0.12.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `uc_categories`
--

DROP TABLE IF EXISTS `uc_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_categories` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `sef` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `order` smallint(6) NOT NULL DEFAULT '0',
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_categories`
--

LOCK TABLES `uc_categories` WRITE;
/*!40000 ALTER TABLE `uc_categories` DISABLE KEYS */;
INSERT INTO `uc_categories` VALUES (1,'Новини','news','Новини - це наче ковток свіжого повітря, саме вони підтримують Вас у тонусі.',1,0,'Новини - це наче ковток свіжого повітря, саме вони підтримують Вас у тонусі.','новини, популярні новини'),(5,'Цікаво знати','cikavo-znatu','Тестові дані важлива штука. Вони допомагають показати красу дизайну',1,0,'Тестові дані важлива штука. Вони допомагають показати красу дизайну','тестова категорія, тестові дані, метатеги');
/*!40000 ALTER TABLE `uc_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_comments`
--

DROP TABLE IF EXISTS `uc_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_comments`
--

LOCK TABLES `uc_comments` WRITE;
/*!40000 ALTER TABLE `uc_comments` DISABLE KEYS */;
INSERT INTO `uc_comments` VALUES (7,12,'funivan','funivan.com','dev@funivan.com','Цікава стаття ;)',1365171200,1),(8,11,'Іван','ukrcms.com','devteam@ukrcms.com','тестовий коментар',1368002628,1);
/*!40000 ALTER TABLE `uc_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_metatags`
--

DROP TABLE IF EXISTS `uc_metatags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_metatags` (
  `id` varchar(40) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_metatags`
--

LOCK TABLES `uc_metatags` WRITE;
/*!40000 ALTER TABLE `uc_metatags` DISABLE KEYS */;
INSERT INTO `uc_metatags` VALUES ('mainpage','UkrCms - швидко і красиво','UkrCms - швидко і красиво','цмс, українська цмс');
/*!40000 ALTER TABLE `uc_metatags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_pages`
--

DROP TABLE IF EXISTS `uc_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `sef` varchar(255) DEFAULT NULL,
  `text` longtext,
  `date` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `template` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_pages`
--

LOCK TABLES `uc_pages` WRITE;
/*!40000 ALTER TABLE `uc_pages` DISABLE KEYS */;
INSERT INTO `uc_pages` VALUES (1,'Про нас','abouts-as','Про нас<br>',NULL,1,'','','');
/*!40000 ALTER TABLE `uc_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_posts`
--

DROP TABLE IF EXISTS `uc_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_posts` (
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_posts`
--

LOCK TABLES `uc_posts` WRITE;
/*!40000 ALTER TABLE `uc_posts` DISABLE KEYS */;
INSERT INTO `uc_posts` VALUES (9,'Україна - чудова країна','ukraine','<p>Украї́на — держава у Східній Європі, у південно-західній частині Східноєвропейської рівнини. Площа становить 603 628 км². Друга країна за величиною на європейському континенті після Росії та найбільша країна, чия територія повністю лежить в Європі[3]. Межує з Росією на сході і північному сході, Білоруссю на півночі, Польщею, Словаччиною та Угорщиною — на заході, Румунією та Молдовою — на південному заході. На півдні і південному сході омивається Чорним й Азовським морями.</p>','<p>Украї́на — держава у Східній Європі, у південно-західній частині Східноєвропейської рівнини. Площа становить 603 628 км². Друга країна за величиною на європейському континенті після Росії та найбільша країна, чия територія повністю лежить в Європі[3]. Межує з Росією на сході і північному сході, Білоруссю на півночі, Польщею, Словаччиною та Угорщиною — на заході, Румунією та Молдовою — на південному заході. На півдні і південному сході омивається Чорним й Азовським морями.</p>\r\n\r\n<p>\r\nНа території сучасної України віддавна існували держави скіфів, готів, гунів та інших народів. Проте відправним пунктом української державності і культури вважається Київська Русь 9—13 століття[4]. Її спадкоємцем стало Галицько-Волинське князівство 13—14 століття[4], що було поглинуте сусідніми Литвою та Польщею. Формування сучасної української нації припало на часи визвольної війни 1648–1657 років під проводом Богдана Хмельницького. Її результатом стало заснування в Україні козацької держави Війська Запорозького, яка однак, через міжусобиці, опинилася розділеною між Польщею та Росією. На початку 20 століття маніфестацією національної свідомості українців, що проживали під владою двох імперій — Російської та Австро-Угорської — були українські держави: Українська Народна Республіка, Українська Держава, Західно-Українська Народна Республіка, Кубанська народна республіка[5] та інші. В результаті поразки українських визвольних змагань 1917–1921 років ці держави були поглинуті сусідами: Радянською Росією, Польщею, Румунією і Чехословаччиною. На російській території була створена більшовицька маріонеткова держава Українська Радянська Соціалістична Республіка (УРСР), яка 1922 року увійшла до складу СРСР. Відлунням визвольних змагань стало проголошення незалежності Карпатської України в 1939 році, що була окупована Угорщиною. В ході Другої світової війни до УРСР була приєднана Західна Україна, а 1954 року — Крим. Сучасна держава Україна утворилося в результаті розпаду СРСР, скріпленого результатом волевиявлення української нації 1 грудня 1991 року.\r\n</p>\r\n<p>Текст було запозичено із сайту http://uk.wikipedia.org</p>','a:6:{s:3:\"uid\";s:32:\"27c9bba000e79940de9f05decd306db7\";s:4:\"name\";s:2:\"UA\";s:9:\"extension\";s:3:\"jpg\";s:9:\"pathLevel\";i:2;s:4:\"path\";s:6:\"/posts\";s:5:\"sizes\";a:2:{s:4:\"main\";a:2:{s:1:\"w\";d:600;s:1:\"h\";d:400;}s:5:\"small\";a:2:{s:1:\"w\";d:300;s:1:\"h\";d:200;}}}',1365157316,5,1,'',''),(10,'Ще один пост','test','короткий текст<br>','повний текст<br>','a:6:{s:3:\"uid\";s:32:\"09f3e0e2a897b12a1d9cc43ad7cb6c08\";s:4:\"name\";s:1:\"3\";s:9:\"extension\";s:3:\"jpg\";s:9:\"pathLevel\";i:2;s:4:\"path\";s:6:\"/posts\";s:5:\"sizes\";a:2:{s:4:\"main\";a:2:{s:1:\"w\";d:600;s:1:\"h\";d:400;}s:5:\"small\";a:2:{s:1:\"w\";d:300;s:1:\"h\";d:200;}}}',1365158030,1,1,'',''),(11,'Прапор України','flag','<p>Жовтий (золотий) і синій кольори використовувалися на гербі Руського королівства 14 століття. Вони також вживалися на гербах руських земель, князів, шляхти і міст середньовіччя і раннього нового часу. У 18 столітті козацькі прапори Війська Запорозького часто вироблялися з синього полотнища із лицарем у золотих чи червлених шатах, із золотим орнаментом та арматурою. 1848 року українці Галичини використовували синьо-жовтий стяг як національний прапор. В 1917–1921 роках, під час української революції, цей стяг був державним прапором Української Народної Республіки й Української Держави. <br></p>','<p>Впродовж 20 столітті жовто-блакитний прапор слугував символом \r\nукраїнського національного опору проти комуністично-радянської та \r\nнацистської окупацій. 1991 року, після розвалу СРСР, цей прапор де-факто\r\n використовувався як державний стяг незалежної України. 18 вересня 1991 \r\nроку Президія Верховної Ради України юридично закріпила за синьо-жовтим \r\nбіколором статус офіційного прапора країни[2][3]. 23 серпня в Україні \r\nщорічно відзначають День державного прапора.</p>','a:6:{s:3:\"uid\";s:32:\"ee01e454b6d17ee944c9e6459ce0cbb9\";s:4:\"name\";s:1:\"2\";s:9:\"extension\";s:3:\"png\";s:9:\"pathLevel\";i:2;s:4:\"path\";s:6:\"/posts\";s:5:\"sizes\";a:2:{s:4:\"main\";a:2:{s:1:\"w\";d:600;s:1:\"h\";d:400;}s:5:\"small\";a:2:{s:1:\"w\";d:300;s:1:\"h\";d:200;}}}',1365158188,5,1,'',''),(12,'Київ','kiev','<p>Заснований наприкінці 5 — початку 6 століття. Був столицею полян, Русі, Української Народної Республіки, Української Держави та Української Радянської Соціалістичної Республіки. Також був адміністративним центром однойменного князівства, литовсько-польського воєводства, козацького полку, російської губернії та радянської області.</p>','<p>Місто розташоване на півночі України, на межі Полісся і лісостепу по обидва береги Дніпра в його середній течії. Площа міста 836 км². Довжина вздовж берега — понад 20 км. Київ здавна знаходився на перетині важливих шляхів. Ще за Київської Русі таким шляхом був легендарний «Шлях із варягів у греки». На сьогодні місто перетинають міжнародні автомобільні та залізничні шляхи. Рельєф Києва сформувався на межі Придніпровської височини, а також Поліської та Придніпровської низовин. Більша частина міста лежить на високому (до 196 метрів над рівнем моря) правому березі Дніпра — Київському плато, порізаному густою сіткою ярів на окремі височини: Печерські пагорби, гори Щекавицю, Хоревицю, Батиєву та інші. Менша частина лежить на низинному лівому березі Дніпра. Житлові квартали міста оточує суцільне кільце лісових масивів.\r\n</p>','a:6:{s:3:\"uid\";s:32:\"2b6b24fdd50e3b83b2ddd133b322d7d7\";s:4:\"name\";s:3:\"ua2\";s:9:\"extension\";s:3:\"jpg\";s:9:\"pathLevel\";i:2;s:4:\"path\";s:6:\"/posts\";s:5:\"sizes\";a:2:{s:4:\"main\";a:2:{s:1:\"w\";d:600;s:1:\"h\";d:400;}s:5:\"small\";a:2:{s:1:\"w\";d:300;s:1:\"h\";d:200;}}}',1365158323,5,1,'','');
/*!40000 ALTER TABLE `uc_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_settings`
--

DROP TABLE IF EXISTS `uc_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_settings`
--

LOCK TABLES `uc_settings` WRITE;
/*!40000 ALTER TABLE `uc_settings` DISABLE KEYS */;
INSERT INTO `uc_settings` VALUES (1,'slogan','UkrCms старається завоювати український вебпрості своєю швидкістю'),(2,'blogTitle','Мій блог - моя фортеця');
/*!40000 ALTER TABLE `uc_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_user`
--

DROP TABLE IF EXISTS `uc_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `password` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Користувач, параметри користувача';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_user`
--

LOCK TABLES `uc_user` WRITE;
/*!40000 ALTER TABLE `uc_user` DISABLE KEYS */;
INSERT INTO `uc_user` VALUES (1,'admin','Адміністратор','$2a$10$9260178384df6c97bfd8bORTU1O66OHTZ1F6vHri0mRM.r3fQAzeK');
/*!40000 ALTER TABLE `uc_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-13 17:13:44
