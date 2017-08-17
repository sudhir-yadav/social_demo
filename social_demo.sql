-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2017 at 08:17 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive_master`
--

CREATE TABLE IF NOT EXISTS `archive_master` (
  `id` bigint(30) NOT NULL,
  `title` varchar(60) NOT NULL,
  `uid` int(11) NOT NULL,
  `url` varchar(130) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `udate` datetime NOT NULL,
  `flag` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=1178274008862446 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `archive_master`
--

INSERT INTO `archive_master` (`id`, `title`, `uid`, `url`, `type`, `udate`, `flag`) VALUES
(149349815088189, 'Profile Pictures', 0, 'usr_zip/Profile_Pictures_149349815088189.zip', 1, '2017-08-16 23:36:46', 1),
(765557443467420, 'Instagram Photos', 0, 'usr_zip/Instagram_Photos_765557443467420.zip', 1, '2017-08-16 23:24:02', 1),
(1178274008862426, 'Timeline Photos', 0, 'usr_zip/Timeline_Photos_1178274008862426.zip', 1, '2017-08-16 23:25:39', 1),
(1178274008862443, 'bkp_02379_16-08-2017__23_24_12_pm', 0, 'usr_zip/bkp_02379_16-08-2017__23_24_12_pm.zip', 2, '2017-08-16 23:24:16', 1),
(1178274008862444, 'bkp_b780f_16-08-2017__23_26_07_pm', 0, 'usr_zip/bkp_b780f_16-08-2017__23_26_07_pm.zip', 2, '2017-08-16 23:26:11', 1),
(1178274008862445, 'bkp_bfb9f_16-08-2017__23_29_41_pm', 0, 'usr_zip/bkp_bfb9f_16-08-2017__23_29_41_pm.zip', 2, '2017-08-16 23:30:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gdrive_master`
--

CREATE TABLE IF NOT EXISTS `gdrive_master` (
  `gdrive_id` varchar(100) NOT NULL,
  `folder_id` varchar(100) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `type` int(11) NOT NULL,
  `flag` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE IF NOT EXISTS `user_master` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `fb_id` varchar(60) NOT NULL,
  `g_token` varchar(500) NOT NULL,
  `flag` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`id`, `name`, `email`, `fb_id`, `g_token`, `flag`) VALUES
(14, 'Sudhir Yadav', 'sudhir_m_yadav@yahoo.com', '1545588452130978', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archive_master`
--
ALTER TABLE `archive_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gdrive_master`
--
ALTER TABLE `gdrive_master`
  ADD PRIMARY KEY (`gdrive_id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fb_id` (`fb_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archive_master`
--
ALTER TABLE `archive_master`
  MODIFY `id` bigint(30) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1178274008862446;
--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
