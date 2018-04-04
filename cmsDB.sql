-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2018 at 02:24 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tours_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cms_module`
--

CREATE TABLE IF NOT EXISTS `cms_module` (
  `cms_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `cms_module_label` varchar(100) DEFAULT NULL,
  `cms_module_uri` varchar(150) DEFAULT NULL,
  `cms_module_icon` varchar(100) DEFAULT NULL,
  `cms_module_rank` int(11) DEFAULT NULL,
  `cms_module_group_id` varchar(45) DEFAULT NULL,
  `special_access` enum('Y','N') DEFAULT 'N',
  `access_key` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cms_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `cms_module`
--

INSERT INTO `cms_module` (`cms_module_id`, `cms_module_label`, `cms_module_uri`, `cms_module_icon`, `cms_module_rank`, `cms_module_group_id`, `special_access`, `access_key`) VALUES
(1, 'Dashboard', 'dashboard', 'fa fa-dashboard', 1, '1', 'N', NULL),
(2, 'Pages', 'pages', 'glyphicon glyphicon-list-alt', 2, '2', 'N', NULL),
(3, 'Enquiries', 'enquiries', 'fa fa-envelope', 3, '3', 'N', NULL),
(4, 'File Manager', 'files', 'fa fa-folder', 4, '4', 'N', NULL),
(5, 'Reviews', 'testimonials', 'fa fa-comments', 5, '5', 'N', NULL),
(6, 'Forms', 'forms', 'fa fa-list-alt', 6, '6', 'N', NULL),
(7, 'Compendium Sections', 'compendium', 'fa fa-list', 7, '7', 'N', NULL),
(8, 'Newsletter Lists', 'beameremails', 'fa fa-th-list', 8, '8', 'N', NULL),
(9, 'Newsletter Campaigns', 'beamercampaigns', 'fa fa-envelope', 9, '8', 'N', NULL),
(10, 'Slideshows', 'slideshows', 'glyphicon glyphicon-picture', 10, '9', 'N', NULL),
(11, 'Galleries', 'galleries', 'glyphicon glyphicon-picture', 11, '10', 'N', NULL),
(12, 'Tours', 'tours', 'fa fa-home', 12, '11', 'N', NULL),
(13, 'Inclusions', 'features', 'fa fa-star', 13, '11', 'N', NULL),
(14, 'Payment Request', 'payments', 'fa fa-money', 14, '12', 'N', NULL),
(15, 'Blog Categories', 'blogcategories', 'fa fa-rss', 15, '13', 'N', NULL),
(16, 'Blog Posts', 'blogposts', 'fa fa-rss', 16, '13', 'N', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_module_group`
--

CREATE TABLE IF NOT EXISTS `cms_module_group` (
  `cms_module_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `cms_module_group_label` varchar(100) DEFAULT NULL,
  `cms_module_description` text,
  `is_active` enum('Y','N') DEFAULT 'N',
  `rank` int(11) DEFAULT NULL,
  `cms_nav_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cms_module_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `cms_module_group`
--

INSERT INTO `cms_module_group` (`cms_module_group_id`, `cms_module_group_label`, `cms_module_description`, `is_active`, `rank`, `cms_nav_group_id`) VALUES
(1, 'Dashboard', NULL, 'Y', 1, 1),
(2, 'Pages', NULL, 'Y', 2, 1),
(3, 'Enquiries', NULL, 'Y', 3, 1),
(4, 'File Manager', NULL, 'Y', 4, 1),
(5, 'Reviews', NULL, 'Y', 5, 1),
(6, 'Forms', NULL, 'Y', 6, 1),
(7, 'Compendium', NULL, 'Y', 7, 1),
(8, 'Mailchimp Beamer', NULL, 'Y', 8, 2),
(9, 'Slideshow', NULL, 'Y', 9, 3),
(10, 'Gallery', NULL, 'Y', 10, 3),
(11, 'Tours', NULL, 'Y', 11, 4),
(12, 'Payments', NULL, 'Y', 12, 5),
(13, 'Blog', NULL, 'Y', 13, 6);

-- --------------------------------------------------------

--
-- Table structure for table `cms_nav_group`
--

CREATE TABLE IF NOT EXISTS `cms_nav_group` (
  `cms_nav_id` int(11) NOT NULL AUTO_INCREMENT,
  `cms_nav_label` varchar(150) DEFAULT NULL,
  `cms_nav_rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`cms_nav_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `cms_nav_group`
--

INSERT INTO `cms_nav_group` (`cms_nav_id`, `cms_nav_label`, `cms_nav_rank`) VALUES
(1, 'General', 1),
(2, 'Newsletter', 2),
(3, 'Photos', 3),
(4, 'Tours', 4),
(5, 'Payments', 5),
(6, 'Blog', 6);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
