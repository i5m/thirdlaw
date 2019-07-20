-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2019 at 03:25 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `noname`
--

-- --------------------------------------------------------

--
-- Table structure for table `crushes`
--

CREATE TABLE `crushes` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `crush` varchar(50) NOT NULL,
  `added_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customuser`
--

CREATE TABLE `customuser` (
  `id` int(11) NOT NULL,
  `customploc` varchar(256) DEFAULT NULL,
  `customname` varchar(50) DEFAULT NULL,
  `crushername` varchar(50) DEFAULT NULL,
  `customcity` varchar(50) DEFAULT NULL,
  `customcollege` varchar(50) DEFAULT NULL,
  `customphone` varchar(20) DEFAULT NULL,
  `custombday` varchar(20) DEFAULT NULL,
  `custominsta` varchar(50) DEFAULT NULL,
  `customed_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `fromuser` varchar(50) DEFAULT NULL,
  `touser` varchar(50) DEFAULT NULL,
  `messagebody` text,
  `hasseen` int(2) DEFAULT '0',
  `sent_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `seen_at` varchar(25) DEFAULT NULL,
  `howreact` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `whoprofile` varchar(75) DEFAULT NULL,
  `profilefreq` int(10) DEFAULT '1',
  `stalked_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `searches`
--

CREATE TABLE `searches` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `searched_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `whosearch` varchar(50) DEFAULT NULL,
  `searchfreq` int(10) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `ploc` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `bday` varchar(20) DEFAULT NULL,
  `bio` varchar(130) DEFAULT NULL,
  `college` varchar(60) DEFAULT NULL,
  `ecrushes` varchar(200) DEFAULT NULL,
  `last_active` varchar(50) DEFAULT 'Never',
  `instaprof` varchar(60) DEFAULT '',
  `latest_lat` varchar(20) DEFAULT '',
  `latest_lng` varchar(20) DEFAULT '',
  `theIp` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crushes`
--
ALTER TABLE `crushes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customuser`
--
ALTER TABLE `customuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `searches`
--
ALTER TABLE `searches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crushes`
--
ALTER TABLE `crushes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customuser`
--
ALTER TABLE `customuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `searches`
--
ALTER TABLE `searches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
