-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2022 at 10:29 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbsmartattendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `last_login_date` date DEFAULT NULL,
  `deleteable` tinyint(1) NOT NULL DEFAULT 1,
  `add_member` tinyint(1) NOT NULL DEFAULT 0,
  `update_member` tinyint(1) NOT NULL DEFAULT 0,
  `delete_member` tinyint(1) NOT NULL DEFAULT 0,
  `add_department` tinyint(1) NOT NULL DEFAULT 0,
  `update_department` tinyint(1) NOT NULL DEFAULT 0,
  `delete_department` tinyint(1) NOT NULL DEFAULT 0,
  `update_attendance` tinyint(1) NOT NULL DEFAULT 0,
  `delete_attendance` tinyint(1) NOT NULL DEFAULT 0,
  `bulk_timeout` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(20) NOT NULL,
  `member_id` int(11) NOT NULL,
  `pod_ME` varchar(3) NOT NULL,
  `date` date NOT NULL,
  `timeIn` time NOT NULL,
  `timeOut` time DEFAULT NULL,
  `timeIn_MA` varchar(1) NOT NULL,
  `timeOut_MA` varchar(1) DEFAULT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(50) NOT NULL,
  `dept_head_name` varchar(50) NOT NULL,
  `dept_area` varchar(25) NOT NULL,
  `dept_location` varchar(100) NOT NULL,
  `dept_phone` varchar(15) DEFAULT NULL,
  `dept_comment` varchar(100) DEFAULT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(20) NOT NULL,
  `updated_date` date NOT NULL DEFAULT current_timestamp(),
  `updated_by` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `formid_number` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `firstname` varchar(15) NOT NULL,
  `lastname` varchar(15) NOT NULL,
  `email` varchar(25) DEFAULT NULL,
  `contact_number` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `cnic` varchar(15) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `marital_status` varchar(10) NOT NULL,
  `doj` date NOT NULL,
  `position` varchar(15) NOT NULL,
  `city` varchar(15) NOT NULL,
  `country` varchar(15) NOT NULL,
  `myaddress` varchar(100) NOT NULL,
  `member_qr` varchar(80) NOT NULL,
  `image_file` blob DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `leaving_date` date DEFAULT NULL,
  `purpose_leaving` varchar(100) DEFAULT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(20) NOT NULL,
  `updated_date` date NOT NULL DEFAULT current_timestamp(),
  `updated_by` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
