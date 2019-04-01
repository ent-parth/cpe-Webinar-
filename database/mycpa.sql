-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2018 at 12:47 PM
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
(1, 'Sanjay', 'Chabhadiya', 'sanjay47c@gmail.com', '$2y$10$RXQX2FhBx6l0CtPR5qFQWexyDHF7YJVWkLffhQVKAgPTXJe7X46Xy', 'hPJpceFYSYlvnQ5J57AvNUFZxfs5S6sn1UHVgt10lX35zxfEKQY0BKp9Jonp', NULL, '7894561230', 'active', 0, 1, NULL, '2018-12-17 07:12:14'),
(6, 'jignesh dodiya', 'Dodiya', 'jigneshdodiya10@gmail.com', '$2y$10$88OH.I5clTmRBYEGvGOaMe6p3NjmlqQ4/0i/lweQ.L4r6HyPsI0C6', NULL, NULL, '9979006185', 'inactive', 1, 1, '2018-12-17 06:26:10', '2018-12-18 06:48:04');

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
(1, 'Twocompo', NULL, NULL, NULL, NULL, 'active', 0, 0, '2018-12-03 04:36:38', '2018-12-03 04:36:38');

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
(1, 'webinar_add', 'Webinar Add', 'Webinar Add', 'active', '2018-12-16 18:30:00', NULL, 1, NULL),
(2, 'webinar_edit', 'Webinar Edit', 'Webinar Edit', 'active', '2018-12-16 18:30:00', '2018-12-16 18:30:00', 1, NULL),
(3, 'webinar_delete', 'Webinar Delete', 'Webinar Delete', 'active', '2018-12-16 18:30:00', NULL, 1, NULL),
(4, 'webinar_view', 'Webinar View', 'Webinar View', 'active', '2018-12-16 18:30:00', '2018-12-16 18:30:00', 1, NULL);

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
(14, 1, 2, 1),
(15, 3, 2, 1),
(16, 2, 2, 1),
(17, 4, 2, 1);

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
(2, 'sanjay47c@gmail.com', 'sanjay47c@gmail.com', 'sanjay47c@gmail.com', 'active', '2018-12-16 18:30:00', NULL, 1, NULL);

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
(1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive','delete') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `series`
--

INSERT INTO `series` (`id`, `name`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'any', 'delete', '2018-11-30 13:00:00', 1, NULL, 1),
(2, 'abc', 'active', '2018-11-30 13:00:00', 1, NULL, 1);

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
(1, 1, 'jignesh', 'dodiya', 'jigneshdodiya10@gmail.com', '$2y$10$VPZyPIZJdSPNNYbPrnY.NOsnCTzcHHz7EzGG2MQo2KAy9sv4ZluN6', '9979006185', 'SmAGGxFoiHf1N47Vt1A8XZguPVcUAekPmgQlfXM7.png', 1, 1, 1, '380015', '<p>testing</p>', '<p>testing</p>', NULL, 0, 1, 'active', NULL, '2018-12-03 04:36:38', '2018-12-03 04:37:36');

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
-- Table structure for table `speaker_invitation`
--

CREATE TABLE `speaker_invitation` (
  `id` int(11) NOT NULL,
  `webinar_id` int(11) NOT NULL,
  `speaker_id` int(11) NOT NULL,
  `status` enum('active','pending','reject','') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `speaker_invitation`
--

INSERT INTO `speaker_invitation` (`id`, `webinar_id`, `speaker_id`, `status`, `created_at`, `updated_at`) VALUES
(8, 1, 3, 'pending', '2018-12-17 14:47:58', NULL);

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
(6, 4, 2, '2018-12-20 00:25:05', NULL);

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
  `timezone_id` int(11) NOT NULL,
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

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `contact_no`, `firm_name`, `country_id`, `state_id`, `city_id`, `zipcode`, `timezone_id`, `user_type_id`, `designation`, `ptin_number`, `credit`, `created_by`, `modified_by`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'jignesh', 'dodiya', 'jigneshdodiya10@gmail.com', 'eyJpdiI6IkJteE05VERmRXU3N2p4OXFyYmgrOFE9PSIsInZhbHVlIjoiUnphV0dGT2ZwbFVqRkhNbVo3YjRYZz09IiwibWFjIjoiN2MyMmNlNWRhYjI3ODFhMjYwNjE2NDM2ODM4ZTE0MzdjOGU3YzNmZWE0MTIxMDk0NmExMDIyMmE2OWNjNTkwNCJ9', '9998989898', 'test', 99, 0, 0, '', 0, 1, NULL, NULL, NULL, 0, 0, 'active', NULL, NULL, NULL);

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
(1, 'jigneshdodiya10@gmail.com', 'eyJpdiI6IkFwQndQbmp6ZnRMVE5hYkxrb1d3Ymc9PSIsInZhbHVlIjoiMjFoc3pYYWNnejJVMEM0VzdDMDgxOUNjTVJmQUJPUGlad2ZOXC9DYnJlbWdFZVwvb3VxZ2tqUzFZaE5YSDMyN1I2IiwibWFjIjoiYTk2ZjJlYTRkYWYwZTJjMDNkZGJhZDg2NzdlMGY0NjRmZjk1NWRjMGJmYzg0YjM4Nzg2NWE3YmIyNWQ3MTkxMiJ9', '2018-12-19 13:37:47');

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
  `fee` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webinar_transcription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentation_length` text COLLATE utf8mb4_unicode_ci,
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
  `status` enum('active','inactive','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `video` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `webinar_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vimeo_video_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vimeo_response` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vimeo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vimeo_embaded` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vimeo_password` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webinar_response` text COLLATE utf8mb4_unicode_ci,
  `series` int(11) DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `added_by` enum('admin','speaker') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `webinars`
--

INSERT INTO `webinars` (`id`, `title`, `webinar_type`, `description`, `fee`, `webinar_transcription`, `presentation_length`, `time_zone`, `recorded_date`, `start_time`, `end_time`, `subject_area`, `course_level`, `pre_requirement`, `advance_preparation`, `who_should_attend`, `tag`, `documents`, `faq_1`, `faq_2`, `faq_3`, `faq_4`, `faq_5`, `status`, `video`, `webinar_key`, `vimeo_video_code`, `vimeo_response`, `vimeo_url`, `vimeo_embaded`, `vimeo_password`, `webinar_response`, `series`, `reason`, `added_by`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 'testing new webinar', 'live', 'final testing new webinar', '2018-12-04', '03:30:00', '', 'US/Central', '2018-12-03', '2018-12-07 09:26:00', '2018-12-09 05:18:00', '2', '3', 'tyutyu', 'utyutyu', 'business owner', '', '', '<p>tyu</p>', '<p>tyuty</p>', '', '', '', 'inactive', '', NULL, '', '', '', '', NULL, NULL, NULL, NULL, 'speaker', 1, 1, '2018-12-03 04:39:24', '2018-12-05 01:55:26'),
(2, 'test my first speaker webinar', 'live', 'test my first speaker webinar', '23', 'sadsadsd asdasd saddsasd a', '34', NULL, '2018-12-04', '2018-12-04 14:11:15', '2018-12-04 17:15:30', 'CA with Banking', 'Advance', 'Yes', 'No', 'enrolled agent', '1,2', 'sadasdsadd.jpg', 'dfsdfdsfsd', 'sdfsdfsdf', 'sdfsdfsdf', 'sdfsdfsd', 'sdfsdfsdfs', 'delete', '', NULL, '', '', '', '', NULL, NULL, NULL, NULL, 'speaker', 0, 1, '2018-12-03 18:30:00', NULL),
(3, 'dfgdfgdfgdfg', NULL, '<p>gfdgfdgdf</p>', NULL, '34543543', '', NULL, '2018-12-05', '2018-12-05 11:55:48', '2018-12-05 11:25:48', '2,1', '4,3', 'fsdf fsdf', 'sdfsdfsdf', 'enrolled agent', '2,1', '15439881111522491451Jignesh.jpg', '<p>dsfsdfdf</p>', '<p>sdfsdfsdfsdfsdf</p>', '<p>sdfsdf</p>', '<p>sdfsdfs</p>', '<p>fsdfsdfsd</p>', 'delete', '', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, 0, 1, '2018-12-05 00:05:11', NULL),
(4, 'dfgdfgdfgdfg', 'live', 'jignesh created and new webinar', '43534', '34543543', '', 'US/Central', '2018-12-05', '2018-12-08 11:55:48', '2018-12-09 11:25:48', '2,1', '4,3', 'fsdf fsdf', 'sdfsdfsdf', 'cpa', '2,1', '1543993605usa.jpg', '<p>dsfsdfdf</p>', '<p>sdfsdfsdfsdfsdf</p>', '<p>sdfsdf</p>', '<p>sdfsdfs</p>', '<p>fsdfsdfsd</p>', 'active', '', '8801831768699715339', '', '', '', '', NULL, NULL, NULL, NULL, NULL, 0, 1, '2018-12-05 00:07:07', '2018-12-05 04:39:15'),
(5, 'dfgdfgdfgdfg', 'live', 'jignesh', '43534', '34543543', '', 'US/Mountain', '2018-12-05', '2018-12-05 11:55:48', '2018-12-05 11:25:48', '2,1', '4,3', 'fsdf fsdf', 'sdfsdfsdf', 'bookkeeper', '2,1', '154399216211.jpg', '<p>dsfsdfdf</p>', '<p>sdfsdfsdfsdfsdf</p>', '<p>sdfsdf</p>', '<p>sdfsdfs</p>', '<p>fsdfsdfsd</p>', 'inactive', '', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, 0, 1, '2018-12-05 00:09:47', '2018-12-05 04:45:06'),
(6, 'prashant', 'live', '<p>any descrprtrtrrt</p>', '43534', '34543543', '', 'US/Hawaii', '2018-12-06', '2018-12-06 22:15:52', '2018-12-07 18:55:52', '2,1', '3,1', 'any', NULL, 'bookkeeper', '2,1', '1544010509download.png', NULL, NULL, NULL, NULL, NULL, 'inactive', '', NULL, '', '', '', '', NULL, NULL, NULL, NULL, 'speaker', 1, 1, '2018-12-05 06:18:29', '2018-12-06 08:00:25'),
(7, 'jignesh', 'live', '<p>asdsad</p>', '423', 'rewrewr', '', 'US/Alaska', '2018-12-05', '2018-12-05 17:30:59', '2018-12-05 18:30:59', '1', '3', 'wrwerew', 'rwer', 'bookkeeper', '1', '1544011319nairobi.jpg', '<p>wer</p>', '<p>wer</p>', '<p>wer</p>', '<p>wer</p>', '<p>wer</p>', 'inactive', '', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, 1, 0, '2018-12-05 06:31:59', NULL),
(8, 'test self study', 'self_study', 'test video for website uplaod code', '3245', 'fsdfsdfdsf', '4', 'Pacific/Midway', '2018-12-06', NULL, NULL, '2', '3', 'retriever', 'trete', 'enrolled agent,attorney', '2', '1544071710new-york.jpg', 'ertret', 'ert', 'ret', 'ert', 'ert', 'active', '154407184715283885.mp4', NULL, '305210018', '{\"uri\":\"/videos/305210018\",\"name\":\"test self study\",\"description\":\"test video for website uplaod code\",\"link\":\"https://vimeo.com/305210018\",\"duration\":0,\"width\":400,\"language\":null,\"height\":300,\"embed\":{\"buttons\":{\"like\":true,\"watchlater\":true,\"share\":true,\"embed\":true,\"hd\":false,\"fullscreen\":true,\"scaling\":true},\"logos\":{\"vimeo\":true,\"custom\":{\"active\":false,\"link\":null,\"sticky\":false}},\"title\":{\"name\":\"user\",\"owner\":\"user\",\"portrait\":\"user\"},\"playbar\":true,\"volume\":true,\"speed\":false,\"color\":\"00adef\",\"uri\":null,\"html\":\"<iframe src=\\\"https://player.vimeo.com/video/305210018?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\\\" width=\\\"400\\\" height=\\\"300\\\" frameborder=\\\"0\\\" title=\\\"test self study\\\" allow=\\\"autoplay; fullscreen\\\" allowfullscreen></iframe>\",\"badges\":{\"hdr\":false,\"live\":{\"streaming\":false,\"archived\":false},\"staff_pick\":{\"normal\":false,\"best_of_the_month\":false,\"best_of_the_year\":false,\"premiere\":false},\"vod\":false,\"weekend_challenge\":false}},\"created_time\":\"2018-12-08T12:55:13+00:00\",\"modified_time\":\"2018-12-08T12:55:13+00:00\",\"release_time\":\"2018-12-08T12:55:13+00:00\",\"content_rating\":[\"unrated\"],\"license\":null,\"privacy\":{\"view\":\"password\",\"embed\":\"public\",\"download\":true,\"add\":true,\"comments\":\"anybody\"},\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":100,\"height\":75,\"link\":\"https://i.vimeocdn.com/video/default_100x75?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_100x75&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":200,\"height\":150,\"link\":\"https://i.vimeocdn.com/video/default_200x150?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_200x150&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":295,\"height\":166,\"link\":\"https://i.vimeocdn.com/video/default_295x166?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_295x166&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":640,\"height\":480,\"link\":\"https://i.vimeocdn.com/video/default_640x480?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_640x480&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":960,\"height\":720,\"link\":\"https://i.vimeocdn.com/video/default_960x720?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_960x720&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1280,\"height\":960,\"link\":\"https://i.vimeocdn.com/video/default_1280x960?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1280x960&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1920,\"height\":1440,\"link\":\"https://i.vimeocdn.com/video/default_1920x1440?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1920x1440&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"}],\"resource_key\":\"7a491d0e8cad256a8ac2fd6d207e647c1b034bad\"},\"tags\":[],\"stats\":{\"plays\":0},\"categories\":[],\"metadata\":{\"connections\":{\"comments\":{\"uri\":\"/videos/305210018/comments\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"credits\":{\"uri\":\"/videos/305210018/credits\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"likes\":{\"uri\":\"/videos/305210018/likes\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/videos/305210018/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"texttracks\":{\"uri\":\"/videos/305210018/texttracks\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"related\":null,\"recommendations\":{\"uri\":\"/videos/305210018/recommendations\",\"options\":[\"GET\"]}},\"interactions\":{\"watchlater\":{\"uri\":\"/users/92271093/watchlater/305210018?auth=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1Ijo5MjI3MTA5MywidXJpIjoiXC91c2Vyc1wvOTIyNzEwOTNcL3dhdGNobGF0ZXJcLzMwNTIxMDAxOCIsImV4cCI6MTU0NDI3NzMxM30.1xObTJnykqHopQ_7x9FssM6yvenlYbGB6ORiZINHo0Q\",\"options\":[\"GET\",\"PUT\",\"DELETE\"],\"added\":false,\"added_time\":null},\"report\":{\"uri\":\"/videos/305210018/report\",\"options\":[\"POST\"],\"reason\":[\"pornographic\",\"harassment\",\"advertisement\",\"ripoff\",\"incorrect rating\",\"spam\"]}}},\"user\":{\"uri\":\"/users/92271093\",\"name\":\"Gary Morya\",\"link\":\"https://vimeo.com/user92271093\",\"location\":null,\"bio\":null,\"created_time\":\"2018-11-29T16:57:20+00:00\",\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":30,\"height\":30,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_30x30.png\"},{\"width\":75,\"height\":75,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_75x75.png\"},{\"width\":100,\"height\":100,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_100x100.png\"},{\"width\":300,\"height\":300,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_300x300.png\"},{\"width\":72,\"height\":72,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_72x72.png\"},{\"width\":144,\"height\":144,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_144x144.png\"},{\"width\":216,\"height\":216,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_216x216.png\"},{\"width\":288,\"height\":288,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_288x288.png\"},{\"width\":360,\"height\":360,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_360x360.png\"}],\"resource_key\":\"06cd312fcc3908e2d839aeb00ccaaf434acb0859\"},\"websites\":[],\"metadata\":{\"connections\":{\"albums\":{\"uri\":\"/users/92271093/albums\",\"options\":[\"GET\"],\"total\":0},\"appearances\":{\"uri\":\"/users/92271093/appearances\",\"options\":[\"GET\"],\"total\":0},\"categories\":{\"uri\":\"/users/92271093/categories\",\"options\":[\"GET\"],\"total\":0},\"channels\":{\"uri\":\"/users/92271093/channels\",\"options\":[\"GET\"],\"total\":0},\"feed\":{\"uri\":\"/users/92271093/feed\",\"options\":[\"GET\"]},\"followers\":{\"uri\":\"/users/92271093/followers\",\"options\":[\"GET\"],\"total\":0},\"following\":{\"uri\":\"/users/92271093/following\",\"options\":[\"GET\"],\"total\":0},\"groups\":{\"uri\":\"/users/92271093/groups\",\"options\":[\"GET\"],\"total\":0},\"likes\":{\"uri\":\"/users/92271093/likes\",\"options\":[\"GET\"],\"total\":0},\"moderated_channels\":{\"uri\":\"/users/92271093/channels?filter=moderated\",\"options\":[\"GET\"],\"total\":0},\"portfolios\":{\"uri\":\"/users/92271093/portfolios\",\"options\":[\"GET\"],\"total\":0},\"videos\":{\"uri\":\"/users/92271093/videos\",\"options\":[\"GET\"],\"total\":4},\"watchlater\":{\"uri\":\"/users/92271093/watchlater\",\"options\":[\"GET\"],\"total\":0},\"shared\":{\"uri\":\"/users/92271093/shared/videos\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/users/92271093/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"watched_videos\":{\"uri\":\"/me/watched/videos\",\"options\":[\"GET\"],\"total\":2},\"folders\":{\"uri\":\"/me/folders\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"block\":{\"uri\":\"/me/block\",\"options\":[\"GET\"],\"total\":0}}},\"preferences\":{\"videos\":{\"privacy\":{\"view\":\"anybody\",\"comments\":\"anybody\",\"embed\":\"public\",\"download\":true,\"add\":true}}},\"content_filter\":[\"language\",\"drugs\",\"violence\",\"nudity\",\"safe\",\"unrated\"],\"upload_quota\":{\"space\":{\"free\":5310617120,\"max\":5368709120,\"used\":58092000,\"showing\":\"periodic\"},\"periodic\":{\"free\":5310617120,\"max\":5368709120,\"used\":58092000,\"reset_date\":\"2018-12-10 00:00:00\"},\"lifetime\":{\"free\":null,\"max\":null,\"used\":null}},\"resource_key\":\"3214185ecce3ee369a9eb45d28f65745f4485886\",\"account\":\"plus\"},\"review_page\":{\"active\":true,\"link\":\"https://vimeo.com/user92271093/review/305210018/1887c46685\"},\"parent_folder\":null,\"last_user_action_event_date\":\"2018-12-08T12:55:13+00:00\",\"app\":{\"name\":\"Mycpe\",\"uri\":\"/apps/138804\"},\"status\":\"transcode_starting\",\"resource_key\":\"50409b47a7b687dca976a601cb8a60adc09f1405\",\"upload\":{\"status\":\"in_progress\",\"upload_link\":null,\"form\":null,\"complete_uri\":null,\"approach\":\"pull\",\"size\":null,\"redirect_url\":null,\"link\":\"https://www.edge196.com/uploads/pitch_deck/video/1539156509The-Global-Startup-Ecosystem-Report-2017.mp4\"},\"transcode\":{\"status\":\"in_progress\"}}', 'https://vimeo.com/305210018', '<iframe src=\"https://player.vimeo.com/video/305210018?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\" width=\"400\" height=\"300\" frameborder=\"0\" title=\"test self study\" allow=\"autoplay; fullscreen\" allowfullscreen></iframe>', 'yFxe5nmU', NULL, NULL, NULL, NULL, 1, 1, '2018-12-05 23:18:30', '2018-12-05 23:23:37'),
(9, 'prashant', 'live', '<p>sdfsdfsdf</p>', '345', '34543543', '456', 'Pacific/Midway', '2018-12-12', '2018-12-06 10:45:39', '2018-12-06 10:45:39', '2', '1', 'dfgfdg', 'fdgdfg', 'enrolled agent,bookkeeper,attorney', '2', '1544072587dhilabslogo.png', 'gfdgg', 'dfgfd', 'gdfgdf', 'gdfgdfg', 'dfgdfgfg', 'inactive', '154407259215283885.mp4', NULL, '', '', '', '', NULL, NULL, NULL, NULL, NULL, 1, 1, '2018-12-05 23:33:07', '2018-12-08 04:07:52'),
(10, 'admin can add', 'live', 'test my first speaker webinar', '53443', '34543543', NULL, 'America/Lima', '2018-12-06', '2018-12-08 12:30:03', '2018-12-08 14:30:03', '', '4', '345435', '435erter', 'enrolled agent', '2', '1544079732usa.jpg', 'retret', 'retretret', 'retert', 'reterte', 'ertreter', 'active', '', '8911406898526070029', '', '', '', '', NULL, NULL, NULL, NULL, NULL, 1, 1, '2018-12-06 01:32:12', '2018-12-08 04:57:00'),
(11, 'jignesh testing new webinar', 'live', 'final testing new webinar', '54', 'yrtytry', '56', 'US/Samoa', '2018-12-06', '2018-12-08 18:35:49', '2018-12-08 21:33:27', '2', '4', 'fhfg', 'hgfhfg', 'bookkeeper', '', '1544101758download.png', NULL, NULL, NULL, NULL, NULL, 'active', '154410176415283885.mp4', '7514827020109031692', '', '', '', '', NULL, NULL, NULL, NULL, 'admin', 1, 1, '2018-12-06 07:39:18', '2018-12-06 07:40:07'),
(12, 'test by jignesh', 'live', 'for delete testing', '564', 'testing', NULL, 'US/Hawaii', '2018-12-10', '2018-12-10 21:50:37', '2018-12-10 22:50:37', '2', '4', 'testing', 'testing', '6', '2', '1544419467new-york.jpg', 'testing', 'testing', 'testing', 'testing', 'testing', 'inactive', '', '', '', '', '', '', NULL, '', NULL, NULL, 'admin', 1, 1, '2018-12-09 23:54:27', '2018-12-10 01:08:34'),
(13, 'test self study', 'self_study', 'Description', '43', 'Webinar Transcription', '3', 'Pacific/Midway', '2018-12-10', NULL, NULL, '2', '4', 'dasdasd Requirement', 'dasd Preparation', '6', '2,1', '1544427558usa-250-140.jpg', 'dsad', 'asd', 'asd', 'asd', 'sad', 'active', '154442757015283885.mp4', NULL, '306326682', '{\"uri\":\"/videos/306326682\",\"name\":\"test self study\",\"description\":\"Description\",\"link\":\"https://vimeo.com/306326682\",\"duration\":0,\"width\":400,\"language\":null,\"height\":300,\"embed\":{\"buttons\":{\"like\":true,\"watchlater\":true,\"share\":true,\"embed\":true,\"hd\":false,\"fullscreen\":true,\"scaling\":true},\"logos\":{\"vimeo\":true,\"custom\":{\"active\":false,\"link\":null,\"sticky\":false}},\"title\":{\"name\":\"user\",\"owner\":\"user\",\"portrait\":\"user\"},\"playbar\":true,\"volume\":true,\"speed\":false,\"color\":\"00adef\",\"uri\":null,\"html\":\"<iframe src=\\\"https://player.vimeo.com/video/306326682?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\\\" width=\\\"400\\\" height=\\\"300\\\" frameborder=\\\"0\\\" title=\\\"test self study\\\" allow=\\\"autoplay; fullscreen\\\" allowfullscreen></iframe>\",\"badges\":{\"hdr\":false,\"live\":{\"streaming\":false,\"archived\":false},\"staff_pick\":{\"normal\":false,\"best_of_the_month\":false,\"best_of_the_year\":false,\"premiere\":false},\"vod\":false,\"weekend_challenge\":false}},\"created_time\":\"2018-12-14T05:37:44+00:00\",\"modified_time\":\"2018-12-14T05:37:44+00:00\",\"release_time\":\"2018-12-14T05:37:44+00:00\",\"content_rating\":[\"unrated\"],\"license\":null,\"privacy\":{\"view\":\"password\",\"embed\":\"public\",\"download\":true,\"add\":true,\"comments\":\"anybody\"},\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":100,\"height\":75,\"link\":\"https://i.vimeocdn.com/video/default_100x75?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_100x75&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":200,\"height\":150,\"link\":\"https://i.vimeocdn.com/video/default_200x150?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_200x150&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":295,\"height\":166,\"link\":\"https://i.vimeocdn.com/video/default_295x166?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_295x166&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":640,\"height\":480,\"link\":\"https://i.vimeocdn.com/video/default_640x480?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_640x480&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":960,\"height\":720,\"link\":\"https://i.vimeocdn.com/video/default_960x720?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_960x720&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1280,\"height\":960,\"link\":\"https://i.vimeocdn.com/video/default_1280x960?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1280x960&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"},{\"width\":1920,\"height\":1440,\"link\":\"https://i.vimeocdn.com/video/default_1920x1440?r=pad\",\"link_with_play_button\":\"https://i.vimeocdn.com/filter/overlay?src0=https%3A%2F%2Fi.vimeocdn.com%2Fvideo%2Fdefault_1920x1440&src1=http%3A%2F%2Ff.vimeocdn.com%2Fp%2Fimages%2Fcrawler_play.png\"}],\"resource_key\":\"7a491d0e8cad256a8ac2fd6d207e647c1b034bad\"},\"tags\":[],\"stats\":{\"plays\":0},\"categories\":[],\"metadata\":{\"connections\":{\"comments\":{\"uri\":\"/videos/306326682/comments\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"credits\":{\"uri\":\"/videos/306326682/credits\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"likes\":{\"uri\":\"/videos/306326682/likes\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/videos/306326682/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"texttracks\":{\"uri\":\"/videos/306326682/texttracks\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"related\":null,\"recommendations\":{\"uri\":\"/videos/306326682/recommendations\",\"options\":[\"GET\"]}},\"interactions\":{\"watchlater\":{\"uri\":\"/users/92271093/watchlater/306326682?auth=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1Ijo5MjI3MTA5MywidXJpIjoiXC91c2Vyc1wvOTIyNzEwOTNcL3dhdGNobGF0ZXJcLzMwNjMyNjY4MiIsImV4cCI6MTU0NDc2OTQ2NH0.48vYoPfNfIGUjcu5kJnStjnZh134E9s4qjE7L2ZxNtk\",\"options\":[\"GET\",\"PUT\",\"DELETE\"],\"added\":false,\"added_time\":null},\"report\":{\"uri\":\"/videos/306326682/report\",\"options\":[\"POST\"],\"reason\":[\"pornographic\",\"harassment\",\"advertisement\",\"ripoff\",\"incorrect rating\",\"spam\"]}}},\"user\":{\"uri\":\"/users/92271093\",\"name\":\"Gary Morya\",\"link\":\"https://vimeo.com/user92271093\",\"location\":null,\"bio\":null,\"created_time\":\"2018-11-29T16:57:20+00:00\",\"pictures\":{\"uri\":null,\"active\":false,\"type\":\"default\",\"sizes\":[{\"width\":30,\"height\":30,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_30x30.png\"},{\"width\":75,\"height\":75,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_75x75.png\"},{\"width\":100,\"height\":100,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_100x100.png\"},{\"width\":300,\"height\":300,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_300x300.png\"},{\"width\":72,\"height\":72,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_72x72.png\"},{\"width\":144,\"height\":144,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_144x144.png\"},{\"width\":216,\"height\":216,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_216x216.png\"},{\"width\":288,\"height\":288,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_288x288.png\"},{\"width\":360,\"height\":360,\"link\":\"https://i.vimeocdn.com/portrait/defaults-blue_360x360.png\"}],\"resource_key\":\"06cd312fcc3908e2d839aeb00ccaaf434acb0859\"},\"websites\":[],\"metadata\":{\"connections\":{\"albums\":{\"uri\":\"/users/92271093/albums\",\"options\":[\"GET\"],\"total\":0},\"appearances\":{\"uri\":\"/users/92271093/appearances\",\"options\":[\"GET\"],\"total\":0},\"categories\":{\"uri\":\"/users/92271093/categories\",\"options\":[\"GET\"],\"total\":0},\"channels\":{\"uri\":\"/users/92271093/channels\",\"options\":[\"GET\"],\"total\":0},\"feed\":{\"uri\":\"/users/92271093/feed\",\"options\":[\"GET\"]},\"followers\":{\"uri\":\"/users/92271093/followers\",\"options\":[\"GET\"],\"total\":0},\"following\":{\"uri\":\"/users/92271093/following\",\"options\":[\"GET\"],\"total\":0},\"groups\":{\"uri\":\"/users/92271093/groups\",\"options\":[\"GET\"],\"total\":0},\"likes\":{\"uri\":\"/users/92271093/likes\",\"options\":[\"GET\"],\"total\":0},\"moderated_channels\":{\"uri\":\"/users/92271093/channels?filter=moderated\",\"options\":[\"GET\"],\"total\":0},\"portfolios\":{\"uri\":\"/users/92271093/portfolios\",\"options\":[\"GET\"],\"total\":0},\"videos\":{\"uri\":\"/users/92271093/videos\",\"options\":[\"GET\"],\"total\":6},\"watchlater\":{\"uri\":\"/users/92271093/watchlater\",\"options\":[\"GET\"],\"total\":0},\"shared\":{\"uri\":\"/users/92271093/shared/videos\",\"options\":[\"GET\"],\"total\":0},\"pictures\":{\"uri\":\"/users/92271093/pictures\",\"options\":[\"GET\",\"POST\"],\"total\":0},\"watched_videos\":{\"uri\":\"/me/watched/videos\",\"options\":[\"GET\"],\"total\":4},\"folders\":{\"uri\":\"/me/folders\",\"options\":[\"GET\",\"POST\"],\"total\":1},\"block\":{\"uri\":\"/me/block\",\"options\":[\"GET\"],\"total\":0}}},\"preferences\":{\"videos\":{\"privacy\":{\"view\":\"anybody\",\"comments\":\"anybody\",\"embed\":\"public\",\"download\":true,\"add\":true}}},\"content_filter\":[\"language\",\"drugs\",\"violence\",\"nudity\",\"safe\",\"unrated\"],\"upload_quota\":{\"space\":{\"free\":5329981120,\"max\":5368709120,\"used\":38728000,\"showing\":\"periodic\"},\"periodic\":{\"free\":5329981120,\"max\":5368709120,\"used\":38728000,\"reset_date\":\"2018-12-17 00:00:00\"},\"lifetime\":{\"free\":null,\"max\":null,\"used\":null}},\"resource_key\":\"3214185ecce3ee369a9eb45d28f65745f4485886\",\"account\":\"plus\"},\"review_page\":{\"active\":true,\"link\":\"https://vimeo.com/user92271093/review/306326682/e0647c0f2b\"},\"parent_folder\":null,\"last_user_action_event_date\":\"2018-12-14T05:37:44+00:00\",\"app\":{\"name\":\"Mycpe\",\"uri\":\"/apps/138804\"},\"status\":\"transcode_starting\",\"resource_key\":\"ecce7c5a1cb78a84c2d4c0e6d37ccd5796b8736f\",\"upload\":{\"status\":\"in_progress\",\"upload_link\":null,\"form\":null,\"complete_uri\":null,\"approach\":\"pull\",\"size\":null,\"redirect_url\":null,\"link\":\"https://www.edge196.com/uploads/pitch_deck/video/1539156509The-Global-Startup-Ecosystem-Report-2017.mp4\"},\"transcode\":{\"status\":\"in_progress\"}}', 'https://vimeo.com/306326682', '<iframe src=\"https://player.vimeo.com/video/306326682?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&app_id=138804\" width=\"400\" height=\"300\" frameborder=\"0\" title=\"test self study\" allow=\"autoplay; fullscreen\" allowfullscreen></iframe>', 'A7ixeFSD', NULL, NULL, NULL, NULL, 1, 1, '2018-12-10 02:09:18', '2018-12-13 23:24:30'),
(14, 'Learn PHP and manage website', 'live', 'Learn PHP and manage website Learn PHP and manage website Learn PHP and manage website', '43543', 'Webinar Transcription', NULL, 'US/Hawaii', '2018-12-13', '2018-12-13 04:50:56', '2018-12-13 05:30:56', '2', '3', 'Pre Requirement', 'Advance Preparation', '3', '1', '1544443294usa.jpg', NULL, NULL, NULL, NULL, NULL, 'inactive', '', NULL, '', '', '', '', NULL, NULL, NULL, NULL, 'speaker', 1, 1, '2018-12-10 06:31:34', '2018-12-10 07:06:01'),
(15, 'jignesh create new webinar for check delete', 'live', 'jignesh create new webinar for check delete', '435', 'Webinar Transcription', NULL, 'US/Hawaii', '2018-12-14', '2018-12-14 03:45:38', '2018-12-14 15:20:38', '2', '4', 'jignesh create new webinar for check delete', 'jignesh create new webinar for check delete', '4', '2', '1544702040download.png', 'jignesh create new webinar for check delete', 'jignesh create new webinar for check delete', 'jignesh create new webinar for check delete', 'jignesh create new webinar for check delete', 'jignesh create new webinar for check delete', 'inactive', '', '', '', '', '', '', NULL, '', 2, NULL, 'admin', 1, 1, '2018-12-13 06:24:00', '2018-12-13 07:21:14'),
(16, 'sdsad', 'live', 'asdasdasd', '2342', NULL, NULL, 'US/Samoa', '2018-12-18', '2018-12-18 05:30:15', '2018-12-18 06:15:15', '2', '4', 'dasdsa', 'dasdasd', '4', '2', '154505088111.jpg', 'sadasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'inactive', '', NULL, '', '', '', '', NULL, NULL, NULL, NULL, 'admin', 1, NULL, '2018-12-17 07:18:01', NULL),
(17, 'test for title', 'live', 'sdasdasda', NULL, NULL, NULL, 'Europe/Copenhagen', '2018-12-20', '2018-12-20 11:25:01', '2018-12-20 17:30:01', '2,1', '4,3,1', 'asdasdasd', 'asdasdas', '4,3,6,5', '2,1', '154528824111.jpg', NULL, NULL, NULL, NULL, NULL, 'inactive', '', NULL, '', '', '', '', NULL, NULL, NULL, NULL, 'speaker', 1, NULL, '2018-12-20 01:14:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `webinar_attendies`
--

CREATE TABLE `webinar_attendies` (
  `id` int(10) UNSIGNED NOT NULL,
  `webinar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attending_status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `status` enum('active','inactive','delete') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webinar_questions`
--

INSERT INTO `webinar_questions` (`id`, `webinar_id`, `type`, `time`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `answer`, `status`, `created_at`, `updated_at`, `added_by`, `updated_by`) VALUES
(1, 13, 'final', '11:30:15', 'sdasd', 'asdas', 'asdasd', 'asdas', 'asdasd', 'c', 'active', '2018-12-20 11:29:25', NULL, 1, NULL);

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
-- Indexes for table `webinar_attendies`
--
ALTER TABLE `webinar_attendies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webinar_documents`
--
ALTER TABLE `webinar_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webinar_questions`
--
ALTER TABLE `webinar_questions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `speakers`
--
ALTER TABLE `speakers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `speaker_invitation`
--
ALTER TABLE `speaker_invitation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_password_reset`
--
ALTER TABLE `user_password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `webinars`
--
ALTER TABLE `webinars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `webinar_attendies`
--
ALTER TABLE `webinar_attendies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webinar_documents`
--
ALTER TABLE `webinar_documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webinar_questions`
--
ALTER TABLE `webinar_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
