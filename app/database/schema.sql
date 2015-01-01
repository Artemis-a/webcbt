-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 01, 2015 at 05:14 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webcbt`
--

-- --------------------------------------------------------

--
-- Table structure for table `cbts`
--

CREATE TABLE IF NOT EXISTS `cbts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `situation` varchar(255) NOT NULL,
  `is_resolved` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_behaviours`
--

CREATE TABLE IF NOT EXISTS `cbt_behaviours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cbt_id` int(11) NOT NULL,
  `behaviour` varchar(255) NOT NULL,
  `when` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_feelings`
--

CREATE TABLE IF NOT EXISTS `cbt_feelings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cbt_id` int(11) NOT NULL,
  `feeling_id` int(11) NOT NULL,
  `percent` int(3) NOT NULL,
  `when` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_symptoms`
--

CREATE TABLE IF NOT EXISTS `cbt_symptoms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cbt_id` int(11) NOT NULL,
  `symptom_id` int(11) NOT NULL,
  `percent` int(3) NOT NULL,
  `when` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_thoughts`
--

CREATE TABLE IF NOT EXISTS `cbt_thoughts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cbt_id` int(11) NOT NULL,
  `thought` varchar(255) NOT NULL,
  `is_challenged` int(1) NOT NULL,
  `dispute` varchar(2000) NOT NULL,
  `balanced_thoughts` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_thought_distortions`
--

CREATE TABLE IF NOT EXISTS `cbt_thought_distortions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cbt_thought_id` int(11) NOT NULL,
  `distortion_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `distortions`
--

CREATE TABLE IF NOT EXISTS `distortions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Dumping data for table `distortions`
--

INSERT INTO `distortions` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'All-or-nothing / Black and white thinking', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(2, 'Overgeneralization (always, never, etc)', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(3, 'Mental Filter', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(4, 'Discounting the positive', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(5, 'Catastrophizing', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(6, 'Jumping to conclusions - Mind reading', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(7, 'Jumping to conclusions - Fortune telling', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(8, 'Magnifications', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(9, 'Emotional reasoning', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(10, '"Should", "Must" statements', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(11, 'Labeling', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(12, 'Personalization and blame', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feelings`
--

CREATE TABLE IF NOT EXISTS `feelings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `symptoms`
--

CREATE TABLE IF NOT EXISTS `symptoms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` char(1) NOT NULL,
  `dob` date NOT NULL,
  `dateformat` varchar(255) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `verification_key` varchar(255) NOT NULL,
  `email_verified` int(1) NOT NULL,
  `admin_verified` int(1) NOT NULL,
  `retry_count` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
