-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2017 at 04:09 AM
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

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `getDateDiff`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getDateDiff` (`timeInterval` INT, `startDate` DATETIME, `endDate` DATETIME) RETURNS INT(11) NO SQL
BEGIN
	DECLARE date_diff INT(11);
	CASE timeInterval
			WHEN 1 THEN SET date_diff=TIMESTAMPDIFF(HOUR, startDate, endDate);
			WHEN 2 THEN SET date_diff=TIMESTAMPDIFF(DAY, startDate, endDate);
			WHEN 3 THEN SET date_diff = TIMESTAMPDIFF(WEEK, startDate, endDate);
			WHEN 4 THEN SET date_diff = TIMESTAMPDIFF(MONTH, startDate, endDate);
	END CASE;
   RETURN date_diff;
END$$

DELIMITER ;

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
  `time_interval_id` tinyint(2) NOT NULL,
  `billing_freq` tinyint(2) NOT NULL COMMENT 'How often the billing occurs (dependant on the time period)',
  `period_starts` tinyint(1) DEFAULT NULL COMMENT 'Whether the billing time should be at the start of the period or on admission date',
  `full_payment` tinyint(1) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`estate_id`),
  KEY `modified_by` (`modified_by`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estate`
--

INSERT INTO `estate` (`estate_id`, `estate_name`, `description`, `address`, `phone`, `phone2`, `district_id`, `time_interval_id`, `billing_freq`, `period_starts`, `full_payment`, `created_by`, `date_created`, `modified_by`, `date_modified`) VALUES
(1, 'Wabyona plaza', 'Bweyogerere Estate', 'Plot 1601 Block 234,\r\nP O Box, 71187, Bweyogerere', '0782369372', '', 44, 4, 1, 2, NULL, 0, 0, 2, '2017-12-14 01:09:17'),
(2, 'Kigandanzi Plaza', 'Bweyogerere, Wakiso', 'Bweyogerere, Wakiso', '0782369372', '0752369372', 111, 4, 1, 2, NULL, 0, 0, 2, '2017-12-13 10:48:23'),
(3, 'Musa Kasule Estates', 'Self Contained apartments and luxurious suites', 'Biina, Mutungo Kampala', '0772566734', '', 44, 4, 2, 1, 1, 2, 1513074947, 2, '2017-12-12 10:39:39');

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
  `max_tenants` tinyint(2) NOT NULL DEFAULT '1',
  `fixed_amount` decimal(10,0) UNSIGNED NOT NULL,
  `time_interval_id` int(2) NOT NULL,
  `billing_freq` tinyint(2) NOT NULL COMMENT 'How often the above should be billed',
  `period_starts` tinyint(2) NOT NULL COMMENT 'Which exactly the billing should happen',
  `full_payment` tinyint(1) DEFAULT NULL COMMENT 'Whether full amount should be paid each and everytime',
  `created_by` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`house_id`),
  KEY `estate_id` (`estate_id`),
  KEY `house_no` (`house_no`),
  KEY `floor` (`floor`),
  KEY `estate_id_2` (`estate_id`),
  KEY `created_by` (`created_by`),
  KEY `modified_by` (`modified_by`),
  KEY `time_interval_id` (`time_interval_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `house`
--

INSERT INTO `house` (`house_id`, `house_no`, `floor`, `estate_id`, `description`, `max_tenants`, `fixed_amount`, `time_interval_id`, `billing_freq`, `period_starts`, `full_payment`, `created_by`, `date_created`, `modified_by`, `date_modified`) VALUES
(1, 'WP1', 0, 1, 'room next to the wash rooms', 1, '2000000', 4, 1, 2, NULL, 0, 0, 2, '2017-12-15 11:00:53'),
(2, 'WP2', 0, 1, 'Found on ground floor', 1, '1500000', 4, 1, 2, NULL, 0, 0, 2, '2017-12-15 11:00:29'),
(3, 'WP3', 0, 1, 'Useful for guests from the West', 1, '1500000', 4, 1, 2, NULL, 0, 0, 2, '2017-12-15 11:00:10'),
(4, 'WP4', 0, 1, 'Nill', 1, '800000', 4, 1, 1, NULL, 0, 0, 2, '2017-12-15 15:42:13'),
(5, 'WP5', 0, 1, 'Not specified', 1, '500000', 4, 1, 2, NULL, 0, 0, 2, '2017-12-15 10:58:32'),
(6, 'WP6', 0, 1, 'NA', 2, '300000', 4, 1, 2, NULL, 0, 0, 2, '2017-12-15 10:57:44'),
(7, 'WP7', 0, 1, 'The room reserved for Guests of Higher Value', 1, '500000', 4, 1, 2, NULL, 0, 0, 2, '2017-12-15 10:57:15'),
(8, 'WP8', 0, 1, 'The room right behind the kitchen area', 1, '400000', 4, 1, 2, NULL, 0, 0, 2, '2017-12-15 14:31:14'),
(9, 'M4i3', 0, 2, 'Room next to the wash rooms', 1, '250000', 4, 1, 2, NULL, 0, 0, 2, '2017-12-14 15:03:32'),
(10, 'M4i6', 0, 2, '', 1, '300000', 4, 1, 2, NULL, 2, 1513262401, 2, '2017-12-14 14:40:01');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `tenancy_id`, `payment_date`, `account_id`, `particulars`, `start_date`, `end_date`, `rent_rate`, `amount`, `created_by`, `date_created`, `modified_by`, `date_modified`) VALUES
(2, 4, 1457999999, NULL, 'Accommodation for April - June', '2016-03-02', '2016-04-02', '650000.00', '650000.00', 1, 0, 2, '2017-11-23 22:59:36'),
(4, 1, 1458863999, 2, 'Rent for March to April 2015', '0000-00-00', '0000-00-00', '0.00', '1200000.00', 1, 0, 0, '2017-11-22 06:01:30'),
(6, 3, 1513814399, 2, 'Rent payment for June 2018 to January 2018', '0000-00-00', '0000-00-00', '0.00', '300000.00', 1, 0, 0, '2017-11-22 06:01:30'),
(7, 4, 1511481599, NULL, 'The client has paid up all the accumulated balances as well as the forward balances', '2016-03-02', '2017-11-02', '650000.00', '13000000.00', 2, 1511472379, 2, '2017-11-23 21:26:19'),
(8, 7, 1511567999, NULL, 'Thanks, well received', '2017-11-16', '2018-02-16', '350000.00', '1050000.00', 2, 1511524817, 2, '2017-11-24 12:00:17'),
(9, 9, 1512777599, NULL, 'He has paid for this month', '2017-12-01', '2018-01-01', '1500000.00', '1500000.00', 2, 1512718422, 2, '2017-12-08 07:33:42'),
(10, 4, 1512777599, NULL, 'htrtdfg', '2016-07-02', '2016-11-02', '650000.00', '2600000.00', 6, 1512746825, 6, '2017-12-08 15:27:05'),
(11, 4, 1512777599, NULL, 'Fully cleared all the balances', '2016-11-02', '2017-12-02', '650000.00', '8450000.00', 6, 1512747250, 6, '2017-12-08 15:34:10');

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
-- Table structure for table `tbl_time_interval`
--

DROP TABLE IF EXISTS `tbl_time_interval`;
CREATE TABLE IF NOT EXISTS `tbl_time_interval` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `label` varchar(1) NOT NULL,
  `description` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='The values in this table must rhyme with what is expected in the PHP date format';

--
-- Dumping data for table `tbl_time_interval`
--

INSERT INTO `tbl_time_interval` (`id`, `label`, `description`) VALUES
(1, 'h', 'Hours'),
(2, 'd', 'Days'),
(3, 'W', 'Weeks'),
(4, 'm', 'Months');

-- --------------------------------------------------------

--
-- Table structure for table `tenancy`
--

DROP TABLE IF EXISTS `tenancy`;
CREATE TABLE IF NOT EXISTS `tenancy` (
  `tenancy_id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) NOT NULL,
  `house_id` int(5) NOT NULL,
  `rent_rate` decimal(12,2) UNSIGNED NOT NULL,
  `time_interval_id` tinyint(2) NOT NULL DEFAULT '4' COMMENT 'The time interval for this tenancy',
  `billing_freq` tinyint(2) NOT NULL DEFAULT '1',
  `full_payment` tinyint(1) DEFAULT NULL,
  `billing_starts` tinyint(1) DEFAULT NULL,
  `start_date` int(12) UNSIGNED NOT NULL,
  `end_date` int(12) UNSIGNED DEFAULT NULL,
  `date_created` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`tenancy_id`),
  KEY `tenant_id` (`tenant_id`,`house_id`),
  KEY `house_id` (`house_id`),
  KEY `tenant_id_2` (`tenant_id`),
  KEY `end_date` (`end_date`),
  KEY `start_date` (`start_date`),
  KEY `time_interval_id` (`time_interval_id`),
  KEY `modified_by` (`modified_by`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenancy`
--

INSERT INTO `tenancy` (`tenancy_id`, `tenant_id`, `house_id`, `rent_rate`, `time_interval_id`, `billing_freq`, `full_payment`, `billing_starts`, `start_date`, `end_date`, `date_created`, `created_by`, `date_modified`, `modified_by`) VALUES
(4, 5, 4, '650000.00', 4, 1, NULL, NULL, 1456876799, 1512259199, 0, 0, '2017-12-08 15:34:10', 0),
(5, 6, 4, '800000.00', 4, 1, NULL, NULL, 1472947199, 1480550399, 0, 0, '2017-11-29 18:05:43', 0),
(6, 3, 8, '400000.00', 4, 1, NULL, NULL, 1510790399, 1517011199, 0, 0, '2017-11-29 18:05:43', 0),
(7, 7, 9, '250000.00', 4, 1, NULL, NULL, 1510790399, 1518728400, 0, 0, '2017-12-08 09:01:06', 0),
(8, 2, 1, '2000000.00', 4, 1, NULL, NULL, 1511740799, 1511740799, 0, 0, '2017-11-29 18:05:43', 0),
(9, 5, 2, '1500000.00', 4, 1, NULL, NULL, 1512086399, 1514840399, 0, 0, '2017-12-08 08:22:56', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

DROP TABLE IF EXISTS `tenant`;
CREATE TABLE IF NOT EXISTS `tenant` (
  `tenant_id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(50) NOT NULL,
  `passport_photo` varchar(100) DEFAULT NULL COMMENT 'location of tenant photo',
  `id_card_no` varchar(20) DEFAULT NULL,
  `id_card_url` varchar(50) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`tenant_id`, `names`, `passport_photo`, `id_card_no`, `id_card_url`, `phone1`, `phone2`, `home_address`, `status`, `district_id`, `created_by`, `date_created`, `modified_by`, `date_modified`) VALUES
