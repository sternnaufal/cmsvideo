-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 02:14 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms_video`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Action', NULL, '2024-12-18 04:43:48'),
(2, 'Adventure', NULL, '2024-12-18 04:43:48'),
(3, 'Comedy', NULL, '2024-12-18 04:43:48'),
(4, 'Drama', NULL, '2024-12-18 04:43:48'),
(5, 'Fantasy', NULL, '2024-12-18 04:43:48'),
(6, 'Horror', NULL, '2024-12-18 04:43:48'),
(7, 'Mystery', NULL, '2024-12-18 04:43:48'),
(8, 'Romance', NULL, '2024-12-18 04:43:48'),
(9, 'Sci-Fi', NULL, '2024-12-18 04:43:48'),
(10, 'Slice of Life', NULL, '2024-12-18 04:43:48'),
(11, 'Supernatural', NULL, '2024-12-18 04:43:48'),
(12, 'Sports', NULL, '2024-12-18 04:43:48'),
(13, 'Shounen', NULL, '2024-12-18 04:43:48'),
(14, 'Shoujo', NULL, '2024-12-18 04:43:48'),
(15, 'Seinen', NULL, '2024-12-18 04:43:48'),
(16, 'Josei', NULL, '2024-12-18 04:43:48'),
(17, 'Thriller', NULL, '2024-12-18 04:43:48'),
(18, 'Historical', NULL, '2024-12-18 04:43:48'),
(19, 'Mecha', NULL, '2024-12-18 04:43:48'),
(20, 'Magic', NULL, '2024-12-18 04:43:48'),
(21, 'Music', NULL, '2024-12-18 04:43:48'),
(22, 'Psychological', NULL, '2024-12-18 04:43:48'),
(23, 'Ecchi', NULL, '2024-12-18 04:43:48'),
(24, 'Harem', NULL, '2024-12-18 04:43:48'),
(25, 'Isekai', NULL, '2024-12-18 04:43:48'),
(26, 'School', NULL, '2024-12-18 04:43:48'),
(27, 'Superpower', NULL, '2024-12-18 04:43:48'),
(28, 'Military', NULL, '2024-12-18 04:43:48'),
(29, 'Vampire', NULL, '2024-12-18 04:43:48'),
(30, 'Zombie', NULL, '2024-12-18 04:43:48'),
(31, 'School Life', NULL, '2024-12-18 04:43:48'),
(32, 'Samurai', NULL, '2024-12-18 04:43:48'),
(33, 'Martial Arts', NULL, '2024-12-18 04:43:48'),
(34, 'Gore', NULL, '2024-12-18 04:43:48'),
(35, 'Yaoi', NULL, '2024-12-18 04:43:48'),
(36, 'Yuri', NULL, '2024-12-18 04:43:48'),
(37, 'Fantasy', NULL, '2024-12-18 04:43:48'),
(38, 'Parody', NULL, '2024-12-18 04:43:48'),
(39, 'Psychological', NULL, '2024-12-18 04:43:48'),
(40, 'Game', NULL, '2024-12-18 04:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `video_id` varchar(12) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `season` int(11) DEFAULT NULL,
  `episode` int(11) DEFAULT NULL,
  `video_id` char(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_admin`) VALUES
(2, 'admin', '$2y$10$bTTiipWzBO/MS5wLMlGCZ.3fySG8m0.U.ZFrQo7q9fFOp4am.voHS', 1),
(3, 'tamu', '$2y$10$O9ieweqaSiYjT12DhV5cbOtk/RIp8Hjjnp/8pf8d8SvXstqgPs1Im', 0),
(4, 'useraja', '$2y$10$22MeiAJ3uibDD/Bkax8PR.zEm6CS/ZKxDIsKBHGD8OrkqMkSwDrDO', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_subscriptions`
--

CREATE TABLE `user_subscriptions` (
  `user_id` int(11) NOT NULL,
  `is_premium` tinyint(1) DEFAULT 0,
  `subscription_start` datetime DEFAULT NULL,
  `subscription_end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_subscriptions`
--

INSERT INTO `user_subscriptions` (`user_id`, `is_premium`, `subscription_start`, `subscription_end`) VALUES
(2, 1, '2024-12-10 00:00:00', '2024-12-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` varchar(12) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `thumbnail` varchar(255) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `is_premium` tinyint(1) DEFAULT 0,
  `premium_link` varchar(255) DEFAULT NULL,
  `member_link` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `series_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_categories`
--

CREATE TABLE `video_categories` (
  `video_id` varchar(12) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`),
  ADD KEY `fk_series_id` (`series_id`);

--
-- Indexes for table `video_categories`
--
ALTER TABLE `video_categories`
  ADD PRIMARY KEY (`video_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `series_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD CONSTRAINT `user_subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_series_id` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `video_categories`
--
ALTER TABLE `video_categories`
  ADD CONSTRAINT `video_categories_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `video_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
