-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2017 at 08:52 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `minyy`
--
CREATE DATABASE IF NOT EXISTS `minyy` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `minyy`;

-- --------------------------------------------------------

--
-- Table structure for table `authorization_access_types`
--

DROP TABLE IF EXISTS `authorization_access_types`;
CREATE TABLE `authorization_access_types` (
  `pkAuthAccessTypeID` int(11) NOT NULL,
  `accessTypeName` tinytext NOT NULL,
  `accessTypeDescription` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `authorization_groups`
--

DROP TABLE IF EXISTS `authorization_groups`;
CREATE TABLE `authorization_groups` (
  `pkAuthGroupID` int(11) NOT NULL,
  `authGroupName` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_group_access_map`
--

DROP TABLE IF EXISTS `auth_group_access_map`;
CREATE TABLE `auth_group_access_map` (
  `pkAGAMap` int(11) NOT NULL,
  `pkAuthGroupID` int(11) NOT NULL,
  `pkAuthAccessTypeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_group_members`
--

DROP TABLE IF EXISTS `auth_group_members`;
CREATE TABLE `auth_group_members` (
  `pkAGMembers` int(11) NOT NULL,
  `pkUserID` int(11) NOT NULL,
  `pkAuthGroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `pkUserID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(75) NOT NULL,
  `lastVisit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fullName` varchar(50) DEFAULT NULL,
  `registrationDate` timestamp NULL DEFAULT NULL,
  `pkLangID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`pkUserID`, `username`, `password`, `email`, `lastVisit`, `fullName`, `registrationDate`, `pkLangID`) VALUES
(1, 'mybirer', 'e10adc3949ba59abbe56e057f20f883e', 'mybirer@gmail.com', '2017-04-20 08:28:01', 'M. Yasin Birer', '2017-04-07 21:00:00', NULL),
(7, 'aliveli', 'e10adc3949ba59abbe56e057f20f883e', 'aliveli@nuri.com', '2017-04-20 07:59:12', 'ali', '2017-04-20 07:59:12', NULL),
(8, 'memo', '202cb962ac59075b964b07152d234b70', 'memo@cano.com', '2017-04-20 08:05:38', 'Ali', '2017-04-20 08:05:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

DROP TABLE IF EXISTS `user_data`;
CREATE TABLE `user_data` (
  `pkUserData` int(11) NOT NULL,
  `pkUserID` int(11) NOT NULL,
  `pkUserDataTypeID` int(11) NOT NULL,
  `dataValue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_data_types`
--

DROP TABLE IF EXISTS `user_data_types`;
CREATE TABLE `user_data_types` (
  `pkUserDataTypeID` int(11) NOT NULL,
  `dataTypeName` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authorization_access_types`
--
ALTER TABLE `authorization_access_types`
  ADD PRIMARY KEY (`pkAuthAccessTypeID`);

--
-- Indexes for table `authorization_groups`
--
ALTER TABLE `authorization_groups`
  ADD PRIMARY KEY (`pkAuthGroupID`);

--
-- Indexes for table `auth_group_access_map`
--
ALTER TABLE `auth_group_access_map`
  ADD PRIMARY KEY (`pkAGAMap`),
  ADD KEY `pkAuthGroupID` (`pkAuthGroupID`),
  ADD KEY `pkAuthAccessTypeID` (`pkAuthAccessTypeID`);

--
-- Indexes for table `auth_group_members`
--
ALTER TABLE `auth_group_members`
  ADD PRIMARY KEY (`pkAGMembers`),
  ADD KEY `pkUserID` (`pkUserID`),
  ADD KEY `pkAuthGroupID` (`pkAuthGroupID`);

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
  ADD PRIMARY KEY (`pkUserID`),
  ADD KEY `pkLangID` (`pkLangID`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`pkUserData`),
  ADD KEY `pkUserID` (`pkUserID`),
  ADD KEY `pkUserDataTypeID` (`pkUserDataTypeID`);

--
-- Indexes for table `user_data_types`
--
ALTER TABLE `user_data_types`
  ADD PRIMARY KEY (`pkUserDataTypeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authorization_access_types`
--
ALTER TABLE `authorization_access_types`
  MODIFY `pkAuthAccessTypeID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `authorization_groups`
--
ALTER TABLE `authorization_groups`
  MODIFY `pkAuthGroupID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `auth_group_access_map`
--
ALTER TABLE `auth_group_access_map`
  MODIFY `pkAGAMap` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `auth_group_members`
--
ALTER TABLE `auth_group_members`
  MODIFY `pkAGMembers` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `pkUserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `pkUserData` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_data_types`
--
ALTER TABLE `user_data_types`
  MODIFY `pkUserDataTypeID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_group_access_map`
--
ALTER TABLE `auth_group_access_map`
  ADD CONSTRAINT `auth_group_access_map_ibfk_1` FOREIGN KEY (`pkAuthGroupID`) REFERENCES `authorization_groups` (`pkAuthGroupID`),
  ADD CONSTRAINT `auth_group_access_map_ibfk_2` FOREIGN KEY (`pkAuthAccessTypeID`) REFERENCES `authorization_access_types` (`pkAuthAccessTypeID`);

--
-- Constraints for table `auth_group_members`
--
ALTER TABLE `auth_group_members`
  ADD CONSTRAINT `auth_group_members_ibfk_1` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pkUserID`),
  ADD CONSTRAINT `auth_group_members_ibfk_2` FOREIGN KEY (`pkAuthGroupID`) REFERENCES `authorization_groups` (`pkAuthGroupID`);

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
  ADD CONSTRAINT `subtitles_ibfk_3` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pkUserID`),
  ADD CONSTRAINT `subtitles_ibfk_4` FOREIGN KEY (`pkLangID`) REFERENCES `languages` (`pkLangID`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pkUserID`);

--
-- Constraints for table `team_chat_comments`
--
ALTER TABLE `team_chat_comments`
  ADD CONSTRAINT `team_chat_comments_ibfk_1` FOREIGN KEY (`pkTopicID`) REFERENCES `team_chat_topics` (`pkTopicID`),
  ADD CONSTRAINT `team_chat_comments_ibfk_2` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pkUserID`);

--
-- Constraints for table `team_chat_topics`
--
ALTER TABLE `team_chat_topics`
  ADD CONSTRAINT `team_chat_topics_ibfk_1` FOREIGN KEY (`pkTeamID`) REFERENCES `teams` (`pkTeamID`),
  ADD CONSTRAINT `team_chat_topics_ibfk_2` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pkUserID`);

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`pkTeamID`) REFERENCES `teams` (`pkTeamID`),
  ADD CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pkUserID`),
  ADD CONSTRAINT `team_members_ibfk_3` FOREIGN KEY (`pkMemTypeID`) REFERENCES `team_member_types` (`pkMemTypeID`);

--
-- Constraints for table `translation_media`
--
ALTER TABLE `translation_media`
  ADD CONSTRAINT `translation_media_ibfk_1` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pkUserID`),
  ADD CONSTRAINT `translation_media_ibfk_2` FOREIGN KEY (`pkSMediaSourceID`) REFERENCES `support_media_sources` (`pkSMediaSourceID`),
  ADD CONSTRAINT `translation_media_ibfk_3` FOREIGN KEY (`pkSupMediaTypeID`) REFERENCES `supported_media_types` (`pkSupMediaTypeID`),
  ADD CONSTRAINT `translation_media_ibfk_4` FOREIGN KEY (`pkLangID`) REFERENCES `languages` (`pkLangID`),
  ADD CONSTRAINT `translation_media_ibfk_5` FOREIGN KEY (`pkTeamID`) REFERENCES `teams` (`pkTeamID`),
  ADD CONSTRAINT `translation_media_ibfk_6` FOREIGN KEY (`nativeLangTranslationID`) REFERENCES `subtitles` (`pkSubtitleID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`pkLangID`) REFERENCES `languages` (`pkLangID`);

--
-- Constraints for table `user_data`
--
ALTER TABLE `user_data`
  ADD CONSTRAINT `user_data_ibfk_1` FOREIGN KEY (`pkUserID`) REFERENCES `users` (`pkUserID`),
  ADD CONSTRAINT `user_data_ibfk_2` FOREIGN KEY (`pkUserDataTypeID`) REFERENCES `user_data_types` (`pkUserDataTypeID`);
