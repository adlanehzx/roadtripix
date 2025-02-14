-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : mariadb:3306
-- Généré le : mer. 12 fév. 2025 à 22:29
-- Version du serveur : 10.9.4-MariaDB-1:10.9.4+maria~ubu2204
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `database`
--

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created_at`) VALUES
(4, 'fourth_group', '2025-02-09 23:59:49'),
(5, 'fourth_group', '2025-02-10 00:00:31'),
(6, 'fourth_group', '2025-02-10 00:00:35'),
(7, 'fifth_group', '2025-02-10 00:00:48'),
(8, 'fifth_group', '2025-02-10 00:01:11'),
(9, 'adlanehz', '2025-02-11 13:56:36');

-- --------------------------------------------------------

--
-- Structure de la table `group_permissions`
--

CREATE TABLE `group_permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `group_permissions`
--

INSERT INTO `group_permissions` (`id`, `name`, `created_at`) VALUES
(1, 'owner', '2025-02-09 23:11:52');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `image_permissions`
--

CREATE TABLE `image_permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `invitations`
--

CREATE TABLE `invitations` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `status` enum('pending','accepted','expired') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `invitations`
--

INSERT INTO `invitations` (`id`, `group_id`, `email`, `token`, `expires_at`, `status`) VALUES
(6, 9, 'contact.adlanehz@gmail.com', '0fce5f129154b7694521be2c25c07be9c649c87f5b13f12998487e700190cfc2', '2025-02-13 15:55:38', 'pending');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `country` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `created_at`, `country`) VALUES
(5, 'ilyes', 'ilyes', 'benameur', 'ilyes@ilyes.com', '$2y$10$d4U/N2LeNogEoU.2gqy0vOZdIellZIlww1WFURNGWboHQDyUe77qW', '2025-02-09 20:37:34', 'fr'),
(6, 'usernameee', 'username', 'username', 'usernamee@usernameee.com', '$2y$10$d4U/N2LeNogEoU.2gqy0vOZdIellZIlww1WFURNGWboHQDyUe77qW', '2025-02-09 21:23:34', 'fr'),
(7, 'ilyes', 'ilyes', 'benameur', 'ilyes2@ilyes2.com', '$2y$10$ZPAQm5Urhz5iHlXuvqqtwuDBZZY9zi.lt8B0lSoN2IT.k/pQLloXm', '2025-02-09 21:26:21', 'fr'),
(8, 'test', 'test', 'test', 'test@test.com', '$2y$10$enyLErAbr3mzU8aewmLLVesXLABzBqKpqMluDa53hnU6Pl/FXXUC6', '2025-02-09 21:39:04', 'test'),
(10, 'creator', 'creator', 'creation', 'creator@creator.io', '$2y$10$/eEiZzcDpyxBPW/Oepc4T.mZAqtxQ8MpXG2CBuTDNeNfOzuMHMi9.', '2025-02-09 23:42:06', 'fr'),
(11, 'adlanehzx', 'adlane', 'hamzaoui', 'adlanehzx@gmail.com', '$2y$10$HB25vnfZb3wdm/kM7O6bAOBTc/ZnL3V8dhqPGWAyYiWBeKelFnbIG', '2025-02-11 08:16:23', 'algérie');

-- --------------------------------------------------------

--
-- Structure de la table `user_groups`
--

CREATE TABLE `user_groups` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_groups`
--

INSERT INTO `user_groups` (`user_id`, `group_id`) VALUES
(11, 9);

-- --------------------------------------------------------

--
-- Structure de la table `user_group_permissions`
--

CREATE TABLE `user_group_permissions` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_group_permissions`
--

INSERT INTO `user_group_permissions` (`user_id`, `group_id`, `permission_id`) VALUES
(11, 9, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_image_permissions`
--

CREATE TABLE `user_image_permissions` (
  `user_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `group_permissions`
--
ALTER TABLE `group_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Index pour la table `image_permissions`
--
ALTER TABLE `image_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`user_id`,`group_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Index pour la table `user_group_permissions`
--
ALTER TABLE `user_group_permissions`
  ADD PRIMARY KEY (`user_id`,`group_id`,`permission_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Index pour la table `user_image_permissions`
--
ALTER TABLE `user_image_permissions`
  ADD PRIMARY KEY (`user_id`,`image_id`,`permission_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `group_permissions`
--
ALTER TABLE `group_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `image_permissions`
--
ALTER TABLE `image_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `images_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Contraintes pour la table `invitations`
--
ALTER TABLE `invitations`
  ADD CONSTRAINT `invitations_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Contraintes pour la table `user_groups`
--
ALTER TABLE `user_groups`
  ADD CONSTRAINT `user_groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Contraintes pour la table `user_group_permissions`
--
ALTER TABLE `user_group_permissions`
  ADD CONSTRAINT `user_group_permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_group_permissions_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `user_group_permissions_ibfk_3` FOREIGN KEY (`permission_id`) REFERENCES `group_permissions` (`id`);

--
-- Contraintes pour la table `user_image_permissions`
--
ALTER TABLE `user_image_permissions`
  ADD CONSTRAINT `user_image_permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_image_permissions_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  ADD CONSTRAINT `user_image_permissions_ibfk_3` FOREIGN KEY (`permission_id`) REFERENCES `image_permissions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
