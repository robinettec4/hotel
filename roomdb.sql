-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2020 at 04:29 AM
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
-- Table structure for table `creditcard`
--

CREATE TABLE `creditcard` (
  `ID` int(11) UNSIGNED NOT NULL,
  `customerID` int(11) UNSIGNED NOT NULL,
  `cardNumber` bigint(16) UNSIGNED NOT NULL,
  `cardExpiration` date NOT NULL,
  `cardSecurityNumber` int(3) NOT NULL,
  `cardHolder` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `creditcard`
--

INSERT INTO `creditcard` (`ID`, `customerID`, `cardNumber`, `cardExpiration`, `cardSecurityNumber`, `cardHolder`) VALUES
(2, 15, 1111222233334444, '2020-05-07', 123, 'Connor Robinette'),
(3, 15, 2222333344445555, '2020-05-20', 123, 'Connor Robinette'),
(4, 15, 1234123412341234, '2020-01-01', 321, 'Connor Robinette');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `ID` int(11) UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8 NOT NULL,
  `email` varchar(40) CHARACTER SET utf8 NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 NOT NULL,
  `userType` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`ID`, `name`, `email`, `password`, `userType`) VALUES
(13, 'admin', 'admin@gmail.com', '$2y$10$6NUv.w.xgjwVXD0pMiv/2eylhYIlqlfuylEndklloPU7de2n1A.1K', 1),
(15, 'Connor Robinette', 'connor@gmail.com', '$2y$10$evi9m7kzwiZIKyQpfSdpkeyKsL18loPZOtbmHLQA2KDTGa9r5BZ0m', 0);

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
  `picture` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `price` double UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `size` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`ID`, `address`, `email`, `availableRooms`, `name`, `picture`, `price`, `description`, `size`) VALUES
(1, '1 Average Avenue', 'joe.average@gmail.com', 3, 'Joe Average Hotel', 'average.jpg', 50, 'An average hotel at an average price!', 4),
(2, '2 Exceptional Expressway', 'exceptionalhotels@gmail.com', 2, 'Exceptionally Overpriced Hotel', 'overpriced.jpg', 150, 'A very expensive hotel', 2),
(3, '3 Reasonable Road', 'reasonable.ralph@gmail.com', 2, 'Reasonable Ralph\'s Hotel', 'reasonable.jpg', 100, 'Reasonably priced hotel', 2),
(4, '4 Ripoff Route', 'rick.ripoff@gmail.com', 2, 'Ripoff Rick\'s Hotel', 'ripoff.jpg', 500, 'Don\'t stay here!', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `ID` int(11) UNSIGNED NOT NULL,
  `roomID` int(11) UNSIGNED NOT NULL,
  `customerID` int(11) UNSIGNED NOT NULL,
  `dayStart` date NOT NULL,
  `dayEnd` date NOT NULL,
  `creditCardID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`ID`, `roomID`, `customerID`, `dayStart`, `dayEnd`, `creditCardID`) VALUES
(23, 3, 15, '2020-05-05', '2020-05-07', 2),
(28, 1, 15, '2020-05-07', '2020-05-08', 2);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `ID` int(10) UNSIGNED NOT NULL,
  `hotelID` int(10) UNSIGNED NOT NULL,
  `roomNumber` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`ID`, `hotelID`, `roomNumber`) VALUES
(1, 1, 100),
(2, 2, 100),
(3, 3, 100),
(4, 4, 100),
(5, 1, 200),
(9, 1, 300),
(10, 2, 200),
(11, 1, 201),
(15, 4, 200);

--
-- Indexes for dumped tables
--

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
  ADD KEY `roomID` (`roomID`,`customerID`),
  ADD KEY `creditCardID` (`creditCardID`),
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
-- AUTO_INCREMENT for table `creditcard`
--
ALTER TABLE `creditcard`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

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
