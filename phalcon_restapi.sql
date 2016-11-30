-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2016 at 09:50 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phalcon_restapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `recent`
--

CREATE TABLE `recent` (
  `id` int(10) NOT NULL,
  `uid` int(11) NOT NULL,
  `ip` varchar(70) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recent`
--

INSERT INTO `recent` (`id`, `uid`, `ip`, `time`) VALUES
(3, 2, '100.111.010.120', '2016-11-28 16:24:37'),
(4, 1, '::1', '2016-11-29 22:42:01'),
(5, 1, '::1', '2016-11-29 22:42:22'),
(6, 1, '::1', '2016-11-29 22:43:12'),
(7, 1, '::1', '2016-11-29 22:43:56'),
(8, 2, '::1', '2016-11-29 23:42:26'),
(9, 2, '::1', '2016-11-29 23:42:32'),
(10, 3, '::1', '2016-11-29 23:42:51'),
(11, 1, '::1', '2016-11-30 13:38:24'),
(12, 3, '::1', '2016-11-30 14:10:03'),
(13, 3, '::1', '2016-11-30 15:38:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `uname` varchar(70) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(70) NOT NULL,
  `ssid` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uname`, `email`, `pass`, `ssid`) VALUES
(1, 'lichnhat', 'g2lnl94@gmail.com', '12345', 'drkd2jr0aa1kv4lcbkrrbav7q6'),
(2, 'tranquan', 'tranquan227@gmail.com', '121212', 'drkd2jr0aa1kv4lcbkrrbav8q6'),
(3, 'nguyenquockhanh', 'quockhanh11@kingko.com', 'kingslayer', 'drkd2jr0aa1kv4lcbkrrbav9q6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recent`
--
ALTER TABLE `recent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ssid` (`ssid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recent`
--
ALTER TABLE `recent`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
