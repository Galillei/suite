-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 10, 2013 at 05:57 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.11-1~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `bazilio_rodger_gmail_comTable`
--

CREATE TABLE IF NOT EXISTS `bazilio_rodger_gmail_comTable` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `nameOfFileOld` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `path` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL,
  `nameOfFileNew` varchar(255) COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `file_id` (`file_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `bazilio_rodgr_gmail_comTable`
--

CREATE TABLE IF NOT EXISTS `bazilio_rodgr_gmail_comTable` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `nameOfFileOld` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `path` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL,
  `nameOfFileNew` varchar(255) COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `file_id` (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bazilio_rodg_gmail_comTable`
--

CREATE TABLE IF NOT EXISTS `bazilio_rodg_gmail_comTable` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `nameOfFileOld` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `path` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL,
  `nameOfFileNew` varchar(255) COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `file_id` (`file_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `pathDir` varchar(255) DEFAULT NULL,
  `nameOfUserTable` varchar(255) NOT NULL,
  KEY `user_id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_files`
--

CREATE TABLE IF NOT EXISTS `user_files` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `nameOfFileOld` varchar(255) COLLATE utf8_bin NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `path` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL,
  `nameOfFileNew` varchar(255) COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `file_id` (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
