-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2017 at 12:21 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minyy`
--
CREATE DATABASE IF NOT EXISTS `minyy` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `minyy`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `pk_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) DEFAULT NULL,
  `module_name` varchar(20) NOT NULL,
  `parent_comment_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  `comment_status` varchar(20) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `guid` varchar(255) DEFAULT NULL,
  `comment_params` text,
  PRIMARY KEY (`pk_comment_id`),
  KEY `parent_id` (`parent_comment_id`) USING BTREE,
  KEY `created_by` (`created_by`) USING BTREE,
  KEY `modified_by` (`modified_by`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`pk_comment_id`, `object_id`, `module_name`, `parent_comment_id`, `created_by`, `created_at`, `content`, `comment_status`, `modified_by`, `modified_date`, `guid`, `comment_params`) VALUES
(1, 4, 'medias', NULL, 29, '2017-05-21 19:11:57', 'nanenane', 'published', 1, NULL, 'adsasdasd', NULL),
(2, 5, 'medias', NULL, 29, '2017-05-21 19:11:57', 'aşslkjdşlaksjd', 'published', NULL, NULL, 'dsds', NULL),
(3, 5, 'medias', 2, 29, '2017-05-21 19:11:57', 'asdasdasd', 'asdad', NULL, NULL, 'wrfwer32', NULL),
(4, 5, 'medias', 2, 1, '2017-05-21 19:11:57', 'bu da ikinci yorumum', 'published', NULL, NULL, 'asdasdasd', NULL),
(5, 5, 'medias', NULL, 7, '2017-06-21 20:11:57', 'bu kök yorumdur', 'published', NULL, NULL, 'adasdasd', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `pk_lang_id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_name` tinytext NOT NULL,
  `lang_code` varchar(8) NOT NULL,
  `lang_status` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`pk_lang_id`),
  KEY `lang_code` (`lang_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=294 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`pk_lang_id`, `lang_name`, `lang_code`, `lang_status`) VALUES
