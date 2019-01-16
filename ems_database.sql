-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2019 at 07:22 PM
-- Server version: 5.7.20-log
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `e_name` varchar(25) DEFAULT NULL,
  `e_code` varchar(45) NOT NULL,
  `examiner_id` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `examiner`
--

CREATE TABLE `examiner` (
  `examiner_id` varchar(128) NOT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `examiner`
--

INSERT INTO `examiner` (`examiner_id`, `full_name`, `username`) VALUES
('0a2a1719bf3ce682afdbedf3b23857818d526efbe7fcb372b31347c26239a0f916c398b7ad8dd0ee76e8e388604d0b0f925d5e913ad2d3165b9b35b3844cd5e6', 'Abdulwahab Alhendi', 'Admin_Abdulwahab');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `exam_code` varchar(45) NOT NULL,
  `question_id` varchar(25) NOT NULL,
  `question_body` varchar(500) NOT NULL,
  `answer1` varchar(45) DEFAULT NULL,
  `answer2` varchar(45) DEFAULT NULL,
  `answer3` varchar(45) DEFAULT NULL,
  `answer4` varchar(45) DEFAULT NULL,
  `correct_ans` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(128) NOT NULL,
  `f_name` varchar(45) DEFAULT NULL,
  `s_name` varchar(45) DEFAULT NULL,
  `l_name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `activated` varchar(10) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `take_exam`
--

CREATE TABLE `take_exam` (
  `student_id` varchar(128) NOT NULL,
  `exam_code` varchar(45) NOT NULL,
  `exam_score` int(11) NOT NULL,
  `max_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`e_code`),
  ADD KEY `fk_examniner_id` (`examiner_id`);

--
-- Indexes for table `examiner`
--
ALTER TABLE `examiner`
  ADD PRIMARY KEY (`examiner_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`,`exam_code`),
  ADD KEY `ecode_idx` (`exam_code`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `take_exam`
--
ALTER TABLE `take_exam`
  ADD PRIMARY KEY (`exam_code`,`student_id`) USING BTREE,
  ADD KEY `take_code_idx` (`exam_code`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `fk_examniner_id` FOREIGN KEY (`examiner_id`) REFERENCES `examiner` (`examiner_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `ecode` FOREIGN KEY (`exam_code`) REFERENCES `exam` (`e_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `take_exam`
--
ALTER TABLE `take_exam`
  ADD CONSTRAINT `take_code` FOREIGN KEY (`exam_code`) REFERENCES `exam` (`e_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
