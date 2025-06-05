-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2025 at 07:32 AM
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
-- Table structure for table `announcement_tbl`
--

CREATE TABLE `announcement_tbl` (
  `ann_id` int(4) NOT NULL,
  `ann_title` varchar(50) NOT NULL,
  `ann_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ann_content` varchar(200) NOT NULL,
  `ann_start` date NOT NULL,
  `ann_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_tbl`
--

INSERT INTO `announcement_tbl` (`ann_id`, `ann_title`, `ann_timestamp`, `ann_content`, `ann_start`, `ann_end`) VALUES
(1, 'TESTTTT', '2025-04-26 13:04:16', 'hakbfaksjbajksbfaskfbaskbfakfabfakkjbjkkjbfsakfakfbaskfbakjfabkasbjkafbajkfbakjsbfkajbfkasbfkajjsbfakbfkasjbfkajsbfkasbfkafbkajbfkjasbfkajsbfkasjbaskjfaksjbfaksbkasjsbfkasjbasjkfbaksbfasjkfbskajfbaska', '2025-04-26', '2025-04-26'),
(2, 'AGAIN', '2025-04-28 07:45:46', 'akjsbafhahahahahahahhahhahhhhahahahahahahhahahahahahahahahhahhahhhahahahahahhhahahahahahahahahahahahahahaahakjsbafhahahahahahahhahhahhhhahahahahahahhahahahahahahahahhahhahhhahahahahahhhahahahahahahaha', '2025-04-20', '2025-04-27'),
(3, 'FACE TO FACE CLASSES', '2025-04-29 07:21:25', 'Classes will be face-to-face on April 30,2025.', '2025-04-29', '2025-04-30'),
(4, 'CAPSTONE DEFENSE', '2025-05-21 03:30:17', 'Capstone defense tomorrow\r\n', '2025-05-15', '2025-05-16'),
(5, 'LOREM IPSUM', '2025-05-23 05:46:41', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut a', '2025-05-23', '2025-05-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement_tbl`
--
ALTER TABLE `announcement_tbl`
  ADD PRIMARY KEY (`ann_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement_tbl`
--
ALTER TABLE `announcement_tbl`
  MODIFY `ann_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
