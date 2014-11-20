-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 20, 2014 at 12:02 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `myLexicon`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `base_lexemes`
--
CREATE TABLE IF NOT EXISTS `base_lexemes` (
`userid` int(10)
,`meaningid` int(10)
,`id` int(10)
,`language` char(2)
,`entry` varchar(255)
,`date_entered` timestamp
);
-- --------------------------------------------------------

--
-- Table structure for table `clarifications`
--

CREATE TABLE IF NOT EXISTS `clarifications` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `meaningid` int(10) NOT NULL,
  `clarification` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meaning_clarifications` (`meaningid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `clarifications`
--

INSERT INTO `clarifications` (`id`, `meaningid`, `clarification`) VALUES
(1, 73, 'music');

-- --------------------------------------------------------

--
-- Table structure for table `examples`
--

CREATE TABLE IF NOT EXISTS `examples` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `meaningid` int(10) NOT NULL,
  `example` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meaning_examples` (`meaningid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `name` char(49) DEFAULT NULL,
  `iso_639` char(2) NOT NULL,
  PRIMARY KEY (`iso_639`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`name`, `iso_639`) VALUES
('Afar', 'aa'),
('Abkhazian', 'ab'),
('Afrikaans', 'af'),
('Amharic', 'am'),
('Arabic', 'ar'),
('Assamese', 'as'),
('Aymara', 'ay'),
('Azerbaijani', 'az'),
('Bashkir', 'ba'),
('Byelorussian', 'be'),
('Bulgarian', 'bg'),
('Bihari', 'bh'),
('Bislama', 'bi'),
('Bengali/Bangla', 'bn'),
('Tibetan', 'bo'),
('Breton', 'br'),
('Catalan', 'ca'),
('Corsican', 'co'),
('Czech', 'cs'),
('Welsh', 'cy'),
('Danish', 'da'),
('German', 'de'),
('Bhutani', 'dz'),
('Greek', 'el'),
('English', 'en'),
('Esperanto', 'eo'),
('Spanish', 'es'),
('Estonian', 'et'),
('Basque', 'eu'),
('Persian', 'fa'),
('Finnish', 'fi'),
('Fiji', 'fj'),
('Faeroese', 'fo'),
('French', 'fr'),
('Frisian', 'fy'),
('Irish', 'ga'),
('Scots/Gaelic', 'gd'),
('Galician', 'gl'),
('Guarani', 'gn'),
('Gujarati', 'gu'),
('Hausa', 'ha'),
('Hindi', 'hi'),
('Croatian', 'hr'),
('Hungarian', 'hu'),
('Armenian', 'hy'),
('Interlingua', 'ia'),
('Interlingue', 'ie'),
('Inupiak', 'ik'),
('Indonesian', 'in'),
('Icelandic', 'is'),
('Italian', 'it'),
('Hebrew', 'iw'),
('Japanese', 'ja'),
('Yiddish', 'ji'),
('Javanese', 'jw'),
('Georgian', 'ka'),
('Kazakh', 'kk'),
('Greenlandic', 'kl'),
('Cambodian', 'km'),
('Kannada', 'kn'),
('Korean', 'ko'),
('Kashmiri', 'ks'),
('Kurdish', 'ku'),
('Kirghiz', 'ky'),
('Latin', 'la'),
('Lingala', 'ln'),
('Laothian', 'lo'),
('Lithuanian', 'lt'),
('Latvian/Lettish', 'lv'),
('Malagasy', 'mg'),
('Maori', 'mi'),
('Macedonian', 'mk'),
('Malayalam', 'ml'),
('Mongolian', 'mn'),
('Moldavian', 'mo'),
('Marathi', 'mr'),
('Malay', 'ms'),
('Maltese', 'mt'),
('Burmese', 'my'),
('Nauru', 'na'),
('Nepali', 'ne'),
('Dutch', 'nl'),
('Norwegian', 'no'),
('Occitan', 'oc'),
('(Afan)/Oromoor/Oriya', 'om'),
('Punjabi', 'pa'),
('Polish', 'pl'),
('Pashto/Pushto', 'ps'),
('Portuguese', 'pt'),
('Quechua', 'qu'),
('Rhaeto-Romance', 'rm'),
('Kirundi', 'rn'),
('Romanian', 'ro'),
('Russian', 'ru'),
('Kinyarwanda', 'rw'),
('Sanskrit', 'sa'),
('Sindhi', 'sd'),
('Sangro', 'sg'),
('Serbo-Croatian', 'sh'),
('Singhalese', 'si'),
('Slovak', 'sk'),
('Slovenian', 'sl'),
('Samoan', 'sm'),
('Shona', 'sn'),
('Somali', 'so'),
('Albanian', 'sq'),
('Serbian', 'sr'),
('Siswati', 'ss'),
('Sesotho', 'st'),
('Sundanese', 'su'),
('Swedish', 'sv'),
('Swahili', 'sw'),
('Tamil', 'ta'),
('Tegulu', 'te'),
('Tajik', 'tg'),
('Thai', 'th'),
('Tigrinya', 'ti'),
('Turkmen', 'tk'),
('Tagalog', 'tl'),
('Setswana', 'tn'),
('Tonga', 'to'),
('Turkish', 'tr'),
('Tsonga', 'ts'),
('Tatar', 'tt'),
('Twi', 'tw'),
('Ukrainian', 'uk'),
('Urdu', 'ur'),
('Uzbek', 'uz'),
('Vietnamese', 'vi'),
('Volapuk', 'vo'),
('Wolof', 'wo'),
('Xhosa', 'xh'),
('Yoruba', 'yo'),
('Chinese', 'zh'),
('Zulu', 'zu');

