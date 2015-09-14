-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 12, 2015 at 04:10 PM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `master_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bodies`
--

CREATE TABLE IF NOT EXISTS `bodies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `body_type` varchar(200) NOT NULL,
  `db_name` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `org` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `bodies`
--

INSERT INTO `bodies` (`id`, `title`, `body_type`, `db_name`, `url`, `org`) VALUES
(1, 'Kothrud', 'School', 'Kothrud_School', 'kothrud_school.schnotify.com', 'mit'),
(2, 'Branch2', 'School', 'Branch2_School', 'branch2_school.schnotify.com', 'mit'),
(3, 'Kothrud', 'College', 'Kothrud_College', 'kothrud_college.schnotify.com', 'mit'),
(4, 'ssb2', 'School', 'School_neworg1', 'ssb2_neworg1.schnotify.com', 'neworg1'),
(5, 'ssb3', 'School', 'School_neworg1', 'ssb3_neworg1.schnotify.com', 'neworg1'),
(6, 'newscholl', 'School', 'School_neworg2', 'newscholl_neworg2.schnotify.com', 'neworg2'),
(7, 'dbdemo', 'School', 'School_neworg1', 'dbdemo_neworg1.schnotify.com', 'neworg1'),
(8, 'dbdemo2', 'School', 'School_neworg1', 'dbdemo2_neworg1.schnotify.com', 'neworg1'),
(9, 'dbdemo3', 'School', 'School_neworg1', 'dbdemo3_neworg1.schnotify.com', 'neworg1'),
(10, 'demodb1', 'School', 'School_neworg1', 'demodb1_neworg1.schnotify.com', 'neworg1'),
(11, 'demodb2', 'School', 'School_neworg1', 'demodb2_neworg1.schnotify.com', 'neworg1'),
(12, 'sfsdfs', 'College', 'College_neworg1', 'sfsdfs_neworg1.schnotify.com', 'neworg1'),
(13, 'fghthbn', 'School', 'School_neworg1', 'fghthbn_neworg1.schnotify.com', 'neworg1'),
(14, 'ghjhfghfghfb', 'School', 'School_neworg1', 'ghjhfghfghfb_neworg1.schnotify.com', 'neworg1'),
(15, 'klxfjlsjklsdjdsjh', 'School', 'School_neworg2', 'klxfjlsjklsdjdsjh_neworg2.schnotify.com', 'neworg2'),
(16, 'sdfsdf', 'School', 'School_neworg1', 'sdfsdf_neworg1.schnotify.com', 'neworg1'),
(17, 'mllkjkcvjk', 'School', 'School_neworg1', 'mllkjkcvjk_neworg1.schnotify.com', 'neworg1'),
(18, 'woxiSchool', 'School', 'School_mitWoxi', 'woxiSchool_mitWoxi.schnotify.com', 'mitWoxi'),
(19, 'city-international', 'School', 'School_woxi-kothrud', 'city-international_woxi-kothrud.schnotify.com', 'woxi-kothrud'),
(20, 'city', 'School', 'School_woxi-kothrud', 'city_woxi-kothrud.schnotify.com', 'woxi-kothrud'),
(21, 'city', 'School', 'School_mitWoxi', 'city_mitWoxi.schnotify.com', 'mitWoxi'),
(22, 'jgjghj', 'Academy', 'Academy_woxi-kothrud', 'jgjghj_woxi-kothrud.schnotify.com', 'woxi-kothrud'),
(23, 'new', 'Academy', 'Academy_woxi-kothrud', 'new_woxi-kothrud.schnotify.com', 'woxi-kothrud'),
(24, 'new123', 'Academy', 'Academy_neworg1', 'new123_neworg1.schnotify.com', 'neworg1'),
(25, 'fghh', 'School', 'School_neworg1', 'fghh_neworg1.schnotify.com', 'neworg1'),
(26, 'gjkghjkghj', 'Academy', 'Academy_neworg1', 'gjkghjkghj_neworg1.schnotify.com', 'neworg1'),
(27, 'vbnvn', 'College', 'College_woxi-kothrud', 'vbnvn_woxi-kothrud.schnotify.com', 'woxi-kothrud'),
(28, 'xfvbdfv', 'University', 'University_neworg1', 'xfvbdfv_neworg1.schnotify.com', 'neworg1'),
(29, 'dgdfg', 'University', 'University_neworg1', 'dgdfg_neworg1.schnotify.com', 'neworg1'),
(30, 'sfgdf', 'University', 'University_neworg2', 'sfgdf_neworg2.schnotify.com', 'neworg2');

-- --------------------------------------------------------

--
-- Table structure for table `body_org_module_relation`
--

CREATE TABLE IF NOT EXISTS `body_org_module_relation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_module_id` int(11) NOT NULL,
  `body_org_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `body_org_relation`
--

CREATE TABLE IF NOT EXISTS `body_org_relation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org__id` int(11) NOT NULL,
  `body_type_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `body_org_user_role_relation`
--

CREATE TABLE IF NOT EXISTS `body_org_user_role_relation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `body_org_id` int(11) NOT NULL,
  `org_user_role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `master_body_type`
--

CREATE TABLE IF NOT EXISTS `master_body_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `master_modules`
--

CREATE TABLE IF NOT EXISTS `master_modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2015_09_12_070959_superadmin', 1),
('2015_09_12_071031_create_organization', 1),
('2015_09_12_071100_master_modules', 1),
('2015_09_12_071116_user_groups', 1),
('2015_09_12_071239_master_body_type', 1),
('2015_09_12_071336_create_organization_users', 1),
('2015_09_12_071440_organization_module_relation', 1),
('2015_09_12_071541_body_org_module_relation', 1),
('2015_09_12_071637_body_organization_relation', 1),
('2015_09_12_071759_user_group_module_relation', 1),
('2015_09_12_071911_create_user_role', 1),
('2015_09_12_071935_org_user_role_relation', 1),
('2015_09_12_071958_body_org_user_role_relation', 1);

-- --------------------------------------------------------

--
-- Table structure for table `organisations`
--

CREATE TABLE IF NOT EXISTS `organisations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `url` varchar(200) NOT NULL,
  `slug` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `organisations`
--

INSERT INTO `organisations` (`id`, `name`, `url`, `slug`) VALUES
(1, 'neworg1', 'neworg1.schnotify.com', 'neworg1'),
(2, 'neworg2', 'neworg2.schnotify.com', 'neworg2'),
(3, 'verynew', 'verynew.schnotify.com', 'verynew'),
(4, 'xfvbfdvbbd', 'xfvbfdvbbd.schnotify.com', 'xfvbfdvbbd'),
(5, 'arch', 'arch.schnotify.com', 'arch'),
(6, 'vvcggbfgh', 'vvcggbfgh.schnotify.com', 'vvcggbfgh'),
(7, 'uilkhjkjhk', 'uilkhjkjhk.schnotify.com', 'uilkhjkjhk'),
(8, 'mitWoxi', 'mitWoxi.schnotify.com', 'mitWoxi'),
(9, 'woxi-kothrud', 'woxi-kothrud.schnotify.com', 'woxi-kothrud');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE IF NOT EXISTS `organization` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `org_module_relation`
--

CREATE TABLE IF NOT EXISTS `org_module_relation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `org_users`
--

CREATE TABLE IF NOT EXISTS `org_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `org_user_role_relation`
--

CREATE TABLE IF NOT EXISTS `org_user_role_relation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE IF NOT EXISTS `superadmin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_group_module_relation`
--

CREATE TABLE IF NOT EXISTS `user_group_module_relation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `master_module__id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