(1, 'Afar [aa]', 'aa', 'normal'),
(2, 'Abkhazian [ab]', 'ab', 'normal'),
(3, 'Avestan [ae]', 'ae', 'normal'),
(4, 'Tunisian Arabic [aeb]', 'aeb', 'normal'),
(5, 'Afrikaans [af]', 'af', 'normal'),
(6, 'Akan [aka]', 'aka', 'normal'),
(7, 'Amharic [amh]', 'amh', 'normal'),
(8, 'Amis [ami]', 'ami', 'normal'),
(9, 'Aragonese [an]', 'an', 'normal'),
(10, 'Aramaic [arc]', 'arc', 'normal'),
(11, 'Algerian Arabic [arq]', 'arq', 'normal'),
(12, 'Egyptian Arabic [arz]', 'arz', 'normal'),
(13, 'Assamese [as]', 'as', 'normal'),
(14, 'American Sign Language [ase]', 'ase', 'normal'),
(15, 'Asturian [ast]', 'ast', 'normal'),
(16, 'Avaric [av]', 'av', 'normal'),
(17, 'Aymara [ay]', 'ay', 'normal'),
(18, 'Azerbaijani [az]', 'az', 'normal'),
(19, 'Bashkir [ba]', 'ba', 'normal'),
(20, 'Bambara [bam]', 'bam', 'normal'),
(21, 'Belarusian [be]', 'be', 'normal'),
(22, 'Bemba (Zambia) [bem]', 'bem', 'normal'),
(23, 'Berber [ber]', 'ber', 'normal'),
(24, 'Bulgarian [bg]', 'bg', 'normal'),
(25, 'Bihari [bh]', 'bh', 'normal'),
(26, 'Bislama [bi]', 'bi', 'normal'),
(27, 'Bengali [bn]', 'bn', 'normal'),
(28, 'Ibibio [bnt]', 'bnt', 'normal'),
(29, 'Tibetan [bo]', 'bo', 'normal'),
(30, 'Breton [br]', 'br', 'normal'),
(31, 'Bosnian [bs]', 'bs', 'normal'),
(32, 'Buginese [bug]', 'bug', 'normal'),
(33, 'Catalan [ca]', 'ca', 'normal'),
(34, 'Cakchiquel, Central [cak]', 'cak', 'normal'),
(35, 'Chechen [ce]', 'ce', 'normal'),
(36, 'Cebuano [ceb]', 'ceb', 'normal'),
(37, 'Chamorro [ch]', 'ch', 'normal'),
(38, 'Choctaw [cho]', 'cho', 'normal'),
(39, 'Cherokee [chr]', 'chr', 'normal'),
(40, 'Kurdish (Central) [ckb]', 'ckb', 'normal'),
(41, 'Koasati [cku]', 'cku', 'normal'),
(42, 'Eastern Chatino [cly]', 'cly', 'normal'),
(43, 'Hakha Chin [cnh]', 'cnh', 'normal'),
(44, 'Corsican [co]', 'co', 'normal'),
(45, 'Cree [cr]', 'cr', 'normal'),
(46, 'Seselwa Creole French [crs]', 'crs', 'normal'),
(47, 'Tataltepec Chatino [cta]', 'cta', 'normal'),
(48, 'Chin, Tedim [ctd]', 'ctd', 'normal'),
(49, 'Chol, Tumbalá [ctu]', 'ctu', 'normal'),
(50, 'Church Slavic [cu]', 'cu', 'normal'),
(51, 'Chuvash [cv]', 'cv', 'normal'),
(52, 'Welsh [cy]', 'cy', 'normal'),
(53, 'Zenzontepec Chatino [czn]', 'czn', 'normal'),
(54, 'German (Switzerland) [de-ch]', 'de-ch', 'normal'),
(55, 'Lower Sorbian [dsb]', 'dsb', 'normal'),
(56, 'Divehi [dv]', 'dv', 'normal'),
(57, 'Dzongkha [dz]', 'dz', 'normal'),
(58, 'Ewe [ee]', 'ee', 'normal'),
(59, 'Efik [efi]', 'efi', 'normal'),
(60, 'English, British [en-gb]', 'en-gb', 'normal'),
(61, 'Esperanto [eo]', 'eo', 'normal'),
(62, 'Spanish, Argentinian [es-ar]', 'es-ar', 'normal'),
(63, 'Spanish, Mexican [es-mx]', 'es-mx', 'normal'),
(64, 'Spanish, Nicaraguan [es-ni]', 'es-ni', 'normal'),
(65, 'Estonian [et]', 'et', 'normal'),
(66, 'Basque [eu]', 'eu', 'normal'),
(67, 'Fulah [ff]', 'ff', 'normal'),
(68, 'Finnish [fi]', 'fi', 'normal'),
(69, 'Filipino [fil]', 'fil', 'normal'),
(70, 'Fijian [fj]', 'fj', 'normal'),
(71, 'Faroese [fo]', 'fo', 'normal'),
(72, 'French (Canada) [fr-ca]', 'fr-ca', 'normal'),
(73, 'Fula [ful]', 'ful', 'normal'),
(74, 'Frisian [fy-nl]', 'fy-nl', 'normal'),
(75, 'Irish [ga]', 'ga', 'normal'),
(76, 'Scottish Gaelic [gd]', 'gd', 'normal'),
(77, 'Galician [gl]', 'gl', 'normal'),
(78, 'Guaran [gn]', 'gn', 'normal'),
(79, 'Gothic [got]', 'got', 'normal'),
(80, 'Swiss German [gsw]', 'gsw', 'normal'),
(81, 'Gujarati [gu]', 'gu', 'normal'),
(82, 'Manx [gv]', 'gv', 'normal'),
(83, 'Haida [hai]', 'hai', 'normal'),
(84, 'Hausa [hau]', 'hau', 'normal'),
(85, 'Hawaiian [haw]', 'haw', 'normal'),
(86, 'Hazaragi [haz]', 'haz', 'normal'),
(87, 'HamariBoli (Roman Hindi-Urdu) [hb]', 'hb', 'normal'),
(88, 'Huichol [hch]', 'hch', 'normal'),
(89, 'Hebrew [he]', 'he', 'normal'),
(90, 'Hindi [hi]', 'hi', 'normal'),
(91, 'Hmong [hmn]', 'hmn', 'normal'),
(92, 'Hiri Motu [ho]', 'ho', 'normal'),
(93, 'Croatian [hr]', 'hr', 'normal'),
(94, 'Upper Sorbian [hsb]', 'hsb', 'normal'),
(95, 'Creole, Haitian [ht]', 'ht', 'normal'),
(96, 'Hupa [hup]', 'hup', 'normal'),
(97, 'Huastec, Veracruz [hus]', 'hus', 'normal'),
(98, 'Armenian [hy]', 'hy', 'normal'),
(99, 'Herero [hz]', 'hz', 'normal'),
(100, 'Interlingua [ia]', 'ia', 'normal'),
(101, 'Igbo [ibo]', 'ibo', 'normal'),
(102, 'Interlingue [ie]', 'ie', 'normal'),
(103, 'Sichuan Yi [ii]', 'ii', 'normal'),
(104, 'Inupia [ik]', 'ik', 'normal'),
(105, 'Ilocano [ilo]', 'ilo', 'normal'),
(106, 'Ingush [inh]', 'inh', 'normal'),
(107, 'Ido [io]', 'io', 'normal'),
(108, 'Iroquoian languages [iro]', 'iro', 'normal'),
(109, 'Icelandic [is]', 'is', 'normal'),
(110, 'Inuktitut [iu]', 'iu', 'normal'),
(111, 'Javanese [jv]', 'jv', 'normal'),
(112, 'Georgian [ka]', 'ka', 'normal'),
(113, 'Karakalpak [kaa]', 'kaa', 'normal'),
(114, 'Karen [kar]', 'kar', 'normal'),
(115, 'Kanuri [kau]', 'kau', 'normal'),
(116, 'Gikuyu [kik]', 'kik', 'normal'),
(117, 'Rwandi [kin]', 'kin', 'normal'),
(118, 'Kuanyama, Kwanyama [kj]', 'kj', 'normal'),
(119, 'Kazakh [kk]', 'kk', 'normal'),
(120, 'Greenlandic [kl]', 'kl', 'normal'),
(121, 'Khmer [km]', 'km', 'normal'),
(122, 'Kannada [kn]', 'kn', 'normal'),
(123, 'Kongo [kon]', 'kon', 'normal'),
(124, 'Kashmiri [ks]', 'ks', 'normal'),
(125, 'Colognian [ksh]', 'ksh', 'normal'),
(126, 'Kurdish [ku]', 'ku', 'normal'),
(127, 'Komi [kv]', 'kv', 'normal'),
(128, 'Cornish [kw]', 'kw', 'normal'),
(129, 'Kyrgyz [ky]', 'ky', 'normal'),
(130, 'Latin [la]', 'la', 'normal'),
(131, 'Luxembourgish [lb]', 'lb', 'normal'),
(132, 'Ganda [lg]', 'lg', 'normal'),
(133, 'Limburgish [li]', 'li', 'normal'),
(134, 'Lingala [lin]', 'lin', 'normal'),
(135, 'Lakota [lkt]', 'lkt', 'normal'),
(136, 'Ladin [lld]', 'lld', 'normal'),
(137, 'Lao [lo]', 'lo', 'normal'),
(138, 'Lithuanian [lt]', 'lt', 'normal'),
(139, 'Latgalian [ltg]', 'ltg', 'normal'),
(140, 'Luba-Katagana [lu]', 'lu', 'normal'),
(141, 'Luba-Kasai [lua]', 'lua', 'normal'),
(142, 'Luo [luo]', 'luo', 'normal'),
(143, 'Mizo [lus]', 'lus', 'normal'),
(144, 'Lushootseed [lut]', 'lut', 'normal'),
(145, 'Luhya [luy]', 'luy', 'normal'),
(146, 'Latvian [lv]', 'lv', 'normal'),
(147, 'Madurese [mad]', 'mad', 'normal'),
(148, 'Mauritian Creole [mfe]', 'mfe', 'normal'),
(149, 'Marshallese [mh]', 'mh', 'normal'),
(150, 'Maori [mi]', 'mi', 'normal'),
(151, 'Macedonian [mk]', 'mk', 'normal'),
(152, 'Malayalam [ml]', 'ml', 'normal'),
(153, 'Malagasy [mlg]', 'mlg', 'normal'),
(154, 'Mongolian [mn]', 'mn', 'normal'),
(155, 'Manipuri [mni]', 'mni', 'normal'),
(156, 'Mandinka [mnk]', 'mnk', 'normal'),
(157, 'Moldavian, Moldovan [mo]', 'mo', 'normal'),
(158, 'Mohawk [moh]', 'moh', 'normal'),
(159, 'Mossi [mos]', 'mos', 'normal'),
(160, 'Marathi [mr]', 'mr', 'normal'),
(161, 'Malay [ms]', 'ms', 'normal'),
(162, 'Maltese [mt]', 'mt', 'normal'),
(163, 'Muscogee [mus]', 'mus', 'normal'),
(164, 'Burmese [my]', 'my', 'normal'),
(165, 'Naurunan [na]', 'na', 'normal'),
(166, 'Hokkien [nan]', 'nan', 'normal'),
(167, 'Norwegian Bokmal [nb]', 'nb', 'normal'),
(168, 'Nahuatl, Classical [nci]', 'nci', 'normal'),
(169, 'North Ndebele [nd]', 'nd', 'normal'),
(170, 'Nepali [ne]', 'ne', 'normal'),
(171, 'Ndonga [ng]', 'ng', 'normal'),
(172, 'Norwegian Nynorsk [nn]', 'nn', 'normal'),
(173, 'Southern Ndebele [nr]', 'nr', 'normal'),
(174, 'Northern Sotho [nso]', 'nso', 'normal'),
(175, 'Navajo [nv]', 'nv', 'normal'),
(176, 'Chewa [nya]', 'nya', 'normal'),
(177, 'Occitan [oc]', 'oc', 'normal'),
(178, 'Ojibwe [oji]', 'oji', 'normal'),
(179, 'Oriya [or]', 'or', 'normal'),
(180, 'Oromo [orm]', 'orm', 'normal'),
(181, 'Ossetian, Ossetic [os]', 'os', 'normal'),
(182, 'Kapampangan [pam]', 'pam', 'normal'),
(183, 'Punjabi [pan]', 'pan', 'normal'),
(184, 'Papiamento [pap]', 'pap', 'normal'),
(185, 'Picard [pcd]', 'pcd', 'normal'),
(186, 'Nigerian Pidgin [pcm]', 'pcm', 'normal'),
(187, 'Pali [pi]', 'pi', 'normal'),
(188, 'Western Punjabi [pnb]', 'pnb', 'normal'),
(189, 'Dari [prs]', 'prs', 'normal'),
(190, 'Pashto [ps]', 'ps', 'normal'),
(191, 'Quechua [que]', 'que', 'normal'),
(192, 'Quichua, Imbabura Highland [qvi]', 'qvi', 'normal'),
(193, 'Rajasthani [raj]', 'raj', 'normal'),
(194, 'Cook Islands Māori [rar]', 'rar', 'normal'),
(195, 'Romansh [rm]', 'rm', 'normal'),
(196, 'Rundi [run]', 'run', 'normal'),
(197, 'Macedo [rup]', 'rup', 'normal'),
(198, 'Rusyn [ry]', 'ry', 'normal'),
(199, 'Sanskrit [sa]', 'sa', 'normal'),
(200, 'Sardinian [sc]', 'sc', 'normal'),
(201, 'Sicilian [scn]', 'scn', 'normal'),
(202, 'Scots [sco]', 'sco', 'normal'),
(203, 'Sindhi [sd]', 'sd', 'normal'),
(204, 'Northern Sami [se]', 'se', 'normal'),
(205, 'Sango [sg]', 'sg', 'normal'),
(206, 'Sign Languages [sgn]', 'sgn', 'normal'),
(207, 'Serbo-Croatian [sh]', 'sh', 'normal'),
(208, 'Sinhala [si]', 'si', 'normal'),
(209, 'Slovak [sk]', 'sk', 'normal'),
(210, 'Seko Padang [skx]', 'skx', 'normal'),
(211, 'Slovenian [sl]', 'sl', 'normal'),
(212, 'Samoan [sm]', 'sm', 'normal'),
(213, 'Shona [sna]', 'sna', 'normal'),
(214, 'Somali [som]', 'som', 'normal'),
(215, 'Sotho [sot]', 'sot', 'normal'),
(216, 'Albanian [sq]', 'sq', 'normal'),
(217, 'Serbian [sr]', 'sr', 'normal'),
(218, 'Serbian, Latin [sr-latn]', 'sr-latn', 'normal'),
(219, 'Montenegrin [srp]', 'srp', 'normal'),
(220, 'Swati [ss]', 'ss', 'normal'),
(221, 'Sundanese [su]', 'su', 'normal'),
(222, 'Swahili [swa]', 'swa', 'normal'),
(223, 'Silesian [szl]', 'szl', 'normal'),
(224, 'Tamil [ta]', 'ta', 'normal'),
(225, 'Yami (Tao) [tao]', 'tao', 'normal'),
(226, 'Tarahumara, Central [tar]', 'tar', 'normal'),
(227, 'Telugu [te]', 'te', 'normal'),
(228, 'Tetum [tet]', 'tet', 'normal'),
(229, 'Tajik [tg]', 'tg', 'normal'),
(230, 'Tigrinya [tir]', 'tir', 'normal'),
(231, 'Turkmen [tk]', 'tk', 'normal'),
(232, 'Tagalog [tl]', 'tl', 'normal'),
(233, 'Klingon [tlh]', 'tlh', 'normal'),
(234, 'Tonga [to]', 'to', 'normal'),
(235, 'Tojolabal [toj]', 'toj', 'normal'),
(236, 'Seediq [trv]', 'trv', 'normal'),
(237, 'Tsonga [ts]', 'ts', 'normal'),
(238, 'Tswana [tsn]', 'tsn', 'normal'),
(239, 'Purepecha [tsz]', 'tsz', 'normal'),
(240, 'Tatar [tt]', 'tt', 'normal'),
(241, 'Twi [tw]', 'tw', 'normal'),
(242, 'Tahitian [ty]', 'ty', 'normal'),
(243, 'Tzeltal, Oxchuc [tzh]', 'tzh', 'normal'),
(244, 'Tzotzil, Venustiano Carranza [tzo]', 'tzo', 'normal'),
(245, 'Uyghur [ug]', 'ug', 'normal'),
(246, 'Ukrainian [uk]', 'uk', 'normal'),
(247, 'Umbundu [umb]', 'umb', 'normal'),
(248, 'Urdu [ur]', 'ur', 'normal'),
(249, 'Uzbek [uz]', 'uz', 'normal'),
(250, 'Venda [ve]', 've', 'normal'),
(251, 'Flemish [vls]', 'vls', 'normal'),
(252, 'Volapuk [vo]', 'vo', 'normal'),
(253, 'Walloon [wa]', 'wa', 'normal'),
(254, 'Wauja [wau]', 'wau', 'normal'),
(255, 'Wakhi [wbl]', 'wbl', 'normal'),
(256, 'Wolof [wol]', 'wol', 'normal'),
(257, 'Xhosa [xho]', 'xho', 'normal'),
(258, 'Yaqui [yaq]', 'yaq', 'normal'),
(259, 'Yiddish [yi]', 'yi', 'normal'),
(260, 'Yoruba [yor]', 'yor', 'normal'),
(261, 'Maya, Yucatán [yua]', 'yua', 'normal'),
(262, 'Zhuang, Chuang [za]', 'za', 'normal'),
(263, 'Zapotec, Miahuatlán [zam]', 'zam', 'normal'),
(264, 'Chinese, Yue [zh]', 'zh', 'normal'),
(265, 'Chinese, Traditional (Hong Kong) [zh-hk]', 'zh-hk', 'normal'),
(266, 'Chinese, Simplified (Singaporean) [zh-sg]', 'zh-sg', 'normal'),
(267, 'Zulu [zul]', 'zul', 'normal'),
(268, 'Arabic [ar]', 'ar', 'popular'),
(269, 'Czech [cs]', 'cs', 'popular'),
(270, 'Danish [da]', 'da', 'popular'),
(271, 'German [de]', 'de', 'popular'),
(272, 'Greek [el]', 'el', 'popular'),
(273, 'English [en]', 'en', 'popular'),
(274, 'Spanish [es]', 'es', 'popular'),
(275, 'Persian [fa]', 'fa', 'popular'),
(276, 'French [fr]', 'fr', 'popular'),
(277, 'Hungarian [hu]', 'hu', 'popular'),
(278, 'Indonesian [id]', 'id', 'popular'),
(279, 'Italian [it]', 'it', 'popular'),
(280, 'Japanese [ja]', 'ja', 'popular'),
(281, 'Korean [ko]', 'ko', 'popular'),
(282, 'Dutch [nl]', 'nl', 'popular'),
(283, 'Polish [pl]', 'pl', 'popular'),
(284, 'Portuguese [pt]', 'pt', 'popular'),
(285, 'Portuguese, Brazilian [pt-br]', 'pt-br', 'popular'),
(286, 'Romanian [ro]', 'ro', 'popular'),
(287, 'Russian [ru]', 'ru', 'popular'),
(288, 'Swedish [sv]', 'sv', 'popular'),
(289, 'Thai [th]', 'th', 'popular'),
(290, 'Turkish [tr]', 'tr', 'popular'),
(291, 'Vietnamese [vi]', 'vi', 'popular'),
(292, 'Chinese, Simplified [zh-cn]', 'zh-cn', 'popular'),
(293, 'Chinese, Traditional [zh-tw]', 'zh-tw', 'popular');

