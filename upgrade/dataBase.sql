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
-- Table structure for table `wa_calls`
--

CREATE TABLE IF NOT EXISTS `wa_calls` (
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

---------------------------------------------------

--
-- Table structure for table `wa_users_blocked`
--

CREATE TABLE IF NOT EXISTS `wa_users_blocked` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `wa_calls`
--
ALTER TABLE `wa_calls`  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_settings`
--
ALTER TABLE `wa_settings`
   ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wa_users_blocked`
--
ALTER TABLE `wa_users_blocked`
  ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wa_calls`
--
ALTER TABLE `wa_calls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `wa_settings`
--
ALTER TABLE `wa_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `wa_users_blocked`
--
ALTER TABLE `wa_users_blocked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;


DROP TABLE IF EXISTS `wa_backups`;
DROP TABLE IF EXISTS `wa_messages_groups_status`;


--
-- Add field notification_key for table `wa_groups`
--
ALTER TABLE `wa_groups`
  ADD `notification_key` text NOT NULL;

--
-- Add field registered_id for table `wa_users`
--
ALTER TABLE `wa_users`
  ADD  `registered_id` text NOT NULL;





--
-- Add values  googleApiKey and googleSenderId for table `wa_settings`
--
DELETE FROM `wa_settings`
WHERE `name`  IN ('app_key_secret','debugging_mode','serverPort');


--
-- Add values  googleApiKey and googleSenderId for table `wa_settings`
--
INSERT IGNORE INTO `wa_settings` (`id`, `name`, `value`) VALUES
(13, 'googleApiKey', 'put your google api key here '),
(14, 'googleSenderId', 'put your google sender id : project ID');