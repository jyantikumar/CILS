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
-- Table structure for table `faculty_tbl`
--

CREATE TABLE `faculty_tbl` (
  `faculty_id` int(11) NOT NULL,
  `faculty_name` varchar(30) NOT NULL,
  `faculty_email` varchar(70) NOT NULL,
  `faculty_status` text NOT NULL,
  `faculty_pass` varchar(30) NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_tbl`
--

INSERT INTO `faculty_tbl` (`faculty_id`, `faculty_name`, `faculty_email`, `faculty_status`, `faculty_pass`, `role`) VALUES
(14, 'ENGR. NINA CIELA FLORENTINO', 'NCFLORENTINO@FACULTY.MCU.EDU.PH', 'ACTIVE', 'ncflorentino', 'PROFESSOR'),
(15, 'PROF. EMELINE SUNGA', 'EGSUNGA@FACULTY.MCU.EDU.PH', 'ARCHIVED', 'egsungaaaa', 'PROFESSOR'),
(27, 'PROF. MARLYN BEUNDIA', 'MPBUENDIA@FACULTY.MCU.EDU.PH', 'ACTIVE', 'mpbuendia', 'PROFESSOR'),
(28, 'PROF. MICHELLE RAMOS', 'MCRAMOS@FACULTY.MCU.EDU.PH', 'ACTIVE', 'michelleramos', 'PROFESSOR');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faculty_tbl`
--
ALTER TABLE `faculty_tbl`
  ADD PRIMARY KEY (`faculty_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faculty_tbl`
--
ALTER TABLE `faculty_tbl`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
