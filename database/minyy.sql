-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2017 at 10:47 PM
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
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `pkLangID` int(11) NOT NULL,
  `langName` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sentences`
--

DROP TABLE IF EXISTS `sentences`;
CREATE TABLE `sentences` (
  `pkSentenceID` int(11) NOT NULL,
  `sentence` text NOT NULL,
  `creationDate` datetime DEFAULT NULL,
  `pkLangID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sentence_translations`
--

DROP TABLE IF EXISTS `sentence_translations`;
CREATE TABLE `sentence_translations` (
  `pkSentenceTranslationID` int(11) NOT NULL,
  `StartTime` time DEFAULT NULL,
  `FinishTime` time DEFAULT NULL,
  `OrderNumber` int(11) DEFAULT NULL,
  `pkSubtitleID` int(11) NOT NULL,
  `pkSourceSentenceID` int(11) NOT NULL,
  `pkTranslatedSentenceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subtitles`
--

DROP TABLE IF EXISTS `subtitles`;
CREATE TABLE `subtitles` (
  `pkSubtitleID` int(11) NOT NULL,
  `subtitleName` tinytext,
  `subtitleDescription` text,
  `pkTmID` int(11) NOT NULL,
  `pkSubtitleTypeID` int(11) NOT NULL,
  `pkUserID` int(11) NOT NULL,
  `pkLangID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subtitle_types`
--

DROP TABLE IF EXISTS `subtitle_types`;
CREATE TABLE `subtitle_types` (
  `pkSubtitleTypeID` int(11) NOT NULL,
  `subtitleTypeName` tinytext NOT NULL,
  `subtitleTypeDescription` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supported_media_types`
--

