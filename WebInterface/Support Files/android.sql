-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2015 at 09:27 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `android`
--
CREATE DATABASE IF NOT EXISTS `android` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `android`;

-- --------------------------------------------------------

--
-- Table structure for table `anonymous`
--

DROP TABLE IF EXISTS `anonymous`;
CREATE TABLE IF NOT EXISTS `anonymous` (
  `testID` int(6) DEFAULT NULL,
  `qID` int(6) DEFAULT NULL,
  `answer` varchar(50) DEFAULT NULL,
  KEY `testID` (`testID`),
  KEY `qID` (`qID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `pageID` int(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `coursename` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`username`,`coursename`),
  UNIQUE KEY `pageID` (`pageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`pageID`, `username`, `coursename`) VALUES
(37, 'lkamath', 'CSC500');

-- --------------------------------------------------------

--
-- Table structure for table `enroll`
--

DROP TABLE IF EXISTS `enroll`;
CREATE TABLE IF NOT EXISTS `enroll` (
  `studentID` varchar(20) NOT NULL DEFAULT '',
  `pageID` int(6) DEFAULT NULL,
  `termID` int(6) NOT NULL DEFAULT '0',
  `coursename` varchar(50) NOT NULL,
  PRIMARY KEY (`studentID`,`termID`),
  KEY `pageID` (`pageID`),
  KEY `termID` (`termID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enroll`
--

INSERT INTO `enroll` (`studentID`, `pageID`, `termID`, `coursename`) VALUES
('200061365', 37, 20, 'CSC500'),
('200061366', 37, 20, 'CSC500');

-- --------------------------------------------------------

--
-- Table structure for table `passcode`
--

DROP TABLE IF EXISTS `passcode`;
CREATE TABLE IF NOT EXISTS `passcode` (
  `passcode` varchar(50) NOT NULL,
  UNIQUE KEY `passcode` (`passcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `passcode`
--

INSERT INTO `passcode` (`passcode`) VALUES
('passcode');

-- --------------------------------------------------------

--
-- Table structure for table `question_pool`
--

DROP TABLE IF EXISTS `question_pool`;
CREATE TABLE IF NOT EXISTS `question_pool` (
  `testID` int(6) DEFAULT NULL,
  `qID` int(6) NOT NULL AUTO_INCREMENT,
  `question_type` varchar(50) DEFAULT NULL,
  `question` varchar(2000) DEFAULT NULL,
  `weight` int(6) DEFAULT NULL,
  `A` varchar(50) DEFAULT NULL,
  `B` varchar(50) DEFAULT NULL,
  `C` varchar(50) DEFAULT NULL,
  `D` varchar(50) DEFAULT NULL,
  `answer` varchar(50) DEFAULT NULL,
  `state` int(50) NOT NULL DEFAULT '0',
  UNIQUE KEY `qID` (`qID`),
  KEY `testID` (`testID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2470 ;

--
-- Dumping data for table `question_pool`
--

INSERT INTO `question_pool` (`testID`, `qID`, `question_type`, `question`, `weight`, `A`, `B`, `C`, `D`, `answer`, `state`) VALUES
(10004, 2468, 'multiChoice', 'hsfsdf', 10, 'a', 's', 'c', 'd', '1', 0),
(10005, 2469, 'trueFalse', 'tf', 1, 'True', 'False', '', '', 'True', 0);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

DROP TABLE IF EXISTS `results`;
CREATE TABLE IF NOT EXISTS `results` (
  `studentID` varchar(20) DEFAULT NULL,
  `testID` int(6) DEFAULT NULL,
  `score` int(6) DEFAULT NULL,
  UNIQUE KEY `studentID` (`studentID`),
  KEY `testID` (`testID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`studentID`, `testID`, `score`) VALUES
('200061365', 10004, 10),
('200061366', 10004, 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `studentID` varchar(20) NOT NULL DEFAULT '',
  `firstName` varchar(20) DEFAULT NULL,
  `lastName` varchar(20) DEFAULT NULL,
  `password` varchar(75) DEFAULT NULL,
  `securityQuestion` varchar(50) DEFAULT NULL,
  `securityAnswer` varchar(20) DEFAULT NULL,
  `unityId` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`studentID`),
  UNIQUE KEY `unityId` (`unityId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentID`, `firstName`, `lastName`, `password`, `securityQuestion`, `securityAnswer`, `unityId`) VALUES
('200061365', 'asdasdasd', 'asd', 'asdasdsdsdsd', 'asd', 'ads', 'sdd'),
('200061366', 'lucky', 'kamath', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'born', 'mangalore', 'lkamath');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

DROP TABLE IF EXISTS `terms`;
CREATE TABLE IF NOT EXISTS `terms` (
  `pageID` int(6) NOT NULL DEFAULT '0',
  `termID` int(6) NOT NULL AUTO_INCREMENT,
  `term` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pageID`,`term`),
  UNIQUE KEY `termID` (`termID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`pageID`, `termID`, `term`) VALUES
(37, 20, 'Fall2015');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `termID` int(6) NOT NULL DEFAULT '0',
  `testName` varchar(50) NOT NULL DEFAULT '',
  `testID` int(6) NOT NULL AUTO_INCREMENT,
  `testType` varchar(50) DEFAULT NULL,
  `pageID` int(6) DEFAULT NULL,
  PRIMARY KEY (`termID`,`testName`),
  UNIQUE KEY `testID` (`testID`),
  KEY `pageID` (`pageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10006 ;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`termID`, `testName`, `testID`, `testType`, `pageID`) VALUES
(20, 'A1', 10005, 'anonymous', 37),
(20, 'Test1', 10004, 'graded', 37);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(200) DEFAULT NULL,
  `question` varchar(50) DEFAULT NULL,
  `answer` varchar(50) DEFAULT NULL,
  `emailID` varchar(50) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`first_name`, `last_name`, `username`, `password`, `question`, `answer`, `emailID`) VALUES
('Lakshminarayan', 'Kamath', 'lkamath', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'birth place', 'mangalore', 'lkamath@ncsu.edu');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anonymous`
--
ALTER TABLE `anonymous`
  ADD CONSTRAINT `anonymous_ibfk_1` FOREIGN KEY (`testID`) REFERENCES `question_pool` (`testID`) ON DELETE CASCADE,
  ADD CONSTRAINT `anonymous_ibfk_2` FOREIGN KEY (`qID`) REFERENCES `question_pool` (`qID`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `enroll`
--
ALTER TABLE `enroll`
  ADD CONSTRAINT `enroll_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_ibfk_2` FOREIGN KEY (`pageID`) REFERENCES `terms` (`pageID`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_ibfk_3` FOREIGN KEY (`termID`) REFERENCES `terms` (`termID`) ON DELETE CASCADE;

--
-- Constraints for table `question_pool`
--
ALTER TABLE `question_pool`
  ADD CONSTRAINT `question_pool_ibfk_1` FOREIGN KEY (`testID`) REFERENCES `test` (`testID`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`testID`) REFERENCES `question_pool` (`testID`) ON DELETE CASCADE;

--
-- Constraints for table `terms`
--
ALTER TABLE `terms`
  ADD CONSTRAINT `terms_ibfk_1` FOREIGN KEY (`pageID`) REFERENCES `courses` (`pageID`) ON DELETE CASCADE;

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`termID`) REFERENCES `terms` (`termID`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_ibfk_2` FOREIGN KEY (`pageID`) REFERENCES `courses` (`pageID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
