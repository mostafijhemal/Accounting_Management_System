-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2019 at 08:13 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_accounts`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `creditCurrentBalanceForTrialBalance` (`fromDate` DATE, `toDate` DATE, `accId` INT(100), `comId` INT(10) UNSIGNED) RETURNS DECIMAL(50,2) NO SQL
begin 
	select ifnull(SUM(ifnull(credit, 0) - ifnull(debit, 0)), 0) into @returnData from acc_ledger_data where voucher_date between fromDate and  toDate and account_id = accId and company_id = comId;
    
	RETURN @returnData;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `creditOpeningBalanceForTrialBalance` (`fromDate` DATE, `accId` INT(100), `comId` INT(10) UNSIGNED) RETURNS DECIMAL(50,2) NO SQL
begin 
	select ifnull(SUM(ifnull(credit, 0) - ifnull(debit, 0)), 0) into @returnData from acc_ledger_data where account_id = accId and voucher_date < fromDate and company_id = comId;
    
	RETURN @returnData;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `credit_debit` (`accountId` INT(50) UNSIGNED) RETURNS DECIMAL(20,2) NO SQL
begin 
	select SUM(credit - debit) into @returnData from acc_ledger_2018_01_01 where approve_id is not null and account_id = accountId;
    
	RETURN @returnData;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `debitCurrentBalanceForTrialBalance` (`fromDate` DATE, `toDate` DATE, `accId` INT(100), `comId` INT(10) UNSIGNED) RETURNS DECIMAL(50,2) NO SQL
begin 
	select ifnull(SUM(ifnull(debit, 0) - ifnull(credit, 0)), 0) into @returnData from acc_ledger_data where voucher_date between fromDate and  toDate and account_id = accId and company_id = comId;
    
	RETURN @returnData;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `debitOpeningBalanceForTrialBalance` (`fromDate` DATE, `accId` INT(100), `comId` INT(10) UNSIGNED) RETURNS DECIMAL(50,2) NO SQL
begin 
	select ifnull(SUM(ifnull(debit, 0) - ifnull(credit, 0)), 0) into @returnData from acc_ledger_data where account_id = accId and voucher_date < fromDate and company_id = comId;
    
	RETURN @returnData;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `debit_credit` (`accountId` INT(50) UNSIGNED) RETURNS DECIMAL(20,2) NO SQL
begin 
	select SUM(debit - credit) into @returnData from acc_ledger_2018_01_01 where approve_id is not null and account_id = accountId;
    
	RETURN @returnData;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `fromDate` (`fromDate` DATE, `accId` INT(100)) RETURNS DECIMAL(50,2) NO SQL
begin 
	select ifnull(SUM(debit - credit), 0) into @returnData from acc_ledger_data where account_id = accId and insert_date < fromDate;
    
	RETURN @returnData;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `access_list`
--

CREATE TABLE `access_list` (
  `id` int(255) UNSIGNED NOT NULL,
  `company_id` int(11) UNSIGNED NOT NULL,
  `controller_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `access_status` enum('Yes','No') CHARACTER SET latin1 NOT NULL DEFAULT 'No',
  `admin_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `access_list`
--

INSERT INTO `access_list` (`id`, `company_id`, `controller_id`, `user_id`, `access_status`, `admin_id`) VALUES
(1, 2, 23, 2, 'Yes', 1),
(2, 2, 28, 2, 'Yes', 1),
(3, 2, 27, 2, 'Yes', 1),
(4, 2, 31, 2, 'Yes', 1),
(5, 2, 25, 2, 'Yes', 1),
(6, 2, 30, 2, 'Yes', 1),
(7, 2, 26, 2, 'Yes', 1),
(8, 2, 24, 2, 'Yes', 1),
(9, 2, 32, 2, 'Yes', 1),
(10, 2, 18, 2, 'Yes', 1),
(11, 2, 19, 2, 'Yes', 1),
(12, 2, 13, 2, 'Yes', 1),
(13, 2, 16, 2, 'Yes', 1),
(14, 2, 29, 2, 'Yes', 1),
(15, 2, 14, 2, 'Yes', 1),
(16, 2, 9, 2, 'Yes', 1),
(17, 2, 12, 2, 'Yes', 1),
(18, 2, 10, 2, 'Yes', 1),
(19, 2, 21, 2, 'Yes', 1),
(20, 2, 22, 2, 'Yes', 1),
(21, 2, 11, 2, 'Yes', 1),
(22, 2, 15, 2, 'Yes', 1),
(23, 2, 20, 2, 'Yes', 1),
(24, 2, 17, 2, 'Yes', 1),
(25, 2, 1, 2, 'Yes', 1),
(26, 2, 5, 2, 'Yes', 1),
(27, 2, 4, 2, 'Yes', 1),
(28, 2, 6, 2, 'Yes', 1),
(29, 2, 2, 2, 'Yes', 1),
(30, 2, 3, 2, 'Yes', 1),
(31, 2, 7, 2, 'Yes', 1),
(32, 2, 8, 2, 'Yes', 1),
(33, 2, 33, 2, 'Yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acc_chart_of_accounts`
--

CREATE TABLE `acc_chart_of_accounts` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `acc_class_id` int(1) DEFAULT NULL,
  `p_id` int(100) NOT NULL,
  `account_id` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `account_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `status` enum('Parent','Child') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `head_status` enum('Enable','Disable') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `required_status` enum('No','Yes') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `edit_status` enum('Yes','No') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acc_chart_of_accounts`
--