DROP TABLE IF EXISTS `supported_media_types`;
CREATE TABLE `supported_media_types` (
  `pkSupMediaTypeID` int(11) NOT NULL,
  `supMediaTypeName` tinytext NOT NULL,
  `supMediaTypeDescription` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `support_media_sources`
--

DROP TABLE IF EXISTS `support_media_sources`;
CREATE TABLE `support_media_sources` (
  `pkSMediaSourceID` int(11) NOT NULL,
  `sMediaSourceName` tinytext NOT NULL,
  `sMediaSourceDescription` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
  `pkTeamID` int(11) NOT NULL,
  `teamName` tinytext,
  `teamDescription` text,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pkUserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_chat_comments`
--

DROP TABLE IF EXISTS `team_chat_comments`;
CREATE TABLE `team_chat_comments` (
  `pkCommentID` int(11) NOT NULL,
  `pkTopicID` int(11) NOT NULL,
  `pkUserID` int(11) NOT NULL,
  `commentContent` mediumtext NOT NULL,
  `commentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_chat_topics`
--

DROP TABLE IF EXISTS `team_chat_topics`;
CREATE TABLE `team_chat_topics` (
  `pkTopicID` int(11) NOT NULL,
  `topicTitle` tinytext NOT NULL,
  `topicContent` longtext NOT NULL,
  `pkTeamID` int(11) NOT NULL,
  `pkUserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
CREATE TABLE `team_members` (
  `pkTeamMemberID` int(11) NOT NULL,
  `since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pkTeamID` int(11) NOT NULL,
  `pkUserID` int(11) NOT NULL,
  `pkMemTypeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_member_types`
--

DROP TABLE IF EXISTS `team_member_types`;
CREATE TABLE `team_member_types` (
  `pkMemTypeID` int(11) NOT NULL,
  `memTypeName` tinytext NOT NULL,
  `memTypeDescription` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `translation_media`
--

DROP TABLE IF EXISTS `translation_media`;
CREATE TABLE `translation_media` (
  `pkTmID` int(11) NOT NULL,
  `tmName` tinytext,
  `tmDescription` text,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pkUserID` int(11) NOT NULL,
  `pkSMediaSourceID` int(11) NOT NULL,
  `pkSupMediaTypeID` int(11) NOT NULL,
  `pkLangID` int(11) DEFAULT NULL,
  `pkTeamID` int(11) DEFAULT NULL,
  `nativeLangTranslationID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `pk_user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(75) NOT NULL,
  `last_visit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fullname` varchar(50) DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`pk_user_id`, `username`, `password`, `email`, `last_visit`, `fullname`, `registration_date`) VALUES
(1, 'mybirer', 'e10adc3949ba59abbe56e057f20f883e', 'mybirer@gmail.com', '2017-04-30 22:46:44', 'M. Yasin Birer', '2017-04-07 21:00:00'),
(7, 'aliveli', 'e10adc3949ba59abbe56e057f20f883e', 'aliveli@nuri.com', '2017-04-30 22:45:38', 'ali23', '2017-04-20 07:59:12'),
(8, 'memo', '202cb962ac59075b964b07152d234b70', 'memo@cano.com', '2017-04-30 12:48:28', 'MEMOCAN2', '2017-04-20 08:05:38'),
(28, 'ahmetcan23', '202cb962ac59075b964b07152d234b70', 'ahmetcan@asdf.com', '2017-04-30 22:41:56', 'ahmetcan2', '2017-04-30 22:22:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
  `pk_group_id` int(11) NOT NULL,
  `name` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`pk_group_id`, `name`) VALUES
(2, 'Public'),
(3, 'Super Users'),
(4, 'Subscriber'),
(5, 'Registered');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE `user_profiles` (
  `pk_user_id` int(11) NOT NULL,
  `profile_key` varchar(100) NOT NULL,
  `profile_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_usergroup_map`
--

DROP TABLE IF EXISTS `user_usergroup_map`;
CREATE TABLE `user_usergroup_map` (
  `id` int(11) NOT NULL,
  `pk_user_id` int(11) NOT NULL,
  `pk_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_usergroup_map`
--

INSERT INTO `user_usergroup_map` (`id`, `pk_user_id`, `pk_group_id`) VALUES
(11, 28, 2),
(12, 28, 5),
(13, 28, 3),
(14, 8, 2),
(15, 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `view_levels`
--

DROP TABLE IF EXISTS `view_levels`;
CREATE TABLE `view_levels` (
  `pk_view_level_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `groups` varchar(5120) DEFAULT NULL COMMENT 'JSON encoded access control.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `view_levels`
--

INSERT INTO `view_levels` (`pk_view_level_id`, `title`, `groups`) VALUES
(2, 'Genel alan herkes girebilir', '[2,4]'),
(4, 'Yönetici Alanı', '[3]'),
(5, 'Editörlere özel alan', '[2]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`pkLangID`);

--
-- Indexes for table `sentences`
--
ALTER TABLE `sentences`
  ADD PRIMARY KEY (`pkSentenceID`),
  ADD KEY `pkLangID` (`pkLangID`);

--
-- Indexes for table `sentence_translations`
--
ALTER TABLE `sentence_translations`
  ADD PRIMARY KEY (`pkSentenceTranslationID`),
  ADD KEY `pkSourceSentenceID` (`pkSourceSentenceID`),
  ADD KEY `pkSubtitleID` (`pkSubtitleID`),
  ADD KEY `pkTranslatedSentenceID` (`pkTranslatedSentenceID`);

--
-- Indexes for table `subtitles`
--
ALTER TABLE `subtitles`
  ADD PRIMARY KEY (`pkSubtitleID`),
  ADD KEY `pkTmID` (`pkTmID`),
  ADD KEY `pkSubtitleTypeID` (`pkSubtitleTypeID`),
  ADD KEY `pkUserID` (`pkUserID`),
  ADD KEY `pkLangID` (`pkLangID`);

--
-- Indexes for table `subtitle_types`
--
ALTER TABLE `subtitle_types`
  ADD PRIMARY KEY (`pkSubtitleTypeID`);

--
-- Indexes for table `supported_media_types`
--
ALTER TABLE `supported_media_types`
  ADD PRIMARY KEY (`pkSupMediaTypeID`);

--
-- Indexes for table `support_media_sources`
--
ALTER TABLE `support_media_sources`
  ADD PRIMARY KEY (`pkSMediaSourceID`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`pkTeamID`),
  ADD KEY `pkUserID` (`pkUserID`);

--
-- Indexes for table `team_chat_comments`
--
ALTER TABLE `team_chat_comments`
  ADD PRIMARY KEY (`pkCommentID`),
  ADD KEY `pkTopicID` (`pkTopicID`),
  ADD KEY `pkUserID` (`pkUserID`);

--
-- Indexes for table `team_chat_topics`
--
ALTER TABLE `team_chat_topics`
  ADD PRIMARY KEY (`pkTopicID`),
  ADD KEY `pkTeamID` (`pkTeamID`),
  ADD KEY `pkUserID` (`pkUserID`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`pkTeamMemberID`),
  ADD KEY `pkTeamID` (`pkTeamID`),
  ADD KEY `pkUserID` (`pkUserID`),
  ADD KEY `pkMemTypeID` (`pkMemTypeID`);

--
-- Indexes for table `team_member_types`
--
ALTER TABLE `team_member_types`
  ADD PRIMARY KEY (`pkMemTypeID`);

--
-- Indexes for table `translation_media`
--
ALTER TABLE `translation_media`
  ADD PRIMARY KEY (`pkTmID`),
  ADD KEY `pkUserID` (`pkUserID`),
  ADD KEY `pkSMediaSourceID` (`pkSMediaSourceID`),
  ADD KEY `pkSupMediaTypeID` (`pkSupMediaTypeID`),
  ADD KEY `pkLangID` (`pkLangID`),
  ADD KEY `pkTeamID` (`pkTeamID`),
  ADD KEY `nativeLangTranslationID` (`nativeLangTranslationID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`pk_user_id`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`pk_group_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD KEY `pk_user_id` (`pk_user_id`);

--
-- Indexes for table `user_usergroup_map`
--
ALTER TABLE `user_usergroup_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pkUserID` (`pk_user_id`),
  ADD KEY `pkAuthGroupID` (`pk_group_id`);

--
-- Indexes for table `view_levels`
--
ALTER TABLE `view_levels`
  ADD PRIMARY KEY (`pk_view_level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `pkLangID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sentences`
--
ALTER TABLE `sentences`
  MODIFY `pkSentenceID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sentence_translations`
--
ALTER TABLE `sentence_translations`
  MODIFY `pkSentenceTranslationID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subtitles`
--
ALTER TABLE `subtitles`
  MODIFY `pkSubtitleID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subtitle_types`
--
ALTER TABLE `subtitle_types`
  MODIFY `pkSubtitleTypeID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supported_media_types`
--
ALTER TABLE `supported_media_types`
  MODIFY `pkSupMediaTypeID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `support_media_sources`
--
ALTER TABLE `support_media_sources`
  MODIFY `pkSMediaSourceID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `pkTeamID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `team_chat_comments`
--
ALTER TABLE `team_chat_comments`
  MODIFY `pkCommentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `team_chat_topics`
--
ALTER TABLE `team_chat_topics`
  MODIFY `pkTopicID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `pkTeamMemberID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `team_member_types`
--
ALTER TABLE `team_member_types`
  MODIFY `pkMemTypeID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `translation_media`
--
ALTER TABLE `translation_media`
  MODIFY `pkTmID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `pk_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `pk_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_usergroup_map`
--
ALTER TABLE `user_usergroup_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `view_levels`
--
ALTER TABLE `view_levels`
  MODIFY `pk_view_level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `sentences`
--
ALTER TABLE `sentences`
  ADD CONSTRAINT `sentences_ibfk_1` FOREIGN KEY (`pkLangID`) REFERENCES `languages` (`pkLangID`);

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
  ADD CONSTRAINT `subtitles_ibfk_1` FOREIGN KEY (`pkTmID`) REFERENCES `translation_media` (`pkTmID`),
  ADD CONSTRAINT `subtitles_ibfk_2` FOREIGN KEY (`pkSubtitleTypeID`) REFERENCES `subtitle_types` (`pkSubtitleTypeID`),
  ADD CONSTRAINT `subtitles_ibfk_3` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pk_user_id`),
  ADD CONSTRAINT `subtitles_ibfk_4` FOREIGN KEY (`pkLangID`) REFERENCES `languages` (`pkLangID`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pk_user_id`);

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
  ADD CONSTRAINT `team_chat_topics_ibfk_1` FOREIGN KEY (`pkTeamID`) REFERENCES `teams` (`pkTeamID`),
  ADD CONSTRAINT `team_chat_topics_ibfk_2` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pk_user_id`);

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`pkTeamID`) REFERENCES `teams` (`pkTeamID`),
  ADD CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pk_user_id`),
  ADD CONSTRAINT `team_members_ibfk_3` FOREIGN KEY (`pkMemTypeID`) REFERENCES `team_member_types` (`pkMemTypeID`);

--
-- Constraints for table `translation_media`
--
ALTER TABLE `translation_media`
  ADD CONSTRAINT `translation_media_ibfk_1` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pk_user_id`),
  ADD CONSTRAINT `translation_media_ibfk_2` FOREIGN KEY (`pkSMediaSourceID`) REFERENCES `support_media_sources` (`pkSMediaSourceID`),
  ADD CONSTRAINT `translation_media_ibfk_3` FOREIGN KEY (`pkSupMediaTypeID`) REFERENCES `supported_media_types` (`pkSupMediaTypeID`),
  ADD CONSTRAINT `translation_media_ibfk_4` FOREIGN KEY (`pkLangID`) REFERENCES `languages` (`pkLangID`),
  ADD CONSTRAINT `translation_media_ibfk_5` FOREIGN KEY (`pkTeamID`) REFERENCES `teams` (`pkTeamID`),
  ADD CONSTRAINT `translation_media_ibfk_6` FOREIGN KEY (`nativeLangTranslationID`) REFERENCES `subtitles` (`pkSubtitleID`);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
