-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 23, 2023 at 01:24 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vuz_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `host` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `name`, `host`, `key`, `icon`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Etisalat', 'https://example.com/', 'key', NULL, '2023-04-23 07:15:54', '2023-04-23 07:15:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `partner_services`
--

CREATE TABLE `partner_services` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partner_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partner_services`
--

INSERT INTO `partner_services` (`id`, `name`, `icon`, `partner_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dr. Norris Koepp Jr.', NULL, 1, '2023-04-23 07:15:54', '2023-04-23 07:15:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20230422080846, 'Users', '2023-04-23 07:15:52', '2023-04-23 07:15:52', 0),
(20230422105542, 'Partners', '2023-04-23 07:15:52', '2023-04-23 07:15:52', 0),
(20230422110321, 'PartnerServices', '2023-04-23 07:15:52', '2023-04-23 07:15:52', 0),
(20230422110645, 'SubscriptionTypes', '2023-04-23 07:15:52', '2023-04-23 07:15:52', 0),
(20230422111826, 'ServiceSubscriptionTypes', '2023-04-23 07:15:52', '2023-04-23 07:15:52', 0),
(20230422122818, 'SubscriptionRequests', '2023-04-23 07:15:52', '2023-04-23 07:15:52', 0),
(20230423080846, 'Webhooks', '2023-04-23 07:15:52', '2023-04-23 07:15:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_subscription_types`
--

CREATE TABLE `service_subscription_types` (
  `id` bigint(20) NOT NULL,
  `partner_service_id` bigint(20) NOT NULL,
  `subscription_type_id` bigint(20) NOT NULL,
  `reference_subscription_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_subscription_types`
--

INSERT INTO `service_subscription_types` (`id`, `partner_service_id`, `subscription_type_id`, `reference_subscription_id`, `price`, `currency`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'reference_subscription_id', '10.00', 'USD', '2023-04-23 07:15:54', '2023-04-23 07:15:54');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_requests`
--

CREATE TABLE `subscription_requests` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `service_subscription_type_id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sub',
  `parent_subscription_request_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
PARTITION BY LIST (`status`)
(
PARTITION p_pending VALUES IN (1) ENGINE=InnoDB,
PARTITION p_subscripe VALUES IN (2) ENGINE=InnoDB,
PARTITION p_unubscripe VALUES IN (3) ENGINE=InnoDB,
PARTITION p_rejected VALUES IN (4) ENGINE=InnoDB
);

--
-- Dumping data for table `subscription_requests`
--

INSERT INTO `subscription_requests` (`id`, `user_id`, `service_subscription_type_id`, `status`, `type`, `parent_subscription_request_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 1, 2, 'sub', NULL, '2023-04-23 11:18:08', '2023-04-23 11:18:29', NULL),
(1, 1, 1, 4, 'sub', NULL, '2023-04-23 11:16:01', '2023-04-23 11:16:14', NULL),
(3, 1, 1, 4, 'unsub', 2, '2023-04-23 11:18:58', '2023-04-23 11:19:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_types`
--

CREATE TABLE `subscription_types` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_types`
--

INSERT INTO `subscription_types` (`id`, `name`, `icon`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Yearly', NULL, '2023-04-23 07:15:54', '2023-04-23 07:15:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` date DEFAULT '2023-04-23',
  `email_verified_at` date DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
PARTITION BY RANGE (year(`created_at`))
(
PARTITION p0 VALUES LESS THAN (2020) ENGINE=InnoDB,
PARTITION p1 VALUES LESS THAN (2021) ENGINE=InnoDB,
PARTITION p2 VALUES LESS THAN (2022) ENGINE=InnoDB,
PARTITION p3 VALUES LESS THAN (2023) ENGINE=InnoDB,
PARTITION p4 VALUES LESS THAN (2024) ENGINE=InnoDB,
PARTITION p5 VALUES LESS THAN MAXVALUE ENGINE=InnoDB
);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `password`, `created_at`, `email_verified_at`, `deleted_at`) VALUES
(1, 'Test User', '870-813-2586', 'user@test.com', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', '2023-04-23', '2023-04-23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `webhooks`
--

CREATE TABLE `webhooks` (
  `id` bigint(20) NOT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referenc_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscription_id` bigint(20) NOT NULL,
  `partner_id` bigint(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payload`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `webhooks`
--

INSERT INTO `webhooks` (`id`, `event`, `action`, `referenc_id`, `subscription_id`, `partner_id`, `amount`, `currency`, `email`, `description`, `error`, `payload`, `created_at`, `updated_at`) VALUES
(1, 'subscription.failed', 'sub', 'ch_1234567890', 1, NULL, '10.00', 'USD', 'test@example.com', 'des', 'invalid msisdn', '\"{}\"', '2023-04-23 11:16:14', NULL),
(2, 'subscription.failed', 'sub', 'ch_1234567890', 1, NULL, '10.00', 'USD', 'test@example.com', 'des', 'invalid msisdn', '\"{}\"', '2023-04-23 11:16:40', NULL),
(3, 'subscription.failed', 'sub', 'ch_1234567890', 1, NULL, '10.00', 'USD', 'test@example.com', 'des', 'invalid msisdn', '\"{}\"', '2023-04-23 11:16:48', NULL),
(4, 'subscription.failed', 'sub', 'ch_1234567890', 1, NULL, '10.00', 'USD', 'test@example.com', 'des', 'invalid msisdn', '\"{}\"', '2023-04-23 11:16:57', NULL),
(5, 'subscription.failed', 'sub', 'ch_1234567890', 1, NULL, '10.00', 'USD', 'test@example.com', 'des', 'invalid msisdn', '\"{}\"', '2023-04-23 11:17:59', NULL),
(6, 'subscription.succeed', 'sub', 'ch_1234567890', 2, NULL, '10.00', 'USD', 'test@example.com', 'des', '', '\"{}\"', '2023-04-23 11:18:29', NULL),
(7, 'unsubscription.failed', 'unsub', 'ch_1234567890', 3, NULL, '10.00', 'USD', 'test@example.com', 'des', 'invalid msisdn', '\"{}\"', '2023-04-23 11:19:24', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `partner_services`
--
ALTER TABLE `partner_services`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `partner_id` (`partner_id`);

--
-- Indexes for table `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `service_subscription_types`
--
ALTER TABLE `service_subscription_types`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `partner_service_id` (`partner_service_id`,`subscription_type_id`),
  ADD UNIQUE KEY `partner_service_id_2` (`partner_service_id`,`reference_subscription_id`),
  ADD KEY `subscription_type_id` (`subscription_type_id`);

--
-- Indexes for table `subscription_requests`
--
ALTER TABLE `subscription_requests`
  ADD UNIQUE KEY `id` (`id`,`status`),
  ADD KEY `id_2` (`id`,`status`,`type`,`user_id`,`service_subscription_type_id`);

--
-- Indexes for table `subscription_types`
--
ALTER TABLE `subscription_types`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `email` (`email`,`created_at`),
  ADD KEY `id` (`id`,`created_at`);

--
-- Indexes for table `webhooks`
--
ALTER TABLE `webhooks`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `event` (`event`,`action`,`partner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `partner_services`
--
ALTER TABLE `partner_services`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_subscription_types`
--
ALTER TABLE `service_subscription_types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscription_requests`
--
ALTER TABLE `subscription_requests`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscription_types`
--
ALTER TABLE `subscription_types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `webhooks`
--
ALTER TABLE `webhooks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `partner_services`
--
ALTER TABLE `partner_services`
  ADD CONSTRAINT `partner_services_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_subscription_types`
--
ALTER TABLE `service_subscription_types`
  ADD CONSTRAINT `service_subscription_types_ibfk_1` FOREIGN KEY (`partner_service_id`) REFERENCES `partner_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_subscription_types_ibfk_2` FOREIGN KEY (`subscription_type_id`) REFERENCES `subscription_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
