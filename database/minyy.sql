-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2017 at 08:32 PM
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
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `pk_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  `comment_status` varchar(20) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `guid` varchar(255) DEFAULT NULL,
  `comment_type` varchar(20) NOT NULL,
  `comment_params` text,
  PRIMARY KEY (`pk_comment_id`),
  KEY `parent_id` (`parent_id`) USING BTREE,
  KEY `created_by` (`created_by`) USING BTREE,
  KEY `modified_by` (`modified_by`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `pk_lang_id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_name` tinytext NOT NULL,
  `lang_code` varchar(8) NOT NULL,
  PRIMARY KEY (`pk_lang_id`),
  KEY `lang_code` (`lang_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`pk_lang_id`, `lang_name`, `lang_code`) VALUES
(1, 'TURKISH', 'tr'),
(2, 'ENGLISH', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `medias`
--

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
(3, 'medya', 'herhangi bir açıklama girilebilir', 'www.google.com', 'MP3', NULL, '2017-05-05 04:11:50', 29, 'en', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

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
  `comment_count` bigint(20) DEFAULT NULL,
  `post_params` text,
  PRIMARY KEY (`pk_post_id`),
  KEY `created_by` (`created_by`) USING BTREE,
  KEY `modified_by` (`modified_by`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`pk_post_id`, `created_by`, `created_at`, `post_title`, `post_alias`, `post_content`, `post_status`, `comment_status`, `modified_by`, `modified_date`, `guid`, `post_type`, `comment_count`, `post_params`) VALUES
(1, 29, '2017-05-02 17:54:42', 'başlık', 'asdas', 'kjhasdfgsadofgb', 'status', 'status', 1, '2017-05-03 18:07:37', 'asdasd', 'type', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sentences`
--

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

CREATE TABLE IF NOT EXISTS `subtitles` (
  `pk_subtitle_id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lang_code` varchar(8) NOT NULL,
  PRIMARY KEY (`pk_subtitle_id`),
  KEY `media_id` (`media_id`),
  KEY `created_by` (`created_by`) USING BTREE,
  KEY `lang_code` (`lang_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

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
(29, 'erden', '8619d248219882ab72aaa3b44474bd5d', 'cwyusef@gmail.com', '2017-05-19 18:33:01', 'Muhammed Yusuf ERDEN', '2017-05-03 18:07:37'),
(32, 'Mehmet', '827ccb0eea8a706c4c34a16891f84e7b', 'mehmetonatce@gmail.com', '2017-05-18 17:22:37', 'Mehmet ONAT', '2017-05-18 17:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

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

CREATE TABLE IF NOT EXISTS `user_usergroup_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pk_user_id` int(11) NOT NULL,
  `pk_group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pkUserID` (`pk_user_id`),
  KEY `pkAuthGroupID` (`pk_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

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
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`pk_comment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
