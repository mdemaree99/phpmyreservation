-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2014 at 10:55 AM
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
  `playground_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `playground_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `playground_password` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `playground_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `playground_location` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `locality` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `playground_about` text COLLATE utf8_unicode_ci NOT NULL,
  `playground_reservation_reminder` tinyint(1) NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`playground_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `phpmyreservation_playgrounds`
--

INSERT INTO `phpmyreservation_playgrounds` (`playground_id`, `playground_email`, `playground_password`, `playground_name`, `playground_location`, `locality`, `playground_about`, `playground_reservation_reminder`, `active`) VALUES
(3, 'abcd@gmail.com', '$1$k4i8pa2m$X1ReQZOxdzAc4mi59J2JJ.', 'Playmania', 'Bellandur, Bangalore , karnataka', 'Bellandur', '', 0, 0),
(2, 'abc@gmail.com', '$1$k4i8pa2m$X1ReQZOxdzAc4mi59J2JJ.', 'Play Zone', 'Near temple , bellandur main road , bangalore', 'Bellandur', '', 0, 0),
(4, 'playmania@gmail.com', '$1$k4i8pa2m$NjbkRtNdyGb57/acRaddn0', 'Glow Tennis Academy', 'Bellandur', 'bellandur', '', 0, 0),
(5, 'glow@gmail.com', '$1$k4i8pa2m$NjbkRtNdyGb57/acRaddn0', 'GlowAcademy', 'Marathalli', 'marathalli', '', 0, 0);

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
  `reservation_phone_number` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`reservation_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Dumping data for table `phpmyreservation_reservations`
--

INSERT INTO `phpmyreservation_reservations` (`reservation_id`, `reservation_venue_id`, `reservation_made_time`, `reservation_year`, `reservation_week`, `reservation_day`, `reservation_time`, `reservation_price`, `reservation_user_id`, `reservation_user_email`, `reservation_user_name`, `reservation_phone_number`) VALUES
(1, 0, '2014-04-09 19:06:51', 2014, 15, 1, '09-10', 2, 1, 'aveek@gmail.com', 'Aveek', ''),
(2, 0, '2014-04-09 19:06:58', 2014, 15, 4, '16-17', 2, 1, 'aveek@gmail.com', 'Aveek', ''),
(3, 0, '2014-04-09 19:11:04', 2014, 18, 3, '09-10', 2, 1, 'aveek@gmail.com', 'Aveek', ''),
(5, 0, '2014-04-09 21:11:58', 2014, 15, 4, '09-10', 200, 1, 'aveek@gmail.com', 'Aveek', ''),
(6, 0, '2014-04-09 21:12:00', 2014, 15, 4, '10-11', 200, 1, 'aveek@gmail.com', 'Aveek', ''),
(8, 0, '2014-04-10 11:33:39', 2014, 15, 5, '13-14', 200, 2, 'abhishek@gmail.com', 'Abhishek', ''),
(9, 0, '2014-04-10 14:04:28', 2014, 15, 2, '09-10', 200, 1, 'aveek@gmail.com', 'Aveek', ''),
(10, 0, '2014-04-10 18:15:34', 2014, 15, 6, '12-13', 200, 2, 'abhishek@gmail.com', 'Abhishek', ''),
(18, 0, '2014-04-11 00:13:20', 0, 0, 0, '0', 200, 2, 'abc@gmail.com', 'abc', ''),
(27, 11, '2014-04-13 12:06:38', 2014, 15, 7, '9AM-10AM', 200, 2, 'abhishek@gmail.com', 'Abhishek', ''),
(20, 0, '2014-04-12 22:01:33', 2014, 15, 6, '13-14', 200, 2, 'abhishek@gmail.com', 'Abhishek', ''),
(22, 0, '2014-04-12 23:29:49', 2014, 15, 6, '11-12', 200, 2, 'abhishek@gmail.com', 'Abhishek', ''),
(23, 0, '2014-04-12 23:29:55', 2014, 15, 7, '13-14', 200, 2, 'abhishek@gmail.com', 'Abhishek', ''),
(26, 11, '2014-04-12 23:38:02', 2014, 15, 7, '13-14', 200, 2, 'abhishek@gmail.com', 'Abhishek', ''),
(25, 11, '2014-04-12 23:37:37', 2014, 15, 6, '11-12', 200, 2, 'abhishek@gmail.com', 'Abhishek', ''),
(28, 11, '2014-04-13 12:16:14', 2014, 15, 7, '11AM-12PM', 250, 2, 'abhishek@gmail.com', 'Abhishek', ''),
(29, 11, '2014-04-13 12:16:28', 2014, 16, 1, '10AM-11AM', 250, 2, 'abhishek@gmail.com', 'Abhishek', ''),
(31, 11, '2014-04-14 16:01:14', 2014, 16, 3, '9AM-10AM', 250, 2, 'abc@gmail.com', 'abc', '');

-- --------------------------------------------------------

--
-- Table structure for table `phpmyreservation_users`
--

CREATE TABLE IF NOT EXISTS `phpmyreservation_users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_is_admin` tinyint(1) NOT NULL,
  `user_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_reservation_reminder` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `phpmyreservation_users`
--

INSERT INTO `phpmyreservation_users` (`user_id`, `user_is_admin`, `user_email`, `user_phone`, `user_password`, `user_name`, `user_reservation_reminder`) VALUES
(1, 1, 'aveek@gmail.com', '', '$1$k4i8pa2m$2VuECbw3hRsiJ.M7ZpPYD1', 'Aveek', 0),
(2, 0, 'abhishek@gmail.com', '', '$1$k4i8pa2m$3KE8i3eRDrr8tLNqn9WEE.', 'Abhishek', 0);

-- --------------------------------------------------------

--
-- Table structure for table `phpmyreservation_venues`
--

CREATE TABLE IF NOT EXISTS `phpmyreservation_venues` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `sports_type` varchar(25) NOT NULL,
  `time_slots` varchar(250) NOT NULL,
  `day_off` varchar(15) NOT NULL,
  `rate` int(11) NOT NULL,
  `location` varchar(50) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `playground_id` bigint(20) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `phpmyreservation_venues`
--

INSERT INTO `phpmyreservation_venues` (`id`, `name`, `sports_type`, `time_slots`, `day_off`, `rate`, `location`, `contact_number`, `playground_id`, `is_active`) VALUES
(11, 'Badminton court 1', 'Badminton', '9AM-10AM;10AM-11AM;11AM-12PM;12AM-1PM;1AM-2PM ', '', 250, 'Playmania, Bellandur', '9741700577', 3, 0),
(15, 'Badminton court B', 'Badminton', '9AM-10AM;10AM-11AM;11AM-12PM;12AM-1PM;1AM-2PM ', '', 260, 'Playmania', '9741700577', 2, 0),
(17, 'Glow tennis academy', 'Tennis', '10AM to 12PM;2PM to 4PM;6PM to 8PM', '', 200, 'Glow tennis academy, Bellandur', '8987656342', 2, 0),
(20, 'test', 'test', '9AM-10AM;10AM-11AM;11AM-12PM;12PM-1PM;1PM-2PM', '2,6,', 400, 'test', '9876567443', 2, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
