-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 26, 2014 at 04:53 PM
-- Server version: 5.5.32
-- PHP Version: 5.3.10-1ubuntu3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `books`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `author_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_name` varchar(250) NOT NULL,
  `author_bio` varchar(500) NOT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `author_name`, `author_bio`) VALUES
(1, 'Джордж Оруел', 'Lorem ipsum dolor sit amet'),
(2, 'Захари Стоянов', 'Lorem ipsum dolor sit amet'),
(3, 'Пратчет', 'Lorem ipsum dolor sit amet'),
(4, 'Николов', 'Lorem ipsum dolor sit amet');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_title` varchar(250) NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_title`) VALUES
(1, '1984'),
(2, 'Записки по българските въстания'),
(3, 'Пътеводител');

-- --------------------------------------------------------

--
-- Table structure for table `books_authors`
--

CREATE TABLE IF NOT EXISTS `books_authors` (
  `book_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  KEY `book_id` (`book_id`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `books_authors`
--

INSERT INTO `books_authors` (`book_id`, `author_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(3, 4),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hops`
--

CREATE TABLE IF NOT EXISTS `hops` (
  `hop_id` int(11) NOT NULL AUTO_INCREMENT,
  `hop_name` text NOT NULL,
  `hop_info` varchar(250) NOT NULL,
  PRIMARY KEY (`hop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `hops`
--

INSERT INTO `hops` (`hop_id`, `hop_name`, `hop_info`) VALUES
(4, 'brat i slava', 'БНТ-то'),
(2, 'BGZ', 'BTV-то'),
(3, 'brr', 'frappy'),
(5, 'probokop', 'тестов докумнет.');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `route_id` int(11) NOT NULL AUTO_INCREMENT,
  `route_name` text NOT NULL,
  PRIMARY KEY (`route_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`route_id`, `route_name`) VALUES
(1, 'Път1'),
(2, 'Route2'),
(3, 'testov 1');

-- --------------------------------------------------------

--
-- Table structure for table `routes_hops`
--

CREATE TABLE IF NOT EXISTS `routes_hops` (
  `route_id` int(11) NOT NULL,
  `hop_id` int(11) NOT NULL,
  KEY `route_id` (`route_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `routes_hops`
--

INSERT INTO `routes_hops` (`route_id`, `hop_id`) VALUES
(2, 3),
(1, 3),
(1, 2),
(2, 2),
(2, 4),
(1, 4),
(3, 4),
(3, 5),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(2, 'tester', 'tester'),
(3, 'tester2', 'tester2'),
(4, 'pacev', 'chernilko');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
