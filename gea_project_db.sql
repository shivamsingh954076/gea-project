-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2022 at 03:26 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gea_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `updated_at`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '01cc35daa1d795ea28fb52340399b83b', NULL, '2022-04-18 13:46:38'),
(2, '{\"name\": \"admin2\", \"email\": \"admin@gmail.com\"}', '', '', NULL, '2022-04-21 17:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `phone` int(5) NOT NULL,
  `code` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `capital` varchar(80) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `created_datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `phone`, `code`, `name`, `symbol`, `capital`, `currency`, `active`, `updated_datetime`, `created_datetime`) VALUES
(1, 93, 'AF', 'Afghanistan', '؋', 'Kabul', 'AFN', 1, NULL, '2022-04-16 13:40:11'),
(2, 358, 'AX', 'Aland Islands', '€', 'Mariehamn', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(3, 355, 'AL', 'Albania', 'Lek', 'Tirana', 'ALL', 1, NULL, '2022-04-16 13:40:11'),
(4, 213, 'DZ', 'Algeria', 'دج', 'Algiers', 'DZD', 1, NULL, '2022-04-16 13:40:11'),
(5, 1684, 'AS', 'American Samoa', '$', 'Pago Pago', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(6, 376, 'AD', 'Andorra', '€', 'Andorra la Vella', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(7, 244, 'AO', 'Angola', 'Kz', 'Luanda', 'AOA', 1, NULL, '2022-04-16 13:40:11'),
(8, 1264, 'AI', 'Anguilla', '$', 'The Valley', 'XCD', 1, NULL, '2022-04-16 13:40:11'),
(9, 672, 'AQ', 'Antarctica', '$', 'Antarctica', 'AAD', 1, NULL, '2022-04-16 13:40:11'),
(10, 1268, 'AG', 'Antigua and Barbuda', '$', 'St. John\'s', 'XCD', 1, NULL, '2022-04-16 13:40:11'),
(11, 54, 'AR', 'Argentina', '$', 'Buenos Aires', 'ARS', 1, NULL, '2022-04-16 13:40:11'),
(12, 374, 'AM', 'Armenia', '֏', 'Yerevan', 'AMD', 1, NULL, '2022-04-16 13:40:11'),
(13, 297, 'AW', 'Aruba', 'ƒ', 'Oranjestad', 'AWG', 1, NULL, '2022-04-16 13:40:11'),
(14, 61, 'AU', 'Australia', '$', 'Canberra', 'AUD', 1, NULL, '2022-04-16 13:40:11'),
(15, 43, 'AT', 'Austria', '€', 'Vienna', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(16, 994, 'AZ', 'Azerbaijan', 'm', 'Baku', 'AZN', 1, NULL, '2022-04-16 13:40:11'),
(17, 1242, 'BS', 'Bahamas', 'B$', 'Nassau', 'BSD', 1, NULL, '2022-04-16 13:40:11'),
(18, 973, 'BH', 'Bahrain', '.د.ب', 'Manama', 'BHD', 1, NULL, '2022-04-16 13:40:11'),
(19, 880, 'BD', 'Bangladesh', '৳', 'Dhaka', 'BDT', 1, NULL, '2022-04-16 13:40:11'),
(20, 1246, 'BB', 'Barbados', 'Bds$', 'Bridgetown', 'BBD', 1, NULL, '2022-04-16 13:40:11'),
(21, 375, 'BY', 'Belarus', 'Br', 'Minsk', 'BYN', 1, NULL, '2022-04-16 13:40:11'),
(22, 32, 'BE', 'Belgium', '€', 'Brussels', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(23, 501, 'BZ', 'Belize', '$', 'Belmopan', 'BZD', 1, NULL, '2022-04-16 13:40:11'),
(24, 229, 'BJ', 'Benin', 'CFA', 'Porto-Novo', 'XOF', 1, NULL, '2022-04-16 13:40:11'),
(25, 1441, 'BM', 'Bermuda', '$', 'Hamilton', 'BMD', 1, NULL, '2022-04-16 13:40:11'),
(26, 975, 'BT', 'Bhutan', 'Nu.', 'Thimphu', 'BTN', 1, NULL, '2022-04-16 13:40:11'),
(27, 591, 'BO', 'Bolivia', 'Bs.', 'Sucre', 'BOB', 1, NULL, '2022-04-16 13:40:11'),
(28, 599, 'BQ', 'Bonaire, Sint Eustatius and Saba', '$', 'Kralendijk', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(29, 387, 'BA', 'Bosnia and Herzegovina', 'KM', 'Sarajevo', 'BAM', 1, NULL, '2022-04-16 13:40:11'),
(30, 267, 'BW', 'Botswana', 'P', 'Gaborone', 'BWP', 1, NULL, '2022-04-16 13:40:11'),
(31, 55, 'BV', 'Bouvet Island', 'kr', '', 'NOK', 1, NULL, '2022-04-16 13:40:11'),
(32, 55, 'BR', 'Brazil', 'R$', 'Brasilia', 'BRL', 1, NULL, '2022-04-16 13:40:11'),
(33, 246, 'IO', 'British Indian Ocean Territory', '$', 'Diego Garcia', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(34, 673, 'BN', 'Brunei Darussalam', 'B$', 'Bandar Seri Begawan', 'BND', 1, NULL, '2022-04-16 13:40:11'),
(35, 359, 'BG', 'Bulgaria', 'Лв.', 'Sofia', 'BGN', 1, NULL, '2022-04-16 13:40:11'),
(36, 226, 'BF', 'Burkina Faso', 'CFA', 'Ouagadougou', 'XOF', 1, NULL, '2022-04-16 13:40:11'),
(37, 257, 'BI', 'Burundi', 'FBu', 'Bujumbura', 'BIF', 1, NULL, '2022-04-16 13:40:11'),
(38, 855, 'KH', 'Cambodia', 'KHR', 'Phnom Penh', 'KHR', 1, NULL, '2022-04-16 13:40:11'),
(39, 237, 'CM', 'Cameroon', 'FCFA', 'Yaounde', 'XAF', 1, NULL, '2022-04-16 13:40:11'),
(40, 1, 'CA', 'Canada', '$', 'Ottawa', 'CAD', 1, NULL, '2022-04-16 13:40:11'),
(41, 238, 'CV', 'Cape Verde', '$', 'Praia', 'CVE', 1, NULL, '2022-04-16 13:40:11'),
(42, 1345, 'KY', 'Cayman Islands', '$', 'George Town', 'KYD', 1, NULL, '2022-04-16 13:40:11'),
(43, 236, 'CF', 'Central African Republic', 'FCFA', 'Bangui', 'XAF', 1, NULL, '2022-04-16 13:40:11'),
(44, 235, 'TD', 'Chad', 'FCFA', 'N\'Djamena', 'XAF', 1, NULL, '2022-04-16 13:40:11'),
(45, 56, 'CL', 'Chile', '$', 'Santiago', 'CLP', 1, NULL, '2022-04-16 13:40:11'),
(46, 86, 'CN', 'China', '¥', 'Beijing', 'CNY', 1, NULL, '2022-04-16 13:40:11'),
(47, 61, 'CX', 'Christmas Island', '$', 'Flying Fish Cove', 'AUD', 1, NULL, '2022-04-16 13:40:11'),
(48, 672, 'CC', 'Cocos (Keeling) Islands', '$', 'West Island', 'AUD', 1, NULL, '2022-04-16 13:40:11'),
(49, 57, 'CO', 'Colombia', '$', 'Bogota', 'COP', 1, NULL, '2022-04-16 13:40:11'),
(50, 269, 'KM', 'Comoros', 'CF', 'Moroni', 'KMF', 1, NULL, '2022-04-16 13:40:11'),
(51, 242, 'CG', 'Congo', 'FC', 'Brazzaville', 'XAF', 1, NULL, '2022-04-16 13:40:11'),
(52, 242, 'CD', 'Congo, Democratic Republic of the Congo', 'FC', 'Kinshasa', 'CDF', 1, NULL, '2022-04-16 13:40:11'),
(53, 682, 'CK', 'Cook Islands', '$', 'Avarua', 'NZD', 1, NULL, '2022-04-16 13:40:11'),
(54, 506, 'CR', 'Costa Rica', '₡', 'San Jose', 'CRC', 1, NULL, '2022-04-16 13:40:11'),
(55, 225, 'CI', 'Cote D\'Ivoire', 'CFA', 'Yamoussoukro', 'XOF', 1, NULL, '2022-04-16 13:40:11'),
(56, 385, 'HR', 'Croatia', 'kn', 'Zagreb', 'HRK', 1, NULL, '2022-04-16 13:40:11'),
(57, 53, 'CU', 'Cuba', '$', 'Havana', 'CUP', 1, NULL, '2022-04-16 13:40:11'),
(58, 599, 'CW', 'Curacao', 'ƒ', 'Willemstad', 'ANG', 1, NULL, '2022-04-16 13:40:11'),
(59, 357, 'CY', 'Cyprus', '€', 'Nicosia', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(60, 420, 'CZ', 'Czech Republic', 'Kč', 'Prague', 'CZK', 1, NULL, '2022-04-16 13:40:11'),
(61, 45, 'DK', 'Denmark', 'Kr.', 'Copenhagen', 'DKK', 1, NULL, '2022-04-16 13:40:11'),
(62, 253, 'DJ', 'Djibouti', 'Fdj', 'Djibouti', 'DJF', 1, NULL, '2022-04-16 13:40:11'),
(63, 1767, 'DM', 'Dominica', '$', 'Roseau', 'XCD', 1, NULL, '2022-04-16 13:40:11'),
(64, 1809, 'DO', 'Dominican Republic', '$', 'Santo Domingo', 'DOP', 1, NULL, '2022-04-16 13:40:11'),
(65, 593, 'EC', 'Ecuador', '$', 'Quito', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(66, 20, 'EG', 'Egypt', 'ج.م', 'Cairo', 'EGP', 1, NULL, '2022-04-16 13:40:11'),
(67, 503, 'SV', 'El Salvador', '$', 'San Salvador', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(68, 240, 'GQ', 'Equatorial Guinea', 'FCFA', 'Malabo', 'XAF', 1, NULL, '2022-04-16 13:40:11'),
(69, 291, 'ER', 'Eritrea', 'Nfk', 'Asmara', 'ERN', 1, NULL, '2022-04-16 13:40:11'),
(70, 372, 'EE', 'Estonia', '€', 'Tallinn', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(71, 251, 'ET', 'Ethiopia', 'Nkf', 'Addis Ababa', 'ETB', 1, NULL, '2022-04-16 13:40:11'),
(72, 500, 'FK', 'Falkland Islands (Malvinas)', '£', 'Stanley', 'FKP', 1, NULL, '2022-04-16 13:40:11'),
(73, 298, 'FO', 'Faroe Islands', 'Kr.', 'Torshavn', 'DKK', 1, NULL, '2022-04-16 13:40:11'),
(74, 679, 'FJ', 'Fiji', 'FJ$', 'Suva', 'FJD', 1, NULL, '2022-04-16 13:40:11'),
(75, 358, 'FI', 'Finland', '€', 'Helsinki', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(76, 33, 'FR', 'France', '€', 'Paris', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(77, 594, 'GF', 'French Guiana', '€', 'Cayenne', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(78, 689, 'PF', 'French Polynesia', '₣', 'Papeete', 'XPF', 1, NULL, '2022-04-16 13:40:11'),
(79, 262, 'TF', 'French Southern Territories', '€', 'Port-aux-Francais', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(80, 241, 'GA', 'Gabon', 'FCFA', 'Libreville', 'XAF', 1, NULL, '2022-04-16 13:40:11'),
(81, 220, 'GM', 'Gambia', 'D', 'Banjul', 'GMD', 1, NULL, '2022-04-16 13:40:11'),
(82, 995, 'GE', 'Georgia', 'ლ', 'Tbilisi', 'GEL', 1, NULL, '2022-04-16 13:40:11'),
(83, 49, 'DE', 'Germany', '€', 'Berlin', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(84, 233, 'GH', 'Ghana', 'GH₵', 'Accra', 'GHS', 1, NULL, '2022-04-16 13:40:11'),
(85, 350, 'GI', 'Gibraltar', '£', 'Gibraltar', 'GIP', 1, NULL, '2022-04-16 13:40:11'),
(86, 30, 'GR', 'Greece', '€', 'Athens', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(87, 299, 'GL', 'Greenland', 'Kr.', 'Nuuk', 'DKK', 1, NULL, '2022-04-16 13:40:11'),
(88, 1473, 'GD', 'Grenada', '$', 'St. George\'s', 'XCD', 1, NULL, '2022-04-16 13:40:11'),
(89, 590, 'GP', 'Guadeloupe', '€', 'Basse-Terre', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(90, 1671, 'GU', 'Guam', '$', 'Hagatna', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(91, 502, 'GT', 'Guatemala', 'Q', 'Guatemala City', 'GTQ', 1, NULL, '2022-04-16 13:40:11'),
(92, 44, 'GG', 'Guernsey', '£', 'St Peter Port', 'GBP', 1, NULL, '2022-04-16 13:40:11'),
(93, 224, 'GN', 'Guinea', 'FG', 'Conakry', 'GNF', 1, NULL, '2022-04-16 13:40:11'),
(94, 245, 'GW', 'Guinea-Bissau', 'CFA', 'Bissau', 'XOF', 1, NULL, '2022-04-16 13:40:11'),
(95, 592, 'GY', 'Guyana', '$', 'Georgetown', 'GYD', 1, NULL, '2022-04-16 13:40:11'),
(96, 509, 'HT', 'Haiti', 'G', 'Port-au-Prince', 'HTG', 1, NULL, '2022-04-16 13:40:11'),
(97, 0, 'HM', 'Heard Island and Mcdonald Islands', '$', '', 'AUD', 1, NULL, '2022-04-16 13:40:11'),
(98, 39, 'VA', 'Holy See (Vatican City State)', '€', 'Vatican City', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(99, 504, 'HN', 'Honduras', 'L', 'Tegucigalpa', 'HNL', 1, NULL, '2022-04-16 13:40:11'),
(100, 852, 'HK', 'Hong Kong', '$', 'Hong Kong', 'HKD', 1, NULL, '2022-04-16 13:40:11'),
(101, 36, 'HU', 'Hungary', 'Ft', 'Budapest', 'HUF', 1, NULL, '2022-04-16 13:40:11'),
(102, 354, 'IS', 'Iceland', 'kr', 'Reykjavik', 'ISK', 1, NULL, '2022-04-16 13:40:11'),
(103, 91, 'IN', 'India', '₹', 'New Delhi', 'INR', 1, NULL, '2022-04-16 13:40:11'),
(104, 62, 'ID', 'Indonesia', 'Rp', 'Jakarta', 'IDR', 1, NULL, '2022-04-16 13:40:11'),
(105, 98, 'IR', 'Iran, Islamic Republic of', '﷼', 'Tehran', 'IRR', 1, NULL, '2022-04-16 13:40:11'),
(106, 964, 'IQ', 'Iraq', 'د.ع', 'Baghdad', 'IQD', 1, NULL, '2022-04-16 13:40:11'),
(107, 353, 'IE', 'Ireland', '€', 'Dublin', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(108, 44, 'IM', 'Isle of Man', '£', 'Douglas, Isle of Man', 'GBP', 1, NULL, '2022-04-16 13:40:11'),
(109, 972, 'IL', 'Israel', '₪', 'Jerusalem', 'ILS', 1, NULL, '2022-04-16 13:40:11'),
(110, 39, 'IT', 'Italy', '€', 'Rome', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(111, 1876, 'JM', 'Jamaica', 'J$', 'Kingston', 'JMD', 1, NULL, '2022-04-16 13:40:11'),
(112, 81, 'JP', 'Japan', '¥', 'Tokyo', 'JPY', 1, NULL, '2022-04-16 13:40:11'),
(113, 44, 'JE', 'Jersey', '£', 'Saint Helier', 'GBP', 1, NULL, '2022-04-16 13:40:11'),
(114, 962, 'JO', 'Jordan', 'ا.د', 'Amman', 'JOD', 1, NULL, '2022-04-16 13:40:11'),
(115, 7, 'KZ', 'Kazakhstan', 'лв', 'Astana', 'KZT', 1, NULL, '2022-04-16 13:40:11'),
(116, 254, 'KE', 'Kenya', 'KSh', 'Nairobi', 'KES', 1, NULL, '2022-04-16 13:40:11'),
(117, 686, 'KI', 'Kiribati', '$', 'Tarawa', 'AUD', 1, NULL, '2022-04-16 13:40:11'),
(118, 850, 'KP', 'Korea, Democratic People\'s Republic of', '₩', 'Pyongyang', 'KPW', 1, NULL, '2022-04-16 13:40:11'),
(119, 82, 'KR', 'Korea, Republic of', '₩', 'Seoul', 'KRW', 1, NULL, '2022-04-16 13:40:11'),
(120, 381, 'XK', 'Kosovo', '€', 'Pristina', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(121, 965, 'KW', 'Kuwait', 'ك.د', 'Kuwait City', 'KWD', 1, NULL, '2022-04-16 13:40:11'),
(122, 996, 'KG', 'Kyrgyzstan', 'лв', 'Bishkek', 'KGS', 1, NULL, '2022-04-16 13:40:11'),
(123, 856, 'LA', 'Lao People\'s Democratic Republic', '₭', 'Vientiane', 'LAK', 1, NULL, '2022-04-16 13:40:11'),
(124, 371, 'LV', 'Latvia', '€', 'Riga', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(125, 961, 'LB', 'Lebanon', '£', 'Beirut', 'LBP', 1, NULL, '2022-04-16 13:40:11'),
(126, 266, 'LS', 'Lesotho', 'L', 'Maseru', 'LSL', 1, NULL, '2022-04-16 13:40:11'),
(127, 231, 'LR', 'Liberia', '$', 'Monrovia', 'LRD', 1, NULL, '2022-04-16 13:40:11'),
(128, 218, 'LY', 'Libyan Arab Jamahiriya', 'د.ل', 'Tripolis', 'LYD', 1, NULL, '2022-04-16 13:40:11'),
(129, 423, 'LI', 'Liechtenstein', 'CHf', 'Vaduz', 'CHF', 1, NULL, '2022-04-16 13:40:11'),
(130, 370, 'LT', 'Lithuania', '€', 'Vilnius', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(131, 352, 'LU', 'Luxembourg', '€', 'Luxembourg', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(132, 853, 'MO', 'Macao', '$', 'Macao', 'MOP', 1, NULL, '2022-04-16 13:40:11'),
(133, 389, 'MK', 'Macedonia, the Former Yugoslav Republic of', 'ден', 'Skopje', 'MKD', 1, NULL, '2022-04-16 13:40:11'),
(134, 261, 'MG', 'Madagascar', 'Ar', 'Antananarivo', 'MGA', 1, NULL, '2022-04-16 13:40:11'),
(135, 265, 'MW', 'Malawi', 'MK', 'Lilongwe', 'MWK', 1, NULL, '2022-04-16 13:40:11'),
(136, 60, 'MY', 'Malaysia', 'RM', 'Kuala Lumpur', 'MYR', 1, NULL, '2022-04-16 13:40:11'),
(137, 960, 'MV', 'Maldives', 'Rf', 'Male', 'MVR', 1, NULL, '2022-04-16 13:40:11'),
(138, 223, 'ML', 'Mali', 'CFA', 'Bamako', 'XOF', 1, NULL, '2022-04-16 13:40:11'),
(139, 356, 'MT', 'Malta', '€', 'Valletta', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(140, 692, 'MH', 'Marshall Islands', '$', 'Majuro', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(141, 596, 'MQ', 'Martinique', '€', 'Fort-de-France', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(142, 222, 'MR', 'Mauritania', 'MRU', 'Nouakchott', 'MRO', 1, NULL, '2022-04-16 13:40:11'),
(143, 230, 'MU', 'Mauritius', '₨', 'Port Louis', 'MUR', 1, NULL, '2022-04-16 13:40:11'),
(144, 269, 'YT', 'Mayotte', '€', 'Mamoudzou', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(145, 52, 'MX', 'Mexico', '$', 'Mexico City', 'MXN', 1, NULL, '2022-04-16 13:40:11'),
(146, 691, 'FM', 'Micronesia, Federated States of', '$', 'Palikir', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(147, 373, 'MD', 'Moldova, Republic of', 'L', 'Chisinau', 'MDL', 1, NULL, '2022-04-16 13:40:11'),
(148, 377, 'MC', 'Monaco', '€', 'Monaco', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(149, 976, 'MN', 'Mongolia', '₮', 'Ulan Bator', 'MNT', 1, NULL, '2022-04-16 13:40:11'),
(150, 382, 'ME', 'Montenegro', '€', 'Podgorica', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(151, 1664, 'MS', 'Montserrat', '$', 'Plymouth', 'XCD', 1, NULL, '2022-04-16 13:40:11'),
(152, 212, 'MA', 'Morocco', 'DH', 'Rabat', 'MAD', 1, NULL, '2022-04-16 13:40:11'),
(153, 258, 'MZ', 'Mozambique', 'MT', 'Maputo', 'MZN', 1, NULL, '2022-04-16 13:40:11'),
(154, 95, 'MM', 'Myanmar', 'K', 'Nay Pyi Taw', 'MMK', 1, NULL, '2022-04-16 13:40:11'),
(155, 264, 'NA', 'Namibia', '$', 'Windhoek', 'NAD', 1, NULL, '2022-04-16 13:40:11'),
(156, 674, 'NR', 'Nauru', '$', 'Yaren', 'AUD', 1, NULL, '2022-04-16 13:40:11'),
(157, 977, 'NP', 'Nepal', '₨', 'Kathmandu', 'NPR', 1, NULL, '2022-04-16 13:40:11'),
(158, 31, 'NL', 'Netherlands', '€', 'Amsterdam', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(159, 599, 'AN', 'Netherlands Antilles', 'NAf', 'Willemstad', 'ANG', 1, NULL, '2022-04-16 13:40:11'),
(160, 687, 'NC', 'New Caledonia', '₣', 'Noumea', 'XPF', 1, NULL, '2022-04-16 13:40:11'),
(161, 64, 'NZ', 'New Zealand', '$', 'Wellington', 'NZD', 1, NULL, '2022-04-16 13:40:11'),
(162, 505, 'NI', 'Nicaragua', 'C$', 'Managua', 'NIO', 1, NULL, '2022-04-16 13:40:11'),
(163, 227, 'NE', 'Niger', 'CFA', 'Niamey', 'XOF', 1, NULL, '2022-04-16 13:40:11'),
(164, 234, 'NG', 'Nigeria', '₦', 'Abuja', 'NGN', 1, NULL, '2022-04-16 13:40:11'),
(165, 683, 'NU', 'Niue', '$', 'Alofi', 'NZD', 1, NULL, '2022-04-16 13:40:11'),
(166, 672, 'NF', 'Norfolk Island', '$', 'Kingston', 'AUD', 1, NULL, '2022-04-16 13:40:11'),
(167, 1670, 'MP', 'Northern Mariana Islands', '$', 'Saipan', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(168, 47, 'NO', 'Norway', 'kr', 'Oslo', 'NOK', 1, NULL, '2022-04-16 13:40:11'),
(169, 968, 'OM', 'Oman', '.ع.ر', 'Muscat', 'OMR', 1, NULL, '2022-04-16 13:40:11'),
(170, 92, 'PK', 'Pakistan', '₨', 'Islamabad', 'PKR', 1, NULL, '2022-04-16 13:40:11'),
(171, 680, 'PW', 'Palau', '$', 'Melekeok', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(172, 970, 'PS', 'Palestinian Territory, Occupied', '₪', 'East Jerusalem', 'ILS', 1, NULL, '2022-04-16 13:40:11'),
(173, 507, 'PA', 'Panama', 'B/.', 'Panama City', 'PAB', 1, NULL, '2022-04-16 13:40:11'),
(174, 675, 'PG', 'Papua New Guinea', 'K', 'Port Moresby', 'PGK', 1, NULL, '2022-04-16 13:40:11'),
(175, 595, 'PY', 'Paraguay', '₲', 'Asuncion', 'PYG', 1, NULL, '2022-04-16 13:40:11'),
(176, 51, 'PE', 'Peru', 'S/.', 'Lima', 'PEN', 1, NULL, '2022-04-16 13:40:11'),
(177, 63, 'PH', 'Philippines', '₱', 'Manila', 'PHP', 1, NULL, '2022-04-16 13:40:11'),
(178, 64, 'PN', 'Pitcairn', '$', 'Adamstown', 'NZD', 1, NULL, '2022-04-16 13:40:11'),
(179, 48, 'PL', 'Poland', 'zł', 'Warsaw', 'PLN', 1, NULL, '2022-04-16 13:40:11'),
(180, 351, 'PT', 'Portugal', '€', 'Lisbon', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(181, 1787, 'PR', 'Puerto Rico', '$', 'San Juan', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(182, 974, 'QA', 'Qatar', 'ق.ر', 'Doha', 'QAR', 1, NULL, '2022-04-16 13:40:11'),
(183, 262, 'RE', 'Reunion', '€', 'Saint-Denis', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(184, 40, 'RO', 'Romania', 'lei', 'Bucharest', 'RON', 1, NULL, '2022-04-16 13:40:11'),
(185, 70, 'RU', 'Russian Federation', '₽', 'Moscow', 'RUB', 1, NULL, '2022-04-16 13:40:11'),
(186, 250, 'RW', 'Rwanda', 'FRw', 'Kigali', 'RWF', 1, NULL, '2022-04-16 13:40:11'),
(187, 590, 'BL', 'Saint Barthelemy', '€', 'Gustavia', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(188, 290, 'SH', 'Saint Helena', '£', 'Jamestown', 'SHP', 1, NULL, '2022-04-16 13:40:11'),
(189, 1869, 'KN', 'Saint Kitts and Nevis', '$', 'Basseterre', 'XCD', 1, NULL, '2022-04-16 13:40:11'),
(190, 1758, 'LC', 'Saint Lucia', '$', 'Castries', 'XCD', 1, NULL, '2022-04-16 13:40:11'),
(191, 590, 'MF', 'Saint Martin', '€', 'Marigot', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(192, 508, 'PM', 'Saint Pierre and Miquelon', '€', 'Saint-Pierre', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(193, 1784, 'VC', 'Saint Vincent and the Grenadines', '$', 'Kingstown', 'XCD', 1, NULL, '2022-04-16 13:40:11'),
(194, 684, 'WS', 'Samoa', 'SAT', 'Apia', 'WST', 1, NULL, '2022-04-16 13:40:11'),
(195, 378, 'SM', 'San Marino', '€', 'San Marino', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(196, 239, 'ST', 'Sao Tome and Principe', 'Db', 'Sao Tome', 'STD', 1, NULL, '2022-04-16 13:40:11'),
(197, 966, 'SA', 'Saudi Arabia', '﷼', 'Riyadh', 'SAR', 1, NULL, '2022-04-16 13:40:11'),
(198, 221, 'SN', 'Senegal', 'CFA', 'Dakar', 'XOF', 1, NULL, '2022-04-16 13:40:11'),
(199, 381, 'RS', 'Serbia', 'din', 'Belgrade', 'RSD', 1, NULL, '2022-04-16 13:40:11'),
(200, 381, 'CS', 'Serbia and Montenegro', 'din', 'Belgrade', 'RSD', 1, NULL, '2022-04-16 13:40:11'),
(201, 248, 'SC', 'Seychelles', 'SRe', 'Victoria', 'SCR', 1, NULL, '2022-04-16 13:40:11'),
(202, 232, 'SL', 'Sierra Leone', 'Le', 'Freetown', 'SLL', 1, NULL, '2022-04-16 13:40:11'),
(203, 65, 'SG', 'Singapore', '$', 'Singapur', 'SGD', 1, NULL, '2022-04-16 13:40:11'),
(204, 1, 'SX', 'Sint Maarten', 'ƒ', 'Philipsburg', 'ANG', 1, NULL, '2022-04-16 13:40:11'),
(205, 421, 'SK', 'Slovakia', '€', 'Bratislava', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(206, 386, 'SI', 'Slovenia', '€', 'Ljubljana', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(207, 677, 'SB', 'Solomon Islands', 'Si$', 'Honiara', 'SBD', 1, NULL, '2022-04-16 13:40:11'),
(208, 252, 'SO', 'Somalia', 'Sh.so.', 'Mogadishu', 'SOS', 1, NULL, '2022-04-16 13:40:11'),
(209, 27, 'ZA', 'South Africa', 'R', 'Pretoria', 'ZAR', 1, NULL, '2022-04-16 13:40:11'),
(210, 500, 'GS', 'South Georgia and the South Sandwich Islands', '£', 'Grytviken', 'GBP', 1, NULL, '2022-04-16 13:40:11'),
(211, 211, 'SS', 'South Sudan', '£', 'Juba', 'SSP', 1, NULL, '2022-04-16 13:40:11'),
(212, 34, 'ES', 'Spain', '€', 'Madrid', 'EUR', 1, NULL, '2022-04-16 13:40:11'),
(213, 94, 'LK', 'Sri Lanka', 'Rs', 'Colombo', 'LKR', 1, NULL, '2022-04-16 13:40:11'),
(214, 249, 'SD', 'Sudan', '.س.ج', 'Khartoum', 'SDG', 1, NULL, '2022-04-16 13:40:11'),
(215, 597, 'SR', 'Suriname', '$', 'Paramaribo', 'SRD', 1, NULL, '2022-04-16 13:40:11'),
(216, 47, 'SJ', 'Svalbard and Jan Mayen', 'kr', 'Longyearbyen', 'NOK', 1, NULL, '2022-04-16 13:40:11'),
(217, 268, 'SZ', 'Swaziland', 'E', 'Mbabane', 'SZL', 1, NULL, '2022-04-16 13:40:11'),
(218, 46, 'SE', 'Sweden', 'kr', 'Stockholm', 'SEK', 1, NULL, '2022-04-16 13:40:11'),
(219, 41, 'CH', 'Switzerland', 'CHf', 'Berne', 'CHF', 1, NULL, '2022-04-16 13:40:11'),
(220, 963, 'SY', 'Syrian Arab Republic', 'LS', 'Damascus', 'SYP', 1, NULL, '2022-04-16 13:40:11'),
(221, 886, 'TW', 'Taiwan, Province of China', '$', 'Taipei', 'TWD', 1, NULL, '2022-04-16 13:40:11'),
(222, 992, 'TJ', 'Tajikistan', 'SM', 'Dushanbe', 'TJS', 1, NULL, '2022-04-16 13:40:11'),
(223, 255, 'TZ', 'Tanzania, United Republic of', 'TSh', 'Dodoma', 'TZS', 1, NULL, '2022-04-16 13:40:11'),
(224, 66, 'TH', 'Thailand', '฿', 'Bangkok', 'THB', 1, NULL, '2022-04-16 13:40:11'),
(225, 670, 'TL', 'Timor-Leste', '$', 'Dili', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(226, 228, 'TG', 'Togo', 'CFA', 'Lome', 'XOF', 1, NULL, '2022-04-16 13:40:11'),
(227, 690, 'TK', 'Tokelau', '$', '', 'NZD', 1, NULL, '2022-04-16 13:40:11'),
(228, 676, 'TO', 'Tonga', '$', 'Nuku\'alofa', 'TOP', 1, NULL, '2022-04-16 13:40:11'),
(229, 1868, 'TT', 'Trinidad and Tobago', '$', 'Port of Spain', 'TTD', 1, NULL, '2022-04-16 13:40:11'),
(230, 216, 'TN', 'Tunisia', 'ت.د', 'Tunis', 'TND', 1, NULL, '2022-04-16 13:40:11'),
(231, 90, 'TR', 'Turkey', '₺', 'Ankara', 'TRY', 1, NULL, '2022-04-16 13:40:11'),
(232, 7370, 'TM', 'Turkmenistan', 'T', 'Ashgabat', 'TMT', 1, NULL, '2022-04-16 13:40:11'),
(233, 1649, 'TC', 'Turks and Caicos Islands', '$', 'Cockburn Town', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(234, 688, 'TV', 'Tuvalu', '$', 'Funafuti', 'AUD', 1, NULL, '2022-04-16 13:40:11'),
(235, 256, 'UG', 'Uganda', 'USh', 'Kampala', 'UGX', 1, NULL, '2022-04-16 13:40:11'),
(236, 380, 'UA', 'Ukraine', '₴', 'Kiev', 'UAH', 1, NULL, '2022-04-16 13:40:11'),
(237, 971, 'AE', 'United Arab Emirates', 'إ.د', 'Abu Dhabi', 'AED', 1, NULL, '2022-04-16 13:40:11'),
(238, 44, 'GB', 'United Kingdom', '£', 'London', 'GBP', 1, NULL, '2022-04-16 13:40:11'),
(239, 1, 'US', 'United States', '$', 'Washington', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(240, 1, 'UM', 'United States Minor Outlying Islands', '$', '', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(241, 598, 'UY', 'Uruguay', '$', 'Montevideo', 'UYU', 1, NULL, '2022-04-16 13:40:11'),
(242, 998, 'UZ', 'Uzbekistan', 'лв', 'Tashkent', 'UZS', 1, NULL, '2022-04-16 13:40:11'),
(243, 678, 'VU', 'Vanuatu', 'VT', 'Port Vila', 'VUV', 1, NULL, '2022-04-16 13:40:11'),
(244, 58, 'VE', 'Venezuela', 'Bs', 'Caracas', 'VEF', 1, NULL, '2022-04-16 13:40:11'),
(245, 84, 'VN', 'Viet Nam', '₫', 'Hanoi', 'VND', 1, NULL, '2022-04-16 13:40:11'),
(246, 1284, 'VG', 'Virgin Islands, British', '$', 'Road Town', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(247, 1340, 'VI', 'Virgin Islands, U.s.', '$', 'Charlotte Amalie', 'USD', 1, NULL, '2022-04-16 13:40:11'),
(248, 681, 'WF', 'Wallis and Futuna', '₣', 'Mata Utu', 'XPF', 1, NULL, '2022-04-16 13:40:11'),
(249, 212, 'EH', 'Western Sahara', 'MAD', 'El-Aaiun', 'MAD', 1, NULL, '2022-04-16 13:40:11'),
(250, 967, 'YE', 'Yemen', '﷼', 'Sanaa', 'YER', 1, NULL, '2022-04-16 13:40:11'),
(251, 260, 'ZM', 'Zambia', 'ZK', 'Lusaka', 'ZMW', 1, NULL, '2022-04-16 13:40:11'),
(252, 263, 'ZW', 'Zimbabwe', '$', 'Harare', 'ZWL', 1, NULL, '2022-04-18 16:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `id` int(11) NOT NULL,
  `doc_name` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`id`, `doc_name`, `img`, `description`, `active`, `created_at`, `updated_at`) VALUES
(1, 'National ID Card', NULL, NULL, 1, '2022-04-15 13:56:25', NULL),
(2, 'Aadhar Card', NULL, NULL, 1, '2022-04-15 13:56:44', NULL),
(3, 'PAN Card', NULL, NULL, 1, '2022-04-15 13:56:44', NULL),
(6, 'Aadhar Card 2', NULL, NULL, 1, '2022-04-19 15:51:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doc_countries`
--

CREATE TABLE `doc_countries` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doc_countries`
--

INSERT INTO `doc_countries` (`id`, `country_id`, `doc_id`, `active`, `updated_at`, `created_at`) VALUES
(7, 1, 1, 1, NULL, '2022-04-19 16:45:29'),
(15, 237, 1, 1, '2022-04-20 12:08:36', '2022-04-20 12:08:36'),
(19, 103, 2, 1, '2022-04-20 13:26:11', '2022-04-20 13:26:11'),
(20, 103, 3, 1, '2022-04-20 13:26:11', '2022-04-20 13:26:11'),
(21, 239, 1, 1, '2022-04-20 12:08:36', '2022-04-20 12:08:36');

-- --------------------------------------------------------

--
-- Table structure for table `gea_currency`
--

CREATE TABLE `gea_currency` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `value` float(8,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gea_currency`
--

INSERT INTO `gea_currency` (`id`, `country_id`, `value`, `description`, `active`, `updated_at`, `created_at`) VALUES
(3, 239, 2.50, 'Test', 1, '2022-04-22 16:09:31', '2022-04-20 18:35:46'),
(4, 2, 60.00, NULL, 1, NULL, '2022-04-20 18:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `gea_product`
--

CREATE TABLE `gea_product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` float(8,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gea_product`
--

INSERT INTO `gea_product` (`id`, `name`, `value`, `description`, `active`, `updated_at`, `created_at`) VALUES
(1, 'Green Energy', 10.25, NULL, 1, '2022-04-21 14:04:27', '2022-04-21 12:24:33');

-- --------------------------------------------------------

--
-- Table structure for table `kyc_request`
--

CREATE TABLE `kyc_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `doc_number` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `kyc_status` varchar(255) NOT NULL,
  `decline_region` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kyc_request`
--

INSERT INTO `kyc_request` (`id`, `user_id`, `country_id`, `doc_id`, `doc_number`, `img`, `description`, `kyc_status`, `decline_region`, `updated_at`, `created_at`) VALUES
(1, 1, 103, 2, 'ABCD4125341', '', 'Test', 'pending', '', '2022-04-20 16:05:32', '2022-04-20 13:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `level_name` varchar(255) NOT NULL,
  `level_no` int(11) NOT NULL,
  `total_token` float NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `terms_conditions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `privacy_policy` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `terms_conditions`, `privacy_policy`) VALUES
(1, '{\"title\":\"Terms & Conditions\",\"content\":\"<p>Website terms and conditions are vital to the long-term success and security of your online business, as they outline the rules by which you and your users must abide. Without terms, you could be subject to abusive users, intellectual property theft, and unnecessary litigation.<\\/p>\\n\\n<p>Our&nbsp;<strong>free terms and conditions template<\\/strong>&nbsp;will help provide your business with the legal protection it deserves.<\\/p>\\n\\n<p>Download our standard template below, or simply copy and paste the text onto your site. Then review each section and edit if needed to reflect your business&rsquo;s needs.<\\/p>\\n\\n<p>Alternatively, keep reading to learn more about what a terms and conditions agreement is and how to start writing your own.<\\/p>\\n\\n<h3><strong>What is a Terms and Conditions Agreement?<\\/strong><\\/h3>\\n\\n<p>A terms and conditions agreement outlines the website administrator&rsquo;s rules regarding user behavior, and provides information about the actions the website administrator can and will perform.<\\/p>\\n\\n<p>Your terms and conditions text is a&nbsp;<strong>contract between your website and its users<\\/strong>. In the event of a legal dispute, arbitrators will look to this agreement to determine whether each party acted within their rights.<\\/p>\\n\",\"status\":\"1\"}', '{\"title\":\"Privacy Policy\",\"content\":\"\",\"status\":\"1\"}');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `amt` float(8,2) NOT NULL,
  `txn_type` varchar(255) NOT NULL,
  `txn_status` varchar(255) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `mode` varchar(255) NOT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `user_id`, `currency`, `amt`, `txn_type`, `txn_status`, `txn_id`, `mode`, `transfer_id`, `message`, `updated_at`, `created_at`) VALUES
(1, 10, 'INR', 100.00, 'cr', 'success', 'test1234', 'credit_card', NULL, 'Money Add', NULL, '2022-04-21 15:14:54'),
(2, 11, 'INR', 150.00, 'cr', 'success', 'test1235', 'credit_card', NULL, 'Money Add', NULL, '2022-04-21 15:14:54'),
(4, 11, 'INR', 250.00, 'cr', 'success', 'test123666', 'credit_card', NULL, 'Money Add', NULL, '2022-04-21 15:14:54'),
(5, 1, 'USD', 500.00, 'cr', 'success', 'test1236667', 'credit_card', NULL, 'Money Add', NULL, '2022-04-21 15:14:54'),
(6, 1, 'USD', 200.00, 'cr', 'success', 'test1236669', 'paypal', NULL, 'Money Add', NULL, '2022-04-21 15:14:54'),
(7, 1, 'USD', 20.00, 'cr', 'success', 'test1236660', 'transfer_receive', 12, 'message From Sender', NULL, '2022-04-21 15:14:54'),
(8, 12, 'USD', 20.00, 'dr', 'success', 'txn234234345', 'transfer_send', 1, 'message To Sender', NULL, '2022-04-21 15:14:54'),
(9, 12, 'USD', 200.00, 'cr', 'success', 'test1236669234', 'paypal', NULL, 'Money Add', NULL, '2022-04-21 15:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `mobile` bigint(20) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `doc_id` int(11) DEFAULT NULL,
  `doc_id_number` varchar(255) DEFAULT NULL,
  `user_active` tinyint(1) NOT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `updated_datetime` timestamp NULL DEFAULT NULL,
  `created_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `mobile`, `country_id`, `email`, `password`, `gender`, `doc_id`, `doc_id_number`, `user_active`, `facebook_id`, `google_id`, `token`, `updated_datetime`, `created_datetime`) VALUES
(1, 'Sagar', 'sc40421', 8287110840, 239, 'sc40421@gmail.com', '771942a6e29839edd655b1a5aeaed33d', 'male', 1, '7612389182372', 1, NULL, NULL, NULL, NULL, '2022-04-13 06:58:40'),
(10, 'Ravinder Choudhary', 'ravic40421', 8287161281, 103, 'ssc40421@gmail.com', '771942a6e29839edd655b1a5aeaed33d', 'male', 3, 'BWGYC6930G', 1, NULL, NULL, NULL, '2022-04-18 06:04:40', '2022-04-15 06:43:47'),
(11, 'aghsd', 'john.test4043', 9746007592, 0, 'johnv.first5434@gmail.com', '771942a6e29839edd655b1a5aeaed33d', 'male', 2, '872348728342', 1, NULL, NULL, NULL, '2022-04-19 11:44:12', '2022-04-15 06:43:47'),
(12, 'TestData', 'David.test40432234', 12654876987, 239, 'david.first00768@gmail.com', '771942a6e29839edd655b1a5aeaed33d', 'male', 1, '1237626763242', 1, NULL, NULL, NULL, '2022-04-19 11:44:12', '2022-04-15 06:43:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `doc_countries`
--
ALTER TABLE `doc_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gea_currency`
--
ALTER TABLE `gea_currency`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `country_id` (`country_id`);

--
-- Indexes for table `gea_product`
--
ALTER TABLE `gea_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `kyc_request`
--
ALTER TABLE `kyc_request`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doc_number` (`doc_number`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `level_no` (`level_no`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `txn_id` (`txn_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `id_number` (`doc_id_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `doc_countries`
--
ALTER TABLE `doc_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `gea_currency`
--
ALTER TABLE `gea_currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gea_product`
--
ALTER TABLE `gea_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kyc_request`
--
ALTER TABLE `kyc_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
