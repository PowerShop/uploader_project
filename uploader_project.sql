-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql206.epizy.com
-- Generation Time: Mar 25, 2023 at 02:57 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_33843964_mini_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `like`
--

CREATE TABLE `like` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `img_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `id` int(11) NOT NULL COMMENT 'Primary Key',
  `membership_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Membership Name',
  `membership_exp` int(11) NOT NULL COMMENT 'Membership Exp',
  `membership_reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Membership Reference',
  `membership_badge` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploader_image`
--

CREATE TABLE `uploader_image` (
  `img_id` int(11) NOT NULL COMMENT 'Primary Key',
  `img_uploader` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Image Name',
  `img_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Image Path',
  `img_size` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Image Size',
  `img_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Image Type',
  `img_tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Image Tag',
  `img_like` int(11) NOT NULL,
  `img_create_time` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Create Time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL COMMENT 'Primary Key',
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User Name',
  `user_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User Password',
  `user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User Email',
  `user_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User Phone',
  `user_exp` int(11) NOT NULL,
  `user_membership` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'User Membership',
  `user_avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_like` int(11) NOT NULL,
  `user_admin_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `create_time` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Create Time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploader_image`
--
ALTER TABLE `uploader_image`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `like`
--
ALTER TABLE `like`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT for table `uploader_image`
--
ALTER TABLE `uploader_image`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
