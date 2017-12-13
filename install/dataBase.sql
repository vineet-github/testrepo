-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jun 25, 2017 at 05:56 AM
-- Server version: 5.5.42
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `whatsCloneF`
--

-- --------------------------------------------------------

--
-- Table structure for table `wa_admins`
--

CREATE TABLE `wa_admins` (
  `id` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wa_admins`
--

INSERT INTO `wa_admins` (`id`, `username`, `password`, `image`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wa_audios`
--

CREATE TABLE `wa_audios` (
  `id` int(11) NOT NULL,
  `audio_original_name` varchar(225) NOT NULL,
  `audio_new_name` varchar(225) NOT NULL,
  `audio_path` varchar(225) NOT NULL,
  `audio_hash` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Table structure for table `wa_calls`
--

CREATE TABLE `wa_calls` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `date` text NOT NULL,
  `duration` longtext NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT '0',
  `received` tinyint(1) NOT NULL DEFAULT '0',
  `emitted` tinyint(1) NOT NULL DEFAULT '0',
  `type` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wa_conversations`
--

CREATE TABLE `wa_conversations` (
  `id` int(11) NOT NULL,
  `sender` int(11) DEFAULT NULL,
  `recipient` int(11) DEFAULT NULL,
  `Date` text
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wa_documents`
--

CREATE TABLE `wa_documents` (
  `id` int(11) NOT NULL,
  `document_original_name` varchar(225) NOT NULL,
  `document_new_name` varchar(225) NOT NULL,
  `document_path` varchar(225) NOT NULL,
  `document_hash` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `wa_groups`
--

CREATE TABLE `wa_groups` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` text NOT NULL,
  `userID` int(11) NOT NULL,
  `notification_key` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wa_group_members`
--

CREATE TABLE `wa_group_members` (
  `id` int(10) NOT NULL,
  `groupID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `role` varchar(11) DEFAULT NULL,
  `isLeft` tinyint(1) NOT NULL DEFAULT '0',
  `Deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wa_images`
--

CREATE TABLE `wa_images` (
  `id` int(11) NOT NULL,
  `image_original_name` varchar(225) NOT NULL,
  `image_new_name` varchar(225) NOT NULL,
  `image_type` int(11) NOT NULL,
  `image_path` varchar(225) NOT NULL,
  `image_hash` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `wa_messages`
--

CREATE TABLE `wa_messages` (
  `id` int(11) NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(250) DEFAULT NULL,
  `video` varchar(250) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `audio` varchar(255) DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `duration` longtext,
  `fileSize` longtext,
  `UserID` int(11) NOT NULL,
  `groupID` int(11) NOT NULL,
  `Date` text NOT NULL,
  `ConversationID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `wa_settings`
--

CREATE TABLE `wa_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `value` longtext NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wa_settings`
--

INSERT INTO `wa_settings` (`id`, `name`, `value`) VALUES
(1, 'privacy_policy', 'put your Privacy Policy here'),
(2, 'phone_number', 'put your SMS provider phone number here'),
(3, 'sms_authentication_key', 'put your SMS provider authentication key here'),
(4, 'account_sid', 'put your SMS provider account SID here '),
(6, 'app_name', 'put your app name here'),
(7, 'banner_ads_unit_id', 'put your unit id of admob'),
(8, 'banner_ads_status', '0'),
(9, 'interstitial_ads_unit_id', 'put your Interstitial unit id of admob'),
(10, 'interstitial_ads_status', '0'),
(11, 'sms_verification', '0'),
(12, 'app_version', '1'),
(13, 'googleApiKey', 'put your google api key here '),
(14, 'googleSenderId', 'put your google sender id : project ID');

-- --------------------------------------------------------

--
-- Table structure for table `wa_sms_codes`
--

CREATE TABLE `wa_sms_codes` (
  `id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `code` varchar(6) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Table structure for table `wa_status`
--

CREATE TABLE `wa_status` (
  `id` int(11) NOT NULL,
  `status` varchar(225) NOT NULL,
  `userID` int(11) NOT NULL,
  `current` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wa_users`
--

CREATE TABLE `wa_users` (
  `id` int(10) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `auth_token` varchar(32) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_date` int(11) NOT NULL,
  `is_activated` int(1) NOT NULL DEFAULT '0',
  `has_backup` int(1) NOT NULL DEFAULT '0',
  `backup_hash` varchar(255) DEFAULT NULL,
  `registered_id` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

---------------------------------------------------

--
-- Table structure for table `wa_users_blocked`
--

CREATE TABLE `wa_users_blocked` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wa_videos`
--

CREATE TABLE `wa_videos` (
  `id` int(11) NOT NULL,
  `video_original_name` varchar(225) NOT NULL,
  `video_new_name` varchar(225) NOT NULL,
  `video_path` varchar(225) NOT NULL,
  `video_hash` varchar(100) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `wa_admins`
--
ALTER TABLE `wa_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_audios`
--
ALTER TABLE `wa_audios`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `wa_calls`
--
ALTER TABLE `wa_calls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_conversations`
--
ALTER TABLE `wa_conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_documents`
--
ALTER TABLE `wa_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_groups`
--
ALTER TABLE `wa_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_group_members`
--
ALTER TABLE `wa_group_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_images`
--
ALTER TABLE `wa_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_messages`
--
ALTER TABLE `wa_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_settings`
--
ALTER TABLE `wa_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_sms_codes`
--
ALTER TABLE `wa_sms_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `wa_status`
--
ALTER TABLE `wa_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_users`
--
ALTER TABLE `wa_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_users_blocked`
--
ALTER TABLE `wa_users_blocked`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_videos`
--
ALTER TABLE `wa_videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wa_admins`
--
ALTER TABLE `wa_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_audios`
--
ALTER TABLE `wa_audios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wa_calls`
--
ALTER TABLE `wa_calls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_conversations`
--
ALTER TABLE `wa_conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_documents`
--
ALTER TABLE `wa_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_groups`
--
ALTER TABLE `wa_groups`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_group_members`
--
ALTER TABLE `wa_group_members`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_images`
--
ALTER TABLE `wa_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_messages`
--
ALTER TABLE `wa_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_settings`
--
ALTER TABLE `wa_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_sms_codes`
--
ALTER TABLE `wa_sms_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_status`
--
ALTER TABLE `wa_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_users`
--
ALTER TABLE `wa_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_users_blocked`
--
ALTER TABLE `wa_users_blocked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `wa_videos`
--
ALTER TABLE `wa_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;