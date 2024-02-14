



-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2024 at 06:25 PM
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
-- Database: `hack`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `pid` int(10) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productquantity` int(10) NOT NULL,
  `productprice` int(10) NOT NULL,
  `productcategory` varchar(50) NOT NULL,
  `productsize` varchar(50) NOT NULL,
  `productcolour` varchar(50) NOT NULL,
  `productlink` varchar(500) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customerid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`pid`, `productname`, `productquantity`, `productprice`, `productcategory`, `productsize`, `productcolour`, `productlink`, `added_at`, `customerid`) VALUES
(25, 'chavi', 1, 349, 'womens cotton kurta', '', 'blue', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAsJCQcJCQcJCQkJCwkJCQkJCQsJCwsMCwsLDA0QDBEODQ4MEhkSJRodJR0ZHxwpKRYlNzU2GioyPi0pMBk7IRP/2wBDAQcICAsJCxULCxUsHRkdLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCz/wAARCAGQAQYDASIAAhEBAxEB/8QAGwABAAIDAQEAAAAAAAAAAAAAAAECAwQHBQb/xABDEAACAgECAwYDBgMFBwMFAAABAgADEQQhBRIxE0FRYXGBBiKRFDJCobHBI1JyJDNiktEHFTSDouHwQ1OCVGRzo7L/xAAaAQEAAwEBAQAAAAAAAAAAAAAAAgMEAQUG/8QAJxEBAQACAgEEAgIDAQEAAAAAAAECEQMhMQQSIkETIzJRFGFxQtH/2gAMAwEAAhEDEQA/A', '2024-02-10 17:05:30', 11),
(26, 'fearless', 0, 200, 'womens western wear', '', 'black', 'https://th.bing.com/th/id/OIP.FJ-4_DlZh_7FD2B9o_xulgHaJ3?w=202&h=269&c=7&r=0&o=5&dpr=1.3&pid=1.7', '2024-02-10 17:08:41', 11);

-- --------------------------------------------------------

--
-- Table structure for table `customerregister`
--

CREATE TABLE `customerregister` (
  `customerid` int(10) NOT NULL,
  `customername` varchar(50) NOT NULL,
  `customeremail` varchar(50) NOT NULL,
  `customerusername` varchar(50) NOT NULL,
  `customernumber` int(10) NOT NULL,
  `customerlocation` varchar(50) NOT NULL,
  `customerpassword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customerregister`
--

INSERT INTO `customerregister` (`customerid`, `customername`, `customeremail`, `customerusername`, `customernumber`, `customerlocation`, `customerpassword`) VALUES
(11, 'chau', 'chaukatula@nako.com', 'chau1', 2147483647, 'vasco', '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `negotiate`
--

CREATE TABLE `negotiate` (
  `pid` int(10) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productquantity` int(10) NOT NULL,
  `productprice` int(10) NOT NULL,
  `productcategory` varchar(50) NOT NULL,
  `productsize` varchar(50) NOT NULL,
  `productcolour` varchar(50) NOT NULL,
  `productlink` varchar(500) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customerid` int(10) NOT NULL,
  `customernegotiateprice` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `negotiate`
--

INSERT INTO `negotiate` (`pid`, `productname`, `productquantity`, `productprice`, `productcategory`, `productsize`, `productcolour`, `productlink`, `added_at`, `customerid`, `customernegotiateprice`) VALUES
(25, 'chavi', 4, 349, 'womens cotton kurta', '', 'blue', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAsJCQcJCQcJCQkJCwkJCQkJCQsJCwsMCwsLDA0QDBEODQ4MEhkSJRodJR0ZHxwpKRYlNzU2GioyPi0pMBk7IRP/2wBDAQcICAsJCxULCxUsHRkdLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCz/wAARCAGQAQYDASIAAhEBAxEB/8QAGwABAAIDAQEAAAAAAAAAAAAAAAECAwQHBQb/xABDEAACAgECAwYDBgMFBwMFAAABAgADEQQhBRIxE0FRYXGBBiKRFDJCobHBI1JyJDNiktEHFTSDouHwQ1OCVGRzo7L/xAAaAQEAAwEBAQAAAAAAAAAAAAAAAgMEAQUG/8QAJxEBAQACAgEEAgIDAQEAAAAAAAECEQMhMQQSIkETIzJRFGFxQtH/2gAMAwEAAhEDEQA/A', '2024-02-10 17:19:01', 11, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pid` int(10) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productquantity` int(10) NOT NULL,
  `productprice` int(10) NOT NULL,
  `negotiableamount` int(10) NOT NULL,
  `productcategory` varchar(50) NOT NULL,
  `productsize` varchar(50) NOT NULL,
  `productcolour` varchar(50) NOT NULL,
  `productlink` varchar(500) NOT NULL,
  `sellerid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `productname`, `productquantity`, `productprice`, `negotiableamount`, `productcategory`, `productsize`, `productcolour`, `productlink`, `sellerid`) VALUES
