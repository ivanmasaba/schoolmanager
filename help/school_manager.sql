-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2022 at 06:35 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `when` date NOT NULL,
  `content` text NOT NULL,
  `operation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `reg_num` int(11) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` varchar(30) NOT NULL,
  `change_details` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`reg_num`, `uname`, `password`, `level`, `change_details`) VALUES
(2, 'andy', '4321', 'admin', ''),
(3, 'mark', '1000', 'student', 'PERMITED');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `reg_num` int(11) NOT NULL,
  `subj_id` int(30) NOT NULL,
  `test_score` int(11) NOT NULL,
  `exam_score` int(11) NOT NULL,
  `total_score` int(11) NOT NULL,
  `grade` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`reg_num`, `subj_id`, `test_score`, `exam_score`, `total_score`, `grade`) VALUES
(3, 1, 40, 45, 85, 'B+'),
(3, 2, 35, 35, 70, 'C'),
(3, 3, 40, 45, 85, 'B+'),
(3, 4, 20, 48, 68, 'C-'),
(3, 5, 33, 40, 73, 'C'),
(3, 6, 42, 42, 84, 'B'),
(3, 7, 40, 48, 88, 'B+');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `reg_num` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `sname` varchar(50) NOT NULL,
  `class` varchar(50) NOT NULL,
  `stream` varchar(50) NOT NULL,
  `birth_date` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `fathers_name` varchar(50) NOT NULL,
  `mothers_name` varchar(50) NOT NULL,
  `parent_number` varchar(50) NOT NULL,
  `parent_address` varchar(50) NOT NULL,
  `illness` varchar(50) NOT NULL,
  `disability` varchar(50) NOT NULL,
  `others` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`reg_num`, `fname`, `sname`, `class`, `stream`, `birth_date`, `email`, `fathers_name`, `mothers_name`, `parent_number`, `parent_address`, `illness`, `disability`, `others`) VALUES
(3, 'mark', 'joel', 'S1', 'a', '1994-06-16', 'nondabashir@gmail.com', 'musimbi', 'steven', '0788720915', 'kampala', 'no', 'no', 'no'),
(3, 'mark', 'joel', 'S1', 'a', '1994-06-16', 'nondabashir@gmail.com', 'musimbi', 'steven', '0788720915', 'kampala', 'no', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(20) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `sname` varchar(50) NOT NULL,
  `birth_date` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `parent_number` varchar(30) NOT NULL,
  `parent_address` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_id`, `fname`, `sname`, `birth_date`, `email`, `parent_number`, `parent_address`) VALUES
(1, 'andy', 'andy', 'masso', '2022-05-06', 'andymasso@yahoo.com', '0702049096', 'kampala');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subj_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subj_name`) VALUES
(1, 'English'),
(2, 'Mathematics'),
(3, 'Chemistry'),
(4, 'Biology'),
(5, 'Physics'),
(6, 'Geography'),
(7, 'History');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`reg_num`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD KEY `subj_id` (`subj_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `reg_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`subj_id`) REFERENCES `subjects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
