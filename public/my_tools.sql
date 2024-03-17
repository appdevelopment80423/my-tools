-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2024 at 12:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_tools`
--
CREATE DATABASE IF NOT EXISTS `my_tools` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `my_tools`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `allow_ip` text DEFAULT NULL,
  `ip_restriction` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 =OFF ,1=ON',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `allow_ip`, `ip_restriction`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@test.com', NULL, '$2y$10$VAjsGvPMsdYdgSCY883oaeH5elJc4TZG8BqqXFvtbIYDxyPP43mR6', '115.246.18.235', 0, 'kvV0UKPqTPf0WNTdDb5jCUPp6VOefPMwMRmC1FEEG1ZVoGXZ90uZbPlfZcgM', NULL, '2023-09-26 08:10:38'),
(2, 'Admin', 'admin@test.com', NULL, '$2y$10$SEBmPmDmpuk/kZnpb/qQkuOl/xc9Q2bXpWyLDMhjfBPfM5WYNH8Q2', '115.246.18.235', 0, NULL, NULL, '2023-09-26 08:19:06'),
(3, 'Manager', 'manager@test.com', NULL, '$2y$10$.bg7FoeEcDjX2ijb.gOEHeRn0lWuqYeoMRW.a0moOBX7AXgiLecoa', NULL, 0, NULL, NULL, NULL),
(4, 'Project Manager', 'pm@test.com', NULL, '$2y$10$/j7qfX22t7xhxGOGX3HGKegazZAbKBh3NAHVJ6ItwIhBEP0OqYPV6', '115.246.18.235', 0, NULL, NULL, '2023-10-27 08:28:41'),
(5, 'HR', 'hr@test.com', NULL, '$2y$10$VAjsGvPMsdYdgSCY883oaeH5elJc4TZG8BqqXFvtbIYDxyPP43mR6', '115.246.18.235', 1, NULL, NULL, '2023-09-26 08:28:55'),
(6, 'TL', 'tl@gmail.com', NULL, '$2y$10$D.A2H.9Yy8HBCaFTRTHI..vyyx8IClR9rDCD9.mA3j.exGikFG2C.', NULL, 0, NULL, '2023-07-31 00:02:01', '2023-07-31 00:02:38');

-- --------------------------------------------------------

--
-- Table structure for table `allotted_ip`
--

CREATE TABLE `allotted_ip` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Inactive, 1=Active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `allotted_ip`
--

INSERT INTO `allotted_ip` (`id`, `ip_address`, `status`, `created_at`, `updated_at`) VALUES
(3, '12.12.12.12', 1, '2023-09-26 11:00:25', '2023-09-26 11:00:25'),
(4, '15.246.18.235', 1, '2023-09-26 11:03:27', '2023-09-26 11:03:27'),
(5, '115.246.18.235', 1, '2023-09-26 13:43:40', '2023-09-26 13:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(100) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(150) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_04_20_134321_create_permission_tables', 1),
(6, '2023_06_21_061440_create_admins_table', 1),
(7, '2023_06_27_114448_create_settings_table', 1),
(8, '2023_08_16_114049_create_jobs_table', 2),
(9, '2023_08_16_174541_create_jobs_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(100) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(100) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Admin', 1),
(1, 'App\\Models\\Admin', 8),
(1, 'App\\Models\\Admin', 9),
(2, 'App\\Models\\Admin', 2),
(3, 'App\\Models\\Admin', 3),
(4, 'App\\Models\\Admin', 4),
(5, 'App\\Models\\Admin', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `guard_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'role_access', 'admin', NULL, NULL),
(3, 'role_create', 'admin', NULL, NULL),
(4, 'role_edit', 'admin', NULL, NULL),
(5, 'role_delete', 'admin', NULL, NULL),
(6, 'permission_access', 'admin', NULL, NULL),
(7, 'permission_create', 'admin', NULL, NULL),
(8, 'permission_edit', 'admin', NULL, NULL),
(9, 'permission_delete', 'admin', NULL, NULL),
(14, 'member_access', 'admin', '2023-07-13 03:07:00', '2023-07-13 03:07:00'),
(16, 'member_edit', 'admin', '2023-07-13 03:07:21', '2023-07-13 03:07:21'),
(17, 'member_delete', 'admin', '2023-07-13 03:07:40', '2023-07-13 03:07:40'),
(18, 'member_create', 'admin', '2023-07-13 03:15:12', '2023-07-13 03:15:12'),
(19, 'user_access', 'admin', '2023-07-13 03:35:57', '2023-07-13 03:35:57'),
(20, 'user_create', 'admin', '2023-07-13 03:36:05', '2023-07-13 03:36:05'),
(21, 'user_edit', 'admin', '2023-07-13 03:36:14', '2023-07-13 03:36:14'),
(22, 'user_delete', 'admin', '2023-07-13 03:36:27', '2023-07-13 03:36:27'),
(45, 'setting_type_access', 'admin', '2023-07-13 22:01:03', '2023-07-13 22:01:03'),
(49, 'setting_access', 'admin', '2023-07-13 22:01:54', '2023-07-13 22:01:54'),
(59, 'user_approval_access', 'admin', '2023-07-20 05:23:08', '2023-07-20 05:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(100) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `guard_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin', NULL, NULL),
(2, 'Admin', 'admin', NULL, NULL),
(3, 'Manager', 'admin', NULL, NULL),
(4, 'Project Manager', 'admin', NULL, NULL),
(5, 'HR Manager', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(8, 1),
(8, 2),
(9, 1),
(9, 2),
(14, 2),
(16, 2),
(17, 2),
(18, 1),
(18, 2),
(19, 1),
(19, 2),
(19, 3),
(20, 1),
(20, 2),
(21, 1),
(21, 2),
(22, 1),
(22, 2),
(45, 1),
(45, 2),
(49, 1),
(49, 2),
(59, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(75) NOT NULL,
  `value` text NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `setting_type_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `description`, `setting_type_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'support_email', 'support.qfonapp.com', 'For supporting email', 8, 1, '2023-07-12 05:09:49', '2023-07-21 05:54:49'),
(2, 'support_contact', '+91 8141128243', 'for supporting contact', 8, 1, '2023-07-12 05:11:23', '2023-08-22 05:45:28'),
(3, 'min_withdrawal_point_per_transaction', '1', 'Minimum withdraw point when user request to withdraw.', 9, 1, '2023-07-12 05:13:05', '2023-09-11 05:18:32'),
(4, 'max_withdrawal_point_per_transaction', '100', 'Maximum withdraw point when user request to withdraw.', 9, 1, '2023-07-12 05:15:05', '2023-09-11 05:14:28'),
(5, 'max_withdrawal_point_for_daily', '100', 'Maximum withdraw points when user request to withdraw for daily.', 9, 1, '2023-07-12 05:16:17', '2023-09-19 13:00:41'),
(6, 'max_withdrawal_transaction_for_daily', '10', 'Maximum withdraw transaction limit when user request to withdraw for daily.', 9, 1, '2023-07-12 05:17:02', '2023-09-11 05:07:56'),
(7, 'max_referral_level', '20', 'Maximum number of referral levels while adding referral levels with a client product.', 11, 1, '2023-07-13 22:45:38', '2023-07-21 05:54:49'),
(8, 'rupee_of_earning_point', '1', 'One point equal to how many rupees setting', 9, 1, '2023-07-17 00:50:54', '2023-09-25 12:41:48'),
(9, 'max_multi_file_upload', '4', 'Maximum number of upload file when client adding product.', 11, 1, '2023-07-17 03:07:55', '2023-08-21 07:59:07'),
(10, 'max_limit_referral_level_allowed_for_payment', '50', 'Maximum limit referral level allowed for payment.', 8, 1, '2023-07-18 03:04:21', '2023-09-13 05:38:32'),
(12, 'max_file_upload_size', '2', 'Maximum number of upload size in \"MB\" file when client adding product.', 11, 1, '2023-07-24 06:40:36', '2023-07-25 13:10:25'),
(13, 'support_location', '5th Floor, Silver Square Complex, Opp. Dipak School, Nikol, Ahmedabad', 'For supporting location', 8, 1, '2023-07-26 05:14:43', '2023-08-07 04:39:28'),
(14, 'withdrawal_transaction_charge_pr', '10', 'withdrawal transaction charge percentage', 9, 1, '2023-08-09 13:18:14', '2023-09-19 11:54:55'),
(15, 'delete_activity_logs_before_number_of_days', '1', 'Number of days to delete client and user activity logs', 8, 1, '2023-08-21 08:41:53', '2023-08-25 04:44:11'),
(16, 'client_wallet_max_limit', '10000', 'client_wallet_max_limit', 12, 1, '2023-08-22 14:28:29', '2023-09-05 12:22:05'),
(17, 'transfer_user_amount_day', '7', 'user not buy product between days after transfer admin', 8, 1, '2023-08-23 04:47:11', '2023-09-27 10:59:37'),
(18, 'admin_charge', '10', 'admin charge percentage per when  add product', 11, 1, '2023-08-29 12:39:57', '2023-09-01 09:15:05'),
(19, 'gst', '18', 'client top up balance add gst percentage', 12, 1, '2023-08-29 12:41:25', '2023-09-03 13:33:53'),
(20, 'roll_out_per', '10', 'The product is visible to more users than the target user as a percentage of its value', 11, 1, '2023-09-04 13:12:28', '2023-09-06 11:30:06'),
(22, 'whatsapp_link', 'https://play.google.com/store/apps/details?id=com.whatsapp&hl=en-IN', 'To show in Frontend panel.', 13, 1, '2023-09-15 10:14:56', '2023-09-15 12:58:22'),
(23, 'support_location_link', 'https://www.google.com/maps/place/416,Silver+Square/@23.0465814,72.6646002,17z/data=!3m1!4b1!4m6!3m5!1s0x395e87ec80b884e3:0x200789e2d4daed4c!8m2!3d23.0465765!4d72.6671751!16s%2Fg%2F11krdrn9qw?entry=ttu', 'Support location link  show in Frontend panel.', 13, 1, '2023-09-15 10:15:50', '2023-09-15 12:59:29'),
(24, 'app_link', 'https://play.google.com/store/apps/details?id=com.referandearn.app', 'To show in Frontend panel.', 13, 1, '2023-09-15 10:16:19', '2023-09-15 12:58:15'),
(25, 'facebook_link', 'https://play.google.com/store/apps/details?id=com.facebook.katana&hl=en-IN', 'To show in Frontend panel.', 13, 1, '2023-09-15 10:16:31', '2023-09-15 12:58:36'),
(26, 'twitter_link', 'https://play.google.com/store/apps/details?id=com.twitter.android', 'To show in Frontend panel.', 13, 1, '2023-09-15 10:16:41', '2023-09-15 12:58:46'),
(27, 'instagram_link', 'https://play.google.com/store/apps/details?id=com.instagram.android&hl=en-IN', 'To show in Frontend panel.', 13, 1, '2023-09-15 10:16:50', '2023-09-15 12:58:59'),
(28, 'linkedin_link', 'https://play.google.com/store/apps/details?id=com.linkedin.android&hl=en-IN', 'To show in Frontend panel.', 13, 1, '2023-09-15 10:17:00', '2023-09-15 12:59:09'),
(29, 'telegram_link', 'https://play.google.com/store/apps/details?id=org.telegram.messenger&hl=en-IN', 'To show in Frontend panel.', 13, 1, '2023-09-15 10:17:16', '2023-09-15 12:59:20');

-- --------------------------------------------------------

--
-- Table structure for table `setting_types`
--

CREATE TABLE `setting_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(25) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_types`
--

INSERT INTO `setting_types` (`id`, `type`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 'General Setting', 1, '2023-07-06 08:51:04', '2023-07-21 05:54:49', NULL),
(9, 'Withdrawal Setting', 1, '2023-07-06 08:51:27', '2023-07-25 06:24:27', NULL),
(10, 'Security Setting', 1, '2023-07-06 08:51:56', '2023-07-21 05:54:49', NULL),
(11, 'Product Setting', 1, '2023-07-13 22:36:55', '2023-07-21 05:54:49', NULL),
(12, 'Client Setting', 1, '2023-09-03 13:33:11', '2023-09-03 13:33:11', NULL),
(13, 'Frontend Setting', 1, '2023-09-15 12:57:57', '2023-09-15 12:57:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `mobile` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `otp` mediumint(8) UNSIGNED DEFAULT NULL,
  `password` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive, 1=Active',
  `remember_token` varchar(100) DEFAULT NULL,
  `otp_created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `mobile`, `email`, `email_verified_at`, `otp`, `password`, `status`, `remember_token`, `otp_created_at`, `created_at`, `updated_at`) VALUES
(4, 'Miss Reanna Kuphal IV', 'jennifer50', '3563923095', 'ines.simonis@example.net', '2024-03-17 05:24:00', NULL, '$2y$12$HD8RPFY7xlvX39V8ZFcTU.4r3e9.mDbYY0pC5yvi9TTuetlvX9PyS', 1, 'f2dQ0YjbA3', '2024-03-17 10:54:01', '2024-03-17 05:24:01', '2024-03-17 05:24:01'),
(5, 'Mrs. Aisha Kunze Sr.', 'santos.kessler', '4885023127', 'nhaag@example.net', '2024-03-17 05:24:01', NULL, '$2y$12$HD8RPFY7xlvX39V8ZFcTU.4r3e9.mDbYY0pC5yvi9TTuetlvX9PyS', 1, 'aICs2bGkDJ', '2024-03-17 10:54:01', '2024-03-17 05:24:01', '2024-03-17 05:24:01'),
(6, 'Gail Collins', 'kellie40', '0263837736', 'sarai72@example.org', '2024-03-17 05:24:01', NULL, '$2y$12$HD8RPFY7xlvX39V8ZFcTU.4r3e9.mDbYY0pC5yvi9TTuetlvX9PyS', 1, '8HjR8pZvwB', '2024-03-17 10:54:01', '2024-03-17 05:24:01', '2024-03-17 05:24:01');

-- --------------------------------------------------------

--
-- Table structure for table `users_addresses`
--

CREATE TABLE `users_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `landmark` varchar(100) DEFAULT NULL,
  `city` varchar(80) DEFAULT NULL,
  `pincode` varchar(6) DEFAULT NULL,
  `state` varchar(80) DEFAULT NULL,
  `country` varchar(80) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_details`
--

CREATE TABLE `users_details` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(100) DEFAULT NULL COMMENT 'Profile Picture',
  `referral_code` varchar(20) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `pin` varchar(20) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL COMMENT 'dob = Date Of Birth',
  `gender` enum('male','female','other') DEFAULT 'male',
  `pincode` varchar(6) DEFAULT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_tracking`
--

CREATE TABLE `users_tracking` (
  `id` bigint(20) NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `country_code` char(2) DEFAULT NULL,
  `region` varchar(191) DEFAULT NULL,
  `region_name` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `lat` decimal(10,6) DEFAULT NULL,
  `lon` decimal(10,6) DEFAULT NULL,
  `timezone` varchar(191) DEFAULT NULL,
  `isp` varchar(191) DEFAULT NULL,
  `org` varchar(191) DEFAULT NULL,
  `org_as` varchar(191) DEFAULT NULL,
  `browser_name` varchar(191) DEFAULT NULL,
  `browser_version` varchar(191) DEFAULT NULL,
  `device_name` varchar(191) DEFAULT NULL,
  `device_model` varchar(191) DEFAULT NULL,
  `os_name` varchar(191) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `location` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_tracking`
--

INSERT INTO `users_tracking` (`id`, `ip`, `country`, `country_code`, `region`, `region_name`, `city`, `lat`, `lon`, `timezone`, `isp`, `org`, `org_as`, `browser_name`, `browser_version`, `device_name`, `device_model`, `os_name`, `user_agent`, `location`, `created_at`, `updated_at`) VALUES
(1, 'gdfgdf', 'gfdfgdf', 'gd', 'gdfg', 'dfgfdfd', 'dgfgfd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-03-12 06:28:52'),
(2, '150.107.232.105', 'India', 'IN', 'GJ', 'Gujarat', 'Surat', 21.188800, 72.829300, 'Asia/Kolkata', 'GTPL Vvc Network Pvt Ltd', 'Gtpl Broadband Pvt. Ltd.', 'AS45916 Gujarat Telelink Pvt Ltd', 'Google Chrome', '122.0.0.0', 'Desktop', '', 'windows', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', '{\"status\":\"success\",\"country\":\"India\",\"countryCode\":\"IN\",\"region\":\"GJ\",\"regionName\":\"Gujarat\",\"city\":\"Surat\",\"zip\":\"394107\",\"lat\":21.1888,\"lon\":72.8293,\"timezone\":\"Asia\\/Kolkata\",\"isp\":\"GTPL Vvc Network Pvt Ltd\",\"org\":\"Gtpl Broadband Pvt. Ltd.\",\"as\":\"AS45916 Gujarat Telelink Pvt Ltd\",\"query\":\"150.107.232.105\"}', '2024-03-12 06:28:52', '2024-03-14 06:46:04'),
(3, '150.107.232.105', 'India', 'IN', 'GJ', 'Gujarat', 'Surat', 21.188800, 72.829300, 'Asia/Kolkata', 'GTPL Vvc Network Pvt Ltd', 'Gtpl Broadband Pvt. Ltd.', 'AS45916 Gujarat Telelink Pvt Ltd', 'Google Chrome', '122.0.0.0', 'Desktop', '', 'windows', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', '{\"status\":\"success\",\"country\":\"India\",\"countryCode\":\"IN\",\"region\":\"GJ\",\"regionName\":\"Gujarat\",\"city\":\"Surat\",\"zip\":\"394107\",\"lat\":21.1888,\"lon\":72.8293,\"timezone\":\"Asia\\/Kolkata\",\"isp\":\"GTPL Vvc Network Pvt Ltd\",\"org\":\"Gtpl Broadband Pvt. Ltd.\",\"as\":\"AS45916 Gujarat Telelink Pvt Ltd\",\"query\":\"150.107.232.105\"}', '2024-03-12 06:28:52', '2024-03-14 06:46:04'),
(4, '150.107.232.105', 'India', 'IN', 'GJ', 'Gujarat', 'Surat', 21.188800, 72.829300, 'Asia/Kolkata', 'GTPL Vvc Network Pvt Ltd', 'Gtpl Broadband Pvt. Ltd.', 'AS45916 Gujarat Telelink Pvt Ltd', 'Google Chrome', '122.0.0.0', 'Desktop', '', 'windows', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', '{\"status\":\"success\",\"country\":\"India\",\"countryCode\":\"IN\",\"region\":\"GJ\",\"regionName\":\"Gujarat\",\"city\":\"Surat\",\"zip\":\"394107\",\"lat\":21.1888,\"lon\":72.8293,\"timezone\":\"Asia\\/Kolkata\",\"isp\":\"GTPL Vvc Network Pvt Ltd\",\"org\":\"Gtpl Broadband Pvt. Ltd.\",\"as\":\"AS45916 Gujarat Telelink Pvt Ltd\",\"query\":\"150.107.232.105\"}', '2024-03-12 06:28:52', '2024-03-14 06:46:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `allotted_ip`
--
ALTER TABLE `allotted_ip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key` (`key`),
  ADD KEY `setting_type_id` (`setting_type_id`);

--
-- Indexes for table `setting_types`
--
ALTER TABLE `setting_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`email`),
  ADD UNIQUE KEY `mobile_number` (`mobile`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users_addresses`
--
ALTER TABLE `users_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_details`
--
ALTER TABLE `users_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_tracking`
--
ALTER TABLE `users_tracking`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `allotted_ip`
--
ALTER TABLE `allotted_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `setting_types`
--
ALTER TABLE `setting_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_tracking`
--
ALTER TABLE `users_tracking`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`setting_type_id`) REFERENCES `setting_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_addresses`
--
ALTER TABLE `users_addresses`
  ADD CONSTRAINT `users_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_details`
--
ALTER TABLE `users_details`
  ADD CONSTRAINT `users_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
