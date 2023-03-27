-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2023 at 09:53 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tripbuilder`
--

-- --------------------------------------------------------

--
-- Table structure for table `airlines`
--

CREATE TABLE `airlines` (
  `iata_airline_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airlines`
--

INSERT INTO `airlines` (`iata_airline_code`, `name`, `description`) VALUES
('AC', 'Air Canada', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `airports`
--

CREATE TABLE `airports` (
  `iata_airport_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `city_code` varchar(255) NOT NULL,
  `country_code` varchar(255) NOT NULL,
  `region_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airports`
--

INSERT INTO `airports` (`iata_airport_code`, `name`, `city`, `latitude`, `longitude`, `timezone`, `city_code`, `country_code`, `region_code`) VALUES
('YUL', 'Pierre Elliott Trudeau International', 'Montreal', '45.457714', '-73.749908', 'America/Montreal', 'YMQ', 'CA', 'QC'),
('YVR', 'Vancouver International', 'Vancouver', '49.194698', '-123.179192', 'America/Vancouver', 'YVR', 'CA', 'BC');

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `flight_number` int(11) NOT NULL,
  `airline_code` varchar(255) NOT NULL,
  `departure_airport_code` varchar(255) NOT NULL,
  `departure_time` varchar(255) NOT NULL,
  `arrival_airport_code` varchar(255) NOT NULL,
  `arrival_time` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`flight_number`, `airline_code`, `departure_airport_code`, `departure_time`, `arrival_airport_code`, `arrival_time`, `price`) VALUES
(301, 'AC', 'YUL', '2023-04-04 07:35', 'YVR', '2023-04-04 10:35', '273.23'),
(302, 'AC', 'YVR', '2023-04-05 12:35', 'YUL', '2023-04-05 15:35', '220.63');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airlines`
--
ALTER TABLE `airlines`
  ADD PRIMARY KEY (`iata_airline_code`);

--
-- Indexes for table `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`iata_airport_code`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`flight_number`),
  ADD KEY `airline_code` (`airline_code`),
  ADD KEY `departure_airport_code` (`departure_airport_code`),
  ADD KEY `arrival_airport_code` (`arrival_airport_code`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `flights_ibfk_1` FOREIGN KEY (`airline_code`) REFERENCES `airlines` (`iata_airline_code`),
  ADD CONSTRAINT `flights_ibfk_2` FOREIGN KEY (`departure_airport_code`) REFERENCES `airports` (`iata_airport_code`),
  ADD CONSTRAINT `flights_ibfk_3` FOREIGN KEY (`arrival_airport_code`) REFERENCES `airports` (`iata_airport_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
