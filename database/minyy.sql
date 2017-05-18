-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 18 May 2017, 20:23:53
-- Sunucu sürümü: 5.7.14
-- PHP Sürümü: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `minyy`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `languages`
--

CREATE TABLE `languages` (
  `pk_lang_id` int(11) NOT NULL,
  `lang_name` tinytext NOT NULL,
  `lang_code` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `languages`
--

INSERT INTO `languages` (`pk_lang_id`, `lang_name`, `lang_code`) VALUES
(1, 'TURKISH', 'tr'),
(2, 'ENGLISH', 'en');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `medias`
--

CREATE TABLE `medias` (
  `pk_media_id` int(11) NOT NULL,
  `name` tinytext,
  `description` text,
  `media_url` text NOT NULL,
  `media_type` varchar(12) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `lang_code` varchar(8) NOT NULL,
  `pk_team_id` int(11) DEFAULT NULL,
  `translated_langs` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `medias`
--

INSERT INTO `medias` (`pk_media_id`, `name`, `description`, `media_url`, `media_type`, `created_at`, `created_by`, `lang_code`, `pk_team_id`, `translated_langs`) VALUES
(2, 'medya ismi', 'medya ile ilgili açıklama', 'https://www.youtube.com/watch?v=zzhzzhzh', 'VID', '2017-05-01 01:22:50', 29, 'tr', 3, NULL),
(3, 'medya', 'herhangi bir açıklama girilebilir', 'www.google.com', 'MP3', '2017-05-05 04:11:50', 29, 'en', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `modules`
--

CREATE TABLE `modules` (
  `pk_module_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `module_key` varchar(20) NOT NULL,
  `does` text,
  `params` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `modules`
--

INSERT INTO `modules` (`pk_module_id`, `name`, `icon`, `module_key`, `does`, `params`) VALUES
(1, 'Dashboard', 'fa-dashboard', 'dashboard', NULL, NULL),
(2, 'Users', 'fa-user', 'users', '["add","edit","remove","list_all"]', NULL),
(3, 'User Groups', 'fa-users', 'user_groups', '["add","edit","remove","list_all"]', NULL),
(4, 'View Levels', 'fa-bars', 'view_levels', '["add","edit","remove","list_all"]', NULL),
(5, 'Pages', 'fa-file', 'pages', '["add","edit","remove","list_all"]', NULL),
(6, 'Posts', 'fa-file', 'posts', '["add","edit","remove","list_all"]', NULL),
(7, 'Forms', 'fa-dashboard', 'forms', '["add","edit","remove","list_all","show"]', NULL),
(8, 'Medias', NULL, 'medias', '["add","edit","remove","list","list_all","show"]', NULL),
(9, 'Teams', NULL, 'teams', '["add","edit","remove","list","list_all","show"]', NULL),
(10, 'Languages', NULL, 'languages', '["add","edit","remove","list"]', NULL),
(11, 'Topics', NULL, 'topics', '["add","edit","remove","list","list_all","show"]', NULL),
(12, 'Translations', NULL, 'translations', '["add","remove","list","list_all","show"]', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `posts`
--

CREATE TABLE `posts` (
  `pk_post_id` int(11) NOT NULL,
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
  `post_params` json DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `posts`
--

INSERT INTO `posts` (`pk_post_id`, `author_id`, `post_date`, `post_title`, `post_alias`, `post_content`, `post_status`, `comment_status`, `modified_by`, `modified_date`, `guid`, `post_type`, `comment_count`, `post_params`) VALUES
(1, 29, '2017-05-02 17:54:42', 'başlık', 'asdas', 'kjhasdfgsadofgb', 'status', 'status', 1, '2017-05-03 18:07:37', 'asdasd', 'type', 5, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sentences`
--

CREATE TABLE `sentences` (
  `pk_sentence_id` int(11) NOT NULL,
  `subtitle_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `order_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `subtitles`
--

CREATE TABLE `subtitles` (
  `pk_subtitle_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lang_code` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `subtitles`
--

INSERT INTO `subtitles` (`pk_subtitle_id`, `media_id`, `created_by`, `created_at`, `lang_code`) VALUES
(1, 2, 29, '2017-04-30 22:22:50', 'en');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teams`
--

CREATE TABLE `teams` (
  `pk_team_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `params` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `teams`
--

INSERT INTO `teams` (`pk_team_id`, `name`, `description`, `created_at`, `created_by`, `params`) VALUES
(1, 'elma', '', '2017-05-16 20:21:32', 29, NULL),
(2, 'Deneme Takımı hhhhhhhhhhh', '', '2017-05-16 20:24:13', 29, NULL),
(3, 'My Team Name 2 ', 'TEST TEST TEST', '2017-05-12 17:37:38', 29, NULL),
(4, 'Deneme Takımı 0000', '', '2017-05-16 20:23:48', 29, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `team_members`
--

CREATE TABLE `team_members` (
  `pk_team_member_id` int(11) NOT NULL,
  `since` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(15) NOT NULL,
  `params` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `team_members`
--

INSERT INTO `team_members` (`pk_team_member_id`, `since`, `team_id`, `user_id`, `type`, `params`) VALUES
(1, '2017-05-01 01:22:50', 1, 1, 'member', NULL),
(2, '2017-05-01 01:22:50', 3, 29, 'member', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `team_topics`
--

CREATE TABLE `team_topics` (
  `pk_topic_id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `content` longtext NOT NULL,
  `team_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `team_topics`
--

INSERT INTO `team_topics` (`pk_topic_id`, `title`, `content`, `team_id`, `created_at`, `created_by`) VALUES
(1, 'Merhaba!', 'merhaba dünyalı bu benim ilk topic yayınım.', 3, '2017-04-30 22:22:50', 29);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `team_topic_messages`
--

CREATE TABLE `team_topic_messages` (
  `pk_tt_message_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

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
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`pk_user_id`, `username`, `password`, `email`, `last_visit`, `fullname`, `registration_date`) VALUES
(1, 'mybirer', 'e10adc3949ba59abbe56e057f20f883e', 'mybirer@gmail.com', '2017-05-18 20:21:31', 'M. Yasin Birer', '2017-04-07 21:00:00'),
(7, 'moderator', 'e10adc3949ba59abbe56e057f20f883e', 'moderator@localhost.com', '2017-05-02 16:27:47', 'Moderatör Kardeş', '2017-04-20 07:59:12'),
(8, 'cevirmen', 'e10adc3949ba59abbe56e057f20f883e', 'cevirmen@localhost.com', '2017-05-10 19:32:07', 'Çevirmen Kardeşimiz', '2017-04-20 08:05:38'),
(28, 'ahmetcan23', '202cb962ac59075b964b07152d234b70', 'ahmetcan@asdf.com', '2017-05-01 13:03:04', 'ahmetcan23', '2017-04-30 22:22:50'),
(29, 'erden', '8619d248219882ab72aaa3b44474bd5d', 'cwyusef@gmail.com', '2017-05-18 08:27:01', 'Muhammed Yusuf ERDEN', '2017-05-03 18:07:37'),
(30, 'Mehmet', '827ccb0eea8a706c4c34a16891f84e7b', 'mehmetonatce@gmail.com', '2017-05-18 20:22:37', 'Mehmet ONAT', '2017-05-18 20:19:51');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_groups`
--

CREATE TABLE `user_groups` (
  `pk_group_id` int(11) NOT NULL,
  `name` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `user_groups`
--

INSERT INTO `user_groups` (`pk_group_id`, `name`) VALUES
(3, 'Super Users'),
(4, 'Translators'),
(7, 'Moderators');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_profiles`
--

CREATE TABLE `user_profiles` (
  `pk_user_id` int(11) NOT NULL,
  `profile_key` varchar(100) NOT NULL,
  `profile_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_usergroup_map`
--

CREATE TABLE `user_usergroup_map` (
  `id` int(11) NOT NULL,
  `pk_user_id` int(11) NOT NULL,
  `pk_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `user_usergroup_map`
--

INSERT INTO `user_usergroup_map` (`id`, `pk_user_id`, `pk_group_id`) VALUES
(19, 7, 7),
(23, 28, 3),
(24, 28, 4),
(25, 8, 7),
(26, 8, 4),
(29, 1, 3),
(30, 29, 3),
(32, 30, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `view_levels`
--

CREATE TABLE `view_levels` (
  `pk_view_level_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `groups` varchar(5120) NOT NULL DEFAULT '[]' COMMENT 'JSON encoded group id list',
  `modules` varchar(5120) NOT NULL DEFAULT '[]' COMMENT 'JSON encoded module list'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `view_levels`
--

INSERT INTO `view_levels` (`pk_view_level_id`, `title`, `groups`, `modules`) VALUES
(2, 'Public Area', '[7,3,4]', '["posts"]'),
(4, 'Manager Area', '[3]', '["dashboard","users","user_groups","view_levels","pages","posts","forms","medias","teams","languages"]'),
(5, 'Translator Area', '[4]', '["dashboard","medias"]'),
(6, 'Moderator Area', '[7]', '[]');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`pk_lang_id`),
  ADD KEY `lang_code` (`lang_code`) USING BTREE;

--
-- Tablo için indeksler `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`pk_media_id`),
  ADD KEY `pk_team_id` (`pk_team_id`) USING BTREE,
  ADD KEY `created_by` (`created_by`) USING BTREE,
  ADD KEY `lang_code` (`lang_code`) USING BTREE;

--
-- Tablo için indeksler `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`pk_module_id`);

--
-- Tablo için indeksler `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`pk_post_id`);

--
-- Tablo için indeksler `sentences`
--
ALTER TABLE `sentences`
  ADD PRIMARY KEY (`pk_sentence_id`),
  ADD KEY `subtitle_id` (`subtitle_id`);

--
-- Tablo için indeksler `subtitles`
--
ALTER TABLE `subtitles`
  ADD PRIMARY KEY (`pk_subtitle_id`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `created_by` (`created_by`) USING BTREE,
  ADD KEY `lang_code` (`lang_code`) USING BTREE;

--
-- Tablo için indeksler `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`pk_team_id`),
  ADD KEY `created_by` (`created_by`) USING BTREE;

--
-- Tablo için indeksler `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`pk_team_member_id`),
  ADD KEY `team_id` (`team_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Tablo için indeksler `team_topics`
--
ALTER TABLE `team_topics`
  ADD PRIMARY KEY (`pk_topic_id`),
  ADD KEY `team_id` (`team_id`) USING BTREE,
  ADD KEY `created_by` (`created_by`) USING BTREE;

--
-- Tablo için indeksler `team_topic_messages`
--
ALTER TABLE `team_topic_messages`
  ADD PRIMARY KEY (`pk_tt_message_id`),
  ADD KEY `topic_id` (`topic_id`) USING BTREE,
  ADD KEY `user_id` (`created_by`) USING BTREE;

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`pk_user_id`);

--
-- Tablo için indeksler `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`pk_group_id`);

--
-- Tablo için indeksler `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD KEY `pk_user_id` (`pk_user_id`);

--
-- Tablo için indeksler `user_usergroup_map`
--
ALTER TABLE `user_usergroup_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pkUserID` (`pk_user_id`),
  ADD KEY `pkAuthGroupID` (`pk_group_id`);

--
-- Tablo için indeksler `view_levels`
--
ALTER TABLE `view_levels`
  ADD PRIMARY KEY (`pk_view_level_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `languages`
--
ALTER TABLE `languages`
  MODIFY `pk_lang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tablo için AUTO_INCREMENT değeri `medias`
--
ALTER TABLE `medias`
  MODIFY `pk_media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `modules`
--
ALTER TABLE `modules`
  MODIFY `pk_module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Tablo için AUTO_INCREMENT değeri `posts`
--
ALTER TABLE `posts`
  MODIFY `pk_post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `sentences`
--
ALTER TABLE `sentences`
  MODIFY `pk_sentence_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `subtitles`
--
ALTER TABLE `subtitles`
  MODIFY `pk_subtitle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `teams`
--
ALTER TABLE `teams`
  MODIFY `pk_team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tablo için AUTO_INCREMENT değeri `team_members`
--
ALTER TABLE `team_members`
  MODIFY `pk_team_member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tablo için AUTO_INCREMENT değeri `team_topics`
--
ALTER TABLE `team_topics`
  MODIFY `pk_topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `team_topic_messages`
--
ALTER TABLE `team_topic_messages`
  MODIFY `pk_tt_message_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `pk_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- Tablo için AUTO_INCREMENT değeri `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `pk_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Tablo için AUTO_INCREMENT değeri `user_usergroup_map`
--
ALTER TABLE `user_usergroup_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- Tablo için AUTO_INCREMENT değeri `view_levels`
--
ALTER TABLE `view_levels`
  MODIFY `pk_view_level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `medias`
--
ALTER TABLE `medias`
  ADD CONSTRAINT `medias_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`pk_user_id`),
  ADD CONSTRAINT `medias_ibfk_2` FOREIGN KEY (`lang_code`) REFERENCES `languages` (`lang_code`),
  ADD CONSTRAINT `medias_ibfk_5` FOREIGN KEY (`pk_team_id`) REFERENCES `teams` (`pk_team_id`);

--
-- Tablo kısıtlamaları `sentences`
--
ALTER TABLE `sentences`
  ADD CONSTRAINT `sentences_ibfk_1` FOREIGN KEY (`subtitle_id`) REFERENCES `subtitles` (`pk_subtitle_id`);

--
-- Tablo kısıtlamaları `subtitles`
--
ALTER TABLE `subtitles`
  ADD CONSTRAINT `subtitles_ibfk_1` FOREIGN KEY (`lang_code`) REFERENCES `languages` (`lang_code`),
  ADD CONSTRAINT `subtitles_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`pk_user_id`),
  ADD CONSTRAINT `subtitles_ibfk_3` FOREIGN KEY (`media_id`) REFERENCES `medias` (`pk_media_id`);

--
-- Tablo kısıtlamaları `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`pk_user_id`);

--
-- Tablo kısıtlamaları `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`pk_team_id`),
  ADD CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`pk_user_id`);

--
-- Tablo kısıtlamaları `team_topics`
--
ALTER TABLE `team_topics`
  ADD CONSTRAINT `team_topics_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`pk_team_id`),
  ADD CONSTRAINT `team_topics_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`pk_user_id`);

--
-- Tablo kısıtlamaları `team_topic_messages`
--
ALTER TABLE `team_topic_messages`
  ADD CONSTRAINT `tt_messages_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `team_topics` (`pk_topic_id`),
  ADD CONSTRAINT `tt_messages_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`pk_user_id`);

--
-- Tablo kısıtlamaları `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`pk_user_id`) REFERENCES `users` (`pk_user_id`);

--
-- Tablo kısıtlamaları `user_usergroup_map`
--
ALTER TABLE `user_usergroup_map`
  ADD CONSTRAINT `user_usergroup_map_ibfk_1` FOREIGN KEY (`pk_user_id`) REFERENCES `users` (`pk_user_id`),
  ADD CONSTRAINT `user_usergroup_map_ibfk_2` FOREIGN KEY (`pk_group_id`) REFERENCES `user_groups` (`pk_group_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
