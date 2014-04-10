-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 10, 2014 at 04:30 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Table structure for table `phpmyreservation_configuration`
--

CREATE TABLE IF NOT EXISTS `phpmyreservation_configuration` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `phpmyreservation_configuration`
--

INSERT INTO `phpmyreservation_configuration` (`id`, `price`) VALUES
(1, 200);

-- --------------------------------------------------------

--
-- Table structure for table `phpmyreservation_playgrounds`
--

CREATE TABLE IF NOT EXISTS `phpmyreservation_playgrounds` (
  `playground_id` int(10) NOT NULL AUTO_INCREMENT,
  `playground_is_admin` tinyint(1) NOT NULL,
  `playground_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `playground_password` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `playground_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `playground_reservation_reminder` tinyint(1) NOT NULL,
  PRIMARY KEY (`playground_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `phpmyreservation_playgrounds`
--

INSERT INTO `phpmyreservation_playgrounds` (`playground_id`, `playground_is_admin`, `playground_email`, `playground_password`, `playground_name`, `playground_reservation_reminder`) VALUES
(3, 0, 'abcd@gmail.com', '$1$k4i8pa2m$X1ReQZOxdzAc4mi59J2JJ.', 'abcd', 0),
(2, 0, 'abc@gmail.com', '$1$k4i8pa2m$X1ReQZOxdzAc4mi59J2JJ.', 'abc', 0);

-- --------------------------------------------------------

--
-- Table structure for table `phpmyreservation_reservations`
--

CREATE TABLE IF NOT EXISTS `phpmyreservation_reservations` (
  `reservation_id` int(10) NOT NULL AUTO_INCREMENT,
  `reservation_venue_id` bigint(20) NOT NULL,
  `reservation_made_time` datetime NOT NULL,
  `reservation_year` smallint(4) NOT NULL,
  `reservation_week` tinyint(2) NOT NULL,
  `reservation_day` tinyint(1) NOT NULL,
  `reservation_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `reservation_price` float NOT NULL,
  `reservation_user_id` int(10) NOT NULL,
  `reservation_user_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `reservation_user_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`reservation_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `phpmyreservation_reservations`
--

INSERT INTO `phpmyreservation_reservations` (`reservation_id`, `reservation_venue_id`, `reservation_made_time`, `reservation_year`, `reservation_week`, `reservation_day`, `reservation_time`, `reservation_price`, `reservation_user_id`, `reservation_user_email`, `reservation_user_name`) VALUES
(1, 0, '2014-04-09 19:06:51', 2014, 15, 1, '09-10', 2, 1, 'aveek@gmail.com', 'Aveek'),
(2, 0, '2014-04-09 19:06:58', 2014, 15, 4, '16-17', 2, 1, 'aveek@gmail.com', 'Aveek'),
(3, 0, '2014-04-09 19:11:04', 2014, 18, 3, '09-10', 2, 1, 'aveek@gmail.com', 'Aveek'),
(5, 0, '2014-04-09 21:11:58', 2014, 15, 4, '09-10', 200, 1, 'aveek@gmail.com', 'Aveek'),
(6, 0, '2014-04-09 21:12:00', 2014, 15, 4, '10-11', 200, 1, 'aveek@gmail.com', 'Aveek'),
(8, 0, '2014-04-10 11:33:39', 2014, 15, 5, '13-14', 200, 2, 'abhishek@gmail.com', 'Abhishek'),
(9, 0, '2014-04-10 14:04:28', 2014, 15, 2, '09-10', 200, 1, 'aveek@gmail.com', 'Aveek'),
(10, 0, '2014-04-10 18:15:34', 2014, 15, 6, '12-13', 200, 2, 'abhishek@gmail.com', 'Abhishek');

-- --------------------------------------------------------

--
-- Table structure for table `phpmyreservation_users`
--

CREATE TABLE IF NOT EXISTS `phpmyreservation_users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_is_admin` tinyint(1) NOT NULL,
  `user_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_reservation_reminder` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `phpmyreservation_users`
--

INSERT INTO `phpmyreservation_users` (`user_id`, `user_is_admin`, `user_email`, `user_password`, `user_name`, `user_reservation_reminder`) VALUES
(1, 1, 'aveek@gmail.com', '$1$k4i8pa2m$2VuECbw3hRsiJ.M7ZpPYD1', 'Aveek', 0),
(2, 0, 'abhishek@gmail.com', '$1$k4i8pa2m$3KE8i3eRDrr8tLNqn9WEE.', 'Abhishek', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
