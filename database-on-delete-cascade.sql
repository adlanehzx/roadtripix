-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Feb 18, 2025 at 02:06 PM
-- Server version: 5.7.44
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created_at`) VALUES
(5, 'fourth_group', '2025-02-10 00:00:31'),
(6, 'fourth_group', '2025-02-10 00:00:35'),
(7, 'fifth_group', '2025-02-10 00:00:48'),
(8, 'fifth_group', '2025-02-10 00:01:11'),
(10, 'latest group -100', '2025-02-14 19:40:09'),
(11, 'another_groups_owned_by_creator', '2025-02-14 20:11:44');

-- --------------------------------------------------------

--
-- Table structure for table `group_invitations`
--

CREATE TABLE `group_invitations` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(512) NOT NULL,
  `expires_at` date NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `group_permissions`
--

CREATE TABLE `group_permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group_permissions`
--

INSERT INTO `group_permissions` (`id`, `name`, `created_at`) VALUES
(1, 'owner', '2025-02-09 23:11:52'),
(2, 'member', '2025-02-14 21:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `description` text,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `description`, `user_id`, `group_id`, `uploaded_at`) VALUES
(18, 'Untitled-1.png', 10, 10, '2025-02-14 23:24:52'),
(19, 'f', 10, 10, '2025-02-14 23:25:27'),
(20, 'Untitled-1.png', 10, 10, '2025-02-14 23:29:35'),
(21, 'Untitled-1.png', 10, 10, '2025-02-14 23:32:17'),
(22, 'Untitled-1.png', 10, 10, '2025-02-14 23:32:32'),
(23, 'Untitled-1.png', 10, 10, '2025-02-14 23:33:58'),
(24, 'snowman.jpeg', 10, 10, '2025-02-14 23:37:12'),
(26, '4039556_ebb3_3.jpg', 10, 10, '2025-02-15 00:19:45'),
(27, 'baki00-1024x576-1291239209.jpg', 10, 10, '2025-02-15 00:28:09'),
(28, 'baki00-1024x576-1291239209.jpg', 10, 10, '2025-02-15 00:33:12'),
(29, '4039556_ebb3_3.jpg', 10, 10, '2025-02-15 00:35:32'),
(30, '4039556_ebb3_3.jpg', 10, 10, '2025-02-15 00:38:16'),
(32, '4039556_ebb3_3.jpg', 10, 10, '2025-02-15 00:46:56'),
(33, 'baki00-1024x576-1291239209.jpg', 5, 10, '2025-02-15 23:06:41'),
(34, 'another-picture.png', 5, 10, '2025-02-15 23:06:51'),
(35, '5543588_3b32_3.jpg', 10, 10, '2025-02-18 13:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `country` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `created_at`, `country`) VALUES
(5, 'ilyes', 'ilyes', 'benameur', 'ilyes@ilyes.com', '$2y$10$d4U/N2LeNogEoU.2gqy0vOZdIellZIlww1WFURNGWboHQDyUe77qW', '2025-02-09 20:37:34', 'fr'),
(6, 'usernameee', 'username', 'username', 'usernamee@usernameee.com', '$2y$10$d4U/N2LeNogEoU.2gqy0vOZdIellZIlww1WFURNGWboHQDyUe77qW', '2025-02-09 21:23:34', 'fr'),
(7, 'ilyes', 'ilyes', 'benameur', 'ilyes2@ilyes2.com', '$2y$10$ZPAQm5Urhz5iHlXuvqqtwuDBZZY9zi.lt8B0lSoN2IT.k/pQLloXm', '2025-02-09 21:26:21', 'fr'),
(8, 'test', 'test', 'test', 'test@test.com', '$2y$10$enyLErAbr3mzU8aewmLLVesXLABzBqKpqMluDa53hnU6Pl/FXXUC6', '2025-02-09 21:39:04', 'test'),
(10, 'creator', 'creator', 'creation', 'creator@creator.io', '$2y$10$/eEiZzcDpyxBPW/Oepc4T.mZAqtxQ8MpXG2CBuTDNeNfOzuMHMi9.', '2025-02-09 23:42:06', 'fr'),
(11, 'adlanehzx', 'adlane', 'hamzaoui', 'adlanehzx@gmail.com', '$2y$10$HB25vnfZb3wdm/kM7O6bAOBTc/ZnL3V8dhqPGWAyYiWBeKelFnbIG', '2025-02-11 08:16:23', 'algérie'),
(12, 'new_username1', 'new', 'user', 'new_username1@mail.com', '$2y$12$Vbg3GgSizX1BaL2AC1cVdOVcD8v4aYxd6ZQZDfa9L/I7FnrOYWQ5u', '2025-02-17 22:18:19', 'fr'),
(13, 'ff', 'fireuser', 'useruser', 'fmail@fmail.com', '$2y$12$ejf2fkH8OL.vhGRg1T0AZOsx/NMngP/kPQQd/n6sFoUczeOeJdxWu', '2025-02-18 11:04:34', 'fr'),
(14, 'roadtripix', 'roadtripix', 'road', 'contact@roadtripix.pix', '$2y$12$a6zcJ.1oLSIYxnmGEbXzU.9cklFaPPWgROLT3vg/72IJcRT8Mzf0i', '2025-02-18 11:08:55', 'fr');

-- --------------------------------------------------------

--
-- Table structure for table `user_group_permissions`
--

CREATE TABLE `user_group_permissions` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_group_permissions`
--

INSERT INTO `user_group_permissions` (`user_id`, `group_id`, `permission_id`) VALUES
(5, 10, 2),
(10, 10, 1),
(10, 11, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_invitations`
--
ALTER TABLE `group_invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_group` (`group_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `group_permissions`
--
ALTER TABLE `group_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_group_permissions`
--
ALTER TABLE `user_group_permissions`
  ADD PRIMARY KEY (`user_id`,`group_id`,`permission_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `group_invitations`
--
ALTER TABLE `group_invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_permissions`
--
ALTER TABLE `group_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_invitations`
--
ALTER TABLE `group_invitations`
  ADD CONSTRAINT `fk_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `images_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_group_permissions`
--
ALTER TABLE `user_group_permissions`
  ADD CONSTRAINT `user_group_permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_group_permissions_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_group_permissions_ibfk_3` FOREIGN KEY (`permission_id`) REFERENCES `group_permissions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
