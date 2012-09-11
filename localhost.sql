-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 11 sep 2012 kl 09:19
-- Serverversion: 5.5.25a
-- PHP-version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `twitterclone`
--
CREATE DATABASE `twitterclone` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `twitterclone`;

-- --------------------------------------------------------

--
-- Tabellstruktur `followers`
--

CREATE TABLE IF NOT EXISTS `followers` (
  `userid` int(11) NOT NULL,
  `following` int(11) NOT NULL,
  PRIMARY KEY (`userid`,`following`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `tweets`
--

CREATE TABLE IF NOT EXISTS `tweets` (
  `tweetid` int(16) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `message` varchar(150) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `timestamp` int(32) NOT NULL,
  `replyto` int(16) DEFAULT NULL,
  PRIMARY KEY (`tweetid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=196 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `userinfo`
--

CREATE TABLE IF NOT EXISTS `userinfo` (
  `userid` int(11) NOT NULL,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `firstname` varchar(32) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `lastname` varchar(40) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `userimage` varchar(40) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT '/avatars/default-avatar.png',
  `description` text CHARACTER SET utf8 COLLATE utf8_swedish_ci,
  `location` varchar(50) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `website` varchar(50) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
