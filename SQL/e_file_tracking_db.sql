-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2023 at 03:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_file_tracking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(10) NOT NULL,
  `file_no` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `sender` varchar(100) NOT NULL,
  `letter_no` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `department` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `letter_date` date NOT NULL,
  `time_limit` int(10) DEFAULT NULL,
  `subject` varchar(200) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `creator_id` int(11) NOT NULL,
  `status` int(1) DEFAULT 0,
  `closed_by` int(10) DEFAULT NULL,
  `closing_remark` varchar(500) DEFAULT NULL,
  `file_type` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `file_loc` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `file_no`, `sender`, `letter_no`, `department`, `letter_date`, `time_limit`, `subject`, `description`, `creator_id`, `status`, `closed_by`, `closing_remark`, `file_type`, `file_loc`) VALUES
(1, '1', 'Intern1', '1', 'IT', '2023-08-07', 0, 'Test', 'Just for testing purpose', 40, 1, 22, 'Ok!', 'test_file', '1688827223.pdf'),
(2, '2', 'Intern1', '2', 'IT', '2023-08-07', 0, 'Test', 'Just for testing purpose 2', 40, 1, 22, 'Good Job!', 'test_file', '1688827659.pdf'),
(3, '3', 'Team_Lead1', '3', 'IT', '2023-10-07', 0, 'Test', 'Project-1', 22, 1, 40, 'Ok Sir\r\n', 'test_file', '1688972866.pdf'),
(5, '754878', 'Tech_Lead_1', '5', 'IT', '2023-05-07', 0, 'Project Submission', 'Project Submission', 20, 1, 13, 'Sure!', 'Project-1', '1688976069.pdf'),
(6, '74578', 'Intern1', '8', 'IT', '2023-05-18', 0, 'Test', 'Testing Purpose', 40, 1, 22, 'Testing Success!!!\r\n', 'test_file', '1688984418.pdf'),
(7, '8', 'Team_Lead1', '8', 'IT', '2023-10-07', 0, 'Test', 'Test with Notesheet', 22, 1, 40, 'Ok, Seen!', 'test_file', '1689000439.pdf'),
(8, '784578', 'Intern1', '10', 'IT', '2023-12-07', 0, 'Test', 'Checking Purpose', 40, 0, NULL, NULL, 'test_file', '1689315512.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `notesheet`
--

CREATE TABLE `notesheet` (
  `id` int(10) NOT NULL,
  `number` varchar(50) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `remark` varchar(200) NOT NULL,
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `ns_loc` varchar(100) DEFAULT NULL,
  `file_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notesheet`
--

INSERT INTO `notesheet` (`id`, `number`, `subject`, `remark`, `created_by`, `date_created`, `ns_loc`, `file_id`) VALUES
(3, '523', 'Test', 'Notesheet1', 22, '2023-07-10 14:41:42', '1689000103.pdf', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notesheet_transactions`
--

CREATE TABLE `notesheet_transactions` (
  `id` int(11) NOT NULL,
  `notesheet_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `dispatch_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `forward_status` int(1) NOT NULL DEFAULT 0,
  `status` int(1) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notesheet_transactions`
--

INSERT INTO `notesheet_transactions` (`id`, `notesheet_id`, `sender_id`, `receiver_id`, `dispatch_time`, `forward_status`, `status`, `remark`) VALUES
(3, 3, 22, 40, '2023-07-10 14:45:05', 0, 1, 'Notesheet1');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `dispatch_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `forward_status` int(1) NOT NULL DEFAULT 0,
  `status` int(1) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `type`, `file_id`, `sender_id`, `receiver_id`, `dispatch_time`, `forward_status`, `status`, `remark`) VALUES
(8, 'Action', 1, 40, 22, '2023-07-08 14:40:22', 1, 1, 'Test'),
(9, 'Action', 2, 40, 22, '2023-07-08 14:47:39', 1, 1, 'Test2'),
(10, 'Information', 1, 22, 20, '2023-07-09 07:51:31', 1, 1, 'Please Check this'),
(11, 'Information', 2, 22, 40, '2023-07-09 07:52:32', 1, 1, 'Need for clarification on this'),
(12, 'Action', 2, 40, 22, '2023-07-09 08:04:02', 1, 1, 'Clarification done!'),
(13, 'Information', 2, 22, 20, '2023-07-09 08:05:12', 1, 1, 'Sir, Please Check This File after clarification'),
(14, 'Information', 2, 20, 13, '2023-07-09 08:06:11', 1, 1, 'Sir, is this okay?'),
(15, 'Action', 2, 13, 20, '2023-07-09 08:07:10', 1, 1, 'Yes it is fine close it'),
(16, 'Information', 2, 20, 22, '2023-07-09 08:07:58', 2, 1, 'Close it'),
(17, 'Action', 3, 22, 40, '2023-07-10 06:42:44', 2, 1, 'Solve this immediately'),
(18, 'Action', 3, 22, 40, '2023-07-10 07:07:45', 1, 1, 'Complete this immediately!'),
(19, 'Action', 4, 22, 40, '2023-07-10 07:10:03', 0, 0, 'Do it before 10/08/2023'),
(20, 'Information', 3, 40, 22, '2023-07-10 07:28:09', 1, 1, 'Ok Sir , I will send you the file tommorrow'),
(21, 'Information', 3, 22, 20, '2023-07-10 07:34:27', 1, 1, 'Sir, he will submit it tommorrow'),
(22, 'Information', 3, 20, 22, '2023-07-10 07:36:00', 2, 1, 'Ok, close it'),
(23, 'Action', 5, 20, 13, '2023-07-10 08:01:09', 1, 1, 'Project Completed'),
(24, 'Information', 5, 13, 20, '2023-07-10 08:02:01', 1, 1, 'Good Work!'),
(25, 'Action', 5, 20, 13, '2023-07-10 08:03:33', 2, 1, 'Thank you sir, please close this file'),
(26, 'Action', 6, 40, 22, '2023-07-10 10:20:17', 2, 1, 'Testing123'),
(27, 'Action', 7, 22, 40, '2023-07-10 14:47:19', 2, 1, 'Just for Notesheet + File Testing'),
(28, 'Action', 8, 40, 22, '2023-07-14 06:18:32', 0, 0, 'Draft check');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(40) NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `supervisor` varchar(50) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `privilege` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `email`, `mobile`, `password`, `supervisor`, `role`, `privilege`, `status`) VALUES
(1, 'Administrator', 'admin@devit.com', 7487964789, 'admin', NULL, 'Administrator', 1, 0),
(2, 'Chairman', 'chairman@devit.com', 9856789478, 'chairman123', NULL, 'Chairman', 0, 1),
(3, 'CEO', 'ceo@devit.com', 8745678213, 'ceo123', '2', 'CEO', 0, 1),
(4, 'GM', 'gm@devit.com', 9851246785, 'gm123', '3', 'General Manager', 0, 1),
(12, 'HR Manager', 'hrmanager@devit.com', 6354127856, 'hrmanager123', '4', 'HR Manager', 0, 1),
(13, 'IT Admin', 'itadmin@devit.com', 7423516812, 'itadmin123', '4', 'IT Admin', 0, 1),
(14, 'Accounting Manager', 'accountingmanager@devit.com', 7581246987, 'accountingmanager123', '4', 'Accounting Manager', 0, 1),
(15, 'Marketing Manager', 'marketingmanager@devit.com', 9521467853, 'marketingmanager123', '4', 'Marketing Manager', 0, 1),
(16, 'Financial Manager', 'financialmanager@devit.com', 6252134578, 'financialmanager123', '4', 'Financial Manager', 0, 1),
(17, 'Operation Manager', 'operationmanager@devit.com', 9632145789, 'operationmanager123', '4', 'Operation Manager', 0, 1),
(18, 'HR_User1', 'hr_user1@devit.com', 6845214537, '123', '12', 'HR Employee', 0, 1),
(19, 'HR_User2', 'hr_user2@devit.com', 7423589614, '123', '12', 'HR Employee', 0, 1),
(20, 'Tech_Lead_1', 'techlead1@devit.com', 9513478567, '123', '13', 'Tech Lead', 0, 1),
(21, 'Tech_Lead_2', 'techlead2@devit.com', 7956123578, '123', '13', 'Tech Lead', 0, 1),
(22, 'Team_Lead1', 'teamlead1@devit.com', 7892341765, '123', '20', 'Team Lead', 0, 1),
(24, 'Team_Lead2', 'teamlead2@devit.com', 7591423578, '123', '20', 'Team Lead', 0, 1),
(25, 'Team_Lead3', 'teamlead3@devit.com', 6352417845, '123', '21', 'Team Lead', 0, 1),
(26, 'Team_Lead4', 'teamlead4@devit.com', 7546789452, '123', '21', 'Team Lead', 0, 1),
(27, 'Tech_Employee1', 'tech_employee1@devit.com', 9562345718, '123', '22', 'Tech_Employee', 0, 1),
(28, 'Tech_Employee2', 'tech_employee2@devit.com', 9321569853, '123', '22', 'Tech_Employee', 0, 1),
(29, 'Tech_Employee3', 'tech_employee3@devit.com', 6354124578, '123', '24', 'Tech_Employee', 0, 1),
(30, 'Tech_Employee4', 'tech_employee4@devit.com', 7856413498, '123', '24', 'Tech_Employee', 0, 1),
(31, 'Tech_Employee5', 'tech_employee5@devit.com', 9452371645, '123', '25', 'Tech_Employee', 0, 1),
(32, 'Tech_Employee6', 'tech_employee6@devit.com', 6341895271, '123', '25', 'Tech_Employee', 0, 1),
(33, 'Tech_Employee7', 'tech_employee7@devit.com', 7895213465, '123', '26', 'Tech_Employee', 0, 1),
(35, 'Tech_Employee8', 'tech_employee8@devit.com', 7312456987, '123', '26', 'Tech_Employee', 0, 1),
(36, 'Acc_Team_User1', 'acc.team_user1@devit.com', 7845123659, '123', '14', 'Acc_Team_Employee', 0, 1),
(37, 'Acc_Team_User2', 'acc.team_user2@devit.com', 6354197358, '123', '14', 'Acc_Team_Employee', 0, 1),
(38, 'Sales_Team_User', 'salesteam@devit.com', 7548685972, '123', '15', 'Sales_Team', 0, 1),
(39, 'Financial_Team_User', 'financialteam@devit.com', 9856197385, '123', '16', 'Financial_Team', 0, 1),
(40, 'Intern1', 'intern1@gmail.com', 6371349624, '123', '22', 'Tech Intern', 0, 1),
(41, 'Intern2', 'intern2@gmail.com', 9856271957, '123', '26', 'Tech Intern', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notesheet`
--
ALTER TABLE `notesheet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notesheet_transactions`
--
ALTER TABLE `notesheet_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notesheet`
--
ALTER TABLE `notesheet`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notesheet_transactions`
--
ALTER TABLE `notesheet_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