-- --------------------------------------------------------

--
-- Table structure for table `lexemes`
--

CREATE TABLE IF NOT EXISTS `lexemes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `language` char(2) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `entry` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_lexeme` (`language`,`entry`,`type`),
  KEY `lexeme_language` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=124 ;

--
-- Dumping data for table `lexemes`
--

INSERT INTO `lexemes` (`id`, `language`, `type`, `entry`) VALUES
(36, 'de', 'verb', 'annehmen'),
(54, 'de', 'verb', 'aufbrechen'),
(112, 'de', 'verb', 'auflegen'),
(104, 'de', 'verb', 'begeistern'),
(78, 'de', 'verb', 'bewältigen'),
(22, 'de', 'noun', 'das Anschreiben'),
(88, 'de', 'noun', 'das Gericht'),
(62, 'de', 'noun', 'das Gerücht'),
(51, 'de', 'noun', 'das Ufer'),
(30, 'de', 'noun', 'das Verzeichnis'),
(49, 'de', 'noun', 'der Hafen'),
(96, 'de', 'noun', 'der Hubschrauber'),
(90, 'de', 'noun', 'der Stift'),
(34, 'de', 'noun', 'der Versprecher'),
(24, 'de', 'noun', 'der Vorgang'),
(67, 'de', 'noun', 'der Vorstand'),
(18, 'de', 'noun', 'die Anforderung'),
(5, 'de', 'noun', 'die Anleitung'),
(28, 'de', 'noun', 'die Fabel'),
(65, 'de', 'noun', 'die Gewissheit'),
(20, 'de', 'noun', 'die Rechnung'),
(98, 'de', 'noun', 'die Sauftour'),
(119, 'de', 'noun', 'die Scheibe'),
(116, 'de', 'verb', 'durchsetzen'),
(14, 'de', 'verb', 'erfordern'),
(100, 'de', 'adjective/adverb', 'gelaunt'),
(69, 'de', 'verb', 'jmdm. etw. mitteilen'),
(73, 'de', 'verb', 'jmdm. für etw. loben'),
(110, 'de', 'adjective/adverb', 'jmdm. zu Ehren'),
(42, 'de', 'phrasal verb', 'jmdm. zum Schweigen bringen'),
(102, 'de', 'verb', 'jubeln'),
(60, 'de', 'verb', 'losgehen'),
(85, 'de', 'verb', 'monieren'),
(122, 'de', 'adjective/adverb', 'schnurstracks'),
(108, 'de', 'verb', 'schütteln'),
(114, 'de', 'verb', 'sich durchsetzen'),
(106, 'de', 'verb', 'sich für etw. begeistern'),
(1, 'de', 'verb', 'sich von jmdm. verabschieden'),
(92, 'de', 'verb', 'sperren'),
(75, 'de', 'adjective/adverb', 'stellvertretend'),
(45, 'de', 'verb', 'verdrängen'),
(10, 'de', 'verb', 'verfassen'),
(41, 'de', 'phrasal verb', 'über eine Fertigkeit verfügen'),
(39, 'de', 'phrasal verb', 'über eine Fähigkeit verfügen'),
(82, 'de', 'verb', 'zerschlagen'),
(26, 'en', 'noun', 'art'),
(77, 'en', 'adjective/adverb', 'assistant'),
(53, 'en', 'noun', 'bank'),
(21, 'en', 'noun', 'bill'),
(66, 'en', 'noun', 'certainty'),
(23, 'en', 'noun', 'correspondence'),
(89, 'en', 'noun', 'court'),
(76, 'en', 'adjective/adverb', 'deputy'),
(9, 'en', 'noun', 'direction'),
(121, 'en', 'noun', 'disc'),
(29, 'en', 'noun', 'fable'),
(8, 'en', 'noun', 'guidance'),
(50, 'en', 'noun', 'harbour'),
(97, 'en', 'noun', 'helicopter'),
(101, 'en', 'adjective/adverb', 'humoured'),
(111, 'en', 'adjective/adverb', 'in so.''s honour'),
(33, 'en', 'noun', 'index'),
(31, 'en', 'noun', 'list'),
(68, 'en', 'noun', 'management'),
(63, 'en', 'noun', 'myth'),
(91, 'en', 'noun', 'pen'),
(27, 'en', 'noun', 'procedure'),
(25, 'en', 'noun', 'process'),
(99, 'en', 'noun', 'pub crawl'),
(32, 'en', 'noun', 'register'),
(19, 'en', 'noun', 'requirement'),
(64, 'en', 'noun', 'rumour'),
(52, 'en', 'noun', 'shore'),
(120, 'en', 'noun', 'slice'),
(35, 'en', 'noun', 'slip of the tongue'),
(123, 'en', 'adjective/adverb', 'straightaway'),
(37, 'en', 'verb', 'to accept'),
(83, 'en', 'verb', 'to annihilate'),
(12, 'en', 'verb', 'to author'),
(107, 'en', 'verb', 'to be crazy about sth.'),
(94, 'en', 'verb', 'to block out'),
(103, 'en', 'verb', 'to cheer'),
(40, 'en', 'phrasal verb', 'to command a skill'),
(86, 'en', 'verb', 'to complain'),
(74, 'en', 'verb', 'to compliment so. on sth.'),
(13, 'en', 'verb', 'to compose'),
(87, 'en', 'verb', 'to criticise'),
(15, 'en', 'verb', 'to demand'),
(48, 'en', 'verb', 'to displace'),
(117, 'en', 'verb', 'to enforce'),
(72, 'en', 'verb', 'to inform so. about sth.'),
(105, 'en', 'verb', 'to inspire'),
(55, 'en', 'verb', 'to leave'),
(95, 'en', 'verb', 'to lock'),
(80, 'en', 'verb', 'to manage'),
(16, 'en', 'verb', 'to necessitate'),
(81, 'en', 'verb', 'to overcome'),
(113, 'en', 'verb', 'to play'),
(115, 'en', 'verb', 'to prevail'),
(118, 'en', 'verb', 'to push'),
(47, 'en', 'verb', 'to replace'),
(17, 'en', 'verb', 'to require'),
(2, 'en', 'verb', 'to say goodbye'),
(109, 'en', 'verb', 'to shake'),
(71, 'en', 'verb', 'to share sth. with so.'),
(43, 'en', 'verb', 'to silence so.'),
(84, 'en', 'verb', 'to smash'),
(93, 'en', 'verb', 'to stop'),
(46, 'en', 'verb', 'to supersede'),
(38, 'en', 'verb', 'to suppose'),
(79, 'en', 'verb', 'to tackle'),
(3, 'en', 'verb', 'to take one''s leave of so.'),
(70, 'en', 'verb', 'to tell so. sth.'),
(11, 'en', 'verb', 'to write'),
(4, 'fr', 'verb', 'congédier qn.');

