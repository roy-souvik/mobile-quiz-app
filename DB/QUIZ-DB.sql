-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2017 at 01:27 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `QUIZ-DB`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question`
--

CREATE TABLE `tbl_question` (
  `qus_id` int(11) NOT NULL,
  `qus_category` int(11) NOT NULL,
  `qus_qustion` varchar(255) NOT NULL,
  `qus_option_1` varchar(255) NOT NULL,
  `qus_option_2` varchar(255) NOT NULL,
  `qus_option_3` varchar(255) NOT NULL,
  `qus_option_4` varchar(255) NOT NULL,
  `qus_right_ans` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_question`
--

INSERT INTO `tbl_question` (`qus_id`, `qus_category`, `qus_qustion`, `qus_option_1`, `qus_option_2`, `qus_option_3`, `qus_option_4`, `qus_right_ans`) VALUES
(1, 1, 'The state which has the largest number of sugar mills in India is', 'Bihar', 'Haryana', 'Punjab', 'Uttar Pradesh', 'Uttar Pradesh'),
(2, 1, 'First University in India was founded at ', 'Bombay', 'Chennai', 'Calcutta', 'Delhi', 'Calcutta'),
(3, 2, 'Tajmahal is on the banks of', 'Ganges', 'Jamuna', 'Tapti', 'Cauvery', 'Jamuna'),
(4, 1, 'The currency notes are printed in', 'New Delhi', 'Nasik', 'Nagpur', 'Bombay', 'Nasik'),
(5, 2, 'Which is the Land of the Rising Sun?', 'Japan', 'Australia', 'China', 'Taiwan', 'Japan'),
(6, 1, 'Kalahari Desert is in', 'India', 'Chile', 'South Africa', 'Saudi Arabia', 'South Africa'),
(7, 1, 'Which crop is sown on the largest area in India?', 'Rice', 'Wheat', 'Sugarcane', 'Maize', 'Rice');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_social_no` varchar(255) NOT NULL,
  `user_phone_no` varchar(255) NOT NULL,
  `user_paypal` varchar(255) NOT NULL,
  `user_bank` varchar(255) NOT NULL,
  `user_bank_ac` varchar(255) NOT NULL,
  `user_bank_ifsc` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_point` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `user_email`, `user_social_no`, `user_phone_no`, `user_paypal`, `user_bank`, `user_bank_ac`, `user_bank_ifsc`, `user_image`, `user_point`) VALUES
(14, 'testUser-1', 'testUser-1@gmail.com', 'ABCD123', '1234567890', '1234567890', 'SBI', 'SBI1387630924', 'SB12345I', '1846963378.png', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_question`
--
ALTER TABLE `tbl_question`
  ADD PRIMARY KEY (`qus_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_question`
--
ALTER TABLE `tbl_question`
  MODIFY `qus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
