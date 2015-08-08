-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2015 at 10:52 PM
-- Server version: 5.6.24
-- PHP Version: 5.5.24
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO" ;
SET time_zone = "+00:00" ;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */ ;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */ ;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */ ;
/*!40101 SET NAMES utf8 */ ;
--
-- Database: `site_test`
--
-- --------------------------------------------------------
--
-- Table structure for table `users`
--
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_password_recovered` int(1) NOT NULL DEFAULT '0',
  `user_first_name` varchar(50) NOT NULL,
  `user_last_name` varchar(50) NOT NULL,
  `user_display_image` varchar(200) NOT NULL,
  `user_branch` varchar(3) NOT NULL,
  `user_roll_number` int(10) NOT NULL,
  `user_email` varchar(1024) NOT NULL,
  `user_email_code` varchar(32) NOT NULL,
  `user_allow_email` int(1) NOT NULL DEFAULT '1',
  `user_joining_date` datetime NOT NULL,
  `user_type` int(1) NOT NULL DEFAULT '0',
  `user_active_status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;
--
-- Indexes for dumped tables
--
--
-- Indexes for table `users`
--
ALTER TABLE `users` ADD PRIMARY KEY (`user_id`) ;
--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users` MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT ;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */ ;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */ ;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */ ;
