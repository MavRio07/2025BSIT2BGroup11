-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2025 at 06:25 PM
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
-- Database: `mywebsite_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` varchar(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
('admin_id1', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `emergencies`
--

CREATE TABLE `emergencies` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `help_level` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergencies`
--

INSERT INTO `emergencies` (`id`, `user_id`, `help_level`, `location`, `description`, `time`, `status`) VALUES
(1, 0, 'high', 'bacolod', 'idk trippings', '2025-11-13 14:47:38', ''),
(2, 0, 'critical', 'deca homes', 'ari kodi gali subong sa ano te ano bala haw daw ka budlay', '2025-11-13 15:14:29', ''),
(3, 0, 'medium', 'asdasdasdad', 'asdvasdyuguysdvyuasvduyasvduyasd', '2025-11-13 15:48:39', ''),
(4, 0, 'medium', 'asdasdasdasdasd', 'asdugasyuidgasuidgi', '2025-11-13 15:55:59', ''),
(5, 0, 'medium', 'sadasduavu', 'uiasbdiasubdiuasbdiubasd', '2025-11-13 15:56:21', ''),
(6, 0, 'medium', 'Bacolod', 'idk trippings lang e', '2025-11-13 16:05:49', ''),
(7, 0, 'medium', 'asdasdas', 'asdasdasdasd', '2025-11-13 16:08:13', ''),
(8, 0, 'medium', 'asdasdasdasd', 'asdsadasdasdasd', '2025-11-13 16:08:46', ''),
(9, 2, 'critical', 'asdasdasdasd', 'asuydgasyudguyasdgasasdasdasdasdasd', '2025-11-13 16:13:48', ''),
(11, 3, 'medium', 'ako gali si', 'asodnoasdn', '2025-11-13 17:15:32', ''),
(12, 5, 'medium', 'i need mana', 'iasbdiasbdiasbdiua', '2025-11-13 18:13:19', '');

-- --------------------------------------------------------

--
-- Table structure for table `markers`
--

CREATE TABLE `markers` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` enum('police','shelter','support') NOT NULL DEFAULT 'support',
  `lat` decimal(10,6) NOT NULL,
  `lng` decimal(10,6) NOT NULL,
  `address` varchar(300) DEFAULT '',
  `phone` varchar(50) DEFAULT '',
  `description` varchar(500) DEFAULT '',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `markers`
--

INSERT INTO `markers` (`id`, `name`, `type`, `lat`, `lng`, `address`, `phone`, `description`, `created_at`) VALUES
(6, 'Bacolod City Police Office', 'police', 10.676500, 122.951100, 'Bacolod City Police Office, Bacolod City, Negros Occidental', '034-435-1234', 'Main police station of Bacolod City', '2025-11-13 22:46:17'),
(7, 'PNP Women & Children Center', 'police', 10.679000, 122.950000, 'Brgy. 2, Bacolod City, Negros Occidental', '034-435-5678', 'Focus on women and children safety', '2025-11-13 22:46:17'),
(8, 'Bacolod Traffic Police Station', 'police', 10.674500, 122.953500, 'Bacolod City, Negros Occidental', '034-435-9101', 'Traffic management and assistance', '2025-11-13 22:46:17'),
(9, 'Safe Haven Shelter', 'shelter', 10.678000, 122.953000, 'Brgy. 1, Bacolod City, Negros Occidental', '0917-123-4567', 'Temporary shelter for victims of violence and disasters', '2025-11-13 22:46:17'),
(10, 'Youth Care Shelter', 'shelter', 10.672500, 122.949000, 'Brgy. 3, Bacolod City, Negros Occidental', '0917-987-6543', 'Shelter for at-risk youth', '2025-11-13 22:46:17'),
(11, 'Women\'s Support Center', 'support', 10.674000, 122.949000, 'Brgy. 4, Bacolod City, Negros Occidental', '0917-555-1111', 'Provides counseling and support for women', '2025-11-13 22:46:17'),
(12, 'Mental Health Helpline', 'support', 10.679500, 122.952500, 'Bacolod City, Negros Occidental', '0917-555-2222', 'Confidential mental health support', '2025-11-13 22:46:17'),
(13, 'Emergency Hotlines', 'support', 10.677000, 122.955000, 'Bacolod City, Negros Occidental', '911', 'Immediate emergency assistance', '2025-11-13 22:46:17'),
(14, 'Barangay Assistance Center', 'support', 10.680000, 122.956000, 'Multiple barangays, Bacolod City, Negros Occidental', '034-435-3333', 'Local government support and assistance', '2025-11-13 22:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Age` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `Age`, `Email`) VALUES
(1, 'John', '', 'johndoe@gmail.com'),
(2, 'Reign', '', 'Reign@gmail.com'),
(5, 'akosi', '', 'dogie@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `emergencies`
--
ALTER TABLE `emergencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emergencies`
--
ALTER TABLE `emergencies`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
