-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2022 at 10:08 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tanzania`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` text NOT NULL,
  `parent_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `parent_id`, `status`) VALUES
(1, 'Buy', 0, 'Y'),
(2, 'Sell', 0, 'Y'),
(3, 'Rent', 0, 'Y'),
(4, 'Job', 0, 'Y'),
(5, 'Service', 0, 'Y'),
(6, 'Event', 0, 'Y'),
(7, 'Appliance ', 1, 'Y'),
(8, 'Beauty', 1, 'Y'),
(12, 'Books', 1, 'Y'),
(13, 'service', 3, 'Y'),
(14, 'Welcome', 3, 'Y'),
(15, 'Car Prts', 2, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `loc_id` int(11) NOT NULL,
  `city_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`city_id`, `loc_id`, `city_name`) VALUES
(1, 0, 'Pune'),
(2, 0, 'Kolkata'),
(4, 0, 'Howrah'),
(5, 0, 'Mumbai'),
(6, 0, 'Delhi'),
(7, 0, 'Bangalore'),
(8, 0, 'AHMEDABAD'),
(9, 0, 'AGRA'),
(10, 0, 'AGARTALA'),
(11, 0, 'Uluberia');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `loc_id` int(11) NOT NULL,
  `loc_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(50) NOT NULL,
  `discription` text NOT NULL,
  `prize` varchar(50) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `specification` varchar(50) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `post_date` date NOT NULL,
  `loc_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `photo_url` varchar(50) NOT NULL,
  `status` text NOT NULL DEFAULT 'Y',
  `createddate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_title`, `discription`, `prize`, `tag`, `specification`, `cat_id`, `post_date`, `loc_id`, `user_id`, `city_id`, `photo_url`, `status`, `createddate`) VALUES
(1, 'BMW G310 RR', ' BMW G310 RR is a sports bike available at a starting price of Rs. 2,85,000 in India. It is available in 2 variants and 2 colours with top ...\r\nKerb Weight: 174 kg\r\nSeat Height: 811 mm\r\nMax Power: 33.5 bhp\r\nFuel Tank Capacity: 11 litres', '29,845', 'null', '', 1, '2022-10-18', 0, 1, 2, 'testdemo.jpg', 'Y', '2022-10-18 04:54:28'),
(2, 'Ferari', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before final copy is available.', '2,0000', 'null', 'car', 1, '2022-10-18', 0, 1, 2, 'cartest.jpg', 'Y', '2022-10-18 05:30:02'),
(3, 'Marcecdece', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before final copy is available.', '29845', 'null', 'car', 1, '2022-10-18', 0, 3, 1, 'cartest.jpg', 'Y', '2022-10-18 06:20:24'),
(4, 'Jaguar 100', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before final copy is available.', '29845', 'null', 'car', 1, '2022-10-18', 0, 3, 1, 'cartest.jpg', 'Y', '2022-10-18 06:24:55'),
(5, 'My beauty', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before final copy is available.', '29845', 'null', 'car', 1, '2022-10-18', 0, 3, 2, 'demoupload.jpg', 'Y', '2022-10-18 07:22:12'),
(6, 'BMW BIKE', 'Using color to add meaning only provides a visual indication, which will not be conveyed to users of assistive technologies – such as screen readers. Ensure that information denoted by the color is either obvious from the content itself (e.g. the visible text), or is included through alternative means, such as additional text hidden with the .sr-only class.', '2,0000', 'null', 'car', 3, '2022-10-18', 0, 3, 4, 'cardemo.jpg', 'Y', '2022-10-18 07:48:26'),
(7, 'AUDI XXLs', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before final copy is available.', '29845', 'null', 'car', 1, '2022-10-18', 0, 2, 10, 'massivecar.jpg', 'Y', '2022-10-18 08:03:39'),
(8, 'Mahindra Thar', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before final copy is available.', '29845', 'null', 'car', 7, '2022-10-18', 0, 2, 9, '', 'Y', '2022-10-18 08:46:20'),
(9, 'Avenzer', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before final copy is available.', '29845', 'null', 'car', 8, '2022-10-18', 0, 2, 8, 'testdemo.jpg', 'Y', '2022-10-18 08:47:57'),
(10, 'Three Idots', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before final copy is available.', '26000', 'null', 'car', 12, '2022-10-18', 0, 3, 7, 'demopic.jpg', 'Y', '2022-10-18 15:45:46');

-- --------------------------------------------------------

--
-- Table structure for table `post_multi_image`
--

CREATE TABLE `post_multi_image` (
  `multi_img__id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `img_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `specification`
--

CREATE TABLE `specification` (
  `spec_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `spec_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `specification`
--

INSERT INTO `specification` (`spec_id`, `subcat_id`, `spec_name`, `status`) VALUES
(2, 14, 'demo', 0),
(3, 14, 'Repair', 0),
(5, 8, 'car', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `fullname` text NOT NULL,
  `password` varchar(50) NOT NULL,
  `is_admin` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `phone_number`, `fullname`, `password`, `is_admin`) VALUES
(1, 'gauravpatil@gmail.com', '8967124365', 'Gaurav Patil', 'fy8JWcrv', 'N'),
(2, 'admin@admin.com', '', 'Admin', '12345', 'Y'),
(3, 'sghorai.in@gmail.com', '9091377992', 'Shovan Ghorai', '123456', 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`loc_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `post_multi_image`
--
ALTER TABLE `post_multi_image`
  ADD PRIMARY KEY (`multi_img__id`);

--
-- Indexes for table `specification`
--
ALTER TABLE `specification`
  ADD PRIMARY KEY (`spec_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `loc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post_multi_image`
--
ALTER TABLE `post_multi_image`
  MODIFY `multi_img__id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specification`
--
ALTER TABLE `specification`
  MODIFY `spec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
