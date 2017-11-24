-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2017 at 11:51 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estates_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `acc_id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_no` varchar(20) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `acc_name` varchar(100) NOT NULL,
  PRIMARY KEY (`acc_id`),
  KEY `acc_no` (`acc_no`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`acc_id`, `acc_no`, `bank_name`, `acc_name`) VALUES
(1, '012008855701', 'Stanbic', 'Wabyona Properties Limited'),
(2, '32523020523025', 'Centenary', 'Wabyona Properties Limited'),
(3, '0600047552', 'Housing Finance', 'Wabyona Properties Limited');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

DROP TABLE IF EXISTS `bill`;
CREATE TABLE IF NOT EXISTS `bill` (
  `bill_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenancy_id` int(10) UNSIGNED NOT NULL,
  `tenant_id` int(11) NOT NULL COMMENT 'FK, reference to tenant',
  `house_no` varchar(20) NOT NULL,
  `bill_date` datetime NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`bill_id`),
  KEY `tenancy_id` (`tenancy_id`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
CREATE TABLE IF NOT EXISTS `district` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `district` varchar(50) NOT NULL,
  PRIMARY KEY (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`district_id`, `district`) VALUES
(1, 'Other'),
(2, 'Abim '),
(3, 'Adjumani '),
(4, 'Agago '),
(5, 'Alebtong '),
(6, 'Amolatar '),
(7, 'Amudat '),
(8, 'Amuria '),
(9, 'Amuru '),
(10, 'Apac '),
(11, 'Arua '),
(12, 'Budaka '),
(13, 'Bududa '),
(14, 'Bugiri '),
(15, 'Buhweju '),
(16, 'Buikwe '),
(17, 'Bukedea '),
(18, 'Bukomansimbi'),
(19, 'Bukwo '),
(20, 'Bulambuli '),
(21, 'Buliisa '),
(22, 'Bundibugyo '),
(23, 'Bushenyi '),
(24, 'Busia '),
(25, 'Butaleja '),
(26, 'Butambala '),
(27, 'Buvuma '),
(28, 'Buyende '),
(29, 'Dokolo '),
(30, 'Gomba '),
(31, 'Gulu '),
(32, 'Hoima '),
(33, 'Ibanda '),
(34, 'Iganga '),
(35, 'Isingiro '),
(36, 'Jinja '),
(37, 'Kaabong '),
(38, 'Kabale '),
(39, 'Kabarole '),
(40, 'Kaberamaido '),
(41, 'Kalangala '),
(42, 'Kaliro '),
(43, 'Kalungu '),
(44, 'Kampala '),
(45, 'Kamuli '),
(46, 'Kamwenge '),
(47, 'Kanungu '),
(48, 'Kapchorwa '),
(49, 'Kasese '),
(50, 'Katakwi '),
(51, 'Kayunga '),
(52, 'Kibaale '),
(53, 'Kiboga '),
(54, 'Kibuku '),
(55, 'Kiruhura '),
(56, 'Kiryandongo '),
(57, 'Kisoro '),
(58, 'Kitgum '),
(59, 'Koboko '),
(60, 'Kole '),
(61, 'Kotido '),
(62, 'Kumi '),
(63, 'Kween '),
(64, 'Kyankwanzi'),
(65, 'Kyegegwa '),
(66, 'Kyenjojo '),
(67, 'Lamwo '),
(68, 'Lira '),
(69, 'Luuka '),
(70, 'Luweero '),
(71, 'Lwengo '),
(72, 'Lyantonde'),
(73, 'Manafwa '),
(74, 'Maracha '),
(75, 'Masaka'),
(76, 'Masindi '),
(77, 'Mayuge '),
(78, 'Mbale '),
(79, 'Mbarara '),
(80, 'Mitooma '),
(81, 'Mityana '),
(82, 'Moroto '),
(83, 'Moyo '),
(84, 'Mpigi '),
(85, 'Mubende '),
(86, 'Mukono '),
(87, 'Nakapiripirit '),
(88, 'Nakaseke '),
(89, 'Nakasongola '),
(90, 'Namayingo '),
(91, 'Namutumba '),
(92, 'Napak '),
(93, 'Nebbi '),
(94, 'Ngora '),
(95, 'Ntoroko '),
(96, 'Ntungamo '),
(97, 'Nwoya '),
(98, 'Otuke '),
(99, 'Oyam '),
(100, 'Pader '),
(101, 'Pallisa '),
(102, 'Rakai'),
(103, 'Rubirizi '),
(104, 'Rukungiri'),
(105, 'Serere '),
(106, 'Sheema '),
(107, 'Sironko '),
(108, 'Soroti '),
(109, 'Ssembabule '),
(110, 'Tororo '),
(111, 'Wakiso '),
(112, 'Yumbe '),
(113, 'Zombo ');

-- --------------------------------------------------------

--
-- Table structure for table `estate`
--

DROP TABLE IF EXISTS `estate`;
CREATE TABLE IF NOT EXISTS `estate` (
  `estate_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `estate_name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `phone2` varchar(10) DEFAULT NULL,
  `district_id` int(11) NOT NULL,
  PRIMARY KEY (`estate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estate`
--

INSERT INTO `estate` (`estate_id`, `estate_name`, `description`, `address`, `phone`, `phone2`, `district_id`) VALUES
(1, 'Wabyona plaza', 'Bweyogerere Estate', 'Plot 1601 Block 234,\r\nP O Box, 71187, Bweyogerere', '0782369372', '', 44),
(2, 'Kigandanzi Plaza', 'Bweyogerere, Wakiso', 'Bweyogerere, Wakiso', '0782369372', '0752369372', 111);

-- --------------------------------------------------------

--
-- Table structure for table `house`
--

DROP TABLE IF EXISTS `house`;
CREATE TABLE IF NOT EXISTS `house` (
  `house_id` int(11) NOT NULL AUTO_INCREMENT,
  `house_no` varchar(20) NOT NULL,
  `floor` tinyint(2) NOT NULL,
  `estate_id` tinyint(3) UNSIGNED NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `fixed_amount` decimal(10,0) UNSIGNED NOT NULL,
  PRIMARY KEY (`house_id`),
  KEY `estate_id` (`estate_id`),
  KEY `house_no` (`house_no`),
  KEY `floor` (`floor`),
  KEY `estate_id_2` (`estate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `house`
--

INSERT INTO `house` (`house_id`, `house_no`, `floor`, `estate_id`, `description`, `fixed_amount`) VALUES
(1, 'WP1', 0, 1, 'room next to the wash rooms', '2000000'),
(2, 'WP2', 0, 1, 'Found on ground floor', '1500000'),
(3, 'WP3', 0, 1, '', '1500000'),
(4, 'WP4', 0, 1, '', '800000'),
(5, 'WP5', 0, 1, '', '500000'),
(6, 'WP6', 0, 1, '', '300000'),
(7, 'WP7', 0, 1, '', '500000'),
(8, 'WP8', 0, 1, '', '400000'),
(9, 'M4i3', 1, 2, 'Room next to the wash rooms', '250000');

--
-- Triggers `house`
--
DROP TRIGGER IF EXISTS `update_tenancy_rate`;
DELIMITER $$
CREATE TRIGGER `update_tenancy_rate` AFTER UPDATE ON `house` FOR EACH ROW IF NEW.fixed_amount <> OLD.fixed_amount THEN  
UPDATE tenancy SET rent_rate = NEW.fixed_amount WHERE tenancy.house_id = house.house_id;
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `tenancy_id` int(11) NOT NULL COMMENT 'Reference to the tenancy of the client',
  `payment_date` int(10) UNSIGNED NOT NULL COMMENT 'Unix timestamp when payment was received',
  `account_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'ID of the  Bank account through which payment was made',
  `particulars` varchar(200) NOT NULL COMMENT 'Details of payment',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `rent_rate` decimal(12,2) NOT NULL,
  `amount` decimal(12,2) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL COMMENT 'Staff entering payment',
  `date_created` int(11) NOT NULL COMMENT 'Date this entry was entered into the database',
  `modified_by` int(11) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`),
  KEY `fk_modified_by` (`modified_by`),
  KEY `tenancy_id` (`tenancy_id`) USING BTREE,
  KEY `fk_created_by` (`created_by`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `tenancy_id`, `payment_date`, `account_id`, `particulars`, `start_date`, `end_date`, `rent_rate`, `amount`, `created_by`, `date_created`, `modified_by`, `date_modified`) VALUES
(2, 4, 1457999999, NULL, 'Accommodation for April - June', '2016-03-02', '2016-04-02', '650000.00', '650000.00', 1, 0, 2, '2017-11-23 22:59:36'),
(3, 5, 1458863999, NULL, 'Rent payment for March to June 2016', '0000-00-00', '0000-00-00', '0.00', '650000.00', 1, 0, 0, '2017-11-22 06:01:30'),
(4, 1, 1458863999, 2, 'Rent for March to April 2015', '0000-00-00', '0000-00-00', '0.00', '1200000.00', 1, 0, 0, '2017-11-22 06:01:30'),
(6, 3, 1513814399, 2, 'Rent payment for June 2018 to January 2018', '0000-00-00', '0000-00-00', '0.00', '300000.00', 1, 0, 0, '2017-11-22 06:01:30'),
(7, 4, 1511481599, NULL, 'The client has paid up all the accumulated balances as well as the forward balances', '2016-03-02', '2017-11-02', '650000.00', '13000000.00', 2, 1511472379, 2, '2017-11-23 21:26:19');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `role_code` tinyint(3) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL,
  PRIMARY KEY (`role_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_code`, `role_name`) VALUES
(1, 'Staff'),
(2, 'Supervisor'),
(3, 'Boss'),
(4, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tenancy`
--

DROP TABLE IF EXISTS `tenancy`;
CREATE TABLE IF NOT EXISTS `tenancy` (
  `tenancy_id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) NOT NULL,
  `house_id` int(5) NOT NULL,
  `start_date` int(12) UNSIGNED NOT NULL,
  `end_date` int(12) UNSIGNED DEFAULT NULL,
  `rent_rate` decimal(12,2) UNSIGNED NOT NULL,
  `assigned_by` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`tenancy_id`),
  KEY `tenant_id` (`tenant_id`,`house_id`),
  KEY `house_id` (`house_id`),
  KEY `tenant_id_2` (`tenant_id`),
  KEY `end_date` (`end_date`),
  KEY `start_date` (`start_date`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenancy`
--

INSERT INTO `tenancy` (`tenancy_id`, `tenant_id`, `house_id`, `start_date`, `end_date`, `rent_rate`, `assigned_by`) VALUES
(1, 3, 4, 1457799999, 0, '800000.00', 1),
(2, 1, 3, 1457599999, 0, '1500000.00', 1),
(3, 4, 1, 1457740799, 0, '1500000.00', 2),
(4, 5, 4, 1456876799, 1467417599, '650000.00', 1),
(5, 6, 4, 1472947199, 1480550399, '800000.00', 1),
(6, 3, 8, 1510790399, 1517011199, '400000.00', 1),
(7, 7, 9, 1510790399, 0, '350000.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

DROP TABLE IF EXISTS `tenant`;
CREATE TABLE IF NOT EXISTS `tenant` (
  `tenant_id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(50) NOT NULL,
  `photo_url` varchar(100) DEFAULT NULL COMMENT 'location of tenant photo',
  `phone1` varchar(10) NOT NULL,
  `phone2` varchar(10) NOT NULL,
  `home_address` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT 'Status of the tenant, active=1 or inactive = 0',
  `district_id` int(11) NOT NULL COMMENT 'Home district id',
  `created_by` int(11) NOT NULL COMMENT 'Reference to staff who entered this record',
  `date_created` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL COMMENT 'Staff who modified this record',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tenant_id`),
  KEY `district_id` (`district_id`),
  KEY `fk_staff_id` (`created_by`),
  KEY `fk_modified_by` (`modified_by`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`tenant_id`, `names`, `photo_url`, `phone1`, `phone2`, `home_address`, `status`, `district_id`, `created_by`, `date_created`, `modified_by`, `date_modified`) VALUES
(1, 'Mukiibi Arthur', NULL, '0793287383', '0776812341', 'Brooks corner,\r\nRakai town', 1, 102, 0, 0, 0, '2017-11-23 22:04:56'),
(2, 'James Batte', NULL, '0782299893', '', 'Kiswa, Bugolobi', 1, 18, 0, 0, 0, '2017-11-23 22:04:56'),
(3, 'Gitau Anthony', NULL, '0713459802', '0773716980', 'Bungoma, Kenya', 1, 1, 0, 0, 0, '2017-11-23 22:04:56'),
(4, 'NWSC', NULL, '0414562318', '', 'Jinja Road', 1, 44, 0, 0, 0, '2017-11-23 22:04:56'),
(5, 'Bank of Baroda', NULL, '0414879302', '', 'Jinja Road, Kampala', 1, 44, 0, 0, 0, '2017-11-23 22:04:56'),
(6, 'Joshua Odongo', NULL, '0777879301', '', 'Kawempe', 1, 5, 0, 0, 2, '2017-11-24 11:14:47'),
(7, 'Odeke Allan', NULL, '0778393803', '', 'Mukono Municipality', 1, 81, 0, 0, 0, '2017-11-23 22:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(30) NOT NULL COMMENT 'Last name',
  `lname` varchar(30) NOT NULL COMMENT 'First name',
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_code` tinyint(3) NOT NULL,
  `reg_date` int(11) NOT NULL COMMENT 'Registration day timestamp',
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `fname`, `lname`, `email`, `phone`, `username`, `password`, `role_code`, `reg_date`) VALUES
(1, 'Allan', 'Odeke', NULL, '', 'ajoluvya', '4d22cd83d39ff90b5417572cc4fd417d', 2, 1456429250),
(2, 'Admin', 'Atiku', NULL, '', 'admin', '4d22cd83d39ff90b5417572cc4fd417d', 4, 1457155910);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
