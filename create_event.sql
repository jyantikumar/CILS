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
-- Table structure for table `create_event`
--

CREATE TABLE `create_event` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(40) NOT NULL,
  `eStart_time` time NOT NULL,
  `eEnd_time` time NOT NULL,
  `eStart_date` date NOT NULL,
  `eEnd_date` date NOT NULL,
  `repeat_sched` varchar(70) NOT NULL,
  `recurrence_type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `create_event`
--

INSERT INTO `create_event` (`event_id`, `event_name`, `eStart_time`, `eEnd_time`, `eStart_date`, `eEnd_date`, `repeat_sched`, `recurrence_type`, `status`) VALUES
(16, 'TEST ULIT', '16:50:00', '16:51:00', '2025-04-22', '2025-04-22', 'Tuesday,Thursday', 'WEEKLY', 'UPCOMING'),
(17, 'TEST ULIT', '15:00:00', '16:01:00', '2025-04-24', '2025-04-24', 'Tuesday,Thursday', 'WEEKLY', 'UPCOMING'),
(19, 'TRY', '17:17:00', '17:18:00', '2025-04-27', '2025-04-27', '', 'WEEKLY', 'UPCOMING'),
(20, 'TRY', '21:00:00', '22:00:00', '2025-04-23', '2025-04-23', 'Wednesday,Thursday', 'WEEKLY', 'UPCOMING'),
(21, 'TRY', '21:00:00', '22:00:00', '2025-04-24', '2025-04-24', 'Wednesday,Thursday', 'WEEKLY', 'UPCOMING');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `create_event`
--
ALTER TABLE `create_event`
  ADD PRIMARY KEY (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `create_event`
--
ALTER TABLE `create_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
