-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2020 at 07:43 AM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surf_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `beach_breaks`
--

CREATE TABLE `beach_breaks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `beach_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `break_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_region` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` smallint(6) NOT NULL DEFAULT '1' COMMENT '1=>active,0=>deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beach_breaks`
--

INSERT INTO `beach_breaks` (`id`, `beach_name`, `break_name`, `city_region`, `state`, `country`, `country_code`, `flag`, `created_at`, `updated_at`) VALUES
(1, 'Avalon Beach', 'North Avalon', 'Sydney', 'NSW', 'Australia', NULL, 1, '2020-11-02 13:00:00', '2020-11-02 13:00:00'),
(2, 'Avalon Beach', 'South Avalon', 'Sydney', 'NSW', 'Australia', NULL, 1, '2020-11-02 13:00:00', '2020-11-02 13:00:00'),
(3, 'Avalon Beach', 'Little Av', 'Sydney', 'NSW', 'Australia', NULL, 1, '2020-11-02 13:00:00', '2020-11-02 13:00:00'),
(4, NULL, 'La Isla', 'Arica', 'Norte Grande', 'Chile', NULL, 1, '2020-11-02 13:00:00', '2020-11-02 13:00:00'),
(5, 'Playa Chinchorro', 'Las Machas', 'Arica', 'Norte Grande', 'Chile', NULL, 1, '2020-11-02 13:00:00', '2020-11-02 13:00:00'),
(6, 'Bilgola Beach', NULL, 'Sydney', 'NSW', 'Australia', NULL, 1, '2020-11-02 13:00:00', '2020-11-02 13:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beach_breaks`
--
ALTER TABLE `beach_breaks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beach_breaks_beach_name_break_name_index` (`beach_name`,`break_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beach_breaks`
--
ALTER TABLE `beach_breaks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
