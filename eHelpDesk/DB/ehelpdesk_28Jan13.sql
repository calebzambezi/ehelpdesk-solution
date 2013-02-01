-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2013 at 09:10 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ehelpdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` char(15) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Technical'),
(2, 'Sales'),
(3, 'General');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('430b7c7780bcc82916dc3083d5db5ca2', '::1', 'Mozilla/5.0 (Windows NT 6.0; rv:17.0) Gecko/20100101 Firefox/17.0', 1356612565, 0x613a383a7b733a393a22757365725f64617461223b733a303a22223b733a343a226c616e67223b733a373a22656e676c697368223b733a373a22757365725f6964223b733a303a22223b733a383a22757365726e616d65223b733a303a22223b733a353a22656d61696c223b733a303a22223b733a363a22737461747573223b733a303a22223b733a383a2267726f75705f6964223b733a303a22223b733a31313a226e6f746966795f75736572223b733a303a22223b7d),
('b0aa8b48c6076c336558dae049b04405', '::1', 'Mozilla/5.0 (Windows NT 6.0; rv:17.0) Gecko/20100101 Firefox/17.0', 1356616921, 0x613a383a7b733a393a22757365725f64617461223b733a303a22223b733a343a226c616e67223b733a373a22656e676c697368223b733a373a22757365725f6964223b733a303a22223b733a383a22757365726e616d65223b733a303a22223b733a353a22656d61696c223b733a303a22223b733a363a22737461747573223b733a303a22223b733a383a2267726f75705f6964223b733a303a22223b733a31313a226e6f746966795f75736572223b733a303a22223b7d),
('fa843683dd11267f1004c855d374dbfd', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17', 1359403733, 0x613a373a7b733a373a22757365725f6964223b733a313a2235223b733a383a22757365726e616d65223b733a363a22666a616d616c223b733a353a22656d61696c223b733a31373a22666a616d616c406261797465792e636f6d223b733a363a22737461747573223b733a313a2231223b733a383a2267726f75705f6964223b733a333a22323030223b733a31313a226e6f746966795f75736572223b733a323a222d31223b733a363a2262616e6e6564223b733a313a2230223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(15) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`group_id`, `group_name`) VALUES
(100, 'Admin'),
(200, 'User'),
(300, 'Moderator');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `priority`
--

CREATE TABLE IF NOT EXISTS `priority` (
  `priority_id` int(11) NOT NULL AUTO_INCREMENT,
  `priority_name` char(15) NOT NULL,
  PRIMARY KEY (`priority_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `priority`
--

INSERT INTO `priority` (`priority_id`, `priority_name`) VALUES
(1, 'Low'),
(2, 'Medium'),
(3, 'High');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE IF NOT EXISTS `reply` (
  `reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `reply_text` text NOT NULL,
  `attachment` char(30) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `is_active` char(1) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`reply_id`),
  KEY `users_id` (`users_id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` char(15) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(1, 'Open'),
(2, 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL,
  `message` text NOT NULL,
  `attachment` char(30) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `date_closed` datetime DEFAULT NULL,
  `is_active` char(1) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`ticket_id`),
  KEY `users_id` (`users_id`),
  KEY `priority_id` (`priority_id`),
  KEY `category_id` (`category_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `title`, `message`, `attachment`, `users_id`, `priority_id`, `category_id`, `status_id`, `date_closed`, `is_active`, `date_created`, `date_updated`) VALUES
