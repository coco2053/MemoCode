-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 03 avr. 2020 à 09:18
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `memo-code`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `language`
--

DROP TABLE IF EXISTS `language`;
CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `language`
--

INSERT INTO `language` (`id`, `name`) VALUES
(1, 'html'),
(2, 'css'),
(3, 'php'),
(4, 'javascript'),
(5, 'twig'),
(6, 'git'),
(7, 'sql'),
(8, 'yalm'),
(9, 'c'),
(10, 'cpp'),
(11, 'processing'),
(12, 'arduino'),
(13, 'csharp'),
(14, 'phpdoc'),
(15, 'json'),
(16, 'phpdoc'),
(17, 'python'),
(18, 'regex'),
(19, 'ruby');

-- --------------------------------------------------------

--
-- Structure de la table `memo`
--

DROP TABLE IF EXISTS `memo`;
CREATE TABLE IF NOT EXISTS `memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `article_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AB4A902A7294869C` (`article_id`),
  KEY `IDX_AB4A902A82F1BAF4` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200328152002', '2020-03-28 15:20:08'),
('20200328171413', '2020-03-28 17:14:23'),
('20200328171832', '2020-03-28 17:19:12'),
('20200331133921', '2020-03-31 13:39:40');

-- --------------------------------------------------------

--
-- Structure de la table `text`
--

DROP TABLE IF EXISTS `text`;
CREATE TABLE IF NOT EXISTS `text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3B8BA7C77294869C` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `registered_at` datetime NOT NULL,
  `confirmation_token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `roles`, `username`, `is_active`, `registered_at`, `confirmation_token`, `password_token`) VALUES
(4, 'coco2053@hotmail.com', '$argon2i$v=19$m=65536,t=4,p=1$bG9xVmdRTkp6Q20xdjlWbg$nhs9ICaFcewUosK3F3cv0Ga20qAoFGd7tF4IroCM7uM', '[\"ROLE_USER\"]', 'baste', 1, '2020-03-28 04:00:00', NULL, NULL),
(5, 'bastienvacherand@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$VUlYYWhiSHFKSS82djBBaA$O2/OryOnYDPY+/wbNkyJvvJNqxBs1tUOrUh2TgHpb4A', '[]', 'Eric', 1, '2020-03-29 11:48:19', NULL, NULL),
(6, 'contact@bastienvacherand.fr', '$argon2i$v=19$m=65536,t=4,p=1$OWxyNUV1TU44VEwzdFNZSQ$CDSrKSbkU64SP6w7nG56m1OzQJDbA6+7HK/r2DZEcxE', '[]', 'Julien', 1, '2020-04-02 16:57:28', NULL, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `memo`
--
ALTER TABLE `memo`
  ADD CONSTRAINT `FK_AB4A902A7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `FK_AB4A902A82F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Contraintes pour la table `text`
--
ALTER TABLE `text`
  ADD CONSTRAINT `FK_3B8BA7C77294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
