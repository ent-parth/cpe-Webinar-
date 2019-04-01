-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2019 at 02:45 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mycpa`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `first_name`, `last_name`, `email`, `password`, `remember_token`, `avatar`, `contact_no`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Sanjay', 'Chabhadiya', 'sanjay47c@gmail.com', '$2y$10$RXQX2FhBx6l0CtPR5qFQWexyDHF7YJVWkLffhQVKAgPTXJe7X46Xy', 'ijnyDedlQ7ix2gqiQbaBGeSPFYOACGUofYDsGvDoFnXcho82Yc3Ff9cOpyxd', NULL, '7894561230', 'active', 0, 1, NULL, '2018-12-17 07:12:14'),
(6, 'jignesh dodiya', 'Dodiya', 'jigneshdodiya10@gmail.com', '$2y$10$88OH.I5clTmRBYEGvGOaMe6p3NjmlqQ4/0i/lweQ.L4r6HyPsI0C6', NULL, NULL, '9979006185', 'inactive', 1, 1, '2018-12-17 06:26:10', '2018-12-18 06:48:04'),
(16, 'p', 'k', 'p@k.com', '$2y$10$RXQX2FhBx6l0CtPR5qFQWexyDHF7YJVWkLffhQVKAgPTXJe7X46Xy', 'NyieA4XqiLXIsDTdXTx8hYXahm18WTmePcq7JxBixQizZFXQMUfKXUlnuEnz', NULL, '1111111111', 'active', 1, 16, '2019-01-09 07:08:27', '2019-01-09 07:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `administrators_password_resets`
--

CREATE TABLE `administrators_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Accounting', 'Accounting', 'active', 1, 0, '2018-12-03 06:57:07', '2018-12-03 06:57:07'),
(2, 'Finance', 'Finance', 'active', 1, 0, '2018-12-03 06:57:24', '2018-12-03 06:57:24'),
(3, 'Information Technology', 'Information Technology', 'inactive', 1, 1, '2018-12-03 06:57:34', '2018-12-06 00:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT 'inactive => InActive, active => Active, delete => Delete',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `state_id`, `name`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Ahmedabad', 'active', 1, 0, '2018-12-03 04:35:39', '2018-12-03 04:35:39');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `logo`, `website`, `contact_number`, `description`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Twocompo', 'download.png', NULL, NULL, NULL, 'active', 0, 0, '2018-12-03 04:36:38', '2018-12-03 04:36:38'),
(2, 'MyCompany', NULL, 'www.MyCompany.com', '543534534534', 'MyCompany MyCompany MyCompany MyCompany MyCompany MyCompany', 'active', 1, 0, '2018-12-20 18:30:00', NULL),
(3, 'Test Company', NULL, NULL, NULL, NULL, 'active', 0, 0, '2018-12-21 00:22:05', '2018-12-21 00:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `companies_password_resets`
--

CREATE TABLE `companies_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_user`
--

CREATE TABLE `company_user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `person_email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `phone_ext` varchar(5) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `about_company` text,
  `credit_card_number` varchar(255) DEFAULT NULL,
  `name_on_card` varchar(255) DEFAULT NULL,
  `card_expiry_date` varchar(255) DEFAULT NULL,
  `card_cvv` varchar(3) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','delete') NOT NULL DEFAULT 'inactive',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_user`
--

INSERT INTO `company_user` (`id`, `email`, `password`, `company_name`, `name`, `person_email`, `phone`, `phone_ext`, `mobile`, `designation`, `website`, `logo`, `about_company`, `credit_card_number`, `name_on_card`, `card_expiry_date`, `card_cvv`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'jigneshdodiya10@gmail.com', '$2y$10$kP90hYMUFDmW9E9ocqENe.3OGbFV2NWU0id7jPxL.ppyLSSE2cVgy', 'twocompo', 'jignesh dodiya', 'jigneshdodiya10@gmail.com', '8596589658', '91', '5845269856', 'Developer', 'https://www.google.com', '1547120308download.png', 'The expiration date is embossed on the card. The card will expire on the last day of the month that is written. For example, if the expiration month/year', '4242424242424242', 'jignesh dodiya', '09/25', '123', NULL, 'active', '2019-01-10 07:20:03', '2019-01-10 12:59:35');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT 'inactive => InActive, active => Active, delete => Delete',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT 'inactive => InActive, active => Active, delete => Delete',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'India', 'active', 1, 0, '2018-12-03 04:34:50', '2018-12-03 04:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_level_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_level_id`, `name`, `description`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Taxes', 'The Tax Cuts and Jobs Act of 2017 (TCJA), signed into law during the closing days of 2017, will significantly affect tax planning and the income tax liability for many taxpayers. This course will examine the principal changes affecting individual taxpayers made by the TCJA.', 'active', 1, 0, '2018-12-03 07:02:59', '2018-12-03 07:02:59'),
(2, 3, 'Personal Development', 'A frequently asked question is \"Are great leaders born or can anyone learn to inspire?\" During this one hour session we will discuss what traits define the best leaders and how you can learn to harness these qualities to be an exceptionally effective leader - whether in your firm, in your community or with clients and business colleagues.', 'active', 1, 0, '2018-12-03 07:03:31', '2018-12-03 07:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `course_levels`
--

CREATE TABLE `course_levels` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_levels`
--

INSERT INTO `course_levels` (`id`, `name`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Individual', 'active', 1, 1, '2018-12-03 07:00:30', '2018-12-03 07:01:23'),
(2, 'Second Level', 'active', 1, 0, '2018-12-03 07:01:00', '2018-12-03 07:01:00'),
(3, 'Basic', 'active', 1, 0, '2018-12-03 07:02:03', '2018-12-03 07:02:03'),
(4, 'Advance', 'active', 1, 0, '2018-12-03 07:02:13', '2018-12-03 07:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `device_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_login` tinyint(4) DEFAULT NULL COMMENT '0 => logout, 1=> login',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_for` tinyint(4) DEFAULT NULL,
  `template_text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 => InActive, 1 => Active, 2 => Delete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_speakers_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_administrators_password_resets_table', 1),
(4, '2018_09_12_104009_create_categories_table', 1),
(5, '2018_09_12_104009_create_companies_table', 1),
(6, '2018_09_12_104009_create_course_levels_table', 1),
(7, '2018_09_12_104009_create_courses_table', 1),
(8, '2018_09_12_104009_create_roles_table', 1),
(9, '2018_09_12_104009_create_speaker_ratings_table', 1),
(10, '2018_09_12_104009_create_tag_webinar_table', 1),
(11, '2018_09_12_104009_create_tags_table', 1),
(12, '2018_09_12_104009_create_webinar_attendies_table', 1),
(13, '2018_09_12_104009_create_webinar_documents_table', 1),
(14, '2018_09_12_104009_create_webinars_table', 1),
(15, '2018_09_12_110842_create_administrators_table', 1),
(16, '2018_09_12_110842_create_teams_table', 1),
(17, '2018_09_17_114130_create_email_templates_table', 1),
(18, '2018_09_27_052743_create_cities_table', 1),
(19, '2018_09_27_052743_create_states_table', 1),
(20, '2018_09_27_052943_create_contact_us_table', 1),
(21, '2018_09_27_052943_create_countries_table', 1),
(22, '2018_10_05_073223_create_permission_role_table', 1),
(23, '2018_10_05_073223_create_tag_user_table', 1),
(24, '2018_10_17_075212_create_devices_table', 1),
(25, '2018_11_21_091940_add_new_fields_into_webinar', 1),
(26, '2018_11_21_110902_add_and_delete_new_fields_into_webinar', 1),
(27, '2014_10_12_100000_create_speakers_password_resets_table', 2),
(28, '2018_09_12_104009_create_subjects_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notification_text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_admin` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `read_at` datetime DEFAULT NULL,
  `read_notification` int(11) NOT NULL DEFAULT '0',
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notification_text`, `user_id`, `is_admin`, `created_at`, `read_at`, `read_notification`, `link`) VALUES
(10, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 10:26:00', NULL, 0, 'selfstudy-webinar'),
(11, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 10:26:00', NULL, 0, 'selfstudy-webinar'),
(12, 'jignesh dodiyahas uploaded an Live Webinar. Please review it.', 1, 1, '2019-01-08 10:30:38', NULL, 0, 'live-webinar'),
(13, 'jignesh dodiyahas uploaded an Live Webinar. Please review it.', 6, 1, '2019-01-08 10:30:38', NULL, 0, 'live-webinar'),
(14, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 10:47:28', NULL, 0, 'selfstudy-webinar'),
(15, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 10:47:28', NULL, 0, 'selfstudy-webinar'),
(16, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 10:47:52', NULL, 0, 'selfstudy-webinar'),
(17, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 10:47:52', NULL, 0, 'selfstudy-webinar'),
(18, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 10:55:12', NULL, 0, 'selfstudy-webinar'),
(19, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 10:55:12', NULL, 0, 'selfstudy-webinar'),
(20, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 11:05:28', NULL, 0, 'selfstudy-webinar'),
(21, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 11:05:28', NULL, 0, 'selfstudy-webinar'),
(22, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 11:07:12', NULL, 0, 'selfstudy-webinar'),
(23, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 11:07:12', NULL, 0, 'selfstudy-webinar'),
(24, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 11:07:47', NULL, 0, 'selfstudy-webinar'),
(25, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 11:07:47', NULL, 0, 'selfstudy-webinar'),
(26, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 11:49:42', NULL, 0, 'selfstudy-webinar'),
(27, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 11:49:42', NULL, 0, 'selfstudy-webinar'),
(28, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 12:14:29', NULL, 0, 'selfstudy-webinar'),
(29, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 12:14:29', NULL, 0, 'selfstudy-webinar'),
(30, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 12:15:35', NULL, 0, 'selfstudy-webinar'),
(31, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 12:15:35', NULL, 0, 'selfstudy-webinar'),
(32, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 12:15:42', NULL, 0, 'selfstudy-webinar'),
(33, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 12:15:42', NULL, 0, 'selfstudy-webinar'),
(34, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 12:19:09', NULL, 0, 'selfstudy-webinar'),
(35, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 12:19:09', NULL, 0, 'selfstudy-webinar'),
(36, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 12:19:40', NULL, 0, 'selfstudy-webinar'),
(37, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 12:19:40', NULL, 0, 'selfstudy-webinar'),
(38, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 12:21:10', NULL, 0, 'selfstudy-webinar'),
(39, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 12:21:10', NULL, 0, 'selfstudy-webinar'),
(40, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 12:22:45', NULL, 0, 'selfstudy-webinar'),
(41, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 12:22:45', NULL, 0, 'selfstudy-webinar'),
(42, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 12:23:45', NULL, 0, 'selfstudy-webinar'),
(43, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 12:23:45', NULL, 0, 'selfstudy-webinar'),
(44, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 12:45:44', NULL, 0, 'selfstudy-webinar'),
(45, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 12:45:44', NULL, 0, 'selfstudy-webinar'),
(46, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 12:46:30', NULL, 0, 'selfstudy-webinar'),
(47, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 12:46:30', NULL, 0, 'selfstudy-webinar'),
(48, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-08 12:46:42', NULL, 0, 'selfstudy-webinar'),
(49, 'jignesh dodiyahas uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-08 12:46:42', NULL, 0, 'selfstudy-webinar'),
(50, 'jignesh dodiya has uploaded an Live Webinar. Please review it.', 1, 1, '2019-01-10 06:23:07', NULL, 0, 'live-webinar'),
(51, 'jignesh dodiya has uploaded an Live Webinar. Please review it.', 6, 1, '2019-01-10 06:23:07', NULL, 0, 'live-webinar'),
(52, 'jignesh dodiya has uploaded an Live Webinar. Please review it.', 16, 1, '2019-01-10 06:23:07', NULL, 0, 'live-webinar'),
(53, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-18 07:18:11', NULL, 0, 'selfstudy-webinar'),
(54, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-18 07:18:11', NULL, 0, 'selfstudy-webinar'),
(55, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-18 07:18:11', NULL, 0, 'selfstudy-webinar'),
(56, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-18 07:40:42', NULL, 0, 'selfstudy-webinar'),
(57, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-18 07:40:42', NULL, 0, 'selfstudy-webinar'),
(58, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-18 07:40:42', NULL, 0, 'selfstudy-webinar'),
(59, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:16:19', NULL, 0, 'selfstudy-webinar'),
(60, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:16:19', NULL, 0, 'selfstudy-webinar'),
(61, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:16:19', NULL, 0, 'selfstudy-webinar'),
(62, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:26:58', NULL, 0, 'selfstudy-webinar'),
(63, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:26:58', NULL, 0, 'selfstudy-webinar'),
(64, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:26:58', NULL, 0, 'selfstudy-webinar'),
(65, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:27:03', NULL, 0, 'selfstudy-webinar'),
(66, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:27:03', NULL, 0, 'selfstudy-webinar'),
(67, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:27:03', NULL, 0, 'selfstudy-webinar'),
(68, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:27:26', NULL, 0, 'selfstudy-webinar'),
(69, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:27:26', NULL, 0, 'selfstudy-webinar'),
(70, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:27:26', NULL, 0, 'selfstudy-webinar'),
(71, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:27:51', NULL, 0, 'selfstudy-webinar'),
(72, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:27:51', NULL, 0, 'selfstudy-webinar'),
(73, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:27:51', NULL, 0, 'selfstudy-webinar'),
(74, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:28:11', NULL, 0, 'selfstudy-webinar'),
(75, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:28:11', NULL, 0, 'selfstudy-webinar'),
(76, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:28:11', NULL, 0, 'selfstudy-webinar'),
(77, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:28:26', NULL, 0, 'selfstudy-webinar'),
(78, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:28:26', NULL, 0, 'selfstudy-webinar'),
(79, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:28:26', NULL, 0, 'selfstudy-webinar'),
(80, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:28:28', NULL, 0, 'selfstudy-webinar'),
(81, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:28:28', NULL, 0, 'selfstudy-webinar'),
(82, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:28:28', NULL, 0, 'selfstudy-webinar'),
(83, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:32:00', NULL, 0, 'selfstudy-webinar'),
(84, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:32:00', NULL, 0, 'selfstudy-webinar'),
(85, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:32:00', NULL, 0, 'selfstudy-webinar'),
(86, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:49:28', NULL, 0, 'selfstudy-webinar'),
(87, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:49:28', NULL, 0, 'selfstudy-webinar'),
(88, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:49:28', NULL, 0, 'selfstudy-webinar'),
(89, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:53:41', NULL, 0, 'selfstudy-webinar'),
(90, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:53:41', NULL, 0, 'selfstudy-webinar'),
(91, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:53:41', NULL, 0, 'selfstudy-webinar'),
(92, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:55:23', NULL, 0, 'selfstudy-webinar'),
(93, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:55:23', NULL, 0, 'selfstudy-webinar'),
(94, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:55:23', NULL, 0, 'selfstudy-webinar'),
(95, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 07:59:03', NULL, 0, 'selfstudy-webinar'),
(96, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 07:59:03', NULL, 0, 'selfstudy-webinar'),
(97, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 07:59:03', NULL, 0, 'selfstudy-webinar'),
(98, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 08:02:01', NULL, 0, 'selfstudy-webinar'),
(99, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 08:02:01', NULL, 0, 'selfstudy-webinar'),
(100, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 08:02:01', NULL, 0, 'selfstudy-webinar'),
(101, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 08:04:56', NULL, 0, 'selfstudy-webinar'),
(102, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 08:04:56', NULL, 0, 'selfstudy-webinar'),
(103, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 08:04:56', NULL, 0, 'selfstudy-webinar'),
(104, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 09:16:49', NULL, 0, 'selfstudy-webinar'),
(105, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 09:16:49', NULL, 0, 'selfstudy-webinar'),
(106, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 09:16:49', NULL, 0, 'selfstudy-webinar'),
(107, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 10:04:31', NULL, 0, 'selfstudy-webinar'),
(108, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 10:04:31', NULL, 0, 'selfstudy-webinar'),
(109, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 10:04:31', NULL, 0, 'selfstudy-webinar'),
(110, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 10:27:01', NULL, 0, 'selfstudy-webinar'),
(111, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 10:27:01', NULL, 0, 'selfstudy-webinar'),
(112, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 10:27:01', NULL, 0, 'selfstudy-webinar'),
(113, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 10:37:53', NULL, 0, 'selfstudy-webinar'),
(114, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 10:37:53', NULL, 0, 'selfstudy-webinar'),
(115, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 10:37:53', NULL, 0, 'selfstudy-webinar'),
(116, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 11:06:43', NULL, 0, 'selfstudy-webinar'),
(117, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 11:06:43', NULL, 0, 'selfstudy-webinar'),
(118, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 11:06:43', NULL, 0, 'selfstudy-webinar'),
(119, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 1, 1, '2019-01-22 11:09:33', NULL, 0, 'selfstudy-webinar'),
(120, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 6, 1, '2019-01-22 11:09:33', NULL, 0, 'selfstudy-webinar'),
(121, 'jignesh dodiya has uploaded an Self Study Webinar. Please review it.', 16, 1, '2019-01-22 11:09:33', NULL, 0, 'selfstudy-webinar'),
(122, 'jignesh dodiya has uploaded an Live Webinar. Please review it.', 1, 1, '2019-01-22 12:52:00', NULL, 0, 'live-webinar'),
(123, 'jignesh dodiya has uploaded an Live Webinar. Please review it.', 6, 1, '2019-01-22 12:52:00', NULL, 0, 'live-webinar'),
(124, 'jignesh dodiya has uploaded an Live Webinar. Please review it.', 16, 1, '2019-01-22 12:52:00', NULL, 0, 'live-webinar');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci DEFAULT 'active' COMMENT '0=Inactive,1=Inactive,2=Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'permission_add', 'Permission Add', 'Permission Add', 'active', '2019-01-08 23:01:31', NULL, NULL, NULL),
(2, 'permission_edit', 'Permission Edit', 'Permission Edit', 'active', '2019-01-08 23:02:41', NULL, NULL, NULL),
(3, 'permission_delete', 'Permission Delete', 'Permission Delete', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(4, 'permission_view', 'Permission View', 'Permission View', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(8, 'country_add', 'country Add', 'country Add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(9, 'country_edit', 'country Edit', 'country Edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(50, 'country_delete', 'country Deletet', 'country Delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(51, 'country_view', 'country View', 'country View', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(52, 'state_add', 'state add', 'state add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(53, 'state_edit', 'state edit', 'state edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(54, 'state_delete', 'state deletet', 'state delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(55, 'state_view', 'state view', 'state view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(56, 'city_add', 'city add', 'city add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(57, 'city_edit', 'city edit', 'city edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(58, 'city_delete', 'city deletet', 'city delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(59, 'city_view', 'city view', 'city view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(60, 'attendee_add', 'attendee add', 'attendee add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(61, 'attendee_edit', 'attendee edit', 'attendee edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(62, 'attendee_delete', 'attendee deletet', 'attendee delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(63, 'attendee_view', 'attendee view', 'attendee view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(64, 'live_webinar_add', 'live webinar add', 'live webinar add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(65, 'live_webinar_edit', 'live webinar edit', 'live webinar edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(66, 'live_webinar_delete', 'live webinar deletet', 'live webinar delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(67, 'live_webinar_view', 'live webinar view', 'live webinar view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(68, 'selfstudy_webinar_add', 'selfstudy webinar add', 'selfstudy webinar add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(69, 'selfstudy_webinar_edit', 'selfstudy webinar edit', 'selfstudy webinar edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(70, 'selfstudy_webinar_delete', 'selfstudy webinar deletet', 'selfstudy webinar delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(71, 'selfstudy_webinar_view', 'selfstudy webinar view', 'selfstudy webinar view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(72, 'archive_webinar_add', 'archive webinar add', 'archive webinar add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(73, 'archive_webinar_edit', 'archive webinar edit', 'archive webinar edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(74, 'archive_webinar_delete', 'archive webinar deletet', 'archive webinar delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(75, 'archive_webinar_view', 'archive webinar view', 'archive webinar view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(76, 'subject_add', 'subject add', 'subject add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(77, 'subject_edit', 'subject edit', 'subject edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(78, 'subject_delete', 'subject deletet', 'subject delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(79, 'subject_view', 'subject view', 'subject view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(80, 'user_type_add', 'user type add', 'user type add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(81, 'user_type_edit', 'user type edit', 'user type edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(82, 'user_type_delete', 'user type deletet', 'user type delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(83, 'user_type_view', 'user type view', 'user type view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(84, 'team_add', 'team add', 'team add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(85, 'team_edit', 'team edit', 'team edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(86, 'team_delete', 'team deletet', 'team delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(87, 'team_view', 'team view', 'team view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(88, 'tag_add', 'tag add', 'tag add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(89, 'tag_edit', 'tag edit', 'tag edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(90, 'tag_delete', 'tag deletet', 'tag delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(91, 'tag_view', 'tag view', 'tag view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(92, 'series_add', 'series add', 'series add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(93, 'series_edit', 'series edit', 'series edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(94, 'series_delete', 'series deletet', 'series delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(95, 'series_view', 'series view', 'series view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(96, 'course_add', 'course add', 'course add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(97, 'course_edit', 'course edit', 'course edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(98, 'course_delete', 'course deletet', 'course delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(99, 'course_view', 'course view', 'course view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(100, 'course_level_add', 'course level add', 'course level add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(101, 'course_level_edit', 'course level edit', 'course level edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(102, 'course_level_delete', 'course level deletet', 'course level delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(103, 'course_level_view', 'course level view', 'course level view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(104, 'category_add', 'category add', 'category add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(105, 'category_edit', 'category edit', 'category edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(106, 'category_delete', 'category deletet', 'category delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(107, 'category_view', 'category view', 'category view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(108, 'speaker_add', 'speaker add', 'speaker add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(109, 'speaker_edit', 'speaker edit', 'speaker edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(110, 'speaker_delete', 'speaker deletet', 'speaker delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(111, 'speaker_view', 'speaker view', 'speaker view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(112, 'company_add', 'company add', 'company add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(113, 'company_edit', 'company edit', 'company edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(114, 'company_delete', 'company deletet', 'company delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(115, 'company_view', 'company view', 'company view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(116, 'admin_add', 'admin add', 'admin add', 'active', '2019-01-08 17:31:31', NULL, NULL, NULL),
(117, 'admin_edit', 'admin edit', 'admin edit', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(118, 'admin_delete', 'admin deletet', 'admin delete', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(119, 'admin_view', 'admin view', 'admin view', 'active', '2019-01-08 17:32:41', NULL, NULL, NULL),
(120, 'front_user_add', 'front user add', 'front user add', 'active', '2019-01-08 17:31:31', '2019-01-09 06:25:45', NULL, NULL),
(121, 'front_user_edit', 'front user edit', 'front user edit', 'active', '2019-01-08 17:32:41', '2019-01-09 06:26:12', NULL, NULL),
(122, 'front_user_delete', 'front user deletet', 'front user delete', 'active', '2019-01-08 17:32:41', '2019-01-09 06:26:22', NULL, NULL),
(123, 'front_user_view', 'front user view', 'front user view', 'active', '2019-01-08 17:32:41', '2019-01-09 06:26:33', NULL, NULL),
(124, 'payment_history_view', 'webinar payment history view', 'webinar payment history view', 'active', '2019-01-09 05:09:31', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL,
  `permissions_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permissions_id`, `role_id`, `user_id`) VALUES
(18, 1, 1, 6),
(19, 3, 1, 6),
(20, 2, 1, 6),
(21, 4, 1, 6),
(31, 116, 2, 1),
(32, 118, 2, 1),
(33, 117, 2, 1),
(34, 119, 2, 1),
(35, 72, 2, 1),
(36, 74, 2, 1),
(37, 73, 2, 1),
(38, 75, 2, 1),
(39, 60, 2, 1),
(40, 62, 2, 1),
(41, 61, 2, 1),
(42, 63, 2, 1),
(43, 104, 2, 1),
(44, 106, 2, 1),
(45, 105, 2, 1),
(46, 107, 2, 1),
(47, 56, 2, 1),
(48, 58, 2, 1),
(49, 57, 2, 1),
(50, 59, 2, 1),
(51, 112, 2, 1),
(52, 114, 2, 1),
(53, 113, 2, 1),
(54, 115, 2, 1),
(55, 8, 2, 1),
(56, 50, 2, 1),
(57, 9, 2, 1),
(58, 51, 2, 1),
(59, 96, 2, 1),
(60, 98, 2, 1),
(61, 97, 2, 1),
(62, 100, 2, 1),
(63, 102, 2, 1),
(64, 101, 2, 1),
(65, 103, 2, 1),
(66, 99, 2, 1),
(67, 64, 2, 1),
(68, 66, 2, 1),
(69, 65, 2, 1),
(70, 67, 2, 1),
(71, 124, 2, 1),
(72, 1, 2, 1),
(73, 3, 2, 1),
(74, 2, 2, 1),
(75, 4, 2, 1),
(76, 68, 2, 1),
(77, 70, 2, 1),
(78, 69, 2, 1),
(79, 71, 2, 1),
(80, 92, 2, 1),
(81, 94, 2, 1),
(82, 93, 2, 1),
(83, 95, 2, 1),
(84, 108, 2, 1),
(85, 110, 2, 1),
(86, 109, 2, 1),
(87, 111, 2, 1),
(88, 52, 2, 1),
(89, 54, 2, 1),
(90, 53, 2, 1),
(91, 55, 2, 1),
(92, 76, 2, 1),
(93, 78, 2, 1),
(94, 77, 2, 1),
(95, 79, 2, 1),
(96, 88, 2, 1),
(97, 90, 2, 1),
(98, 89, 2, 1),
(99, 91, 2, 1),
(100, 84, 2, 1),
(101, 86, 2, 1),
(102, 85, 2, 1),
(103, 87, 2, 1),
(104, 120, 2, 1),
(105, 122, 2, 1),
(106, 121, 2, 1),
(107, 80, 2, 1),
(108, 82, 2, 1),
(109, 81, 2, 1),
(110, 83, 2, 1),
(111, 123, 2, 1),
(274, 116, 7, 16),
(275, 118, 7, 16),
(276, 117, 7, 16),
(277, 119, 7, 16),
(278, 72, 7, 16),
(279, 74, 7, 16),
(280, 73, 7, 16),
(281, 75, 7, 16),
(282, 60, 7, 16),
(283, 62, 7, 16),
(284, 61, 7, 16),
(285, 63, 7, 16),
(286, 104, 7, 16),
(287, 106, 7, 16),
(288, 105, 7, 16),
(289, 107, 7, 16),
(290, 56, 7, 16),
(291, 58, 7, 16),
(292, 57, 7, 16),
(293, 59, 7, 16),
(294, 112, 7, 16),
(295, 114, 7, 16),
(296, 113, 7, 16),
(297, 115, 7, 16),
(298, 8, 7, 16),
(299, 50, 7, 16),
(300, 9, 7, 16),
(301, 51, 7, 16),
(302, 96, 7, 16),
(303, 98, 7, 16),
(304, 97, 7, 16),
(305, 100, 7, 16),
(306, 102, 7, 16),
(307, 101, 7, 16),
(308, 103, 7, 16),
(309, 99, 7, 16),
(310, 120, 7, 16),
(311, 122, 7, 16),
(312, 121, 7, 16),
(313, 123, 7, 16),
(314, 64, 7, 16),
(315, 66, 7, 16),
(316, 65, 7, 16),
(317, 67, 7, 16),
(318, 124, 7, 16),
(319, 1, 7, 16),
(320, 3, 7, 16),
(321, 2, 7, 16),
(322, 4, 7, 16),
(323, 68, 7, 16),
(324, 70, 7, 16),
(325, 69, 7, 16),
(326, 71, 7, 16),
(327, 92, 7, 16),
(328, 94, 7, 16),
(329, 93, 7, 16),
(330, 95, 7, 16),
(331, 108, 7, 16),
(332, 110, 7, 16),
(333, 109, 7, 16),
(334, 111, 7, 16),
(335, 52, 7, 16),
(336, 54, 7, 16),
(337, 53, 7, 16),
(338, 55, 7, 16),
(339, 76, 7, 16),
(340, 78, 7, 16),
(341, 77, 7, 16),
(342, 79, 7, 16),
(343, 88, 7, 16),
(344, 90, 7, 16),
(345, 89, 7, 16),
(346, 91, 7, 16),
(347, 84, 7, 16),
(348, 86, 7, 16),
(349, 85, 7, 16),
(350, 87, 7, 16),
(351, 80, 7, 16),
(352, 82, 7, 16),
(353, 81, 7, 16),
(354, 83, 7, 16);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT '0=Inactive,1=Inactive,2=Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'jigneshdodiya10@gmail.com', 'jigneshdodiya10@gmail.com', 'jigneshdodiya10@gmail.com', 'active', '2018-12-17 06:26:10', NULL, NULL, NULL),
(2, 'sanjay47c@gmail.com', 'sanjay47c@gmail.com', 'sanjay47c@gmail.com', 'active', '2018-12-16 18:30:00', NULL, 1, NULL),
(7, 'p@k.com', 'p@k.com', 'p@k.com', 'active', '2019-01-09 07:08:27', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 2),
(2, 6, 1),
(5, 16, 7);

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `status` enum('active','inactive','delete') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `series`
--

INSERT INTO `series` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'any', NULL, 'delete', '2018-11-30 13:00:00', 1, NULL, 1),
(2, 'abc', NULL, 'active', '2018-11-30 13:00:00', 1, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `speakers`
--

CREATE TABLE `speakers` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `zipcode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expertise` text COLLATE utf8mb4_unicode_ci,
  `about_speaker` text COLLATE utf8mb4_unicode_ci,
  `about_company` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `speakers`
--

INSERT INTO `speakers` (`id`, `company_id`, `first_name`, `last_name`, `email`, `password`, `contact_no`, `avatar`, `country_id`, `state_id`, `city_id`, `zipcode`, `expertise`, `about_speaker`, `about_company`, `created_by`, `modified_by`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'jignesh', 'dodiya', 'jigneshdodiya10@gmail.com', '$2y$10$VPZyPIZJdSPNNYbPrnY.NOsnCTzcHHz7EzGG2MQo2KAy9sv4ZluN6', '9979006185', '2018-10-23.png', 1, 1, 1, '380015', '<p>testing</p>', '<p>testing</p>', NULL, 0, 1, 'active', NULL, '2018-12-03 04:36:38', '2018-12-03 04:37:36'),
(2, 2, 'Prashant', 'Kansagara', 'prashant.kansagara@gmail.com', '11111111', '4569854475', '2018-10-23.png', 1, 1, 1, '256325', 'expertise', 'about_speaker', 'sd asdsa sa dasd sad asdas das dasd asd sdsa', 1, 0, 'active', NULL, '2018-12-20 18:30:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `speakers_password_resets`
--

CREATE TABLE `speakers_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `speaker_follow`
--

CREATE TABLE `speaker_follow` (
  `id` int(11) NOT NULL,
  `speaker_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `speaker_invitation`
--

CREATE TABLE `speaker_invitation` (
  `id` int(11) NOT NULL,
  `webinar_id` int(11) NOT NULL,
  `speaker_id` int(11) NOT NULL,
  `status` enum('accepted','pending','rejected') NOT NULL DEFAULT 'pending',
  `reason` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `speaker_invitation`
--

INSERT INTO `speaker_invitation` (`id`, `webinar_id`, `speaker_id`, `status`, `reason`, `created_at`, `updated_at`) VALUES
(8, 1, 3, 'pending', NULL, '2018-12-26 14:47:58', NULL),
(9, 17, 1, 'pending', NULL, '2018-12-26 00:28:25', NULL),
(10, 22, 1, 'pending', NULL, '2018-12-26 07:36:19', '2018-12-27 00:10:14'),
(11, 23, 1, 'pending', NULL, '2018-12-27 01:10:44', NULL),
(12, 24, 1, 'rejected', NULL, '2018-12-27 02:02:38', '2018-12-27 02:46:44');

-- --------------------------------------------------------

--
-- Table structure for table `speaker_ratings`
--

CREATE TABLE `speaker_ratings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ratings` double(2,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 => InActive, 1 => Active, 2 => Delete',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT 'inactive => InActive, active => Active, delete => Delete',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gujarat', 'active', 1, 0, '2018-12-03 04:35:11', '2018-12-03 04:35:11');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 => Admin, 1 => Speaker',
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag`, `user_type`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'Student', 0, 'active', 1, 0, '2018-12-03 07:06:15', '2018-12-03 07:06:15'),
(2, 'CA', 0, 'active', 1, 0, '2018-12-03 07:06:55', '2018-12-03 07:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `tag_user`
--

CREATE TABLE `tag_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tag_user`
--

INSERT INTO `tag_user` (`id`, `user_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2018-12-20 00:20:50', NULL),
(2, 2, 2, '2018-12-20 00:20:50', NULL),
(3, 3, 1, '2018-12-20 00:23:24', NULL),
(4, 3, 2, '2018-12-20 00:23:24', NULL),
(5, 4, 1, '2018-12-20 00:25:05', NULL),
(6, 4, 2, '2018-12-20 00:25:05', NULL),
(7, 1, 1, '2018-12-27 05:56:31', NULL),
(8, 1, 2, '2019-01-06 23:11:54', NULL),
(9, 1, 2, '2019-01-06 23:15:40', NULL),
(10, 2, 2, '2019-01-10 05:54:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tag_webinar`
--

CREATE TABLE `tag_webinar` (
  `id` int(10) UNSIGNED NOT NULL,
  `webinar_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `designation` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `first_name`, `last_name`, `email`, `avatar`, `description`, `designation`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'jignesh', 'Dodiya', 'jigneshdodiya10@gmail.com', '014A7QBWvyMJ7grTu2gqj5z6ZFAhh1by00BJEfRt.jpeg', '<p>developer</p>', 'developer', 'active', 1, 0, '2018-12-03 07:08:44', '2018-12-03 07:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firm_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `zipcode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_zone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type_id` int(11) DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ptin_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `contact_no`, `firm_name`, `country_id`, `state_id`, `city_id`, `zipcode`, `time_zone`, `user_type_id`, `designation`, `ptin_number`, `credit`, `created_by`, `modified_by`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'jignesh', 'dodiya', 'jigneshdodiya10@gmail.com', '$2y$10$k3s45zaJJR6nAjOoYZscvOyAsT7VG9xLSTANRiuJCoYyiKkR/ZNfi', '5656565656', 'test company', 1, 1, 1, '', 'Asia/Kolkata', 3, NULL, NULL, NULL, 0, 0, 'active', NULL, '2019-01-06 23:15:40', NULL),
(2, 'prashant', 'patel', 'p@k.com', '$2y$10$5svH6ckxY3orAjel.J.yVOCCTy7hUVEmJAoWIq3lpXa9gXgL6OZ4i', '1111111111', '1', 1, 1, 1, '', 'US/Samoa', 5, NULL, NULL, NULL, 0, 0, 'active', NULL, '2019-01-10 05:54:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_password_reset`
--

CREATE TABLE `user_password_reset` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_password_reset`
--

INSERT INTO `user_password_reset` (`id`, `email`, `token`, `created_at`) VALUES
(1, 'jigneshdodiya10@gmail.com', 'eyJpdiI6IkFwQndQbmp6ZnRMVE5hYkxrb1d3Ymc9PSIsInZhbHVlIjoiMjFoc3pYYWNnejJVMEM0VzdDMDgxOUNjTVJmQUJPUGlad2ZOXC9DYnJlbWdFZVwvb3VxZ2tqUzFZaE5YSDMyN1I2IiwibWFjIjoiYTk2ZjJlYTRkYWYwZTJjMDNkZGJhZDg2NzdlMGY0NjRmZjk1NWRjMGJmYzg0YjM4Nzg2NWE3YmIyNWQ3MTkxMiJ9', '2018-12-19 13:37:47'),
(2, 'jigneshdodiya10@gmail.com', 'eyJpdiI6Ik9OMVhOMW1IYWx1XC9hTVdcL3ZlYjBJUT09IiwidmFsdWUiOiJublBLYkhkd2RCaGZabjNCOHpxUk5FK29xXC9lYXcyWEpLd3VVXC9kY1dXbkFTN2prSXFEbkhOKzRYWk9SUmtDZVEiLCJtYWMiOiJlNjI0ZmNjZTQwMTJhYjg0NDFlOTdjNzA4YzBkNTg0MmI0OTJiZDk4NmNjNDc0Zjc2NzFmMWQwMDQ2ZDQzYjE1In0=', '2018-12-27 11:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive','delete') NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `name`, `status`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'cpa', 'active', 1, 0, '2018-12-05 13:00:00', NULL),
(2, 'enrolled agent', 'active', 1, 0, '2018-12-05 13:00:00', NULL),
(3, 'bookkeeper', 'active', 1, 0, '2018-12-05 13:00:00', NULL),
(4, 'attorney', 'active', 1, 0, '2018-12-05 13:00:00', NULL),
(5, 'cfo', 'active', 1, 0, '2018-12-05 13:00:00', NULL),
(6, 'business owner', 'active', 1, 0, '2018-12-05 13:00:00', NULL),
(7, 'other', 'active', 1, 0, '2018-12-05 13:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `webinars`
--

CREATE TABLE `webinars` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webinar_type` enum('live','archived','self_study') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webinar_transcription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentation_length` text COLLATE utf8mb4_unicode_ci,
  `learning_objectives` text COLLATE utf8mb4_unicode_ci,
  `Instructional_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_zone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recorded_date` date DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `subject_area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pre_requirement` text COLLATE utf8mb4_unicode_ci,
  `advance_preparation` text COLLATE utf8mb4_unicode_ci,
  `who_should_attend` text COLLATE utf8mb4_unicode_ci,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documents` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faq_1` text COLLATE utf8mb4_unicode_ci,
  `faq_2` text COLLATE utf8mb4_unicode_ci,
  `faq_3` text COLLATE utf8mb4_unicode_ci,
  `faq_4` text COLLATE utf8mb4_unicode_ci,
  `faq_5` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','delete','draft') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `video` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webinar_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vimeo_video_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vimeo_response` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vimeo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vimeo_embaded` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vimeo_password` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webinar_response` text COLLATE utf8mb4_unicode_ci,
  `series` int(11) DEFAULT NULL,
  `cpa_credit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `reason` text COLLATE utf8mb4_unicode_ci,
  `added_by` enum('admin','speaker') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `webinars`
--

INSERT INTO `webinars` (`id`, `title`, `webinar_type`, `description`, `image`, `fee`, `webinar_transcription`, `presentation_length`, `learning_objectives`, `Instructional_method`, `time_zone`, `recorded_date`, `start_time`, `end_time`, `subject_area`, `course_level`, `pre_requirement`, `advance_preparation`, `who_should_attend`, `tag`, `documents`, `faq_1`, `faq_2`, `faq_3`, `faq_4`, `faq_5`, `status`, `video`, `duration`, `webinar_key`, `vimeo_video_code`, `vimeo_response`, `vimeo_url`, `vimeo_embaded`, `vimeo_password`, `webinar_response`, `series`, `cpa_credit`, `reason`, `added_by`, `created_by`, `modified_by`, `created_at`, `updated_at`, `view_count`) VALUES
(1, 'testing new webinar', 'live', 'final testing new webinar', NULL, '2018-12-04', '03:30:00', '', NULL, NULL, 'US/Central', '2018-12-03', '2018-12-07 09:26:00', '2018-12-09 05:18:00', '2', '3', 'tyutyu', 'utyutyu', 'business owner', '', '', '<p>tyu</p>', '<p>tyuty</p>', '', '', '', 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '0', NULL, 'speaker', 1, 1, '2018-12-03 04:39:24', '2018-12-05 01:55:26', 0),
(2, 'test my first speaker webinar', 'archived', 'test my first speaker webinar', NULL, '23', 'sadsadsd asdasd saddsasd a', '34', NULL, NULL, NULL, '2018-12-04', '2018-12-04 14:11:15', '2018-12-04 17:15:30', 'CA with Banking', 'Advance', 'Yes', 'No', 'enrolled agent', '1,2', 'sadasdsadd.jpg', 'dfsdfdsfsd', 'sdfsdfsdf', 'sdfsdfsdf', 'sdfsdfsd', 'sdfsdfsdfs', 'active', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '0', NULL, 'speaker', 0, 1, '2018-12-03 18:30:00', NULL, 0),
(3, 'dfgdfgdfgdfg', NULL, '<p>gfdgfdgdf</p>', NULL, NULL, '34543543', '', NULL, NULL, NULL, '2018-12-05', '2018-12-05 11:55:48', '2018-12-05 11:25:48', '2,1', '4,3', 'fsdf fsdf', 'sdfsdfsdf', 'enrolled agent', '2,1', '15439881111522491451Jignesh.jpg', '<p>dsfsdfdf</p>', '<p>sdfsdfsdfsdfsdf</p>', '<p>sdfsdf</p>', '<p>sdfsdfs</p>', '<p>fsdfsdfsd</p>', 'delete', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '0', NULL, NULL, 0, 1, '2018-12-05 00:05:11', NULL, 0),
(4, 'dfgdfgdfgdfg', 'live', 'jignesh created and new webinar', NULL, '43534', '34543543', '', NULL, NULL, 'US/Central', '2018-12-05', '2018-12-08 11:55:48', '2018-12-09 11:25:48', '2,1', '4,3', 'fsdf fsdf', 'sdfsdfsdf', 'cpa', '2,1', '1543993605usa.jpg', '<p>dsfsdfdf</p>', '<p>sdfsdfsdfsdfsdf</p>', '<p>sdfsdf</p>', '<p>sdfsdfs</p>', '<p>fsdfsdfsd</p>', 'active', '', NULL, '8801831768699715339', '', '', '', '', NULL, NULL, NULL, '0', NULL, NULL, 0, 1, '2018-12-05 00:07:07', '2018-12-05 04:39:15', 0),
(5, 'dfgdfgdfgdfg', 'live', 'jignesh', NULL, '43534', '34543543', '', NULL, NULL, 'US/Mountain', '2018-12-05', '2018-12-05 11:55:48', '2018-12-05 11:25:48', '2,1', '4,3', 'fsdf fsdf', 'sdfsdfsdf', 'bookkeeper', '2,1', '154399216211.jpg', '<p>dsfsdfdf</p>', '<p>sdfsdfsdfsdfsdf</p>', '<p>sdfsdf</p>', '<p>sdfsdfs</p>', '<p>fsdfsdfsd</p>', 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '0', NULL, NULL, 0, 1, '2018-12-05 00:09:47', '2018-12-05 04:45:06', 0),
(6, 'prashant', 'live', '<p>any descrprtrtrrt</p>', NULL, '43534', '34543543', '', NULL, NULL, 'US/Hawaii', '2018-12-06', '2018-12-06 22:15:52', '2018-12-07 18:55:52', '2,1', '3,1', 'any', NULL, 'bookkeeper', '2,1', '1544010509download.png', NULL, NULL, NULL, NULL, NULL, 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '0', NULL, 'speaker', 1, 1, '2018-12-05 06:18:29', '2018-12-06 08:00:25', 0),
(7, 'jignesh', 'live', '<p>asdsad</p>', NULL, '423', 'rewrewr', '', NULL, NULL, 'US/Alaska', '2018-12-05', '2018-12-05 17:30:59', '2018-12-05 18:30:59', '1', '3', 'wrwerew', 'rwer', 'bookkeeper', '1', '1544011319nairobi.jpg', '<p>wer</p>', '<p>wer</p>', '<p>wer</p>', '<p>wer</p>', '<p>wer</p>', 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '0', NULL, NULL, 1, 0, '2018-12-05 06:31:59', NULL, 0),
(8, 'test self study', 'self_study', 'test video for website uplaod code', NULL, '3245', 'fsdfsdfdsf', '4', NULL, NULL, 'Pacific/Midway', '2018-12-06', NULL, NULL, '2', '3', 'retriever', 'trete', 'enrolled agent,attorney', '2', '1544071710new-york.jpg', 'ertret', 'ert', 'ret', 'ert', 'ert', 'active', '154407184715283885.mp4', NULL, NULL, '305210018', '{\"uri\":\"/videos/305210018\",\"name\":\"test self study\",\"description\":\"test video for website uplaod code\",\"link\":\"https://vimeo.com/305210018\",\"duration\":0,\"width\":400,\"language\":null,\"height\":300,\"embed\":{\"buttons\":{\"like\":true,\"watchlater\":true,\"share\":true,\"embed\":true,\"hd\":false,\"fullscreen\":true,\"scaling\":true},\"logos\":{\"vimeo\":true,\"custom\":{\"active\":false,\"link\":null,\"sticky\":false}},\"title\":{\"name\":\"user\",\"owner\":\"user\",\"portrait\":\"user\"},\"playbar\":true,\"volume\":true,\"speed\":false,\"color\":\"00adef\",\"uri\":null,\"html\":\"<iframe src=\\\"https://player.vimeo.com/video/305210018?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\\\" width=\\\"400\\\" height=\\\"300\\\" frameborder=\\\"0\\\" title=\\\"test self study\\\" allow=\\\"autoplay; fullscreen\\\" allowfullscreen></iframe>\",\"badges\":{\"hdr\":false,\"live\":{\"streaming\":false,\"archived\":false},\"staff_pick\":{\"normal\":false,\"best_of_the_month\":false,\"best_of_the_year\":false,\"premiere\":false},\"vod\":false,\"weekend_challenge\":false}},\"created_time\":\"2018-12-08T12:55:13+00:00\",\"modified_time\":\"2018-12-08T12:55:13+00:00\",\"release_time\":\"2018-12-08T12:55:13+00:00\",\"content_rating\":[\"unrated\"],\"license\":null,\"privacy\":{\"view\":\"password\",\"embed\":\"public\",\"download\":true,\"add\":true,\"comments\":\"anybody\"},\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":100,\"height\":75,\"link\":\"https://i.vimeocdn.com/video/default_100x75?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_100x75&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":200,\"height\":150,\"link\":\"https://i.vimeocdn.com/video/default_200x150?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_200x150&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":295,\"height\":166,\"link\":\"https://i.vimeocdn.com/video/default_295x166?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_295x166&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":640,\"height\":480,\"link\":\"https://i.vimeocdn.com/video/default_640x480?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_640x480&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":960,\"height\":720,\"link\":\"https://i.vimeocdn.com/video/default_960x720?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_960x720&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1280,\"height\":960,\"link\":\"https://i.vimeocdn.com/video/default_1280x960?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1280x960&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1920,\"height\":1440,\"link\":\"https://i.vimeocdn.com/video/default_1920x1440?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1920x1440&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"}],\"resource_key\":\"7a491d0e8cad256a8ac2fd6d207e647c1b034bad\"},\"tags\":[],\"stats\":{\"plays\":0},\"categories\":[],\"metadata\":{\"connections\":{\"comments\":{\"uri\":\"/videos/305210018/comments\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"credits\":{\"uri\":\"/videos/305210018/credits\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"likes\":{\"uri\":\"/videos/305210018/likes\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/videos/305210018/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"texttracks\":{\"uri\":\"/videos/305210018/texttracks\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"related\":null,\"recommendations\":{\"uri\":\"/videos/305210018/recommendations\",\"options\":[\"GET\"]}},\"interactions\":{\"watchlater\":{\"uri\":\"/users/92271093/watchlater/305210018?auth=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1Ijo5MjI3MTA5MywidXJpIjoiXC91c2Vyc1wvOTIyNzEwOTNcL3dhdGNobGF0ZXJcLzMwNTIxMDAxOCIsImV4cCI6MTU0NDI3NzMxM30.1xObTJnykqHopQ_7x9FssM6yvenlYbGB6ORiZINHo0Q\",\"options\":[\"GET\",\"PUT\",\"DELETE\"],\"added\":false,\"added_time\":null},\"report\":{\"uri\":\"/videos/305210018/report\",\"options\":[\"POST\"],\"reason\":[\"pornographic\",\"harassment\",\"advertisement\",\"ripoff\",\"incorrect rating\",\"spam\"]}}},\"user\":{\"uri\":\"/users/92271093\",\"name\":\"Gary Morya\",\"link\":\"https://vimeo.com/user92271093\",\"location\":null,\"bio\":null,\"created_time\":\"2018-11-29T16:57:20+00:00\",\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":30,\"height\":30,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_30x30.png\"},{\"width\":75,\"height\":75,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_75x75.png\"},{\"width\":100,\"height\":100,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_100x100.png\"},{\"width\":300,\"height\":300,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_300x300.png\"},{\"width\":72,\"height\":72,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_72x72.png\"},{\"width\":144,\"height\":144,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_144x144.png\"},{\"width\":216,\"height\":216,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_216x216.png\"},{\"width\":288,\"height\":288,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_288x288.png\"},{\"width\":360,\"height\":360,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_360x360.png\"}],\"resource_key\":\"06cd312fcc3908e2d839aeb00ccaaf434acb0859\"},\"websites\":[],\"metadata\":{\"connections\":{\"albums\":{\"uri\":\"/users/92271093/albums\",\"options\":[\"GET\"],\"total\":0},\"appearances\":{\"uri\":\"/users/92271093/appearances\",\"options\":[\"GET\"],\"total\":0},\"categories\":{\"uri\":\"/users/92271093/categories\",\"options\":[\"GET\"],\"total\":0},\"channels\":{\"uri\":\"/users/92271093/channels\",\"options\":[\"GET\"],\"total\":0},\"feed\":{\"uri\":\"/users/92271093/feed\",\"options\":[\"GET\"]},\"followers\":{\"uri\":\"/users/92271093/followers\",\"options\":[\"GET\"],\"total\":0},\"following\":{\"uri\":\"/users/92271093/following\",\"options\":[\"GET\"],\"total\":0},\"groups\":{\"uri\":\"/users/92271093/groups\",\"options\":[\"GET\"],\"total\":0},\"likes\":{\"uri\":\"/users/92271093/likes\",\"options\":[\"GET\"],\"total\":0},\"moderated_channels\":{\"uri\":\"/users/92271093/channels?filter=moderated\",\"options\":[\"GET\"],\"total\":0},\"portfolios\":{\"uri\":\"/users/92271093/portfolios\",\"options\":[\"GET\"],\"total\":0},\"videos\":{\"uri\":\"/users/92271093/videos\",\"options\":[\"GET\"],\"total\":4},\"watchlater\":{\"uri\":\"/users/92271093/watchlater\",\"options\":[\"GET\"],\"total\":0},\"shared\":{\"uri\":\"/users/92271093/shared/videos\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/users/92271093/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"watched_videos\":{\"uri\":\"/me/watched/videos\",\"options\":[\"GET\"],\"total\":2},\"folders\":{\"uri\":\"/me/folders\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"block\":{\"uri\":\"/me/block\",\"options\":[\"GET\"],\"total\":0}}},\"preferences\":{\"videos\":{\"privacy\":{\"view\":\"anybody\",\"comments\":\"anybody\",\"embed\":\"public\",\"download\":true,\"add\":true}}},\"content_filter\":[\"language\",\"drugs\",\"violence\",\"nudity\",\"safe\",\"unrated\"],\"upload_quota\":{\"space\":{\"free\":5310617120,\"max\":5368709120,\"used\":58092000,\"showing\":\"periodic\"},\"periodic\":{\"free\":5310617120,\"max\":5368709120,\"used\":58092000,\"reset_date\":\"2018-12-10 00:00:00\"},\"lifetime\":{\"free\":null,\"max\":null,\"used\":null}},\"resource_key\":\"3214185ecce3ee369a9eb45d28f65745f4485886\",\"account\":\"plus\"},\"review_page\":{\"active\":true,\"link\":\"https://vimeo.com/user92271093/review/305210018/1887c46685\"},\"parent_folder\":null,\"last_user_action_event_date\":\"2018-12-08T12:55:13+00:00\",\"app\":{\"name\":\"Mycpe\",\"uri\":\"/apps/138804\"},\"status\":\"transcode_starting\",\"resource_key\":\"50409b47a7b687dca976a601cb8a60adc09f1405\",\"upload\":{\"status\":\"in_progress\",\"upload_link\":null,\"form\":null,\"complete_uri\":null,\"approach\":\"pull\",\"size\":null,\"redirect_url\":null,\"link\":\"https://www.edge196.com/uploads/pitch_deck/video/1539156509The-Global-Startup-Ecosystem-Report-2017.mp4\"},\"transcode\":{\"status\":\"in_progress\"}}', 'https://vimeo.com/305210018', '<iframe src=\"https://player.vimeo.com/video/305210018?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\" width=\"400\" height=\"300\" frameborder=\"0\" title=\"test self study\" allow=\"autoplay; fullscreen\" allowfullscreen></iframe>', 'yFxe5nmU', NULL, NULL, '0', NULL, NULL, 1, 1, '2018-12-05 23:18:30', '2018-12-05 23:23:37', 0),
(9, 'prashant', 'live', '<p>sdfsdfsdf</p>', NULL, '6', '34543543', '456', NULL, NULL, 'Pacific/Midway', '2018-12-12', '2018-12-06 10:45:39', '2018-12-06 10:45:39', '2', '1', 'dfgfdg', 'fdgdfg', 'enrolled agent,bookkeeper,attorney', '2', '1544072587dhilabslogo.png', 'gfdgg', 'dfgfd', 'gdfgdf', 'gdfgdfg', 'dfgdfgfg', 'inactive', '154407259215283885.mp4', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '0', NULL, NULL, 1, 1, '2018-12-05 23:33:07', '2018-12-08 04:07:52', 0),
(10, 'admin can add', 'live', 'test my first speaker webinar', NULL, '5', '34543543', NULL, NULL, NULL, 'America/Lima', '2018-12-06', '2018-12-08 12:30:03', '2018-12-08 14:30:03', '', '4', '345435', '435erter', 'enrolled agent', '2', '1544079732usa.jpg', 'retret', 'retretret', 'retert', 'reterte', 'ertreter', 'active', '', NULL, '8911406898526070029', '', '', '', '', NULL, NULL, NULL, '0', NULL, NULL, 1, 1, '2018-12-06 01:32:12', '2018-12-08 04:57:00', 0),
(11, 'jignesh testing new webinar', 'live', 'final testing new webinar', NULL, '2', 'yrtytry', '56', NULL, NULL, 'US/Samoa', '2018-12-06', '2018-12-08 18:35:49', '2018-12-08 21:33:27', '2', '4', 'fhfg', 'hgfhfg', 'bookkeeper', '', '1544101758download.png', NULL, NULL, NULL, NULL, NULL, 'active', '154410176415283885.mp4', NULL, '7514827020109031692', '', '', '', '', NULL, NULL, NULL, '0', NULL, 'admin', 1, 1, '2018-12-06 07:39:18', '2018-12-06 07:40:07', 0),
(12, 'test by jignesh', 'live', 'for delete testing', NULL, '564', 'testing', NULL, NULL, NULL, 'US/Hawaii', '2018-12-10', '2018-12-10 21:50:37', '2018-12-10 22:50:37', '2', '4', 'testing', 'testing', '6', '2', '1544419467new-york.jpg', 'testing', 'testing', 'testing', 'testing', 'testing', 'inactive', '', NULL, '', '', '', '', '', NULL, '', NULL, '0', NULL, 'admin', 1, 1, '2018-12-09 23:54:27', '2018-12-10 01:08:34', 0),
(13, 'test self study', 'self_study', 'Description', NULL, '43', 'Webinar Transcription', '3', NULL, NULL, 'Pacific/Midway', '2018-12-10', '2018-12-18 00:00:00', '2018-12-31 00:00:00', '2', '4', 'dasdasd Requirement', 'dasd Preparation', '6', '2,1', '1544427558usa-250-140.jpg', 'dsad', 'asd', 'asd', 'asd', 'sad', 'active', '154442757015283885.mp4', NULL, NULL, '306326682', '{\"uri\":\"/videos/306326682\",\"name\":\"test self study\",\"description\":\"Description\",\"link\":\"https://vimeo.com/306326682\",\"duration\":0,\"width\":400,\"language\":null,\"height\":300,\"embed\":{\"buttons\":{\"like\":true,\"watchlater\":true,\"share\":true,\"embed\":true,\"hd\":false,\"fullscreen\":true,\"scaling\":true},\"logos\":{\"vimeo\":true,\"custom\":{\"active\":false,\"link\":null,\"sticky\":false}},\"title\":{\"name\":\"user\",\"owner\":\"user\",\"portrait\":\"user\"},\"playbar\":true,\"volume\":true,\"speed\":false,\"color\":\"00adef\",\"uri\":null,\"html\":\"<iframe src=\\\"https://player.vimeo.com/video/306326682?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\\\" width=\\\"400\\\" height=\\\"300\\\" frameborder=\\\"0\\\" title=\\\"test self study\\\" allow=\\\"autoplay; fullscreen\\\" allowfullscreen></iframe>\",\"badges\":{\"hdr\":false,\"live\":{\"streaming\":false,\"archived\":false},\"staff_pick\":{\"normal\":false,\"best_of_the_month\":false,\"best_of_the_year\":false,\"premiere\":false},\"vod\":false,\"weekend_challenge\":false}},\"created_time\":\"2018-12-14T05:37:44+00:00\",\"modified_time\":\"2018-12-14T05:37:44+00:00\",\"release_time\":\"2018-12-14T05:37:44+00:00\",\"content_rating\":[\"unrated\"],\"license\":null,\"privacy\":{\"view\":\"password\",\"embed\":\"public\",\"download\":true,\"add\":true,\"comments\":\"anybody\"},\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":100,\"height\":75,\"link\":\"https://i.vimeocdn.com/video/default_100x75?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_100x75&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":200,\"height\":150,\"link\":\"https://i.vimeocdn.com/video/default_200x150?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_200x150&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":295,\"height\":166,\"link\":\"https://i.vimeocdn.com/video/default_295x166?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_295x166&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":640,\"height\":480,\"link\":\"https://i.vimeocdn.com/video/default_640x480?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_640x480&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":960,\"height\":720,\"link\":\"https://i.vimeocdn.com/video/default_960x720?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_960x720&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1280,\"height\":960,\"link\":\"https://i.vimeocdn.com/video/default_1280x960?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1280x960&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1920,\"height\":1440,\"link\":\"https://i.vimeocdn.com/video/default_1920x1440?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1920x1440&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"}],\"resource_key\":\"7a491d0e8cad256a8ac2fd6d207e647c1b034bad\"},\"tags\":[],\"stats\":{\"plays\":0},\"categories\":[],\"metadata\":{\"connections\":{\"comments\":{\"uri\":\"/videos/306326682/comments\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"credits\":{\"uri\":\"/videos/306326682/credits\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"likes\":{\"uri\":\"/videos/306326682/likes\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/videos/306326682/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"texttracks\":{\"uri\":\"/videos/306326682/texttracks\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"related\":null,\"recommendations\":{\"uri\":\"/videos/306326682/recommendations\",\"options\":[\"GET\"]}},\"interactions\":{\"watchlater\":{\"uri\":\"/users/92271093/watchlater/306326682?auth=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1Ijo5MjI3MTA5MywidXJpIjoiXC91c2Vyc1wvOTIyNzEwOTNcL3dhdGNobGF0ZXJcLzMwNjMyNjY4MiIsImV4cCI6MTU0NDc2OTQ2NH0.48vYoPfNfIGUjcu5kJnStjnZh134E9s4qjE7L2ZxNtk\",\"options\":[\"GET\",\"PUT\",\"DELETE\"],\"added\":false,\"added_time\":null},\"report\":{\"uri\":\"/videos/306326682/report\",\"options\":[\"POST\"],\"reason\":[\"pornographic\",\"harassment\",\"advertisement\",\"ripoff\",\"incorrect rating\",\"spam\"]}}},\"user\":{\"uri\":\"/users/92271093\",\"name\":\"Gary Morya\",\"link\":\"https://vimeo.com/user92271093\",\"location\":null,\"bio\":null,\"created_time\":\"2018-11-29T16:57:20+00:00\",\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":30,\"height\":30,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_30x30.png\"},{\"width\":75,\"height\":75,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_75x75.png\"},{\"width\":100,\"height\":100,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_100x100.png\"},{\"width\":300,\"height\":300,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_300x300.png\"},{\"width\":72,\"height\":72,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_72x72.png\"},{\"width\":144,\"height\":144,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_144x144.png\"},{\"width\":216,\"height\":216,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_216x216.png\"},{\"width\":288,\"height\":288,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_288x288.png\"},{\"width\":360,\"height\":360,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_360x360.png\"}],\"resource_key\":\"06cd312fcc3908e2d839aeb00ccaaf434acb0859\"},\"websites\":[],\"metadata\":{\"connections\":{\"albums\":{\"uri\":\"/users/92271093/albums\",\"options\":[\"GET\"],\"total\":0},\"appearances\":{\"uri\":\"/users/92271093/appearances\",\"options\":[\"GET\"],\"total\":0},\"categories\":{\"uri\":\"/users/92271093/categories\",\"options\":[\"GET\"],\"total\":0},\"channels\":{\"uri\":\"/users/92271093/channels\",\"options\":[\"GET\"],\"total\":0},\"feed\":{\"uri\":\"/users/92271093/feed\",\"options\":[\"GET\"]},\"followers\":{\"uri\":\"/users/92271093/followers\",\"options\":[\"GET\"],\"total\":0},\"following\":{\"uri\":\"/users/92271093/following\",\"options\":[\"GET\"],\"total\":0},\"groups\":{\"uri\":\"/users/92271093/groups\",\"options\":[\"GET\"],\"total\":0},\"likes\":{\"uri\":\"/users/92271093/likes\",\"options\":[\"GET\"],\"total\":0},\"moderated_channels\":{\"uri\":\"/users/92271093/channels?filter=moderated\",\"options\":[\"GET\"],\"total\":0},\"portfolios\":{\"uri\":\"/users/92271093/portfolios\",\"options\":[\"GET\"],\"total\":0},\"videos\":{\"uri\":\"/users/92271093/videos\",\"options\":[\"GET\"],\"total\":6},\"watchlater\":{\"uri\":\"/users/92271093/watchlater\",\"options\":[\"GET\"],\"total\":0},\"shared\":{\"uri\":\"/users/92271093/shared/videos\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/users/92271093/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"watched_videos\":{\"uri\":\"/me/watched/videos\",\"options\":[\"GET\"],\"total\":4},\"folders\":{\"uri\":\"/me/folders\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"block\":{\"uri\":\"/me/block\",\"options\":[\"GET\"],\"total\":0}}},\"preferences\":{\"videos\":{\"privacy\":{\"view\":\"anybody\",\"comments\":\"anybody\",\"embed\":\"public\",\"download\":true,\"add\":true}}},\"content_filter\":[\"language\",\"drugs\",\"violence\",\"nudity\",\"safe\",\"unrated\"],\"upload_quota\":{\"space\":{\"free\":5329981120,\"max\":5368709120,\"used\":38728000,\"showing\":\"periodic\"},\"periodic\":{\"free\":5329981120,\"max\":5368709120,\"used\":38728000,\"reset_date\":\"2018-12-17 00:00:00\"},\"lifetime\":{\"free\":null,\"max\":null,\"used\":null}},\"resource_key\":\"3214185ecce3ee369a9eb45d28f65745f4485886\",\"account\":\"plus\"},\"review_page\":{\"active\":true,\"link\":\"https://vimeo.com/user92271093/review/306326682/e0647c0f2b\"},\"parent_folder\":null,\"last_user_action_event_date\":\"2018-12-14T05:37:44+00:00\",\"app\":{\"name\":\"Mycpe\",\"uri\":\"/apps/138804\"},\"status\":\"transcode_starting\",\"resource_key\":\"ecce7c5a1cb78a84c2d4c0e6d37ccd5796b8736f\",\"upload\":{\"status\":\"in_progress\",\"upload_link\":null,\"form\":null,\"complete_uri\":null,\"approach\":\"pull\",\"size\":null,\"redirect_url\":null,\"link\":\"https://www.edge196.com/uploads/pitch_deck/video/1539156509The-Global-Startup-Ecosystem-Report-2017.mp4\"},\"transcode\":{\"status\":\"in_progress\"}}', 'https://vimeo.com/306326682', '<iframe src=\"https://player.vimeo.com/video/306326682?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\" width=\"400\" height=\"300\" frameborder=\"0\" title=\"test self study\" allow=\"autoplay; fullscreen\" allowfullscreen></iframe>', 'A7ixeFSD', NULL, NULL, '0', NULL, NULL, 1, 1, '2018-12-10 02:09:18', '2018-12-13 23:24:30', 0),
(14, 'Learn PHP and manage website', 'live', 'Learn PHP and manage website Learn PHP and manage website Learn PHP and manage website', NULL, '43543', 'Webinar Transcription', NULL, NULL, NULL, 'US/Hawaii', '2018-12-13', '2018-12-13 04:50:56', '2018-12-13 05:30:56', '2', '3', 'Pre Requirement', 'Advance Preparation', '3', '1', '1544443294usa.jpg', NULL, NULL, NULL, NULL, NULL, 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '0', NULL, 'speaker', 1, 1, '2018-12-10 06:31:34', '2018-12-10 07:06:01', 0),
(15, 'jignesh create new webinar for check delete', 'live', 'jignesh create new webinar for check delete', NULL, '435', 'Webinar Transcription', NULL, NULL, NULL, 'US/Hawaii', '2018-12-14', '2018-12-14 03:45:38', '2018-12-14 15:20:38', '2', '4', 'jignesh create new webinar for check delete', 'jignesh create new webinar for check delete', '4', '2', '1544702040download.png', 'jignesh create new webinar for check delete', 'jignesh create new webinar for check delete', 'jignesh create new webinar for check delete', 'jignesh create new webinar for check delete', 'jignesh create new webinar for check delete', 'inactive', '', NULL, '', '', '', '', '', NULL, '', 2, '0', NULL, 'admin', 1, 1, '2018-12-13 06:24:00', '2018-12-13 07:21:14', 0),
(16, 'sdsad', 'live', 'asdasdasd', NULL, '2342', NULL, NULL, NULL, NULL, 'US/Samoa', '2018-12-18', '2018-12-18 05:30:15', '2018-12-18 06:15:15', '2', '4', 'dasdsa', 'dasdasd', '4', '2', '154505088111.jpg', 'sadasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '0', NULL, 'admin', 1, NULL, '2018-12-17 07:18:01', NULL, 0),
(17, 'test for title', 'live', '<h3>Course Description</h3>\r\n              <p>Brands, because of their success and/or widespread recognition tend to be infringed by third parties. Some trademark owners, because of budget restraints or lack of funds, may be unable to enforce their valid trademarks against these third-party infringers. As such, this course seeks to alleviate their angst in enforcing their trademarks. This course seeks to present these trademark owners with possible litigation venues and scenarios</p>\r\n              <h3>Learning Objectives</h3>\r\n              <ol class=\"list\">\r\n                <li>Learn foundational trademark knowledge required for a better understanding of the key concepts regarding trademarks</li>\r\n                <li>Understand the different venues where they can enforce their trademarks within a reasonable budget</li>\r\n                <li>Discover how to get the Federal Government assist in their trademark’s enforcement</li>\r\n                <li>Learn available remedies for successful trademark enforcement</li>\r\n                <li>Understand contingency trademark litigation options; Essential conditions for attorney adoption of trademark litigation on contingency</li>\r\n              </ol>', NULL, NULL, NULL, NULL, NULL, NULL, 'Europe/Copenhagen', '2018-12-25', '2018-12-25 14:45:11', '2018-12-25 18:50:01', '2,1', '4,3,1', 'asdasdasd', 'asdasdas', '4,3,6,5', '2,1', '1545734938usa-250-140.jpg', 'faq1', 'faq2', NULL, 'faq4', 'faq5', 'active', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '0', NULL, 'speaker', 1, 1, '2018-12-20 01:14:01', '2018-12-25 05:18:58', 0),
(18, 'Create webinar for co operator', 'live', 'Create webinar for co operator', NULL, NULL, NULL, NULL, NULL, NULL, 'Europe/Berlin', '2018-12-26', '2018-12-26 15:50:11', '2018-12-27 00:15:11', '1', '3,1', 'Create webinar for co operator', 'Create webinar for co operator', '2', '1', '1545821415nairobi.jpg', 'Legal definitions and principals involving estates and trusts', 'Legal definitions and principals involving estates and trusts', 'Legal definitions and principals involving estates and trusts', 'Legal definitions and principals involving estates and trusts', 'Legal definitions and principals involving estates and trusts', 'active', '', NULL, '6524386946232192525', '', '', '', '', NULL, '{\"webinarKey\":\"6524386946232192525\"}', NULL, '5', '', 'speaker', 1, 1, '2018-12-26 05:20:15', '2018-12-26 05:21:05', 0),
(19, 'Create webinar for co operator jignesh', 'live', 'Create webinar for co operator jignesh', NULL, '100', NULL, NULL, NULL, NULL, 'Asia/Kolkata', '2018-12-26', '2018-12-26 11:15:55', '2018-12-26 11:25:55', '1', '1', 'Create webinar for co operator jignesh', 'Create webinar for co operator jignesh', '6', '2', '1545822210usa.jpg', 'Basic principles regarding property ownership', 'Basic principles regarding property ownership', 'Basic principles regarding property ownership', 'Basic principles regarding property ownership', 'Basic principles regarding property ownership', 'active', '', NULL, '7917232883136243211', '', '', '', '', NULL, '{\"webinarKey\":\"7917232883136243211\"}', NULL, '45', '', 'speaker', 1, 1, '2018-12-26 05:33:30', '2018-12-26 05:34:17', 0),
(20, 'Create webinar for co operator jignesh to prashant', 'live', 'Create webinar for co operator jignesh to prashant', NULL, NULL, NULL, NULL, NULL, NULL, 'Asia/Kolkata', '2018-12-26', '2018-12-26 11:40:41', '2018-12-26 12:20:41', '1', '3,1', 'Create webinar for co operator jignesh to prashant', 'Create webinar for co operator jignesh to prashant', '3', '1', '1545823682new-york.jpg', 'Create webinar for co operator jignesh to prashant', 'Create webinar for co operator jignesh to prashant', 'Create webinar for co operator jignesh to prashant', 'Create webinar for co operator jignesh to prashant', 'Create webinar for co operator jignesh to prashant', 'active', '', NULL, '5814606011014999052', '', '', '', '', NULL, '{\"webinarKey\":\"5814606011014999052\"}', NULL, '4', '', 'speaker', 1, 1, '2018-12-26 05:58:02', '2018-12-26 05:58:55', 0),
(21, 'Final test for co-organizer', 'live', 'Final test for co-organizer', NULL, NULL, NULL, NULL, NULL, NULL, 'Asia/Kolkata', '2018-12-26', '2018-12-26 12:44:12', '2018-12-27 17:15:12', '1', '3', 'Final test for co-organizer', 'Final test for co-organizer', '3', '1', '1545827540nairobi.jpg', 'Final test for co-organizer', 'Final test for co-organizer', 'Final test for co-organizer', 'Final test for co-organizer', 'Final test for co-organizer', 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '6', NULL, 'speaker', 1, NULL, '2018-12-26 07:02:20', NULL, 0),
(22, 'Final test for co organizer', 'live', 'Final test for co organizer', NULL, NULL, NULL, NULL, NULL, NULL, 'Asia/Kolkata', '2018-12-26', '2018-12-28 22:45:27', '2018-12-29 23:20:27', '2', '3,1', 'Final test for co organizer', 'Final test for co organizer', '3', '1', '1545827983new-york.jpg', 'Final test for co organizer', 'Final test for co organizer', 'Final test for co organizer', 'Final test for co organizer', 'Final test for co organizer', 'active', '', NULL, '4815982271670239499', '', '', '', '', NULL, '{\"webinarKey\":\"4815982271670239499\"}', NULL, '6', '', 'speaker', 1, 1, '2018-12-26 07:09:43', '2018-12-26 07:29:57', 0),
(23, 'Test for invitation', 'live', 'Test for invitation', NULL, NULL, NULL, NULL, NULL, NULL, 'Asia/Kolkata', '2018-12-27', '2018-12-27 06:45:37', '2018-12-27 07:25:37', '2', '3', 'Test for invitation', 'Test for invitation', '6', '1', '1545892486nairobi.jpg', 'Test for invitation', 'Test for invitation', 'Test for invitation', 'Test for invitation', 'Test for invitation', 'active', '', NULL, '3288361497984776459', '', '', '', '', NULL, '{\"webinarKey\":\"3288361497984776459\"}', NULL, '6', '', 'speaker', 1, 1, '2018-12-27 01:04:46', '2018-12-27 01:10:00', 0),
(24, 'Add Webinar', 'live', 'Add Webinar', NULL, NULL, NULL, NULL, NULL, NULL, 'Asia/Kolkata', '2018-12-27', '2018-12-28 22:45:28', '2018-12-29 23:20:28', '1', '3', 'Add Webinar', 'Add Webinar', '3', '1', '1545895896download.png', NULL, NULL, NULL, NULL, NULL, 'active', '', NULL, '117245718665653773', '', '', '', '', NULL, '{\"webinarKey\":\"117245718665653773\"}', NULL, '6', '', 'speaker', 1, 1, '2018-12-27 02:01:36', '2018-12-27 02:02:05', 0),
(25, 'self study webinar test by jignesh', 'self_study', 'self study webinar test by jignesh', NULL, NULL, NULL, '1', NULL, NULL, 'Asia/Kolkata', '2018-12-28', NULL, NULL, '2', '3', 'self study webinar test by jignesh', 'self study webinar test by jignesh', '6', '1', '1546002782nairobi.jpg', 'self study webinar test by jignesh', 'self study webinar test by jignesh', 'self study webinar test by jignesh', 'self study webinar test by jignesh', 'self study webinar test by jignesh', 'active', '154605913615283885.mp4', '30', NULL, '308643429', '{\"uri\":\"/videos/308643429\",\"name\":\"self study webinar test by jignesh\",\"description\":\"self study webinar test by jignesh\",\"link\":\"https://vimeo.com/308643429\",\"duration\":0,\"width\":400,\"language\":null,\"height\":300,\"embed\":{\"buttons\":{\"like\":true,\"watchlater\":true,\"share\":true,\"embed\":true,\"hd\":false,\"fullscreen\":true,\"scaling\":true},\"logos\":{\"vimeo\":true,\"custom\":{\"active\":false,\"link\":null,\"sticky\":false}},\"title\":{\"name\":\"user\",\"owner\":\"user\",\"portrait\":\"user\"},\"playbar\":true,\"volume\":true,\"speed\":false,\"color\":\"00adef\",\"uri\":null,\"html\":\"<iframe src=\\\"https://player.vimeo.com/video/308643429?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\\\" width=\\\"400\\\" height=\\\"300\\\" frameborder=\\\"0\\\" title=\\\"self study webinar test by jignesh\\\" allow=\\\"autoplay; fullscreen\\\" allowfullscreen></iframe>\",\"badges\":{\"hdr\":false,\"live\":{\"streaming\":false,\"archived\":false},\"staff_pick\":{\"normal\":false,\"best_of_the_month\":false,\"best_of_the_year\":false,\"premiere\":false},\"vod\":false,\"weekend_challenge\":false}},\"created_time\":\"2018-12-29T04:56:57+00:00\",\"modified_time\":\"2018-12-29T04:56:58+00:00\",\"release_time\":\"2018-12-29T04:56:57+00:00\",\"content_rating\":[\"unrated\"],\"license\":null,\"privacy\":{\"view\":\"password\",\"embed\":\"public\",\"download\":true,\"add\":true,\"comments\":\"anybody\"},\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":100,\"height\":75,\"link\":\"https://i.vimeocdn.com/video/default_100x75?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_100x75&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":200,\"height\":150,\"link\":\"https://i.vimeocdn.com/video/default_200x150?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_200x150&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":295,\"height\":166,\"link\":\"https://i.vimeocdn.com/video/default_295x166?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_295x166&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":640,\"height\":480,\"link\":\"https://i.vimeocdn.com/video/default_640x480?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_640x480&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":960,\"height\":720,\"link\":\"https://i.vimeocdn.com/video/default_960x720?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_960x720&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1280,\"height\":960,\"link\":\"https://i.vimeocdn.com/video/default_1280x960?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1280x960&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1920,\"height\":1440,\"link\":\"https://i.vimeocdn.com/video/default_1920x1440?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1920x1440&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"}],\"resource_key\":\"7a491d0e8cad256a8ac2fd6d207e647c1b034bad\"},\"tags\":[],\"stats\":{\"plays\":0},\"categories\":[],\"metadata\":{\"connections\":{\"comments\":{\"uri\":\"/videos/308643429/comments\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"credits\":{\"uri\":\"/videos/308643429/credits\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"likes\":{\"uri\":\"/videos/308643429/likes\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/videos/308643429/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"texttracks\":{\"uri\":\"/videos/308643429/texttracks\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"related\":null,\"recommendations\":{\"uri\":\"/videos/308643429/recommendations\",\"options\":[\"GET\"]}},\"interactions\":{\"watchlater\":{\"uri\":\"/users/92271093/watchlater/308643429?auth=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1Ijo5MjI3MTA5MywidXJpIjoiXC91c2Vyc1wvOTIyNzEwOTNcL3dhdGNobGF0ZXJcLzMwODY0MzQyOSIsImV4cCI6MTU0NjA2MzAxOH0.vaEAKMg7soVSs7pn64T1G6lMT_jSsqk9SwTk1vq8LNk\",\"options\":[\"GET\",\"PUT\",\"DELETE\"],\"added\":false,\"added_time\":null},\"report\":{\"uri\":\"/videos/308643429/report\",\"options\":[\"POST\"],\"reason\":[\"pornographic\",\"harassment\",\"advertisement\",\"ripoff\",\"incorrect rating\",\"spam\"]}}},\"user\":{\"uri\":\"/users/92271093\",\"name\":\"Gary Morya\",\"link\":\"https://vimeo.com/user92271093\",\"location\":null,\"bio\":null,\"created_time\":\"2018-11-29T16:57:20+00:00\",\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":30,\"height\":30,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_30x30.png\"},{\"width\":75,\"height\":75,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_75x75.png\"},{\"width\":100,\"height\":100,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_100x100.png\"},{\"width\":300,\"height\":300,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_300x300.png\"},{\"width\":72,\"height\":72,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_72x72.png\"},{\"width\":144,\"height\":144,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_144x144.png\"},{\"width\":216,\"height\":216,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_216x216.png\"},{\"width\":288,\"height\":288,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_288x288.png\"},{\"width\":360,\"height\":360,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_360x360.png\"}],\"resource_key\":\"06cd312fcc3908e2d839aeb00ccaaf434acb0859\"},\"websites\":[],\"metadata\":{\"connections\":{\"albums\":{\"uri\":\"/users/92271093/albums\",\"options\":[\"GET\"],\"total\":0},\"appearances\":{\"uri\":\"/users/92271093/appearances\",\"options\":[\"GET\"],\"total\":0},\"categories\":{\"uri\":\"/users/92271093/categories\",\"options\":[\"GET\"],\"total\":0},\"channels\":{\"uri\":\"/users/92271093/channels\",\"options\":[\"GET\"],\"total\":0},\"feed\":{\"uri\":\"/users/92271093/feed\",\"options\":[\"GET\"]},\"followers\":{\"uri\":\"/users/92271093/followers\",\"options\":[\"GET\"],\"total\":0},\"following\":{\"uri\":\"/users/92271093/following\",\"options\":[\"GET\"],\"total\":0},\"groups\":{\"uri\":\"/users/92271093/groups\",\"options\":[\"GET\"],\"total\":0},\"likes\":{\"uri\":\"/users/92271093/likes\",\"options\":[\"GET\"],\"total\":0},\"moderated_channels\":{\"uri\":\"/users/92271093/channels?filter=moderated\",\"options\":[\"GET\"],\"total\":0},\"portfolios\":{\"uri\":\"/users/92271093/portfolios\",\"options\":[\"GET\"],\"total\":0},\"videos\":{\"uri\":\"/users/92271093/videos\",\"options\":[\"GET\"],\"total\":18},\"watchlater\":{\"uri\":\"/users/92271093/watchlater\",\"options\":[\"GET\"],\"total\":0},\"shared\":{\"uri\":\"/users/92271093/shared/videos\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/users/92271093/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"watched_videos\":{\"uri\":\"/me/watched/videos\",\"options\":[\"GET\"],\"total\":7},\"folders\":{\"uri\":\"/me/folders\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"block\":{\"uri\":\"/me/block\",\"options\":[\"GET\"],\"total\":0}}},\"preferences\":{\"videos\":{\"privacy\":{\"view\":\"anybody\",\"comments\":\"anybody\",\"embed\":\"public\",\"download\":true,\"add\":true}}},\"content_filter\":[\"language\",\"drugs\",\"violence\",\"nudity\",\"safe\",\"unrated\"],\"upload_quota\":{\"space\":{\"free\":5368709120,\"max\":5368709120,\"used\":0,\"showing\":\"periodic\"},\"periodic\":{\"free\":5368709120,\"max\":5368709120,\"used\":0,\"reset_date\":\"2018-12-31 00:00:00\"},\"lifetime\":{\"free\":null,\"max\":null,\"used\":null}},\"resource_key\":\"3214185ecce3ee369a9eb45d28f65745f4485886\",\"account\":\"plus\"},\"review_page\":{\"active\":true,\"link\":\"https://vimeo.com/user92271093/review/308643429/0a7271eefa\"},\"parent_folder\":null,\"last_user_action_event_date\":\"2018-12-29T04:56:58+00:00\",\"app\":{\"name\":\"Mycpe\",\"uri\":\"/apps/138804\"},\"status\":\"transcode_starting\",\"resource_key\":\"928e78c295541c783c0168637f2a04a553896888\",\"upload\":{\"status\":\"in_progress\",\"upload_link\":null,\"form\":null,\"complete_uri\":null,\"approach\":\"pull\",\"size\":null,\"redirect_url\":null,\"link\":\"http://mycpa.local/uploads/webinar_video/154605913615283885.mp4\"},\"transcode\":{\"status\":\"in_progress\"}}', 'https://vimeo.com/308643429', '<iframe src=\"https://player.vimeo.com/video/307663031\" width=\"640\" height=\"360\" frameborder=\"0\" id=\"playiframe\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>', 'igd5mHG9', NULL, NULL, '7', '', 'speaker', 1, 1, '2018-12-28 07:43:02', '2018-12-28 23:22:16', 0),
(26, 'tes for add attenddes', 'live', 'tes for add attenddes', NULL, '10', NULL, NULL, NULL, NULL, 'Asia/Kolkata', '2019-01-03', '2019-01-03 10:30:32', '2019-01-03 17:35:32', '2', '3', 'tes for add attenddes', 'tes for add attenddes', '3', '1', '1546425098nairobi.jpg', NULL, NULL, NULL, NULL, NULL, 'active', '', NULL, '3686018570003884813', '', '', '', '', NULL, '{\"webinarKey\":\"3686018570003884813\"}', NULL, '70', '', 'speaker', 1, 1, '2019-01-02 05:01:38', '2019-01-02 05:02:03', 0),
(27, 'asdasdasd sdasdas a', 'live', 'asdasdasd sdasdas a', NULL, '5', NULL, NULL, NULL, NULL, 'Asia/Kolkata', '2019-01-02', '2019-01-02 11:20:19', '2019-01-02 18:25:19', '2', '3', 'asdasdasd sdasdas a', 'asdasdasd sdasdas a', '3', '1', '1546427890nairobi.jpg', NULL, NULL, NULL, NULL, NULL, 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '56', NULL, 'speaker', 1, NULL, '2019-01-02 05:48:10', NULL, 0),
(28, 'jay mataji mota', 'live', 'ejjat to kaharij', NULL, '5', NULL, NULL, NULL, NULL, 'America/Tijuana', '2019-01-04', '2019-01-04 01:10:32', '2019-01-04 07:10:32', '1', '3', NULL, NULL, '5', '2', '15464292861522491451Jignesh.jpg', NULL, NULL, NULL, NULL, NULL, 'active', '', NULL, '343624167844974347', '', '', '', '', NULL, '{\"webinarKey\":\"343624167844974347\"}', NULL, '12', '', 'speaker', 1, 1, '2019-01-02 06:11:26', '2019-01-02 06:11:59', 0),
(29, 'mafat webinar', 'archived', '<p>trett</p>', NULL, NULL, NULL, '12', NULL, NULL, 'US/Samoa', '2019-01-05', '2019-01-05 04:45:19', '2019-01-05 10:55:19', '1', '3', '11', '11', '2', '', '1548067710logo.png', NULL, NULL, NULL, NULL, NULL, 'inactive', '1548067538videoplayback.mp4', NULL, '8042152797370328333', '', '', '', '', NULL, '{\"webinarKey\":\"8042152797370328333\"}', 2, '12', '', 'speaker', 1, 1, '2019-01-02 06:47:57', '2019-01-21 05:18:30', 0);
INSERT INTO `webinars` (`id`, `title`, `webinar_type`, `description`, `image`, `fee`, `webinar_transcription`, `presentation_length`, `learning_objectives`, `Instructional_method`, `time_zone`, `recorded_date`, `start_time`, `end_time`, `subject_area`, `course_level`, `pre_requirement`, `advance_preparation`, `who_should_attend`, `tag`, `documents`, `faq_1`, `faq_2`, `faq_3`, `faq_4`, `faq_5`, `status`, `video`, `duration`, `webinar_key`, `vimeo_video_code`, `vimeo_response`, `vimeo_url`, `vimeo_embaded`, `vimeo_password`, `webinar_response`, `series`, `cpa_credit`, `reason`, `added_by`, `created_by`, `modified_by`, `created_at`, `updated_at`, `view_count`) VALUES
(30, 'test by pk mafat', 'self_study', 'qaaaa', NULL, NULL, NULL, '111', NULL, NULL, 'US/Alaska', '2019-01-05', NULL, NULL, '2', '3', NULL, NULL, '5', '1', '15464316332018-10-23.png', NULL, NULL, NULL, NULL, NULL, 'active', '154643166715283885.mp4', '30', NULL, '309089585', '{\"uri\":\"/videos/309089585\",\"name\":\"testbypkmafat\",\"description\":null,\"link\":\"https://vimeo.com/309089585\",\"duration\":0,\"width\":400,\"language\":null,\"height\":300,\"embed\":{\"buttons\":{\"like\":true,\"watchlater\":true,\"share\":true,\"embed\":true,\"hd\":false,\"fullscreen\":true,\"scaling\":true},\"logos\":{\"vimeo\":true,\"custom\":{\"active\":false,\"link\":null,\"sticky\":false}},\"title\":{\"name\":\"user\",\"owner\":\"user\",\"portrait\":\"user\"},\"playbar\":true,\"volume\":true,\"speed\":false,\"color\":\"00adef\",\"uri\":null,\"html\":\"<iframe src=\\\"https://player.vimeo.com/video/309089585?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\\\" width=\\\"400\\\" height=\\\"300\\\" frameborder=\\\"0\\\" title=\\\"testbypkmafat\\\" allow=\\\"autoplay; fullscreen\\\" allowfullscreen></iframe>\",\"badges\":{\"hdr\":false,\"live\":{\"streaming\":false,\"archived\":false},\"staff_pick\":{\"normal\":false,\"best_of_the_month\":false,\"best_of_the_year\":false,\"premiere\":false},\"vod\":false,\"weekend_challenge\":false}},\"created_time\":\"2019-01-02T12:29:54+00:00\",\"modified_time\":\"2019-01-02T12:29:54+00:00\",\"release_time\":\"2019-01-02T12:29:54+00:00\",\"content_rating\":[\"unrated\"],\"license\":null,\"privacy\":{\"view\":\"password\",\"embed\":\"public\",\"download\":true,\"add\":true,\"comments\":\"anybody\"},\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":100,\"height\":75,\"link\":\"https://i.vimeocdn.com/video/default_100x75?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_100x75&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":200,\"height\":150,\"link\":\"https://i.vimeocdn.com/video/default_200x150?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_200x150&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":295,\"height\":166,\"link\":\"https://i.vimeocdn.com/video/default_295x166?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_295x166&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":640,\"height\":480,\"link\":\"https://i.vimeocdn.com/video/default_640x480?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_640x480&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":960,\"height\":720,\"link\":\"https://i.vimeocdn.com/video/default_960x720?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_960x720&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1280,\"height\":960,\"link\":\"https://i.vimeocdn.com/video/default_1280x960?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1280x960&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1920,\"height\":1440,\"link\":\"https://i.vimeocdn.com/video/default_1920x1440?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1920x1440&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"}],\"resource_key\":\"7a491d0e8cad256a8ac2fd6d207e647c1b034bad\"},\"tags\":[],\"stats\":{\"plays\":0},\"categories\":[],\"metadata\":{\"connections\":{\"comments\":{\"uri\":\"/videos/309089585/comments\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"credits\":{\"uri\":\"/videos/309089585/credits\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"likes\":{\"uri\":\"/videos/309089585/likes\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/videos/309089585/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"texttracks\":{\"uri\":\"/videos/309089585/texttracks\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"related\":null,\"recommendations\":{\"uri\":\"/videos/309089585/recommendations\",\"options\":[\"GET\"]}},\"interactions\":{\"watchlater\":{\"uri\":\"/users/92271093/watchlater/309089585?auth=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1Ijo5MjI3MTA5MywidXJpIjoiXC91c2Vyc1wvOTIyNzEwOTNcL3dhdGNobGF0ZXJcLzMwOTA4OTU4NSIsImV4cCI6MTU0NjQzNTc5NH0.r4zP68blvaQv2iCA0uOQjCD8DTcqK7H-RdRDR3EBcfs\",\"options\":[\"GET\",\"PUT\",\"DELETE\"],\"added\":false,\"added_time\":null},\"report\":{\"uri\":\"/videos/309089585/report\",\"options\":[\"POST\"],\"reason\":[\"pornographic\",\"harassment\",\"advertisement\",\"ripoff\",\"incorrect rating\",\"spam\"]}}},\"user\":{\"uri\":\"/users/92271093\",\"name\":\"Gary Morya\",\"link\":\"https://vimeo.com/user92271093\",\"location\":null,\"bio\":null,\"created_time\":\"2018-11-29T16:57:20+00:00\",\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":30,\"height\":30,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_30x30.png\"},{\"width\":75,\"height\":75,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_75x75.png\"},{\"width\":100,\"height\":100,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_100x100.png\"},{\"width\":300,\"height\":300,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_300x300.png\"},{\"width\":72,\"height\":72,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_72x72.png\"},{\"width\":144,\"height\":144,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_144x144.png\"},{\"width\":216,\"height\":216,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_216x216.png\"},{\"width\":288,\"height\":288,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_288x288.png\"},{\"width\":360,\"height\":360,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_360x360.png\"}],\"resource_key\":\"06cd312fcc3908e2d839aeb00ccaaf434acb0859\"},\"websites\":[],\"metadata\":{\"connections\":{\"albums\":{\"uri\":\"/users/92271093/albums\",\"options\":[\"GET\"],\"total\":0},\"appearances\":{\"uri\":\"/users/92271093/appearances\",\"options\":[\"GET\"],\"total\":0},\"categories\":{\"uri\":\"/users/92271093/categories\",\"options\":[\"GET\"],\"total\":0},\"channels\":{\"uri\":\"/users/92271093/channels\",\"options\":[\"GET\"],\"total\":0},\"feed\":{\"uri\":\"/users/92271093/feed\",\"options\":[\"GET\"]},\"followers\":{\"uri\":\"/users/92271093/followers\",\"options\":[\"GET\"],\"total\":0},\"following\":{\"uri\":\"/users/92271093/following\",\"options\":[\"GET\"],\"total\":0},\"groups\":{\"uri\":\"/users/92271093/groups\",\"options\":[\"GET\"],\"total\":0},\"likes\":{\"uri\":\"/users/92271093/likes\",\"options\":[\"GET\"],\"total\":0},\"moderated_channels\":{\"uri\":\"/users/92271093/channels?filter=moderated\",\"options\":[\"GET\"],\"total\":0},\"portfolios\":{\"uri\":\"/users/92271093/portfolios\",\"options\":[\"GET\"],\"total\":0},\"videos\":{\"uri\":\"/users/92271093/videos\",\"options\":[\"GET\"],\"total\":19},\"watchlater\":{\"uri\":\"/users/92271093/watchlater\",\"options\":[\"GET\"],\"total\":0},\"shared\":{\"uri\":\"/users/92271093/shared/videos\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/users/92271093/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"watched_videos\":{\"uri\":\"/me/watched/videos\",\"options\":[\"GET\"],\"total\":9},\"folders\":{\"uri\":\"/me/folders\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"block\":{\"uri\":\"/me/block\",\"options\":[\"GET\"],\"total\":0}}},\"preferences\":{\"videos\":{\"privacy\":{\"view\":\"anybody\",\"comments\":\"anybody\",\"embed\":\"public\",\"download\":true,\"add\":true}}},\"content_filter\":[\"language\",\"drugs\",\"violence\",\"nudity\",\"safe\",\"unrated\"],\"upload_quota\":{\"space\":{\"free\":5146244733,\"max\":5368709120,\"used\":222464387,\"showing\":\"periodic\"},\"periodic\":{\"free\":5146244733,\"max\":5368709120,\"used\":222464387,\"reset_date\":\"2019-01-07 00:00:00\"},\"lifetime\":{\"free\":null,\"max\":null,\"used\":null}},\"resource_key\":\"3214185ecce3ee369a9eb45d28f65745f4485886\",\"account\":\"plus\"},\"review_page\":{\"active\":true,\"link\":\"https://vimeo.com/user92271093/review/309089585/52576739aa\"},\"parent_folder\":null,\"last_user_action_event_date\":\"2019-01-02T12:29:54+00:00\",\"app\":{\"name\":\"Mycpe\",\"uri\":\"/apps/138804\"},\"status\":\"transcode_starting\",\"resource_key\":\"3a9889fedcb00280d153d7f1628387abbd6b2ab7\",\"upload\":{\"status\":\"in_progress\",\"upload_link\":null,\"form\":null,\"complete_uri\":null,\"approach\":\"pull\",\"size\":null,\"redirect_url\":null,\"link\":\"http://user.spaarg.tech/uploads/webinar_video/1546361153SampleVideo_1280x720_5mb.mp4\"},\"transcode\":{\"status\":\"in_progress\"}}', 'https://vimeo.com/309089585', '<iframe src=\"https://player.vimeo.com/video/309089585?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\" width=\"400\" height=\"300\" frameborder=\"0\" title=\"testbypkmafat\" allow=\"autoplay; fullscreen\" allowfullscreen></iframe>', 'ryBcJhWR', NULL, NULL, '12', '', 'speaker', 1, NULL, '2019-01-02 06:50:33', NULL, 0),
(31, 'abcd', 'self_study', 'aaaa', NULL, '15', NULL, '11', NULL, NULL, 'US/Samoa', '2019-01-04', NULL, NULL, '1', '1', '1', '1', '6', '1', '15464332932018-10-23.png', NULL, NULL, NULL, NULL, NULL, 'active', '154643330515283885.mp4', NULL, NULL, '309092993', '{\"uri\":\"/videos/309092993\",\"name\":\"abcd\",\"description\":null,\"link\":\"https://vimeo.com/309092993\",\"duration\":0,\"width\":400,\"language\":null,\"height\":300,\"embed\":{\"buttons\":{\"like\":true,\"watchlater\":true,\"share\":true,\"embed\":true,\"hd\":false,\"fullscreen\":true,\"scaling\":true},\"logos\":{\"vimeo\":true,\"custom\":{\"active\":false,\"link\":null,\"sticky\":false}},\"title\":{\"name\":\"user\",\"owner\":\"user\",\"portrait\":\"user\"},\"playbar\":true,\"volume\":true,\"speed\":false,\"color\":\"00adef\",\"uri\":null,\"html\":\"<iframe src=\\\"https://player.vimeo.com/video/309092993?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\\\" width=\\\"400\\\" height=\\\"300\\\" frameborder=\\\"0\\\" title=\\\"abcd\\\" allow=\\\"autoplay; fullscreen\\\" allowfullscreen></iframe>\",\"badges\":{\"hdr\":false,\"live\":{\"streaming\":false,\"archived\":false},\"staff_pick\":{\"normal\":false,\"best_of_the_month\":false,\"best_of_the_year\":false,\"premiere\":false},\"vod\":false,\"weekend_challenge\":false}},\"created_time\":\"2019-01-02T12:51:24+00:00\",\"modified_time\":\"2019-01-02T12:51:24+00:00\",\"release_time\":\"2019-01-02T12:51:24+00:00\",\"content_rating\":[\"unrated\"],\"license\":null,\"privacy\":{\"view\":\"password\",\"embed\":\"public\",\"download\":true,\"add\":true,\"comments\":\"anybody\"},\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":100,\"height\":75,\"link\":\"https://i.vimeocdn.com/video/default_100x75?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_100x75&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":200,\"height\":150,\"link\":\"https://i.vimeocdn.com/video/default_200x150?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_200x150&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":295,\"height\":166,\"link\":\"https://i.vimeocdn.com/video/default_295x166?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_295x166&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":640,\"height\":480,\"link\":\"https://i.vimeocdn.com/video/default_640x480?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_640x480&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":960,\"height\":720,\"link\":\"https://i.vimeocdn.com/video/default_960x720?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_960x720&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1280,\"height\":960,\"link\":\"https://i.vimeocdn.com/video/default_1280x960?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1280x960&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1920,\"height\":1440,\"link\":\"https://i.vimeocdn.com/video/default_1920x1440?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1920x1440&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"}],\"resource_key\":\"7a491d0e8cad256a8ac2fd6d207e647c1b034bad\"},\"tags\":[],\"stats\":{\"plays\":0},\"categories\":[],\"metadata\":{\"connections\":{\"comments\":{\"uri\":\"/videos/309092993/comments\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"credits\":{\"uri\":\"/videos/309092993/credits\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"likes\":{\"uri\":\"/videos/309092993/likes\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/videos/309092993/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"texttracks\":{\"uri\":\"/videos/309092993/texttracks\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"related\":null,\"recommendations\":{\"uri\":\"/videos/309092993/recommendations\",\"options\":[\"GET\"]}},\"interactions\":{\"watchlater\":{\"uri\":\"/users/92271093/watchlater/309092993?auth=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1Ijo5MjI3MTA5MywidXJpIjoiXC91c2Vyc1wvOTIyNzEwOTNcL3dhdGNobGF0ZXJcLzMwOTA5Mjk5MyIsImV4cCI6MTU0NjQzNzA4NH0.6_SIPDLa0hGWDhdmX4RnCLgO8NKHy_52Ad1Hi-9ATF4\",\"options\":[\"GET\",\"PUT\",\"DELETE\"],\"added\":false,\"added_time\":null},\"report\":{\"uri\":\"/videos/309092993/report\",\"options\":[\"POST\"],\"reason\":[\"pornographic\",\"harassment\",\"advertisement\",\"ripoff\",\"incorrect rating\",\"spam\"]}}},\"user\":{\"uri\":\"/users/92271093\",\"name\":\"Gary Morya\",\"link\":\"https://vimeo.com/user92271093\",\"location\":null,\"bio\":null,\"created_time\":\"2018-11-29T16:57:20+00:00\",\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":30,\"height\":30,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_30x30.png\"},{\"width\":75,\"height\":75,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_75x75.png\"},{\"width\":100,\"height\":100,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_100x100.png\"},{\"width\":300,\"height\":300,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_300x300.png\"},{\"width\":72,\"height\":72,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_72x72.png\"},{\"width\":144,\"height\":144,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_144x144.png\"},{\"width\":216,\"height\":216,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_216x216.png\"},{\"width\":288,\"height\":288,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_288x288.png\"},{\"width\":360,\"height\":360,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_360x360.png\"}],\"resource_key\":\"06cd312fcc3908e2d839aeb00ccaaf434acb0859\"},\"websites\":[],\"metadata\":{\"connections\":{\"albums\":{\"uri\":\"/users/92271093/albums\",\"options\":[\"GET\"],\"total\":0},\"appearances\":{\"uri\":\"/users/92271093/appearances\",\"options\":[\"GET\"],\"total\":0},\"categories\":{\"uri\":\"/users/92271093/categories\",\"options\":[\"GET\"],\"total\":0},\"channels\":{\"uri\":\"/users/92271093/channels\",\"options\":[\"GET\"],\"total\":0},\"feed\":{\"uri\":\"/users/92271093/feed\",\"options\":[\"GET\"]},\"followers\":{\"uri\":\"/users/92271093/followers\",\"options\":[\"GET\"],\"total\":0},\"following\":{\"uri\":\"/users/92271093/following\",\"options\":[\"GET\"],\"total\":0},\"groups\":{\"uri\":\"/users/92271093/groups\",\"options\":[\"GET\"],\"total\":0},\"likes\":{\"uri\":\"/users/92271093/likes\",\"options\":[\"GET\"],\"total\":0},\"moderated_channels\":{\"uri\":\"/users/92271093/channels?filter=moderated\",\"options\":[\"GET\"],\"total\":0},\"portfolios\":{\"uri\":\"/users/92271093/portfolios\",\"options\":[\"GET\"],\"total\":0},\"videos\":{\"uri\":\"/users/92271093/videos\",\"options\":[\"GET\"],\"total\":20},\"watchlater\":{\"uri\":\"/users/92271093/watchlater\",\"options\":[\"GET\"],\"total\":0},\"shared\":{\"uri\":\"/users/92271093/shared/videos\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/users/92271093/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"watched_videos\":{\"uri\":\"/me/watched/videos\",\"options\":[\"GET\"],\"total\":10},\"folders\":{\"uri\":\"/me/folders\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"block\":{\"uri\":\"/me/block\",\"options\":[\"GET\"],\"total\":0}}},\"preferences\":{\"videos\":{\"privacy\":{\"view\":\"anybody\",\"comments\":\"anybody\",\"embed\":\"public\",\"download\":true,\"add\":true}}},\"content_filter\":[\"language\",\"drugs\",\"violence\",\"nudity\",\"safe\",\"unrated\"],\"upload_quota\":{\"space\":{\"free\":5140990853,\"max\":5368709120,\"used\":227718267,\"showing\":\"periodic\"},\"periodic\":{\"free\":5140990853,\"max\":5368709120,\"used\":227718267,\"reset_date\":\"2019-01-07 00:00:00\"},\"lifetime\":{\"free\":null,\"max\":null,\"used\":null}},\"resource_key\":\"3214185ecce3ee369a9eb45d28f65745f4485886\",\"account\":\"plus\"},\"review_page\":{\"active\":true,\"link\":\"https://vimeo.com/user92271093/review/309092993/3fc08ba0eb\"},\"parent_folder\":null,\"last_user_action_event_date\":\"2019-01-02T12:51:24+00:00\",\"app\":{\"name\":\"Mycpe\",\"uri\":\"/apps/138804\"},\"status\":\"transcode_starting\",\"resource_key\":\"f97f2fafe3a102afbb904c696f684acd447de0e6\",\"upload\":{\"status\":\"in_progress\",\"upload_link\":null,\"form\":null,\"complete_uri\":null,\"approach\":\"pull\",\"size\":null,\"redirect_url\":null,\"link\":\"http://user.spaarg.tech/uploads/webinar_video/1546361153SampleVideo_1280x720_5mb.mp4\"},\"transcode\":{\"status\":\"in_progress\"}}', 'https://vimeo.com/309092993', '<iframe src=\"https://player.vimeo.com/video/309092993?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\" width=\"400\" height=\"300\" frameborder=\"0\" title=\"abcd\" allow=\"autoplay; fullscreen\" allowfullscreen></iframe>', 'LHSs8hO3', NULL, NULL, '12', '', 'speaker', 1, NULL, '2019-01-02 07:18:13', NULL, 0),
(32, 'sadasd', 'live', 'sadsads', NULL, '34', NULL, NULL, NULL, NULL, 'Asia/Kolkata', '2019-01-04', '2019-01-04 10:05:43', '2019-01-04 18:00:43', '2', '1', 'sadasds', 'adasdsad', '3,6', '1', '1546596277nairobi.jpg', '<p>asdasdas dasd asdasdasdasdsadasdasd</p>', NULL, NULL, NULL, NULL, 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, 2, '45', NULL, 'speaker', 1, 1, '2019-01-04 04:34:37', '2019-01-04 06:21:26', 0),
(33, 'rrrrrrrrrrrrrrrrrrr', 'self_study', 'fffffffffffffff', NULL, NULL, NULL, '54', NULL, NULL, 'Asia/Kolkata', '2019-01-04', NULL, NULL, '2', '3', 'ssssssssss', 'dddddddddddddddd', '3', '2', '1546598124nairobi.jpg', '<p>dddddd</p>', NULL, NULL, NULL, NULL, 'inactive', '', '4:11', NULL, '', '', '', '', NULL, NULL, NULL, '5555555555', NULL, 'speaker', 1, 1, '2019-01-04 05:05:24', '2019-01-08 02:41:34', 0),
(34, 'sadas', 'live', 'asdas', NULL, NULL, NULL, NULL, NULL, NULL, 'Asia/Kolkata', '2019-01-04', '2019-01-04 11:30:14', '2019-01-04 12:15:14', '1', '3', 'gdfg', 'fdgfdg', '4,6', '1', '1546601301narendra-modi.jpg', '<p>gggggggggg</p>', NULL, NULL, NULL, NULL, 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, 2, '45', NULL, 'speaker', 1, 1, '2019-01-04 05:58:21', '2019-01-04 06:21:09', 0),
(35, 'sdfsdfsd', 'self_study', 'sdfsdfsdfsdfsdf dsfsdf fsd fsdfsdf', NULL, NULL, NULL, '4', NULL, NULL, 'Greenland', '2019-01-08', NULL, NULL, '2', '3', 'dsfsdf', 'sdfsdf', '3', '1', '1546935190nairobi.jpg', '<p>sdfsdfsdfsd fdsfsdfdsfds</p>', NULL, NULL, NULL, NULL, 'inactive', '1546943160videoplayback.mp4', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '54', NULL, 'speaker', 1, NULL, '2019-01-08 02:43:10', NULL, 0),
(36, 'dfgdfg', 'live', 'dfgdfgfdg', NULL, NULL, NULL, NULL, NULL, NULL, 'US/Hawaii', '2019-01-09', '2019-01-09 16:30:57', '2019-01-10 03:50:57', '2', '3', 'dfgdfg', 'dfgdfg', '3', '2', '1546943438nairobi.jpg', '<p>dfgdfgdfgdfgd</p>', NULL, NULL, NULL, NULL, 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '5', NULL, 'speaker', 1, NULL, '2019-01-08 05:00:38', NULL, 0),
(37, 'ssssssssssssssssss', 'self_study', 'sssssssssssssssssssssssssssss', NULL, NULL, NULL, '34543', NULL, NULL, 'US/Hawaii', '2019-01-09', NULL, NULL, '2', '1', 'gdfgdf', 'dfgdf', '3', '1', '1546944181Fundingtree-logo-Horizontal.png', '<p>dfgdfgg gdfgfdgdfgdfggdf gfd gdfg</p>', NULL, NULL, NULL, NULL, 'inactive', '154694566715283885.mp4', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '4', NULL, 'speaker', 1, NULL, '2019-01-08 05:13:01', NULL, 0),
(38, 'hhhhhhhhhhhh', 'self_study', 'fghfghfgh', NULL, NULL, NULL, '5', NULL, NULL, 'US/Hawaii', '2019-01-09', NULL, NULL, '1', '3', 'try', 'rty', '3', '2', '', '<p>ryrtyrtyrt</p>', NULL, NULL, NULL, NULL, 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '5', NULL, 'speaker', 1, 1, '2019-01-08 06:18:37', '2019-01-18 02:59:37', 0),
(39, 'test sandy', 'live', 'sfgfdg', NULL, NULL, NULL, NULL, NULL, NULL, 'US/Alaska', '2019-01-19', '2019-01-19 20:50:23', '2019-01-20 04:55:23', '1', '3', NULL, NULL, '5', '', '1547800654mvp.xlsx', NULL, NULL, NULL, NULL, NULL, 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '12', NULL, 'speaker', 1, 1, '2019-01-10 00:53:07', '2019-01-18 03:07:39', 0),
(40, NULL, 'self_study', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, 'delete', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, 'speaker', 1, 1, '2019-01-22 00:38:53', NULL, 0),
(41, 'abcd', 'self_study', '<p>abcd</p>', '1548137964pk.jpg', NULL, NULL, '2', NULL, 'qas_self_study', 'US/Hawaii', '2019-01-26', NULL, NULL, '1', '1', NULL, NULL, '1', '', '1548137964IMG_20180627_140809.jpg', NULL, NULL, NULL, NULL, NULL, 'inactive', '1548141379videoplayback.mp4', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '12', NULL, 'speaker', 1, 1, '2019-01-22 00:49:24', '2019-01-22 04:12:27', 0),
(42, 'Hi Gustsssssssssex', 'self_study', '<p>ssssss</p>', '', NULL, NULL, '3', NULL, 'qas_self_study', 'US/Alaska', '2019-01-23', NULL, NULL, '1', '3', NULL, NULL, '1', '', '1548141942pk.jpg', '<p>33333</p>', NULL, NULL, NULL, NULL, 'inactive', '1548142320videoplayback.mp4', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '33', NULL, 'speaker', 1, NULL, '2019-01-22 01:55:42', NULL, 0),
(43, 'dddd', 'self_study', '<p>sdfsdf</p>', '', NULL, NULL, '2', '<p>sdfsdf</p>', 'qas_self_study', 'US/Hawaii', '2019-01-25', NULL, NULL, '1', '1', 'dsfdf', 'sdfsdf', '5', '', '15481433001.png', NULL, NULL, NULL, NULL, NULL, 'inactive', '1548143368pihu.mp4', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '33', NULL, 'speaker', 1, NULL, '2019-01-22 02:18:20', NULL, 0),
(44, 'sdfdfdsfds', 'self_study', '<p>dfsdfdfdf</p>', '', NULL, NULL, '33', NULL, NULL, 'US/Hawaii', '2019-01-24', NULL, NULL, '1', '1', NULL, NULL, '6', '', '154814347420181122_200939.jpg', NULL, NULL, NULL, NULL, NULL, 'inactive', '1548144121pihu.mp4', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '22', NULL, 'speaker', 1, 1, '2019-01-22 02:21:14', '2019-01-22 04:04:43', 0),
(45, 'dfdf', 'self_study', '<p>dfsdfsdf</p>', '', NULL, NULL, '22', NULL, NULL, 'US/Hawaii', '1899-12-22', NULL, NULL, '1', '1', NULL, NULL, '6', '1', '15481437822.png', NULL, NULL, NULL, NULL, NULL, 'inactive', '1548148608pihu.mp4', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '11', NULL, 'speaker', 1, 1, '2019-01-22 02:26:22', '2019-01-22 04:01:39', 0),
(46, 'final draft test', 'self_study', '<p>sdfsdfsdfsd</p>', '', NULL, NULL, '1', NULL, NULL, 'America/Tijuana', '2019-01-24', NULL, NULL, '1', '1', NULL, NULL, '5', '', '1548151504pk.jpg', NULL, NULL, NULL, NULL, NULL, 'delete', '1548151471season3_7.mp4', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '5', NULL, 'speaker', 1, 1, '2019-01-22 04:34:03', '2019-01-22 04:35:04', 0),
(47, 'final normal', 'self_study', '<p>ssss</p>', '', NULL, NULL, '1', NULL, 'nano_learning', 'US/Pacific', '2019-01-24', NULL, NULL, '1', '2', NULL, NULL, '6', '', '1548152805demo1.jpg', NULL, NULL, NULL, NULL, NULL, 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '2', NULL, 'speaker', 1, NULL, '2019-01-22 04:56:45', NULL, 0),
(48, 'sdsdsdsd', 'self_study', '<p>sdsd</p>', '', NULL, NULL, '444', NULL, NULL, 'US/Samoa', '2019-01-17', NULL, NULL, '1', '2', NULL, NULL, '3', '1', '15481533371.png', NULL, NULL, NULL, NULL, NULL, 'inactive', '1548155221videoplayback.mp4', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '4444', NULL, 'speaker', 1, 1, '2019-01-22 05:05:37', '2019-01-22 05:37:10', 0),
(49, 'hgjghj', 'self_study', '<p>hjghjgh</p>', '', '12', NULL, '1', NULL, 'group_internet_based', 'America/Tijuana', '2019-01-25', NULL, NULL, '1', '1', NULL, NULL, '1', '', '1548155333pk.jpg', NULL, NULL, NULL, NULL, NULL, 'inactive', '1548160123pihu.mp4', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '12', NULL, 'speaker', 1, 1, '2019-01-22 05:37:51', '2019-01-22 07:28:52', 0),
(50, 'test', 'live', '<p>SSSSSSSSSSSSS</p>', '', NULL, NULL, NULL, '<p>SSSSSS</p>', 'qas_self_study', 'US/Hawaii', '2019-01-31', '2019-01-31 10:00:07', '2019-02-01 01:55:07', '1', '1', NULL, NULL, '6', '', '1548161520pk.jpg', NULL, NULL, NULL, NULL, NULL, 'inactive', '', NULL, NULL, '', '', '', '', NULL, NULL, NULL, '11', NULL, 'speaker', 1, 1, '2019-01-22 07:22:00', '2019-01-22 07:25:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `webinar_co_organizer`
--

CREATE TABLE `webinar_co_organizer` (
  `id` int(11) NOT NULL,
  `webinar_id` int(11) NOT NULL,
  `speaker_id` int(11) NOT NULL,
  `memberKey` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `givenName` varchar(255) DEFAULT NULL,
  `joinLink` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` enum('active','inactive','delete') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webinar_co_organizer`
--

INSERT INTO `webinar_co_organizer` (`id`, `webinar_id`, `speaker_id`, `memberKey`, `surname`, `givenName`, `joinLink`, `email`, `created_by`, `created_at`, `updated_at`, `status`) VALUES
(1, 22, 1, '679458999279272715', '', 'jignesh dodiya', 'https://global.gotowebinar.com/eojoin/4815982271670239499/679458999279272715', 'karanp701@yahoo.com', 1, '2018-12-26 12:59:59', '0000-00-00 00:00:00', 'active'),
(2, 23, 1, '1995153304789990412', '', 'jignesh dodiya', 'https://global.gotowebinar.com/eojoin/3288361497984776459/1995153304789990412', 'jigneshdodiya10@gmail.com', 1, '2018-12-27 06:40:03', '0000-00-00 00:00:00', 'active'),
(3, 24, 1, '1874230115479613709', '', 'jignesh dodiya', 'https://global.gotowebinar.com/eojoin/117245718665653773/1874230115479613709', 'jigneshdodiya10@gmail.com', 1, '2018-12-27 07:32:07', '0000-00-00 00:00:00', 'active'),
(4, 24, 1, '1082283775830218253', '', 'jaypal Chauhan', 'https://global.gotowebinar.com/eojoin/117245718665653773/1082283775830218253', 'abctest@yahoo.com', 1, '2018-12-27 08:01:33', '0000-00-00 00:00:00', 'active'),
(5, 24, 1, '6169006096456987916', '', 'vishal testhfign', 'https://global.gotowebinar.com/eojoin/117245718665653773/6169006096456987916', 'vishalkhanderi@veri.com', 1, '2018-12-27 08:11:40', '0000-00-00 00:00:00', 'active'),
(6, 26, 1, '1753895165024742925', '', 'jignesh dodiya', 'https://global.gotowebinar.com/eojoin/3686018570003884813/1753895165024742925', 'jigneshdodiya10@gmail.com', 1, '2019-01-02 10:32:06', '0000-00-00 00:00:00', 'active'),
(7, 28, 1, '7871795565273780491', '', 'jignesh dodiya', 'https://global.gotowebinar.com/eojoin/343624167844974347/7871795565273780491', 'jigneshdodiya10@gmail.com', 1, '2019-01-02 11:42:01', '0000-00-00 00:00:00', 'active'),
(8, 29, 1, '530436690962818827', '', 'jignesh dodiya', 'https://global.gotowebinar.com/eojoin/8042152797370328333/530436690962818827', 'jigneshdodiya10@gmail.com', 1, '2019-01-02 12:18:40', '0000-00-00 00:00:00', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `webinar_documents`
--

CREATE TABLE `webinar_documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `webinar_id` int(11) NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 => InActive, 1 => Active, 2 => Delete',
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `webinar_like`
--

CREATE TABLE `webinar_like` (
  `id` int(11) NOT NULL,
  `webinar_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webinar_like`
--

INSERT INTO `webinar_like` (`id`, `webinar_id`, `user_id`, `created_at`) VALUES
(1, 2, 2, '2019-01-10 12:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `webinar_questions`
--

CREATE TABLE `webinar_questions` (
  `id` int(11) NOT NULL,
  `webinar_id` int(11) NOT NULL,
  `type` enum('review','final') NOT NULL,
  `time` time DEFAULT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `answer` enum('a','b','c','d') NOT NULL,
  `currect_answer_note_a` text,
  `wrong_answer_note_a` text,
  `status` enum('active','inactive','delete') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `currect_answer_note_b` text,
  `wrong_answer_note_b` text,
  `currect_answer_note_c` text,
  `wrong_answer_note_c` text,
  `currect_answer_note_d` text,
  `wrong_answer_note_d` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webinar_questions`
--

INSERT INTO `webinar_questions` (`id`, `webinar_id`, `type`, `time`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `answer`, `currect_answer_note_a`, `wrong_answer_note_a`, `status`, `created_at`, `updated_at`, `added_by`, `updated_by`, `currect_answer_note_b`, `wrong_answer_note_b`, `currect_answer_note_c`, `wrong_answer_note_c`, `currect_answer_note_d`, `wrong_answer_note_d`) VALUES
(1, 13, 'review', '11:33:18', 'question one', 'asdas', 'asdasd', 'asdas', 'asdasd', 'c', NULL, NULL, 'active', '2018-12-20 11:29:25', '2018-12-20 11:57:01', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 13, 'review', '11:33:18', 'Question two for Review', 'asdasfsd', 'asdasdsdfd', 'asdassdfds', 'asdasdfdsf', 'b', NULL, NULL, 'active', '2018-12-20 11:29:25', '2018-12-20 11:57:01', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 13, 'final', '11:33:18', 'sdasdfd fds f', 'asdasfsd fdsf', 'asdasdsdfd fdfdsf ', 'asdassdfdssdfdsf ', 'asdasdfdsf sdf ', 'd', NULL, NULL, 'active', '2018-12-20 11:29:25', '2018-12-20 11:57:01', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 13, 'final', '11:33:18', 'sdasdfd fds dddddddfsdfdsf', 'asdasfsd fdsf sdfsdfsdfd', 'asdasdsdfd fdfdsf sf fsdfsdfsdfs', 'asdassdfdssdfdsf dfsd sdfsdfsdf', 'asdasdfdsf sdfsfsdfsdf', 'a', NULL, NULL, 'active', '2018-12-20 11:29:25', '2018-12-20 11:57:01', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 25, 'review', '10:31:31', 'What does the blue and green color-coding of entries in the ProSeries tax worksheets indicate?', 'Complete versus incomplete data', 'What-if scenarios for married filing jointly or separately', 'Information rolled over from the prior year versus this year', 'The billing status of the client', 'c', NULL, NULL, 'active', '2018-12-29 05:02:56', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 25, 'review', '10:33:15', 'To more easily keep track of missing client information, ProSeries offers all the following features, EXCEPT:', 'Right-click the field and select Add/Edit Missing Client Information.', 'Use Print/Email from the Missing Client Information window.', 'View forms with a red exclamation point in the Home Base View.', 'In Client Portal, click the Send Missing Information Reminder.', 'c', NULL, NULL, 'active', '2018-12-29 05:03:53', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 25, 'final', '10:34:03', 'Which statement is true about the E-Filing feature in ProSeries?', 'The feature is free for the first signature request per client.', 'The feature includes encryption and mobile access.', 'The feature costs more for returns requiring multiple signatures.', 'The feature has a small flat fee per email sent.', 'b', NULL, NULL, 'active', '2018-12-29 05:04:38', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 25, 'final', '12:38:13', 'Which steps BEST describe how to prepare a new, basic tax return for an employed individual?', 'Click on Form 1040 in the left-hand pane and select New Client to clear the form for the new client data. Add forms W-2 and Schedule B', 'From Home Base view, right-click on the Client Name column and choose Add New. Complete the Federal Information Worksheet.', 'Click New Client to access the wizard that guides completion of US Form 1040, W-2, Schedule B, and other worksheets and forms as needed.', 'From Home Base view, select New Client File and select type US Form 1040. Add forms W-2 and Schedule B. Complete red-shaded fields.', 'c', NULL, NULL, 'active', '2018-12-31 07:09:02', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 25, 'final', '12:39:10', 'What feature does the presenter suggest you use to quickly locate all forms related to a topic, such as educational expenses?', 'Use the Where Do I Enter button to search.', 'Click on the User Guide icon, and use Find.', 'Use Ask ProSeries in the upper right.', 'Search the Intuit blog posts.', 'a', NULL, NULL, 'active', '2018-12-31 07:09:40', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 25, 'review', '12:39:55', 'Which statement is true about the E-Filing feature in ProSeries?', 'The feature is free for the first signature request per client.', 'The feature includes encryption and mobile access', 'The feature costs more for returns requiring multiple signatures.', 'The feature has a small flat fee per email sent.', 'b', NULL, NULL, 'active', '2018-12-31 07:10:41', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 31, 'review', '12:38:13', 'aaaaaa', 'aa', 'dd', 'ddde', 'feeee', 'b', NULL, NULL, 'active', '2019-01-02 12:33:49', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 31, 'review', '06:04:08', 'dfsdfsdf', 'dsfdsf', 'dsfdsf', 'fdsf', 'dsfds', 'c', NULL, NULL, 'active', '2019-01-02 12:34:20', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 30, 'final', '06:04:30', 'sdfsdfsd', 'dsfsdf', 'dsfdsf', 'sdfsdfdsf', 'dsfdsf', 'd', NULL, NULL, 'active', '2019-01-02 12:34:39', '2019-01-07 06:42:05', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 41, 'review', '04:49:20', 'abcd', 'aa', 'aaa', 'aaa', 'aa', 'b', 'aa', 'aaa', 'delete', '2019-01-22 06:20:13', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 41, 'review', '12:25:35', 'aaaa', 'aaa', 'aaaa', 'assss', 'sssddddd', 'c', 'aaa', 'aa', 'delete', '2019-01-22 06:57:59', NULL, 1, 1, 'aaaaa', 'aaa', 'ssss', 'sssss', 'ddfdfff', 'ffffff'),
(16, 41, 'final', '12:29:01', 'wwww', 'www', 'aaaa', 'dffff', 'yyyy', 'c', 'www', 'ww', 'active', '2019-01-22 06:59:20', NULL, 1, NULL, 'aaaa', 'aaa', 'fffff', 'ffff', 'yyy', 'yyy'),
(17, 41, 'review', '12:30:50', 'aaaapppppp', 'ddddpppp', 'ffffpppp', 'ggggpp', 'hjjjpppp', 'd', 'ddddpppp', 'dddppp', 'active', '2019-01-22 07:00:14', '2019-01-22 07:15:20', 1, 1, 'ffffppp', 'fffppp', 'gppppppppppppp', 'gggpppp', 'jjjjppppp', 'jjjp'),
(18, 42, 'review', '12:55:49', '3333', 'ddddpppp', '2222', 'r555', 'yyyy', 'c', '333', '333', 'active', '2019-01-22 07:26:05', NULL, 1, NULL, '44', '444', '55', '555', 'yyyyy', 't'),
(19, 42, 'final', '12:56:30', 'ererer', 'rererre', 'erere', 'rere', 'erere', 'c', 'ererer', 'erer', 'active', '2019-01-22 07:26:26', NULL, 1, NULL, 'erere', 'erer', 'rere', 'rere', 'erer', 'rer'),
(20, 43, 'review', '01:35:30', 'aaaaaaa', 'aa', 'aaaa', 'aaa', 'aaaaaaaaaaaaaaaaaaaaaaa', 'b', 'aaa', 'aa', 'active', '2019-01-22 07:48:43', NULL, 1, NULL, 'a', 'a', 'aaa', 'aaaa', 'aaaa', 'aa'),
(21, 43, 'final', '01:18:35', 'ddddddddddddddd', 'dddddddddd', 'ddddddddddddd', 'dddddddddddddd', 'ddddddddddddd', 'c', 'dddddddddddd', 'dddddddddddd', 'active', '2019-01-22 07:49:00', NULL, 1, NULL, 'dddddddddddddd', 'dddddddddddd', 'ddddddddddddd', 'dddddddddddd', 'dddddddddddd', 'dddddddddddddd'),
(22, 44, 'review', '01:21:17', 'aaaaaaa', 'aaaaaaaaaaaaaa', 'aaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaa', 'b', 'aaaaaaaaaaaaa', 'aaaaaaaaaaaaa', 'active', '2019-01-22 07:51:30', NULL, 1, NULL, 'aaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaa', 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaa', 'aaaaaaaaaaa'),
(23, 44, 'final', '01:21:30', 'qssssss', 'qqqqqqqqqqqqqqqqqq', 'qqqqqqqqqqqqqqqqq', 'qqqqqqqqqqqqqq', 'qqqqqqqqqqqqq', 'c', 'qqqqqqqqq', 'qqqqqqqqqqqqqqq', 'active', '2019-01-22 07:51:49', '2019-01-22 09:40:09', 1, 1, 'qqqqqqqqqqqqq', 'wwwwwwwwww', 'qqqqqqqqqqqqqqqq', 'qqqqqqqqq', 'qqqqqqqqqqqq', 'qqqqqqqqqqqsss'),
(24, 45, 'review', '01:26:25', 'a', 'aaaaaaaaaa', 'aaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaa', 'b', 'aaaaaaaaaaaa', 'aaaaaaaaaaaaa', 'active', '2019-01-22 07:56:36', NULL, 1, NULL, 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaaaa', 'aaaaaaaaaaa', 'aaaaaaaaaaaa', 'aaaaaaaaaaaaaa', 'aaaaaaaaaa'),
(25, 45, 'final', '01:26:50', 'aaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaa', 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaaaa', 'c', 'aaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaa', 'active', '2019-01-22 07:56:56', NULL, 1, NULL, 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaaaa', 'aaaaaaaaaaaaa', 'aaaaaaaaaaa', 'aaaaaaaaaaaaaaa', 'aaaaaaa'),
(26, 44, 'review', '03:05:18', 'any', 'yyy', 'tttttttttttttttt', 'hhhhhh', 'yyyyyyyyyyyy', 'c', 'yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy', 'yyyyyyyyyyyyy', 'active', '2019-01-22 09:35:37', '2019-01-22 09:39:53', 1, 1, 'ttttttttttttttttttt', 'tttttttttt', 'hhhhhhhhhhhhhhhh', 'hhhhhhhhhhhhhh', 'yyyyyyyyyyyyy', 'hhhh'),
(27, 44, 'final', '03:05:44', 'hhhhhhhhhhhh', 'jjjj', 'yyyyyyyyyyyyyyyyyyyyyyy', 'rr', 'yyyyyyyyy', 'c', 'hhhhhhhhhhhhhhh', 'hhhhhhhhhhhh', 'active', '2019-01-22 09:36:05', NULL, 1, NULL, 'yyyyyy', 'yyyyyyyyyyyyyyyyyyyyyyyyyyyyy', 'rrrrrrrrrrrrrrrrr', 'rrrrrr', 'yyyyyyyyyyyyyyyyyy', 'yyyyyyyyy'),
(28, 47, 'review', '03:56:48', '222222', '22', '222222222222222222', '222222222222222222', '22222222222222', 'b', '222222', '2222222222222', 'active', '2019-01-22 10:27:01', NULL, 1, NULL, '22222222222222222', '2222222222', '2222222222222', '2222222222222', '2222222222222222', '2222222222222'),
(29, 47, 'final', '03:55:05', '22222ee', 'eeeeeeeeeeeeeeee', 'eeeeeeeeeeeeeeeee', 'eeeeeeeeeeeee', 'eeeeeeeeeeeeeee', 'b', 'eeeeeeeeeeeeeee', 'eeeeeeeeeeeeee', 'active', '2019-01-22 10:27:19', NULL, 1, NULL, 'eeeeeeeeeeee', 'eeeeeeeeeee', 'eeeeeeeeeeeeeeee', 'eeeeeeeeeeeee', 'eeeeeeeeeeeeeeeeeeee', 'eeeeeeeeeee'),
(30, 48, 'review', '04:07:22', 'aaaa', 'aaaaaaaaaa', 'aaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaa', 'c', 'aaaaaaaaaa', 'aaaaaaaaaaaa', 'active', '2019-01-22 10:37:34', NULL, 1, NULL, 'aaaaaaaaaaaaaa', 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 'aaaaaaaaaaa', 'aaaaaaaaaaaaaaaaa', 'aaaaaaaaaaa'),
(31, 48, 'final', '04:07:41', 'dddddd', 'dddddddddddddddd', 'dddddddddddddddddd', 'ddddddddddddddd', 'dddddddddddd', 'c', 'dddddddddd', 'ddddddddddddddd', 'active', '2019-01-22 10:37:53', NULL, 1, NULL, 'dddddddddddddd', 'dddddddddddd', 'dddddddddd', 'dddddddddddd', 'dddddddddddddddddd', 'dddddddddd'),
(32, 49, 'review', '04:39:03', 'ssss', 'ssssssssssssssssssssssss', 'sssssssssssss', 'sssssssssssssssss', 'ssssssssssssssssss', 'c', 'sssssssssss', 'ssssssssssss', 'delete', '2019-01-22 11:09:14', NULL, 1, 1, 'ssssssssssssssssssssss', 'sssssssssss', 'ssssssssssssssss', 'ssssssssssssssss', 'ssssssssssssss', 'ssssssssssss'),
(33, 49, 'final', '04:39:22', 'sssssss', 'ssssssssssss', 'ssssssssssssss', 'sssssssssssssss', 'ssssssssssssssss', 'b', 'sssssssssssssss', 'ssssssssssss', 'delete', '2019-01-22 11:09:33', NULL, 1, 1, 'ssssssssssssss', 'ssssssssss', 'sssssssssssssss', 'ssssssssssss', 'sssssssssss', 'sssssssssss'),
(37, 0, 'review', '06:08:58', 'aaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaa', 'bbbbbbbbbb', 'cccccc', 'cccccc', 'c', 'aaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaa', 'active', '2019-01-22 12:39:23', NULL, 1, NULL, 'bbbbbbbbbbbbbbb', 'bbbbbbbbbb', 'cccccccccccccccccccccccc', 'cccccccc', 'cccccccccccccccccc', 'cccccccccc'),
(38, 49, 'review', '06:14:15', 'aaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaa', 'bbbbbbbb', 'cccccccccc', 'dddddddddddddd', 'b', 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaa', 'delete', '2019-01-22 12:44:37', NULL, 1, 1, 'bbbbbbbbbbbbbbbb', 'bbbbbb', 'ccccccccc', 'ccccccccccc', 'ddddddddddddddddddddddd', 'ddddddd'),
(39, 49, 'final', '06:14:35', 'ccccc', 'ccccccccccccccc', 'cccccccccccc', 'ccccccccccccccccccc', 'ccccccccccccc', 'c', 'cccccccccccccc', 'ccccccccccccccccc', 'delete', '2019-01-22 12:45:01', NULL, 1, 1, 'cccccccccccccccccccc', 'cccccccccccc', 'cccccccccccccc', 'ccccccccccc', 'ccccccccccccccccccc', 'cccccccccc'),
(40, 49, 'review', '06:18:35', 'sssssssssss', 'sssssssssss', 'sssssssssssss', 'sssssssssssssssss', 'sssssssssssss', 'c', 'ssssssssssss', 'sssssssssss', 'delete', '2019-01-22 12:49:32', NULL, 1, 1, 'ssssssssssssssss', 'ssssssssss', 'ssssssssssssssssssssssssssssss', 'sssssssssss', 'sssssssssssssss', 'sssssssss'),
(41, 49, 'review', '06:33:35', 'ddddddddddd', 'dddddddddddd', 'dddddddddddddddd', 'dddddddddddd', 'ddddddddddddddddddddd', 'a', 'dddddddddddd', 'dddddddddddd', 'active', '2019-01-22 13:04:12', NULL, 1, NULL, 'dddddddddddddddd', 'dddddddddd', 'dddddddddddddd', 'ddddddd', 'ddddddddddd', 'ddddddddddd');

-- --------------------------------------------------------

--
-- Table structure for table `webinar_question_result`
--

CREATE TABLE `webinar_question_result` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `webinar_id` int(11) NOT NULL,
  `type` enum('review','final') DEFAULT NULL,
  `answer` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `result` enum('0','1') DEFAULT NULL COMMENT '0=Wrong,1=Right'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webinar_question_result`
--

INSERT INTO `webinar_question_result` (`id`, `question_id`, `user_id`, `webinar_id`, `type`, `answer`, `created_by`, `created_at`, `updated_at`, `result`) VALUES
(1, 5, 1, 25, 'review', 'c', 1, '2019-01-02 13:01:10', '0000-00-00 00:00:00', '1'),
(2, 6, 1, 25, 'review', 'c', 1, '2019-01-02 13:01:10', '0000-00-00 00:00:00', '1'),
(3, 10, 1, 25, 'review', 'b', 1, '2019-01-02 13:01:10', '0000-00-00 00:00:00', '1'),
(10, 7, 1, 25, 'final', 'b', 1, '2019-01-02 13:12:50', '0000-00-00 00:00:00', '1'),
(11, 8, 1, 25, 'final', 'c', 1, '2019-01-02 13:12:50', '0000-00-00 00:00:00', '1'),
(12, 9, 1, 25, 'final', 'a', 1, '2019-01-02 13:12:50', '0000-00-00 00:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `webinar_selfstudy_video_duration`
--

CREATE TABLE `webinar_selfstudy_video_duration` (
  `id` int(11) NOT NULL,
  `webinar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `play_time_duration` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webinar_selfstudy_video_duration`
--

INSERT INTO `webinar_selfstudy_video_duration` (`id`, `webinar_id`, `user_id`, `play_time_duration`, `created_at`, `updated_at`) VALUES
(1, 25, 1, '25', '2019-01-02 13:10:17', '2019-01-02 13:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `webinar_user_register`
--

CREATE TABLE `webinar_user_register` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `webinar_id` int(11) NOT NULL,
  `webinar_type` enum('live','archived','self_study') DEFAULT NULL,
  `payment_type` enum('free','paid') DEFAULT NULL,
  `paid_amount` float(9,2) DEFAULT NULL,
  `transection_id` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `payment_status` enum('pending','success') NOT NULL DEFAULT 'pending',
  `join_url` text,
  `registrant_key` varchar(500) DEFAULT NULL,
  `registration_status` enum('APPROVED','REJECT','PENDING') DEFAULT NULL,
  `status` enum('active','inactive','delete') NOT NULL DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webinar_user_register`
--

INSERT INTO `webinar_user_register` (`id`, `user_id`, `webinar_id`, `webinar_type`, `payment_type`, `paid_amount`, `transection_id`, `start_time`, `end_time`, `created_at`, `updated_at`, `payment_status`, `join_url`, `registrant_key`, `registration_status`, `status`) VALUES
(1, 1, 28, 'live', 'paid', 5.00, 'txn_1Dosf0LuyvTTvdwTNqCICqJ2', '2019-01-04 01:10:32', '2019-01-04 07:10:32', '2019-01-04 13:24:08', NULL, 'success', NULL, NULL, NULL, 'inactive'),
(2, 1, 2, 'archived', 'free', NULL, NULL, '2018-12-04 14:11:15', '2018-12-04 17:15:30', '2019-01-07 04:53:30', NULL, 'success', NULL, NULL, NULL, 'active'),
(3, 1, 31, 'self_study', 'paid', 15.00, 'txn_1DqIpELuyvTTvdwTx8iKjq5i', NULL, NULL, '2019-01-08 11:32:46', NULL, 'success', NULL, NULL, NULL, 'active'),
(4, 1, 30, 'self_study', 'free', NULL, NULL, NULL, NULL, '2019-01-08 12:05:31', NULL, 'success', NULL, NULL, NULL, 'active'),
(5, 1, 25, 'self_study', 'free', NULL, NULL, NULL, NULL, '2019-01-08 12:05:35', NULL, 'success', NULL, NULL, NULL, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrators_password_resets`
--
ALTER TABLE `administrators_password_resets`
  ADD KEY `administrators_password_resets_email_index` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_index` (`country_id`),
  ADD KEY `cities_state_id_index` (`state_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies_password_resets`
--
ALTER TABLE `companies_password_resets`
  ADD KEY `speakers_password_resets_email_index` (`email`);

--
-- Indexes for table `company_user`
--
ALTER TABLE `company_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_levels`
--
ALTER TABLE `course_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devices_user_id_index` (`user_id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `speakers`
--
ALTER TABLE `speakers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `speakers_email_unique` (`email`);

--
-- Indexes for table `speakers_password_resets`
--
ALTER TABLE `speakers_password_resets`
  ADD KEY `speakers_password_resets_email_index` (`email`);

--
-- Indexes for table `speaker_follow`
--
ALTER TABLE `speaker_follow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `speaker_invitation`
--
ALTER TABLE `speaker_invitation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `speaker_ratings`
--
ALTER TABLE `speaker_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_index` (`country_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag_user`
--
ALTER TABLE `tag_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_user_user_id_index` (`user_id`),
  ADD KEY `tag_user_tag_id_index` (`tag_id`);

--
-- Indexes for table `tag_webinar`
--
ALTER TABLE `tag_webinar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_password_reset`
--
ALTER TABLE `user_password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webinars`
--
ALTER TABLE `webinars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webinar_co_organizer`
--
ALTER TABLE `webinar_co_organizer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webinar_documents`
--
ALTER TABLE `webinar_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webinar_like`
--
ALTER TABLE `webinar_like`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webinar_questions`
--
ALTER TABLE `webinar_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webinar_question_result`
--
ALTER TABLE `webinar_question_result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webinar_selfstudy_video_duration`
--
ALTER TABLE `webinar_selfstudy_video_duration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webinar_user_register`
--
ALTER TABLE `webinar_user_register`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company_user`
--
ALTER TABLE `company_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_levels`
--
ALTER TABLE `course_levels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `speakers`
--
ALTER TABLE `speakers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `speaker_follow`
--
ALTER TABLE `speaker_follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `speaker_invitation`
--
ALTER TABLE `speaker_invitation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `speaker_ratings`
--
ALTER TABLE `speaker_ratings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tag_user`
--
ALTER TABLE `tag_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tag_webinar`
--
ALTER TABLE `tag_webinar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_password_reset`
--
ALTER TABLE `user_password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `webinars`
--
ALTER TABLE `webinars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `webinar_co_organizer`
--
ALTER TABLE `webinar_co_organizer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `webinar_documents`
--
ALTER TABLE `webinar_documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webinar_like`
--
ALTER TABLE `webinar_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `webinar_questions`
--
ALTER TABLE `webinar_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `webinar_question_result`
--
ALTER TABLE `webinar_question_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `webinar_selfstudy_video_duration`
--
ALTER TABLE `webinar_selfstudy_video_duration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `webinar_user_register`
--
ALTER TABLE `webinar_user_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
