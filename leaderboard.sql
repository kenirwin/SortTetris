-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2016 at 11:57 AM
-- Server version: 5.6.30
-- PHP Version: 5.4.16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `tetris`
--

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE IF NOT EXISTS `leaderboard` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `time_entry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(50) NOT NULL,
  `score` int(11) NOT NULL,
  `percent` tinyint(4) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `config_file` varchar(50) NOT NULL,
  `institution` varchar(50),
  PRIMARY KEY (`game_id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;
