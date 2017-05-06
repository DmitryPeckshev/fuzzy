-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 06, 2017 at 08:07 
-- Server version: 5.7.13
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fuzzy`
--

-- --------------------------------------------------------

--
-- Table structure for table `cat`
--

CREATE TABLE IF NOT EXISTS `cat` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cat`
--

INSERT INTO `cat` (`id`, `name`) VALUES
(20, 'Автомобили');

-- --------------------------------------------------------

--
-- Table structure for table `exp_prop`
--

CREATE TABLE IF NOT EXISTS `exp_prop` (
  `id` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  `prop` int(11) NOT NULL,
  `cat` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exp_prop`
--

INSERT INTO `exp_prop` (`id`, `exp`, `prop`, `cat`) VALUES
(31, 2, 39, 20),
(32, 2, 31, 20),
(33, 2, 40, 20),
(34, 2, 37, 20),
(35, 2, 32, 20);

-- --------------------------------------------------------

--
-- Table structure for table `obj`
--

CREATE TABLE IF NOT EXISTS `obj` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cat` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `obj`
--

INSERT INTO `obj` (`id`, `name`, `cat`) VALUES
(20, 'Ваз 2109', 20),
(18, 'Лада Приора', 20),
(21, 'Шевроле Круз', 20),
(19, 'Шевроле Лачетти', 20);

-- --------------------------------------------------------

--
-- Table structure for table `obj_prop`
--

CREATE TABLE IF NOT EXISTS `obj_prop` (
  `key_id` int(11) NOT NULL,
  `obj` int(11) NOT NULL,
  `prop` int(11) NOT NULL,
  `cat` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `obj_prop`
--

INSERT INTO `obj_prop` (`key_id`, `obj`, `prop`, `cat`) VALUES
(55, 18, 32, 20),
(56, 18, 33, 20),
(57, 18, 34, 20),
(58, 18, 35, 20),
(59, 19, 33, 20),
(60, 19, 34, 20),
(61, 19, 38, 20),
(62, 19, 39, 20),
(63, 19, 37, 20),
(64, 19, 40, 20),
(65, 20, 35, 20),
(66, 20, 32, 20),
(67, 20, 33, 20),
(68, 20, 40, 20),
(69, 21, 33, 20),
(70, 21, 34, 20),
(71, 21, 36, 20),
(72, 21, 37, 20),
(73, 21, 38, 20),
(74, 21, 39, 20);

-- --------------------------------------------------------

--
-- Table structure for table `prop`
--

CREATE TABLE IF NOT EXISTS `prop` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cat` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prop`
--

INSERT INTO `prop` (`id`, `name`, `cat`) VALUES
(31, 'Надежный', 20),
(32, 'Экономный', 20),
(33, 'Вместительный', 20),
(34, 'Красивый', 20),
(35, 'Недорогой', 20),
(36, 'Престижный', 20),
(37, 'Современный', 20),
(38, 'Комфортабельный', 20),
(39, 'Быстрый', 20),
(40, 'Проходимый', 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `status` varchar(32) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `pass`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(3, 'boss', 'ceb8447cc4ab78d2ec34cd9f11e4bed2', 'boss'),
(2, 'expert', 'b9b83bad6bd2b4f7c40109304cf580e1', 'expert');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cat`
--
ALTER TABLE `cat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `exp_prop`
--
ALTER TABLE `exp_prop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exp` (`exp`),
  ADD KEY `prop` (`prop`),
  ADD KEY `cat` (`cat`);

--
-- Indexes for table `obj`
--
ALTER TABLE `obj`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`cat`),
  ADD KEY `cat` (`cat`);

--
-- Indexes for table `obj_prop`
--
ALTER TABLE `obj_prop`
  ADD PRIMARY KEY (`key_id`),
  ADD UNIQUE KEY `obj_2` (`obj`,`prop`),
  ADD KEY `obj` (`obj`),
  ADD KEY `prop` (`prop`),
  ADD KEY `cat` (`cat`);

--
-- Indexes for table `prop`
--
ALTER TABLE `prop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat` (`cat`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`pass`,`status`),
  ADD UNIQUE KEY `name_2` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cat`
--
ALTER TABLE `cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `exp_prop`
--
ALTER TABLE `exp_prop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `obj`
--
ALTER TABLE `obj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `obj_prop`
--
ALTER TABLE `obj_prop`
  MODIFY `key_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `prop`
--
ALTER TABLE `prop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `exp_prop`
--
ALTER TABLE `exp_prop`
  ADD CONSTRAINT `exp_prop_ibfk_1` FOREIGN KEY (`exp`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exp_prop_ibfk_2` FOREIGN KEY (`cat`) REFERENCES `cat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exp_prop_ibfk_3` FOREIGN KEY (`prop`) REFERENCES `prop` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `obj`
--
ALTER TABLE `obj`
  ADD CONSTRAINT `obj_ibfk_1` FOREIGN KEY (`cat`) REFERENCES `cat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `obj_prop`
--
ALTER TABLE `obj_prop`
  ADD CONSTRAINT `obj_prop_ibfk_1` FOREIGN KEY (`prop`) REFERENCES `prop` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `obj_prop_ibfk_2` FOREIGN KEY (`obj`) REFERENCES `obj` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `obj_prop_ibfk_3` FOREIGN KEY (`cat`) REFERENCES `cat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prop`
--
ALTER TABLE `prop`
  ADD CONSTRAINT `prop_ibfk_1` FOREIGN KEY (`cat`) REFERENCES `cat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