(1, 'Question number 1', 'HEY! TESTING', '', 1, 2, 1, 1, NULL, '', '2012-11-01 00:07:04', '2012-11-01 00:07:04'),
(8, 'I need help', 'vvvvvvvvvv', '', 1, 1, 1, 1, NULL, '', '2012-11-13 01:46:46', '2012-11-05 01:46:46'),
(9, 'I need help', 'vvvvvvvvvv', '', 1, 1, 1, 1, NULL, '', '2012-11-05 01:46:46', '2012-11-05 01:46:46'),
(10, 'I need help', 'vvvvvvvvvv', '', 1, 1, 1, 1, NULL, '', '2012-11-08 01:46:46', '2012-11-05 01:46:46'),
(11, 'MYYYYYYYYY', 'WORKKKKKKKKKKK', '', 1, 1, 1, 1, NULL, '', '2012-11-05 01:54:36', '2012-11-05 01:54:36'),
(12, 'lllllllll', 'mmmmmmmmm', NULL, 5, 1, 1, 1, NULL, '', '2012-11-05 01:58:26', '2012-11-05 01:58:26'),
(13, 'xvxcvxcvxcvxc', 'vvvvvvvvvvv', '', 1, 3, 3, 1, NULL, '', '2012-11-05 02:00:35', '2012-11-05 02:00:35'),
(14, 'nnnnnnnnnnn', 'aaaaaaaaaaaaaaaa', 'jjj2.txt', 1, 3, 2, 1, NULL, '', '2012-11-05 02:01:12', '2012-11-05 02:01:12'),
(15, 'mmmmmmmmmmmmmm', '5hghllllllllllllllllllllll', 'vvvvbghbg.txt', 1, 3, 2, 1, NULL, '', '2012-11-05 02:03:31', '2012-11-05 02:03:31'),
(16, 'bbbbbbbbb', 'ccccccccc', '', 1, 1, 1, 1, NULL, '', '2012-11-05 02:06:52', '2012-11-05 02:06:52'),
(24, 'oooooooooooooooo', 'qqqqqqqqqqqqq,,,,,,,,,,,,,,,,', NULL, 1, 1, 1, 1, NULL, '', '2012-11-05 02:13:28', '2012-11-05 02:13:28'),
(25, 'kkllll', 'lllllllll', NULL, 1, 1, 1, 1, NULL, '', '2012-11-05 02:17:09', '2012-11-05 02:17:09'),
(26, 'kkkkkk', 'mmmmmmmmm', 'NULL', 1, 1, 1, 1, NULL, '', '2012-11-05 02:34:04', '2012-11-05 02:34:04'),
(27, 'LLPPPPPPPPp', 'PPPPPPPPPPPPP', 'S.txt', 1, 1, 1, 1, NULL, '', '2012-11-05 02:37:03', '2012-11-05 02:37:03'),
(28, 'nnnnnnnnnn', 'cccccccccccc', 'license-non-commercial.txt', 1, 1, 1, 1, NULL, '', '2012-11-05 02:55:02', '2012-11-05 02:55:02'),
(29, 'nnnnnnnn', 'srtrterter', NULL, 1, 2, 2, 1, NULL, '', '2012-11-05 10:57:38', '2012-11-05 10:57:38'),
(30, 'mmmmmmmmmm', 'mmmmmmmmmmmmmmmmmmmmmmm', 'n.txt', 1, 3, 2, 1, NULL, '', '2012-11-05 11:05:13', '2012-11-05 11:05:13'),
(31, 'hhhhhhhhhhhhhhhhh', 'kkkkkkkk', 'm.txt', 1, 3, 3, 1, NULL, '', '2012-11-05 11:12:08', '2012-11-05 11:12:08'),
(32, 'JAMES', 'kkkkkkkkkkkkkk', NULL, 1, 1, 1, 1, NULL, '', '2012-11-12 09:21:28', '2012-11-12 09:21:28'),
(33, 'JAMES 2', 'YESSS', NULL, 1, 3, 2, 1, NULL, '', '2012-11-12 09:21:58', '2012-11-12 09:21:58'),
(34, 'Latest rest!!!', 'YESSSS', NULL, 5, 3, 2, 1, NULL, '', '2012-12-03 19:22:24', '2012-12-03 19:22:24'),
(35, 'ppppppp', 'kkkkkkkkkkkk', NULL, 5, 1, 1, 1, NULL, '', '2012-12-03 19:40:22', '0000-00-00 00:00:00'),
(36, 'lllllllll', ',,,,,,,,,,,,,,,', NULL, 5, 1, 1, 1, NULL, '', '2012-12-03 19:41:58', NULL),
(37, 'I Need a Discount', 'Do you have any new promotions going on?', NULL, 5, 2, 2, 1, NULL, '', '2012-12-16 17:24:00', NULL),
(38, 'I Need Best Promotion', 'What is the latest promotion?', NULL, 5, 2, 3, 2, '2012-12-22 16:43:58', '', '2012-12-16 17:25:55', '2012-12-22 16:43:45'),
(39, 'erterter', 'ertertertertertert', NULL, 5, 1, 1, 1, NULL, '', '2012-12-16 17:29:01', NULL),
(40, 'nnnnnnnnnnnnn', 'kkkkkkkkkkkkkkk', 'Course_1_(Essentials).txt', 5, 1, 1, 1, NULL, '', '2012-12-16 17:31:17', NULL),
(41, 'tyutyutyuyutyutyu', 'uyttu', '7.AccessObjectProperties_.PNG', 5, 1, 1, 1, NULL, '', '2012-12-16 17:35:41', NULL),
(42, 'vvvvvvvv', 'reterterteter', 'Source.txt', 5, 1, 1, 1, NULL, '', '2012-12-16 17:39:29', NULL),
(43, 'ertertertertertertertergf', 'rrrrrrrrrrrrr', NULL, 5, 1, 1, 2, '2012-12-20 22:49:30', '', '2012-12-16 18:32:39', '2012-12-20 22:49:21'),
(44, 'ertertertertertertertergf', 'rrrrrrrrrrrrr', '2.Variables_.PNG', 5, 1, 1, 1, '2012-12-20 19:58:30', '', '2012-12-16 18:32:52', NULL),
(45, 'ertertertertertertertergf', 'rrrrrrrrrrrrr', '13.Inheritence_.PNG', 5, 1, 1, 1, NULL, '', '2012-12-16 18:33:15', NULL),
(46, 'ertertertertertertertergf', 'rrrrrrrrrrrrr', '13.Inheritence_1.PNG', 5, 1, 1, 1, NULL, '', '2012-12-16 18:33:25', '2012-12-25 08:18:18'),
(47, 'ertertertertertertertergf', 'rrrrrrrrrrrrr', '13.Inheritence_2.PNG', 5, 1, 1, 1, '2012-12-20 19:54:55', '', '2012-12-16 18:35:14', '2012-12-20 19:54:55'),
(48, 'ffffffff', 'eeeeee', '9.NestedObjects_.PNG', 5, 2, 3, 1, '2012-12-20 20:00:19', '', '2012-12-16 18:35:27', NULL),
(49, 'rtyrtyrtyrt', 'rtytyrty', NULL, 5, 1, 1, 1, '2012-12-20 18:58:10', '', '2012-12-16 18:35:50', '2012-12-20 18:58:10'),
(50, 'rtyrtyrtyrt', 'rtytyrty', NULL, 5, 3, 3, 1, '2012-12-20 19:29:36', '', '2012-12-16 18:36:14', '2012-12-25 07:33:34'),
(51, '90000000 EDITED', 'bbbbb YESSSSSS\r\n\r\nVVVVVVV', NULL, 5, 2, 1, 2, '2012-12-20 22:23:22', '', '2012-12-16 19:12:39', '2012-12-20 22:21:32'),
(52, 'xcvxcvx', 'xcvcx', 'README.txt', 5, 1, 1, 1, '2012-12-20 18:47:29', '', '2012-12-16 19:13:12', '2012-12-20 18:47:29'),
(53, 'pYESSSSSS JUST GOT CLOSED', 'Noooop', '1.WhereToPlaceJS_.PNG', 5, 3, 3, 2, '2012-12-20 22:18:46', '', '2012-12-16 19:30:40', '2012-12-20 18:53:37'),
(54, 'ooooooooooooo', 'ooooooooooo', 'Capture.PNG', 5, 1, 1, 2, '2012-12-25 08:22:45', '', '2012-12-16 19:32:56', NULL),
(55, 'iiiiiiiiiiiiii', 'jjjjjjjjj', NULL, 5, 3, 1, 1, '2012-12-20 18:57:37', '', '2012-12-16 19:41:23', '2012-12-20 18:57:37'),
(56, '444444', 'xzaaaaaaaaaaaaa', NULL, 5, 2, 2, 2, '2012-12-22 16:32:27', '', '2012-12-16 19:46:52', '2012-12-22 16:32:13'),
(57, 'ccccccc', 'ppppppppppp', NULL, 5, 3, 1, 1, '2012-12-20 18:02:53', '', '2012-12-16 19:48:37', '2012-12-20 18:02:53'),
(58, 'pppppppppWWWCC', 'kkkkk????????CCC', NULL, 5, 2, 2, 1, NULL, '', '2012-12-16 19:49:39', '2012-12-20 04:48:31'),
(59, '9---------------', 'ppppppp', NULL, 5, 1, 3, 1, NULL, '', '2012-12-16 19:51:36', '2012-12-20 22:50:53'),
(60, 'TTTTTTTTTTTTTT', 'sefsdfsdfs', '', 3, 1, 1, 2, '2012-12-27 01:11:38', '', '2012-12-16 20:46:59', NULL),
(61, 'trrrrrrrr', 'rrrrrrrrrrrrrrrrrrrr', NULL, 5, 1, 1, 1, NULL, '', '2012-12-16 21:42:14', '2012-12-26 21:45:02'),
(62, 'hhhhhhhhhhh', 'hhhhhhh', 'Source.txt', 5, 1, 1, 2, '2012-12-20 21:46:49', '', '2012-12-16 21:42:36', NULL),
(63, '0', '0', NULL, 5, 3, 2, 1, NULL, '', '2012-12-20 03:36:02', NULL),
(64, 'iiiiiiiiiiii', 'kkkkkkkkkkkk', NULL, 3, 1, 1, 1, NULL, '', '2012-12-27 04:19:11', '2012-12-27 04:19:27'),
(65, 'mmmmmmmmmmm', 'mmmmmmmm', NULL, 3, 1, 1, 2, '2012-12-27 04:20:58', '', '2012-12-27 04:20:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `group_id` int(11) DEFAULT '200',
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `notify_user` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `group_id`, `email`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`, `notify_user`) VALUES
(1, 'fahmi', '123456', 200, 'fahmi.j.a@gmail.com', 1, 0, NULL, 'b53b6d2e33cb6144c57ac50ae5c28383', '2012-11-12 09:50:33', NULL, NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2012-11-12 14:50:09', 1),
(2, 'TheTechGuy', '$P$BnSvoWgWXEv9n2J0C8gwQwQLHx5QyF/', 100, 'lllll.a@gmail.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2012-11-12 10:21:27', -1),
(3, 'fahmisaa', '$P$BmNdZw2iGLZ89QNUWsVEh5HDsyyQVJ1', 200, 'fahmi.j.aaa@gmail.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2012-12-27 04:19:01', '2012-11-12 06:14:08', '2012-12-27 09:18:37', 1),
(4, 'fahmisaax', '$P$B6rWvHKcv6oNAOC4h3Dlt34./mgTRB/', 200, 'fahmxci.j.aaa@gmail.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '0000-00-00 00:00:00', '2012-11-12 06:46:04', '2012-11-12 11:45:40', 1),
(5, 'fjamal', '$P$BGLSUr20QpDopdkAkk3b1vYMMmemna.', 200, 'fjamal@baytey.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2013-01-28 21:09:21', '2012-11-12 06:47:07', '2013-01-28 20:09:21', -1),
(6, 'james', '$P$BP8NGvQS8//BLgfVq0bodgFJnUCmsg.', 200, 'john@mmm.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '0000-00-00 00:00:00', '2012-12-03 17:51:04', '2012-12-03 22:50:40', 1),
(7, 'mike', '$P$BuqJJbJ2MmEGBCEWII1fv8oP5pY1hE/', 200, 'kkkkkk@fffff.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '0000-00-00 00:00:00', '2012-12-16 15:12:31', '2012-12-16 20:12:07', 1),
(8, 'bbbbb', '$P$Bl71yqSQEZ43aEyOicnmzjWqfMcaXG1', 200, 'bbbbb@fffff.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '0000-00-00 00:00:00', '2012-12-16 15:13:31', '2012-12-16 20:13:07', 1),
(9, 'ccccccccc', '$P$BkZX9TGKtiQbRC5.rAfNMK7jJY47FS/', 200, 'wedww@dsfsd.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '0000-00-00 00:00:00', '2012-12-16 18:11:00', '2012-12-16 23:10:36', 1),
(10, 'eeerere', '$P$BQOpYAd3q9e3wH2D00FlQZq44DGoe3.', 200, 'wedwcw@dsfsd.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '0000-00-00 00:00:00', '2012-12-16 18:12:36', '2012-12-16 23:12:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `country`, `website`) VALUES
(1, 3, NULL, NULL),
(2, 4, NULL, NULL),
(3, 5, NULL, NULL),
(4, 6, NULL, NULL),
(5, 7, NULL, NULL),
(6, 8, NULL, NULL),
(7, 9, NULL, NULL),
(8, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_reply`
--
CREATE TABLE IF NOT EXISTS `v_reply` (
`reply_id` int(11)
,`reply_text` text
,`ticket_id` int(11)
,`attachment` char(30)
,`users_id` int(11)
,`username` varchar(50)
,`date_created` datetime
,`date_updated` datetime
,`is_active` char(1)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_ticket`
--
CREATE TABLE IF NOT EXISTS `v_ticket` (
`ticket_id` int(11)
,`users_id` int(11)
,`username` varchar(50)
,`email` varchar(100)
,`activated` tinyint(1)
,`banned` tinyint(1)
,`notify_user` tinyint(1)
,`title` char(100)
,`message` text
,`category_id` int(11)
,`category_name` char(15)
,`priority_id` int(11)
,`priority_name` char(15)
,`status_id` int(11)
,`status_name` char(15)
,`attachment` char(30)
,`date_created` datetime
,`date_updated` datetime
,`date_closed` datetime
,`is_ticket_active` char(1)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_users`
--
CREATE TABLE IF NOT EXISTS `v_users` (
`id` int(11)
,`username` varchar(50)
,`group_id` int(11)
,`group_name` varchar(15)
,`email` varchar(100)
,`notify_user` tinyint(1)
,`banned` tinyint(1)
);
-- --------------------------------------------------------

--
-- Structure for view `v_reply`
--
DROP TABLE IF EXISTS `v_reply`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_reply` AS select `reply`.`reply_id` AS `reply_id`,`reply`.`reply_text` AS `reply_text`,`reply`.`ticket_id` AS `ticket_id`,`reply`.`attachment` AS `attachment`,`users`.`id` AS `users_id`,`users`.`username` AS `username`,`reply`.`date_created` AS `date_created`,`reply`.`date_updated` AS `date_updated`,`reply`.`is_active` AS `is_active` from (`reply` join `users` on((`reply`.`users_id` = `users`.`id`)));

-- --------------------------------------------------------

--
-- Structure for view `v_ticket`
--
DROP TABLE IF EXISTS `v_ticket`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ticket` AS select `ticket`.`ticket_id` AS `ticket_id`,`ticket`.`users_id` AS `users_id`,`users`.`username` AS `username`,`users`.`email` AS `email`,`users`.`activated` AS `activated`,`users`.`banned` AS `banned`,`users`.`notify_user` AS `notify_user`,`ticket`.`title` AS `title`,`ticket`.`message` AS `message`,`ticket`.`category_id` AS `category_id`,`category`.`category_name` AS `category_name`,`ticket`.`priority_id` AS `priority_id`,`priority`.`priority_name` AS `priority_name`,`ticket`.`status_id` AS `status_id`,`status`.`status_name` AS `status_name`,`ticket`.`attachment` AS `attachment`,`ticket`.`date_created` AS `date_created`,`ticket`.`date_updated` AS `date_updated`,`ticket`.`date_closed` AS `date_closed`,`ticket`.`is_active` AS `is_ticket_active` from ((((`ticket` join `category` on((`ticket`.`category_id` = `category`.`category_id`))) join `priority` on((`ticket`.`priority_id` = `priority`.`priority_id`))) join `status` on((`ticket`.`status_id` = `status`.`status_id`))) join `users` on((`ticket`.`users_id` = `users`.`id`)));

-- --------------------------------------------------------

--
-- Structure for view `v_users`
--
DROP TABLE IF EXISTS `v_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_users` AS select `users`.`id` AS `id`,`users`.`username` AS `username`,`users`.`group_id` AS `group_id`,`group`.`group_name` AS `group_name`,`users`.`email` AS `email`,`users`.`notify_user` AS `notify_user`,`users`.`banned` AS `banned` from (`group` join `users` on((`users`.`group_id` = `group`.`group_id`)));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`ticket_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`priority_id`) REFERENCES `priority` (`priority_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