INSERT INTO `acc_chart_of_accounts` (`id`, `company_id`, `acc_class_id`, `p_id`, `account_id`, `account_name`, `status`, `head_status`, `required_status`, `edit_status`) VALUES
(1, 1, 1, 0, '1', 'ASSETS', 'Parent', 'Enable', 'No', 'Yes'),
(2, 1, 1, 1, '101', 'CURRENT ASSETS', 'Parent', 'Enable', 'No', 'Yes'),
(3, 1, 1, 101, '10101', 'CASH & CASH EQUIVALENT', 'Parent', 'Enable', 'No', 'Yes'),
(4, 1, 1, 10101, '1010101', 'CASH IN HAND', 'Child', 'Enable', 'No', 'Yes'),
(5, 1, 1, 10101, '1010102', 'CASH AT BANK', 'Child', 'Enable', 'No', 'Yes'),
(6, 1, 1, 101, '10102', 'ADVANCE DEPOSIT & PREPAYMENT', 'Parent', 'Enable', 'No', 'Yes'),
(7, 1, 1, 10102, '1010201', 'HOUSE RENT - ADVANCE', 'Child', 'Enable', 'No', 'Yes'),
(8, 1, 1, 10102, '1010202', 'SECURITY DEPOSIT', 'Child', 'Enable', 'No', 'Yes'),
(9, 1, 1, 10102, '1010203', 'LOANS & ADVANCE', 'Child', 'Enable', 'No', 'Yes'),
(10, 1, 1, 101, '10103', 'BILLS RECEIVABLES', 'Child', 'Enable', 'No', 'Yes'),
(11, 1, 1, 101, '10104', 'INVENTORY', 'Child', 'Enable', 'No', 'Yes'),
(12, 1, 1, 101, '10105', 'PRELIMINARY EXPENSES', 'Child', 'Enable', 'No', 'Yes'),
(13, 1, 1, 1, '102', 'NON CURRENT ASSETS', 'Parent', 'Enable', 'No', 'Yes'),
(14, 1, 1, 102, '10201', 'PROPERTY, PLANT & EQUIPMENT', 'Parent', 'Enable', 'No', 'Yes'),
(15, 1, 1, 10201, '1020101', 'INTELLECTUAL ASSETS', 'Child', 'Enable', 'No', 'Yes'),
(16, 1, 1, 10201, '1020102', 'FURNITURE & FIXTURES', 'Child', 'Enable', 'No', 'Yes'),
(17, 1, 1, 10201, '1020103', 'AIR CONDITION', 'Child', 'Enable', 'No', 'Yes'),
(18, 1, 1, 10201, '1020104', 'ASSETS & OTHERS', 'Child', 'Enable', 'No', 'Yes'),
(19, 1, 1, 10201, '1020105', 'GENERATOR', 'Child', 'Enable', 'No', 'Yes'),
(20, 1, 1, 10201, '1020106', 'COMPUTER & MONITOR', 'Child', 'Enable', 'No', 'Yes'),
(21, 1, 1, 10201, '1020107', 'ACCESSORIES', 'Child', 'Enable', 'No', 'Yes'),
(22, 1, 1, 10201, '1020108', 'LAPTOP COMPUTER', 'Child', 'Enable', 'No', 'Yes'),
(23, 1, 1, 10201, '1020109', 'PRINTER & PHOTOCOPY', 'Child', 'Enable', 'No', 'Yes'),
(24, 1, 1, 10201, '1020110', 'PROJECTOR', 'Child', 'Enable', 'No', 'Yes'),
(25, 1, 1, 10201, '1020111', 'IPS', 'Child', 'Enable', 'No', 'Yes'),
(26, 1, 1, 10201, '1020112', 'VEHICLES', 'Child', 'Enable', 'No', 'Yes'),
(27, 1, 1, 10201, '1020113', 'MOTORCYCLE', 'Child', 'Enable', 'No', 'Yes'),
(28, 1, 2, 0, '2', 'LIABILITIES', 'Parent', 'Enable', 'No', 'Yes'),
(29, 1, 2, 2, '201', 'CURRENT LIABILITIES', 'Parent', 'Enable', 'No', 'Yes'),
(30, 1, 2, 201, '20101', 'LIABILITIES FOR EXPENSES', 'Child', 'Enable', 'No', 'Yes'),
(31, 1, 2, 201, '20102', 'BILLS PAYABLES', 'Child', 'Enable', 'No', 'Yes'),
(32, 1, 2, 201, '20103', 'TRADE CREDITORS, SALARIES & OTHER PAYABLES', 'Parent', 'Enable', 'No', 'Yes'),
(33, 1, 2, 20103, '2010301', 'PAYABLE - SALARY', 'Child', 'Enable', 'No', 'Yes'),
(34, 1, 2, 20103, '2010302', 'HOUSE RENT - PAYABLE', 'Child', 'Enable', 'No', 'Yes'),
(35, 1, 2, 201, '20104', 'LOAN FROM OTHERS', 'Child', 'Enable', 'No', 'Yes'),
(36, 1, 2, 2, '202', 'NON CURRENT LIABILITIES', 'Parent', 'Enable', 'No', 'Yes'),
(37, 1, 2, 202, '20201', 'SECURED LOAN', 'Child', 'Enable', 'No', 'Yes'),
(38, 1, 2, 202, '20202', 'UNSECURED LOAN', 'Parent', 'Enable', 'No', 'Yes'),
(39, 1, 2, 20202, '2020201', 'DIRECTORES LOAN', 'Child', 'Enable', 'No', 'Yes'),
(40, 1, 2, 2, '203', 'CAPITALS & OWNERS EQUITY', 'Parent', 'Enable', 'No', 'Yes'),
(41, 1, 2, 203, '20301', 'SHARE CAPITALS', 'Parent', 'Enable', 'No', 'Yes'),
(42, 1, 2, 20301, '2030101', 'MANAGING DIRECTOR', 'Child', 'Enable', 'No', 'Yes'),
(43, 1, 2, 20301, '2030102', 'PROFIT CAPITAL', 'Child', 'Enable', 'No', 'Yes'),
(44, 1, 2, 203, '20302', 'RETAINED EARNINGS', 'Child', 'Enable', 'No', 'Yes'),
(45, 1, 3, 0, '3', 'INCOME', 'Parent', 'Enable', 'No', 'Yes'),
(46, 1, 3, 3, '301', 'REVENUE FROM SALES', 'Parent', 'Enable', 'No', 'Yes'),
(47, 1, 3, 301, '30101', 'SALES', 'Child', 'Enable', 'No', 'Yes'),
(48, 1, 3, 3, '302', 'REVENUE FROM OTHERS', 'Child', 'Enable', 'No', 'Yes'),
(49, 1, 3, 3, '303', 'NON OPERATING REVENUE', 'Parent', 'Enable', 'No', 'Yes'),
(50, 1, 3, 303, '30301', 'MISCELLANEOUS INCOME', 'Parent', 'Enable', 'No', 'Yes'),
(51, 1, 3, 30301, '3030101', 'GAIN ON DISPOSAL OF FIXED ASSETS', 'Parent', 'Enable', 'No', 'Yes'),
(52, 1, 3, 3030101, '303010101', 'FURNITURE & FIXTURE', 'Child', 'Enable', 'No', 'Yes'),
(53, 1, 3, 3, '304', 'INCOME SUMMARY', 'Child', 'Enable', 'No', 'Yes'),
(54, 1, 4, 0, '4', 'EXPENSE', 'Parent', 'Enable', 'No', 'Yes'),
(55, 1, 4, 4, '401', 'CONVEYANCE', 'Child', 'Enable', 'No', 'Yes'),
(56, 1, 4, 4, '402', 'ENTERTAINMENT', 'Child', 'Enable', 'No', 'Yes'),
(57, 1, 4, 4, '403', 'PRINTING & STATIONERY', 'Child', 'Enable', 'No', 'Yes'),
(58, 1, 4, 4, '404', 'MISCELLENEOUS', 'Child', 'Enable', 'No', 'Yes'),
(59, 1, 4, 4, '405', 'HOUSE RENT - EXPENSE', 'Child', 'Enable', 'No', 'Yes'),
(60, 1, 4, 4, '406', 'ADJUSTMENTS & OTHERS', 'Parent', 'Enable', 'No', 'Yes'),
(61, 1, 4, 406, '40601', 'LOSS ON DISPOSAL OF FIXED ASSETS', 'Child', 'Enable', 'No', 'Yes'),
(62, 1, 4, 406, '40602', 'BROKEN,DAMAGED & REPLACEMENT', 'Child', 'Enable', 'No', 'Yes'),
(63, 1, 4, 406, '40603', 'BAD DEBT EXPENSES', 'Parent', 'Enable', 'No', 'Yes'),
(64, 1, 4, 40603, '4060301', 'BAD DEBTS', 'Child', 'Enable', 'No', 'Yes'),
(65, 1, 4, 406, '40604', 'VAT ADJUSTMENTS', 'Child', 'Enable', 'No', 'Yes'),
(66, 1, 4, 4, '407', 'SALARY & PAY', 'Parent', 'Enable', 'No', 'Yes'),
(67, 1, 4, 407, '40701', 'SALARY EXPENSE', 'Child', 'Enable', 'No', 'Yes'),
(68, 1, 4, 407, '40702', 'FESTIVAL BONUS', 'Child', 'Enable', 'No', 'Yes'),
(69, 1, 4, 407, '40703', 'PROFIT BONUS', 'Child', 'Enable', 'No', 'Yes'),
(70, 1, 4, 4, '408', 'EXPENSE FOR GOOD SOLD', 'Child', 'Enable', 'No', 'Yes'),
(71, 1, 4, 4, '409', 'WITHDRAW', 'Child', 'Enable', 'No', 'Yes'),
(72, 2, 1, 0, '1', 'ASSETS', 'Parent', 'Enable', 'No', 'Yes'),
(73, 2, 1, 1, '101', 'CURRENT ASSETS', 'Parent', 'Enable', 'No', 'Yes'),
(74, 2, 1, 101, '10101', 'CASH & CASH EQUIVALENT', 'Parent', 'Enable', 'No', 'Yes'),
(75, 2, 1, 10101, '1010101', 'CASH IN HAND', 'Child', 'Enable', 'No', 'Yes'),
(76, 2, 1, 10101, '1010102', 'CASH AT BANK', 'Child', 'Enable', 'No', 'Yes'),
(77, 2, 1, 101, '10102', 'ADVANCE DEPOSIT & PREPAYMENT', 'Parent', 'Enable', 'No', 'Yes'),
(78, 2, 1, 10102, '1010201', 'HOUSE RENT - ADVANCE', 'Child', 'Enable', 'No', 'Yes'),
(79, 2, 1, 10102, '1010202', 'SECURITY DEPOSIT', 'Child', 'Enable', 'No', 'Yes'),
(80, 2, 1, 10102, '1010203', 'LOANS & ADVANCE', 'Child', 'Enable', 'No', 'Yes'),
(81, 2, 1, 101, '10103', 'BILLS RECEIVABLES', 'Child', 'Enable', 'No', 'Yes'),
(82, 2, 1, 101, '10104', 'INVENTORY', 'Child', 'Enable', 'No', 'Yes'),
(83, 2, 1, 101, '10105', 'PRELIMINARY EXPENSES', 'Child', 'Enable', 'No', 'Yes'),
(84, 2, 1, 1, '102', 'NON CURRENT ASSETS', 'Parent', 'Enable', 'No', 'Yes'),
(85, 2, 1, 102, '10201', 'PROPERTY, PLANT & EQUIPMENT', 'Parent', 'Enable', 'No', 'Yes'),
(86, 2, 1, 10201, '1020101', 'INTELLECTUAL ASSETS', 'Child', 'Enable', 'No', 'Yes'),
(87, 2, 1, 10201, '1020102', 'FURNITURE & FIXTURES', 'Child', 'Enable', 'No', 'Yes'),
(88, 2, 1, 10201, '1020103', 'AIR CONDITION', 'Child', 'Enable', 'No', 'Yes'),
(89, 2, 1, 10201, '1020104', 'ASSETS & OTHERS', 'Child', 'Enable', 'No', 'Yes'),
(90, 2, 1, 10201, '1020105', 'GENERATOR', 'Child', 'Enable', 'No', 'Yes'),
(91, 2, 1, 10201, '1020106', 'COMPUTER & MONITOR', 'Child', 'Enable', 'No', 'Yes'),
(92, 2, 1, 10201, '1020107', 'ACCESSORIES', 'Child', 'Enable', 'No', 'Yes'),
(93, 2, 1, 10201, '1020108', 'LAPTOP COMPUTER', 'Child', 'Enable', 'No', 'Yes'),
(94, 2, 1, 10201, '1020109', 'PRINTER & PHOTOCOPY', 'Child', 'Enable', 'No', 'Yes'),
(95, 2, 1, 10201, '1020110', 'PROJECTOR', 'Child', 'Enable', 'No', 'Yes'),
(96, 2, 1, 10201, '1020111', 'IPS', 'Child', 'Enable', 'No', 'Yes'),
(97, 2, 1, 10201, '1020112', 'VEHICLES', 'Child', 'Enable', 'No', 'Yes'),
(98, 2, 1, 10201, '1020113', 'MOTORCYCLE', 'Child', 'Enable', 'No', 'Yes'),
(99, 2, 2, 0, '2', 'LIABILITIES', 'Parent', 'Enable', 'No', 'Yes'),
(100, 2, 2, 2, '201', 'CURRENT LIABILITIES', 'Parent', 'Enable', 'No', 'Yes'),
(101, 2, 2, 201, '20101', 'LIABILITIES FOR EXPENSES', 'Child', 'Enable', 'No', 'Yes'),
(102, 2, 2, 201, '20102', 'BILLS PAYABLES', 'Child', 'Enable', 'No', 'Yes'),
(103, 2, 2, 201, '20103', 'TRADE CREDITORS, SALARIES & OTHER PAYABLES', 'Parent', 'Enable', 'No', 'Yes'),
(104, 2, 2, 20103, '2010301', 'PAYABLE - SALARY', 'Child', 'Enable', 'No', 'Yes'),
(105, 2, 2, 20103, '2010302', 'HOUSE RENT - PAYABLE', 'Child', 'Enable', 'No', 'Yes'),
(106, 2, 2, 201, '20104', 'LOAN FROM OTHERS', 'Child', 'Enable', 'No', 'Yes'),
(107, 2, 2, 2, '202', 'NON CURRENT LIABILITIES', 'Parent', 'Enable', 'No', 'Yes'),
(108, 2, 2, 202, '20201', 'SECURED LOAN', 'Child', 'Enable', 'No', 'Yes'),
(109, 2, 2, 202, '20202', 'UNSECURED LOAN', 'Parent', 'Enable', 'No', 'Yes'),
(110, 2, 2, 20202, '2020201', 'DIRECTORES LOAN', 'Child', 'Enable', 'No', 'Yes'),
(111, 2, 2, 2, '203', 'CAPITALS & OWNERS EQUITY', 'Parent', 'Enable', 'No', 'Yes'),
(112, 2, 2, 203, '20301', 'SHARE CAPITALS', 'Parent', 'Enable', 'No', 'Yes'),
(113, 2, 2, 20301, '2030101', 'MANAGING DIRECTOR', 'Child', 'Enable', 'No', 'Yes'),
(114, 2, 2, 20301, '2030102', 'PROFIT CAPITAL', 'Child', 'Enable', 'No', 'Yes'),
(115, 2, 2, 203, '20302', 'RETAINED EARNINGS', 'Child', 'Enable', 'No', 'Yes'),
(116, 2, 3, 0, '3', 'INCOME', 'Parent', 'Enable', 'No', 'Yes'),
(117, 2, 3, 3, '301', 'REVENUE FROM SALES', 'Parent', 'Enable', 'No', 'Yes'),
(118, 2, 3, 301, '30101', 'SALES', 'Child', 'Enable', 'No', 'Yes'),
(119, 2, 3, 3, '302', 'REVENUE FROM OTHERS', 'Child', 'Enable', 'No', 'Yes'),
(120, 2, 3, 3, '303', 'NON OPERATING REVENUE', 'Parent', 'Enable', 'No', 'Yes'),
(121, 2, 3, 303, '30301', 'MISCELLANEOUS INCOME', 'Parent', 'Enable', 'No', 'Yes'),
(122, 2, 3, 30301, '3030101', 'GAIN ON DISPOSAL OF FIXED ASSETS', 'Parent', 'Enable', 'No', 'Yes'),
(123, 2, 3, 3030101, '303010101', 'FURNITURE & FIXTURE', 'Child', 'Enable', 'No', 'Yes'),
(124, 2, 3, 3, '304', 'INCOME SUMMARY', 'Child', 'Enable', 'No', 'Yes'),
(125, 2, 4, 0, '4', 'EXPENSE', 'Parent', 'Enable', 'No', 'Yes'),
(126, 2, 4, 4, '401', 'CONVEYANCE', 'Child', 'Enable', 'No', 'Yes'),
(127, 2, 4, 4, '402', 'ENTERTAINMENT', 'Child', 'Enable', 'No', 'Yes'),
(128, 2, 4, 4, '403', 'PRINTING & STATIONERY', 'Child', 'Enable', 'No', 'Yes'),
(129, 2, 4, 4, '404', 'MISCELLENEOUS', 'Child', 'Enable', 'No', 'Yes'),
(130, 2, 4, 4, '405', 'HOUSE RENT - EXPENSE', 'Child', 'Enable', 'No', 'Yes'),
(131, 2, 4, 4, '406', 'ADJUSTMENTS & OTHERS', 'Parent', 'Enable', 'No', 'Yes'),
(132, 2, 4, 406, '40601', 'LOSS ON DISPOSAL OF FIXED ASSETS', 'Child', 'Enable', 'No', 'Yes'),
(133, 2, 4, 406, '40602', 'BROKEN,DAMAGED & REPLACEMENT', 'Child', 'Enable', 'No', 'Yes'),
(134, 2, 4, 406, '40603', 'BAD DEBT EXPENSES', 'Parent', 'Enable', 'No', 'Yes'),
(135, 2, 4, 40603, '4060301', 'BAD DEBTS', 'Child', 'Enable', 'No', 'Yes'),
(136, 2, 4, 406, '40604', 'VAT ADJUSTMENTS', 'Child', 'Enable', 'No', 'Yes'),
(137, 2, 4, 4, '407', 'SALARY & PAY', 'Parent', 'Enable', 'No', 'Yes'),
(138, 2, 4, 407, '40701', 'SALARY EXPENSE', 'Parent', 'Enable', 'No', 'Yes'),
(139, 2, 4, 407, '40702', 'FESTIVAL BONUS', 'Child', 'Enable', 'No', 'Yes'),
(140, 2, 4, 407, '40703', 'PROFIT BONUS', 'Child', 'Enable', 'No', 'Yes'),
(141, 2, 4, 4, '408', 'EXPENSE FOR GOOD SOLD', 'Child', 'Enable', 'No', 'Yes'),
(142, 2, 4, 4, '409', 'WITHDRAW', 'Child', 'Enable', 'No', 'Yes'),
(143, 2, 4, 40701, '4070101', 'Managing Director', 'Child', 'Enable', 'No', 'Yes'),
(144, 2, 4, 40701, '4070102', 'Managing Director', 'Child', 'Enable', 'No', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `acc_finance_table`
--

CREATE TABLE `acc_finance_table` (
  `id` int(255) UNSIGNED NOT NULL,
  `company_id` int(5) UNSIGNED NOT NULL,
  `financial_year_auto_id` int(11) DEFAULT NULL,
  `insert_date` date DEFAULT NULL,
  `system_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `account_id` int(100) NOT NULL,
  `year_opening_debit` decimal(50,2) NOT NULL DEFAULT '0.00',
  `year_opening_credit` decimal(50,2) NOT NULL DEFAULT '0.00',
  `day_opening_debit` decimal(50,2) NOT NULL DEFAULT '0.00',
  `day_opening_credit` decimal(50,2) NOT NULL DEFAULT '0.00',
  `total_debit` decimal(50,2) NOT NULL DEFAULT '0.00',
  `total_credit` decimal(50,2) NOT NULL DEFAULT '0.00',
  `status` enum('Active','Inactive') CHARACTER SET latin1 NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acc_ledger_data`
--

CREATE TABLE `acc_ledger_data` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `company_id` int(5) UNSIGNED NOT NULL,
  `financial_year_auto_id` int(11) DEFAULT NULL,
  `voucher_info_auto_id` bigint(255) UNSIGNED DEFAULT NULL,
  `voucher_no` int(3) UNSIGNED ZEROFILL DEFAULT NULL,
  `voucher_date` date NOT NULL,
  `system_date` datetime NOT NULL,
  `account_id` int(100) UNSIGNED NOT NULL,
  `debit` decimal(50,2) NOT NULL DEFAULT '0.00',
  `credit` decimal(50,2) NOT NULL DEFAULT '0.00',
  `narration` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `opening_approve` enum('1','2') CHARACTER SET latin1 DEFAULT '1' COMMENT '1 = Opening Painding, 2 = Opening Approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acc_voucher_details`
--

CREATE TABLE `acc_voucher_details` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `voucher_info_auto_id` bigint(255) UNSIGNED NOT NULL,
  `account_id` int(100) UNSIGNED NOT NULL,
  `debit` decimal(50,2) DEFAULT NULL,
  `credit` decimal(50,2) DEFAULT NULL,
  `narration` varchar(255) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acc_voucher_info`
--

CREATE TABLE `acc_voucher_info` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `company_id` int(5) UNSIGNED NOT NULL,
  `financial_year_auto_id` int(11) DEFAULT NULL,
  `voucher_type_auto_id` int(10) UNSIGNED NOT NULL,
  `serial_no` int(3) UNSIGNED ZEROFILL NOT NULL,
  `voucher_no` int(3) UNSIGNED ZEROFILL DEFAULT NULL,
  `voucher_date` date DEFAULT NULL,
  `system_date` datetime DEFAULT NULL,
  `voucher_detail` varchar(500) CHARACTER SET latin1 DEFAULT NULL,
  `prepare_by` int(10) UNSIGNED NOT NULL,
  `check_by` int(10) UNSIGNED DEFAULT NULL,
  `approve_by` int(10) UNSIGNED DEFAULT NULL,
  `current_station` enum('Prepare','Check','Approve') CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acc_voucher_type_list`
--

CREATE TABLE `acc_voucher_type_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `type_detail` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `status` enum('Active','Inactive') CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acc_year_closing_check`
--

CREATE TABLE `acc_year_closing_check` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `data_name` enum('running') CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='this table use for year closing check for destroy session ';

-- --------------------------------------------------------

--
-- Table structure for table `app_user`
--

CREATE TABLE `app_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `app_user_auto_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `login_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `password` varchar(35) CHARACTER SET latin1 NOT NULL,
  `designition` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `cell` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `present_address` varchar(150) CHARACTER SET latin1 NOT NULL,
  `permanent_address` varchar(150) CHARACTER SET latin1 NOT NULL,
  `image` longtext CHARACTER SET latin1,
  `status` varchar(15) CHARACTER SET latin1 NOT NULL DEFAULT 'active',
  `user_type_id` int(11) DEFAULT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `app_user`
--

INSERT INTO `app_user` (`id`, `company_id`, `app_user_auto_id`, `full_name`, `login_name`, `password`, `designition`, `email`, `cell`, `present_address`, `permanent_address`, `image`, `status`, `user_type_id`, `create_at`, `update_at`) VALUES
(1, 1, 1, 'Robiul Awal', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Accounts Manager', 'awalrobiul70@gmail.com', '01709073511', 'Dhaka', 'Trishal, Mymensingh', NULL, 'active', 3, '2018-01-11 11:34:11', '2018-09-02 10:08:02'),
(2, 2, 1, 'MD. Shakirul Islam', 'shakirul', 'e10adc3949ba59abbe56e057f20f883e', 'IT Officer', 'shoaib7323@gmail.com', '01846291292', '.......', '...........', NULL, 'active', 1, '2019-09-06 12:26:18', '2019-09-06 01:13:36');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) CHARACTER SET latin1 NOT NULL,
  `ip_address` varchar(45) CHARACTER SET latin1 NOT NULL,
  `timestamp` int(11) NOT NULL,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('2hvnpbaui7o155vghbv1udq81bum1uu6', '::1', 1567710822, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373731303536313b6170705f7573657269647c4e3b6170705f757365725f747970655f69647c4e3b6170705f757365725f64657369676e6974696f6e7c4e3b6170705f757365725f66756c6c5f6e616d657c4e3b6170705f6c6f67696e5f6e616d657c4e3b636f6d70616e795f69647c4e3b66696e616e6369616c5f796561725f6175746f5f69647c4e3b66726f6d5f796561727c4e3b746f5f796561727c4e3b737563636573737c733a303a22223b6d6573736567657c733a303a22223b),
('3j2cfv6c3vlohpfrnkfoflpbt9mlonbl', '::1', 1567710538, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373730373431313b6170705f7573657269647c733a313a2232223b6170705f757365725f747970655f69647c733a313a2232223b6170705f757365725f64657369676e6974696f6e7c733a31303a224954204f666669636572223b6170705f757365725f66756c6c5f6e616d657c733a31383a224d442e2053686f61696220486f737361696e223b6170705f6c6f67696e5f6e616d657c733a363a2273686f616962223b636f6d70616e795f69647c733a313a2232223b66696e616e6369616c5f796561725f6175746f5f69647c4e3b66726f6d5f796561727c4e3b746f5f796561727c4e3b737563636573737c733a303a22223b6d6573736567657c733a303a22223b6d73677c733a303a22223b),
('581h29irm9gtdv2ol7c6kf05kgrub2a8', '::1', 1569694153, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393639333638373b6170705f7573657269647c733a313a2232223b6170705f757365725f747970655f69647c733a313a2231223b6170705f757365725f64657369676e6974696f6e7c733a31303a224954204f666669636572223b6170705f757365725f66756c6c5f6e616d657c733a31383a224d442e205368616b6972756c2049736c616d223b6170705f6c6f67696e5f6e616d657c733a383a227368616b6972756c223b636f6d70616e795f69647c733a313a2232223b66696e616e6369616c5f796561725f6175746f5f69647c733a313a2232223b66726f6d5f796561727c733a31303a22323031392d30312d3031223b746f5f796561727c733a31303a22323031392d30392d3036223b),
('gvd7c9mcg3ag2fn0082rdtd7ls32in3q', '::1', 1568693705, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536383639333639333b6170705f7573657269647c733a313a2231223b6170705f757365725f747970655f69647c733a313a2233223b6170705f757365725f64657369676e6974696f6e7c733a31363a224163636f756e7473204d616e61676572223b6170705f757365725f66756c6c5f6e616d657c733a31313a22526f6269756c204177616c223b6170705f6c6f67696e5f6e616d657c733a353a2261646d696e223b636f6d70616e795f69647c733a313a2231223b66696e616e6369616c5f796561725f6175746f5f69647c733a313a2231223b66726f6d5f796561727c733a31303a22323031392d30312d3031223b746f5f796561727c733a31303a22323031392d30392d3036223b737563636573737c733a303a22223b6d6573736567657c733a303a22223b),
('nurnhhhv4sr3qkfi9bishda8subs2n58', '::1', 1567707384, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373730323838393b6170705f7573657269647c733a313a2231223b6170705f757365725f747970655f69647c733a313a2233223b6170705f757365725f64657369676e6974696f6e7c733a31363a224163636f756e7473204d616e61676572223b6170705f757365725f66756c6c5f6e616d657c733a31313a22526f6269756c204177616c223b6170705f6c6f67696e5f6e616d657c733a353a2261646d696e223b636f6d70616e795f69647c733a313a2231223b66696e616e6369616c5f796561725f6175746f5f69647c4e3b66726f6d5f796561727c4e3b746f5f796561727c4e3b737563636573737c733a303a22223b6d6573736567657c733a303a22223b),
('orf7h1dse1ok81humfbk4mau1vro90nb', '::1', 1567921719, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536373731303833353b6170705f7573657269647c733a313a2231223b6170705f757365725f747970655f69647c733a313a2233223b6170705f757365725f64657369676e6974696f6e7c733a31363a224163636f756e7473204d616e61676572223b6170705f757365725f66756c6c5f6e616d657c733a31313a22526f6269756c204177616c223b6170705f6c6f67696e5f6e616d657c733a353a2261646d696e223b636f6d70616e795f69647c733a313a2231223b66696e616e6369616c5f796561725f6175746f5f69647c733a313a2231223b66726f6d5f796561727c733a31303a22323031392d30312d3031223b746f5f796561727c733a31303a22323031392d30392d3036223b737563636573737c733a303a22223b6d6573736567657c733a303a22223b);

-- --------------------------------------------------------

--
-- Table structure for table `company_register_table`
--

CREATE TABLE `company_register_table` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `short_name` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `email_or_phone` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `phone_no` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `chif_name` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `a_chif_name` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `financial_year_from` date DEFAULT NULL,
  `financial_year_end` date DEFAULT NULL,
  `number_of_decimal_place` int(11) DEFAULT NULL,
  `symbol_of_decimal_portion` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `show_amount_in_millions` enum('No','Yes') CHARACTER SET latin1 DEFAULT NULL,
  `account_head_code` enum('Manual','Auto') CHARACTER SET latin1 DEFAULT NULL,
  `voucher_validation_active` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `logo` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `fab_icon` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `address` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET latin1 DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `company_register_table`
--

INSERT INTO `company_register_table` (`id`, `company_name`, `short_name`, `email_or_phone`, `phone_no`, `email`, `chif_name`, `a_chif_name`, `country_id`, `financial_year_from`, `financial_year_end`, `number_of_decimal_place`, `symbol_of_decimal_portion`, `show_amount_in_millions`, `account_head_code`, `voucher_validation_active`, `logo`, `fab_icon`, `address`, `status`) VALUES
(1, 'Company 1', 'c1', '01929588684', '01929588684', 'najmul@gmail.com', 'Najmul Hossain', 'Billal', 19, '2018-01-02', '2018-12-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Trishal Bazar, Trishal, Mymensingh', 'active'),
(2, 'Datasoft Systems Bangladesh Limited', 'Datasoft', '', '01846291292', 'shoaib7323@gmail.com', 'MD. Shoaib Hossain', 'Sakirul Islam', 19, '2019-01-01', '2019-09-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Dhaka', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `controller_list`
--

CREATE TABLE `controller_list` (
  `id` int(11) UNSIGNED NOT NULL,
  `controller_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `function_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `url_link` varchar(100) CHARACTER SET latin1 NOT NULL,
  `title_text` varchar(150) CHARACTER SET latin1 NOT NULL,
  `detail` varchar(255) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `controller_list`
--

INSERT INTO `controller_list` (`id`, `controller_name`, `function_name`, `url_link`, `title_text`, `detail`) VALUES
(1, 'App', 'index', 'dashboard/summary', 'Application Dashboard', 'It Contains Summary Report'),
(2, 'App_user_manage', 'index', 'user/adduser', 'Create User Page View', 'User ListView, Add, Edit, Delete'),
(3, 'App_user_manage', 'userDataStore', 'user/save', 'User Data Save', ''),
(4, 'App_user_manage', 'accessRulePageLoad', 'user/accessRule', 'User Access Page View', ''),
(5, 'App_user_manage', 'accessRuleDataSave', 'user/accessSave', 'User Access Data Save &amp; Update', 'With Out Superadmin'),
(6, 'App_user_manage', 'allUserAccessList', 'user/accessList', 'User Access List', 'All Controller Access List With Access Status'),
(7, 'ChartOfAccounts', 'index', 'acc/chartCreate', 'Chart Of Accounts', 'Chart Of Accounts Create, Edit, Delete, View'),
(8, 'ChartOfAccounts', 'saveChartOfAccount', 'acc/chartAccSave', 'Chart Of Accounts Save', 'Chart Of Accounts Save &amp; Update'),
(9, 'AccVoucher', 'journalVoucher', 'acc/voucherCreate', 'Voucher Create', 'Any Type Voucher Create Page'),
(10, 'AccVoucher', 'manageVoucherType', 'acc/voucherTypeManage', 'Voucher Type Manage', 'Create Voucher Type'),
(11, 'AccVoucher', 'saveVoucherType', 'acc/vTypeSave', 'Voucher Type Data Save, Update', 'Voucher Type Data Save, Update'),
(12, 'AccVoucher', 'journalVoucherSave', 'acc/voucherSave', 'Voucher Data Save, Update', 'New Voucher Data Save and Update'),
(13, 'AccVoucher', 'checkVoucher', 'acc/vCheck', 'Voucher Check', 'Voucher Check'),
(14, 'AccVoucher', 'deleteVoucher', 'acc/dVoucer', 'Delete Voucher', ''),
(15, 'AccVoucher', 'voucher', 'accReport/voucher', 'Show Voucher Data', ''),
(16, 'AccVoucher', 'checkVoucherAction', 'acc/voucherCheckAction', 'Voucher Checked Action', 'Voucher Checked'),
(17, 'AccVoucher', 'voucherReturnToCreateAction', 'acc/voucherReturnToPrepare', 'Voucher Return For Update', ''),
(18, 'AccVoucher', 'approveVoucher', 'acc/vApprove', 'Voucher Approve', ''),
(19, 'AccVoucher', 'approveVoucherAction', 'acc/voucherApproveAction', 'Voucher Approved Action', ''),
(20, 'AccVoucher', 'voucherReturnToCheckAction', 'acc/voucherReturnToCheck', 'Voucher Return For Check', 'Voucher Return From Approve to Check'),
(21, 'AccVoucher', 'openingDataEntry', 'acc/opening', 'Opening Data Entry Page', ''),
(22, 'AccVoucher', 'openingDataSave', 'acc/saveOpening', 'Opening Data Save &amp; Update', ''),
(23, 'AccReport', 'approveVoucherList', 'accReport/approveVoucherList', 'Get All Approve Voucher List', ''),
(24, 'AccReport', 'unapproveVoucherList', 'accReport/unapproveVoucherList', 'Get All Unapprove Voucher List', ''),
(25, 'AccReport', 'findLedgerReport', 'accReport/findLedgerReportPage', 'Ledger Report Filter Page', ''),
(26, 'AccReport', 'findTrialBalanceReport', 'accReport/findTrialBalanceReport', 'Get Trial Balance', ''),
(27, 'AccReport', 'findDayBookReport', 'accReport/findDayBookReport', 'Get Day Book Report', ''),
(28, 'AccReport', 'findBalanceSheet', 'accReport/findBalanceSheet', 'Get Balance Sheet Report', ''),
(29, 'AccVoucher', 'dayOpenOrClosePage', 'acc/dayOpenClose/0', 'Day Open or Close for Data Insert', ''),
(30, 'AccReport', 'findOwnersEquityReport', 'accReport/findOwnersEquityReport', 'Get Owner\'s Equity Report', ''),
(31, 'AccReport', 'findIncomeStatementReport', 'accReport/findIncomeStatementReport', 'Get Income Statement Report', ''),
(32, 'AccReport', 'yearClosing', 'accYearClosing/yearClosing', 'Financial Year Close', 'Very Carefully use and Access'),
(33, 'InstituteInfo', 'index', 'company/information', 'Comapny Information Update', '');

-- --------------------------------------------------------

--
-- Table structure for table `country_list`
--

CREATE TABLE `country_list` (
  `country_id` int(5) UNSIGNED NOT NULL,
  `country_code` char(2) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `country_name` varchar(45) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `currency_symbol` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `capital` varchar(30) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `country_list`
--

INSERT INTO `country_list` (`country_id`, `country_code`, `country_name`, `currency_symbol`, `capital`) VALUES
(1, 'AD', 'Andorra', 'EUR', 'Andorra la Vella'),
(2, 'AE', 'United Arab Emirates', 'AED', 'Abu Dhabi'),
(3, 'AF', 'Afghanistan', 'AFN', 'Kabul'),
(4, 'AG', 'Antigua and Barbuda', 'XCD', 'St. John\'s'),
(5, 'AI', 'Anguilla', 'XCD', 'The Valley'),
(6, 'AL', 'Albania', 'ALL', 'Tirana'),
(7, 'AM', 'Armenia', 'AMD', 'Yerevan'),
(8, 'AO', 'Angola', 'AOA', 'Luanda'),
(9, 'AQ', 'Antarctica', '', ''),
(10, 'AR', 'Argentina', 'ARS', 'Buenos Aires'),
(11, 'AS', 'American Samoa', 'USD', 'Pago Pago'),
(12, 'AT', 'Austria', 'EUR', 'Vienna'),
(13, 'AU', 'Australia', 'AUD', 'Canberra'),
(14, 'AW', 'Aruba', 'AWG', 'Oranjestad'),
(15, 'AX', 'Åland', 'EUR', 'Mariehamn'),
(16, 'AZ', 'Azerbaijan', 'AZN', 'Baku'),
(17, 'BA', 'Bosnia and Herzegovina', 'BAM', 'Sarajevo'),
(18, 'BB', 'Barbados', 'BBD', 'Bridgetown'),
(19, 'BD', 'Bangladesh', 'BDT', 'Dhaka'),
(20, 'BE', 'Belgium', 'EUR', 'Brussels'),
(21, 'BF', 'Burkina Faso', 'XOF', 'Ouagadougou'),
(22, 'BG', 'Bulgaria', 'BGN', 'Sofia'),
(23, 'BH', 'Bahrain', 'BHD', 'Manama'),
(24, 'BI', 'Burundi', 'BIF', 'Bujumbura'),
(25, 'BJ', 'Benin', 'XOF', 'Porto-Novo'),
(26, 'BL', 'Saint Barthélemy', 'EUR', 'Gustavia'),
(27, 'BM', 'Bermuda', 'BMD', 'Hamilton'),
(28, 'BN', 'Brunei', 'BND', 'Bandar Seri Begawan'),
(29, 'BO', 'Bolivia', 'BOB', 'Sucre'),
(30, 'BQ', 'Bonaire', 'USD', 'Kralendijk'),
(31, 'BR', 'Brazil', 'BRL', 'Brasília'),
(32, 'BS', 'Bahamas', 'BSD', 'Nassau'),
(33, 'BT', 'Bhutan', 'BTN', 'Thimphu'),
(34, 'BV', 'Bouvet Island', 'NOK', ''),
(35, 'BW', 'Botswana', 'BWP', 'Gaborone'),
(36, 'BY', 'Belarus', 'BYR', 'Minsk'),
(37, 'BZ', 'Belize', 'BZD', 'Belmopan'),
(38, 'CA', 'Canada', 'CAD', 'Ottawa'),
(39, 'CC', 'Cocos [Keeling] Islands', 'AUD', 'West Island'),
(40, 'CD', 'Democratic Republic of the Congo', 'CDF', 'Kinshasa'),
(41, 'CF', 'Central African Republic', 'XAF', 'Bangui'),
(42, 'CG', 'Republic of the Congo', 'XAF', 'Brazzaville'),
(43, 'CH', 'Switzerland', 'CHF', 'Bern'),
(44, 'CI', 'Ivory Coast', 'XOF', 'Yamoussoukro'),
(45, 'CK', 'Cook Islands', 'NZD', 'Avarua'),
(46, 'CL', 'Chile', 'CLP', 'Santiago'),
(47, 'CM', 'Cameroon', 'XAF', 'Yaoundé'),
(48, 'CN', 'China', 'CNY', 'Beijing'),
(49, 'CO', 'Colombia', 'COP', 'Bogotá'),
(50, 'CR', 'Costa Rica', 'CRC', 'San José'),
(51, 'CU', 'Cuba', 'CUP', 'Havana'),
(52, 'CV', 'Cape Verde', 'CVE', 'Praia'),
(53, 'CW', 'Curacao', 'ANG', 'Willemstad'),
(54, 'CX', 'Christmas Island', 'AUD', 'Flying Fish Cove'),
(55, 'CY', 'Cyprus', 'EUR', 'Nicosia'),
(56, 'CZ', 'Czechia', 'CZK', 'Prague'),
(57, 'DE', 'Germany', 'EUR', 'Berlin'),
(58, 'DJ', 'Djibouti', 'DJF', 'Djibouti'),
(59, 'DK', 'Denmark', 'DKK', 'Copenhagen'),
(60, 'DM', 'Dominica', 'XCD', 'Roseau'),
(61, 'DO', 'Dominican Republic', 'DOP', 'Santo Domingo'),
(62, 'DZ', 'Algeria', 'DZD', 'Algiers'),
(63, 'EC', 'Ecuador', 'USD', 'Quito'),
(64, 'EE', 'Estonia', 'EUR', 'Tallinn'),
(65, 'EG', 'Egypt', 'EGP', 'Cairo'),
(66, 'EH', 'Western Sahara', 'MAD', 'Laâyoune / El Aaiún'),
(67, 'ER', 'Eritrea', 'ERN', 'Asmara'),
(68, 'ES', 'Spain', 'EUR', 'Madrid'),
(69, 'ET', 'Ethiopia', 'ETB', 'Addis Ababa'),
(70, 'FI', 'Finland', 'EUR', 'Helsinki'),
(71, 'FJ', 'Fiji', 'FJD', 'Suva'),
(72, 'FK', 'Falkland Islands', 'FKP', 'Stanley'),
(73, 'FM', 'Micronesia', 'USD', 'Palikir'),
(74, 'FO', 'Faroe Islands', 'DKK', 'Tórshavn'),
(75, 'FR', 'France', 'EUR', 'Paris'),
(76, 'GA', 'Gabon', 'XAF', 'Libreville'),
(77, 'GB', 'United Kingdom', 'GBP', 'London'),
(78, 'GD', 'Grenada', 'XCD', 'St. George\'s'),
(79, 'GE', 'Georgia', 'GEL', 'Tbilisi'),
(80, 'GF', 'French Guiana', 'EUR', 'Cayenne'),
(81, 'GG', 'Guernsey', 'GBP', 'St Peter Port'),
(82, 'GH', 'Ghana', 'GHS', 'Accra'),
(83, 'GI', 'Gibraltar', 'GIP', 'Gibraltar'),
(84, 'GL', 'Greenland', 'DKK', 'Nuuk'),
(85, 'GM', 'Gambia', 'GMD', 'Bathurst'),
(86, 'GN', 'Guinea', 'GNF', 'Conakry'),
(87, 'GP', 'Guadeloupe', 'EUR', 'Basse-Terre'),
(88, 'GQ', 'Equatorial Guinea', 'XAF', 'Malabo'),
(89, 'GR', 'Greece', 'EUR', 'Athens'),
(90, 'GS', 'South Georgia and the South Sandwich Islands', 'GBP', 'Grytviken'),
(91, 'GT', 'Guatemala', 'GTQ', 'Guatemala City'),
(92, 'GU', 'Guam', 'USD', 'Hagåtña'),
(93, 'GW', 'Guinea-Bissau', 'XOF', 'Bissau'),
(94, 'GY', 'Guyana', 'GYD', 'Georgetown'),
(95, 'HK', 'Hong Kong', 'HKD', 'Hong Kong'),
(96, 'HM', 'Heard Island and McDonald Islands', 'AUD', ''),
(97, 'HN', 'Honduras', 'HNL', 'Tegucigalpa'),
(98, 'HR', 'Croatia', 'HRK', 'Zagreb'),
(99, 'HT', 'Haiti', 'HTG', 'Port-au-Prince'),
(100, 'HU', 'Hungary', 'HUF', 'Budapest'),
(101, 'ID', 'Indonesia', 'IDR', 'Jakarta'),
(102, 'IE', 'Ireland', 'EUR', 'Dublin'),
(103, 'IL', 'Israel', 'ILS', ''),
(104, 'IM', 'Isle of Man', 'GBP', 'Douglas'),
(105, 'IN', 'India', 'INR', 'New Delhi'),
(106, 'IO', 'British Indian Ocean Territory', 'USD', ''),
(107, 'IQ', 'Iraq', 'IQD', 'Baghdad'),
(108, 'IR', 'Iran', 'IRR', 'Tehran'),
(109, 'IS', 'Iceland', 'ISK', 'Reykjavik'),
(110, 'IT', 'Italy', 'EUR', 'Rome'),
(111, 'JE', 'Jersey', 'GBP', 'Saint Helier'),
(112, 'JM', 'Jamaica', 'JMD', 'Kingston'),
(113, 'JO', 'Jordan', 'JOD', 'Amman'),
(114, 'JP', 'Japan', 'JPY', 'Tokyo'),
(115, 'KE', 'Kenya', 'KES', 'Nairobi'),
(116, 'KG', 'Kyrgyzstan', 'KGS', 'Bishkek'),
(117, 'KH', 'Cambodia', 'KHR', 'Phnom Penh'),
(118, 'KI', 'Kiribati', 'AUD', 'Tarawa'),
(119, 'KM', 'Comoros', 'KMF', 'Moroni'),
(120, 'KN', 'Saint Kitts and Nevis', 'XCD', 'Basseterre'),
(121, 'KP', 'North Korea', 'KPW', 'Pyongyang'),
(122, 'KR', 'South Korea', 'KRW', 'Seoul'),
(123, 'KW', 'Kuwait', 'KWD', 'Kuwait City'),
(124, 'KY', 'Cayman Islands', 'KYD', 'George Town'),
(125, 'KZ', 'Kazakhstan', 'KZT', 'Astana'),
(126, 'LA', 'Laos', 'LAK', 'Vientiane'),
(127, 'LB', 'Lebanon', 'LBP', 'Beirut'),
(128, 'LC', 'Saint Lucia', 'XCD', 'Castries'),
(129, 'LI', 'Liechtenstein', 'CHF', 'Vaduz'),
(130, 'LK', 'Sri Lanka', 'LKR', 'Colombo'),
(131, 'LR', 'Liberia', 'LRD', 'Monrovia'),
(132, 'LS', 'Lesotho', 'LSL', 'Maseru'),
(133, 'LT', 'Lithuania', 'EUR', 'Vilnius'),
(134, 'LU', 'Luxembourg', 'EUR', 'Luxembourg'),
(135, 'LV', 'Latvia', 'EUR', 'Riga'),
(136, 'LY', 'Libya', 'LYD', 'Tripoli'),
(137, 'MA', 'Morocco', 'MAD', 'Rabat'),
(138, 'MC', 'Monaco', 'EUR', 'Monaco'),
(139, 'MD', 'Moldova', 'MDL', 'Chişinău'),
(140, 'ME', 'Montenegro', 'EUR', 'Podgorica'),
(141, 'MF', 'Saint Martin', 'EUR', 'Marigot'),
(142, 'MG', 'Madagascar', 'MGA', 'Antananarivo'),
(143, 'MH', 'Marshall Islands', 'USD', 'Majuro'),
(144, 'MK', 'Macedonia', 'MKD', 'Skopje'),
(145, 'ML', 'Mali', 'XOF', 'Bamako'),
(146, 'MM', 'Myanmar [Burma]', 'MMK', 'Naypyitaw'),
(147, 'MN', 'Mongolia', 'MNT', 'Ulan Bator'),
(148, 'MO', 'Macao', 'MOP', 'Macao'),
(149, 'MP', 'Northern Mariana Islands', 'USD', 'Saipan'),
(150, 'MQ', 'Martinique', 'EUR', 'Fort-de-France'),
(151, 'MR', 'Mauritania', 'MRO', 'Nouakchott'),
(152, 'MS', 'Montserrat', 'XCD', 'Plymouth'),
(153, 'MT', 'Malta', 'EUR', 'Valletta'),
(154, 'MU', 'Mauritius', 'MUR', 'Port Louis'),
(155, 'MV', 'Maldives', 'MVR', 'Malé'),
(156, 'MW', 'Malawi', 'MWK', 'Lilongwe'),
(157, 'MX', 'Mexico', 'MXN', 'Mexico City'),
(158, 'MY', 'Malaysia', 'MYR', 'Kuala Lumpur'),
(159, 'MZ', 'Mozambique', 'MZN', 'Maputo'),
(160, 'NA', 'Namibia', 'NAD', 'Windhoek'),
(161, 'NC', 'New Caledonia', 'XPF', 'Noumea'),
(162, 'NE', 'Niger', 'XOF', 'Niamey'),
(163, 'NF', 'Norfolk Island', 'AUD', 'Kingston'),
(164, 'NG', 'Nigeria', 'NGN', 'Abuja'),
(165, 'NI', 'Nicaragua', 'NIO', 'Managua'),
(166, 'NL', 'Netherlands', 'EUR', 'Amsterdam'),
(167, 'NO', 'Norway', 'NOK', 'Oslo'),
(168, 'NP', 'Nepal', 'NPR', 'Kathmandu'),
(169, 'NR', 'Nauru', 'AUD', 'Yaren'),
(170, 'NU', 'Niue', 'NZD', 'Alofi'),
(171, 'NZ', 'New Zealand', 'NZD', 'Wellington'),
(172, 'OM', 'Oman', 'OMR', 'Muscat'),
(173, 'PA', 'Panama', 'PAB', 'Panama City'),
(174, 'PE', 'Peru', 'PEN', 'Lima'),
(175, 'PF', 'French Polynesia', 'XPF', 'Papeete'),
(176, 'PG', 'Papua New Guinea', 'PGK', 'Port Moresby'),
(177, 'PH', 'Philippines', 'PHP', 'Manila'),
(178, 'PK', 'Pakistan', 'PKR', 'Islamabad'),
(179, 'PL', 'Poland', 'PLN', 'Warsaw'),
(180, 'PM', 'Saint Pierre and Miquelon', 'EUR', 'Saint-Pierre'),
(181, 'PN', 'Pitcairn Islands', 'NZD', 'Adamstown'),
(182, 'PR', 'Puerto Rico', 'USD', 'San Juan'),
(183, 'PS', 'Palestine', 'ILS', ''),
(184, 'PT', 'Portugal', 'EUR', 'Lisbon'),
(185, 'PW', 'Palau', 'USD', 'Melekeok'),
(186, 'PY', 'Paraguay', 'PYG', 'Asunción'),
(187, 'QA', 'Qatar', 'QAR', 'Doha'),
(188, 'RE', 'Réunion', 'EUR', 'Saint-Denis'),
(189, 'RO', 'Romania', 'RON', 'Bucharest'),
(190, 'RS', 'Serbia', 'RSD', 'Belgrade'),
(191, 'RU', 'Russia', 'RUB', 'Moscow'),
(192, 'RW', 'Rwanda', 'RWF', 'Kigali'),
(193, 'SA', 'Saudi Arabia', 'SAR', 'Riyadh'),
(194, 'SB', 'Solomon Islands', 'SBD', 'Honiara'),
(195, 'SC', 'Seychelles', 'SCR', 'Victoria'),
(196, 'SD', 'Sudan', 'SDG', 'Khartoum'),
(197, 'SE', 'Sweden', 'SEK', 'Stockholm'),
(198, 'SG', 'Singapore', 'SGD', 'Singapore'),
(199, 'SH', 'Saint Helena', 'SHP', 'Jamestown'),
(200, 'SI', 'Slovenia', 'EUR', 'Ljubljana'),
(201, 'SJ', 'Svalbard and Jan Mayen', 'NOK', 'Longyearbyen'),
(202, 'SK', 'Slovakia', 'EUR', 'Bratislava'),
(203, 'SL', 'Sierra Leone', 'SLL', 'Freetown'),
(204, 'SM', 'San Marino', 'EUR', 'San Marino'),
(205, 'SN', 'Senegal', 'XOF', 'Dakar'),
(206, 'SO', 'Somalia', 'SOS', 'Mogadishu'),
(207, 'SR', 'Suriname', 'SRD', 'Paramaribo'),
(208, 'SS', 'South Sudan', 'SSP', 'Juba'),
(209, 'ST', 'São Tomé and Príncipe', 'STD', 'São Tomé'),
(210, 'SV', 'El Salvador', 'USD', 'San Salvador'),
(211, 'SX', 'Sint Maarten', 'ANG', 'Philipsburg'),
(212, 'SY', 'Syria', 'SYP', 'Damascus'),
(213, 'SZ', 'Swaziland', 'SZL', 'Mbabane'),
(214, 'TC', 'Turks and Caicos Islands', 'USD', 'Cockburn Town'),
(215, 'TD', 'Chad', 'XAF', 'N\'Djamena'),
(216, 'TF', 'French Southern Territories', 'EUR', 'Port-aux-Français'),
(217, 'TG', 'Togo', 'XOF', 'Lomé'),
(218, 'TH', 'Thailand', 'THB', 'Bangkok'),
(219, 'TJ', 'Tajikistan', 'TJS', 'Dushanbe'),
(220, 'TK', 'Tokelau', 'NZD', ''),
(221, 'TL', 'East Timor', 'USD', 'Dili'),
(222, 'TM', 'Turkmenistan', 'TMT', 'Ashgabat'),
(223, 'TN', 'Tunisia', 'TND', 'Tunis'),
(224, 'TO', 'Tonga', 'TOP', 'Nuku\'alofa'),
(225, 'TR', 'Turkey', 'TRY', 'Ankara'),
(226, 'TT', 'Trinidad and Tobago', 'TTD', 'Port of Spain'),
(227, 'TV', 'Tuvalu', 'AUD', 'Funafuti'),
(228, 'TW', 'Taiwan', 'TWD', 'Taipei'),
(229, 'TZ', 'Tanzania', 'TZS', 'Dodoma'),
(230, 'UA', 'Ukraine', 'UAH', 'Kiev'),
(231, 'UG', 'Uganda', 'UGX', 'Kampala'),
(232, 'UM', 'U.S. Minor Outlying Islands', 'USD', ''),
(233, 'US', 'United States', 'USD', 'Washington'),
(234, 'UY', 'Uruguay', 'UYU', 'Montevideo'),
(235, 'UZ', 'Uzbekistan', 'UZS', 'Tashkent'),
(236, 'VA', 'Vatican City', 'EUR', 'Vatican City'),
(237, 'VC', 'Saint Vincent and the Grenadines', 'XCD', 'Kingstown'),
(238, 'VE', 'Venezuela', 'VEF', 'Caracas'),
(239, 'VG', 'British Virgin Islands', 'USD', 'Road Town'),
(240, 'VI', 'U.S. Virgin Islands', 'USD', 'Charlotte Amalie'),
(241, 'VN', 'Vietnam', 'VND', 'Hanoi'),
(242, 'VU', 'Vanuatu', 'VUV', 'Port Vila'),
(243, 'WF', 'Wallis and Futuna', 'XPF', 'Mata-Utu'),
(244, 'WS', 'Samoa', 'WST', 'Apia'),
(245, 'XK', 'Kosovo', 'EUR', 'Pristina'),
(246, 'YE', 'Yemen', 'YER', 'Sanaa'),
(247, 'YT', 'Mayotte', 'EUR', 'Mamoudzou'),
(248, 'ZA', 'South Africa', 'ZAR', 'Pretoria'),
(249, 'ZM', 'Zambia', 'ZMW', 'Lusaka'),
(250, 'ZW', 'Zimbabwe', 'ZWL', 'Harare');

-- --------------------------------------------------------

--
-- Table structure for table `financial_year_list`
--

CREATE TABLE `financial_year_list` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `financial_year_from` date NOT NULL,
  `financial_year_end` date NOT NULL,
  `status` enum('Active','Inactive') CHARACTER SET latin1 NOT NULL DEFAULT 'Active',
  `user_id` int(11) NOT NULL,
  `sys_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gender_list`
--

CREATE TABLE `gender_list` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_number` int(1) UNSIGNED DEFAULT NULL,
  `gender` varchar(6) CHARACTER SET latin1 DEFAULT NULL,
  `status` enum('Active','Inactive') CHARACTER SET latin1 NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gender_list`
--

INSERT INTO `gender_list` (`id`, `order_number`, `gender`, `status`) VALUES
(1, 1, 'Male', 'Active'),
(2, 2, 'Female', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `menu_list`
--

CREATE TABLE `menu_list` (
  `id` int(11) NOT NULL,
  `order` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `menu_name` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `menu_link` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '#',
  `menu_icon` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `target` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `status` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `position_status` varchar(15) CHARACTER SET latin1 NOT NULL DEFAULT 'child',
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu_list`
--

INSERT INTO `menu_list` (`id`, `order`, `menu_id`, `menu_name`, `menu_link`, `menu_icon`, `target`, `status`, `position_status`, `create_at`, `update_at`) VALUES
(1, 1, NULL, 'Dashboard', 'dashboard/summary', 'fa fa-tachometer', '', 'active', 'child', '2017-07-31 12:05:45', '2018-04-10 03:02:32'),
(2, 2, NULL, 'Setup', '#', 'fa fa-wrench', '', 'active', 'parents', '2017-07-31 12:05:45', '2018-04-21 09:01:26'),
(3, 3, NULL, 'User Manage', '#', 'fa fa-users', '', 'active', 'parents', '2017-07-31 12:05:45', '2018-04-10 03:08:55'),
(19, 10, NULL, 'Accounts', '#', 'fa fa-money', '', 'active', 'parents', '2017-08-10 04:15:34', '2018-01-21 10:58:24'),
(24, 3, 19, 'Voucher', '#', '', '', 'active', 'parents', '2017-08-30 11:11:17', '2018-04-18 01:06:38'),
(27, 1, 24, 'Create Voucher', 'acc/voucherCreate', '', '', 'active', 'child', '2017-09-09 04:03:23', '2018-04-18 12:57:56'),
(29, 4, 19, 'Report', '#', '', '', 'active', 'parents', '2017-09-10 01:49:15', '2018-04-18 01:06:49'),
(30, 1, 29, 'Chart of Accounts', 'accReport/chartOfAccounts', '', '', 'active', 'child', '2017-09-10 01:51:10', NULL),
(31, 2, 29, 'General Report', '#', '', '', 'active', 'parents', '2017-09-13 12:58:37', '2018-04-22 12:31:48'),
(69, 7, 24, 'Opening', 'acc/opening', '', '', 'active', 'child', '2017-11-18 01:06:33', '2018-04-20 02:26:09'),
(70, 5, 24, 'Voucher Check', 'acc/vCheck', '', '', 'active', 'child', '2018-01-13 02:23:13', '2018-04-18 06:18:33'),
(71, 6, 24, 'Approve Voucher', 'acc/vApprove', '', '', 'active', 'child', '2018-01-13 02:23:55', '2018-04-19 01:47:27'),
(149, 1, 3, 'Add User', 'user/adduser', '', '', 'active', 'child', '2018-04-10 03:09:18', NULL),
(150, 2, 3, 'User Access', 'user/accessRule', '', '', 'active', 'child', '2018-04-10 03:12:42', NULL),
(151, 3, 3, 'Access List', 'user/accessList', '', '', 'active', 'child', '2018-04-18 10:03:23', NULL),
(154, 1, 2, 'Company Info', 'company/information', '', '', 'active', 'child', '2018-04-21 09:02:00', NULL),
(155, 5, 2, 'Chart of Accounts ', 'acc/chartCreate', '', '', 'active', 'child', '2018-04-21 09:20:04', NULL),
(156, 6, 2, 'Voucher Type', 'acc/voucherTypeManage', '', '', 'active', 'child', '2018-04-21 09:21:22', NULL),
(157, 10, 2, 'Year Closing', 'accYearClosing/yearClosing', '', '', 'active', 'child', '2018-04-21 09:22:51', NULL),
(159, 1, 31, 'Approve Voucher List', 'accReport/approveVoucherList', '', '', 'active', 'child', '2018-04-22 12:45:42', '2018-04-22 02:08:52'),
(160, 2, 31, 'Unapprove Voucher List', 'accReport/unapproveVoucherList', '', '', 'active', 'child', '2018-04-22 02:09:31', NULL),
(161, 3, 31, 'Ledger Report', 'accReport/findLedgerReport', '', '', 'active', 'child', '2018-04-23 04:53:17', '2018-04-23 04:57:21'),
(162, 3, 29, 'Finance Report', '#', '', '', 'active', 'parents', '2018-04-26 07:00:58', NULL),
(163, 1, 162, 'Income Statement', 'accReport/findIncomeStatementReport', '', '', 'active', 'child', '2018-04-26 07:01:52', '2018-06-03 11:45:02'),
(164, 2, 162, 'Owner\'s Equity', 'accReport/findOwnersEquityReport', '', '', 'active', 'child', '2018-04-26 07:02:28', '2018-05-31 06:08:13'),
(165, 3, 162, 'Trial Balance', 'accReport/findTrialBalanceReport', '', '', 'active', 'child', '2018-04-26 07:03:02', '2018-04-26 08:29:13'),
(166, 4, 162, 'Balance Sheet', 'accReport/findBalanceSheet', '', '', 'active', 'child', '2018-04-26 07:03:32', '2018-04-28 12:24:18'),
(167, 4, 31, 'Day Book', 'accReport/findDayBookReport', '', '', 'active', 'child', '2018-04-26 07:04:05', '2018-04-27 11:46:46'),
(168, 9, 2, 'Day Open/Close', 'acc/dayOpenClose/0', '', '', 'active', 'child', '2018-05-03 11:22:18', '2018-05-08 12:56:57');

-- --------------------------------------------------------

--
-- Table structure for table `temp_verify_code`
--

CREATE TABLE `temp_verify_code` (
  `id` bigint(100) UNSIGNED NOT NULL,
  `email_address` varchar(150) CHARACTER SET latin1 NOT NULL,
  `verify_code` varchar(5) CHARACTER SET latin1 DEFAULT NULL,
  `delete_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) UNSIGNED NOT NULL,
  `type_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `status` varchar(10) CHARACTER SET latin1 NOT NULL DEFAULT 'active',
  `serial` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `type_name`, `status`, `serial`) VALUES
(1, 'Superadmin', 'active', 1),
(2, 'Accountant ', 'active', 2),
(3, 'Application Admin', 'active', 3);

-- --------------------------------------------------------

--
-- Table structure for table `working_day_open_close`
--

CREATE TABLE `working_day_open_close` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `working_date` date DEFAULT NULL,
  `permanent_close_date` date DEFAULT NULL,
  `status` enum('Open','Close') CHARACTER SET latin1 NOT NULL,
  `system_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_list`
--
ALTER TABLE `access_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`,`controller_id`,`user_id`);

--
-- Indexes for table `acc_chart_of_accounts`
--
ALTER TABLE `acc_chart_of_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_id` (`account_id`,`company_id`);

--
-- Indexes for table `acc_finance_table`
--
ALTER TABLE `acc_finance_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_acc_finance_table_company_id` (`company_id`),
  ADD KEY `fk_acc_finance_table_financial_year_auto_id` (`financial_year_auto_id`);

--
-- Indexes for table `acc_ledger_data`
--
ALTER TABLE `acc_ledger_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_acc_ledger_data_company_id` (`company_id`),
  ADD KEY `fk_acc_ledger_data_financial_year_auto_id` (`financial_year_auto_id`),
  ADD KEY `fk_acc_ledger_data_voucher_info_auto_id` (`voucher_info_auto_id`);

--
-- Indexes for table `acc_voucher_details`
--
ALTER TABLE `acc_voucher_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_acc_voucher_details_voucher_info_auto_id` (`voucher_info_auto_id`);

--
-- Indexes for table `acc_voucher_info`
--
ALTER TABLE `acc_voucher_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_acc_voucher_info_company_id` (`company_id`),
  ADD KEY `fk_acc_voucher_info_financial_year_auto_id` (`financial_year_auto_id`),
  ADD KEY `fk_acc_voucher_info_voucher_type_auto_id` (`voucher_type_auto_id`);

--
-- Indexes for table `acc_voucher_type_list`
--
ALTER TABLE `acc_voucher_type_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_year_closing_check`
--
ALTER TABLE `acc_year_closing_check`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_user`
--
ALTER TABLE `app_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login_name` (`login_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_register_table`
--
ALTER TABLE `company_register_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `controller_list`
--
ALTER TABLE `controller_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country_list`
--
ALTER TABLE `country_list`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `financial_year_list`
--
ALTER TABLE `financial_year_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gender_list`
--
ALTER TABLE `gender_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_list`
--
ALTER TABLE `menu_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_verify_code`
--
ALTER TABLE `temp_verify_code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `verify_code` (`verify_code`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial` (`serial`);

--
-- Indexes for table `working_day_open_close`
--
ALTER TABLE `working_day_open_close`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_list`
--
ALTER TABLE `access_list`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `acc_chart_of_accounts`
--
ALTER TABLE `acc_chart_of_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `acc_finance_table`
--
ALTER TABLE `acc_finance_table`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acc_ledger_data`
--
ALTER TABLE `acc_ledger_data`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acc_voucher_details`
--
ALTER TABLE `acc_voucher_details`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acc_voucher_info`
--
ALTER TABLE `acc_voucher_info`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acc_voucher_type_list`
--
ALTER TABLE `acc_voucher_type_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acc_year_closing_check`
--
ALTER TABLE `acc_year_closing_check`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_user`
--
ALTER TABLE `app_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_register_table`
--
ALTER TABLE `company_register_table`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `controller_list`
--
ALTER TABLE `controller_list`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `country_list`
--
ALTER TABLE `country_list`
  MODIFY `country_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `financial_year_list`
--
ALTER TABLE `financial_year_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gender_list`
--
ALTER TABLE `gender_list`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu_list`
--
ALTER TABLE `menu_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `temp_verify_code`
--
ALTER TABLE `temp_verify_code`
  MODIFY `id` bigint(100) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `working_day_open_close`
--
ALTER TABLE `working_day_open_close`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acc_finance_table`
--
ALTER TABLE `acc_finance_table`
  ADD CONSTRAINT `fk_acc_finance_table_company_id` FOREIGN KEY (`company_id`) REFERENCES `company_register_table` (`id`),
  ADD CONSTRAINT `fk_acc_finance_table_financial_year_auto_id` FOREIGN KEY (`financial_year_auto_id`) REFERENCES `financial_year_list` (`id`);

--
-- Constraints for table `acc_ledger_data`
--
ALTER TABLE `acc_ledger_data`
  ADD CONSTRAINT `fk_acc_ledger_data_company_id` FOREIGN KEY (`company_id`) REFERENCES `company_register_table` (`id`),
  ADD CONSTRAINT `fk_acc_ledger_data_financial_year_auto_id` FOREIGN KEY (`financial_year_auto_id`) REFERENCES `financial_year_list` (`id`),
  ADD CONSTRAINT `fk_acc_ledger_data_voucher_info_auto_id` FOREIGN KEY (`voucher_info_auto_id`) REFERENCES `acc_voucher_info` (`id`);

--
-- Constraints for table `acc_voucher_details`
--
ALTER TABLE `acc_voucher_details`
  ADD CONSTRAINT `fk_acc_voucher_details_voucher_info_auto_id` FOREIGN KEY (`voucher_info_auto_id`) REFERENCES `acc_voucher_info` (`id`);

--
-- Constraints for table `acc_voucher_info`
--
ALTER TABLE `acc_voucher_info`
  ADD CONSTRAINT `fk_acc_voucher_info_company_id` FOREIGN KEY (`company_id`) REFERENCES `company_register_table` (`id`),
  ADD CONSTRAINT `fk_acc_voucher_info_financial_year_auto_id` FOREIGN KEY (`financial_year_auto_id`) REFERENCES `financial_year_list` (`id`),
  ADD CONSTRAINT `fk_acc_voucher_info_voucher_type_auto_id` FOREIGN KEY (`voucher_type_auto_id`) REFERENCES `acc_voucher_type_list` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