(25, 'chavi', 4, 349, 340, 'womens cotton kurta', 'M,XXL', 'blue', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAsJCQcJCQcJCQkJCwkJCQkJCQsJCwsMCwsLDA0QDBEODQ4MEhkSJRodJR0ZHxwpKRYlNzU2GioyPi0pMBk7IRP/2wBDAQcICAsJCxULCxUsHRkdLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCz/wAARCAGQAQYDASIAAhEBAxEB/8QAGwABAAIDAQEAAAAAAAAAAAAAAAECAwQHBQb/xABDEAACAgECAwYDBgMFBwMFAAABAgADEQQhBRIxE0FRYXGBBiKRFDJCobHBI1JyJDNiktEHFTSDouHwQ1OCVGRzo7L/xAAaAQEAAwEBAQAAAAAAAAAAAAAAAgMEAQUG/8QAJxEBAQACAgEEAgIDAQEAAAAAAAECEQMhMQQSIkETIzJRFGFxQtH/2gAMAwEAAhEDEQA/A', 22),
(26, 'fearless', 10, 200, 180, 'womens western wear', 'S,M', 'black', 'https://th.bing.com/th/id/OIP.FJ-4_DlZh_7FD2B9o_xulgHaJ3?w=202&h=269&c=7&r=0&o=5&dpr=1.3&pid=1.7', 22),
(27, 'chanderi', 20, 2200, 2100, 'women traditional wear', '6 yard', 'red', 'https://th.bing.com/th/id/OIP.LACuNcaOpq0ZkpB-0Y_kvwHaJQ?w=202&h=253&c=7&r=0&o=5&dpr=1.3&pid=1.7', 22),
(28, 'hunu-man', 4, 5000, 4998, 'mens formal wear', 'XL,XXL,XXXL', 'black', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAsJCQcJCQcJCQkJCwkJCQkJCQsJCwsMCwsLDA0QDBEODQ4MEhkSJRodJR0ZHxwpKRYlNzU2GioyPi0pMBk7IRP/2wBDAQcICAsJCxULCxUsHRkdLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCz/wAARCAFtAQYDASIAAhEBAxEB/8QAHAAAAQQDAQAAAAAAAAAAAAAAAAECAwcEBQYI/8QATxAAAQMCBAMFBAcFBAYHCQAAAQACAwQRBRIhMQZBURNhcYGRByKhsRQjMkJScsEVYoKS0VOi4fAWM0NksrMkJjRzo8LxJURVY3SDk6S0/8QAFgEBAQEAAAAAAAAAAAAAAAAAAAEC/8QAHBEBAQEBAAIDAAAAAAAAAAAAAAERIQIxEkFR/9oADAMBAAIRAxEAPwC20', 21),
(29, 'desi-munda', 30, 500, 450, 'mens traditional wear', 'M,L,XL', 'green', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAsJCQcJCQcJCQkJCwkJCQkJCQsJCwsMCwsLDA0QDBEODQ4MEhkSJRodJR0ZHxwpKRYlNzU2GioyPi0pMBk7IRP/2wBDAQcICAsJCxULCxUsHRkdLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCz/wAARCAGJAQYDASIAAhEBAxEB/8QAGwAAAgMBAQEAAAAAAAAAAAAAAgMBBAUABgf/xABEEAACAQMDAQYEAwYDBgUFAQABAhEAAyEEEjFBBRMiUWFxMoGRobHB8AYUI0LR4TNSYiQ0cnOC8RVDRFOyNWOis8KS/8QAGQEAAwEBAQAAAAAAAAAAAAAAAAECAwQF/8QAJREBAQACAgIDAAMAAwEAAAAAAAECEQMxEiEEQVETIjJCQ2Fx/9oADAMBAAIRAxEAPwDzu', 21),
(30, 'QTee', 10, 1010, 1000, 'kids wear', 'XXS,XS', 'yellow', 'https://th.bing.com/th/id/OIP.Qcua2cNh0hUQOQmeDbXcEwHaJQ?w=161&h=202&c=7&r=0&o=5&dpr=1.3&pid=1.7', 20);

-- --------------------------------------------------------

--
-- Table structure for table `sellerregister`
--

CREATE TABLE `sellerregister` (
  `sellerid` int(10) NOT NULL,
  `sellername` varchar(50) NOT NULL,
  `sellernumber` varchar(10) NOT NULL,
  `selleremail` varchar(50) NOT NULL,
  `sellerlocation` varchar(50) NOT NULL,
  `sellergstinno` varchar(50) NOT NULL,
  `sellerusername` varchar(50) NOT NULL,
  `sellerpassword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellerregister`
--

INSERT INTO `sellerregister` (`sellerid`, `sellername`, `sellernumber`, `selleremail`, `sellerlocation`, `sellergstinno`, `sellerusername`, `sellerpassword`) VALUES
(20, 'jaan', '3456765434', 'jaan21@gmail.com', 'pune', 'A123456DRYH5437', 'janu', 'janu@21'),
(21, 'josi', '6789256783', 'josi2003@gmail.com', 'goa', 'GT7589ERFYUJ235', 'josi1', 'josi1hi'),
(22, 'chutki', '9167825678', 'chutki@gmail.com', 'bihar', 'HJU756789RFG5678', 'chutkifrombihar', 'chutkiwedschottabheem');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `pid` int(10) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productquantity` int(10) NOT NULL,
  `productprice` int(10) NOT NULL,
  `productcategory` varchar(50) NOT NULL,
  `productsize` varchar(50) NOT NULL,
  `productcolour` varchar(50) NOT NULL,
  `productlink` varchar(500) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customerid` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`pid`, `productname`, `productquantity`, `productprice`, `productcategory`, `productsize`, `productcolour`, `productlink`, `added_at`, `customerid`) VALUES
(25, 'chavi', 5, 349, 'womens cotton kurta', '', 'blue', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAsJCQcJCQcJCQkJCwkJCQkJCQsJCwsMCwsLDA0QDBEODQ4MEhkSJRodJR0ZHxwpKRYlNzU2GioyPi0pMBk7IRP/2wBDAQcICAsJCxULCxUsHRkdLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCz/wAARCAGQAQYDASIAAhEBAxEB/8QAGwABAAIDAQEAAAAAAAAAAAAAAAECAwQHBQb/xABDEAACAgECAwYDBgMFBwMFAAABAgADEQQhBRIxE0FRYXGBBiKRFDJCobHBI1JyJDNiktEHFTSDouHwQ1OCVGRzo7L/xAAaAQEAAwEBAQAAAAAAAAAAAAAAAgMEAQUG/8QAJxEBAQACAgEEAgIDAQEAAAAAAAECEQMhMQQSIkETIzJRFGFxQtH/2gAMAwEAAhEDEQA/A', '2024-02-10 17:07:59', 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customerregister`
--
ALTER TABLE `customerregister`
  ADD PRIMARY KEY (`customerid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `sellerregister`
--
ALTER TABLE `sellerregister`
  ADD PRIMARY KEY (`sellerid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customerregister`
--
ALTER TABLE `customerregister`
  MODIFY `customerid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sellerregister`
--
ALTER TABLE `sellerregister`
  MODIFY `sellerid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
