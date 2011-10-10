-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2011 at 11:38 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ninja_pmacct`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `acct_v7_combined`
--
CREATE TABLE IF NOT EXISTS `acct_v7_combined` (
`ip` char(15)
,`date` datetime
,`bytes_out` bigint(20) unsigned
,`bytes_in` bigint(20) unsigned
);
-- --------------------------------------------------------

--
-- Table structure for table `acct_v7_in`
--

CREATE TABLE IF NOT EXISTS `acct_v7_in` (
  `agent_id` int(4) unsigned NOT NULL,
  `class_id` char(16) NOT NULL,
  `mac_src` char(17) NOT NULL,
  `mac_dst` char(17) NOT NULL,
  `vlan` int(2) unsigned NOT NULL,
  `as_src` int(4) unsigned NOT NULL,
  `as_dst` int(4) unsigned NOT NULL,
  `ip_src` char(15) NOT NULL,
  `ip_dst` char(15) NOT NULL,
  `src_port` int(2) unsigned NOT NULL,
  `dst_port` int(2) unsigned NOT NULL,
  `tcp_flags` int(4) unsigned NOT NULL,
  `ip_proto` char(6) NOT NULL,
  `tos` int(4) unsigned NOT NULL,
  `packets` int(10) unsigned NOT NULL,
  `bytes` bigint(20) unsigned NOT NULL,
  `flows` int(10) unsigned NOT NULL,
  `stamp_inserted` datetime NOT NULL,
  `stamp_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`agent_id`,`class_id`,`mac_src`,`mac_dst`,`vlan`,`as_src`,`as_dst`,`ip_src`,`ip_dst`,`src_port`,`dst_port`,`ip_proto`,`tos`,`stamp_inserted`),
  KEY `stamp_inserted` (`stamp_inserted`),
  KEY `stamp_updated` (`stamp_updated`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acct_v7_out`
--

CREATE TABLE IF NOT EXISTS `acct_v7_out` (
  `agent_id` int(4) unsigned NOT NULL,
  `class_id` char(16) NOT NULL,
  `mac_src` char(17) NOT NULL,
  `mac_dst` char(17) NOT NULL,
  `vlan` int(2) unsigned NOT NULL,
  `as_src` int(4) unsigned NOT NULL,
  `as_dst` int(4) unsigned NOT NULL,
  `ip_src` char(15) NOT NULL,
  `ip_dst` char(15) NOT NULL,
  `src_port` int(2) unsigned NOT NULL,
  `dst_port` int(2) unsigned NOT NULL,
  `tcp_flags` int(4) unsigned NOT NULL,
  `ip_proto` char(6) NOT NULL,
  `tos` int(4) unsigned NOT NULL,
  `packets` int(10) unsigned NOT NULL,
  `bytes` bigint(20) unsigned NOT NULL,
  `flows` int(10) unsigned NOT NULL,
  `stamp_inserted` datetime NOT NULL,
  `stamp_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`agent_id`,`class_id`,`mac_src`,`mac_dst`,`vlan`,`as_src`,`as_dst`,`ip_src`,`ip_dst`,`src_port`,`dst_port`,`ip_proto`,`tos`,`stamp_inserted`),
  KEY `stamp_inserted` (`stamp_inserted`),
  KEY `stamp_updated` (`stamp_updated`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `acct_v7_combined`
--
DROP TABLE IF EXISTS `acct_v7_combined`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `acct_v7_combined` AS select `acct_out`.`ip_src` AS `ip`,`acct_out`.`stamp_inserted` AS `date`,`acct_out`.`bytes` AS `bytes_out`,`acct_in`.`bytes` AS `bytes_in` from (`acct_v7_out` `acct_out` join `acct_v7_in` `acct_in` on(((`acct_out`.`ip_src` = `acct_in`.`ip_dst`) and (`acct_out`.`stamp_inserted` = `acct_in`.`stamp_inserted`))));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
