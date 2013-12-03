-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 03, 2013 at 11:02 PM
-- Server version: 5.5.34-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uc_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `uc_categories`
--

DROP TABLE IF EXISTS `uc_categories`;
CREATE TABLE IF NOT EXISTS `uc_categories` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `sef` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `order` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `uc_categories`
--

INSERT INTO `uc_categories` (`id`, `sef`, `status`, `order`) VALUES
(4, 'sity', 1, 0),
(5, 'entertainment', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `uc_categories_langs`
--

DROP TABLE IF EXISTS `uc_categories_langs`;
CREATE TABLE IF NOT EXISTS `uc_categories_langs` (
  `table_lang_id` int(11) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uc_categories_langs`
--

INSERT INTO `uc_categories_langs` (`table_lang_id`, `lang`, `title`, `description`, `meta_description`, `meta_keywords`) VALUES
(4, 'ua', 'Міста', 'Опис міст України', 'міста україни', 'опис, міста, Україні'),
(4, 'ru', 'Города', 'Описание городов Украины', 'города Укрины', 'описание, города, украина'),
(4, 'en', 'Sity', 'Description of cities in Ukraine', 'cities in Ukraine', 'description, city, ukraine'),
(5, 'ua', 'Розваги', '', '', ''),
(5, 'ru', 'Развлечения', '', '', ''),
(5, 'en', 'Entertainment', '', '', '');

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sef` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `uc_metatags`
--

INSERT INTO `uc_metatags` (`id`, `id_sef`) VALUES
(1, ''),
(2, 'mainpage');

-- --------------------------------------------------------

--
-- Table structure for table `uc_metatags_langs`
--

DROP TABLE IF EXISTS `uc_metatags_langs`;
CREATE TABLE IF NOT EXISTS `uc_metatags_langs` (
  `table_lang_id` int(11) NOT NULL,
  `lang` varchar(2) CHARACTER SET utf8 NOT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `meta_description` text CHARACTER SET utf8 NOT NULL,
  `meta_keywords` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uc_metatags_langs`
--

INSERT INTO `uc_metatags_langs` (`table_lang_id`, `lang`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
(2, 'ua', 'UkrCms - швидко і красиво', 'UkrCms - швидко і красиво', 'цмс, українська цмс'),
(2, 'ru', 'UkrCms - быстро и красиво', 'UkrCms - быстро и красиво', 'цмс, українська цмс'),
(2, 'en', 'UkrCms - fast and nice', 'UkrCms - fast and nice', 'цмс, українська цмс');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `uc_pages`
--

INSERT INTO `uc_pages` (`id`, `sef`, `date`, `published`, `template`) VALUES
(10, 'about-us', NULL, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `uc_pages_langs`
--

DROP TABLE IF EXISTS `uc_pages_langs`;
CREATE TABLE IF NOT EXISTS `uc_pages_langs` (
  `table_lang_id` int(11) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` longtext,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uc_pages_langs`
--

INSERT INTO `uc_pages_langs` (`table_lang_id`, `lang`, `title`, `text`, `meta_description`, `meta_keywords`) VALUES
(10, 'ua', 'Про нас', 'Про нас', '', ''),
(10, 'ru', 'Про нас', 'Про нас', '', ''),
(10, 'en', 'About us', 'About us', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `uc_posts`
--

DROP TABLE IF EXISTS `uc_posts`;
CREATE TABLE IF NOT EXISTS `uc_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sef` varchar(255) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `category_id` int(8) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `uc_posts`
--

INSERT INTO `uc_posts` (`id`, `sef`, `date`, `category_id`, `published`) VALUES
(2, 'lviv', 1386102321, 4, 1),
(3, 'kyiv', 1386103256, 4, 1),
(4, 'communa-pervoe-antykafe', 1386104011, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `uc_posts_langs`
--

DROP TABLE IF EXISTS `uc_posts_langs`;
CREATE TABLE IF NOT EXISTS `uc_posts_langs` (
  `table_lang_id` int(11) NOT NULL,
  `lang` varchar(2) CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `shorttext` text CHARACTER SET utf8 NOT NULL,
  `text` longtext CHARACTER SET utf8 NOT NULL,
  `imageData` text CHARACTER SET utf8 NOT NULL,
  `meta_description` text CHARACTER SET utf8 NOT NULL,
  `meta_keywords` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uc_posts_langs`
--

INSERT INTO `uc_posts_langs` (`table_lang_id`, `lang`, `title`, `shorttext`, `text`, `imageData`, `meta_description`, `meta_keywords`) VALUES
(2, 'ru', 'Львов', '... Львов ... лежит в таком месте, как будто это беседка посреди рая. Очень красивые окрестности ... Как только немного перейти через порог, встретишь столько удивительных вещей, что где-то нужно было бы путешествовать сто миль, чтобы такое увидеть. Здесь широкие поля, горы и долины, холмы и верхом, кустарники и лес.', '<ptimes new="" roman'';="" font-size:="" medium;="" text-align:="" justify;="" background-color:="" rgb(204,="" 255,="" 204);"=""><div>Сразу за городскими воротами все это не только можно осматривать , но и достичь руками. Не знаю города во всем королевстве , которое было бы богаче на сады . Здесь растут орехи и сливы , размером с куриное яйцо. Их упаковывают в большие бочки и вывозят до Москвы . Виноград из здешних садов не только носят корзинами на рынок , но и делают вино в погреба по 50-60 бочек с одного пресса. Благодаря умению и бдительности виноделов их вино крепнет из года в год , так что некоторые вина принимают за привезенные , а не местные ... Кипарисы и розмарин здесь увидишь не только в вазонах , но и на участках . Хорошие каштаны , дыни , артишоки и некоторые другие иностранные растения здесь не редкость. И они не только цветут , но и дают плоды ... Душистые ноготки , лучшие фиалки и другие свежие цветы можно найти здесь в любое время круглый год. И огороды они не только для пользы , но и для забавы - в городах есть хорошие беседки , пруды, даже площадки для кеглей .</div><div>... Вся скот , что ее гонят с Подолья и Молдавии в Италию , проходит через этот город. А здешних щук едят и в Вене , хотя там и протекает под семи мостами богатый рыбой Дунай.</div><div>Я объехал пол- Европы , побывал в самых славных городах мира , но в одном не видел столько хлеба , как здесь ежедневно приносят на рынок , и почти каждый чужак найдет такое печенье , как в своей стране , - хлеб , струцли , пирожные , или как еще их назвать. Здесь огромное количество пива и меда , не только местного , но и привезенного . А вино им привозят также из Молдавии , Венгрии , Греции. Иногда на рынке можно увидеть в кипах более тысячи бочек вина - там его состав .</div><div>В этом городе , как и в Венеции , стало привычным встречать на рынке людей из всех стран мира в своих одеждах : венгров в их малых магерках , казаков в больших кучмах , русских в белых шапках , турков в белых чалмах . Эти все в длинном одежды , а немцы , итальянцы , испанцы - в коротком . Каждый , на каком бы языке он не говорил , найдет здесь и свой язык . Город удаленное более ста миль от моря. Но когда увидишь , как на рынке при бочках малмазии бурлит толпа критян , турков , греков , итальянцев , одетых еще по корабельному , кажется будто здесь порт сразу за воротами города .</div><ptimes new="" roman'';="" font-size:="" medium;="" text-align:="" justify;="" background-color:="" rgb(204,="" 255,="" 204);"=""><ptimes new="" roman'';="" font-size:="" medium;="" text-align:="" justify;="" background-color:="" rgb(204,="" 255,="" 204);"=""><ptimes new="" roman'';="" font-size:="" medium;="" text-align:="" justify;="" background-color:="" rgb(204,="" 255,="" 204);"=""><p></p></ptimes></ptimes></ptimes></ptimes>', 'a:6:{s:3:"uid";s:32:"ad215aea5832d09104b404d9b1eb4f2d";s:4:"name";s:4:"lviv";s:9:"extension";s:3:"jpg";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:402;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:201;}}}', '', ''),
(2, 'ua', 'Львів', '...Львів... лежить у такому місці, неначе це альтана посеред раю. Дуже гарні околиці... Як тільки трохи перейти через поріг, натрапиш на стільки дивовижних речей, що деінде треба було б подорожувати сто миль, щоб таке побачити. Тут широкі поля, гори і долини, пагорби і верхи, чагарники й ліс.', '<ptimes new="" roman'';="" font-size:="" medium;="" text-align:="" justify;="" background-color:="" rgb(204,="" 255,="" 204);"="">Відразу за міською брамою все це не тільки можна оглядати, але й досягти руками. Не знаю міста у всьому королівстві, яке було б багатше на садки. Тут ростуть горіхи і сливи, розміром з куряче яйце. Їх пакують у великі бочки і вивозять аж до Москви. Виноград з тутешніх садів не тільки носять кошиками на ринок, але й роблять вино до погребів по 50-60 бочок з одного преса. Завдяки умінню і пильності виноробів їхнє вино міцніє з року в рік, так що деякі вина приймають за привезені, а не місцеві... Кипариси і розмарин тут побачиш не тільки в вазонах, але й на ділянках. Гарні каштани, дині, артишоки та деякі инші іноземні рослини тут не дивина. І вони не лише квітують, але й дають плоди... Запашні нагідки, найкращі фіалки та инші свіжі квіти можна знайти тут в будь-який час цілий рік. І городи вони мають не тільки для пожитку, але й для забави – у городах є гарні альтанки, ставки, навіть майданчики для кеглів.<p></p><ptimes new="" roman'';="" font-size:="" medium;="" text-align:="" justify;="" background-color:="" rgb(204,="" 255,="" 204);"="">...Вся худоба, що її женуть з Поділля і Молдавії до Італії, проходить через це місто. А тутешніх щупаків їдять і у Відні, хоч там і протікає під семи мостами багатий на рибу Дунай.<p></p><ptimes new="" roman'';="" font-size:="" medium;="" text-align:="" justify;="" background-color:="" rgb(204,="" 255,="" 204);"="">Я об’їхав пів-Европи, побував у найславніших містах світу, але в жодному не бачив стільки хліба, як тут щодня приносять на ринок, і майже кожний чужинець знайде таке печиво, як у своїй країні, – хліб, струцлі, тістечка, чи як ще їх назвати. Тут величезна кількість пива і меду, не тільки місцевого, але й привезеного. А вино їм привозять також з Молдавії, Угорщини, Греції. Інколи на ринку можна побачити в стосах більше тисячі бочок вина – там його склад.<p></p><ptimes new="" roman'';="" font-size:="" medium;="" text-align:="" justify;="" background-color:="" rgb(204,="" 255,="" 204);"="">У цьому місті, як і у Венеції, стало звичним зустрічати на ринку людей з усіх країн світу в своїх одягах: угорців у їхніх малих магерках, козаків у великих кучмах, росіян у білих шапках, турків у білих чалмах. Ці всі у довгому одягу, а німці, італійці, іспанці – у короткому. Кожен, якою б мовою він не говорив, знайде тут і свою мову. Місто віддалене понад сто миль від моря. Але коли побачиш, як на ринку при бочках малмазії вирує натовп крітян, турків, греків, італійців, зодягнених ще по корабельному, видається неначе тут порт відразу за брамою міста.<p></p></ptimes></ptimes></ptimes></ptimes>', 'a:6:{s:3:"uid";s:32:"e143b87331cfd0bc0ab796a42edfd03d";s:4:"name";s:4:"lviv";s:9:"extension";s:3:"jpg";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:402;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:201;}}}', '', ''),
(2, 'en', 'Lviv', 'Lviv ... ... lies in a place like this Altana midst of the garden. Very nice neighborhood ... Once the bit to cross the threshold to come across so many amazing things that elsewhere would have to travel a hundred miles to see a. This broad fields, mountains and valleys, hills and riding, shrubs and forest.', '<ptimes new="" roman'';="" font-size:="" medium;="" text-align:="" justify;="" background-color:="" rgb(204,="" 255,="" 204);"=""><div>Just outside the city gate all this is not only possible to examine , but to reach your hands. I do not know the city throughout the kingdom, which would be richer by gardens. Here there are nuts and plums the size of a hen''s egg . They are packed in large barrels and taken up in Moscow. Grapes from local gardens not only carry baskets on the market, but also to make the wine cellars of 50-60 barrels with one press. Thanks to the skill and vigilance of wine the wine is growing from year to year , so some wine mistaken for imported rather than local ... Cypress and rosemary see here not only in pots , but also on land. Good chestnuts , melons, artichokes and some others , foreign plants are not surprising . And they only bloom , but are working ... Fragrant marigold , violet and others the best fresh flowers can be found here at any time of year . And the cities they have not only the profit but for fun - the garden is a beautiful gazebo , ponds, even grounds for pins .</div><div>... All cattle driven from skirts and Moldova to Italy , passes through the city. A local Shchupak eat in Vienna , although there takes place under the seven bridges rich in fish Danube.</div><div>I traveled half of Europe , visited the glorious cities of the world , but nowhere have I seen so much bread as here every day to bring to market, and almost every stranger finds a cookie as in their own country - the bread strutsli , cakes, or how else to call them . There is a huge amount of beer and honey, not only local but also imported. And they brought wine also from Moldavia , Hungary, Greece. Sometimes you can see in piles over a thousand barrels of wine - where its composition.</div><div>In this city , like Venice , it became customary in the market to meet people from all over the world in their clothes: Hungarians in their little felt cap , Cossacks in big furry hats, caps in white Russians , Turks in white turbans . These are all in long clothing , and the Germans , Italians , Spaniards - in short . Everyone , no matter what language you speak , will find here their language. The city lies far more than a hundred miles from the sea. But when you see a market in barrels malmaziyi raging crowd Cretans , Turks , Greeks , Italians, still dressed for the ship , it seems as though this port just outside the gates of the city.</div><ptimes new="" roman'';="" font-size:="" medium;="" text-align:="" justify;="" background-color:="" rgb(204,="" 255,="" 204);"=""><ptimes new="" roman'';="" font-size:="" medium;="" text-align:="" justify;="" background-color:="" rgb(204,="" 255,="" 204);"=""><ptimes new="" roman'';="" font-size:="" medium;="" text-align:="" justify;="" background-color:="" rgb(204,="" 255,="" 204);"=""><p></p></ptimes></ptimes></ptimes></ptimes>', 'a:6:{s:3:"uid";s:32:"de1493834c85eb9dd2a8488dca665fbf";s:4:"name";s:4:"lviv";s:9:"extension";s:3:"jpg";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:402;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:201;}}}', '', ''),
(3, 'ua', 'Київ', 'Будь-який український школяр знає, що Київ — столиця нашої Батьківщини, України.<br>Колись він був також матір''ю всіх російських міст, і названий так на честь князя Кия.<br>Існує легенда, що Київ заснований трьома братами: Києм, Щеком і Хоривом та сестрою Либіддю як центр племені полян. Названий на честь старшого брата.', 'Сьогодні Київ — це не тільки велике українське місто, а й крупний транспортний вузол. У ньому є залізні і шосейні дороги; річковий порт; міжнародний аеропорт в Борисполі. Місто також є крупним центром машинобудування, металургії, легкої та поліграфічної промисловості. З 1960 року в Києві діє метрополітен , що складається з 3 ліній, загальна його довжина — 56,5 км.<br>Наша столиця — велике місто, в якому є безліч вулиць, скверів, будинків, площ, музеїв, театрів, шкіл, університетів, лікарень, магазинів. У Києві життя стрімке і непередбачуване, але, якщо хочеться тиші, можна прогулятися в парку, сквері, помилуватися знаменитими київськими каштанами, подивитися на пам''ятники Т. Г. Шевченку, Богдану Хмельницькому, або Золоті Ворота.<br>Київ —- один з найбільших на Україні центрів науки й освіти. У Києві величезна кількість шкіл, гімназій, ліцеїв, близько 70 Вузів.<br>Є багато цікавих історичних фактів про Київ. Загальновідомий факт, що, починаючи з IX сторіччя, Київ був важливим центром інтелектуального розвитку Східної Європи. І, починаючи з кінця XVII сторіччя, Києво-Могилянська академія підготувала багато відомих учених.<br>Ми пишаємося цим красивим і величним містом. І з упевненістю вважаємо, що Київ — місто незвичайне. Найвідомішими місцями Києва є центральна вулиця міста Хрещатик і Андріївський Узвіз. На них завжди багато туристів, які фотографують, купляють сувеніри, або просто балакають з жителями столиці. І їм є що розповісти про рідне місто!<br>Особлива гордість киян-це головна вулиця Києва — Хрещатик. її довжина — 1,2 км, напрям — з півночі на південь. А закінчується вона не менш відомою Бессарабською площею. Назва вулиці походить від Хрещатого Яру (тобто<br>перехрещеного поперечними балками-ярами). У документах XVII століття вся ця місцевість називалася Хрещатою Долиною. З кінця 1990-х pp. у вихідні і святкові дні рух автотранспорту по Хрещатику заборонений — вулиця стала пішохідною.<br>Київ справедливо називають одним з найзеленіших міст миру (а колись він вважався найзеленішим), І це недаремно. Отже ліси, паркі і сади складає більше половини його площі. На території міста знаходяться два ботанічні сади. А знамениті київські каштани, які розкішно квітнуть в травні, а іноді і двічі в рік: навесні і осінню, стали одним з символів міста.<br>Вулиці і площі, бурхливий рух транспорту, красуня-річка — все це надихає і радує погляд будь-якого гостя або жителя цього міста. Звичайно, тут багато машин,що отруюють повітря красуні-столиці, та у кожного є можливість відправитися на берег Дніпра. Це прекрасне місце для відпочинку чи роздумів. Звідси відкривається дивний вигляд на велику і прекрасну річку, а ландшафтні парки надзвичайно красиві. Можна годинами милуватися красою ліній Софійського Собору, або витонченими церквами Києво-Печерської Лаври, вигляд на які в усьому блиску позолоти її куполів відкривається при в''їзді до старішої частини міста через міст Патона. У такі хвилини здається, що вічність прийшла до тебе назустріч, щоб розповісти секрети покою і волі. Казкове красиве убрання зелених схилів навесні, або білих взимку, шепіт води, свіжий вітер, що наповнює груди... Таким місто було здавна... І ще більш красиве в наші часи. ', 'a:6:{s:3:"uid";s:32:"bb82e02771e5f31f03c98eab6dcb75d1";s:4:"name";s:4:"kiev";s:9:"extension";s:3:"jpg";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:450;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:225;}}}', '', ''),
(3, 'ru', 'Киев', '<div>Любой украинский школьник знает, что Киев - столица нашей Родины, Украины.</div><div>Когда-то он был также матерью всех русских городов, и назван так в честь князя Кия.</div><div>Существует легенда, что Киев основан тремя братьями: Кием, Щеком и Хоривом и сестрой Лыбедь как центр племени полян. Назван в честь старшего брата.</div>', '<div>Сегодня Киев - это не только большой украинский город , но и крупный транспортный узел. В нем есть железные и шоссейные дороги ; речной порт , международный аэропорт в Борисполе. Город также является крупным центром машиностроения , металлургии , легкой и полиграфической промышленности . С 1960 года в Киеве действует метрополитен , состоящий из 3 линий , общая его длина - 56,5 км .</div><div>Наша столица - большой город , в котором есть множество улиц , скверов , домов , площадей , музеев , театров , школ , университетов , больниц , магазинов. В Киеве жизнь стремительное и непредсказуемое , но , если хочется тишины , можно прогуляться в парке , сквере , полюбоваться знаменитыми киевскими каштанами , посмотреть на памятники Т. Г. Шевченко , Богдану Хмельницкому , или Золотые Ворота .</div><div>Киев - один из крупнейших на Украине центров науки и образования. В Киеве огромное количество школ , гимназий , лицеев , около 70 ВУЗов .</div><div>Есть много интересных исторических фактов о Киеве. Общеизвестный факт , что , начиная с IX века , Киев был важным центром интеллектуального развития Восточной Европы. И , начиная с конца XVII века , Киево - Могилянская академия подготовила много известных ученых.</div><div>Мы гордимся этим красивым и величественным городом . И с уверенностью считаем , что Киев - город необычное. Самыми известными местами Киева есть центральная улица города Крещатик и Андреевский спуск . На них всегда много туристов , которые фотографируют , покупают сувениры , или просто говорят с жителями столицы. И им есть что рассказать о родном городе !</div><div>Особая гордость киевлян это главная улица Киева - Крещатик. ее длина - 1,2 км , направление - с севера на юг. А заканчивается она не менее известной Бессарабской площади. Название улицы происходит от Крещатого Яра (то есть</div><div>перекрещенного поперечными балками - оврагами ) . В документах XVII века вся эта местность называлась Крещатой Долиной . С конца 1990- х pp . в выходные и праздничные дни движение автотранспорта по Крещатику запрещено - улица стала пешеходной.</div><div>Киев справедливо называют одним из самых зеленых городов мира ( а некогда он считался самым зеленым ), и это не случайно . Итак леса , парки и сады составляет более половины его площади. На территории города находятся два ботанических сада . А знаменитые киевские каштаны , которые роскошно цветут в мае , а иногда и два раза в год : весной и осенью , стали одним из символов города.</div><div>Улицы и площади , бурное движение транспорта , красавица- река - все это вдохновляет и радует взгляд любого гостя или жителя этого города. Конечно , здесь много машин , которые отравляют воздух красавицы- столицы , и у каждого есть возможность отправиться на берег Днепра. Это прекрасное место для отдыха или размышлений. Отсюда открывается чудесный вид на большую и прекрасную реку , а ландшафтные парки чрезвычайно красивы. Можно часами любоваться красотой линий Софийского Собора , или изящными церквями Киево - Печерской Лавры , вид на которые во всем блеске позолоты ее куполов открывается при въезде в старой части города через мост Патона. В такие минуты кажется , что вечность пришла к тебе навстречу , чтобы рассказать секреты покоя и воли . Сказочное красивое убранство зеленых склонов весной , или белых зимой , шепот воды , свежий ветер , наполняющий грудь ... Таким город был издавна ... И еще более красивое в наше время.</div>', 'a:6:{s:3:"uid";s:32:"ccff234481b452443f4b49cd913c5fab";s:4:"name";s:4:"kiev";s:9:"extension";s:3:"jpg";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:450;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:225;}}}', '', ''),
(3, 'en', 'Kyiv', '<div>Any Ukrainian schoolchild knows that Kyiv - the capital of our country, Ukraine.</div><div>Once he was also the mother of all Russian cities, and named in honor of Prince Kyi.</div><div>Legend has it that Kyiv was founded by three brothers: Kiy, Schek Horiv and sister Lybyed as the center of the tribe of the field. Named in honor of his older brother.</div>', '<div>Today Kyiv - is not only a great Ukrainian city , but also a major transport hub. It contains iron and highways , river port , international airport Boryspil . The city is also a major center for machine building, metallurgy , textile and printing industries. Since 1960, operates in Kyiv subway , consisting of 3 lines , the total of its length - 56,5 km.</div><div>Our capital - a great city in which there are numerous streets , squares , buildings , plazas , museums , theaters , schools, universities , hospitals and shops. In Kiev rapid and unpredictable life , but if you want quiet, you can walk in parks, gardens, admire the famous Kiev chestnuts, look at the monument to Taras Shevchenko , Bohdan Khmelnytsky, or Golden Gate.</div><div>Kyiv - one of the largest in Ukraine centers of science and education. In Kiev, a large number of schools, high schools , 70 high schools .</div><div>There are many interesting historical facts about Kyiv . It is common knowledge that since IX century Kyiv was an important center for intellectual development of Europe. And since the late XVII century , Kyiv- Mohyla Academy has trained many famous scientists.</div><div>We are proud of this beautiful and magnificent city. I confidently believe that Kyiv - city special. Prestigious Kyiv''s main street Khreschatyk City and St. Andrew''s Descent . They are always a lot of tourists who photograph, purchasing gifts, or just chat with residents of the capital. And they have something to talk about hometown !</div><div>A special pride of people of Kiev is the main street of Kyiv - Khreschatyk. its length - 1.2 km, direction - from north to south. And it ends with the equally famous Bessarabian area. The name comes from the street Kreschaty Yar (ie</div><div>crossed by transverse beams , ravines ). The documents of the XVII century, the whole area was called cruciform Valley . Since the late 1990s, pp. weekends and holidays vehicular traffic on Khreschatyk banned - the street became a pedestrian .</div><div>Kyiv rightly called one of the greenest cities in the world (and once he was considered the greenest ), and it is not without reason . So forests, parks and gardens more than half of its area. Within the city there are two botanical gardens. A famous Kiev chestnuts that beautifully bloom in May , and sometimes twice a year : in the spring and fall , became a symbol of the city.</div><div>The streets and squares, rapid traffic, beautiful river , - all this inspires and delights view any guest or resident of this city . Of course , there are many cars that poison the air of the beautiful capital city, and everyone has the opportunity to go to the bank of the Dnieper . This is a great place to rest or reflection. It has a strange view of the large and beautiful river views and landscaped parks are extremely beautiful . You can spend hours admiring the beauty of the lines of Hagia Sophia, or graceful churches of Kiev-Pechersk Lavra, look at that shine throughout the gilding of the dome open at the entrance to the older part of the town across the bridge Paton. At such times it seems like an eternity has come to meet you , to tell you the secrets of eternal peace and freedom. Fabulous dress beautiful green slopes of the spring or winter white , the whisper of water , fresh breeze , which fills the breast ... This city has long been ... And even more beautiful in our time.</div>', 'a:6:{s:3:"uid";s:32:"81b453c7b2db320643e0a0cdb4783c6d";s:4:"name";s:4:"kiev";s:9:"extension";s:3:"jpg";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:450;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:225;}}}', '', ''),
(4, 'ua', 'Communa:  перше антикафе', 'Мода на вільні простори нарешті добралась і до заходу України. Ще в жовтні у Львові відкрилось оригінальне місце <strongnoto sans'';="" font-size:="" 14px;="" line-height:="" 23.796875px;"="">"CoMMuna", а 19 грудня відбувся офіційний перезапуск закладу, для якого було обрано не менш оригінальний статус — антикафе. В такому закладі, який ще іноді називають "вільним простором" або "третім місцем", ви платите лише за час перебування, а решта послуг — безкоштовні.</strongnoto>', '<pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"="">З моменту відкриття нас насторожували, щоб ми випадково не перетворились в інтернет-кафе. Ці думки надокучали й нам, думаю, що саме тому ми перекваліфікувались й перейняли київський досвід, де в одному місті повноцінно й прибутково працює три заклади з подібною політикою (<a href="http://inspired.com.ua/interior/clockfacer-kyiv/">Циферблат</a>, <a href="http://inspired.com.ua/interior/bibliotech-kyiv/">Bibliotech</a>, <a href="http://inspired.com.ua/interior/chasopys/">Часопис</a> – <em>IN</em>)<pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><strong>Чи довго часу зайняла підготовка до запуску закладу?</strong><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"="">Близько півроку ми вибивали стіни, потім фарбували їх, завозили меблі.<pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><strong>Скільки людей працювало над проектом?</strong><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"="">Знаєте, навіть важко сказати. Людей було багато, і кожен робив свої корективи для кращого функціонування проекту. Люди приходили і йшли від нас, за те ми їм теж дякуємо.<pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><strong>Хто цільова аудиторія "Коммуни"?</strong><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"="">Якщо обмежуватись віком, то це молоді люди від 16 до 30 років. Молодь часто збирається тут для гарного проведення часу — пограти у настільні ігри, посмакувати какао.<pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><strong>Згадали про какао, а які послуги ви ще надаєте?</strong><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"="">Як ви вже знаєте, у нас платять за час перебування, а не за послуги. Ціни наступні:<pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"="">Вдень: 15 хвилин – 5 грн (Перша година 20 грн, а усі наступні по 16 грн)<br>Вночі: 30 хвилин – 5 грн (1 год – 10 грн)<pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"="">В нас доступний також щомісячний абонемент з 50%-знижкою, і ми працюємо 24 години на добу. У вартість однієї хвилини або ж години входить користування настільними іграми (яких більше п’яти), нетбуками й стаціонарними комп’ютерами, смакування какао, узвару, печива, цукерками. У нас є мольберти, де можна малювати, а також різні сучасні журнали. Кожен охочий, за додаткову вартість, може купити собі так звані "снеки", роздрукувати або перексерити необхідне, а також телефонувати закордон.</pnoto></pnoto></pnoto></pnoto></pnoto></pnoto></pnoto></pnoto></pnoto></pnoto></pnoto>', 'a:6:{s:3:"uid";s:32:"0072199fb2fc7f75ea8008858414ec14";s:4:"name";s:16:"IMG_2899-640x426";s:9:"extension";s:3:"jpg";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:399;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:200;}}}', '', ''),
(4, 'ru', 'Communa:  первое антикафе', 'Мода на свободные пространства наконец добралась и до запада Украины. Еще в октябре во Львове открылось оригинальное место "CoMMuna", а 19 декабря состоялся официальный перезапуск заведения, для которого было выбрано не менее оригинальный статус - антикафе. В таком заведении, который еще иногда называют "свободным пространством" или "третье место", вы платите только за время пребывания, а остальные услуги - бесплатные.', '<p>С момента открытия нас настораживающие чтобы мы случаем не превратились в интернет -кафе. Эти мысли надоедали и нам , думаю , что именно поэтому мы переквалифицировались и переняли киевский опыт , где в одном городе полноценно и прибыльно работает три заведения с подобной политикой ( Циферблат , Bibliotech , Журнал - IN )</p><p><span style="font-size: 10pt;">Долго времени заняла подготовка к запуску заведения?</span></p><p><span style="font-size: 10pt;">Около полугода мы выбивали стены , потом красили их , завозили мебель.</span></p><p>Сколько людей работало над проектом?</p><p>Знаете , даже трудно сказать . Людей было много , и каждый делал свои коррективы для лучшего функционирования проекта . Люди приходили и уходили от нас , за то мы им тоже спасибо.</p><p>Кто целевая аудитория " Коммуны " ?</p><p>Если ограничиваться возрастом , то это молодые люди от 16 до 30 лет. Молодежь часто собирается здесь для хорошего проведения времени - поиграть в настольные игры , насладиться какао.</p><p>Вспомнили о какао , а какие услуги вы еще предоставляете ?</p><p>Как вы уже знаете , у нас платят за время пребывания , а не за услуги. Цены следующие:</p><p>Днем: 15 минут - 5 грн ( Первый час 20 грн , а все последующие по 16 грн )</p><p>Ночью : 30 минут - 5 грн (1 час - 10 грн)</p><p>У нас доступен также ежемесячный абонемент с 50% - скидкой , и мы работаем 24 часа в сутки . В стоимость одной минуты или часа входит пользование настольными играми ( которых более пяти ) , нетбуками и стационарными компьютерами , смакование какао , компота , печенья , конфетами. У нас есть мольберты , где можно рисовать , а также различные современные журналы. Каждый желающий , за дополнительную стоимость , может купить себе так называемые " снеки " , распечатать или перексериты необходимо , а также звонить заграницу .</p>', 'a:6:{s:3:"uid";s:32:"0072199fb2fc7f75ea8008858414ec14";s:4:"name";s:16:"IMG_2899-640x426";s:9:"extension";s:3:"jpg";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:399;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:200;}}}', '', ''),
(4, 'en', 'Communa: у Львові відкрилось перше антикафе', '<font face="Arial, Verdana" size="2">Fashion in free space and finally reached to the west of Ukraine. Back in October in Lviv opened the original location "CoMMuna", and December 19, an official restart of the institution for which it was elected no less original status - antykafe. In this institution, which is sometimes called the "free space" or "third place", you only pay for the time spent and the remaining services - free of charge.</font>', '<pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><div>Since the discovery of alarming us so we do not accidentally turned into an internet cafe. These thoughts nadokuchaly and we think that is why we retrained and adopted Kyiv experience where one city to fully and profitably operates three schools with similar policies ( Dial , Bibliotech, Journal - IN)</div><div>How long took the time to prepare for the launch of the institution ?</div><div>About six months we knocked the wall, then painted them imported furniture.</div><div>How many people worked on the project ?</div><div>You know, it is hard to say. The people were many, and each made ​​their adjustments for better functioning of the project. People came and went from us , for that we thank them too .</div><div>Who is the target audience " Kommuny "?</div><div>If limited to age , it is young people aged 16 to 30 years. Young people are often going there for a good pastime - play board games, enjoy cocoa.</div><div>Mentioned cocoa , and what services you provide another ?</div><div>As you know , we pay for the visit , not the service. They are:</div><div>Day : 15 minutes - 5 UAH ( 20 USD first hour , and all subsequent to 16 USD)</div><div>Night : 30 minutes - 5 USD (1 hour - 10 hr)</div><div>We have a monthly subscription is also available with a 50% discount, and we are working 24 hours a day. The price per minute or hour includes use of board games ( which more than five) , netbooks and desktops , eating cocoa, stewed fruit , cookies, candy. We have easels, where you can draw as well as a variety of modern magazines. Every interested person , for an extra cost, can buy a so-called " snacks " , printed or perekseryty necessary , and to call abroad.</div><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><pnoto sans'';="" vertical-align:="" baseline;="" line-height:="" 23.796875px;"=""><p></p></pnoto></pnoto></pnoto></pnoto></pnoto></pnoto></pnoto></pnoto></pnoto></pnoto></pnoto>', 'a:6:{s:3:"uid";s:32:"0072199fb2fc7f75ea8008858414ec14";s:4:"name";s:16:"IMG_2899-640x426";s:9:"extension";s:3:"jpg";s:9:"pathLevel";i:2;s:4:"path";s:6:"/posts";s:5:"sizes";a:2:{s:4:"main";a:2:{s:1:"w";d:600;s:1:"h";d:399;}s:5:"small";a:2:{s:1:"w";d:300;s:1:"h";d:200;}}}', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `uc_settings`
--

DROP TABLE IF EXISTS `uc_settings`;
CREATE TABLE IF NOT EXISTS `uc_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `uc_settings`
--

INSERT INTO `uc_settings` (`id`, `key`) VALUES
(1, 'slogan'),
(2, 'blogTitle'),
(3, 'widgetName'),
(4, 'categoryName'),
(5, 'pagesName'),
(6, 'mainPageName');

-- --------------------------------------------------------

--
-- Table structure for table `uc_settings_langs`
--

DROP TABLE IF EXISTS `uc_settings_langs`;
CREATE TABLE IF NOT EXISTS `uc_settings_langs` (
  `table_lang_id` int(11) NOT NULL,
  `value` text NOT NULL,
  `lang` varchar(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uc_settings_langs`
--

INSERT INTO `uc_settings_langs` (`table_lang_id`, `value`, `lang`) VALUES
(1, 'UkrCms старається завоювати український вебпрості своєю швидкістю', 'ua'),
(1, 'UkrCms старается завоевать украинский веб пространство своей скоростью', 'ru'),
(1, 'UkrCms tries to win the Ukrainian web space for its speed', 'en'),
(2, 'Мій блог - моя фортеця', 'ua'),
(2, 'Мой блог - моя крепость', 'ru'),
(2, 'My blog - my castle', 'en'),
(3, 'Віджет', 'ua'),
(3, 'Виджет', 'ru'),
(3, 'Widget', 'en'),
(4, 'Категорія', 'ua'),
(4, 'Категория', 'ru'),
(4, 'Category', 'en'),
(5, 'Сторінки', 'ua'),
(5, 'Страницы', 'ru'),
(5, 'Pages', 'en'),
(6, 'Головна', 'ua'),
(6, 'Главная', 'ru'),
(6, 'Home', 'en');

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
