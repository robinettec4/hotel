-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2020 at 04:17 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roomdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) UNSIGNED NOT NULL,
  `customerID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `customerID`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `creditcard`
--

CREATE TABLE `creditcard` (
  `ID` int(11) UNSIGNED NOT NULL,
  `customerID` int(11) UNSIGNED NOT NULL,
  `cardNumber` bigint(16) UNSIGNED NOT NULL,
  `cardExpiration` date NOT NULL,
  `cardSecurityNumber` int(3) NOT NULL,
  `Accepted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `creditcard`
--

INSERT INTO `creditcard` (`ID`, `customerID`, `cardNumber`, `cardExpiration`, `cardSecurityNumber`, `Accepted`) VALUES
(1, 1, 1111222233334444, '2020-04-01', 123, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `ID` int(11) UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8 NOT NULL,
  `email` varchar(40) CHARACTER SET utf8 NOT NULL,
  `password` varchar(40) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`ID`, `name`, `email`, `password`) VALUES
(1, 'Connor Robinette', 'connor.robinette@gmail.com', 'password1'),
(2, 'Angela Robinette', 'angela.robinette@gmail.com', 'password2'),
(3, 'Gregory Robinette', 'greg.robinette@gmail.com', 'password3');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `ID` int(10) UNSIGNED NOT NULL,
  `address` varchar(40) CHARACTER SET utf8 NOT NULL,
  `email` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `availableRooms` int(11) NOT NULL,
  `name` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `picture` varchar(40) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`ID`, `address`, `email`, `availableRooms`, `name`, `picture`) VALUES
(1, '1 Average Avenue', 'joe.average@gmail.com', 10, 'Joe Average Hotel', 'picture/average.jpg'),
(2, '2 Exceptional Expressway', 'exceptionalhotels@gmail.com', 5, 'Exceptionally Overpriced Hotel', 'picture/overpriced.jpg'),
(3, '3 Reasonable Road', 'reasonable.ralph@gmail.com', 7, 'Reasonable Ralph\'s Hotel', 'picture/reasonable.jpg'),
(4, '4 Ripoff Route', 'rick.ripoff@gmail.com', 20, 'Ripoff Rick\'s Hotel', 'picture/ripoff.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `ID` int(11) UNSIGNED NOT NULL,
  `roomID` int(11) UNSIGNED NOT NULL,
  `hotelID` int(11) UNSIGNED NOT NULL,
  `customerID` int(11) UNSIGNED NOT NULL,
  `numberOfGuests` int(11) NOT NULL,
  `dayStart` date NOT NULL,
  `dayEnd` date NOT NULL,
  `creditCardID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`ID`, `roomID`, `hotelID`, `customerID`, `numberOfGuests`, `dayStart`, `dayEnd`, `creditCardID`) VALUES
(1, 1, 1, 1, 1, '2020-04-01', '2020-04-04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `ID` int(10) UNSIGNED NOT NULL,
  `hotelID` int(10) UNSIGNED NOT NULL,
  `price` double UNSIGNED NOT NULL,
  `size` tinyint(3) UNSIGNED NOT NULL,
  `picture` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`ID`, `hotelID`, `price`, `size`, `picture`, `description`) VALUES
(1, 1, 100, 2, 'picture/average.jpg', 'This is the description for room 1'),
(2, 2, 900, 1, 'picture/overpriced.jpg', 'This is the description for room 2'),
(3, 3, 150, 4, 'picture/reasonable.jpg', 'This is the description for room 3'),
(4, 4, 200, 2, 'picture/ripoff.jpg', 'This is the description for room 4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `creditcard`
--
ALTER TABLE `creditcard`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`,`address`,`email`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `roomID` (`roomID`,`hotelID`,`customerID`),
  ADD KEY `creditCardID` (`creditCardID`),
  ADD KEY `hotelID` (`hotelID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `hotelID` (`hotelID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `creditcard`
--
ALTER TABLE `creditcard`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer` (`ID`);

--
-- Constraints for table `creditcard`
--
ALTER TABLE `creditcard`
  ADD CONSTRAINT `creditcard_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer` (`ID`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`roomID`) REFERENCES `room` (`ID`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`hotelID`) REFERENCES `hotel` (`ID`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`customerID`) REFERENCES `customer` (`ID`),
  ADD CONSTRAINT `reservation_ibfk_4` FOREIGN KEY (`creditCardID`) REFERENCES `creditcard` (`ID`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`hotelID`) REFERENCES `hotel` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
