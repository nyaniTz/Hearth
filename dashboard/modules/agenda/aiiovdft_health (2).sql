-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 04, 2023 at 06:27 PM
-- Server version: 10.3.38-MariaDB-log-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aiiovdft_health`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@health.aiiot.center', 'admin43210');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `doctor_id` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `service_description` text DEFAULT NULL,
  `appointment_status` enum('pending','confirmed','cancelled') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `doctor_id`, `appointment_date`, `appointment_time`, `service_type`, `service_description`, `appointment_status`, `created_at`) VALUES
(1, 'jsmith', 'D001', '2023-05-10', '09:00:00', 'checkup', 'routine checkup', 'confirmed', '2023-05-04 02:36:33'),
(2, 'P002', 'D001', '2023-05-11', '11:00:00', 'consultation', 'follow-up consultation', 'confirmed', '2023-05-04 02:36:33'),
(3, 'P003', 'D002', '2023-05-12', '14:30:00', 'procedure', 'tooth extraction', 'pending', '2023-05-04 02:36:33'),
(4, 'P004', 'D003', '2023-05-13', '16:00:00', 'checkup', 'annual checkup', 'confirmed', '2023-05-04 02:36:33'),
(5, 'P005', 'D002', '2023-05-14', '10:00:00', 'consultation', 'new patient consultation', 'cancelled', '2023-05-04 02:36:33');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(6) UNSIGNED NOT NULL,
  `user` varchar(30) NOT NULL,
  `mqttserver` varchar(50) NOT NULL,
  `mqttuser` varchar(30) NOT NULL,
  `mqttpass` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `user`, `mqttserver`, `mqttuser`, `mqttpass`) VALUES
(1, 'jsmith', 'mqtt.example.com', 'jsmith', 'password'),
(2, 'jdoe', 'mqtt.example.com', 'jdoe', 'password'),
(3, '20215449', 'mqtt.example.com', '20215449', 'Marvel16');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(5) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `age` int(2) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `specialty` varchar(250) NOT NULL DEFAULT 'General Medicine',
  `license` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `age`, `phone`, `specialty`, `license`, `gender`, `address`) VALUES
(1, 'ibrahim', 'hello123', 'Ibrahim', 'Ame', 'ame.ibrahim@yahoo.com', 55, '0777777777', 'General Medicine', '834738773', 'Male', '456 Road'),
(2, 'teyei', 'hello123', 'Teyei', '', '', 20, '0947583754', 'Physical Therapy', '7475836', 'Female', '456 Road Road'),
(3, 'mahmoud', 'hello123', 'Mahmoud', 'Abduswamad', '', 20, '03848465836', 'Ophthalmology', '57484637', 'Male', '475 Road Road');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `calendar_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `is_allday` tinyint(1) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `calendar_id`, `title`, `start_time`, `end_time`, `is_allday`, `category`, `user`) VALUES
(1, 1, 'Weekly Checkup', '2022-01-01 09:00:00', '2022-01-01 10:00:00', 0, 'health', 'jdoe'),
(2, 2, 'Dr. Ambedkar - Orthopaedic', '2022-01-02 13:00:00', '2022-01-02 19:00:00', 0, 'health', '20215449'),
(3, 3, 'Operation - ICU', '2022-10-08 00:00:00', '2022-10-08 23:59:59', 1, 'health', 'jsmith'),
(4, 1, 'Team Meeting', '2022-01-03 14:00:00', '2022-01-03 15:00:00', 0, 'work', 'jsmith');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `Ambulation` tinyint(1) NOT NULL DEFAULT 0,
  `BMI` decimal(4,1) NOT NULL,
  `Chills` tinyint(1) NOT NULL DEFAULT 0,
  `Contacts` varchar(255) NOT NULL,
  `DOB` date NOT NULL,
  `Email` varchar(255) NOT NULL,
  `DBP` int(11) NOT NULL,
  `DecreasedMood` tinyint(1) NOT NULL DEFAULT 0,
  `FiO2` int(11) NOT NULL,
  `GeneralizedFatigue` tinyint(1) NOT NULL DEFAULT 0,
  `HeartRate` int(11) NOT NULL,
  `HistoryFever` varchar(255) NOT NULL,
  `RR` int(11) NOT NULL,
  `RecentHospitalStay` date NOT NULL,
  `SBP` int(11) NOT NULL,
  `SpO2` int(11) NOT NULL,
  `Temp` int(11) NOT NULL,
  `WeightGain` int(11) NOT NULL DEFAULT 0,
  `WeightLoss` int(11) NOT NULL DEFAULT 0,
  `BGroup` varchar(255) NOT NULL,
  `Sex` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `latitude` varchar(100) NOT NULL DEFAULT '35.2157696',
  `longitude` varchar(100) NOT NULL DEFAULT '33.34144',
  `status` varchar(250) NOT NULL DEFAULT 'patient',
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`ID`, `Name`, `Address`, `Age`, `Ambulation`, `BMI`, `Chills`, `Contacts`, `DOB`, `Email`, `DBP`, `DecreasedMood`, `FiO2`, `GeneralizedFatigue`, `HeartRate`, `HistoryFever`, `RR`, `RecentHospitalStay`, `SBP`, `SpO2`, `Temp`, `WeightGain`, `WeightLoss`, `BGroup`, `Sex`, `pass`, `latitude`, `longitude`, `status`, `user`) VALUES
(1, 'John Smith', '123 Main Street', 35, 0, '22.5', 0, '123-456-7890', '1986-01-01', 'johnsmith@example.com', 70, 0, 90, 0, 80, 'Never', 14, '0000-00-00', 12, 95, 97, 0, 0, 'O+', 'Male', 'password', '1001', '1002', 'patient', 'jsmith'),
(2, 'Jane Doe', '456 Park Avenue', 28, 0, '21.0', 0, '098-765-4321', '1993-02-14', 'janedoe@example.com', 75, 0, 95, 0, 85, 'Once', 15, '0000-00-00', 115, 96, 98, 0, 0, 'A-', 'Female', 'password', '35.2157696', '33.34144', 'patient', 'jdoe'),
(3, 'Vubangsi Mercel', 'Department of Computer Science,', 0, 0, '19.0', 0, '17407463080', '2022-12-16', 'vmercel@gmail.com', 69, 0, 55, 0, 83, 'Never', 12, '0000-00-00', 101, 97, 98, 0, 0, 'A', 'Male', 'Marvel16', '35.2157696', '33.34144', 'patient', '20215449'),
(4, 'Ntumbi Laura', 'C/O Ntumbi Rex N. J.,', 1, 0, '21.0', 0, '17407463082', '2022-12-27', 'vmercel@yahoo.com', 60, 0, 55, 0, 99, 'Never', 12, '0000-00-00', 99, 97, 95, 0, 0, 'A', 'Female', 'Marvel@16', '35.2157696', '33.34144', 'patient', 'lau'),
(5, 'Venan Noela', 'C/O Ntumbi Rex N. J.,', 0, 0, '21.0', 0, '17407463081', '2022-12-04', 'vmercel@gmail.com', 77, 0, 78, 0, 96, 'Never', 12, '0000-00-00', 97, 94, 96, 0, 0, 'A', 'Female', 'Marvel16', '35.2157696', '33.34144', 'patient', 'noela'),
(6, 'fadi', 'Near East University, Innovation and Information Technologies Center Faculty of Engineering Tel: +90 (392) 223 66 24', 42, 0, '21.0', 0, '4567880000', '1980-01-01', 'alturjman@outlook.com', 69, 0, 63, 0, 85, 'Never', 14, '0000-00-00', 105, 91, 95, 0, 0, 'A-', 'Male', 'Fadi1234', '35.2157696', '33.34144', 'doctor', 'fadi'),
(7, 'mehmet Ilker Gelisen', 'Faculty6 of Pharmacy', 69, 0, '21.0', 0, '905338559367', '1953-03-11', 'ilker.gelisen@neu.edu.tr', 69, 0, 64, 0, 61, 'Never', 12, '0000-00-00', 113, 95, 96, 0, 0, 'ARh+', 'Male', 'Ankara765%', '35.2157696', '33.34144', 'patient', 'ilker.gelisen@neu.edu.tr'),
(8, 'Keyna Inamugisha', 'agaoglu 2, gumus sokak', 22, 0, '21.0', 0, '5338857918', '2000-04-19', 'kinamugisha@gmail.com', 76, 0, 88, 0, 98, 'Never', 12, '0000-00-00', 113, 92, 97, 0, 0, 'O+', 'Female', 'KeynaLaure1', '35.2157696', '33.34144', 'patient', 'keyna'),
(9, 'mohamad darwish', 'Nicosia', 23, 0, '20.0', 0, '5391041078', '1999-05-27', 'mohameddarwaish@gmail.com', 64, 0, 51, 0, 67, 'Never', 12, '0000-00-00', 111, 99, 96, 0, 0, 'A', 'Male', 'Hamoda2799', '1001', '1002', 'patient', 'mohamad'),
(10, 'vubangsi', 'lefkosa', 0, 0, '22.0', 0, '5338294913', '2023-03-29', '05338294913', 73, 0, 94, 0, 63, 'Never', 15, '0000-00-00', 90, 92, 97, 0, 0, 'O+', 'Male', 'abc', '1001', '1002', 'patient', 'vubang'),
(11, 'Ibrahim Ame', '490 NEU', 0, 0, '18.0', 0, '744444444', '2022-09-07', 'ame.ibrahim@yahoo.com', 62, 0, 65, 0, 92, 'Never', 13, '0000-00-00', 103, 98, 97, 0, 0, 'B-', 'Male', 'IbrahimAme123', '35.2157696', '33.34144', 'patient', 'ibrahimame'),
(12, 'mohamad darwish', 'Nicosia', 24, 0, '24.0', 0, '5391041078', '1999-02-27', 'mohameddarwaish@gmail.com', 60, 0, 95, 0, 69, 'Never', 12, '0000-00-00', 94, 99, 95, 0, 0, 'A', 'Male', 'Hamoda2799', '1001', '1002', 'patient', 'mohamad'),
(13, 'mohamad darwish', 'Nicosia', 23, 0, '21.0', 0, '5391041078', '1999-05-27', 'mohameddarwaish@gmail.com', 69, 0, 60, 0, 76, 'Never', 14, '0000-00-00', 107, 94, 95, 0, 0, 'A', 'Male', 'Hamoda2799', '1001', '1002', 'patient', 'mohamad12');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` varchar(50) NOT NULL,
  `patient_id` int(50) NOT NULL,
  `doctor_id` int(50) NOT NULL,
  `patient_name` varchar(50) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `report_type` varchar(50) NOT NULL,
  `doctor_email` varchar(50) NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `patient_id`, `doctor_id`, `patient_name`, `filename`, `report_type`, `doctor_email`, `status`, `created_date`) VALUES
('16ncogbcllghvqx3l', 8, 2, 'Keyna Inamugisha', 'Covid-Report@16ncogbcllghvqx3l.pdf', 'Covid-19-Report', '', 'patient', '2023-04-15'),
('1b88mgbqdlh82zq1d', 6, 2, 'fadi', 'High-Blood-Pressure-Report@1b88mgbqdlh82zq1d.pdf', 'High-Blood-Pressure-Report', '', 'patient', '2023-05-03'),
('kovut7nhlg2f9o7h', 6, 1, 'fadi', 'Covid-Report@kovut7nhlg2f9o7h.pdf', 'Covid-19-Report', 'ame.ibrahim@yahoo.com', 'doctor', '2023-04-04');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `user` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `date`, `user`, `start_time`, `end_time`, `description`) VALUES
(1, '2022-12-19', 'jsmith', '20:06:00', '20:12:00', 'this is just a new event'),
(2, '2022-12-22', 'jsmith', '21:04:00', '20:09:00', 'this is just a new event'),
(3, '2022-12-25', 'jsmith', '20:41:00', '14:46:00', 'this is just another description. it is just about the same as the previos one');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `specialty` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `specialty`) VALUES
(1, 'General Checkup', 'A routine checkup to assess your overall health', 'General Medicine'),
(2, 'Dental Cleaning', 'A cleaning of your teeth and gums to maintain oral health', 'Dentistry'),
(3, 'Eye Exam', 'A comprehensive eye exam to check your vision and eye health', 'Ophthalmology'),
(4, 'Physical Therapy', 'Therapy to help improve your movement, balance, and strength', 'Physical Therapy');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `geo_api` varchar(255) NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `token` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `user`, `pass`, `geo_api`, `lat`, `lon`, `token`, `status`) VALUES
(0, 'noela', 'Marvel16', '45d6937ff6b14b1a9bf1d4aa6f9a26a5', 37.4419, -122.142, 'token1', 'patient'),
(1, 'jsmith', 'password', '45d6937ff6b14b1a9bf1d4aa6f9a26a5', 37.4419, -122.142, 'token1', 'patient'),
(2, 'doc1', 'doc1', '45d6937ff6b14b1a9bf1d4aa6f9a26a5', 37.43, -122.14, 'token2', 'doctor'),
(3, 'admin', 'admin', '45d6937ff6b14b1a9bf1d4aa6f9a26a5', 37.45, -122.135, 'token3', 'admin'),
(5, 'fadi', 'fadi', '45d6937ff6b14b1a9bf1d4aa6f9a26a5', 37.45, -122.135, 'token3', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `license` (`license`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
