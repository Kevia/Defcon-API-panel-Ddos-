-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2016 at 03:24 AM
-- Server version: 5.6.26
-- PHP Version: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `botnet`
--

-- --------------------------------------------------------

--
-- Table structure for table `atack`
--

CREATE TABLE IF NOT EXISTS `atack` (
  `id` int(11) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `port` varchar(10) NOT NULL,
  `time` varchar(50) NOT NULL,
  `method` varchar(20) NOT NULL,
  `vreme` varchar(30) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `cip` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `banovi`
--

CREATE TABLE IF NOT EXISTS `banovi` (
  `id` int(11) NOT NULL,
  `ip` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prijave`
--

CREATE TABLE IF NOT EXISTS `prijave` (
  `id` int(11) NOT NULL,
  `sid` varchar(30) NOT NULL,
  `razlog` varchar(30) NOT NULL,
  `napomena` text NOT NULL,
  `author` varchar(30) NOT NULL,
  `authorid` varchar(30) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `ime` varchar(30) NOT NULL,
  `prezime` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `register_time` varchar(30) NOT NULL,
  `datum` varchar(222) NOT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'noimg.jpg',
  `drzava` varchar(222) NOT NULL,
  `user_ip` varchar(30) NOT NULL DEFAULT '0',
  `rank` int(11) DEFAULT '0',
  `rank_status` varchar(100) DEFAULT 'korisnik',
  `last_activity` varchar(64) NOT NULL,
  `online` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `ime`, `prezime`, `password`, `email`, `register_time`, `datum`, `avatar`, `drzava`, `user_ip`, `rank`, `rank_status`, `last_activity`, `online`) VALUES
(199, 'Kevia', 'Muhamed', 'Skoko', 'fe01ce2a7fbac8fafaed7c982a04e229', 'info@kevia.com', '1442680855', '16.09.2016', '1473374707.png', 'ME', '37.122.160.7', 1, 'Developer', '1474105056', 0),
(203, 'Demo', 'Demo', 'Demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'test@test', '1448711892', '12.09.2016', '1473389442.png', 'RS', '::1', 0, 'Support', '1474107163', 0),
(204, 'Demo2', 'Demo2', 'Demo2', 'fe01ce2a7fbac8fafaed7c982a04e229', 'test@test', '1448711892', '13.09.2016', '1473389442.png', 'RS', '::1', 0, 'Support', '1474063252', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tiketi`
--

CREATE TABLE IF NOT EXISTS `tiketi` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `naslov` varchar(222) NOT NULL,
  `sadrzaj` longtext NOT NULL,
  `datum` varchar(222) NOT NULL,
  `vreme` varchar(222) NOT NULL,
  `status` int(11) NOT NULL,
  `odgovor` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tiketi_odgovori`
--

CREATE TABLE IF NOT EXISTS `tiketi_odgovori` (
  `id` int(11) NOT NULL,
  `tiketid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `odgovor` longtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atack`
--
ALTER TABLE `atack`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banovi`
--
ALTER TABLE `banovi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prijave`
--
ALTER TABLE `prijave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `tiketi`
--
ALTER TABLE `tiketi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tiketi_odgovori`
--
ALTER TABLE `tiketi_odgovori`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atack`
--
ALTER TABLE `atack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `banovi`
--
ALTER TABLE `banovi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `prijave`
--
ALTER TABLE `prijave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `tiketi`
--
ALTER TABLE `tiketi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `tiketi_odgovori`
--
ALTER TABLE `tiketi_odgovori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
