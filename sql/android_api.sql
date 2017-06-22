-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2017 at 01:10 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `android_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `employee_id` varchar(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `vehicle` int(2) NOT NULL DEFAULT '0',
  `zone_id` int(5) NOT NULL,
  `seats_left` int(4) DEFAULT NULL,
  `visibility` int(4) NOT NULL DEFAULT '0',
  `address` varchar(50) NOT NULL,
  `designation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`employee_id`, `name`, `vehicle`, `zone_id`, `seats_left`, `visibility`, `address`, `designation`) VALUES
('TS339', 'Shubhi', 1, 10, 4, 0, 'Mayur Vihar, Delhi', 'Manager'),
('TS340', 'Aakansha', 1, 10, 4, 0, 'Kanahiya Nagar, Delhi', 'Manager'),
('TS341', 'Aakash', 1, 10, 4, 0, 'Lajpat Nagar, Delhi', 'Manager'),
('TS342', 'Aditi', 0, 10, NULL, 0, 'Lajpat Nagar, Delhi', 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(23) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `encrypted_password` varchar(80) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `unique_id`, `employee_id`, `name`, `email`, `encrypted_password`, `salt`, `created_at`, `updated_at`, `active`) VALUES
(1, '59479fab37d9a4.50559708', 'TS339', 'Shubhi', 'IN_shubhi.lohani@shopclues.com', 'CQ4r0bu5V+lurDulIObprfNyfhE1MjM4Y2I4NzI3', '5238cb8727', '2017-06-19 15:25:55', NULL, 1),
(2, '5947a1dc37c9d4.72383990', 'TS340', 'Aakansha', 'Aakansha@shopclues.com', 'poIjQIqBiK8bTa8KyFI07y+Ooz03N2Q1ZTMzM2M2', '77d5e333c6', '2017-06-19 15:35:16', NULL, 1),
(3, '5947a3247f9ef3.16777039', 'UM123', 'uma', 'uma@shopclues.com', 'zfhe+lKstej9k7AGyr894RO4NkUxOWY4ZDE5MGIz', '19f8d190b3', '2017-06-19 15:40:44', NULL, 0),
(4, '5947a339eb4ed1.23943097', 'DZ223', 'deep', 'deep@shopclues.com', 'EXSnSbOtHNbiineTL0+eP8ZkgXk4MjEwODY2Yjdh', '8210866b7a', '2017-06-19 15:41:05', NULL, 0),
(5, '5947a351e4dea4.97833751', 'DZ243', 'dee', 'dee@shopclues.com', '8zisUnrqv1RqGQUISKyTDEDaLbI0Y2QzOTc3MTQ2', '4cd3977146', '2017-06-19 15:41:29', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