-- --------------------------------------------------------

--
-- Table structure for table `meanings`
--

CREATE TABLE IF NOT EXISTS `meanings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) DEFAULT NULL,
  `targetid` int(10) NOT NULL,
  `baseid` int(10) NOT NULL,
  `frequency` int(10) NOT NULL DEFAULT '1',
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_meaning_per_user_constraint` (`targetid`,`baseid`,`userid`),
  KEY `base` (`targetid`),
  KEY `target` (`baseid`),
  KEY `user_meaning` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

--
-- Dumping data for table `meanings`
--

INSERT INTO `meanings` (`id`, `userid`, `targetid`, `baseid`, `frequency`, `date_entered`) VALUES
(1, 1, 1, 2, 1, '2014-11-17 07:37:55'),
(2, 1, 1, 3, 1, '2014-11-17 08:09:21'),
(3, 1, 1, 4, 1, '2014-11-17 08:42:13'),
(4, 1, 5, 8, 1, '2014-11-18 08:37:34'),
(5, 1, 5, 9, 1, '2014-11-18 08:39:18'),
(6, 1, 10, 11, 1, '2014-11-18 08:41:49'),
(7, 1, 10, 12, 1, '2014-11-18 08:41:53'),
(8, 1, 10, 13, 1, '2014-11-18 08:42:01'),
(10, 1, 14, 15, 1, '2014-11-18 08:53:27'),
(11, 1, 14, 16, 1, '2014-11-18 08:53:34'),
(12, 1, 14, 17, 1, '2014-11-18 08:53:39'),
(14, 1, 18, 19, 1, '2014-11-18 08:55:07'),
(15, 1, 20, 21, 1, '2014-11-18 08:57:02'),
(16, 1, 22, 23, 1, '2014-11-18 08:57:55'),
(17, 1, 24, 25, 1, '2014-11-18 08:59:05'),
(18, 1, 24, 26, 1, '2014-11-18 08:59:10'),
(19, 1, 24, 27, 1, '2014-11-18 08:59:14'),
(20, 1, 28, 29, 1, '2014-11-18 09:00:39'),
(22, 1, 30, 31, 1, '2014-11-18 09:04:37'),
(23, 1, 30, 32, 1, '2014-11-18 09:04:41'),
(24, 1, 30, 33, 1, '2014-11-18 09:04:49'),
(25, 1, 34, 35, 1, '2014-11-18 09:05:52'),
(26, 1, 36, 37, 1, '2014-11-18 09:07:02'),
(27, 1, 36, 38, 1, '2014-11-18 09:07:09'),
(28, 1, 39, 40, 1, '2014-11-18 09:19:35'),
(29, 1, 41, 40, 1, '2014-11-18 09:19:35'),
(30, 1, 42, 43, 1, '2014-11-18 09:25:59'),
(31, 1, 45, 46, 1, '2014-11-19 08:07:19'),
(32, 1, 45, 47, 1, '2014-11-19 08:07:36'),
(33, 1, 45, 48, 1, '2014-11-19 08:08:15'),
(34, 1, 49, 50, 1, '2014-11-19 08:10:33'),
(35, 1, 51, 52, 1, '2014-11-19 08:11:31'),
(36, 1, 51, 53, 1, '2014-11-19 08:11:40'),
(37, 1, 54, 55, 1, '2014-11-19 08:14:04'),
(39, 1, 60, 55, 1, '2014-11-19 08:14:04'),
(41, 1, 62, 63, 1, '2014-11-19 08:34:57'),
(42, 1, 62, 64, 1, '2014-11-19 08:35:01'),
(44, 1, 65, 66, 1, '2014-11-19 08:46:54'),
(45, 1, 67, 68, 1, '2014-11-19 08:48:27'),
(46, 1, 69, 70, 1, '2014-11-19 08:50:18'),
(47, 1, 69, 71, 1, '2014-11-19 08:50:39'),
(48, 1, 69, 72, 1, '2014-11-19 08:50:54'),
(49, 1, 73, 74, 1, '2014-11-19 08:53:16'),
(50, 1, 75, 76, 1, '2014-11-19 09:18:53'),
(51, 1, 75, 77, 1, '2014-11-19 09:19:00'),
(52, 1, 78, 79, 1, '2014-11-19 09:21:10'),
(53, 1, 78, 80, 1, '2014-11-19 09:21:16'),
(54, 1, 78, 81, 1, '2014-11-19 09:21:19'),
(55, 1, 82, 83, 1, '2014-11-19 09:32:28'),
(57, 1, 82, 84, 1, '2014-11-19 09:32:44'),
(58, 1, 85, 86, 1, '2014-11-19 09:34:45'),
(59, 1, 85, 87, 1, '2014-11-19 09:34:54'),
(60, 1, 88, 89, 1, '2014-11-19 09:36:07'),
(61, 1, 90, 91, 1, '2014-11-19 14:28:12'),
(62, 1, 92, 93, 1, '2014-11-19 14:30:50'),
(63, 1, 92, 94, 1, '2014-11-19 14:30:56'),
(64, 1, 92, 95, 1, '2014-11-19 14:31:05'),
(65, 1, 96, 97, 1, '2014-11-19 14:33:05'),
(66, 1, 98, 99, 1, '2014-11-19 14:34:21'),
(67, 1, 100, 101, 1, '2014-11-19 14:35:59'),
(68, 1, 102, 103, 1, '2014-11-19 14:36:40'),
(69, 1, 104, 105, 1, '2014-11-19 14:38:04'),
(70, 1, 106, 107, 1, '2014-11-19 14:38:44'),
(71, 1, 108, 109, 1, '2014-11-19 14:39:22'),
(72, 1, 110, 111, 1, '2014-11-19 14:42:53'),
(73, 1, 112, 113, 1, '2014-11-19 14:47:23'),
(74, 1, 114, 115, 1, '2014-11-19 15:02:18'),
(75, 1, 116, 117, 1, '2014-11-19 15:03:19'),
(76, 1, 116, 118, 1, '2014-11-19 15:03:25'),
(77, 1, 119, 120, 1, '2014-11-19 15:05:36'),
(78, 1, 119, 121, 1, '2014-11-19 15:05:45'),
(79, 1, 122, 123, 1, '2014-11-19 15:10:20');

