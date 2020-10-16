-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: sql7.jnb1.host-h.net
-- Generation Time: Oct 11, 2020 at 11:00 AM
-- Server version: 10.1.46-MariaDB-1~stretch
-- PHP Version: 7.3.19-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greenbluegpyuty_db5`
--

-- --------------------------------------------------------

--
-- Table structure for table `bedding_resources`
--

CREATE TABLE `bedding_resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_bedding_resources_link_children` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bedding_resources`
--

INSERT INTO `bedding_resources` (`id`, `event_bedding_resources_link_children`, `name`) VALUES
(1, NULL, 'Dovet/sleeping bags'),
(2, NULL, 'Matresses'),
(3, NULL, 'Camping chairs'),
(4, NULL, 'Pillows');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_bedding_resources_link_children` bigint(20) UNSIGNED DEFAULT NULL,
  `event_personal_resources_link_children` bigint(20) UNSIGNED DEFAULT NULL,
  `event_food_resources_link_children` bigint(20) UNSIGNED DEFAULT NULL,
  `event_transport_resources_link_children` bigint(20) UNSIGNED DEFAULT NULL,
  `event_place_link_children` bigint(20) UNSIGNED DEFAULT NULL,
  `event_person_link_children` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `dates` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_bedding_resources_link_children`, `event_personal_resources_link_children`, `event_food_resources_link_children`, `event_transport_resources_link_children`, `event_place_link_children`, `event_person_link_children`, `name`, `dates`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, 'Nuts and bolts rally', '2020/10/07 - 2020/10/10');

-- --------------------------------------------------------

--
-- Table structure for table `event_bedding_resources_links`
--

CREATE TABLE `event_bedding_resources_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bedding_resource_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_bedding_resources_links`
--

INSERT INTO `event_bedding_resources_links` (`id`, `event_id`, `bedding_resource_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `event_food_resources_links`
--

CREATE TABLE `event_food_resources_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `food_resource_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_food_resources_links`
--

INSERT INTO `event_food_resources_links` (`id`, `event_id`, `food_resource_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(18, 1, 16);

-- --------------------------------------------------------

--
-- Table structure for table `event_personal_resources_links`
--

CREATE TABLE `event_personal_resources_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `personal_resource_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_personal_resources_links`
--

INSERT INTO `event_personal_resources_links` (`id`, `event_id`, `personal_resource_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `event_person_links`
--

CREATE TABLE `event_person_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `person_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_person_links`
--

INSERT INTO `event_person_links` (`id`, `event_id`, `person_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `event_place_links`
--

CREATE TABLE `event_place_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `place_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_place_links`
--

INSERT INTO `event_place_links` (`id`, `event_id`, `place_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_transport_resources_links`
--

CREATE TABLE `event_transport_resources_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transport_resource_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_transport_resources_links`
--

INSERT INTO `event_transport_resources_links` (`id`, `event_id`, `transport_resource_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `food_resources`
--

CREATE TABLE `food_resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_food_resources_link_children` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_resources`
--

INSERT INTO `food_resources` (`id`, `event_food_resources_link_children`, `name`) VALUES
(1, NULL, 'Meat'),
(2, NULL, 'Rice'),
(3, NULL, 'Boose'),
(4, NULL, 'Jaffel maker'),
(5, NULL, 'Rocket stove'),
(6, NULL, 'Pot'),
(7, NULL, 'Cooler bag'),
(8, NULL, 'Water'),
(9, NULL, 'Nuts'),
(10, NULL, 'Muesli'),
(11, NULL, 'Bread'),
(12, 0, 'Tea'),
(13, NULL, 'Milk'),
(14, NULL, 'Peanut butter'),
(15, NULL, 'Juice'),
(16, NULL, 'Crockery');

-- --------------------------------------------------------

--
-- Table structure for table `personal_resources`
--

CREATE TABLE `personal_resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_personal_resources_link_children` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personal_resources`
--

INSERT INTO `personal_resources` (`id`, `event_personal_resources_link_children`, `name`) VALUES
(1, NULL, 'Clothes'),
(2, NULL, 'Sleeping pills'),
(3, NULL, 'Power bank'),
(4, NULL, 'Car battery adaptor'),
(5, NULL, 'Cigarete to USB adaptor'),
(6, NULL, 'Sunblock'),
(7, NULL, 'Towel'),
(8, NULL, 'Tripod'),
(9, NULL, 'Rain coat');

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_person_link_children` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`id`, `event_person_link_children`, `name`) VALUES
(1, NULL, 'Mike'),
(2, NULL, 'Ivan'),
(3, NULL, 'Greg');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_place_link_children` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `event_place_link_children`, `name`) VALUES
(1, NULL, 'Cederberg');

-- --------------------------------------------------------

--
-- Table structure for table `transport_resources`
--

CREATE TABLE `transport_resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_transport_resources_link_children` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transport_resources`
--

INSERT INTO `transport_resources` (`id`, `event_transport_resources_link_children`, `name`) VALUES
(1, NULL, 'Mike\'s car');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bedding_resources`
--
ALTER TABLE `bedding_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_bedding_resources_links`
--
ALTER TABLE `event_bedding_resources_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_food_resources_links`
--
ALTER TABLE `event_food_resources_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_personal_resources_links`
--
ALTER TABLE `event_personal_resources_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_person_links`
--
ALTER TABLE `event_person_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_place_links`
--
ALTER TABLE `event_place_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_transport_resources_links`
--
ALTER TABLE `event_transport_resources_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_resources`
--
ALTER TABLE `food_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_resources`
--
ALTER TABLE `personal_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_resources`
--
ALTER TABLE `transport_resources`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bedding_resources`
--
ALTER TABLE `bedding_resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_bedding_resources_links`
--
ALTER TABLE `event_bedding_resources_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event_food_resources_links`
--
ALTER TABLE `event_food_resources_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `event_personal_resources_links`
--
ALTER TABLE `event_personal_resources_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `event_person_links`
--
ALTER TABLE `event_person_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event_place_links`
--
ALTER TABLE `event_place_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_transport_resources_links`
--
ALTER TABLE `event_transport_resources_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `food_resources`
--
ALTER TABLE `food_resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_resources`
--
ALTER TABLE `personal_resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transport_resources`
--
ALTER TABLE `transport_resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
