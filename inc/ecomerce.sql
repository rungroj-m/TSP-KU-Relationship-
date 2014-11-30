-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 30, 2014 at 11:23 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ecomerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `AdditionProductDescriptionTags`
--

CREATE TABLE IF NOT EXISTS `AdditionProductDescriptionTags` (
  `ProductDescriptionId` int(11) NOT NULL,
  `TagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

CREATE TABLE IF NOT EXISTS `Admins` (
`AdminId` int(11) NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `UserName` varchar(20) NOT NULL,
  `Password` text NOT NULL,
  `Level` int(2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `Brands`
--

CREATE TABLE IF NOT EXISTS `Brands` (
`BrandId` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `Carts`
--

CREATE TABLE IF NOT EXISTS `Carts` (
`CartId` int(11) NOT NULL,
  `LastUpdate` datetime NOT NULL,
  `CustomerId` int(11) NOT NULL,
  `Closed` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `CartTransactions`
--

CREATE TABLE IF NOT EXISTS `CartTransactions` (
  `CartId` int(11) NOT NULL,
  `InventoryTransactionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE IF NOT EXISTS `Categories` (
`CategoryId` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `CreditCards`
--

CREATE TABLE IF NOT EXISTS `CreditCards` (
  `Number` varchar(16) NOT NULL,
  `Cvv` varchar(3) NOT NULL,
  `Name` text NOT NULL,
  `Balance` decimal(20,2) NOT NULL,
  `ExpDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Customers`
--

CREATE TABLE IF NOT EXISTS `Customers` (
`CustomerId` int(11) NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `Password` text NOT NULL,
  `UserName` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `InventoryTransactions`
--

CREATE TABLE IF NOT EXISTS `InventoryTransactions` (
`TransactionId` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `ProductId` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Deposition` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `Payments`
--

CREATE TABLE IF NOT EXISTS `Payments` (
`PaymentId` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `CreditCardNumber` varchar(16) NOT NULL,
  `Amount` decimal(20,2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `ProductDescriptions`
--

CREATE TABLE IF NOT EXISTS `ProductDescriptions` (
`ProductDescriptionId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `BrandId` int(11) NOT NULL,
  `ProductName` text NOT NULL,
  `ModelCode` text NOT NULL,
  `Description` text NOT NULL,
  `CreateDate` datetime NOT NULL,
  `Weight` decimal(10,2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `ProductDescriptionTags`
--

CREATE TABLE IF NOT EXISTS `ProductDescriptionTags` (
  `ProductDescriptionId` int(11) NOT NULL,
  `TagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ProductImages`
--

CREATE TABLE IF NOT EXISTS `ProductImages` (
`ImageId` int(11) NOT NULL,
  `ProductDescriptionId` int(11) NOT NULL,
  `ImageAddress` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE IF NOT EXISTS `Products` (
`ProductId` int(11) NOT NULL,
  `ProductDescriptionId` text NOT NULL,
  `Price` float NOT NULL,
  `CreateDate` datetime NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `Promotions`
--

CREATE TABLE IF NOT EXISTS `Promotions` (
`PromotionId` int(11) NOT NULL,
  `Type` int(1) NOT NULL,
  `Value` decimal(20,2) NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `AdminId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Sales`
--

CREATE TABLE IF NOT EXISTS `Sales` (
`SaleId` int(11) NOT NULL,
  `CartId` int(11) NOT NULL,
  `PaymentId` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `Tags`
--

CREATE TABLE IF NOT EXISTS `Tags` (
`TagId` int(11) NOT NULL,
  `Key` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=155 ;

-- --------------------------------------------------------

--
-- Table structure for table `WishLists`
--

CREATE TABLE IF NOT EXISTS `WishLists` (
`WishListId` int(11) NOT NULL,
  `LastUpdate` datetime NOT NULL,
  `CustomerId` int(11) NOT NULL,
  `Closed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AdditionProductDescriptionTags`
--
ALTER TABLE `AdditionProductDescriptionTags`
 ADD PRIMARY KEY (`ProductDescriptionId`,`TagId`);

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
 ADD PRIMARY KEY (`AdminId`);

--
-- Indexes for table `Brands`
--
ALTER TABLE `Brands`
 ADD PRIMARY KEY (`BrandId`), ADD UNIQUE KEY `name` (`Name`);

--
-- Indexes for table `Carts`
--
ALTER TABLE `Carts`
 ADD PRIMARY KEY (`CartId`);

--
-- Indexes for table `CartTransactions`
--
ALTER TABLE `CartTransactions`
 ADD PRIMARY KEY (`CartId`,`InventoryTransactionId`);

--
-- Indexes for table `Categories`
--
ALTER TABLE `Categories`
 ADD PRIMARY KEY (`CategoryId`), ADD UNIQUE KEY `name` (`Name`);

--
-- Indexes for table `CreditCards`
--
ALTER TABLE `CreditCards`
 ADD PRIMARY KEY (`Number`);

--
-- Indexes for table `Customers`
--
ALTER TABLE `Customers`
 ADD PRIMARY KEY (`CustomerId`), ADD UNIQUE KEY `UserName` (`UserName`);

--
-- Indexes for table `InventoryTransactions`
--
ALTER TABLE `InventoryTransactions`
 ADD PRIMARY KEY (`TransactionId`);

--
-- Indexes for table `Payments`
--
ALTER TABLE `Payments`
 ADD PRIMARY KEY (`PaymentId`);

--
-- Indexes for table `ProductDescriptions`
--
ALTER TABLE `ProductDescriptions`
 ADD PRIMARY KEY (`ProductDescriptionId`);

--
-- Indexes for table `ProductImages`
--
ALTER TABLE `ProductImages`
 ADD PRIMARY KEY (`ImageId`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
 ADD PRIMARY KEY (`ProductId`);

--
-- Indexes for table `Promotions`
--
ALTER TABLE `Promotions`
 ADD PRIMARY KEY (`PromotionId`);

--
-- Indexes for table `Sales`
--
ALTER TABLE `Sales`
 ADD PRIMARY KEY (`SaleId`);

--
-- Indexes for table `Tags`
--
ALTER TABLE `Tags`
 ADD PRIMARY KEY (`TagId`), ADD UNIQUE KEY `Key` (`Key`);

--
-- Indexes for table `WishLists`
--
ALTER TABLE `WishLists`
 ADD PRIMARY KEY (`WishListId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admins`
--
ALTER TABLE `Admins`
MODIFY `AdminId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Brands`
--
ALTER TABLE `Brands`
MODIFY `BrandId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `Carts`
--
ALTER TABLE `Carts`
MODIFY `CartId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Categories`
--
ALTER TABLE `Categories`
MODIFY `CategoryId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `Customers`
--
ALTER TABLE `Customers`
MODIFY `CustomerId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `InventoryTransactions`
--
ALTER TABLE `InventoryTransactions`
MODIFY `TransactionId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `Payments`
--
ALTER TABLE `Payments`
MODIFY `PaymentId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `ProductDescriptions`
--
ALTER TABLE `ProductDescriptions`
MODIFY `ProductDescriptionId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `ProductImages`
--
ALTER TABLE `ProductImages`
MODIFY `ImageId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
MODIFY `ProductId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `Promotions`
--
ALTER TABLE `Promotions`
MODIFY `PromotionId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Sales`
--
ALTER TABLE `Sales`
MODIFY `SaleId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `Tags`
--
ALTER TABLE `Tags`
MODIFY `TagId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=155;
--
-- AUTO_INCREMENT for table `WishLists`
--
ALTER TABLE `WishLists`
MODIFY `WishListId` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