-- --------------------------------------------------------

--
-- Stand-in structure for view `target_lexemes`
--
CREATE TABLE IF NOT EXISTS `target_lexemes` (
`id` int(10)
,`language` char(2)
,`type` varchar(30)
,`entry` varchar(255)
,`baseid` int(10)
,`frequency` int(10)
);
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `target_language` char(2) NOT NULL,
  `base_language` char(2) NOT NULL,
  `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `user_base_language` (`base_language`),
  KEY `user_target_language` (`target_language`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `target_language`, `base_language`, `date_joined`) VALUES
(1, 'deanrobertcook', 'password', 'de', 'en', '2014-11-17 07:35:16'),
(2, 'testUser', 'password', 'de', 'en', '2014-11-20 11:46:42');

-- --------------------------------------------------------

--
-- Stand-in structure for view `word_list`
--
CREATE TABLE IF NOT EXISTS `word_list` (
`meaningid` int(10)
,`frequency` int(10)
,`target_id` int(10)
,`target_entry_type` varchar(30)
,`target_entry` varchar(255)
,`base_id` int(10)
,`base_entry` varchar(255)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `word_list_verbose`
--
CREATE TABLE IF NOT EXISTS `word_list_verbose` (
`userid` int(10)
,`meaningid` int(10)
,`frequency` int(10)
,`target_id` int(10)
,`target_language` char(2)
,`target_entry_type` varchar(30)
,`target_entry` varchar(255)
,`base_id` int(10)
,`base_language` char(2)
,`base_entry` varchar(255)
,`date_entered` timestamp
);
-- --------------------------------------------------------

--
-- Structure for view `base_lexemes`
--
DROP TABLE IF EXISTS `base_lexemes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `base_lexemes` AS select distinct `meanings`.`userid` AS `userid`,`meanings`.`id` AS `meaningid`,`lexemes`.`id` AS `id`,`lexemes`.`language` AS `language`,`lexemes`.`entry` AS `entry`,`meanings`.`date_entered` AS `date_entered` from (`lexemes` join `meanings` on((`lexemes`.`id` = `meanings`.`baseid`)));

