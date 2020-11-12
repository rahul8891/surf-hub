-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2020 at 12:11 PM
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
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code2` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capital` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` smallint(6) NOT NULL DEFAULT '1' COMMENT '1=>active,0=>deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `country_code`, `country_code2`, `phone_code`, `capital`, `currency`, `flag`, `created_at`, `updated_at`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', '+93', 'Kabul', 'AFN', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(2, 'Aland Islands', 'AX', 'ALA', '+358-18', 'Mariehamn', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(3, 'Albania', 'AL', 'ALB', '+355', 'Tirana', 'ALL', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(4, 'Algeria', 'DZ', 'DZA', '+213', 'Algiers', 'DZD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(5, 'American Samoa', 'AS', 'ASM', '+1-684', 'Pago Pago', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(6, 'Andorra', 'AD', 'AND', '+376', 'Andorra la Vella', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(7, 'Angola', 'AO', 'AGO', '+244', 'Luanda', 'AOA', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(8, 'Anguilla', 'AI', 'AIA', '+1-264', 'The Valley', 'XCD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(9, 'Antarctica', 'AQ', 'ATA', '+672', '', '', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(10, 'Antigua And Barbuda', 'AG', 'ATG', '+1-268', 'St. John\'s', 'XCD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(11, 'Argentina', 'AR', 'ARG', '+54', 'Buenos Aires', 'ARS', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(12, 'Armenia', 'AM', 'ARM', '+374', 'Yerevan', 'AMD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(13, 'Aruba', 'AW', 'ABW', '+297', 'Oranjestad', 'AWG', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(14, 'Australia', 'AU', 'AUS', '+61', 'Canberra', 'AUD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(15, 'Austria', 'AT', 'AUT', '+43', 'Vienna', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(16, 'Azerbaijan', 'AZ', 'AZE', '+994', 'Baku', 'AZN', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(17, 'Bahamas The', 'BS', 'BHS', '+1-242', 'Nassau', 'BSD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(18, 'Bahrain', 'BH', 'BHR', '+973', 'Manama', 'BHD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(19, 'Bangladesh', 'BD', 'BGD', '+880', 'Dhaka', 'BDT', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(20, 'Barbados', 'BB', 'BRB', '+1-246', 'Bridgetown', 'BBD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(21, 'Belarus', 'BY', 'BLR', '+375', 'Minsk', 'BYN', 1, '2018-07-20 09:11:03', '2020-08-15 05:58:19'),
(22, 'Belgium', 'BE', 'BEL', '+32', 'Brussels', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(23, 'Belize', 'BZ', 'BLZ', '+501', 'Belmopan', 'BZD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(24, 'Benin', 'BJ', 'BEN', '+229', 'Porto-Novo', 'XOF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(25, 'Bermuda', 'BM', 'BMU', '+1-441', 'Hamilton', 'BMD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(26, 'Bhutan', 'BT', 'BTN', '+975', 'Thimphu', 'BTN', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(27, 'Bolivia', 'BO', 'BOL', '+591', 'Sucre', 'BOB', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(28, 'Bosnia and Herzegovina', 'BA', 'BIH', '+387', 'Sarajevo', 'BAM', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(29, 'Botswana', 'BW', 'BWA', '+267', 'Gaborone', 'BWP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(30, 'Bouvet Island', 'BV', 'BVT', '+55', '', 'NOK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(31, 'Brazil', 'BR', 'BRA', '+55', 'Brasilia', 'BRL', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(32, 'British Indian Ocean Territory', 'IO', 'IOT', '+246', 'Diego Garcia', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(33, 'Brunei', 'BN', 'BRN', '+673', 'Bandar Seri Begawan', 'BND', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(34, 'Bulgaria', 'BG', 'BGR', '+359', 'Sofia', 'BGN', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(35, 'Burkina Faso', 'BF', 'BFA', '+226', 'Ouagadougou', 'XOF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(36, 'Burundi', 'BI', 'BDI', '+257', 'Bujumbura', 'BIF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(37, 'Cambodia', 'KH', 'KHM', '+855', 'Phnom Penh', 'KHR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(38, 'Cameroon', 'CM', 'CMR', '+237', 'Yaounde', 'XAF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(39, 'Canada', 'CA', 'CAN', '+1', 'Ottawa', 'CAD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(40, 'Cape Verde', 'CV', 'CPV', '+238', 'Praia', 'CVE', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(41, 'Cayman Islands', 'KY', 'CYM', '+1-345', 'George Town', 'KYD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(42, 'Central African Republic', 'CF', 'CAF', '+236', 'Bangui', 'XAF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(43, 'Chad', 'TD', 'TCD', '+235', 'N\'Djamena', 'XAF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(44, 'Chile', 'CL', 'CHL', '+56', 'Santiago', 'CLP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(45, 'China', 'CN', 'CHN', '+86', 'Beijing', 'CNY', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(46, 'Christmas Island', 'CX', 'CXR', '+61', 'Flying Fish Cove', 'AUD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(47, 'Cocos (Keeling) Islands', 'CC', 'CCK', '+61', 'West Island', 'AUD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(48, 'Colombia', 'CO', 'COL', '+57', 'Bogota', 'COP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(49, 'Comoros', 'KM', 'COM', '+269', 'Moroni', 'KMF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(50, 'Congo', 'CG', 'COG', '+242', 'Brazzaville', 'XAF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(51, 'Congo The Democratic Republic Of The', 'CD', 'COD', '+243', 'Kinshasa', 'CDF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(52, 'Cook Islands', 'CK', 'COK', '+682', 'Avarua', 'NZD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(53, 'Costa Rica', 'CR', 'CRI', '+506', 'San Jose', 'CRC', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(54, 'Cote D\'Ivoire (Ivory Coast)', 'CI', 'CIV', '+225', 'Yamoussoukro', 'XOF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(55, 'Croatia (Hrvatska)', 'HR', 'HRV', '+385', 'Zagreb', 'HRK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(56, 'Cuba', 'CU', 'CUB', '+53', 'Havana', 'CUP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(57, 'Cyprus', 'CY', 'CYP', '+357', 'Nicosia', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(58, 'Czech Republic', 'CZ', 'CZE', '+420', 'Prague', 'CZK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(59, 'Denmark', 'DK', 'DNK', '+45', 'Copenhagen', 'DKK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(60, 'Djibouti', 'DJ', 'DJI', '+253', 'Djibouti', 'DJF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(61, 'Dominica', 'DM', 'DMA', '+1-767', 'Roseau', 'XCD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(62, 'Dominican Republic', 'DO', 'DOM', '+1-809', 'Santo Domingo', 'DOP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(63, 'East Timor', 'TL', 'TLS', '+670', 'Dili', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(64, 'Ecuador', 'EC', 'ECU', '+593', 'Quito', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(65, 'Egypt', 'EG', 'EGY', '+20', 'Cairo', 'EGP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(66, 'El Salvador', 'SV', 'SLV', '+503', 'San Salvador', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(67, 'Equatorial Guinea', 'GQ', 'GNQ', '+240', 'Malabo', 'XAF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(68, 'Eritrea', 'ER', 'ERI', '+291', 'Asmara', 'ERN', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(69, 'Estonia', 'EE', 'EST', '+372', 'Tallinn', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(70, 'Ethiopia', 'ET', 'ETH', '+251', 'Addis Ababa', 'ETB', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(71, 'Falkland Islands', 'FK', 'FLK', '+500', 'Stanley', 'FKP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(72, 'Faroe Islands', 'FO', 'FRO', '+298', 'Torshavn', 'DKK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(73, 'Fiji Islands', 'FJ', 'FJI', '+679', 'Suva', 'FJD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(74, 'Finland', 'FI', 'FIN', '+358', 'Helsinki', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(75, 'France', 'FR', 'FRA', '+33', 'Paris', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(76, 'French Guiana', 'GF', 'GUF', '+594', 'Cayenne', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(77, 'French Polynesia', 'PF', 'PYF', '+689', 'Papeete', 'XPF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(78, 'French Southern Territories', 'TF', 'ATF', '+262', 'Port-aux-Francais', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(79, 'Gabon', 'GA', 'GAB', '+241', 'Libreville', 'XAF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(80, 'Gambia The', 'GM', 'GMB', '+220', 'Banjul', 'GMD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(81, 'Georgia', 'GE', 'GEO', '+995', 'Tbilisi', 'GEL', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(82, 'Germany', 'DE', 'DEU', '+49', 'Berlin', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(83, 'Ghana', 'GH', 'GHA', '+233', 'Accra', 'GHS', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(84, 'Gibraltar', 'GI', 'GIB', '+350', 'Gibraltar', 'GIP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(85, 'Greece', 'GR', 'GRC', '+30', 'Athens', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(86, 'Greenland', 'GL', 'GRL', '+299', 'Nuuk', 'DKK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(87, 'Grenada', 'GD', 'GRD', '+1-473', 'St. George\'s', 'XCD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(88, 'Guadeloupe', 'GP', 'GLP', '+590', 'Basse-Terre', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(89, 'Guam', 'GU', 'GUM', '+1-671', 'Hagatna', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(90, 'Guatemala', 'GT', 'GTM', '+502', 'Guatemala City', 'GTQ', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(91, 'Guernsey and Alderney', 'GG', 'GGY', '+44-1481', 'St Peter Port', 'GBP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(92, 'Guinea', 'GN', 'GIN', '+224', 'Conakry', 'GNF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(93, 'Guinea-Bissau', 'GW', 'GNB', '+245', 'Bissau', 'XOF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(94, 'Guyana', 'GY', 'GUY', '+592', 'Georgetown', 'GYD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(95, 'Haiti', 'HT', 'HTI', '+509', 'Port-au-Prince', 'HTG', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(96, 'Heard and McDonald Islands', 'HM', 'HMD', '+672', '', 'AUD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(97, 'Honduras', 'HN', 'HND', '+504', 'Tegucigalpa', 'HNL', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(98, 'Hong Kong S.A.R.', 'HK', 'HKG', '+852', 'Hong Kong', 'HKD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(99, 'Hungary', 'HU', 'HUN', '+36', 'Budapest', 'HUF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(100, 'Iceland', 'IS', 'ISL', '+354', 'Reykjavik', 'ISK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(101, 'India', 'IN', 'IND', '+91', 'New Delhi', 'INR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(102, 'Indonesia', 'ID', 'IDN', '+62', 'Jakarta', 'IDR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(103, 'Iran', 'IR', 'IRN', '+98', 'Tehran', 'IRR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(104, 'Iraq', 'IQ', 'IRQ', '+964', 'Baghdad', 'IQD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(105, 'Ireland', 'IE', 'IRL', '+353', 'Dublin', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(106, 'Israel', 'IL', 'ISR', '+972', 'Jerusalem', 'ILS', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(107, 'Italy', 'IT', 'ITA', '+39', 'Rome', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(108, 'Jamaica', 'JM', 'JAM', '+1-876', 'Kingston', 'JMD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(109, 'Japan', 'JP', 'JPN', '+81', 'Tokyo', 'JPY', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(110, 'Jersey', 'JE', 'JEY', '+44', 'Saint Helier', 'GBP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(111, 'Jordan', 'JO', 'JOR', '+962', 'Amman', 'JOD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(112, 'Kazakhstan', 'KZ', 'KAZ', '+7', 'Astana', 'KZT', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(113, 'Kenya', 'KE', 'KEN', '+254', 'Nairobi', 'KES', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(114, 'Kiribati', 'KI', 'KIR', '+686', 'Tarawa', 'AUD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(115, 'Korea North', 'KP', 'PRK', '+850', 'Pyongyang', 'KPW', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(116, 'Korea South', 'KR', 'KOR', '+82', 'Seoul', 'KRW', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(117, 'Kuwait', 'KW', 'KWT', '+965', 'Kuwait City', 'KWD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(118, 'Kyrgyzstan', 'KG', 'KGZ', '+996', 'Bishkek', 'KGS', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(119, 'Laos', 'LA', 'LAO', '+856', 'Vientiane', 'LAK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(120, 'Latvia', 'LV', 'LVA', '+371', 'Riga', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(121, 'Lebanon', 'LB', 'LBN', '+961', 'Beirut', 'LBP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(122, 'Lesotho', 'LS', 'LSO', '+266', 'Maseru', 'LSL', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(123, 'Liberia', 'LR', 'LBR', '+231', 'Monrovia', 'LRD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(124, 'Libya', 'LY', 'LBY', '+218', 'Tripolis', 'LYD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(125, 'Liechtenstein', 'LI', 'LIE', '+423', 'Vaduz', 'CHF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(126, 'Lithuania', 'LT', 'LTU', '+370', 'Vilnius', 'EUR', 1, '2018-07-20 09:11:03', '2020-08-15 05:58:03'),
(127, 'Luxembourg', 'LU', 'LUX', '+352', 'Luxembourg', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(128, 'Macau S.A.R.', 'MO', 'MAC', '+853', 'Macao', 'MOP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(129, 'Macedonia', 'MK', 'MKD', '+389', 'Skopje', 'MKD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(130, 'Madagascar', 'MG', 'MDG', '+261', 'Antananarivo', 'MGA', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(131, 'Malawi', 'MW', 'MWI', '+265', 'Lilongwe', 'MWK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(132, 'Malaysia', 'MY', 'MYS', '+60', 'Kuala Lumpur', 'MYR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(133, 'Maldives', 'MV', 'MDV', '+960', 'Male', 'MVR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(134, 'Mali', 'ML', 'MLI', '+223', 'Bamako', 'XOF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(135, 'Malta', 'MT', 'MLT', '+356', 'Valletta', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(136, 'Man (Isle of)', 'IM', 'IMN', '+44', 'Douglas, Isle of Man', 'GBP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(137, 'Marshall Islands', 'MH', 'MHL', '+692', 'Majuro', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(138, 'Martinique', 'MQ', 'MTQ', '+596', 'Fort-de-France', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(139, 'Mauritania', 'MR', 'MRT', '+222', 'Nouakchott', 'MRO', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(140, 'Mauritius', 'MU', 'MUS', '+230', 'Port Louis', 'MUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(141, 'Mayotte', 'YT', 'MYT', '+262', 'Mamoudzou', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(142, 'Mexico', 'MX', 'MEX', '+52', 'Mexico City', 'MXN', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(143, 'Micronesia', 'FM', 'FSM', '+691', 'Palikir', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(144, 'Moldova', 'MD', 'MDA', '+373', 'Chisinau', 'MDL', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(145, 'Monaco', 'MC', 'MCO', '+377', 'Monaco', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(146, 'Mongolia', 'MN', 'MNG', '+976', 'Ulan Bator', 'MNT', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(147, 'Montenegro', 'ME', 'MNE', '+382', 'Podgorica', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(148, 'Montserrat', 'MS', 'MSR', '+1-664', 'Plymouth', 'XCD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(149, 'Morocco', 'MA', 'MAR', '+212', 'Rabat', 'MAD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(150, 'Mozambique', 'MZ', 'MOZ', '+258', 'Maputo', 'MZN', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(151, 'Myanmar', 'MM', 'MMR', '+95', 'Nay Pyi Taw', 'MMK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(152, 'Namibia', 'NA', 'NAM', '+264', 'Windhoek', 'NAD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(153, 'Nauru', 'NR', 'NRU', '+674', 'Yaren', 'AUD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(154, 'Nepal', 'NP', 'NPL', '+977', 'Kathmandu', 'NPR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(155, 'Netherlands Antilles', 'AN', 'ANT', '+599', '', '', 1, '2018-07-20 09:11:03', '2018-07-20 09:11:03'),
(156, 'Netherlands The', 'NL', 'NLD', '+31', 'Amsterdam', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(157, 'New Caledonia', 'NC', 'NCL', '+687', 'Noumea', 'XPF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(158, 'New Zealand', 'NZ', 'NZL', '+64', 'Wellington', 'NZD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(159, 'Nicaragua', 'NI', 'NIC', '+505', 'Managua', 'NIO', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(160, 'Niger', 'NE', 'NER', '+227', 'Niamey', 'XOF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(161, 'Nigeria', 'NG', 'NGA', '+234', 'Abuja', 'NGN', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(162, 'Niue', 'NU', 'NIU', '+683', 'Alofi', 'NZD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(163, 'Norfolk Island', 'NF', 'NFK', '+672', 'Kingston', 'AUD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(164, 'Northern Mariana Islands', 'MP', 'MNP', '+1-670', 'Saipan', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(165, 'Norway', 'NO', 'NOR', '+47', 'Oslo', 'NOK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(166, 'Oman', 'OM', 'OMN', '+968', 'Muscat', 'OMR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(167, 'Pakistan', 'PK', 'PAK', '+92', 'Islamabad', 'PKR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(168, 'Palau', 'PW', 'PLW', '+680', 'Melekeok', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(169, 'Palestinian Territory Occupied', 'PS', 'PSE', '+970', 'East Jerusalem', 'ILS', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(170, 'Panama', 'PA', 'PAN', '+507', 'Panama City', 'PAB', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(171, 'Papua new Guinea', 'PG', 'PNG', '+675', 'Port Moresby', 'PGK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(172, 'Paraguay', 'PY', 'PRY', '+595', 'Asuncion', 'PYG', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(173, 'Peru', 'PE', 'PER', '+51', 'Lima', 'PEN', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(174, 'Philippines', 'PH', 'PHL', '+63', 'Manila', 'PHP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(175, 'Pitcairn Island', 'PN', 'PCN', '+870', 'Adamstown', 'NZD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(176, 'Poland', 'PL', 'POL', '+48', 'Warsaw', 'PLN', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(177, 'Portugal', 'PT', 'PRT', '+351', 'Lisbon', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(178, 'Puerto Rico', 'PR', 'PRI', '+1-787', 'San Juan', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(179, 'Qatar', 'QA', 'QAT', '+974', 'Doha', 'QAR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(180, 'Reunion', 'RE', 'REU', '+262', 'Saint-Denis', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(181, 'Romania', 'RO', 'ROU', '+40', 'Bucharest', 'RON', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(182, 'Russia', 'RU', 'RUS', '+7', 'Moscow', 'RUB', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(183, 'Rwanda', 'RW', 'RWA', '+250', 'Kigali', 'RWF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(184, 'Saint Helena', 'SH', 'SHN', '+290', 'Jamestown', 'SHP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(185, 'Saint Kitts And Nevis', 'KN', 'KNA', '+1-869', 'Basseterre', 'XCD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(186, 'Saint Lucia', 'LC', 'LCA', '+1-758', 'Castries', 'XCD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(187, 'Saint Pierre and Miquelon', 'PM', 'SPM', '+508', 'Saint-Pierre', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(188, 'Saint Vincent And The Grenadines', 'VC', 'VCT', '+1-784', 'Kingstown', 'XCD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(189, 'Saint-Barthelemy', 'BL', 'BLM', '+590', 'Gustavia', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(190, 'Saint-Martin (French part)', 'MF', 'MAF', '+590', 'Marigot', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(191, 'Samoa', 'WS', 'WSM', '+685', 'Apia', 'WST', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(192, 'San Marino', 'SM', 'SMR', '+378', 'San Marino', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(193, 'Sao Tome and Principe', 'ST', 'STP', '+239', 'Sao Tome', 'STD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(194, 'Saudi Arabia', 'SA', 'SAU', '+966', 'Riyadh', 'SAR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(195, 'Senegal', 'SN', 'SEN', '+221', 'Dakar', 'XOF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(196, 'Serbia', 'RS', 'SRB', '+381', 'Belgrade', 'RSD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(197, 'Seychelles', 'SC', 'SYC', '+248', 'Victoria', 'SCR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(198, 'Sierra Leone', 'SL', 'SLE', '+232', 'Freetown', 'SLL', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(199, 'Singapore', 'SG', 'SGP', '+65', 'Singapur', 'SGD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(200, 'Slovakia', 'SK', 'SVK', '+421', 'Bratislava', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(201, 'Slovenia', 'SI', 'SVN', '+386', 'Ljubljana', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(202, 'Solomon Islands', 'SB', 'SLB', '+677', 'Honiara', 'SBD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(203, 'Somalia', 'SO', 'SOM', '+252', 'Mogadishu', 'SOS', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(204, 'South Africa', 'ZA', 'ZAF', '+27', 'Pretoria', 'ZAR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(205, 'South Georgia', 'GS', 'SGS', '+500', 'Grytviken', 'GBP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(206, 'South Sudan', 'SS', 'SSD', '+211', 'Juba', 'SSP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(207, 'Spain', 'ES', 'ESP', '+34', 'Madrid', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(208, 'Sri Lanka', 'LK', 'LKA', '+94', 'Colombo', 'LKR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(209, 'Sudan', 'SD', 'SDN', '+249', 'Khartoum', 'SDG', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(210, 'Suriname', 'SR', 'SUR', '+597', 'Paramaribo', 'SRD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(211, 'Svalbard And Jan Mayen Islands', 'SJ', 'SJM', '+47', 'Longyearbyen', 'NOK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(212, 'Swaziland', 'SZ', 'SWZ', '+268', 'Mbabane', 'SZL', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(213, 'Sweden', 'SE', 'SWE', '+46', 'Stockholm', 'SEK', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(214, 'Switzerland', 'CH', 'CHE', '+41', 'Berne', 'CHF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(215, 'Syria', 'SY', 'SYR', '+963', 'Damascus', 'SYP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(216, 'Taiwan', 'TW', 'TWN', '+886', 'Taipei', 'TWD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(217, 'Tajikistan', 'TJ', 'TJK', '+992', 'Dushanbe', 'TJS', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(218, 'Tanzania', 'TZ', 'TZA', '+255', 'Dodoma', 'TZS', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(219, 'Thailand', 'TH', 'THA', '+66', 'Bangkok', 'THB', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(220, 'Togo', 'TG', 'TGO', '+228', 'Lome', 'XOF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(221, 'Tokelau', 'TK', 'TKL', '+690', '', 'NZD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(222, 'Tonga', 'TO', 'TON', '+676', 'Nuku\'alofa', 'TOP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(223, 'Trinidad And Tobago', 'TT', 'TTO', '+1-868', 'Port of Spain', 'TTD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(224, 'Tunisia', 'TN', 'TUN', '+216', 'Tunis', 'TND', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(225, 'Turkey', 'TR', 'TUR', '+90', 'Ankara', 'TRY', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(226, 'Turkmenistan', 'TM', 'TKM', '+993', 'Ashgabat', 'TMT', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(227, 'Turks And Caicos Islands', 'TC', 'TCA', '+1-649', 'Cockburn Town', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(228, 'Tuvalu', 'TV', 'TUV', '+688', 'Funafuti', 'AUD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(229, 'Uganda', 'UG', 'UGA', '+256', 'Kampala', 'UGX', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(230, 'Ukraine', 'UA', 'UKR', '+380', 'Kiev', 'UAH', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(231, 'United Arab Emirates', 'AE', 'ARE', '+971', 'Abu Dhabi', 'AED', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(232, 'United Kingdom', 'GB', 'GBR', '+44', 'London', 'GBP', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(233, 'United States', 'US', 'USA', '+1', 'Washington', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(234, 'United States Minor Outlying Islands', 'UM', 'UMI', '+1', '', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(235, 'Uruguay', 'UY', 'URY', '+598', 'Montevideo', 'UYU', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(236, 'Uzbekistan', 'UZ', 'UZB', '+998', 'Tashkent', 'UZS', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(237, 'Vanuatu', 'VU', 'VUT', '+678', 'Port Vila', 'VUV', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(238, 'Vatican City State (Holy See)', 'VA', 'VAT', '+379', 'Vatican City', 'EUR', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(239, 'Venezuela', 'VE', 'VEN', '+58', 'Caracas', 'VEF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(240, 'Vietnam', 'VN', 'VNM', '+84', 'Hanoi', 'VND', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(241, 'Virgin Islands (British)', 'VG', 'VGB', '+1-284', 'Road Town', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(242, 'Virgin Islands (US)', 'VI', 'VIR', '+1-340', 'Charlotte Amalie', 'USD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(243, 'Wallis And Futuna Islands', 'WF', 'WLF', '+681', 'Mata Utu', 'XPF', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(244, 'Western Sahara', 'EH', 'ESH', '+212', 'El-Aaiun', 'MAD', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(245, 'Yemen', 'YE', 'YEM', '+967', 'Sanaa', 'YER', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(246, 'Zambia', 'ZM', 'ZMB', '+260', 'Lusaka', 'ZMW', 1, '2018-07-20 09:11:03', '2020-08-15 05:58:10'),
(247, 'Zimbabwe', 'ZW', 'ZWE', '+263', 'Harare', 'ZWL', 1, '2018-07-20 09:11:03', '2020-05-15 23:49:11'),
(248, 'Kosovo', 'XK', 'XKX', '+383', 'Pristina', 'EUR', 1, '2020-08-15 04:33:50', '2020-08-15 04:36:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countries_name_country_code_phone_code_index` (`name`,`country_code`,`phone_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*! +90	Afghanistan
+355	Albania
+213	Algeria
+684	American Samoa
+376	Andorra
+244	Angola
+1264	Anguilla
+1268	Antigua and Barbuda
+54	Argentina
+374	Armenia
+297	Aruba
+61	Australia
+672	Australia - Christmas Island
+672	Australia - Cocos (Keeling) Islands
+672	Australia - Heard and McDonald (Islands)
+6723	Australia - Norfolk Island
+43	Austria
+994	Azerbaijan
+1242	Bahamas, The
+973	Bahrain
+880	Bangladesh
+1246	Barbados
+375	Belarus
+32	Belgium
+501	Belize
+229	Benin
+1441	Bermuda
+975	Bhutan
+591	Bolivia
+387	Bosnia and Herzegovina
+267	Botswana
+55	Brazil
+246	British Indian Ocean Territory - Diego Garcia
+673	Brunei
+359	Bulgaria
+226	Burkina Faso
+257	Burundi
+855	Cambodia
+237	Cameroon
+1	Canada
+238	Cape Verde
+1345	Cayman (Islands)
+236	Central African Republic
+235	Chad
+56	Chile
+86	China
+57	Colombia
+269	Comoros
+242	Congo
+243	Congo Zaire (Dem. Rep.)
+682	Cook Islands
+506	Costa Rica
+385	Croatia
+53	Cuba
+357	Cyprus
+420	Czech (Rep.)
+45	Denmark
+253	Djibouti
+1767	Dominica
+1809	Dominican (Republic)
+670	East Timor - Leste
+593	Ecuador
+20	Egypt
+503	El Salvador
+240	Equatorial Guinea
+291	Eritrea
+372	Estonia
+251	Ethiopia
+500	Falkland Islands (Malvinas)
+298	Faroe Islands
+679	Fiji
+358	Finland
+33	France
+33	France - Guadeloupe
+33	France - Guiana
+33	France - Martinique
+33	France - Mayotte
+689	France - Polynesia
+33	France - Réunion
+33	France - Saint-Pierre and Miquelon
+33	France - Southern Territories
+681	France - Wallis and Futuna
+241	Gabon
+220	Gambia
+995	Georgia
+49	Germany
+233	Ghana
+350	Gibraltar
+30	Greece
+299	Greenland
+1473	Grenada
+671	Guam
+502	Guatemala
+224	Guinea
+245	Guinea-Bissau
+592	Guyana
+509	Haiti
+504	Honduras
+852	Hong Kong
+36	Hungary
+354	Iceland
+91	India
+62	Indonesia
+98	Iran (Islamic Rep. of)
+964	Iraq
+353	Ireland
+972	Israel
+390	Italy
+225	Ivory Coast
+1876	Jamaica
+81	Japan
+44	Jersey (Islands)
+962	Jordan
+7	Kazakhstan
+254	Kenya
+686	Kiribati
+850	Korea (Dem. People's Rep. of) (North)
+82	Korea (Republic of) (South)
+965	Kuwait
+996	Kyrgyzstan
+856	Laos (People's Democratic Rep. of)
+371	Latvia
+961	Lebanon
+266	Lesotho
+231	Liberia
+218	Libya (Libyan Arab Jamahiriya)
+423	Liechtenstein
+370	Lithuania
+352	Luxembourg
+853	Macau
+389	Macedonia (F.Y.R.O.M.)
+261	Madagascar
+265	Malawi
+60	Malaysia
+960	Maldives (Islands)
+223	Mali
+356	Malta
+692	Marshall Islands
+222	Mauritania
+230	Mauritius (Island)
+52	Mexico
+691	Micronesia
+373	Moldova
+377	Monaco
+976	Mongolia
+1664	Montserrat
+212	Morocco
+258	Mozambique
+95	Myanmar (Burma)
+264	Namibia
+674	Nauru
+977	Nepal
+31	Netherlands
+599	Netherlands Antilles
+687	New Caledonia
+64	New Zealand
+690	New Zealand - Tokelau
+505	Nicaragua
+227	Niger
+234	Nigeria
+683	Niue
+1670	Northern Marianas (Islands)
+47	Norway
+47	Norway - Bouvet Island
+47	Norway - Svalbard and Jan Mayen
+968	Oman
+92	Pakistan
+680	Palau
+970	Palestinian Territories
+507	Panama
+675	Papua New Guinea
+595	Paraguay
+51	Peru
+63	Philippines
+672	Pitcairn Islands
+48	Poland
+351	Portugal
+351	Portugal - Azores
+351	Portugal - Madeira
+1787	Puerto Rico
+974	Qatar
+40	Romania
+7	Russia
+250	Rwanda
+290	Saint Helena
+247	Saint Helena: Ascension
+1869	Saint Kitts and Nevis
+1758	Saint Lucia
+1784	Saint Vincent and the Grenadines
+685	Samoa
+378	San Marino
+239	Sao Tome and Principe
+966	Saudi Arabia
+221	Senegal
+248	Seychelles (Islands)
+232	Sierra Leone
+65	Singapore
+421	Slovakia (Republic)
+386	Slovenia
+677	Solomon (Islands)
+252	Somalia
+27	South Africa
+34	Spain
+94	Sri Lanka
+249	Sudan
+597	Suriname
+268	Swaziland
+46	Sweden
+41	Switzerland
+963	Syria
+886	Taiwan
+992	Tajikistan (Republic of)
+255	Tanzania
+66	Thailand
+228	Togo
+676	Tonga
+1868	Trinidad and Tobago
+216	Tunisia
+90	Turkey
+993	Turkmenistan
+1649	Turks and Caicos Islands
+688	Tuvalu
+256	Uganda
+380	Ukraine
+971	United Arab Emirates
+44	United Kingdom (UK)
+1	United States of America (USA)
+1	United States of America (USA): Minor Outlying Islands
+598	Uruguay
+7	Uzbekistan
+678	Vanuatu
+264	Vatican
+58	Venezuela
+84	Vietnam
+1340	Virgin Islands (USA)
+1284	Virgin Islands, British (Tortola)
+212	Western Sahara
+967	Yemen (Rep. of)
+381	Yugoslavia
+260	Zambia
+263	Zimbabwe*/