-- --------------------------------------------------------

--
-- Table structure for table `medias`
--

DROP TABLE IF EXISTS `medias`;
CREATE TABLE IF NOT EXISTS `medias` (
  `pk_media_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  `description` text,
  `media_url` text NOT NULL,
  `media_type` varchar(12) NOT NULL,
  `thumbnail` varchar(300) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `lang_code` varchar(8) NOT NULL,
  `pk_team_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk_media_id`),
  KEY `pk_team_id` (`pk_team_id`) USING BTREE,
  KEY `created_by` (`created_by`) USING BTREE,
  KEY `lang_code` (`lang_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medias`
--

INSERT INTO `medias` (`pk_media_id`, `name`, `description`, `media_url`, `media_type`, `thumbnail`, `created_at`, `created_by`, `lang_code`, `pk_team_id`) VALUES
(2, 'medya ismi', 'medya ile ilgili açıklama', 'https://www.youtube.com/watch?v=zzhzzhzh', 'VID', NULL, '2017-05-01 01:22:50', 29, 'tr', 3),
(4, 'Pink Floyd Welcome to the Machine', 'Enjoy^_^ ~|Please Subscribe If you like my Videos|~', 'https://youtube.com/watch?v=L5jRewnxSBY', 'video', 'https://i.ytimg.com/vi/L5jRewnxSBY/default.jpg', '2017-05-19 18:35:06', 1, 'en', NULL),
(5, 'sami yusuf  Allahumme salli ala seyyidina Mustafa', 'video uploaded from my mobile phone', 'https://youtube.com/watch?v=7EDh1ATNilE', 'video', 'https://i.ytimg.com/vi/7EDh1ATNilE/default.jpg', '2017-05-19 18:36:00', 1, 'en', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `pk_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `module_key` varchar(20) NOT NULL,
  `does` text,
  `params` text,
  PRIMARY KEY (`pk_module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`pk_module_id`, `name`, `icon`, `module_key`, `does`, `params`) VALUES
(1, 'Dashboard', 'fa-dashboard', 'dashboard', NULL, NULL),
(2, 'Users', 'fa-user', 'users', '["add","edit","remove","list_all"]', NULL),
(3, 'User Groups', 'fa-users', 'user_groups', '["add","edit","remove","list_all"]', NULL),
(4, 'View Levels', 'fa-bars', 'view_levels', '["add","edit","remove","list_all"]', NULL),
(5, 'Pages', 'fa-file', 'pages', '["add","edit","remove","list_all"]', NULL),
(6, 'Posts', 'fa-files-o', 'posts', '["add","edit","remove","list_all"]', NULL),
(7, 'Forms', 'fa-file-text-o', 'forms', '["add","edit","remove","list_all","show"]', NULL),
(8, 'Medias', 'fa-file-video-o', 'medias', '["add","edit","remove","list","list_all","show"]', NULL),
(9, 'Teams', 'fa-ge', 'teams', '["add","edit","remove","list","list_all","show"]', NULL),
(10, 'Languages', 'fa-language', 'languages', '["add","edit","remove","list"]', NULL),
(11, 'Topics', 'fa-commenting-o', 'topics', '["add","edit","remove","list","list_all","show"]', NULL),
(12, 'Translations', 'fa-code', 'translations', '["add","remove","list","list_all","show"]', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `pk_post_id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_title` text,
  `post_alias` text,
  `post_content` longtext,
  `post_status` varchar(20) NOT NULL,
  `comment_status` varchar(20) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `guid` varchar(255) DEFAULT NULL,
  `post_type` varchar(20) NOT NULL,
  `featured_image` varchar(300) DEFAULT NULL,
  `comment_count` bigint(20) DEFAULT NULL,
  `post_params` text,
  PRIMARY KEY (`pk_post_id`),
  KEY `created_by` (`created_by`) USING BTREE,
  KEY `modified_by` (`modified_by`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`pk_post_id`, `created_by`, `created_at`, `post_title`, `post_alias`, `post_content`, `post_status`, `comment_status`, `modified_by`, `modified_date`, `guid`, `post_type`, `featured_image`, `comment_count`, `post_params`) VALUES
(1, 29, '2017-05-02 17:54:42', 'başlık 1234565789', 'başlık 1234565789', '&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;&lt;p&gt;as&lt;/p&gt;&lt;p&gt;d&lt;/p&gt;&lt;p&gt;asd&lt;/p&gt;', 'draft', 'off', 32, '2017-05-21 13:48:31', 'asdasd', 'post', 'fetured image', 5, ''),
(2, 29, '2017-05-21 11:08:19', 'title', 'title', '&lt;p&gt;içerik&lt;/p&gt;', 'publish', 'on', NULL, '2017-05-21 11:08:19', '', 'post', 'fetured image', NULL, ''),
(3, 29, '2017-05-21 11:13:43', 'titletitle', 'titletitle', '&lt;p&gt;content content&lt;/p&gt;', 'publish', 'off', NULL, '2017-05-21 11:24:07', '{F554B94E-7B14-4225-AF14-168C051F9B25}', 'post', 'fetured image', NULL, ''),
(4, 29, '2017-05-21 11:29:03', 'asldhasdj', 'asldhasdj', '&lt;p&gt;lsdkjfsldkjnfşsnjdkflasdf&lt;/p&gt;', 'publish', 'off', NULL, '2017-05-21 11:29:03', '{CA85D873-A0A7-4B6F-888B-279F9F2FA673}', 'post', 'fetured image', NULL, ''),
(5, 29, '2017-05-21 11:31:12', 'sfasdfsfd', 'sfasdfsfd', '&lt;p&gt;adfasdfsdfasdf&lt;/p&gt;', 'publish', 'off', NULL, '2017-05-21 11:31:12', '{666E55E3-42C5-4DCA-A733-3886FAA4EDFC}', 'post', 'fetured image', NULL, ''),
(6, 29, '2017-05-21 11:32:47', 'elma', 'elma', '&lt;p&gt;armut&lt;/p&gt;', 'publish', 'off', NULL, '2017-05-21 11:32:47', '{B23F22C9-6CE4-4EA8-860A-6DDA748A0646}', 'post', 'fetured image', NULL, ''),
(8, 29, '2017-05-21 11:36:44', 'deneme başlık', 'deneme başlık', '&lt;p&gt;içerik&amp;nbsp;\r\n\r\niçerik \r\n\r\n\r\n\r\niçerik \r\n\r\n\r\n\r\niçerik \r\n\r\n\r\n\r\niçerik \r\n\r\n\r\n\r\niçerik \r\n\r\n\r\n\r\niçerik \r\n\r\n\r\n\r\niçerik \r\n\r\n\r\n\r\niçerik \r\n\r\n\r\n\r\niçerik \r\n\r\n\r\n\r\niçerik \r\n\r\n&lt;/p&gt;', 'publish', 'on', NULL, '2017-05-21 11:36:44', '{A00D6DD8-0F5D-4311-A50B-0D2305BB3B66}', 'post', 'fetured image', NULL, ''),
(9, 32, '2017-05-21 13:56:33', 'post başlık', 'post başlık', '&lt;p&gt;post içerik&lt;/p&gt;', 'draft', 'on', NULL, '2017-05-21 13:56:33', '{7EC396E7-D681-4D69-8F93-4077832747E9}', 'post', 'fetured image', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `sentences`
--

DROP TABLE IF EXISTS `sentences`;
CREATE TABLE IF NOT EXISTS `sentences` (
  `pk_sentence_id` int(11) NOT NULL AUTO_INCREMENT,
  `subtitle_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `order_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk_sentence_id`),
  KEY `subtitle_id` (`subtitle_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subtitles`
--

DROP TABLE IF EXISTS `subtitles`;
CREATE TABLE IF NOT EXISTS `subtitles` (
  `pk_subtitle_id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL,
  `media_name` tinytext,
  `media_description` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lang_code` varchar(8) NOT NULL,
  PRIMARY KEY (`pk_subtitle_id`),
  KEY `media_id` (`media_id`),
  KEY `created_by` (`created_by`) USING BTREE,
  KEY `lang_code` (`lang_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subtitles`
--

INSERT INTO `subtitles` (`pk_subtitle_id`, `media_id`, `media_name`, `media_description`, `created_by`, `created_at`, `lang_code`) VALUES
(1, 2, NULL, NULL, 29, '2017-04-30 19:22:50', 'en'),
(2, 5, NULL, NULL, 1, '2017-05-19 17:06:52', 'ar'),
(3, 5, NULL, NULL, 1, '2017-05-20 17:24:30', 'da');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `pk_team_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `params` json DEFAULT NULL,
  PRIMARY KEY (`pk_team_id`),
  KEY `created_by` (`created_by`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`pk_team_id`, `name`, `description`, `created_at`, `created_by`, `params`) VALUES
(1, 'elma', '', '2017-05-16 20:21:32', 29, NULL),
(2, 'Deneme Takımı hhhhhhhhhhh', '', '2017-05-16 20:24:13', 29, NULL),
(3, 'My Team Name 2 ', 'TEST TEST TEST', '2017-05-12 17:37:38', 29, NULL),
(4, 'Deneme Takımı 0000', '', '2017-05-16 20:23:48', 29, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
CREATE TABLE IF NOT EXISTS `team_members` (
  `pk_team_member_id` int(11) NOT NULL AUTO_INCREMENT,
  `since` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(15) NOT NULL,
  `params` json DEFAULT NULL,
  PRIMARY KEY (`pk_team_member_id`),
  UNIQUE KEY `unique_team_member` (`team_id`,`user_id`),
  KEY `team_id` (`team_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`pk_team_member_id`, `since`, `team_id`, `user_id`, `type`, `params`) VALUES
(1, '2017-05-01 01:22:50', 1, 1, 'member', NULL),
(2, '2017-05-01 01:22:50', 3, 29, 'member', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_topics`
--

DROP TABLE IF EXISTS `team_topics`;
CREATE TABLE IF NOT EXISTS `team_topics` (
  `pk_topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `content` longtext NOT NULL,
  `team_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`pk_topic_id`),
  KEY `team_id` (`team_id`) USING BTREE,
  KEY `created_by` (`created_by`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team_topics`
--

INSERT INTO `team_topics` (`pk_topic_id`, `title`, `content`, `team_id`, `created_at`, `created_by`, `status`) VALUES
(1, 'Merhaba!', 'merhaba dünyalı bu benim ilk topic yayınım.', 3, '2017-04-30 22:22:50', 29, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_topic_messages`
--

DROP TABLE IF EXISTS `team_topic_messages`;
CREATE TABLE IF NOT EXISTS `team_topic_messages` (
  `pk_tt_message_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk_tt_message_id`),
  KEY `topic_id` (`topic_id`) USING BTREE,
  KEY `user_id` (`created_by`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team_topic_messages`
--

INSERT INTO `team_topic_messages` (`pk_tt_message_id`, `topic_id`, `message`, `created_at`, `created_by`) VALUES
(1, 1, 'topic message response', '2017-05-01 01:22:50', 29),
(2, 1, 'son mesajım', '2017-05-10 22:32:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `pk_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(75) NOT NULL,
  `last_visit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fullname` varchar(50) DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pk_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`pk_user_id`, `username`, `password`, `email`, `last_visit`, `fullname`, `registration_date`) VALUES
(1, 'mybirer', 'e10adc3949ba59abbe56e057f20f883e', 'mybirer@gmail.com', '2017-05-19 07:00:06', 'M. Yasin Birer', '2017-04-07 21:00:00'),
(7, 'moderator', 'e10adc3949ba59abbe56e057f20f883e', 'moderator@localhost.com', '2017-05-02 16:27:47', 'Moderatör Kardeş', '2017-04-20 07:59:12'),
(8, 'cevirmen', 'e10adc3949ba59abbe56e057f20f883e', 'cevirmen@localhost.com', '2017-05-10 19:32:07', 'Çevirmen Kardeşimiz', '2017-04-20 08:05:38'),
(28, 'ahmetcan23', '202cb962ac59075b964b07152d234b70', 'ahmetcan@asdf.com', '2017-05-01 13:03:04', 'ahmetcan23', '2017-04-30 22:22:50'),
(29, 'erden', '8619d248219882ab72aaa3b44474bd5d', 'cwyusef@gmail.com', '2017-05-22 00:09:51', 'Muhammed Yusuf ERDEN', '2017-05-03 18:07:37'),
(32, 'Mehmet', '827ccb0eea8a706c4c34a16891f84e7b', 'mehmetonatce@gmail.com', '2017-05-21 14:09:12', 'Mehmet ONAT', '2017-05-18 17:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE IF NOT EXISTS `user_groups` (
  `pk_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`pk_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`pk_group_id`, `name`) VALUES
(3, 'Super Users'),
(4, 'Translators'),
(7, 'Moderators');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `pk_user_id` int(11) NOT NULL,
  `profile_key` varchar(100) NOT NULL,
  `profile_value` text NOT NULL,
  KEY `pk_user_id` (`pk_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_usergroup_map`
--

DROP TABLE IF EXISTS `user_usergroup_map`;
CREATE TABLE IF NOT EXISTS `user_usergroup_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pk_user_id` int(11) NOT NULL,
  `pk_group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pkUserID` (`pk_user_id`),
  KEY `pkAuthGroupID` (`pk_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_usergroup_map`
--

INSERT INTO `user_usergroup_map` (`id`, `pk_user_id`, `pk_group_id`) VALUES
(19, 7, 7),
(23, 28, 3),
(24, 28, 4),
(25, 8, 7),
(26, 8, 4),
(29, 1, 3),
(30, 29, 3),
(33, 32, 7),
(34, 32, 3),
(35, 32, 4);

-- --------------------------------------------------------

--
-- Table structure for table `view_levels`
--

DROP TABLE IF EXISTS `view_levels`;
CREATE TABLE IF NOT EXISTS `view_levels` (
  `pk_view_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `groups` varchar(5120) NOT NULL DEFAULT '[]' COMMENT 'JSON encoded group id list',
  `modules` varchar(5120) NOT NULL DEFAULT '[]' COMMENT 'JSON encoded module list',
  PRIMARY KEY (`pk_view_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `view_levels`
--

INSERT INTO `view_levels` (`pk_view_level_id`, `title`, `groups`, `modules`) VALUES
(2, 'Public Area', '[7,3,4]', '{"posts":["add","edit","show"]}'),
(4, 'Manager Area', '[3]', '{"dashboard":[],"users":["add","edit","remove","list_all"],"user_groups":["add","edit","remove","list_all"],"view_levels":["add","edit","remove","list_all"],"pages":["add","edit","remove","list_all"],"posts":["add","edit","remove","list_all"],"forms":["add","edit","remove","list_all","show"],"medias":["add","edit","remove","list","list_all","show"],"teams":["add","edit","remove","list","list_all","show"],"languages":["add","edit","remove","list"],"topics":["add","edit","remove","list","list_all","show"],"translations":["add","remove","list","list_all","show"]}'),
(5, 'Translator Area', '[4]', '{"dashboard":["add","edit"],"medias":["add","edit"]}'),
(6, 'Moderator Area', '[7]', '{}');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`parent_comment_id`) REFERENCES `comments` (`pk_comment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`pk_user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`modified_by`) REFERENCES `users` (`pk_user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `medias`
--
ALTER TABLE `medias`
  ADD CONSTRAINT `medias_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`pk_user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `medias_ibfk_2` FOREIGN KEY (`lang_code`) REFERENCES `languages` (`lang_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `medias_ibfk_5` FOREIGN KEY (`pk_team_id`) REFERENCES `teams` (`pk_team_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`modified_by`) REFERENCES `users` (`pk_user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_22` FOREIGN KEY (`created_by`) REFERENCES `users` (`pk_user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `sentences`
--
ALTER TABLE `sentences`
  ADD CONSTRAINT `sentences_ibfk_1` FOREIGN KEY (`subtitle_id`) REFERENCES `subtitles` (`pk_subtitle_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subtitles`
--
ALTER TABLE `subtitles`
  ADD CONSTRAINT `subtitles_ibfk_1` FOREIGN KEY (`lang_code`) REFERENCES `languages` (`lang_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `subtitles_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`pk_user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `subtitles_ibfk_3` FOREIGN KEY (`media_id`) REFERENCES `medias` (`pk_media_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`pk_user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`pk_team_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`pk_user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `team_topics`
--
ALTER TABLE `team_topics`
  ADD CONSTRAINT `team_topics_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`pk_team_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `team_topics_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`pk_user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `team_topic_messages`
--
ALTER TABLE `team_topic_messages`
  ADD CONSTRAINT `tt_messages_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `team_topics` (`pk_topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tt_messages_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`pk_user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`pk_user_id`) REFERENCES `users` (`pk_user_id`);

--
-- Constraints for table `user_usergroup_map`
--
ALTER TABLE `user_usergroup_map`
  ADD CONSTRAINT `user_usergroup_map_ibfk_1` FOREIGN KEY (`pk_user_id`) REFERENCES `users` (`pk_user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_usergroup_map_ibfk_2` FOREIGN KEY (`pk_group_id`) REFERENCES `user_groups` (`pk_group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
