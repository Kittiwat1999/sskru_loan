-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Aug 04, 2026 at 07:56 AM
-- Server version: 8.0.46
-- PHP Version: 8.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_document_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `policy_acceptances`
--

CREATE TABLE `policy_acceptances` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `policy_id` bigint UNSIGNED NOT NULL,
  `policy_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `policy_version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accepted_at` timestamp NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `policy_acceptances`
--
ALTER TABLE `policy_acceptances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `policy_acceptances_user_id_policy_id_unique` (`user_id`,`policy_id`),
  ADD KEY `policy_acceptances_policy_id_foreign` (`policy_id`),
  ADD KEY `policy_acceptances_policy_type_index` (`policy_type`),
  ADD KEY `policy_acceptances_policy_version_index` (`policy_version`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `policy_acceptances`
--
ALTER TABLE `policy_acceptances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `policy_acceptances`
--
ALTER TABLE `policy_acceptances`
  ADD CONSTRAINT `policy_acceptances_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `policies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `policy_acceptances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
