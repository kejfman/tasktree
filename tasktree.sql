-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 19, 2022 at 05:47 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tasktree`
--

-- --------------------------------------------------------

--
-- Table structure for table `pt_dictionary`
--

DROP TABLE IF EXISTS `pt_dictionary`;
CREATE TABLE IF NOT EXISTS `pt_dictionary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `destination` varchar(50) NOT NULL,
  `value` varchar(125) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin2;

--
-- Dumping data for table `pt_dictionary`
--

-- --------------------------------------------------------

--
-- Table structure for table `pt_tasks`
--

DROP TABLE IF EXISTS `pt_tasks`;
CREATE TABLE IF NOT EXISTS `pt_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TaskTree` varchar(50) NOT NULL,
  `TaskNumber` varchar(128) NOT NULL,
  `TaskOwner` varchar(50) NOT NULL,
  `TaskType` varchar(128) NOT NULL,
  `MyTask` int(1) NOT NULL DEFAULT '0',
  `CreateDateTime` datetime DEFAULT NULL,
  `Done` int(11) NOT NULL DEFAULT '0',
  `DoneDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=286 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pt_tasks`
--

-- --------------------------------------------------------

--
-- Table structure for table `pt_tasks_block`
--

DROP TABLE IF EXISTS `pt_tasks_block`;
CREATE TABLE IF NOT EXISTS `pt_tasks_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TaskTree` varchar(126) NOT NULL,
  `TaskBlockTaskNumber` varchar(50) NOT NULL,
  `TaskBlockByNumber` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=156 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pt_tasks_block`
--


-- --------------------------------------------------------

--
-- Table structure for table `pt_trees`
--

DROP TABLE IF EXISTS `pt_trees`;
CREATE TABLE IF NOT EXISTS `pt_trees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TreeName` varchar(125) NOT NULL,
  `TreeEnv` varchar(50) DEFAULT NULL,
  `CreateDateTime` datetime DEFAULT NULL,
  `Done` int(11) NOT NULL DEFAULT '0',
  `DoneDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin2;

--
-- Dumping data for table `pt_trees`
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
