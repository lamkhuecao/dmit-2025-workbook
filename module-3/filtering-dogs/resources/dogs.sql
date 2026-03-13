-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 08, 2013 at 02:08 PM
-- Server version: 5.1.52
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `philr_prep`
--

-- --------------------------------------------------------

--
-- Table structure for table `dogs`
--

CREATE TABLE IF NOT EXISTS `dogs` (
  `breed` varchar(50) NOT NULL,
  `size` varchar(50) NOT NULL,
  `children` varchar(50) NOT NULL,
  `guard` tinyint(1) NOT NULL,
  `lowshedding` varchar(50) NOT NULL,
  `intelligence` int(2) NOT NULL,
  `image_file` varchar(100) NOT NULL,
  `pooch_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pooch_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `dogs`
--

INSERT INTO `dogs` (`breed`, `size`, `children`, `guard`, `lowshedding`, `intelligence`, `image_file`, `pooch_id`) VALUES
('Afghan Hound', 'large', 'maybe', 0, 'yes', 1, 'Afghan-Hound.jpg', 1),
('Akita', 'large', 'no', 1, 'no', 3, 'akita.jpg', 2),
('American Eskimo Dog', 'medium', 'yes', 1, 'no', 7, 'American_Eskimo_Dog.jpg', 3),
('Basset Hound', 'small', 'yes', 0, 'yes', 1, 'basset hound.jpg', 4),
('Bichon Frise', 'medium', 'yes', 0, 'yes', 4, 'bichon frise.jpg', 5),
('Bloodhound', 'large', 'no', 0, 'yes', 2, 'bloodhound.jpg', 6),
('Border Collie', 'medium', 'yes', 0, 'no', 10, 'border collie.jpg', 7),
('Boxer', 'large', 'no', 1, 'yes', 4, 'boxer.jpg', 8),
('Chihuahua', 'small', 'yes', 0, 'yes', 3, 'chihuahua.jpg', 9),
('Finnish Spitz', 'medium', 'yes', 0, 'no', 5, 'finnish_spitz.jpg', 10),
('Greyhound', 'large', 'yes', 0, 'yes', 5, 'greyhound.jpg', 11),
('Yorkshire Terrier', 'small', 'yes', 1, 'yes', 7, 'yorkie.jpg', 12),
('Standard Poodle', 'medium', 'yes', 0, 'no', 10, 'poodle.jpg', 13),
('Saint Bernard', 'large', 'yes', 1, 'no', 3, 'stbernard.jpg', 14),
('German Shepherd', 'large', 'yes', 1, 'no', 8, 'germanshepherd.jpg', 15),
('Rottweiler', 'large', 'no', 1, 'yes', 5, 'rottweiler.jpg', 16),
('Siberian Husky', 'large', 'yes', 1, 'no', 8, 'husky.jpg', 17),
('Mastiff', 'large', 'no', 1, 'yes', 3, 'mastiff.jpg', 18),
('Pekinese', 'small', 'yes', 0, 'no', 2, 'pekinese.jpg', 20);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
