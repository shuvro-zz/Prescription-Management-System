# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.5-10.1.25-MariaDB
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2018-04-13 15:21:59
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for pms
DROP DATABASE IF EXISTS `pms`;
CREATE DATABASE IF NOT EXISTS `pms` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `pms`;


# Dumping structure for table pms.attendees
DROP TABLE IF EXISTS `attendees`;
CREATE TABLE IF NOT EXISTS `attendees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(222) NOT NULL,
  `surname` varchar(222) DEFAULT NULL,
  `dob` varchar(222) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `address_line1` varchar(222) NOT NULL,
  `address_line2` varchar(222) DEFAULT NULL,
  `email` varchar(222) NOT NULL,
  `post_code` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL,
  `attendee_type_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

# Dumping data for table pms.attendees: 9 rows
/*!40000 ALTER TABLE `attendees` DISABLE KEYS */;
REPLACE INTO `attendees` (`id`, `first_name`, `surname`, `dob`, `mobile`, `telephone`, `address_line1`, `address_line2`, `email`, `post_code`, `city`, `state`, `country_id`, `attendee_type_id`, `status`, `created`, `updated`) VALUES
	(1, 'Larry', 'Ullman', '29/09/2017', '234567', '345678', 'Dhaka', 'Uttara', 'larry@gmail.com', '4567', 'Dhaka', 'Dhaka', 240, 3, 1, '2017-08-30 21:48:41', '0000-00-00 00:00:00'),
	(2, 'Mizan', 'BM', '29/08/2017', '34567', '6789', 'Dhaka', 'Dhaka', 'mizan@bitmascot.com', '789', 'Dhaka', 'Dhaka', 16, 3, 1, '2017-08-30 21:48:45', '0000-00-00 00:00:00'),
	(3, 'Larry', 'Ullman', '29/08/2017', '234567', '345678', 'Dhaka', 'Uttara', 'larryy@gmail.com', '4567', 'Dhaka', 'Dhaka', 8, 3, 1, '2017-08-30 15:20:34', '0000-00-00 00:00:00'),
	(17, 'Nandita', NULL, '29/09/2018', '48987', '21325465', 'Test', NULL, 'e2@ft.com', '1213', 'Dhaka', 'Dhaka', 18, 3, 1, '2017-08-30 21:08:38', '0000-00-00 00:00:00'),
	(18, 'Nandita', 'Roy', '29/09/2021', '48987', NULL, 'Test', NULL, 'e5@ft.com', '1216', 'Dhaka', 'Dhaka', 18, 3, 1, '2017-08-30 21:08:38', '0000-00-00 00:00:00'),
	(19, 'Nandita', 'Roy', '29/09/2026', '48987', '21325465', 'Test', NULL, 'e10@ft.com', '1221', 'Dhaka', 'Dhaka', 0, 3, 1, '2017-08-30 21:08:38', '0000-00-00 00:00:00'),
	(20, 'Nandita', 'Roy', '29/09/2027', '48987', '21325465', 'Test', NULL, 'e11@ft.com', '1222', 'Dhaka', 'Dhaka', 18, 3, 1, '2017-08-30 21:48:48', '0000-00-00 00:00:00'),
	(21, 'Nandita', 'Roy', '29/09/2028', '48987', '21325465', 'Test', NULL, 'e12@ft.com', '1223', 'Dhaka', 'Dhaka', 18, 3, 1, '2017-08-30 21:08:38', '0000-00-00 00:00:00'),
	(22, 'test', 'nan', '01/08/2017', '456', '5676', '6uytu', 'tyujtyu', 'pinni.na6ndita@gmail.com', '5466', 'Dhaka', 'Dhaka', 18, 3, 1, '2017-08-30 21:47:33', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `attendees` ENABLE KEYS */;


# Dumping structure for table pms.attendee_types
DROP TABLE IF EXISTS `attendee_types`;
CREATE TABLE IF NOT EXISTS `attendee_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attendee_type` varchar(222) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

# Dumping data for table pms.attendee_types: 1 rows
/*!40000 ALTER TABLE `attendee_types` DISABLE KEYS */;
REPLACE INTO `attendee_types` (`id`, `attendee_type`, `status`, `created`, `updated`) VALUES
	(3, 'Software Engineer', 1, '2017-08-30 15:19:15', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `attendee_types` ENABLE KEYS */;


# Dumping structure for table pms.conferences
DROP TABLE IF EXISTS `conferences`;
CREATE TABLE IF NOT EXISTS `conferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL,
  `slug` varchar(222) NOT NULL,
  `conference_date` int(15) NOT NULL,
  `start_time` varchar(222) NOT NULL,
  `end_time` varchar(222) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

# Dumping data for table pms.conferences: 2 rows
/*!40000 ALTER TABLE `conferences` DISABLE KEYS */;
REPLACE INTO `conferences` (`id`, `name`, `slug`, `conference_date`, `start_time`, `end_time`, `venue_id`, `event_id`, `status`, `created`, `updated`) VALUES
	(6, 'test', 'test', 1503878400, '15:00', '14:00', 4, 6, 1, '2017-08-29 17:21:53', '0000-00-00 00:00:00'),
	(7, 'test2', 'test2', 1503964800, '16:00', '16:00', 3, 6, 1, '2017-08-29 17:22:17', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `conferences` ENABLE KEYS */;


# Dumping structure for table pms.countries
DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `iso_code_2` char(2) NOT NULL DEFAULT '',
  `iso_code_3` char(3) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_countries_name_zen` (`name`),
  KEY `idx_iso_2_zen` (`iso_code_2`),
  KEY `idx_iso_3_zen` (`iso_code_3`)
) ENGINE=MyISAM AUTO_INCREMENT=246 DEFAULT CHARSET=utf8;

# Dumping data for table pms.countries: 243 rows
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
REPLACE INTO `countries` (`id`, `name`, `iso_code_2`, `iso_code_3`) VALUES
	(240, 'Aaland Islands', 'AX', 'ALA'),
	(1, 'Afghanistan', 'AF', 'AFG'),
	(2, 'Albania', 'AL', 'ALB'),
	(3, 'Algeria', 'DZ', 'DZA'),
	(4, 'American Samoa', 'AS', 'ASM'),
	(5, 'Andorra', 'AD', 'AND'),
	(6, 'Angola', 'AO', 'AGO'),
	(7, 'Anguilla', 'AI', 'AIA'),
	(8, 'Antarctica', 'AQ', 'ATA'),
	(9, 'Antigua and Barbuda', 'AG', 'ATG'),
	(10, 'Argentina', 'AR', 'ARG'),
	(11, 'Armenia', 'AM', 'ARM'),
	(12, 'Aruba', 'AW', 'ABW'),
	(13, 'Australia', 'AU', 'AUS'),
	(14, 'Austria', 'AT', 'AUT'),
	(15, 'Azerbaijan', 'AZ', 'AZE'),
	(16, 'Bahamas', 'BS', 'BHS'),
	(17, 'Bahrain', 'BH', 'BHR'),
	(18, 'Bangladesh', 'BD', 'BGD'),
	(19, 'Barbados', 'BB', 'BRB'),
	(20, 'Belarus', 'BY', 'BLR'),
	(21, 'Belgium', 'BE', 'BEL'),
	(22, 'Belize', 'BZ', 'BLZ'),
	(23, 'Benin', 'BJ', 'BEN'),
	(24, 'Bermuda', 'BM', 'BMU'),
	(25, 'Bhutan', 'BT', 'BTN'),
	(26, 'Bolivia', 'BO', 'BOL'),
	(27, 'Bosnia and Herzegowina', 'BA', 'BIH'),
	(28, 'Botswana', 'BW', 'BWA'),
	(29, 'Bouvet Island', 'BV', 'BVT'),
	(30, 'Brazil', 'BR', 'BRA'),
	(31, 'British Indian Ocean Territory', 'IO', 'IOT'),
	(32, 'Brunei Darussalam', 'BN', 'BRN'),
	(33, 'Bulgaria', 'BG', 'BGR'),
	(34, 'Burkina Faso', 'BF', 'BFA'),
	(35, 'Burundi', 'BI', 'BDI'),
	(36, 'Cambodia', 'KH', 'KHM'),
	(37, 'Cameroon', 'CM', 'CMR'),
	(38, 'Canada', 'CA', 'CAN'),
	(39, 'Cape Verde', 'CV', 'CPV'),
	(40, 'Cayman Islands', 'KY', 'CYM'),
	(41, 'Central African Republic', 'CF', 'CAF'),
	(42, 'Chad', 'TD', 'TCD'),
	(43, 'Chile', 'CL', 'CHL'),
	(44, 'China', 'CN', 'CHN'),
	(45, 'Christmas Island', 'CX', 'CXR'),
	(46, 'Cocos (Keeling) Islands', 'CC', 'CCK'),
	(47, 'Colombia', 'CO', 'COL'),
	(48, 'Comoros', 'KM', 'COM'),
	(49, 'Congo', 'CG', 'COG'),
	(50, 'Cook Islands', 'CK', 'COK'),
	(51, 'Costa Rica', 'CR', 'CRI'),
	(52, 'Cote D\'Ivoire', 'CI', 'CIV'),
	(53, 'Croatia', 'HR', 'HRV'),
	(54, 'Cuba', 'CU', 'CUB'),
	(55, 'Cyprus', 'CY', 'CYP'),
	(56, 'Czech Republic', 'CZ', 'CZE'),
	(57, 'Denmark', 'DK', 'DNK'),
	(58, 'Djibouti', 'DJ', 'DJI'),
	(59, 'Dominica', 'DM', 'DMA'),
	(60, 'Dominican Republic', 'DO', 'DOM'),
	(61, 'Timor-Leste', 'TL', 'TLS'),
	(62, 'Ecuador', 'EC', 'ECU'),
	(63, 'Egypt', 'EG', 'EGY'),
	(64, 'El Salvador', 'SV', 'SLV'),
	(65, 'Equatorial Guinea', 'GQ', 'GNQ'),
	(66, 'Eritrea', 'ER', 'ERI'),
	(67, 'Estonia', 'EE', 'EST'),
	(68, 'Ethiopia', 'ET', 'ETH'),
	(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK'),
	(70, 'Faroe Islands', 'FO', 'FRO'),
	(71, 'Fiji', 'FJ', 'FJI'),
	(72, 'Finland', 'FI', 'FIN'),
	(73, 'France', 'FR', 'FRA'),
	(75, 'French Guiana', 'GF', 'GUF'),
	(76, 'French Polynesia', 'PF', 'PYF'),
	(77, 'French Southern Territories', 'TF', 'ATF'),
	(78, 'Gabon', 'GA', 'GAB'),
	(79, 'Gambia', 'GM', 'GMB'),
	(80, 'Georgia', 'GE', 'GEO'),
	(81, 'Germany', 'DE', 'DEU'),
	(82, 'Ghana', 'GH', 'GHA'),
	(83, 'Gibraltar', 'GI', 'GIB'),
	(84, 'Greece', 'GR', 'GRC'),
	(85, 'Greenland', 'GL', 'GRL'),
	(86, 'Grenada', 'GD', 'GRD'),
	(87, 'Guadeloupe', 'GP', 'GLP'),
	(88, 'Guam', 'GU', 'GUM'),
	(89, 'Guatemala', 'GT', 'GTM'),
	(90, 'Guinea', 'GN', 'GIN'),
	(91, 'Guinea-bissau', 'GW', 'GNB'),
	(92, 'Guyana', 'GY', 'GUY'),
	(93, 'Haiti', 'HT', 'HTI'),
	(94, 'Heard and Mc Donald Islands', 'HM', 'HMD'),
	(95, 'Honduras', 'HN', 'HND'),
	(96, 'Hong Kong', 'HK', 'HKG'),
	(97, 'Hungary', 'HU', 'HUN'),
	(98, 'Iceland', 'IS', 'ISL'),
	(99, 'India', 'IN', 'IND'),
	(100, 'Indonesia', 'ID', 'IDN'),
	(101, 'Iran (Islamic Republic of)', 'IR', 'IRN'),
	(102, 'Iraq', 'IQ', 'IRQ'),
	(103, 'Ireland', 'IE', 'IRL'),
	(104, 'Israel', 'IL', 'ISR'),
	(105, 'Italy', 'IT', 'ITA'),
	(106, 'Jamaica', 'JM', 'JAM'),
	(107, 'Japan', 'JP', 'JPN'),
	(108, 'Jordan', 'JO', 'JOR'),
	(109, 'Kazakhstan', 'KZ', 'KAZ'),
	(110, 'Kenya', 'KE', 'KEN'),
	(111, 'Kiribati', 'KI', 'KIR'),
	(112, 'Korea, Democratic People\'s Republic of', 'KP', 'PRK'),
	(113, 'Korea, Republic of', 'KR', 'KOR'),
	(114, 'Kuwait', 'KW', 'KWT'),
	(115, 'Kyrgyzstan', 'KG', 'KGZ'),
	(116, 'Lao People\'s Democratic Republic', 'LA', 'LAO'),
	(117, 'Latvia', 'LV', 'LVA'),
	(118, 'Lebanon', 'LB', 'LBN'),
	(119, 'Lesotho', 'LS', 'LSO'),
	(120, 'Liberia', 'LR', 'LBR'),
	(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY'),
	(122, 'Liechtenstein', 'LI', 'LIE'),
	(123, 'Lithuania', 'LT', 'LTU'),
	(124, 'Luxembourg', 'LU', 'LUX'),
	(125, 'Macao', 'MO', 'MAC'),
	(126, 'Macedonia, The Former Yugoslav Republic of', 'MK', 'MKD'),
	(127, 'Madagascar', 'MG', 'MDG'),
	(128, 'Malawi', 'MW', 'MWI'),
	(129, 'Malaysia', 'MY', 'MYS'),
	(130, 'Maldives', 'MV', 'MDV'),
	(131, 'Mali', 'ML', 'MLI'),
	(132, 'Malta', 'MT', 'MLT'),
	(133, 'Marshall Islands', 'MH', 'MHL'),
	(134, 'Martinique', 'MQ', 'MTQ'),
	(135, 'Mauritania', 'MR', 'MRT'),
	(136, 'Mauritius', 'MU', 'MUS'),
	(137, 'Mayotte', 'YT', 'MYT'),
	(138, 'Mexico', 'MX', 'MEX'),
	(139, 'Micronesia, Federated States of', 'FM', 'FSM'),
	(140, 'Moldova', 'MD', 'MDA'),
	(141, 'Monaco', 'MC', 'MCO'),
	(142, 'Mongolia', 'MN', 'MNG'),
	(143, 'Montserrat', 'MS', 'MSR'),
	(144, 'Morocco', 'MA', 'MAR'),
	(145, 'Mozambique', 'MZ', 'MOZ'),
	(146, 'Myanmar', 'MM', 'MMR'),
	(147, 'Namibia', 'NA', 'NAM'),
	(148, 'Nauru', 'NR', 'NRU'),
	(149, 'Nepal', 'NP', 'NPL'),
	(150, 'Netherlands', 'NL', 'NLD'),
	(151, 'Netherlands Antilles', 'AN', 'ANT'),
	(152, 'New Caledonia', 'NC', 'NCL'),
	(153, 'New Zealand', 'NZ', 'NZL'),
	(154, 'Nicaragua', 'NI', 'NIC'),
	(155, 'Niger', 'NE', 'NER'),
	(156, 'Nigeria', 'NG', 'NGA'),
	(157, 'Niue', 'NU', 'NIU'),
	(158, 'Norfolk Island', 'NF', 'NFK'),
	(159, 'Northern Mariana Islands', 'MP', 'MNP'),
	(160, 'Norway', 'NO', 'NOR'),
	(161, 'Oman', 'OM', 'OMN'),
	(162, 'Pakistan', 'PK', 'PAK'),
	(163, 'Palau', 'PW', 'PLW'),
	(164, 'Panama', 'PA', 'PAN'),
	(165, 'Papua New Guinea', 'PG', 'PNG'),
	(166, 'Paraguay', 'PY', 'PRY'),
	(167, 'Peru', 'PE', 'PER'),
	(168, 'Philippines', 'PH', 'PHL'),
	(169, 'Pitcairn', 'PN', 'PCN'),
	(170, 'Poland', 'PL', 'POL'),
	(171, 'Portugal', 'PT', 'PRT'),
	(172, 'Puerto Rico', 'PR', 'PRI'),
	(173, 'Qatar', 'QA', 'QAT'),
	(174, 'Reunion', 'RE', 'REU'),
	(175, 'Romania', 'RO', 'ROU'),
	(176, 'Russian Federation', 'RU', 'RUS'),
	(177, 'Rwanda', 'RW', 'RWA'),
	(178, 'Saint Kitts and Nevis', 'KN', 'KNA'),
	(179, 'Saint Lucia', 'LC', 'LCA'),
	(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT'),
	(181, 'Samoa', 'WS', 'WSM'),
	(182, 'San Marino', 'SM', 'SMR'),
	(183, 'Sao Tome and Principe', 'ST', 'STP'),
	(184, 'Saudi Arabia', 'SA', 'SAU'),
	(185, 'Senegal', 'SN', 'SEN'),
	(186, 'Seychelles', 'SC', 'SYC'),
	(187, 'Sierra Leone', 'SL', 'SLE'),
	(188, 'Singapore', 'SG', 'SGP'),
	(189, 'Slovakia (Slovak Republic)', 'SK', 'SVK'),
	(190, 'Slovenia', 'SI', 'SVN'),
	(191, 'Solomon Islands', 'SB', 'SLB'),
	(192, 'Somalia', 'SO', 'SOM'),
	(193, 'South Africa', 'ZA', 'ZAF'),
	(194, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS'),
	(195, 'Spain', 'ES', 'ESP'),
	(196, 'Sri Lanka', 'LK', 'LKA'),
	(197, 'St. Helena', 'SH', 'SHN'),
	(198, 'St. Pierre and Miquelon', 'PM', 'SPM'),
	(199, 'Sudan', 'SD', 'SDN'),
	(200, 'Suriname', 'SR', 'SUR'),
	(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM'),
	(202, 'Swaziland', 'SZ', 'SWZ'),
	(203, 'Sweden', 'SE', 'SWE'),
	(204, 'Switzerland', 'CH', 'CHE'),
	(205, 'Syrian Arab Republic', 'SY', 'SYR'),
	(206, 'Taiwan', 'TW', 'TWN'),
	(207, 'Tajikistan', 'TJ', 'TJK'),
	(208, 'Tanzania, United Republic of', 'TZ', 'TZA'),
	(209, 'Thailand', 'TH', 'THA'),
	(210, 'Togo', 'TG', 'TGO'),
	(211, 'Tokelau', 'TK', 'TKL'),
	(212, 'Tonga', 'TO', 'TON'),
	(213, 'Trinidad and Tobago', 'TT', 'TTO'),
	(214, 'Tunisia', 'TN', 'TUN'),
	(215, 'Turkey', 'TR', 'TUR'),
	(216, 'Turkmenistan', 'TM', 'TKM'),
	(217, 'Turks and Caicos Islands', 'TC', 'TCA'),
	(218, 'Tuvalu', 'TV', 'TUV'),
	(219, 'Uganda', 'UG', 'UGA'),
	(220, 'Ukraine', 'UA', 'UKR'),
	(221, 'United Arab Emirates', 'AE', 'ARE'),
	(222, 'United Kingdom', 'GB', 'GBR'),
	(223, 'United States', 'US', 'USA'),
	(224, 'United States Minor Outlying Islands', 'UM', 'UMI'),
	(225, 'Uruguay', 'UY', 'URY'),
	(226, 'Uzbekistan', 'UZ', 'UZB'),
	(227, 'Vanuatu', 'VU', 'VUT'),
	(228, 'Vatican City State (Holy See)', 'VA', 'VAT'),
	(229, 'Venezuela', 'VE', 'VEN'),
	(230, 'Viet Nam', 'VN', 'VNM'),
	(231, 'Virgin Islands (British)', 'VG', 'VGB'),
	(232, 'Virgin Islands (U.S.)', 'VI', 'VIR'),
	(233, 'Wallis and Futuna Islands', 'WF', 'WLF'),
	(234, 'Western Sahara', 'EH', 'ESH'),
	(235, 'Yemen', 'YE', 'YEM'),
	(236, 'Serbia', 'RS', 'SRB'),
	(238, 'Zambia', 'ZM', 'ZMB'),
	(239, 'Zimbabwe', 'ZW', 'ZWE'),
	(241, 'Palestinian Territory', 'PS', 'PSE'),
	(242, 'Montenegro', 'ME', 'MNE'),
	(243, 'Guernsey', 'GG', 'GGY'),
	(244, 'Isle of Man', 'IM', 'IMN'),
	(245, 'Jersey', 'JE', 'JEY');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;


# Dumping structure for table pms.diagnosis
DROP TABLE IF EXISTS `diagnosis`;
CREATE TABLE IF NOT EXISTS `diagnosis` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(10) NOT NULL DEFAULT '0',
  `diagnosis_list_id` int(10) NOT NULL,
  `instructions` text,
  `status` tinyint(1) DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

# Dumping data for table pms.diagnosis: ~3 rows (approximately)
/*!40000 ALTER TABLE `diagnosis` DISABLE KEYS */;
REPLACE INTO `diagnosis` (`id`, `doctor_id`, `diagnosis_list_id`, `instructions`, `status`, `created`, `updated`) VALUES
	(15, 101, 1, 'instructions goes here1', 1, '2018-04-12 13:53:33', '0000-00-00 00:00:00'),
	(16, 101, 4, 'instructions goes here1', 1, '2018-04-12 14:20:50', '0000-00-00 00:00:00'),
	(20, 101, 3, 'instructions goes here1  instructions goes here instructions goes here instructions goes here', 1, '2018-04-12 23:09:18', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `diagnosis` ENABLE KEYS */;


# Dumping structure for table pms.diagnosis_lists
DROP TABLE IF EXISTS `diagnosis_lists`;
CREATE TABLE IF NOT EXISTS `diagnosis_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

# Dumping data for table pms.diagnosis_lists: ~4 rows (approximately)
/*!40000 ALTER TABLE `diagnosis_lists` DISABLE KEYS */;
REPLACE INTO `diagnosis_lists` (`id`, `name`, `status`, `created`) VALUES
	(1, 'fevar', 1, '2018-04-11 19:35:41'),
	(3, 'taifoed', 1, '2018-04-11 19:38:10'),
	(4, 'alcher', 1, '2018-04-11 20:34:06'),
	(6, 'cancer', 1, '2018-04-13 11:44:40');
/*!40000 ALTER TABLE `diagnosis_lists` ENABLE KEYS */;


# Dumping structure for table pms.diagnosis_medicines
DROP TABLE IF EXISTS `diagnosis_medicines`;
CREATE TABLE IF NOT EXISTS `diagnosis_medicines` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `medicine_id` int(10) NOT NULL,
  `diagnosis_id` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

# Dumping data for table pms.diagnosis_medicines: ~9 rows (approximately)
/*!40000 ALTER TABLE `diagnosis_medicines` DISABLE KEYS */;
REPLACE INTO `diagnosis_medicines` (`id`, `medicine_id`, `diagnosis_id`, `status`, `created`, `updated`) VALUES
	(3, 4, 1, 1, '2018-04-12 13:36:48', '0000-00-00 00:00:00'),
	(4, 13, 1, 1, '2018-04-12 13:36:50', '0000-00-00 00:00:00'),
	(9, 15, 3, 1, '2018-02-17 19:25:05', '0000-00-00 00:00:00'),
	(10, 16, 3, 1, '2018-02-17 19:25:05', '0000-00-00 00:00:00'),
	(21, 2, 10, 1, '2018-04-11 20:00:30', '0000-00-00 00:00:00'),
	(22, 6, 10, 1, '2018-04-11 20:00:30', '0000-00-00 00:00:00'),
	(28, 2, 15, 1, '2018-04-12 13:53:33', '0000-00-00 00:00:00'),
	(29, 121, 15, 1, '2018-04-12 13:53:33', '0000-00-00 00:00:00'),
	(30, 139, 16, 1, '2018-04-12 14:20:51', '0000-00-00 00:00:00'),
	(31, 225, 16, 1, '2018-04-12 14:20:51', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `diagnosis_medicines` ENABLE KEYS */;


# Dumping structure for table pms.diagnosis_tests
DROP TABLE IF EXISTS `diagnosis_tests`;
CREATE TABLE IF NOT EXISTS `diagnosis_tests` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `test_id` int(10) NOT NULL,
  `diagnosis_id` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

# Dumping data for table pms.diagnosis_tests: ~9 rows (approximately)
/*!40000 ALTER TABLE `diagnosis_tests` DISABLE KEYS */;
REPLACE INTO `diagnosis_tests` (`id`, `test_id`, `diagnosis_id`, `status`, `created`, `updated`) VALUES
	(2, 4, 2, 1, '2018-02-15 17:07:54', '0000-00-00 00:00:00'),
	(3, 7, 2, 1, '2018-02-15 17:07:54', '0000-00-00 00:00:00'),
	(4, 11, 2, 1, '2018-02-15 17:07:54', '0000-00-00 00:00:00'),
	(6, 11, 3, 1, '2018-02-16 14:20:17', '0000-00-00 00:00:00'),
	(9, 9, 3, 1, '2018-02-17 19:25:05', '0000-00-00 00:00:00'),
	(19, 6, 10, 1, '2018-04-11 20:00:30', '0000-00-00 00:00:00'),
	(20, 11, 10, 1, '2018-04-11 20:00:30', '0000-00-00 00:00:00'),
	(26, 4, 15, 1, '2018-04-12 13:53:33', '0000-00-00 00:00:00'),
	(27, 10, 16, 1, '2018-04-12 14:20:51', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `diagnosis_tests` ENABLE KEYS */;


# Dumping structure for table pms.events
DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL DEFAULT '0',
  `slug` varchar(222) NOT NULL DEFAULT '0',
  `start_date` int(15) NOT NULL,
  `end_date` int(15) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

# Dumping data for table pms.events: 3 rows
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
REPLACE INTO `events` (`id`, `name`, `slug`, `start_date`, `end_date`, `status`, `created`, `updated`) VALUES
	(6, 'test', 'test', 0, 0, 1, '2017-08-28 19:31:04', '0000-00-00 00:00:00'),
	(13, 'test1', 'test1', 1503878400, 1503964800, 1, '2017-08-29 17:19:26', '0000-00-00 00:00:00'),
	(15, 'test4', 'test4', 1515542400, 1516924800, 1, '2018-01-10 00:13:55', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;


# Dumping structure for table pms.medicines
DROP TABLE IF EXISTS `medicines`;
CREATE TABLE IF NOT EXISTS `medicines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=462 DEFAULT CHARSET=latin1;

# Dumping data for table pms.medicines: ~442 rows (approximately)
/*!40000 ALTER TABLE `medicines` DISABLE KEYS */;
REPLACE INTO `medicines` (`id`, `name`, `status`, `created`, `updated`) VALUES
	(1, 'Avlosef 250 Capsule', 1, '2018-04-01 05:38:11', '0000-00-00 00:00:00'),
	(2, 'Avlosef 500 Capsule', 1, '2018-04-01 05:38:11', '0000-00-00 00:00:00'),
	(3, 'Avlosef Dry Syrup', 1, '2018-04-01 05:38:11', '0000-00-00 00:00:00'),
	(4, 'Avlosef DS Dry Syrup', 1, '2018-04-01 05:38:11', '0000-00-00 00:00:00'),
	(5, 'Avlosef Paediatric Drop', 1, '2018-04-01 05:38:11', '0000-00-00 00:00:00'),
	(6, 'Avlosef 500 Injection IV/ IM', 1, '2018-04-01 05:38:11', '0000-00-00 00:00:00'),
	(7, 'Avlosef Injection IV/IM 1 g', 1, '2018-04-01 05:38:11', '0000-00-00 00:00:00'),
	(8, 'Avlotrin Tablet', 1, '2018-04-01 05:38:11', '0000-00-00 00:00:00'),
	(9, 'Avlotrin DS Tablet', 1, '2018-04-01 05:38:11', '0000-00-00 00:00:00'),
	(10, 'Avlotrin Suspension', 1, '2018-04-01 05:38:11', '0000-00-00 00:00:00'),
	(11, 'Avloxin 250 Capsule', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(12, 'Avloxin 500 Capsule', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(13, 'Avloxin Dry Syrup', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(14, 'Cedril Capsule', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(15, 'Cedril Powder for Suspension', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(16, 'Cefdox 100 Capsule', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(17, 'Cefdox 200 F/C Tablet', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(18, 'Cefdox Powder for Suspension', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(19, 'Cefdox DS Powder for Suspension', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(20, 'Cefdox Paediatric Drop', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(21, 'Cefim-3 200 Capsule', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(22, 'Ceffim-3 DS 400 Capsule', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(23, 'Cefim-3 Dry Syrup', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(24, 'Cerox-A 125 Tablet', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(25, 'Cerox-A 250 Tablet', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(26, 'Cerox-A 500 Tablet', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(27, 'Cerox-A 250 mg IM/ IV Injection', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(28, 'Cerox-A 750 mg IM/ IV Injection', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(29, 'Cerox-A Powder for Suspension', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(30, 'Erythin Tablet', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(31, 'Erythin Powder for Suspension', 1, '2018-04-01 05:38:12', '0000-00-00 00:00:00'),
	(32, 'Erythin Powder for P/Drop', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(33, 'Ezolid 400 Tablet', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(34, 'Ezolid 600 Tablet', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(35, 'Floxabid 250 Tablet', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(36, 'Floxabid 500 Tablet', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(37, 'Floxabid 750 F/C Tablet', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(38, 'Floxabid SR Tablet', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(39, 'Floxabid DS Powder for Suspension', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(40, 'Floxabid DS Pellets for Suspension', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(41, 'Fluclox 250 Capsule', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(42, 'Fluclox 500 Capsule', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(43, 'Fluclox Powder for Suspension', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(44, 'Fluclox DS Powder for Suspension', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(45, 'Fluclox 250 Injection', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(46, 'Fluclox 500 Injection', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(47, 'Foxitane 1 g Injection', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(48, 'Foxitane 2 g Injection', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(49, 'Gatilon 200 Tablet', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(50, 'Gatilon 400 Tablet', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(51, 'Iminem Powder for Injection', 1, '2018-04-01 05:38:13', '0000-00-00 00:00:00'),
	(52, 'Impedox Capsule', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(53, 'Impetet 250 Capsule', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(54, 'Kacin 100 Injection', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(55, 'Kacin 500 Injection', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(56, 'Leflox 500 Tablet', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(57, 'Leflox 750 Tablet', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(58, 'Mt-3 Tablet', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(59, 'Odazyth 250 Capsule', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(60, 'Odazyth 500 Tablet', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(61, 'Odazyth IV Dry Powder for Injection', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(62, 'Odazyth Dry Syrup', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(63, 'Omeflox Tablet', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(64, 'Pandeflu Capsule', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(65, 'Pime-4 500 mg IV/IM Injection', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(66, 'Pime-4 1 g IV/IM Injection', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(67, 'Pime-4 2 g IV Injection', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(68, 'Pirom 1 Injection', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(69, 'Pirom 2 Injection', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(70, 'Teviral 0.5 F/C Tablet', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(71, 'Teviral 1 F/C Tablet', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(72, 'Water for Injection', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(73, 'Zitum 250 mg Injection', 1, '2018-04-01 05:38:14', '0000-00-00 00:00:00'),
	(74, 'Zitum 500 mg Injection', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(75, 'Zitum 1g Injection', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(76, 'Avlocid Tablet', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(77, 'Avlocid Liquid', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(78, 'Esomep 20 Tablet', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(79, 'Esomep 40 Tablet', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(80, 'Lanz 15 Capsule', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(81, 'Lanz 30 Capsule', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(82, 'Locid Tablet', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(83, 'Novatac 20 Tablet', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(84, 'Novatac 40 Tablet', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(85, 'Pantex 20 Capsule', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(86, 'Pantex 40 Capsule', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(87, 'Pantex 20 Tablet', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(88, 'Pantex 40 Tablet', 1, '2018-04-01 05:38:15', '0000-00-00 00:00:00'),
	(89, 'Paricel Tablet', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(90, 'Xantid Tablet', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(91, 'Xantid-HS Tablet', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(92, 'Xantid Injection', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(93, 'Xeldrin 10 Capsule', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(94, 'Xeldrin 20 Capsule', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(95, 'Xeldrin 40 Capsule', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(96, 'Xeldrin 20 Tablet', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(97, 'Xeldrin 40 Dry Powder for Injection', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(98, 'Acira Tablet', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(99, 'Acira Syrup', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(100, 'Acitrin Tablet', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(101, 'Acitrin Syrup', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(102, 'Alaron Tablet', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(103, 'Brodil 2 Tablet', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(104, 'Brodil 4 Tablet', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(105, 'Brodil SR Capsule', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(106, 'Brodil Syrup', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(107, 'Brodil Levo 1 Tablet', 1, '2018-04-01 05:38:16', '0000-00-00 00:00:00'),
	(108, 'Brodil Levo 2 Tablet', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(109, 'Brodil Levo Syrup', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(110, 'Buterol 10 Tablet', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(111, 'Buterol 20 Tablet', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(112, 'Buterol Syrup', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(113, 'Castin Capsule', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(114, 'Castin Syrup', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(115, 'Castin DS Syrup', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(116, 'Coderin 5 Tablet', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(117, 'Coderin 10 Tablet', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(118, 'Deslorin Tablet', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(119, 'Deslorin Syrup', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(120, 'Deslorin Plus 2.5 ER Tablet', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(121, 'Deslorin Plus 5 ER Tablet', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(122, 'Didra Syrup', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(123, 'Dixxar Syrup', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(124, 'Hytarax 10 F/C Tablet', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(125, 'Hytarax 25 F/C Tablet', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(126, 'Hytarax Syrup', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(127, 'Mastel MR Tablet', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(128, 'Myrox SR Capsule', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(129, 'Myrox Syrup', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(130, 'Myrox Paediatric Drop', 1, '2018-04-01 05:38:17', '0000-00-00 00:00:00'),
	(131, 'Pevil Tablet', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(132, 'Progic Tablet', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(133, 'Progic Elixir', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(134, 'Prosma Tablet', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(135, 'Prosma Syrup', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(136, 'Pyrimac Tablet', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(137, 'Reversair Tablet', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(138, 'Reversair 4 Orodispersible Tablet', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(139, 'Reversair 5 Orodispersible Tablet', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(140, 'Tyrex Syrup', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(141, 'Teolex 300 CR Capsule', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(142, 'Teolex 400 CR Tablet', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(143, 'Acicox Capsule', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(144, 'Acron Tablet', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(145, 'Anaflex 250 Tablet', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(146, 'Anaflex 500 Tablet', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(147, 'Anaflex Gel', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(148, 'Anaflex SR Tablet', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(149, 'Anaflex 250 Suppository', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(150, 'Anaflex 500 Suppository', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(151, 'Anaflex Suspension', 1, '2018-04-01 05:38:18', '0000-00-00 00:00:00'),
	(152, 'Celofen Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(153, 'Coxia 60 Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(154, 'Coxia 90 Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(155, 'Coxia 120 Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(156, 'Demarin Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(157, 'Dexcor Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(158, 'Dexcor Injection', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(159, 'Flamex 200 Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(160, 'Flamex 400 Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(161, 'Flamex Suspension', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(162, 'Flamex DX 200 Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(163, 'Flamex DX 300 Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(164, 'Flamex DX 400 Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(165, 'Hison Injection', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(166, 'Ketron Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(167, 'Ketron 100 SR Capsule', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(168, 'Ketron 200 SR Capsule', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(169, 'Ketron-D F/C Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(170, 'Minolac Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(171, 'Minolac Injection', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(172, 'Mobifen 25 Tablet', 1, '2018-04-01 05:38:19', '0000-00-00 00:00:00'),
	(173, 'Mobifen 50 Tablet', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(174, 'Mobifen 12.5 Suppository', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(175, 'Mobifen 50 Suppository', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(176, 'Mobifen SR Capsule', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(177, 'Mobifen Plus Injection', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(178, 'Motoral 20 Tablet', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(179, 'Motoral 100 Tablet', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(180, 'Oxicam Tablet', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(181, 'Solone 5 Tablet', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(182, 'Solone 20 Tablet', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(183, 'Tendia Capsule', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(184, 'Tendia Injection', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(185, 'Valiflex 10 Tablet', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(186, 'Valiflex 20 Tablet', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(187, 'Viscon 15 Cream', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(188, 'Viscon 30 Cream', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(189, 'Xcel Tablet', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(190, 'Xcel Dispersible Tablet', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(191, 'Xcel Paediatric Drop', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(192, 'Xcel Suspension', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(193, 'Xcel 125 Suppository', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(194, 'Xcel 250 Suppository', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(195, 'Xcel Plus Tablet', 1, '2018-04-01 05:38:20', '0000-00-00 00:00:00'),
	(196, 'Abetis 20 Tablet', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(197, 'Abetis 40 Tablet', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(198, 'Aciprin CV Tablet', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(199, 'Anaxyl 250 Capsule', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(200, 'Anaxyl 500 Capsule', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(201, 'Anaxyl 5 Injection', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(202, 'Anaxyl 10 Injection', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(203, 'Bipinor Tablet', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(204, 'Bisomet Tablet', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(205, 'Cab 5 Tablet', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(206, 'Cab 10 Tablet', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(207, 'Cacetor 10/2.5 Capsule', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(208, 'Cacetor 10/5 Capsule', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(209, 'Cacetor 20/5 Capsule', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(210, 'Canider Tablet', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(211, 'Dobumin Injection', 1, '2018-04-01 05:38:21', '0000-00-00 00:00:00'),
	(212, 'Indever 10 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(213, 'Indever 40 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(214, 'Indever SR 40 Capsule', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(215, 'Indever SR 80 Capsule', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(216, 'Isart Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(217, 'Kaltide Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(218, 'Karvedil 6.25 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(219, 'Karvedil 12.5 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(220, 'Karvedil 25 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(221, 'Moniten Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(222, 'Pactorin Retard Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(223, 'Rosatan-25 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(224, 'Rosatan-50 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(225, 'Rosatan-H 25 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(226, 'Rosatan-H 50 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(227, 'Stril 5 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(228, 'Stril 10 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(229, 'Tenocab 25 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(230, 'Tenocab 50 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(231, 'Tenoren 25 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(232, 'Tenoren 50 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(233, 'Tenoren 100 Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(234, 'Tenoren Plus Tablet', 1, '2018-04-01 05:38:22', '0000-00-00 00:00:00'),
	(235, 'Telopin SR Capsule', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(236, 'Canazole 50 Tablet', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(237, 'Canazole 150 Tablet', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(238, 'Canazole Suspension', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(239, 'Clovate Cream', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(240, 'Clovate Ointment', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(241, 'Clovate N Ointment', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(242, 'Clovate N Cream', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(243, 'Dermasim 1% Cream', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(244, 'Dermasim 1% Solution', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(245, 'Ecoren Cream', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(246, 'Ecoren T Cream', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(247, 'Fulcinex Tablet', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(248, 'Fulcinex Suspension', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(249, 'Miconex Cream', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(250, 'Micoral Oral Gel', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(251, 'Micosone Cream', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(252, 'Micosone Ointment', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(253, 'Neocitrin Powder', 1, '2018-04-01 05:38:23', '0000-00-00 00:00:00'),
	(254, 'Nyscan Paediatric Drop', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(255, 'Permisol Cream', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(256, 'Progil Tablet', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(257, 'Skinabin Tablet', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(258, 'Skinabin Cream', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(259, 'Skinalar Cream', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(260, 'Skinalar Ointment', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(261, 'Skinalar-N Cream', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(262, 'Skinalar-N Ointment', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(263, 'Tapicin Cream', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(264, 'Tetrasol Solution', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(265, 'Trena Gel', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(266, 'Zinoxy Ointment', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(267, 'Zocort Cream', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(268, 'Calbic Effervescent Tablet', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(269, 'Carbofol-Z Capsule', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(270, 'Cartine Oral Solution', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(271, 'Dispazinc', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(272, 'Feridex+ Capsule', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(273, 'Femizin TR Capsule', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(274, 'Feridex Syrup', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(275, 'Feridex TR Capsule', 1, '2018-04-01 05:38:24', '0000-00-00 00:00:00'),
	(276, 'Hepta Seas Syrup', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(277, 'Livita Syrup', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(278, 'Mylovit Capsule', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(279, 'Mylovit-Z Capsule', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(280, 'Oral ZF Tablet', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(281, 'Tonadin 0.2 Injection', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(282, 'Tonadin 1 Injection', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(283, 'Tioxil Capsule', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(284, 'Acical Tablet', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(285, 'Acical-D Tablet', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(286, 'Acical-M Tablet', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(287, 'Caloren IV Injection', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(288, 'Nutrivit-B Tablet', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(289, 'Nutrivit-B Syrup', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(290, 'Nutrivit-C Tablet', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(291, 'Nutrivit-C Syrup', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(292, 'Nutrivit-C Paediatric Drop', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(293, 'Nutrivit-E Tablet', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(294, 'Nutrivit-MV Paediatric Drop', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(295, 'Oral-Z Tablet', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(296, 'Oral-Z Syrup', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(297, 'Oral ZB Syrup', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(298, 'Phyton Tablet', 1, '2018-04-01 05:38:25', '0000-00-00 00:00:00'),
	(299, 'Phyton Injection', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(300, 'Polyron Syrup', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(301, 'Polyron Plus Capsule', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(302, 'Polyron Plus Syrup', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(303, 'Povital Tablet', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(304, 'Povital Injection', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(305, 'Revigor Tablet', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(306, 'Revital 32 Tablet', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(307, 'Revital 30 F/C Tablet', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(308, 'Tasti Tablet', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(309, 'Tivit Tablet', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(310, 'Amotrex 200 Tablet', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(311, 'Amotrex 400 Tablet', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(312, 'Amotrex DS Tablet', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(313, 'Amotrex Suspension', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(314, 'Avloquin Tablet', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(315, 'Avloquin Syrup', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(316, 'Diar Tablet', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(317, 'Diar Powder for Suspension', 1, '2018-04-01 05:38:26', '0000-00-00 00:00:00'),
	(318, 'Dicarmin Tablet', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(319, 'Etrax Tablet', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(320, 'Etrax Syrup', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(321, 'Meflon Tablet', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(322, 'Meflon Plus Tablet', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(323, 'Sezol- DS Tablet', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(324, 'Sintel 200 Tablet', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(325, 'Sintel 400 Tablet', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(326, 'Sintel Suspension', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(327, 'Hexiscrub Solution', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(328, 'Hexisol Hand Rub', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(329, 'Hexitane Obs. Cream', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(330, 'Oralon Dental Gel', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(331, 'Oralon Solution', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(332, 'Septex Cream', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(333, 'Septex Liquid', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(334, 'Septex Hospital Concentrate', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(335, 'Acuten tablet', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(336, 'Acuten Injection', 1, '2018-04-01 05:38:27', '0000-00-00 00:00:00'),
	(337, 'Adelax Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(338, 'Chear 25 Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(339, 'Chear 50 Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(340, 'Clonium 0.5 Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(341, 'Clonium 2 Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(342, 'Clonium Paediatric Drop', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(343, 'Cardopa Injection', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(344, 'Gabarol 75mg Capsule', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(345, 'Gabarol 100mg Capsule', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(346, 'Gabarol 150mg Capsule', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(347, 'Fluver 5 Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(348, 'Fluver 10 Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(349, 'Hypnoclone Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(350, 'Memopil 800 Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(351, 'Memopil 1200 Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(352, 'Memopil Injection', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(353, 'Nortyl 10 Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(354, 'Nortyle 25 Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(355, 'Sedazam Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(356, 'Stignal Injection', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(357, 'Xytrex Tablet', 1, '2018-04-01 05:38:28', '0000-00-00 00:00:00'),
	(358, 'Zepam Tablet', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(359, 'Acicot Eye/Ear Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(360, 'Atier Eye Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(361, 'Betan Eye, Ear, Nose Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(362, 'Denicol Eye Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(363, 'Floxabid Eye Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(364, 'Icol Eye/Ear Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(365, 'Icrom Eye Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(366, 'Igen Eye Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(367, 'Lotensin 0.25 Eye Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(368, 'Lotensin 0.5 Eye Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(369, 'Maxiflox Eye Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(370, 'Mobifen Eye Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(371, 'Omeflox Eye Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(372, 'Prosma Eye Drop', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(373, 'Colik 10 Tablet', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(374, 'Colik 20 Tablet', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(375, 'Colik Injection', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(376, 'Drovin 40 Tablet', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(377, 'Drovin Injection', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(378, 'Diverin 10 Tablet', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(379, 'Diverin 20 Tablet', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(380, 'Diverin Syrup', 1, '2018-04-01 05:38:29', '0000-00-00 00:00:00'),
	(381, 'Meba Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(382, 'Tynium Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(383, 'Tynium Injection', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(384, 'Tegod Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(385, 'Vave Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(386, 'Vave Paediatric Drop', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(387, 'Vave Suspension', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(388, 'Osetron Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(389, 'Osetron Injection', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(390, 'Diatag 15 Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(391, 'Diatag 30 Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(392, 'Diatag 45 Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(393, 'Diatag Plus 2 F/C Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(394, 'Diatag Plus 4 F/C Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(395, 'Glimirid 1 Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(396, 'Glimirid 2 Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(397, 'Lozide Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(398, 'Metform Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(399, 'Metform 850 Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(400, 'Metform ER Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(401, 'Politor 500 Tablet', 1, '2018-04-01 05:38:30', '0000-00-00 00:00:00'),
	(402, 'Politor 850 Tablet', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(403, 'Roglim 1 Tablet', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(404, 'Roglim 2 Tablet', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(405, 'Rotamin 2 Tablet', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(406, 'Rotamin 2 DS Tablet', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(407, 'Rotamin 4 Tablet', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(408, 'Rotamin 4 DS Tablet', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(409, 'Halosin Solution', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(410, 'Lidocaine Solution for Injection', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(411, 'Lidogel Jelly', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(412, 'Pentyl Injection', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(413, 'Pivacaine 0.25 Injection', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(414, 'Pivacaine 0.5 Injection', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(415, 'Pivacaine-D Injection', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(416, 'Thiopen 0.5 Powder for Injection', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(417, 'Thiopen 1 Powder for Injection', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(418, 'Xylone 1% Injection', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(419, 'Xylone 2% Injection', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(420, 'Xylone 4% Injection', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(421, 'Xylone Jelly', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(422, 'Brodil', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(423, 'Brodil HFA', 1, '2018-04-01 05:38:31', '0000-00-00 00:00:00'),
	(424, 'Brodil Levo', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(425, 'Brodil Levo HFA', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(426, 'Seroxyn 25/250', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(427, 'Seroxyn 25/125', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(428, 'Seroxyn 25/50', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(429, 'Steradin 250 HFA', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(430, 'Steradin 100 HFA', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(431, 'Steradin 50 HFA', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(432, 'Cismatica 160', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(433, 'Cismatica 80', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(434, 'Ropidil', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(435, 'Alvairy', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(436, 'Alen-D Tablet', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(437, 'Cartilex F/C Tablet', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(438, 'Glupain Tablet', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(439, 'Mabone Tablet', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(440, 'Rolage Tablet', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(441, 'Dermasim VT', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(442, 'Ecoren VT', 1, '2018-04-01 05:38:32', '0000-00-00 00:00:00'),
	(443, 'Atasin 10 F/C Tablet', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(444, 'Atasin 20 F/C Tablet', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(445, 'Inosit 500 Tablet', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(446, 'Inosit 750 Tablet', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(447, 'Lipigem Capsule', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(448, 'Recol Tablet', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(449, 'Clorel Tablet', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(450, 'Clorel-A Tablet', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(451, 'Minocap Injection', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(452, 'Rapilax Injection', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(453, 'Tizadin Tablet', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(454, 'Vecuron Dry Powder for Injection', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(455, 'Vecuron Injection', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(456, 'Relacs Oral Solution', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(457, 'Cepilep Tablet', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(458, 'Lamitrin Tablet', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(459, 'Veratin Tablet', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(460, 'Simet Paediatric Drop', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00'),
	(461, 'Sibuthin Capsule', 1, '2018-04-01 05:38:33', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `medicines` ENABLE KEYS */;


# Dumping structure for table pms.prescriptions
DROP TABLE IF EXISTS `prescriptions`;
CREATE TABLE IF NOT EXISTS `prescriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `doctor_id` int(11) NOT NULL DEFAULT '0',
  `diagnosis` varchar(222) DEFAULT '0',
  `temperature` varchar(222) DEFAULT '0',
  `blood_pressure` varchar(222) DEFAULT '0',
  `doctores_notes` text,
  `other_instructions` text,
  `pdf_file` varchar(222) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

# Dumping data for table pms.prescriptions: ~6 rows (approximately)
/*!40000 ALTER TABLE `prescriptions` DISABLE KEYS */;
REPLACE INTO `prescriptions` (`id`, `user_id`, `doctor_id`, `diagnosis`, `temperature`, `blood_pressure`, `doctores_notes`, `other_instructions`, `pdf_file`, `status`, `created`, `updated`) VALUES
	(36, 119, 101, '0', '90', 'heigh', 'instructions goes here, instructions goes here1', '', NULL, 1, '2018-02-27 10:20:45', '0000-00-00 00:00:00'),
	(49, 126, 101, '0', '', '', 'instructions goes here tetstts tet ste tst ste ets,\r\ninstructions goes here lal la  la lal lal la la ,\r\ninstructions goes here1 some text for instruction', '', NULL, 1, '2018-03-03 12:24:42', '0000-00-00 00:00:00'),
	(50, 126, 101, '0', '', '', 'instructions goes here tetstts tet ste tst ste ets,\r\ninstructions goes here1 some text for instruction', '', NULL, 1, '2018-03-03 12:25:15', '0000-00-00 00:00:00'),
	(57, 104, 101, '0', '', '', 'instructions goes here1,\r\ninstructions goes here1', '', 'prescription-1523118689.pdf', 1, '2018-04-06 08:32:19', '0000-00-00 00:00:00'),
	(58, 104, 101, '0', '', '', 'instructions goes here1', 'terte', 'prescription-1523100254.pdf', 1, '2018-04-06 08:42:11', '0000-00-00 00:00:00'),
	(59, 103, 101, '0', '', '', 'instructions goes here1', '', NULL, 1, '2018-04-12 14:00:02', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `prescriptions` ENABLE KEYS */;


# Dumping structure for table pms.prescriptions_diagnosis
DROP TABLE IF EXISTS `prescriptions_diagnosis`;
CREATE TABLE IF NOT EXISTS `prescriptions_diagnosis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prescription_id` int(11) NOT NULL,
  `diagnosis_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=277 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

# Dumping data for table pms.prescriptions_diagnosis: ~11 rows (approximately)
/*!40000 ALTER TABLE `prescriptions_diagnosis` DISABLE KEYS */;
REPLACE INTO `prescriptions_diagnosis` (`id`, `prescription_id`, `diagnosis_id`, `status`, `created`, `updated`) VALUES
	(28, 36, 3, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(29, 36, 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(123, 49, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(124, 49, 3, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(125, 49, 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(126, 50, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(127, 50, 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(270, 57, 15, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(271, 57, 16, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(275, 59, 15, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(276, 58, 16, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `prescriptions_diagnosis` ENABLE KEYS */;


# Dumping structure for table pms.prescriptions_medicines
DROP TABLE IF EXISTS `prescriptions_medicines`;
CREATE TABLE IF NOT EXISTS `prescriptions_medicines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prescription_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `rule` varchar(222) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=336 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

# Dumping data for table pms.prescriptions_medicines: ~26 rows (approximately)
/*!40000 ALTER TABLE `prescriptions_medicines` DISABLE KEYS */;
REPLACE INTO `prescriptions_medicines` (`id`, `prescription_id`, `medicine_id`, `rule`, `status`, `created`, `updated`) VALUES
	(28, 8, 4, '1-1-1', 1, '2018-02-11 15:19:21', '0000-00-00 00:00:00'),
	(29, 9, 5, '1-1-1', 1, '2018-02-11 16:54:29', '0000-00-00 00:00:00'),
	(30, 10, 5, '0-0-1', 1, '2018-02-11 17:06:33', '0000-00-00 00:00:00'),
	(31, 11, 4, '1-1-1', 1, '2018-02-11 17:09:47', '0000-00-00 00:00:00'),
	(33, 12, 4, '0-0-1', 1, '2018-02-11 17:23:00', '0000-00-00 00:00:00'),
	(40, 19, 6, '', 1, '2018-02-11 18:13:48', '0000-00-00 00:00:00'),
	(99, 36, 6, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(100, 36, 7, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(101, 36, 15, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(102, 36, 16, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(167, 49, 4, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(168, 49, 6, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(169, 49, 7, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(170, 49, 13, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(171, 49, 15, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(172, 49, 16, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(173, 50, 4, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(174, 50, 6, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(175, 50, 7, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(176, 50, 13, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(322, 57, 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(323, 57, 121, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(324, 57, 139, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(325, 57, 225, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(332, 59, 2, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(333, 59, 121, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(334, 58, 139, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(335, 58, 225, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `prescriptions_medicines` ENABLE KEYS */;


# Dumping structure for table pms.prescriptions_tests
DROP TABLE IF EXISTS `prescriptions_tests`;
CREATE TABLE IF NOT EXISTS `prescriptions_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prescription_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `note` varchar(222) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

# Dumping data for table pms.prescriptions_tests: ~21 rows (approximately)
/*!40000 ALTER TABLE `prescriptions_tests` DISABLE KEYS */;
REPLACE INTO `prescriptions_tests` (`id`, `prescription_id`, `test_id`, `note`, `status`, `created`, `updated`) VALUES
	(27, 8, 4, 'rtgh', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(28, 9, 4, 'rtgh', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(29, 10, 5, 'tert', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(30, 11, 5, 'rtgh', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(32, 12, 5, 'tert', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(39, 19, 0, '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(87, 36, 5, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(88, 36, 7, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(89, 36, 9, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(90, 36, 11, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(144, 49, 4, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(145, 49, 5, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(146, 49, 7, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(147, 49, 9, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(148, 49, 11, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(149, 50, 4, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(150, 50, 5, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(151, 50, 7, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(152, 50, 11, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(217, 57, 10, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(218, 58, 10, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(219, 57, 4, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(220, 59, 4, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `prescriptions_tests` ENABLE KEYS */;


# Dumping structure for table pms.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

# Dumping data for table pms.roles: ~3 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
REPLACE INTO `roles` (`id`, `name`) VALUES
	(1, 'Admin'),
	(2, 'Doctor'),
	(3, 'Patient');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;


# Dumping structure for table pms.settings
DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

# Dumping data for table pms.settings: ~8 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
REPLACE INTO `settings` (`id`, `key_name`, `value`) VALUES
	(3, 'site_name', 'PMS'),
	(6, 'site_email', 'admin@pms.com'),
	(10, 'from_email', 'PMS'),
	(11, 'from_name', 'mizan@pms.com'),
	(12, 'smtp_username', ''),
	(13, 'smtp_password', 'webalive@123'),
	(14, 'smtp_host', 'smtp_host'),
	(21, 'mode', 'dev');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;


# Dumping structure for table pms.states
DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(2) NOT NULL,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

# Dumping data for table pms.states: 59 rows
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
REPLACE INTO `states` (`id`, `code`, `name`) VALUES
	(1, 'AL', 'Alabama'),
	(2, 'AK', 'Alaska'),
	(3, 'AS', 'American Samoa'),
	(4, 'AZ', 'Arizona'),
	(5, 'AR', 'Arkansas'),
	(6, 'CA', 'California'),
	(7, 'CO', 'Colorado'),
	(8, 'CT', 'Connecticut'),
	(9, 'DE', 'Delaware'),
	(10, 'DC', 'District of Columbia'),
	(11, 'FM', 'Federated States of Micronesia'),
	(12, 'FL', 'Florida'),
	(13, 'GA', 'Georgia'),
	(14, 'GU', 'Guam'),
	(15, 'HI', 'Hawaii'),
	(16, 'ID', 'Idaho'),
	(17, 'IL', 'Illinois'),
	(18, 'IN', 'Indiana'),
	(19, 'IA', 'Iowa'),
	(20, 'KS', 'Kansas'),
	(21, 'KY', 'Kentucky'),
	(22, 'LA', 'Louisiana'),
	(23, 'ME', 'Maine'),
	(24, 'MH', 'Marshall Islands'),
	(25, 'MD', 'Maryland'),
	(26, 'MA', 'Massachusetts'),
	(27, 'MI', 'Michigan'),
	(28, 'MN', 'Minnesota'),
	(29, 'MS', 'Mississippi'),
	(30, 'MO', 'Missouri'),
	(31, 'MT', 'Montana'),
	(32, 'NE', 'Nebraska'),
	(33, 'NV', 'Nevada'),
	(34, 'NH', 'New Hampshire'),
	(35, 'NJ', 'New Jersey'),
	(36, 'NM', 'New Mexico'),
	(37, 'NY', 'New York'),
	(38, 'NC', 'North Carolina'),
	(39, 'ND', 'North Dakota'),
	(40, 'MP', 'Northern Mariana Islands'),
	(41, 'OH', 'Ohio'),
	(42, 'OK', 'Oklahoma'),
	(43, 'OR', 'Oregon'),
	(44, 'PW', 'Palau'),
	(45, 'PA', 'Pennsylvania'),
	(46, 'PR', 'Puerto Rico'),
	(47, 'RI', 'Rhode Island'),
	(48, 'SC', 'South Carolina'),
	(49, 'SD', 'South Dakota'),
	(50, 'TN', 'Tennessee'),
	(51, 'TX', 'Texas'),
	(52, 'UT', 'Utah'),
	(53, 'VT', 'Vermont'),
	(54, 'VI', 'Virgin Islands'),
	(55, 'VA', 'Virginia'),
	(56, 'WA', 'Washington'),
	(57, 'WV', 'West Virginia'),
	(58, 'WI', 'Wisconsin'),
	(59, 'WY', 'Wyoming');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;


# Dumping structure for table pms.tests
DROP TABLE IF EXISTS `tests`;
CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

# Dumping data for table pms.tests: ~10 rows (approximately)
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
REPLACE INTO `tests` (`id`, `name`, `status`, `created`) VALUES
	(4, 'PSA', 1, '2018-01-09 23:51:57'),
	(5, 'Skin exams', 1, '2018-01-09 23:51:57'),
	(6, 'Transvaginal ultrasound', 1, '2018-01-09 23:51:57'),
	(7, 'Virtual colonoscopy', 1, '2018-01-09 23:51:57'),
	(9, 'CA-125 test', 1, '2018-01-09 23:51:57'),
	(10, 'Cervical Cancer', 1, '2025-01-09 23:51:57'),
	(11, 'Abdominal Pain', 1, '2025-01-09 23:51:57'),
	(12, 'Mammography', 1, '2018-02-20 16:37:11'),
	(14, 'MRI', 1, '2018-02-20 16:39:13');
/*!40000 ALTER TABLE `tests` ENABLE KEYS */;


# Dumping structure for table pms.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  `password` varchar(255) NOT NULL,
  `clinic_name` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `signature` varchar(255) NOT NULL,
  `educational_qualification` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `token_generated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;

# Dumping data for table pms.users: 26 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `role_id`, `doctor_id`, `first_name`, `last_name`, `address_line1`, `address_line2`, `phone`, `email`, `age`, `password`, `clinic_name`, `website`, `logo`, `signature`, `educational_qualification`, `created`, `modified`, `expire_date`, `token`, `token_generated`) VALUES
	(6, 1, 0, 'Larry', 'Ullman', 'pangsha', 'rajbari', '01736 348772', 'doctor@gmail.com', 25, '$2y$10$rhBgWQ4X71B.f.VTKJ284OvBzvZ4NWW1/fSGB8obI8QLPBL49AXzm', 'clinic name', '', '', '', '', '2016-02-15 11:46:54', '2018-04-11 13:02:55', '0000-00-00', 'cddddb0f-5ce2-4e93-bf06-6f91f861975a', '2018-01-23 02:44:17'),
	(76, 3, 0, 'Johan', 'Costa', '', '', '01765 541265', 'johan@gmail.com', 55, '$2y$10$rhBgWQ4X71B.f.VTKJ284OvBzvZ4NWW1/fSGB8obI8QLPBL49AXzm', 'Fictionsoft', '', '', '', '', '2016-02-15 11:46:54', '2018-01-11 16:28:43', '0000-00-00', '54944a5d-6647-435e-925f-e969b704a4e7', '2016-12-01 06:39:37'),
	(77, 3, 0, 'MD', 'Mamun', '', '', '01735 451265', 'mamun@gmail.com', 43, '$2y$10$37mfbJVzmRKwkElBV.CMmOi3ZI67SC2uHzoHVl1xhpNQefB1ggvFm', '', '', '', 'signature', '', '2018-01-09 17:15:35', '2018-01-23 01:41:14', '0000-00-00', '', '0000-00-00 00:00:00'),
	(88, 3, 0, 'Saiful', 'Islam', '', '', '01736 451256', 'saiful@gmail.com', 21, '', '', '', '', '', '', '2018-01-10 17:16:17', '2018-01-11 16:28:13', '0000-00-00', '', '0000-00-00 00:00:00'),
	(89, 3, 0, 'AB', 'Rahaim', '', '', '01756 784521', 'rahaim@gmail.com', 25, '', '', '', '', '', '', '2018-01-11 16:35:48', '2018-01-11 16:35:48', '0000-00-00', '', '0000-00-00 00:00:00'),
	(90, 3, 0, 'Abdullah', 'Almamun', '', '', '10945 451245', 'abdullah@gmail.com', 24, '', '', '', '', '', '', '2018-01-11 16:38:59', '2018-01-11 16:38:59', '0000-00-00', '', '0000-00-00 00:00:00'),
	(92, 3, 101, 'Rakib', 'Islam', 'pabna', 'hemayetpur', '01854 452165', 'rakib@gmail.com', 18, '', 'Dhaka Medical Collage Hospital', 'www.fictionsoft.com', 'logo', 'signature', 'Diploma Engineer', '2018-01-11 16:43:27', '2018-03-13 19:02:06', '0000-00-00', '', '0000-00-00 00:00:00'),
	(95, 0, 0, 'Nazmul', 'Hasan', '', '', '', '', 0, '$2y$10$GA8RwPHMkKuMvl68977wYuVV/oN/u3WXReG../pICbddQ/TtwrAj6', '', '', '', '', '', '2018-01-19 17:06:07', '2018-01-19 17:06:07', '0000-00-00', '', '0000-00-00 00:00:00'),
	(96, 0, 0, 'Khalid', 'Hasan', '', '', '', 'khalid@gmail.com', 0, '$2y$10$l8SPv/l3XHL2PhySGP/7KOoH2BVa.vrSPLgvmEh3XovZBk4aT5AWa', '', '', '', '', '', '2018-01-19 17:16:39', '2018-01-19 17:16:39', '0000-00-00', '', '0000-00-00 00:00:00'),
	(101, 2, 132, 'Arafath', 'Khan', '384/1 , West Nakhalpara', 'Tejgaon, Mohakhali', '55165088', 'doctor@pms.com', 0, '$2y$10$Drrd2B1bJgAsXVnfbMJhgeTNPmQZp9IyHGa8ZitTURnHGrbOz.HrS', 'Dhaka Medical Collage Hospital', '', 'logo', 'signature', 'MBBS; FCPS( Medicine )', '2018-01-22 15:37:56', '2018-04-05 04:10:43', '06/04/2018', '047cabfb-58d9-451f-9893-d3181340aba8', '2018-01-23 17:15:44'),
	(99, 2, 132, 'Abdullah', 'Al Mamun', '', '', '', 'abdullah@pms.com', 0, '$2y$10$UFIpZGrkJS35p7C/fah13OtpAHmiEklqGXDjuNWAvqRcuGgOrkUDa', '', '', '', '', '', '2018-01-22 02:04:23', '2018-01-22 02:04:23', '0000-00-00', '', '0000-00-00 00:00:00'),
	(141, 2, 132, 'rfew', '', 'hg', '', '345', 'ghrtrt@gmail.com', 34, '', '', '', '', '', '', '2018-03-29 15:09:51', '2018-04-07 05:37:01', '0000-00-00', '', '0000-00-00 00:00:00'),
	(104, 3, 101, 'mintu islam', 'islam', 'shariatpur , sokhipur', 'sokhipur', '2222', 'aalmamun417@gmail.com', 23, '', '', '', '', '', '', '2018-02-08 17:13:57', '2018-04-13 13:11:42', '0000-00-00', '', '0000-00-00 00:00:00'),
	(103, 3, 101, 'sobuj hossen', 'hossen', 'Pangsha, Rajbari', 'rajbari', '1122', 'sobuj@gmail.com', 10, '', '', '', '', '', '', '2018-02-01 09:19:01', '2018-04-13 13:11:32', '0000-00-00', '', '0000-00-00 00:00:00'),
	(105, 3, 101, 'khairul islam', ' islam', '', 'rajbari', '12132141', 'khairul@gmail.com', 23, '', '', '', '', '', '', '2018-02-10 08:53:15', '2018-03-14 10:22:25', '0000-00-00', '', '0000-00-00 00:00:00'),
	(117, 3, 101, 'fahim', '', 'dhaka', '', '456789', 'fahim@gmail.com', 20, '', '', '', '', '', '', '2018-02-15 16:49:40', '2018-03-01 13:39:11', '0000-00-00', '', '0000-00-00 00:00:00'),
	(131, 3, 127, 'sohag', '', 'dhaka', '', '4324', 'saiful@gmail.co', 324, '', '', '', '', '', '', '2018-03-02 17:24:31', '2018-03-02 17:24:31', '0000-00-00', '', '0000-00-00 00:00:00'),
	(132, 1, 0, 'Mohammad ', 'Habibullah', '', '', '', 'admin@pms.com', 0, '$2y$10$IJWoTlDS4DziORD0t//XiOEb3RjEocH3O1CuhiX1R4Q1P0/Ccr/vO', '', '', '', '', '', '2018-03-19 16:50:47', '2018-03-19 16:50:47', '0000-00-00', '889e4a17-7fb1-4709-9c48-3aa28f2af42c', '0000-00-00 00:00:00'),
	(133, 2, 132, 'Rayhan', '', 'Dhaka, Bangladesh', '', '017235467', 'rayhan@gmail.com', 25, '', '', '', '', '', '', '2018-03-20 16:35:45', '2018-03-20 16:35:45', '0000-00-00', '', '0000-00-00 00:00:00'),
	(134, 2, 132, 'Redoy', '', 'Dhaka', '', '01735435678', 'redoy@gmail.com', 28, '$2y$10$fTusKipNh3MmChTUOFjogOKXlfMl9vUWbk96a4.izOyh2t12Z71rG', '', '', '', '', '', '2018-03-25 15:24:44', '2018-04-07 06:13:56', '0000-00-00', '', '0000-00-00 00:00:00'),
	(153, 2, NULL, 'fds', 'rete', '', '', '', 'tete@pms.com', 0, '$2y$10$EUwKutlfBF7DwtDGP6k.xOHjk7UfPiuz06IkgeYKxbCCdmaqlv8NK', '', '', '', '', '', '2018-04-07 06:32:11', '2018-04-07 06:32:11', '07/04/2019', '2d2578b7-d4c4-4357-8e02-e1c9cad19fce', '0000-00-00 00:00:00'),
	(154, 2, NULL, 'fds', 'rete', '', '', '', 'hgtr@pms.com', 0, '$2y$10$VHIyXUIv5yj.z0xEr7y2/ulx4EbJV0iLhOWyjXgLsBY8akP1FhMuO', '', '', '', '', '', '2018-04-07 06:33:44', '2018-04-07 06:33:44', '04/04/2018', '997efc26-0e28-497c-8af3-b2d4aa62fc04', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


# Dumping structure for table pms.venues
DROP TABLE IF EXISTS `venues`;
CREATE TABLE IF NOT EXISTS `venues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) DEFAULT NULL,
  `slug` varchar(222) DEFAULT NULL,
  `post_code` varchar(222) DEFAULT NULL,
  `state` varchar(222) DEFAULT NULL,
  `city` varchar(222) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

# Dumping data for table pms.venues: 2 rows
/*!40000 ALTER TABLE `venues` DISABLE KEYS */;
REPLACE INTO `venues` (`id`, `name`, `slug`, `post_code`, `state`, `city`, `country_id`, `status`, `created`, `updated`) VALUES
	(4, 'test venue', 'test-venue', '4', '4', 'Dha', 1, 1, '2017-08-28 21:03:32', '0000-00-00 00:00:00'),
	(3, 'Venue1', 'venue1', '11', 'state', 'Dhaka', 18, 1, '2017-08-28 20:41:12', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `venues` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
