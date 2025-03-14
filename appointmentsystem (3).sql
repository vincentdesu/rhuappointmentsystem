-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2025 at 03:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
  `username` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `service` varchar(50) NOT NULL,
  `schedule_date` date NOT NULL,
  `time_slot` varchar(20) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Waiting',
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `username`, `contact`, `fullname`, `service`, `schedule_date`, `time_slot`, `reason`, `code`, `status`, `type`) VALUES
(42, 'testlangs', '09103764645', 'Vincent Dela Cruz', 'dentalcares', '2025-03-13', '9', 'Hi', 'UI8P0ASYFH', 'Cancelled', 'online'),
(43, 'testlangs', '09760268903', 'Vincent Dela Cruz', 'dentalcares', '2025-03-13', '9', 'asdasdsad', 'QB3IPS8LVA', 'Cancelled', 'online'),
(45, '', '09526350634', 'Vincent Dela Cruz', 'checkup', '2025-03-14', '9', 'gff', 'FGUE33T4QP', 'Completed', 'kiosk'),
(46, 'admin', '2147483647', 'Vincent Dela Cruz', 'checkup', '2025-03-14', '9', 'gugweygweruwe', 'KAD4T1Q6AS', 'Cancelled', 'online'),
(47, '', '9318097798', 'allen', 'checkup', '2025-03-14', '10', 'paturok buldit', 'UO4728TYS3', 'Completed', 'kiosk');

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
(6, 'General Checkup', 'Available', 'Dr. Smith'),
(7, 'Dental Consultation', 'Available', 'Dr. Brown'),
(9, 'Eye Checkup', 'Available', 'Dr. Adams'),
(10, 'Cardiology Consultation', 'Not Available', 'Dr. Johnson'),
(11, 'asdasda', 'Available', 'Dr. Deez');

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
(1, 'Check up', 'Monday to Fridayy'),
(2, 'Animal Bite', 'Monday to Friday'),
(3, 'Dental Cares', 'Monday, Wednesday, Friday');

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
(8, 'animalbites', '2025-02-18', '4', 1, 20),
(10, 'checkup', '2025-03-09', '9', 0, 100),
(11, 'dentalcares', '2025-03-09', '9', 0, 100),
(12, 'checkup', '2025-03-11', '9', 0, 20),
(13, 'checkup', '2025-03-12', '9', 1, 19),
(14, 'checkup', '2025-03-13', '9', 10, 10),
(15, 'checkup', '2025-03-14', '9', 5, 20),
(16, 'dentalcares', '2025-03-13', '9', 2, 20),
(17, 'checkup', '2025-03-19', '10', 1, 100);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `dateofbirth` date NOT NULL,
  `age` int(11) NOT NULL,
  `placeofbirth` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `parent` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fileid` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `date`, `lastname`, `firstname`, `middlename`, `dateofbirth`, `age`, `placeofbirth`, `address`, `occupation`, `parent`, `contact`, `username`, `password`, `fileid`, `status`, `type`) VALUES
(1, '2025-03-08 20:51:23', 'Dela Cruz', 'Vincent', 'Dayrit', '2003-03-05', 22, 'Tarlac', '123', 'None', 'APOSDJAOPd', '2147483647', 'admin', '123', '3c0f81ab6913eac3da0e5db3cd1fddf5.jpg', 'approved', ''),
(2, '2025-03-08 20:51:23', 'asdklas', 'askdjasdasdas', 'qweqwe', '2025-03-06', 69, 'asdasdas', 'asd', 'asdasd', 'asdasd', '123123', 'qwe', 'qwe', '481026527_979548090808109_3505111162577816684_n.jpg', 'pending', ''),
(3, '2025-03-08 20:51:23', 'aadsqqw', 'qweqwe', 'qweqwe', '2025-03-20', 23, 'aisjdaoisjd', 'oaisjdoi', 'oajsdioj', 'oajsdoij', '298329', 'lul', '1234', '', 'pending', ''),
(4, '2025-03-08 20:51:23', 'nkayama', 'bitch', 'gay', '2025-03-13', 69, 'kjasdkjashdkj', 'japanese', 'whore', 'asdjasidjo', '69420', 'niggayama', '1234', NULL, 'pending', ''),
(5, '2025-03-08 20:51:23', 'aisji', 'oasijdio', 'oasjdoi', '0063-02-07', 8378, 'ausdausidy', 'iudyiu', 'sydiu', 'sdi', '0', 'ysduiy', 'siudy', NULL, 'pending', ''),
(6, '2025-03-08 20:51:23', 'sdfjsoij', 'oidjaosdj', 'oasjdoiasjdio', '2025-04-01', 89, 'asdoij', 'oijasodijiasd', 'oiajsdoiajsod', 'oaisjdoiasjdi', '1283728', 'jasd', '1234', 'admin/uploads/1740890828_481866275_1689502568440345_3249706558642356255_n.jpg', 'pending', ''),
(7, '2025-03-08 20:51:23', 'askdji', 'iajsdi', 'iajsdijas', '0007-03-28', 23, 'aisjdio', 'oijsdioj', 'odjsoijd', 'oisjod', '82378', 'oaisjdoiasd', '2837', '480009532_549863638106222_5785755104063048587_n.jpg', 'pending', ''),
(9, '2025-03-08 20:52:17', 'adasd', 'asdad', 'qweqwe', '1994-02-23', 23, 'werwer', 'werwer', 'werwer', 'werwer', '234234', 'test2', '1234', 'image-removebg-preview (1).png', 'approved', ''),
(10, '2025-03-11 10:28:53', 'Mama', 'Joe', '\'s', '6969-09-06', 69, '69 Island', '69 VIlle', 'sixtyniner', 'Joe Mama', '2147483647', '69MAN', '69', 'Screenshot 2025-03-09 193709.png', 'pending', ''),
(11, '2025-03-12 11:59:07', '1111', '23123213', '12312312', '0000-00-00', 2147483647, 'fnksbfsabjfsabjhbajd', 'fkbjhfbashjh24b', 'nojob', 'asdjasjdhgajhdvasj', '324234234', '1', '1', 'image-removebg-preview (1).png', 'approved', ''),
(12, '2025-03-12 13:23:09', '', '', '', '0000-00-00', 0, '', '', '', '', '0', '', '2', NULL, 'approved', ''),
(13, '2025-03-13 19:45:51', 'Dela Cruz', 'Vincent', 'Dayrit', '2003-03-05', 22, 'Tarlac', 'San Jose', 'Student', 'Hehe', '2147483647', 'testlangs', '12345678', 'image-removebg-preview.png', 'approved', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `available_services`
--
ALTER TABLE `available_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `slots`
--
ALTER TABLE `slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `update_status_event` ON SCHEDULE EVERY 1 HOUR STARTS '2025-03-14 22:11:43' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE appointments 
SET status = 'Cancelled' 
WHERE schedule_date < NOW() AND status = 'Waiting'$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
