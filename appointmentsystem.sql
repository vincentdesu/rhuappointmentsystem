-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2025 at 06:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appointmentsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `service` varchar(50) NOT NULL,
  `schedule_date` date NOT NULL,
  `time_slot` varchar(20) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `service`, `schedule_date`, `time_slot`, `reason`, `code`, `status`) VALUES
(9, 'checkup', '2025-02-25', '9', 'asdasd23e', 'H7F3CHC4FP', 'waiting'),
(10, 'checkup', '2025-02-25', '9', 'ASDHOAISHD', 'SXWIWPI4H1', 'waiting');

-- --------------------------------------------------------

--
-- Table structure for table `available_services`
--

CREATE TABLE `available_services` (
  `id` int(11) NOT NULL,
  `services` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `doc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `available_services`
--

INSERT INTO `available_services` (`id`, `services`, `status`, `doc`) VALUES
(1, 'Checkup', 'active', 'Dr. Santos'),
(2, 'Dental Care', 'active', 'Dr. Reyes'),
(3, 'Animal Bites', 'inactive', 'Dr. Cruz'),
(4, 'Pediatric Consultation', 'active', 'Dr. Dela Rosa'),
(5, 'General Surgery', 'inactive', 'Dr. Villanueva');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `services` varchar(255) NOT NULL,
  `sched` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `services`, `sched`) VALUES
(1, 'Check up', 'Monday to Friday'),
(2, 'Animal Bite', 'Monday to Friday'),
(3, 'Dental Cares', 'Monday, Wednesday, Friday'),
(4, 'TB Dots', 'Fridays');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service`) VALUES
(1, 'Check up'),
(2, 'Medical Certificate'),
(3, 'Free Medicines'),
(4, 'TB Dots'),
(5, 'Family Planning'),
(6, 'Dental Cares'),
(7, 'Animal Bites'),
(8, 'Blood Chem'),
(9, 'Urinalysis');

-- --------------------------------------------------------

--
-- Table structure for table `slots`
--

CREATE TABLE `slots` (
  `id` int(11) NOT NULL,
  `service` varchar(50) NOT NULL,
  `schedule_date` date NOT NULL,
  `time_slot` varchar(20) NOT NULL,
  `booked_count` int(11) DEFAULT 0,
  `total_slots` int(11) DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slots`
--

INSERT INTO `slots` (`id`, `service`, `schedule_date`, `time_slot`, `booked_count`, `total_slots`) VALUES
(1, 'checkup', '2025-02-25', '9', 5, 20),
(2, 'checkup', '2025-02-25', '10', 2, 20),
(3, 'dentalcares', '2025-02-28', '2', 3, 20),
(4, 'animalbites', '2025-02-18', '4', 1, 20),
(5, 'checkup', '2025-02-18', '9', 5, 20),
(6, 'checkup', '2025-02-18', '10', 2, 20),
(7, 'dentalcares', '2025-02-18', '2', 3, 20),
(8, 'animalbites', '2025-02-18', '4', 1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `dateofbirth` date NOT NULL,
  `age` int(11) NOT NULL,
  `placeofbirth` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `parent` varchar(255) NOT NULL,
  `contact` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fileid` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `middlename`, `dateofbirth`, `age`, `placeofbirth`, `address`, `occupation`, `parent`, `contact`, `username`, `password`, `fileid`, `status`) VALUES
(1, 'Dela Cruz', 'Vincent', 'Dayrit', '2003-03-05', 21, 'Tarlac', 'San Jose Concepcion Tarlac', 'Student', 'ASDASDASD', 129381293, 'admin', '1234', '3c0f81ab6913eac3da0e5db3cd1fddf5.jpg', 'pending'),
(2, 'asdklas', 'askdjasdasdas', 'qweqwe', '2025-03-06', 69, 'asdasdas', 'asd', 'asdasd', 'asdasd', 123123, 'qwe', 'qwe', '481026527_979548090808109_3505111162577816684_n.jpg', 'pending'),
(3, 'aadsqqw', 'qweqwe', 'qweqwe', '2025-03-20', 23, 'aisjdaoisjd', 'oaisjdoi', 'oajsdioj', 'oajsdoij', 298329, 'lul', '1234', '', 'pending'),
(4, 'nkayama', 'bitch', 'gay', '2025-03-13', 69, 'kjasdkjashdkj', 'japanese', 'whore', 'asdjasidjo', 69420, 'niggayama', '1234', NULL, 'pending'),
(5, 'aisji', 'oasijdio', 'oasjdoi', '0063-02-07', 8378, 'ausdausidy', 'iudyiu', 'sydiu', 'sdi', 0, 'ysduiy', 'siudy', NULL, 'pending'),
(6, 'sdfjsoij', 'oidjaosdj', 'oasjdoiasjdio', '2025-04-01', 89, 'asdoij', 'oijasodijiasd', 'oiajsdoiajsod', 'oaisjdoiasjdi', 1283728, 'jasd', '1234', 'admin/uploads/1740890828_481866275_1689502568440345_3249706558642356255_n.jpg', 'pending'),
(7, 'askdji', 'iajsdi', 'iajsdijas', '0007-03-28', 23, 'aisjdio', 'oijsdioj', 'odjsoijd', 'oisjod', 82378, 'oaisjdoiasd', '2837', '480009532_549863638106222_5785755104063048587_n.jpg', 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `available_services`
--
ALTER TABLE `available_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slots`
--
ALTER TABLE `slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `available_services`
--
ALTER TABLE `available_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `slots`
--
ALTER TABLE `slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
