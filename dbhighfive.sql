-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2019 at 11:55 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbhighfive`
--
CREATE DATABASE IF NOT EXISTS `dbhighfive` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dbhighfive`;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `aid` int(11) NOT NULL,
  `path` mediumtext,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chid` int(11) NOT NULL,
  `senderId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `message` mediumtext,
  `aid` int(11) NOT NULL DEFAULT '0',
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `parent_comid` int(11) DEFAULT NULL,
  `comment` mediumtext NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `fid` int(11) NOT NULL,
  `uidr` int(11) NOT NULL,
  `uidl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `gid` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `age_restrict` int(11) DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `description` mediumtext,
  `visibility` int(11) NOT NULL,
  `banned_users` mediumtext,
  `group_profile` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `gmid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `pid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `aid` int(11) NOT NULL DEFAULT '0',
  `content` mediumtext,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `DOB` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `recovery_code` varchar(50) DEFAULT NULL,
  `recovery_code_created` datetime DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usersinfo`
--

CREATE TABLE `usersinfo` (
  `ufid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `home_town` varchar(100) DEFAULT NULL,
  `current_city` varchar(100) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `about` mediumtext,
  `profile_pic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_preferences`
--

CREATE TABLE `user_preferences` (
  `upid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `users_muted` mediumtext,
  `groups_muted` mediumtext,
  `users_blocked` mediumtext,
  `groups_blocked` mediumtext,
  `auto_download` int(11) NOT NULL,
  `visibility_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chid`),
  ADD KEY `senderId` (`senderId`),
  ADD KEY `receiverId` (`receiverId`),
  ADD KEY `aid` (`aid`) USING BTREE;

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `parent_comid` (`parent_comid`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `uidr` (`uidr`),
  ADD KEY `uidl` (`uidl`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`gmid`),
  ADD KEY `gid` (`gid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `aid` (`aid`),
  ADD KEY `gid` (`gid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `usersinfo`
--
ALTER TABLE `usersinfo`
  ADD PRIMARY KEY (`ufid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD PRIMARY KEY (`upid`),
  ADD KEY `uid` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `gmid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usersinfo`
--
ALTER TABLE `usersinfo`
  MODIFY `ufid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_preferences`
--
ALTER TABLE `user_preferences`
  MODIFY `upid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`senderId`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`receiverId`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `chats_ibfk_3` FOREIGN KEY (`aid`) REFERENCES `attachments` (`aid`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `posts` (`pid`),
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_comid`) REFERENCES `comments` (`comid`);

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`uidr`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`uidl`) REFERENCES `users` (`uid`);

--
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_members_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `groups` (`gid`),
  ADD CONSTRAINT `group_members_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `aid` FOREIGN KEY (`aid`) REFERENCES `attachments` (`aid`),
  ADD CONSTRAINT `gid` FOREIGN KEY (`gid`) REFERENCES `groups` (`gid`),
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `usersinfo`
--
ALTER TABLE `usersinfo`
  ADD CONSTRAINT `usersinfo_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD CONSTRAINT `user_preferences_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);
  
DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `recovery_code_expired` ON SCHEDULE EVERY 1 HOUR STARTS '2019-06-08 21:49:44' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE users
SET recovery_code = NULL
where TIMESTAMPDIFF(MINUTE, recovery_code_created,CURRENT_TIMESTAMP) > 60$$

CREATE DEFINER=`root`@`localhost` EVENT `status_reset` ON SCHEDULE EVERY 5 MINUTE STARTS '2019-06-10 19:28:47' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Resets the status to 0[dormant] after every 5 minutes.' DO UPDATE users
SET status = NULL$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
