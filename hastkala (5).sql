-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2022 at 09:12 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hastkala`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `ParentCategoryID` int(11) DEFAULT NULL,
  `ImagesPath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `ParentCategoryID`, `ImagesPath`) VALUES
(1, 'Earthen Wear', NULL, 'categoriesimages/earthen/'),
(2, 'Cooking Wear', 1, NULL),
(3, 'Home Essentials', 1, NULL),
(4, 'Fashion', NULL, 'categoriesimages/fashion/'),
(5, 'Traditional Wear', 4, NULL),
(6, 'Jewellery', 4, NULL),
(7, 'Footwear', 4, NULL),
(8, 'Watches', 4, NULL),
(9, 'Home Decore', NULL, 'categoriesimages/home/'),
(10, 'Diyas', 9, NULL),
(11, 'Candals', 9, NULL),
(12, 'Showpis', 9, NULL),
(13, 'Photoframes', 9, NULL),
(14, 'Beauty Products', NULL, 'categoriesimages/Beautyproducts/'),
(15, 'Toothpaste', 14, NULL),
(16, 'Soap', 14, NULL),
(17, 'Hair Oils', 14, NULL),
(18, 'Shampoos', 14, NULL),
(19, 'Mehandi', 14, NULL),
(20, 'Body Losans', 14, NULL),
(21, 'Handmade Bags', NULL, 'categoriesimages/bags/'),
(22, 'Carry Bags', 21, NULL),
(23, 'Pouches', 21, NULL),
(24, 'Hand Bags', 21, NULL),
(25, 'Sling Bags', 21, NULL),
(26, 'Backpacks', 21, NULL),
(27, 'Furnishing', NULL, 'categoriesimages/furnishing/'),
(28, 'Tables', 27, NULL),
(29, 'Cabinets', 27, NULL),
(30, 'Matreses', 27, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `Quantity` int(20) NOT NULL,
  `TotalPrice` float(7,2) NOT NULL,
  `SizeID` int(11) DEFAULT NULL,
  `ProductId` int(11) NOT NULL,
  `OrderStatusID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `DateTime`, `Quantity`, `TotalPrice`, `SizeID`, `ProductId`, `OrderStatusID`, `UserID`) VALUES
(3, '2022-01-22 18:11:53', 2, 26000.00, 2, 1, 2, 3),
(47, '2022-03-12 01:27:23', 1, 80.00, NULL, 4, 3, 1),
(53, '2022-03-12 01:33:44', 2, 2600.00, NULL, 16, 2, 1),
(55, '2022-03-12 10:45:05', 1, 1600.00, 2, 2, 2, 1),
(56, '2022-03-12 14:46:16', 2, 2600.00, NULL, 16, 2, 1),
(57, '2022-03-12 14:46:25', 1, 1600.00, 2, 2, 2, 1),
(58, '2022-03-12 14:49:30', 1, 1600.00, NULL, 17, 3, 1),
(74, '2022-03-31 11:58:29', 1, 13000.00, NULL, 1, 1, 1),
(75, '2022-03-31 11:59:38', 1, 1300.00, NULL, 16, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderstatus`
--

CREATE TABLE `orderstatus` (
  `OrderStatusID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderstatus`
--

INSERT INTO `orderstatus` (`OrderStatusID`, `Name`) VALUES
(1, 'In Cart'),
(2, 'Ordered Placed'),
(3, 'Shipped'),
(4, 'Out for delivery'),
(5, 'Delivered'),
(6, 'Cancelled'),
(7, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Details` varchar(300) NOT NULL,
  `Price` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Color` varchar(100) DEFAULT NULL,
  `Weight` varchar(50) DEFAULT NULL,
  `Material` varchar(50) DEFAULT NULL,
  `ForGender` varchar(20) DEFAULT NULL,
  `Composition` varchar(500) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `ImagesPath` varchar(100) NOT NULL,
  `IsDelete` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `Name`, `Details`, `Price`, `Quantity`, `Color`, `Weight`, `Material`, `ForGender`, `Composition`, `CategoryID`, `ImagesPath`, `IsDelete`) VALUES
(1, 'jwell fine', 'made of great pearl', 13000, 798, 'white', '150gm', 'silver pure', 'Female', 'made of pure silver material', 4, 'images/1/', NULL),
(2, 'dress', 'orange dress', 1600, 498, 'orange', '250gm', 'cotton soft pure', 'Female', 'made of pure cotton material with soft touch', 4, 'images/2/', NULL),
(3, 'juti', 'women footwear', 500, 690, 'multicolor', '400gm', 'made of leather', 'Female', 'made of leather shoes juti for womens ...', 4, 'images/3/', NULL),
(4, 'soap', 'made of natural ingredients', 80, 376, 'orange', '50gm', 'natural ingredients', 'Female', 'made of natural ingredients', 14, 'images/4/', NULL),
(5, 'ciramic handmade set', 'this is the set of teapot and ciramic glass ', 2500, 600, 'white', '500gm', 'ciramic', NULL, 'this is the set made of ciramic', 1, 'images/5/', NULL),
(6, 'diyas', 'hand made diya', 40, 900, 'clay', '20gm', 'clay', 'other', 'its eco-friendly and made from filtered soil...', 9, 'images/6/', NULL),
(7, 'natural losan', '', 200, 600, 'multi', '100gm', 'natural ingredients', '', 'natural things', 14, 'images/7/', 1),
(8, 'cooking wear', 'this is the cooking wear items', 2222, 59, 'natural', '200gm', 'clay', '0', 'made up from the earthen clay ', 1, 'images/8/', NULL),
(9, 'crafted watch', 'watch with hand crafted carvings', 1500, 100, 'wooden', '220gm', 'wood and steel', 'other', 'body of wood and the dial of  steel ', 4, 'images/9/', NULL),
(10, 'hand made candles ', 'hand made candles pack of 2 ', 70, 150, 'white ', '100gm', 'natural wax ', 'other', 'made of natural wax and insence flavor ', 9, 'images/10/', NULL),
(11, 'buddha show piece ', 'showpiece', 800, 150, 'black', '300gm', 'multiple metals ', 'other', 'made of multiple metals ', 9, 'images/11/', NULL),
(12, 'hand made photo frame ', 'frame of wood with an ideal between ', 600, 40, 'black', '250gm', 'wood ', 'other', 'made of wood and poster', 9, 'images/12/', NULL),
(14, 'tooth paste ', 'toothpaste with natural insence', 70, 80, 'white', '120gm', 'natural ingredients', 'other', 'made of natural ingredients and insence', 14, 'images/14/', NULL),
(15, 'natural hair oils', 'made of natural ingredients', 250, 88, 'natural', '250ml', 'natural incence', 'other', 'natural', 14, 'images/15/', NULL),
(16, 'zipper jacket', 'made of natural cotton', 1300, 500, 'dark blue', '350gm', 'cotton', 'Male', 'made of pure cotton material', 4, 'images/16/', NULL),
(17, 'workers shirt jacket', 'mens jacket', 1600, 400, 'black', '250gm', 'cotton blend', 'Male', 'made of pure cotton and blend material with soft touch', 4, 'images/17/', NULL),
(18, 'zipper jacket', 'mens designer jacket', 1500, 700, 'mate black', '350gm', 'made of blend material', 'Male', 'made of profound blend of materials ...', 4, 'images/18/', NULL),
(19, 'watercolor sport jacket in brown/blue', 'mens wear', 1800, 400, 'brown/blue', '300gm', 'naylon cotton blend', 'Male', 'made of nylon blend', 4, 'images/19/', NULL),
(20, 'washed wool blazer', 'made of natural cotton', 2200, 300, 'light blue', '350gm', 'cotton', 'Male', 'made of pure cotton material', 4, 'images/20/', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productssize`
--

CREATE TABLE `productssize` (
  `ID` int(11) NOT NULL,
  `ProductId` int(11) NOT NULL,
  `Sizeid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productssize`
--

INSERT INTO `productssize` (`ID`, `ProductId`, `Sizeid`) VALUES
(1, 2, 2),
(2, 2, 3),
(3, 2, 5),
(4, 3, 8),
(5, 3, 10),
(6, 3, 11),
(7, 3, 12);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `MobileNumber` varchar(13) NOT NULL,
  `Address` varchar(500) NOT NULL,
  `State` varchar(50) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `Pincode` varchar(6) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`ID`, `Name`, `MobileNumber`, `Address`, `State`, `Gender`, `Pincode`, `UserID`) VALUES
(1, 'vaibhav', '+918155801818', 'Janta Society', 'Gujarat', 'male', '361005', 1),
(2, 'Somu', '8916512331', 'Gokul Nagar', 'Gujarat', 'male', '361005', 2),
(3, 'Somesh', '5351548322', 'Jamnagar', 'Gujarat', 'male', '361004', 3),
(5, 'Nilesh', '8155801818', 'Jamnagar', 'Gujarat', 'male', '361004', 4),
(6, 'Vaibhav', '1234567890', 'hshs', 'hshs', 'male', '3614', 38);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `ID` int(11) NOT NULL,
  `FixedSize` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`ID`, `FixedSize`) VALUES
(1, 's'),
(2, 'm'),
(3, 'l'),
(4, 'xl'),
(5, 'xxl'),
(6, 'xxxl'),
(7, '6'),
(8, '7'),
(9, '8'),
(10, '9'),
(11, '10'),
(12, '11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `User_type` varchar(30) NOT NULL DEFAULT 'user',
  `Email` varchar(200) NOT NULL,
  `PasswordHash` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `User_type`, `Email`, `PasswordHash`) VALUES
(1, 'admin', 'vaibhav@gmail.com', '$2y$10$KSE7ioDlxhLQwnWFHzKUee3hq/W.qw8St.RPdNooDgdu8AmcW0sDK'),
(2, 'user', 'som@gmail.com', '$2y$10$r36mUur3rgjSlmhX7MbUfuhupK9PmbWb5r68VEXwAZLpiM0k6OHqa'),
(3, 'user', 'somesh@gmail.com', '$2y$10$ghZjbgKwClknKhPFBp.r0OIajrQpo7vpzEAnJ8DuxvoLDpW9EZu/C'),
(4, 'admin', 'nilesh@gmail.com', '$2y$10$9j8YQ6qOv4uvwnYFZwzA4uH/dthNry9KkEREc9ss76cnWWSGxrijW'),
(33, 'user', 'soham@gmail.com', '$2y$10$mYIfex02RjyfHHNe.hdsjuHxk.zSSc3NPQ9lEGIimgwJSMxe4GnLa'),
(34, 'user', 'soha@gmail.com', '$2y$10$Nc.r0iPxlATAOVK6BXxwkekiEogL4q6j7Jgr7e0hkH.Kl86mtMTzu'),
(35, 'user', 'kishor@gmail.com', '$2y$10$SQi3yaflPxCzPK7hNKFopO/kKl/N7DafluBqS6kX2vb3M/QpVaF8C'),
(36, 'user', 'goku', '$2y$10$vKszjWiuLoBaDFzNN21p3uhSaM3/PEIRA9wCSOnAcAcxwoMjwpVQa'),
(37, 'user', 'vbpatel@gmail.com', '$2y$10$agWz7OCYqhJ23fRMRycnnu1WqbheagWjswY2/vnGHylNbBhQCPQUO'),
(38, 'user', 'vaibhavkodinariya312@gmail.com', '$2y$10$4EjUFm2dBZYhiSn3WwOgxuNuUCsdtiDOz0T8QrPnlAILHQZHw3uoS'),
(39, 'user', 'bznsjwnwhwjw', '$2y$10$YSoDtigp4z1sbIr7Yn7CguY.2pQlTUC8A5TkV2plItQxoxJgFkQ6i'),
(41, 'user', 'somiya', '$2y$10$bklLE8fs7h5S0k345mSMwurVpLpji28AnN7Ne6PtGdjMAJEJXj2WS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FkCategoryIDInCategories` (`ParentCategoryID`) KEY_BLOCK_SIZE=30 USING BTREE;

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `FK_USERID` (`UserID`),
  ADD KEY `FK_ORDERSTATUSID` (`OrderStatusID`),
  ADD KEY `FK_productID` (`ProductId`),
  ADD KEY `FK_SizeID` (`SizeID`);

--
-- Indexes for table `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD PRIMARY KEY (`OrderStatusID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FkCategoryIDInProducts` (`CategoryID`);

--
-- Indexes for table `productssize`
--
ALTER TABLE `productssize`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FkSizeidInProductssize` (`Sizeid`),
  ADD KEY `Product_id` (`ProductId`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FkUserIDInProfiles` (`UserID`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `productssize`
--
ALTER TABLE `productssize`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `FkCategoryIDInCategories` FOREIGN KEY (`ParentCategoryID`) REFERENCES `categories` (`ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_ORDERSTATUSID` FOREIGN KEY (`OrderStatusID`) REFERENCES `orderstatus` (`OrderStatusID`),
  ADD CONSTRAINT `FK_SizeID` FOREIGN KEY (`SizeID`) REFERENCES `sizes` (`ID`),
  ADD CONSTRAINT `FK_USERID` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `FK_productID` FOREIGN KEY (`productid`) REFERENCES `products` (`ID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FkCategoryIDInProducts` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`ID`);

--
-- Constraints for table `productssize`
--
ALTER TABLE `productssize`
  ADD CONSTRAINT `FkSizeidInProductssize` FOREIGN KEY (`Sizeid`) REFERENCES `sizes` (`ID`),
  ADD CONSTRAINT `productssize_ibfk_1` FOREIGN KEY (`ProductId`) REFERENCES `products` (`ID`);

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `FkUserIDInProfiles` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
