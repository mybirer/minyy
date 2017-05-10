-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2017 at 03:41 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET FOREIGN_KEY_CHECKS=0;
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
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `pk_lang_id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_name` tinytext,
  `lang_short_expression` tinytext,
  PRIMARY KEY (`pk_lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `media_sources`
--

DROP TABLE IF EXISTS `media_sources`;
CREATE TABLE IF NOT EXISTS `media_sources` (
  `pk_media_source_id` int(11) NOT NULL AUTO_INCREMENT,
  `media_source_name` tinytext NOT NULL,
  `media_source_description` text,
  PRIMARY KEY (`pk_media_source_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `media_types`
--

DROP TABLE IF EXISTS `media_types`;
CREATE TABLE IF NOT EXISTS `media_types` (
  `pk_media_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `media_type_name` tinytext NOT NULL,
  `media_type_description` text,
  PRIMARY KEY (`pk_media_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `pk_post_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `post_date` timestamp NULL DEFAULT NULL,
  `post_title` text,
  `post_alias` text,
  `post_content` longtext,
  `post_status` varchar(20) DEFAULT NULL,
  `comment_status` varchar(20) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL,
  `guid` varchar(255) DEFAULT NULL,
  `post_type` varchar(20) DEFAULT NULL,
  `comment_count` bigint(20) DEFAULT NULL,
  `post_params` json DEFAULT NULL,
  PRIMARY KEY (`pk_post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`pk_post_id`, `author_id`, `post_date`, `post_title`, `post_alias`, `post_content`, `post_status`, `comment_status`, `modified_by`, `modified_date`, `guid`, `post_type`, `comment_count`, `post_params`) VALUES
(1, 29, '2017-05-02 17:54:42', 'başlık', 'asdas', 'kjhasdfgsadofgb', 'status', 'status', 1, '2017-05-03 18:07:37', 'asdasd', 'type', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sentences`
--

DROP TABLE IF EXISTS `sentences`;
CREATE TABLE IF NOT EXISTS `sentences` (
  `pkSentenceID` int(11) NOT NULL AUTO_INCREMENT,
  `sentence` text NOT NULL,
  `creationDate` datetime DEFAULT NULL,
  `pkLangID` int(11) DEFAULT NULL,
  PRIMARY KEY (`pkSentenceID`),
  KEY `pkLangID` (`pkLangID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sentence_translations`
--

DROP TABLE IF EXISTS `sentence_translations`;
CREATE TABLE IF NOT EXISTS `sentence_translations` (
  `pkSentenceTranslationID` int(11) NOT NULL AUTO_INCREMENT,
  `StartTime` time DEFAULT NULL,
  `FinishTime` time DEFAULT NULL,
  `OrderNumber` int(11) DEFAULT NULL,
  `pkSubtitleID` int(11) NOT NULL,
  `pkSourceSentenceID` int(11) NOT NULL,
  `pkTranslatedSentenceID` int(11) NOT NULL,
  PRIMARY KEY (`pkSentenceTranslationID`),
  KEY `pkSourceSentenceID` (`pkSourceSentenceID`),
  KEY `pkSubtitleID` (`pkSubtitleID`),
  KEY `pkTranslatedSentenceID` (`pkTranslatedSentenceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subtitles`
--

DROP TABLE IF EXISTS `subtitles`;
CREATE TABLE IF NOT EXISTS `subtitles` (
  `pkSubtitleID` int(11) NOT NULL AUTO_INCREMENT,
  `subtitleName` tinytext,
  `subtitleDescription` text,
  `pkTmID` int(11) NOT NULL,
  `pkSubtitleTypeID` int(11) NOT NULL,
  `pkUserID` int(11) NOT NULL,
  `pkLangID` int(11) DEFAULT NULL,
  PRIMARY KEY (`pkSubtitleID`),
  KEY `pkTmID` (`pkTmID`),
  KEY `pkSubtitleTypeID` (`pkSubtitleTypeID`),
  KEY `pkUserID` (`pkUserID`),
  KEY `pkLangID` (`pkLangID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subtitle_types`
--

DROP TABLE IF EXISTS `subtitle_types`;
CREATE TABLE IF NOT EXISTS `subtitle_types` (
  `pkSubtitleTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `subtitleTypeName` tinytext NOT NULL,
  `subtitleTypeDescription` text,
  PRIMARY KEY (`pkSubtitleTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `pk_team_id` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` tinytext,
  `team_description` text,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pk_user_id` int(11) NOT NULL,
  PRIMARY KEY (`pk_team_id`),
  KEY `pkUserID` (`pk_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_chat_comments`
--

DROP TABLE IF EXISTS `team_chat_comments`;
CREATE TABLE IF NOT EXISTS `team_chat_comments` (
  `pkCommentID` int(11) NOT NULL AUTO_INCREMENT,
  `pkTopicID` int(11) NOT NULL,
  `pkUserID` int(11) NOT NULL,
  `commentContent` mediumtext NOT NULL,
  `commentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pkCommentID`),
  KEY `pkTopicID` (`pkTopicID`),
  KEY `pkUserID` (`pkUserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_chat_topics`
--

DROP TABLE IF EXISTS `team_chat_topics`;
CREATE TABLE IF NOT EXISTS `team_chat_topics` (
  `pkTopicID` int(11) NOT NULL AUTO_INCREMENT,
  `topicTitle` tinytext NOT NULL,
  `topicContent` longtext NOT NULL,
  `pkTeamID` int(11) NOT NULL,
  `pkUserID` int(11) NOT NULL,
  PRIMARY KEY (`pkTopicID`),
  KEY `pkTeamID` (`pkTeamID`),
  KEY `pkUserID` (`pkUserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
CREATE TABLE IF NOT EXISTS `team_members` (
  `pkTeamMemberID` int(11) NOT NULL AUTO_INCREMENT,
  `since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pkTeamID` int(11) NOT NULL,
  `pkUserID` int(11) NOT NULL,
  `pkMemTypeID` int(11) NOT NULL,
  PRIMARY KEY (`pkTeamMemberID`),
  KEY `pkTeamID` (`pkTeamID`),
  KEY `pkUserID` (`pkUserID`),
  KEY `pkMemTypeID` (`pkMemTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_member_types`
--

DROP TABLE IF EXISTS `team_member_types`;
CREATE TABLE IF NOT EXISTS `team_member_types` (
  `pkMemTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `memTypeName` tinytext NOT NULL,
  `memTypeDescription` text,
  PRIMARY KEY (`pkMemTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `translation_media`
--

DROP TABLE IF EXISTS `translation_media`;
CREATE TABLE IF NOT EXISTS `translation_media` (
  `pk_tm_id` int(11) NOT NULL AUTO_INCREMENT,
  `tm_name` tinytext,
  `tm_description` text,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pk_user_id` int(11) NOT NULL,
  `pk_media_source_id` int(11) NOT NULL,
  `pk_media_type_id` int(11) NOT NULL,
  `tm_url` text NOT NULL,
  `pk_lang_id` int(11) DEFAULT NULL,
  `pk_team_id` int(11) DEFAULT NULL,
  `native_translation_id` int(11) DEFAULT NULL COMMENT 'Ana dilde yazılmış olan altyazıyı işaret eder.',
  PRIMARY KEY (`pk_tm_id`),
  KEY `pkUserID` (`pk_user_id`),
  KEY `pkSMediaSourceID` (`pk_media_source_id`),
  KEY `pkSupMediaTypeID` (`pk_media_type_id`),
  KEY `pkLangID` (`pk_lang_id`),
  KEY `pkTeamID` (`pk_team_id`),
  KEY `nativeLangTranslationID` (`native_translation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `last_visit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fullname` varchar(50) DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pk_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`pk_user_id`, `username`, `password`, `email`, `last_visit`, `fullname`, `registration_date`) VALUES
(1, 'mybirer', 'e10adc3949ba59abbe56e057f20f883e', 'mybirer@gmail.com', '2017-05-02 17:54:42', 'M. Yasin Birer', '2017-04-07 21:00:00'),
(7, 'moderator', 'e10adc3949ba59abbe56e057f20f883e', 'moderator@localhost.com', '2017-05-02 16:27:47', 'Moderatör Kardeş', '2017-04-20 07:59:12'),
(8, 'cevirmen', 'e10adc3949ba59abbe56e057f20f883e', 'cevirmen@localhost.com', '2017-05-02 17:51:24', 'Çevirmen Kardeşimiz', '2017-04-20 08:05:38'),
(28, 'ahmetcan23', '202cb962ac59075b964b07152d234b70', 'ahmetcan@asdf.com', '2017-05-01 13:03:04', 'ahmetcan23', '2017-04-30 22:22:50'),
(29, 'erden', '8619d248219882ab72aaa3b44474bd5d', 'cwyusef@gmail.com', '2017-05-10 01:13:38', 'Muhammed Yusuf ERDEN', '2017-05-03 18:07:37');

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

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
(30, 29, 3);

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
(2, 'Public Area', '[7,3,4]', '["posts"]'),
(4, 'Manager Area', '[3]', '["dashboard","users","user_groups","view_levels","pages","posts","forms","medias","teams","languages"]'),
(5, 'Translator Area', '[4]', '["dashboard"]'),
(6, 'Moderator Area', '[7]', '[]');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sentences`
--
ALTER TABLE `sentences`
  ADD CONSTRAINT `sentences_ibfk_1` FOREIGN KEY (`pkLangID`) REFERENCES `languages` (`pk_lang_id`);

--
-- Constraints for table `sentence_translations`
--
ALTER TABLE `sentence_translations`
  ADD CONSTRAINT `sentence_translations_ibfk_1` FOREIGN KEY (`pkSourceSentenceID`) REFERENCES `sentences` (`pkSentenceID`),
  ADD CONSTRAINT `sentence_translations_ibfk_2` FOREIGN KEY (`pkSubtitleID`) REFERENCES `subtitles` (`pkSubtitleID`),
  ADD CONSTRAINT `sentence_translations_ibfk_3` FOREIGN KEY (`pkTranslatedSentenceID`) REFERENCES `sentences` (`pkSentenceID`);

--
-- Constraints for table `subtitles`
--
ALTER TABLE `subtitles`
  ADD CONSTRAINT `subtitles_ibfk_1` FOREIGN KEY (`pkTmID`) REFERENCES `translation_media` (`pk_tm_id`),
  ADD CONSTRAINT `subtitles_ibfk_2` FOREIGN KEY (`pkSubtitleTypeID`) REFERENCES `subtitle_types` (`pkSubtitleTypeID`),
  ADD CONSTRAINT `subtitles_ibfk_3` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pk_user_id`),
  ADD CONSTRAINT `subtitles_ibfk_4` FOREIGN KEY (`pkLangID`) REFERENCES `languages` (`pk_lang_id`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`pk_user_id`) REFERENCES `users` (`pk_user_id`);

--
-- Constraints for table `team_chat_comments`
--
ALTER TABLE `team_chat_comments`
  ADD CONSTRAINT `team_chat_comments_ibfk_1` FOREIGN KEY (`pkTopicID`) REFERENCES `team_chat_topics` (`pkTopicID`),
  ADD CONSTRAINT `team_chat_comments_ibfk_2` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pk_user_id`);

--
-- Constraints for table `team_chat_topics`
--
ALTER TABLE `team_chat_topics`
  ADD CONSTRAINT `team_chat_topics_ibfk_1` FOREIGN KEY (`pkTeamID`) REFERENCES `teams` (`pk_team_id`),
  ADD CONSTRAINT `team_chat_topics_ibfk_2` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pk_user_id`);

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`pkTeamID`) REFERENCES `teams` (`pk_team_id`),
  ADD CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pk_user_id`),
  ADD CONSTRAINT `team_members_ibfk_3` FOREIGN KEY (`pkMemTypeID`) REFERENCES `team_member_types` (`pkMemTypeID`);

--
-- Constraints for table `translation_media`
--
ALTER TABLE `translation_media`
  ADD CONSTRAINT `translation_media_ibfk_1` FOREIGN KEY (`pk_user_id`) REFERENCES `users` (`pk_user_id`),
  ADD CONSTRAINT `translation_media_ibfk_2` FOREIGN KEY (`pk_media_source_id`) REFERENCES `media_sources` (`pk_media_source_id`),
  ADD CONSTRAINT `translation_media_ibfk_3` FOREIGN KEY (`pk_media_type_id`) REFERENCES `media_types` (`pk_media_type_id`),
  ADD CONSTRAINT `translation_media_ibfk_4` FOREIGN KEY (`pk_lang_id`) REFERENCES `languages` (`pk_lang_id`),
  ADD CONSTRAINT `translation_media_ibfk_5` FOREIGN KEY (`pk_team_id`) REFERENCES `teams` (`pk_team_id`),
  ADD CONSTRAINT `translation_media_ibfk_6` FOREIGN KEY (`native_translation_id`) REFERENCES `subtitles` (`pkSubtitleID`);

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`pk_user_id`) REFERENCES `users` (`pk_user_id`);

--
-- Constraints for table `user_usergroup_map`
--
ALTER TABLE `user_usergroup_map`
  ADD CONSTRAINT `user_usergroup_map_ibfk_1` FOREIGN KEY (`pk_user_id`) REFERENCES `users` (`pk_user_id`),
  ADD CONSTRAINT `user_usergroup_map_ibfk_2` FOREIGN KEY (`pk_group_id`) REFERENCES `user_groups` (`pk_group_id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
