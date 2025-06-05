-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2025 at 07:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cils`
--

-- --------------------------------------------------------

--
-- Table structure for table `create_sched`
--

CREATE TABLE `create_sched` (
  `sched_id` int(2) NOT NULL,
  `purpose` varchar(30) NOT NULL,
  `sem` varchar(30) NOT NULL,
  `program` varchar(25) NOT NULL,
  `level` varchar(30) NOT NULL,
  `section` varchar(15) NOT NULL,
  `course_code` varchar(7) NOT NULL,
  `course_desc` varchar(50) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `repeat_sched` varchar(80) NOT NULL,
  `recurrence_type` text NOT NULL,
  `faculty` varchar(30) NOT NULL,
  `status` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `create_sched`
--

INSERT INTO `create_sched` (`sched_id`, `purpose`, `sem`, `program`, `level`, `section`, `course_code`, `course_desc`, `start_time`, `end_time`, `start_date`, `end_date`, `repeat_sched`, `recurrence_type`, `faculty`, `status`) VALUES
(74, 'CLASS', 'SECOND SEMESTER', 'INFORMATION TECHNOLOGY', 'THIRD YEAR', 'IT 3-1', 'FRE104', 'ADVANCED MULTIMEDIA SYSTEMS', '14:12:00', '14:15:00', '2025-05-23', '2025-05-24', 'Friday,Saturday', 'WEEKLY', 'PROF. EMELINE SUNGA', 'UPCOMING'),
(75, 'CLASS', 'SECOND SEMESTER', 'INFORMATION TECHNOLOGY', 'SECOND YEAR', 'IT2-1', 'CCS301', 'OBJECT ORIENTED PROGRAMMING 2', '09:06:00', '09:07:00', '2025-05-23', '2025-05-23', '', 'ONETIME', 'PROF. EMELINE SUNGA', 'ONGOING'),
(76, 'CLASS', 'FIRST SEMESTER', 'COMPUTER SCIENCE', 'THIRD YEAR', 'CS 3-1', 'CCS412', 'AUTOMATA AND COMPUTABILITY', '15:15:00', '17:15:00', '2025-05-24', '2025-05-24', '', 'ONETIME', 'ENGR. NINA CIELA FLORENTINO', 'UPCOMING'),
(77, 'CLASS', 'SECOND SEMESTER', 'INFORMATION TECHNOLOGY', 'THIRD YEAR', 'IT3-1', 'CCS214', 'SYSTEM ARCHITECTURE AND INTEGRATION', '14:25:00', '14:30:00', '2025-05-23', '2025-05-23', 'Friday', 'WEEKLY', 'ENGR. NINA CIELA FLORENTINO', 'UPCOMING');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `create_sched`
--
ALTER TABLE `create_sched`
  ADD PRIMARY KEY (`sched_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `create_sched`
--
ALTER TABLE `create_sched`
  MODIFY `sched_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