(1, 'Mukiibi Arthur', NULL, NULL, NULL, '0793287383', '0776812341', 'Brooks corner,\r\nRakai town', 1, 102, 0, 0, 0, '2017-11-23 22:04:56'),
(2, 'James Batte', NULL, NULL, NULL, '0782299893', '', 'Kiswa, Bugolobi', 1, 18, 0, 0, 0, '2017-11-23 22:04:56'),
(3, 'Gitau Anthony', NULL, NULL, NULL, '0713459802', '0773716980', 'Bungoma, Kenya', 1, 1, 0, 0, 0, '2017-11-23 22:04:56'),
(4, 'NWSC', NULL, NULL, NULL, '0414562318', '', 'Jinja Road', 1, 44, 0, 0, 0, '2017-11-23 22:04:56'),
(5, 'Bank of Baroda', NULL, NULL, NULL, '0414879302', '', 'Jinja Road, Kampala', 1, 44, 0, 0, 0, '2017-11-23 22:04:56'),
(6, 'Joshua Odongo', NULL, NULL, NULL, '0777879301', '', 'Kawempe', 1, 5, 0, 0, 2, '2017-11-24 11:14:47'),
(7, 'Odeke Allan', NULL, NULL, NULL, '0778393803', '0756084422', 'Mukono Municipality', 1, 81, 0, 0, 2, '2017-11-28 08:27:15'),
(8, 'Andrew Ojok', '39afcd134e2ebe4c4c95c05a95fe470f.jpg', 'CNUE3903KD8', 'e8a294bd3a355a1f3b983969acf5528a.jpg', '0774837928', '', 'Plot 35, Bombo Road, Kawempe', 1, 44, 2, 1511868211, 2, '2017-11-28 12:39:37');

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
