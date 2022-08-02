-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 07, 2021 at 06:10 AM
-- Server version: 5.7.33
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cvsuc006_dbcontacttracinglgu1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_acct`
--

CREATE TABLE `tbl_acct` (
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `empno` varchar(255) NOT NULL,
  `position` int(2) NOT NULL,
  `campus` int(2) NOT NULL,
  `bday` date NOT NULL,
  `sex` varchar(1) NOT NULL,
  `address` varchar(255) NOT NULL,
  `allow` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_acct`
--

INSERT INTO `tbl_acct` (`user`, `pass`, `email`, `fullname`, `empno`, `position`, `campus`, `bday`, `sex`, `address`, `allow`) VALUES
('minlee', '3ec834bf31ccedf8384e454a97c20da0', 'maeignaco@cvsu.edu.ph', 'MARY ANN E. IGNACO', '2015-325', 1, 1, '1990-02-20', 'F', '152 PAG-ASA ST. BANCAAN, NAIC, CAVITE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_campus`
--

CREATE TABLE `tbl_campus` (
  `campno` int(2) NOT NULL,
  `campdesc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_campus`
--

INSERT INTO `tbl_campus` (`campno`, `campdesc`) VALUES
(9, 'CCAT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contracing`
--

CREATE TABLE `tbl_contracing` (
  `regid` varchar(255) NOT NULL,
  `hdate` date NOT NULL,
  `timein` time NOT NULL,
  `timeout` time NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_evaluation`
--

CREATE TABLE `tbl_evaluation` (
  `regid` varchar(255) NOT NULL,
  `fdate` date NOT NULL,
  `adate` date NOT NULL,
  `fpoints` int(1) NOT NULL,
  `feedback` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_healthsurvey`
--

CREATE TABLE `tbl_healthsurvey` (
  `regid` varchar(255) NOT NULL,
  `hdate` date NOT NULL,
  `temp` varchar(255) NOT NULL,
  `origin` varchar(255) NOT NULL,
  `cough` int(1) NOT NULL,
  `sore` int(1) NOT NULL,
  `breathing` int(1) NOT NULL,
  `diarrhea` int(1) NOT NULL,
  `bodypains` int(1) NOT NULL,
  `closeprox` int(1) NOT NULL,
  `travelled` int(1) NOT NULL,
  `agree` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

CREATE TABLE `tbl_location` (
  `locid` int(2) NOT NULL,
  `locdesc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_location`
--

INSERT INTO `tbl_location` (`locid`, `locdesc`) VALUES
(1, 'GATE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_position`
--

CREATE TABLE `tbl_position` (
  `posno` int(2) NOT NULL,
  `posdesc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_position`
--

INSERT INTO `tbl_position` (`posno`, `posdesc`) VALUES
(1, 'Admin'),
(2, 'University physician'),
(3, 'Technical'),
(4, 'Nurse'),
(5, 'Human resource management');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reg`
--

CREATE TABLE `tbl_reg` (
  `usertype` int(1) NOT NULL,
  `regid` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contactno` varchar(15) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `office` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usertype`
--

CREATE TABLE `tbl_usertype` (
  `userid` int(2) NOT NULL,
  `userdesc` varchar(255) NOT NULL,
  `userauto` int(1) NOT NULL,
  `userctr` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_usertype`
--

INSERT INTO `tbl_usertype` (`userid`, `userdesc`, `userauto`, `userctr`) VALUES
(1, 'Employee', 0, 0),
(2, 'Client', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_location`
--
ALTER TABLE `tbl_location`
  ADD PRIMARY KEY (`locid`);

--
-- Indexes for table `tbl_usertype`
--
ALTER TABLE `tbl_usertype`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_location`
--
ALTER TABLE `tbl_location`
  MODIFY `locid` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_usertype`
--
ALTER TABLE `tbl_usertype`
  MODIFY `userid` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