-- --------------------------------------------------------

--
-- Structure for view `target_lexemes`
--
DROP TABLE IF EXISTS `target_lexemes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `target_lexemes` AS select `lexemes`.`id` AS `id`,`lexemes`.`language` AS `language`,`lexemes`.`type` AS `type`,`lexemes`.`entry` AS `entry`,`meanings`.`baseid` AS `baseid`,`meanings`.`frequency` AS `frequency` from (`lexemes` join `meanings` on((`lexemes`.`id` = `meanings`.`targetid`)));

-- --------------------------------------------------------

--
-- Structure for view `word_list`
--
DROP TABLE IF EXISTS `word_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `word_list` AS select `base_lexemes`.`meaningid` AS `meaningid`,`target_lexemes`.`frequency` AS `frequency`,`target_lexemes`.`id` AS `target_id`,`target_lexemes`.`type` AS `target_entry_type`,`target_lexemes`.`entry` AS `target_entry`,`base_lexemes`.`id` AS `base_id`,`base_lexemes`.`entry` AS `base_entry` from (`target_lexemes` join `base_lexemes` on((`target_lexemes`.`baseid` = `base_lexemes`.`id`)));

-- --------------------------------------------------------

--
-- Structure for view `word_list_verbose`
--
DROP TABLE IF EXISTS `word_list_verbose`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `word_list_verbose` AS select `base_lexemes`.`userid` AS `userid`,`base_lexemes`.`meaningid` AS `meaningid`,`target_lexemes`.`frequency` AS `frequency`,`target_lexemes`.`id` AS `target_id`,`target_lexemes`.`language` AS `target_language`,`target_lexemes`.`type` AS `target_entry_type`,`target_lexemes`.`entry` AS `target_entry`,`base_lexemes`.`id` AS `base_id`,`base_lexemes`.`language` AS `base_language`,`base_lexemes`.`entry` AS `base_entry`,`base_lexemes`.`date_entered` AS `date_entered` from (`target_lexemes` join `base_lexemes` on((`target_lexemes`.`baseid` = `base_lexemes`.`id`)));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clarifications`
--
ALTER TABLE `clarifications`
  ADD CONSTRAINT `meaning_clarifications` FOREIGN KEY (`meaningID`) REFERENCES `meanings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `examples`
--
ALTER TABLE `examples`
  ADD CONSTRAINT `meaning_examples` FOREIGN KEY (`meaningID`) REFERENCES `meanings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lexemes`
--
ALTER TABLE `lexemes`
  ADD CONSTRAINT `lexeme_language` FOREIGN KEY (`language`) REFERENCES `languages` (`iso_639`) ON UPDATE CASCADE;

--
-- Constraints for table `meanings`
--
ALTER TABLE `meanings`
  ADD CONSTRAINT `base` FOREIGN KEY (`targetid`) REFERENCES `lexemes` (`id`),
  ADD CONSTRAINT `target` FOREIGN KEY (`baseid`) REFERENCES `lexemes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_meaning` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_base_language` FOREIGN KEY (`base_language`) REFERENCES `languages` (`iso_639`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_target_language` FOREIGN KEY (`target_language`) REFERENCES `languages` (`iso_639`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
