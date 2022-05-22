-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2022 at 07:29 PM
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
(1, 'ivan', '9999', 'teacher', ''),
(2, 'andy', '4321', 'admin', ''),
(3, 'mark', '1000', 'student', 'PERMITED'),
(4, 'musamali', '1', 'student', 'PERMITED'),
(5, 'john', '111', 'student', ''),
(6, 'fred', '3', 'student', ''),
(7, 'benard', '4', 'student', ''),
(8, 'william', '2', 'student', '');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
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

INSERT INTO `marks` (`id`, `reg_num`, `subj_id`, `test_score`, `exam_score`, `total_score`, `grade`) VALUES
(1, 3, 1, 48, 45, 93, 'B+'),
(2, 3, 2, 35, 35, 70, 'C'),
(3, 3, 3, 40, 45, 85, 'B+'),
(4, 3, 4, 20, 48, 68, 'C-'),
(5, 3, 5, 33, 40, 73, 'C'),
(6, 3, 6, 42, 42, 84, 'B'),
(7, 3, 7, 40, 48, 88, 'B+'),
(8, 4, 1, 28, 44, 72, 'C'),
(9, 4, 2, 23, 44, 67, 'F'),
(10, 4, 3, 23, 44, 67, 'F'),
(11, 4, 4, 23, 44, 67, 'C-'),
(12, 4, 5, 23, 44, 67, 'B'),
(13, 4, 6, 23, 44, 67, 'B'),
(14, 4, 7, 23, 44, 67, 'A'),
(16, 6, 1, 0, 0, 0, 'F'),
(17, 6, 2, 0, 0, 0, 'F'),
(18, 6, 3, 0, 0, 0, 'F'),
(19, 6, 4, 0, 0, 0, 'F'),
(20, 6, 5, 0, 0, 0, 'F'),
(21, 6, 6, 0, 0, 0, 'F'),
(22, 6, 7, 0, 0, 0, 'F'),
(23, 7, 1, 0, 0, 0, 'F'),
(24, 7, 2, 0, 0, 0, 'F'),
(25, 7, 3, 0, 0, 0, 'F'),
(26, 7, 4, 0, 0, 0, 'F'),
(27, 7, 5, 0, 0, 0, 'F'),
(28, 7, 6, 0, 0, 0, 'F'),
(29, 7, 7, 0, 0, 0, 'F'),
(30, 8, 1, 50, 50, 100, 'F'),
(31, 8, 2, 0, 0, 0, 'F'),
(32, 8, 3, 0, 0, 0, 'F'),
(33, 8, 4, 0, 0, 0, 'F'),
(34, 8, 5, 0, 0, 0, 'F'),
(35, 8, 6, 0, 0, 0, 'F'),
(36, 8, 7, 0, 0, 0, 'F');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
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

INSERT INTO `registration` (`id`, `reg_num`, `fname`, `sname`, `class`, `stream`, `birth_date`, `email`, `fathers_name`, `mothers_name`, `parent_number`, `parent_address`, `illness`, `disability`, `others`) VALUES
(1, 3, 'mark', 'joel', 'senior one', 'a', '1994-06-16', 'nondabashir@gmail.com', 'musimbi', 'steven', '0788720915', 'kampala', 'no', 'no', 'no'),
(3, 4, 'musamali', 'derrick', 'senior one', 'a', '2022-05-12', 'derick@yahoo.com', 'musa', 'esther', '0771380954', 'mbale', 'no', 'no', 'no'),
(4, 5, 'john', 'godfrey', 'senior three', 'B', '2016-06-29', 'nondabashir@gmail.com', 'henry', 'esther', '0702049096', 'kampala', 'no', 'no', 'no'),
(5, 8, 'william', 'isaac', 'senior one', 'A', '2022-05-10', 'will@hotmail.com', 'henry', 'steven', '0788720915', 'kampala', 'no', 'no', 'no'),
(6, 6, 'fred', 'bill', 'senior one', 'A', '2022-06-01', 'andymasso@yahoo.com', 'musimbi', 'esther', '0702049096', 'kampala', 'no', 'no', 'no'),
(7, 7, 'benard', 'gregory', 'senior one', 'A', '2022-05-04', 'ben@yahoo.com', 'henry', 'steven', '0702049096', 'kampala', 'no', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(30) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subj_id` int(11) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `sname` varchar(30) NOT NULL,
  `birth_date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_id`, `class_id`, `subj_id`, `fname`, `sname`, `birth_date`, `email`, `phone`, `address`) VALUES
(12, 'ivan', 1, 1, 'ivan', 'masaba', '2010-10-05', 'ivanmasaba@gmail.com', '0778465853', 'kampala');

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
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`reg_num`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subj_id` (`subj_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `reg_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
