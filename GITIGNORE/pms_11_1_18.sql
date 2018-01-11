# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.5-10.1.25-MariaDB
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2018-01-11 08:34:29
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
	(1, 'Larry', 'Ullman', '29/09/2017', '234567', '345678', 'Dhaka', 'Uttara', 'larry@gmail.com', '4567', 'Dhaka', 'Dhaka', 240, 3, 1, '2017-08-29 20:48:41', '0000-00-00 00:00:00'),
	(2, 'Mizan', 'BM', '29/08/2017', '34567', '6789', 'Dhaka', 'Dhaka', 'mizan@bitmascot.com', '789', 'Dhaka', 'Dhaka', 16, 3, 1, '2017-08-29 20:48:45', '0000-00-00 00:00:00'),
	(3, 'Larry', 'Ullman', '29/08/2017', '234567', '345678', 'Dhaka', 'Uttara', 'larryy@gmail.com', '4567', 'Dhaka', 'Dhaka', 8, 3, 1, '2017-08-29 14:20:34', '0000-00-00 00:00:00'),
	(17, 'Nandita', NULL, '29/09/2018', '48987', '21325465', 'Test', NULL, 'e2@ft.com', '1213', 'Dhaka', 'Dhaka', 18, 3, 1, '2017-08-29 20:08:38', '0000-00-00 00:00:00'),
	(18, 'Nandita', 'Roy', '29/09/2021', '48987', NULL, 'Test', NULL, 'e5@ft.com', '1216', 'Dhaka', 'Dhaka', 18, 3, 1, '2017-08-29 20:08:38', '0000-00-00 00:00:00'),
	(19, 'Nandita', 'Roy', '29/09/2026', '48987', '21325465', 'Test', NULL, 'e10@ft.com', '1221', 'Dhaka', 'Dhaka', 0, 3, 1, '2017-08-29 20:08:38', '0000-00-00 00:00:00'),
	(20, 'Nandita', 'Roy', '29/09/2027', '48987', '21325465', 'Test', NULL, 'e11@ft.com', '1222', 'Dhaka', 'Dhaka', 18, 3, 1, '2017-08-29 20:48:48', '0000-00-00 00:00:00'),
	(21, 'Nandita', 'Roy', '29/09/2028', '48987', '21325465', 'Test', NULL, 'e12@ft.com', '1223', 'Dhaka', 'Dhaka', 18, 3, 1, '2017-08-29 20:08:38', '0000-00-00 00:00:00'),
	(22, 'test', 'nan', '01/08/2017', '456', '5676', '6uytu', 'tyujtyu', 'pinni.na6ndita@gmail.com', '5466', 'Dhaka', 'Dhaka', 18, 3, 1, '2017-08-29 20:47:33', '0000-00-00 00:00:00');
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
	(3, 'Software Engineer', 1, '2017-08-29 14:19:15', '0000-00-00 00:00:00');
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
	(6, 'test', 'test', 1503878400, '15:00', '14:00', 4, 6, 1, '2017-08-28 16:21:53', '0000-00-00 00:00:00'),
	(7, 'test2', 'test2', 1503964800, '16:00', '16:00', 3, 6, 1, '2017-08-28 16:22:17', '0000-00-00 00:00:00');
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
	(6, 'test', 'test', 0, 0, 1, '2017-08-27 18:31:04', '0000-00-00 00:00:00'),
	(13, 'test1', 'test1', 1503878400, 1503964800, 1, '2017-08-28 16:19:26', '0000-00-00 00:00:00'),
	(15, 'test4', 'test4', 1515542400, 1516924800, 1, '2018-01-08 22:13:55', '0000-00-00 00:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

# Dumping data for table pms.medicines: ~9 rows (approximately)
/*!40000 ALTER TABLE `medicines` DISABLE KEYS */;
REPLACE INTO `medicines` (`id`, `name`, `status`, `created`, `updated`) VALUES
	(4, 'Actiq', 1, '2018-01-09 14:57:55', '0000-00-00 00:00:00'),
	(5, 'Alora', 1, '2018-01-09 14:58:19', '0000-00-00 00:00:00'),
	(6, 'Dacogen', 1, '2018-01-09 14:59:16', '0000-00-00 00:00:00'),
	(7, 'Daypro', 1, '2018-01-09 14:59:32', '0000-00-00 00:00:00'),
	(8, 'Edex', 1, '2018-01-09 14:59:53', '0000-00-00 00:00:00'),
	(9, 'Emla', 1, '2018-01-09 15:00:06', '0000-00-00 00:00:00'),
	(10, 'Je-Vax', 1, '2018-01-09 15:00:27', '0000-00-00 00:00:00'),
	(11, 'Lasix', 1, '2018-01-09 15:00:45', '0000-00-00 00:00:00'),
	(12, 'Lipitor', 1, '2018-01-09 15:01:03', '0000-00-00 00:00:00'),
	(13, 'Questran', 1, '2018-01-09 15:01:24', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `medicines` ENABLE KEYS */;


# Dumping structure for table pms.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

# Dumping data for table pms.roles: ~2 rows (approximately)
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
	(10, 'from_email', 'NACCO'),
	(11, 'from_name', 'mizan@bitmascot.com'),
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

# Dumping data for table pms.tests: ~7 rows (approximately)
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
REPLACE INTO `tests` (`id`, `name`, `status`, `created`) VALUES
	(4, 'PSA test', 1, '2018-01-08 21:51:57'),
	(5, 'Skin exams', 1, '2018-01-08 21:51:57'),
	(6, 'Transvaginal ultrasound', 1, '2018-01-08 21:51:57'),
	(7, 'Virtual colonoscopy', 1, '2018-01-08 21:51:57'),
	(8, 'Mammography', 1, '2018-01-08 21:51:57'),
	(9, 'CA-125 test', 1, '2018-01-08 21:51:57'),
	(10, 'Cervical Cancer', 1, '2018-01-08 21:51:57');
/*!40000 ALTER TABLE `tests` ENABLE KEYS */;


# Dumping structure for table pms.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  `password` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `token_generated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

# Dumping data for table pms.users: 4 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `role_id`, `first_name`, `last_name`, `phone`, `email`, `age`, `password`, `company`, `created`, `modified`, `token`, `token_generated`) VALUES
	(6, 1, 'Larry', 'Ullman', '523', 'admin@pms.com', 40, '$2y$10$rhBgWQ4X71B.f.VTKJ284OvBzvZ4NWW1/fSGB8obI8QLPBL49AXzm', 'Fictionsoft', '2016-02-15 11:46:54', '2016-12-01 06:40:07', '54944a5d-6647-435e-925f-e969b704a4e7', '2016-12-01 06:39:37'),
	(76, 3, 'Johan', 'Costa', '523', 'johan@gmail.com', 55, '$2y$10$rhBgWQ4X71B.f.VTKJ284OvBzvZ4NWW1/fSGB8obI8QLPBL49AXzm', 'Fictionsoft', '2016-02-15 11:46:54', '2018-01-09 17:18:02', '54944a5d-6647-435e-925f-e969b704a4e7', '2016-12-01 06:39:37'),
	(77, 3, 'mamun', 'gbfdg', '5345', 'dfghdf@gmail.com', 43, '$2y$10$DMsTXzj5d2PhVvmUexXcuOiQzfk.baiGj59vkUvgmK500gsuaKQn.', '', '2018-01-09 17:15:35', '2018-01-10 16:13:44', '', '0000-00-00 00:00:00'),
	(88, 3, 'saiful', 'islam', '5435', 'saiful@gmail.com', 21, '', '', '2018-01-10 17:16:17', '2018-01-10 17:16:17', '', '0000-00-00 00:00:00');
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
	(4, 'test venue', 'test-venue', '4', '4', 'Dha', 1, 1, '2017-08-27 20:03:32', '0000-00-00 00:00:00'),
	(3, 'Venue1', 'venue1', '11', 'state', 'Dhaka', 18, 1, '2017-08-27 19:41:12', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `venues` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
