-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2017 at 11:47 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rent_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `apartment`
--

DROP TABLE IF EXISTS `apartment`;
CREATE TABLE IF NOT EXISTS `apartment` (
  `apartment_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'PK, unique identifier for the apartment',
  `apartment_no` varchar(20) NOT NULL COMMENT 'Apartment number',
  `description` varchar(100) NOT NULL COMMENT 'Description for this apartment',
  `rent_rate` decimal(12,2) NOT NULL COMMENT 'monthly rate of rent for this apartment',
  `max_occupants` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'Maximum number of occupants in this room',
  `fk_estate_id` int(11) NOT NULL COMMENT 'FK, reference to the ',
  PRIMARY KEY (`apartment_id`),
  KEY `fk_estate_id` (`fk_estate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table holds records of apartments in an estate';

-- --------------------------------------------------------

--
-- Table structure for table `estate`
--

DROP TABLE IF EXISTS `estate`;
CREATE TABLE IF NOT EXISTS `estate` (
  `estate_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK, identifier number for the estate',
  `estate_name` varchar(50) NOT NULL COMMENT 'Name of the estate',
  `description` varchar(100) NOT NULL COMMENT 'Description of this estate',
  `address` varchar(50) NOT NULL COMMENT 'Actual address where the estate is located',
  `lc1_village` varchar(30) NOT NULL COMMENT 'LC1 Village',
  `parish` varchar(30) DEFAULT NULL COMMENT 'Parish',
  `subcounty` varchar(30) DEFAULT NULL COMMENT 'Sub county',
  `county` varchar(30) DEFAULT NULL COMMENT 'County',
  `district_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'FK, reference to the district',
  `fk_category_id` tinyint(2) UNSIGNED NOT NULL COMMENT 'FK, reference to the category of estate',
  PRIMARY KEY (`estate_id`),
  KEY `district_id` (`district_id`,`fk_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table holds estates available in the system';

-- --------------------------------------------------------

--
-- Table structure for table `estate_category`
--

DROP TABLE IF EXISTS `estate_category`;
CREATE TABLE IF NOT EXISTS `estate_category` (
  `category_id` int(11) NOT NULL COMMENT 'PK, identifier key for the caegory',
  `category` varchar(30) NOT NULL COMMENT 'Name for this category',
  `description` varchar(100) NOT NULL COMMENT 'Descriptive text for this'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Categories to which estates may belong';

-- --------------------------------------------------------

--
-- Table structure for table `estate_staff`
--

DROP TABLE IF EXISTS `estate_staff`;
CREATE TABLE IF NOT EXISTS `estate_staff` (
  `estate_staff_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK, identifier key for an entry',
  `fk_staff_id` int(11) NOT NULL COMMENT 'Fk, reference No to the staff',
  `fk_estate_id` int(11) NOT NULL COMMENT 'FK, reference No to the estate',
  `start_timestamp` int(15) NOT NULL COMMENT 'Start time of appointment',
  `end_timestamp` int(15) DEFAULT NULL COMMENT 'End time of appointment',
  PRIMARY KEY (`estate_staff_id`),
  KEY `fk_staff_id` (`fk_staff_id`,`fk_estate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Staff appointment to work in an estate';

-- --------------------------------------------------------

--
-- Table structure for table `landlord`
--

DROP TABLE IF EXISTS `landlord`;
CREATE TABLE IF NOT EXISTS `landlord` (
  `landlord_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifier key for the landlord',
  `llord_names` varchar(100) NOT NULL COMMENT 'Names of the landlord',
  `llord_phone1` varchar(15) NOT NULL COMMENT 'Phone number1 of the landlord',
  `llord_phone2` varchar(15) DEFAULT NULL COMMENT 'Phone number2 of the landlord',
  `llord_email1` varchar(50) NOT NULL COMMENT 'Email1 of the landlord',
  `llord_email2` varchar(50) DEFAULT NULL COMMENT 'Email2 of the landlord',
  `llord_username` varchar(30) NOT NULL COMMENT 'Login username',
  `llord_password` varchar(100) NOT NULL COMMENT 'Login password',
  `time_added` int(20) NOT NULL COMMENT 'Timestamp the landlord was added',
  `fk_admin_id` tinyint(2) NOT NULL COMMENT 'Admin that added the added',
  PRIMARY KEY (`landlord_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Hold records of all landlords singned_up for the service';

-- --------------------------------------------------------

--
-- Table structure for table `lease`
--

DROP TABLE IF EXISTS `lease`;
CREATE TABLE IF NOT EXISTS `lease` (
  `lease_id` tinyint(4) NOT NULL COMMENT 'PK, unique identifier for this lease',
  `fk_apartment_id` int(11) UNSIGNED NOT NULL COMMENT 'FK, reference to the apartment number',
  `tenant_id` int(11) NOT NULL COMMENT 'Fk, reference number to the tenant',
  `start_time` int(20) NOT NULL COMMENT 'Start time for the lease',
  `end_time` int(20) NOT NULL COMMENT 'End time for the lease',
  `total_amount` decimal(12,2) NOT NULL COMMENT 'Total amount charged for this lease',
  `fk_staff_id` int(11) UNSIGNED NOT NULL COMMENT 'Fk, reference to the staff who made this entry',
  PRIMARY KEY (`lease_id`),
  KEY `fk_apartment_id` (`fk_apartment_id`,`tenant_id`,`fk_staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Lease records for all tenants';

-- --------------------------------------------------------

--
-- Table structure for table `mgmt_role`
--

DROP TABLE IF EXISTS `mgmt_role`;
CREATE TABLE IF NOT EXISTS `mgmt_role` (
  `mgmt_role_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each role entry',
  `role_name` varchar(20) NOT NULL COMMENT 'Name of the role',
  `description` varchar(100) NOT NULL COMMENT 'Description of the role',
  PRIMARY KEY (`mgmt_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Roles that can be assigned to a staff member';

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

DROP TABLE IF EXISTS `package`;
CREATE TABLE IF NOT EXISTS `package` (
  `package_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'Identifier key for the package',
  `package_name` varchar(20) NOT NULL COMMENT 'Package name',
  `estates_min` tinyint(2) NOT NULL COMMENT 'Minimum number of estates owned',
  `estates_max` tinyint(2) NOT NULL COMMENT 'Maximum number of estates owned',
  `package_price` decimal(12,2) NOT NULL COMMENT 'Package price',
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Holds the packages for landlords to subscribe to';

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each staff',
  `fname` varchar(30) NOT NULL COMMENT 'First name of the member of staff',
  `lname` varchar(30) NOT NULL COMMENT 'Last name of the member of staff',
  `phone1` varchar(15) NOT NULL COMMENT 'Phone1 of the staff member',
  `phone2` varchar(15) DEFAULT NULL COMMENT 'Phone2 of the staff member',
  `email1` varchar(30) NOT NULL COMMENT 'Email1 of the staff member',
  `email2` varchar(30) DEFAULT NULL COMMENT 'Email2 of the staff member',
  `staff_address` varchar(50) DEFAULT NULL COMMENT 'Address of the staff',
  `parish` varchar(30) DEFAULT NULL COMMENT 'Parish the staff member comes from',
  `subcounty` varchar(30) DEFAULT NULL COMMENT 'Subcounty the staff comes from',
  `fk_district_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'FK, identifier for the',
  `fk_landlord_id` int(10) UNSIGNED NOT NULL COMMENT 'Fk, Landlord employing this staff',
  `fk_role_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'Role of this staff',
  `time_added` int(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`staff_id`),
  KEY `fk_district_id` (`fk_district_id`,`fk_landlord_id`,`fk_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Records of all staff belonging to given estates';

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

DROP TABLE IF EXISTS `tenant`;
CREATE TABLE IF NOT EXISTS `tenant` (
  `tenant_id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(50) NOT NULL,
  `lname` varchar(50) DEFAULT NULL COMMENT 'Last name of the tenant',
  `phone1` varchar(10) NOT NULL,
  `phone2` varchar(10) NOT NULL,
  `email1` varchar(50) NOT NULL COMMENT 'Email of the tenant, if any',
  `email2` varchar(50) DEFAULT NULL COMMENT 'Email2 of tenant, optional',
  `home_address` varchar(100) NOT NULL,
  `lc1village` varchar(50) DEFAULT NULL COMMENT 'LC1 village of tenant',
  `parish` varchar(50) DEFAULT NULL COMMENT 'Parish of the tenant',
  `subcounty` varchar(50) DEFAULT NULL COMMENT 'Subcounty of the tenant',
  `district_id` int(11) NOT NULL COMMENT 'Home district id',
  `status` tinyint(1) DEFAULT '1' COMMENT 'Status of the tenant, active=1 or inactive = 0',
  `added_by` int(11) NOT NULL COMMENT 'FK, reference of the staff who added tenant',
  PRIMARY KEY (`tenant_id`),
  KEY `district_id` (`district_id`),
  KEY `added_by` (`added_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Records of all staff belonging to given estates';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
