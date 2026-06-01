-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260526.9a43c2e222
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 01, 2026 at 11:08 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `benovaide`
--

-- --------------------------------------------------------

--
-- Table structure for table `benevole`
--

CREATE TABLE `benevole` (
  `id` int NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code_postal` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `id_role` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `benevole`
--

INSERT INTO `benevole` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `adresse`, `code_postal`, `date_naissance`, `id_role`) VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@gmail.com', '1234', '12 rue de la Paix', '01000', '1995-03-15', 1),
(2, 'Martin', 'Marie', 'marie.martin@gmail.com', '1234', '5 avenue Carnot', '69001', '1998-07-22', 1),
(3, 'Bernard', 'Lucas', 'lucas.bernard@gmail.com', '1234', '8 rue Victor Hugo', '01000', '2000-01-10', 1),
(4, 'Leclerc', 'Sophie', 'sophie.leclerc@gmail.com', '1234', '3 rue du Moulin', '38000', '1993-11-05', 1),
(5, 'Petit', 'Thomas', 'thomas.petit@gmail.com', '1234', '22 boulevard Gambetta', '13001', '1997-06-18', 2),
(6, 'Moreau', 'Julie', 'julie.moreau@gmail.com', '1234', '7 rue des Fleurs', '69002', '1999-04-12', 1),
(7, 'Garcia', 'Antoine', 'antoine.garcia@gmail.com', '1234', '15 avenue de la Gare', '01000', '1996-08-30', 1),
(8, 'Leroy', 'Camille', 'camille.leroy@gmail.com', '1234', '3 rue Pasteur', '38000', '2001-02-14', 1),
(9, 'Roux', 'Nicolas', 'nicolas.roux@gmail.com', '1234', '9 boulevard de la Paix', '13002', '1994-11-25', 1),
(10, 'Simon', 'Emma', 'emma.simon@gmail.com', '1234', '21 rue Victor Hugo', '75001', '2000-07-08', 2),
(11, 'Dubois', 'Laura', 'laura.dubois@gmail.com', '1234', '4 rue de la République', '69001', '1998-03-22', 1),
(12, 'Lambert', 'Maxime', 'maxime.lambert@gmail.com', '1234', '11 avenue Jean Jaurès', '01000', '1995-09-15', 1),
(13, 'Fontaine', 'Chloé', 'chloe.fontaine@gmail.com', '1234', '6 rue du Commerce', '38100', '2002-01-30', 1),
(14, 'Girard', 'Baptiste', 'baptiste.girard@gmail.com', '1234', '18 rue Molière', '13003', '1993-06-17', 1),
(15, 'Bonnet', 'Léa', 'lea.bonnet@gmail.com', '1234', '2 place de la Mairie', '74000', '2000-12-05', 1),
(16, 'Chevalier', 'Hugo', 'hugo.chevalier@gmail.com', '1234', '33 boulevard Gambetta', '31000', '1997-04-28', 1),
(17, 'Muller', 'Inès', 'ines.muller@gmail.com', '1234', '8 rue de Strasbourg', '67000', '1999-10-11', 2),
(18, 'Blanc', 'Zoé', 'zoe.blanc@gmail.com', '1234', '5 rue de la Liberté', '69003', '2001-05-18', 1),
(19, 'Rousseau', 'Pierre', 'pierre.rousseau@gmail.com', '1234', '14 avenue Foch', '01000', '1992-07-23', 1),
(20, 'Mercier', 'Manon', 'manon.mercier@gmail.com', '1234', '9 rue Gambetta', '38200', '1998-11-02', 1),
(21, 'Dupuis', 'Théo', 'theo.dupuis@gmail.com', '1234', '27 boulevard Michelet', '13008', '1996-03-14', 1),
(22, 'Colin', 'Sarah', 'sarah.colin@gmail.com', '1234', '3 rue des Lilas', '74100', '2000-09-27', 1),
(23, 'Renard', 'Kevin', 'kevin.renard@gmail.com', '1234', '16 place Bellecour', '69002', '1994-01-08', 1),
(24, 'Faure', 'Lucie', 'lucie.faure@gmail.com', '1234', '8 rue de la Paix', '67100', '1999-06-30', 2),
(25, 'Aubert', 'Clara', 'clara.aubert@gmail.com', '1234', '12 rue des Roses', '69004', '2000-03-10', 1),
(26, 'Marchand', 'Romain', 'romain.marchand@gmail.com', '1234', '7 avenue du Parc', '01000', '1997-08-22', 1),
(27, 'Lefebvre', 'Océane', 'oceane.lefebvre@gmail.com', '1234', '3 rue Pasteur', '38000', '2001-11-15', 1),
(28, 'Arnaud', 'Julien', 'julien.arnaud@gmail.com', '1234', '19 boulevard Carnot', '13001', '1995-05-30', 1),
(29, 'Perrin', 'Anaïs', 'anais.perrin@gmail.com', '1234', '5 rue de la Liberté', '74000', '1999-01-18', 1),
(30, 'Barbier', 'Tom', 'tom.barbier@gmail.com', '1234', '22 rue Victor Hugo', '31000', '2002-07-04', 1),
(38, 'sdfsd', 'sdfsdf', 'dsff', '2323', 'dfds2', '010', '2026-05-20', 1),
(40, 'dfsd', 'fdsfsd', 'fdsfsdfsqfds', '34839493489', 'dskfjd\"àç\'_ç\"à', '10010', '2026-05-20', 1),
(41, 'ttes', 'fdsfsd', 'djfklsdklf@gmai.com', 'dfsdfd', 'Fdfsdf23', '0010', '2026-06-24', 1),
(42, 'dfsd', 'kldsjfj', 'kldsfjjkdsl@gmail.com', '1234', 'fldsklmdsf', '01001', '2026-05-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mission`
--

CREATE TABLE `mission` (
  `id` int NOT NULL,
  `titre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lieu` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_mission` date DEFAULT NULL,
  `actif` tinyint(1) DEFAULT '1',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mission`
--

INSERT INTO `mission` (`id`, `titre`, `lieu`, `date_mission`, `actif`, `description`) VALUES
(1, 'Distribution alimentaire', 'Bourg-en-Bresse', '2026-05-12', 1, 'Distribution de colis alimentaires aux familles en difficulté du quartier. Besoin de 5 bénévoles pour préparer et distribuer les colis.'),
(2, 'Nouveau titre', 'Lyon', '2026-10-01', 1, 'Nouvelle description'),
(3, 'Collecte de vêtements', 'Villefranche-sur-Saône', '2026-05-25', 1, 'Organisation d\'une collecte de vêtements d\'hiver. Tri et conditionnement des dons. Ouvert à tous les bénévoles.'),
(4, 'Visite aux personnes âgées', 'Oyonnax', '2026-06-01', 1, 'Visites de convivialité en EHPAD. Moments d\'échange, jeux de société, lecture. Formation préalable assurée.'),
(5, 'Maraude nocturne', 'Lyon centre', '2026-06-05', 1, 'Distribution de repas chauds et couvertures aux sans-abris. Départ à 21h, retour vers minuit. Majeurs uniquement.'),
(6, 'Nettoyage de rivière', 'Parc de la Feyssine', '2026-06-10', 1, 'Mission annulée - Conditions météo défavorables'),
(7, 'Atelier numérique seniors', 'Bourg-en-Bresse', '2026-06-29', 0, 'Initiation smartphone et tablette pour personnes âgées. Besoin de bénévoles patients et pédagogues.'),
(8, 'Rénovation local associatif', 'Belley', '2026-06-18', 0, 'Travaux de peinture et petits aménagements. Matériel fourni. Prévoir tenue adaptée.'),
(10, 'Distribution de repas', 'Lyon 7ème', '2026-07-05', 0, 'Distribution de repas chauds aux sans-abris.'),
(12, 'Collecte de jouets', 'Mâcon', '2026-07-15', 1, 'Collecte de jouets pour enfants défavorisés.'),
(13, 'Jardinage solidaire', 'Annecy', '2026-07-20', 0, 'Mission annulée - Manque de bénévoles.'),
(14, 'Maraude hivernale', 'Grenoble', '2026-08-01', 1, 'Distribution de vêtements chauds et repas aux sans-abris.'),
(15, 'Aide scolaire', 'Lyon 8ème', '2026-08-05', 1, 'Soutien scolaire pour enfants en difficulté.'),
(16, 'Collecte alimentaire', 'Bourg-en-Bresse', '2026-08-10', 1, 'Collecte de denrées alimentaires pour les familles.'),
(17, 'Animation seniors', 'Mâcon', '2026-08-15', 1, 'Activités ludiques pour personnes âgées en EHPAD.'),
(18, 'Nettoyage parc', 'Annecy', '2026-08-20', 0, 'Mission annulée - Météo défavorable.'),
(19, 'Aide administrative', 'Villefranche-sur-Saône', '2026-08-25', 1, 'Aide aux démarches administratives pour personnes en difficulté.'),
(29, 'fsdfdsf', 'Oyon', '2026-05-11', 0, 'fd'),
(30, 'test', 'dsfds', '2026-05-31', 0, 'fsdfsdf'),
(31, 'ra', 'Oyonnax', '2026-06-01', 1, 'lfksdfkdskfds'),
(32, 'fsd', 'sdfds', '2026-06-02', 0, 'f'),
(33, 'fdsfsd', 'test', '2026-06-09', 1, 'oyopoa'),
(34, 'fdsfsd', 'dfsdfs', '2026-06-17', 1, 'fsd23');

-- --------------------------------------------------------

--
-- Table structure for table `participation`
--

CREATE TABLE `participation` (
  `id` int NOT NULL,
  `id_benevole` int DEFAULT NULL,
  `id_mission` int DEFAULT NULL,
  `date_inscription` datetime DEFAULT CURRENT_TIMESTAMP,
  `statut` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'active',
  `date_annulation` datetime DEFAULT NULL,
  `annule_par` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participation`
--

INSERT INTO `participation` (`id`, `id_benevole`, `id_mission`, `date_inscription`, `statut`, `date_annulation`, `annule_par`) VALUES
(7, 1, 5, '2026-05-28 22:17:14', 'annulée', NULL, NULL),
(8, 1, 8, '2026-05-28 22:18:48', 'annulée', '2026-05-31 12:48:37', NULL),
(11, 1, 1, '2026-05-29 09:08:39', 'annulée', NULL, NULL),
(19, 1, 1, '2026-05-29 10:14:32', 'annulée', NULL, NULL),
(22, 3, 29, '2026-05-29 11:39:04', 'annulée', NULL, NULL),
(23, 1, 18, '2026-05-29 12:03:40', 'annulée', NULL, NULL),
(24, 41, 1, '2026-05-31 11:50:01', 'annulée', NULL, NULL),
(25, 41, 18, '2026-05-31 11:52:05', 'annulée', NULL, NULL),
(26, 41, 18, '2026-05-31 11:55:36', 'annulée', '2026-05-31 22:32:30', 'admin'),
(27, 1, 18, '2026-05-31 12:17:44', 'annulée', NULL, NULL),
(28, 1, 18, '2026-05-31 12:19:56', 'active', NULL, NULL),
(29, 1, 19, '2026-05-31 12:24:14', 'active', NULL, NULL),
(30, 1, 5, '2026-05-31 12:24:30', 'annulée', '2026-05-31 22:16:21', NULL),
(31, 1, 18, '2026-05-31 12:25:55', 'annulée', NULL, NULL),
(32, 1, 1, '2026-05-31 12:26:46', 'annulée', NULL, NULL),
(33, 3, 18, '2026-05-31 12:32:19', 'annulée', NULL, NULL),
(34, 3, 15, '2026-05-31 12:34:18', 'annulée', NULL, NULL),
(35, 3, 8, '2026-05-31 12:35:29', 'annulée', NULL, NULL),
(36, 3, 19, '2026-05-31 12:35:30', 'annulée', NULL, NULL),
(37, 3, 18, '2026-05-31 12:37:41', 'annulée', NULL, NULL),
(38, 3, 29, '2026-05-31 12:38:32', 'annulée', NULL, NULL),
(39, 3, 18, '2026-05-31 12:40:04', 'annulée', NULL, NULL),
(40, 3, 19, '2026-05-31 12:40:19', 'annulée', NULL, NULL),
(41, 3, 19, '2026-05-31 12:49:45', 'annulée', '2026-05-31 12:49:47', NULL),
(42, 3, 19, '2026-05-31 12:50:32', 'annulée', '2026-05-31 12:50:33', NULL),
(43, 3, 18, '2026-05-31 12:52:09', 'annulée', '2026-05-31 12:52:11', NULL),
(44, 3, 15, '2026-05-31 12:52:14', 'annulée', '2026-05-31 12:52:16', NULL),
(45, 3, 4, '2026-05-31 13:06:58', 'annulée', '2026-05-31 13:07:00', NULL),
(46, 3, 29, '2026-05-31 13:55:20', 'annulée', '2026-05-31 13:55:29', NULL),
(47, 3, 18, '2026-05-31 13:59:18', 'annulée', '2026-05-31 13:59:19', NULL),
(48, 3, 19, '2026-05-31 14:04:02', 'annulée', '2026-05-31 14:04:40', NULL),
(49, 3, 18, '2026-05-31 14:04:44', 'annulée', '2026-05-31 14:18:22', NULL),
(50, 3, 30, '2026-05-31 14:07:49', 'annulée', '2026-05-31 14:09:09', NULL),
(51, 3, 30, '2026-05-31 14:17:31', 'active', NULL, NULL),
(52, 3, 18, '2026-05-31 14:18:19', 'active', NULL, NULL),
(53, 41, 30, '2026-05-31 14:36:31', 'annulée', '2026-05-31 14:36:33', NULL),
(54, 42, 30, '2026-05-31 14:37:58', 'annulée', '2026-05-31 15:22:45', NULL),
(55, 42, 18, '2026-05-31 14:38:08', 'annulée', '2026-05-31 22:18:16', NULL),
(56, 42, 30, '2026-05-31 15:08:34', 'annulée', '2026-05-31 22:18:17', NULL),
(57, 42, 30, '2026-05-31 22:32:42', 'annulée', '2026-05-31 22:44:54', 'admin'),
(58, 42, 31, '2026-05-31 22:32:44', 'annulée', '2026-05-31 22:33:30', 'admin'),
(59, 42, 30, '2026-05-31 22:44:33', 'active', NULL, NULL),
(60, 42, 15, '2026-05-31 22:44:35', 'annulée', '2026-05-31 22:44:56', 'admin'),
(61, 2, 30, '2026-05-31 22:53:11', 'annulée', '2026-05-31 22:54:09', 'admin'),
(62, 2, 19, '2026-05-31 22:53:13', 'annulée', '2026-05-31 22:56:43', 'benevole'),
(63, 2, 12, '2026-05-31 22:56:33', 'annulée', '2026-05-31 22:56:54', 'admin'),
(64, 2, 15, '2026-05-31 23:02:37', 'annulée', '2026-05-31 23:02:46', 'admin'),
(65, 2, 30, '2026-06-01 12:08:07', 'annulée', '2026-06-01 12:36:12', 'admin'),
(66, 2, 30, '2026-06-01 12:08:09', 'annulée', '2026-06-01 12:36:10', 'admin'),
(67, 2, 30, '2026-06-01 12:08:15', 'annulée', '2026-06-01 12:36:10', 'admin'),
(68, 2, 18, '2026-06-01 12:08:17', 'annulée', '2026-06-01 12:08:52', 'benevole'),
(69, 2, 15, '2026-06-01 12:08:19', 'annulée', '2026-06-01 12:09:15', 'benevole'),
(70, 2, 13, '2026-06-01 12:08:22', 'annulée', '2026-06-01 12:09:25', 'benevole'),
(71, 2, 1, '2026-06-01 12:08:27', 'active', NULL, NULL),
(72, 2, 30, '2026-06-01 12:08:41', 'annulée', '2026-06-01 12:36:08', 'admin'),
(73, 2, 16, '2026-06-01 12:09:06', 'annulée', '2026-06-01 12:10:48', 'benevole'),
(74, 2, 30, '2026-06-01 12:10:53', 'annulée', '2026-06-01 12:36:06', 'admin'),
(75, 2, 30, '2026-06-01 12:10:55', 'annulée', '2026-06-01 12:36:09', 'admin'),
(76, 2, 30, '2026-06-01 12:10:55', 'annulée', '2026-06-01 12:36:05', 'admin'),
(77, 2, 30, '2026-06-01 12:10:55', 'annulée', '2026-06-01 12:36:04', 'admin'),
(78, 2, 30, '2026-06-01 12:10:56', 'annulée', '2026-06-01 12:36:05', 'admin'),
(79, 2, 30, '2026-06-01 12:10:56', 'annulée', '2026-06-01 12:36:03', 'admin'),
(80, 2, 30, '2026-06-01 12:10:56', 'annulée', '2026-06-01 12:36:03', 'admin'),
(81, 2, 15, '2026-06-01 12:11:04', 'annulée', '2026-06-01 12:13:59', 'benevole'),
(82, 2, 30, '2026-06-01 12:13:37', 'annulée', '2026-06-01 12:36:02', 'admin'),
(83, 2, 31, '2026-06-01 12:13:38', 'annulée', '2026-06-01 12:36:00', 'admin'),
(84, 2, 31, '2026-06-01 12:13:40', 'annulée', '2026-06-01 12:36:00', 'admin'),
(85, 2, 32, '2026-06-01 12:13:42', 'annulée', '2026-06-01 12:13:56', 'benevole'),
(86, 2, 31, '2026-06-01 12:13:44', 'annulée', '2026-06-01 12:35:59', 'admin'),
(87, 2, 31, '2026-06-01 12:13:44', 'annulée', '2026-06-01 12:35:52', 'admin'),
(88, 2, 31, '2026-06-01 12:13:45', 'annulée', '2026-06-01 12:35:52', 'admin'),
(89, 2, 31, '2026-06-01 12:13:45', 'annulée', '2026-06-01 12:35:51', 'admin'),
(90, 2, 19, '2026-06-01 12:13:51', 'annulée', '2026-06-01 12:13:54', 'benevole'),
(91, 2, 15, '2026-06-01 12:14:04', 'annulée', '2026-06-01 12:16:02', 'benevole'),
(92, 2, 13, '2026-06-01 12:14:12', 'annulée', '2026-06-01 12:14:17', 'benevole'),
(93, 2, 13, '2026-06-01 12:14:19', 'annulée', '2026-06-01 12:14:23', 'benevole'),
(94, 2, 32, '2026-06-01 12:14:27', 'annulée', '2026-06-01 12:14:29', 'benevole'),
(95, 2, 30, '2026-06-01 12:16:03', 'annulée', '2026-06-01 12:36:09', 'admin'),
(96, 2, 18, '2026-06-01 12:16:06', 'annulée', '2026-06-01 12:16:10', 'benevole'),
(97, 2, 16, '2026-06-01 12:16:12', 'annulée', '2026-06-01 12:16:18', 'benevole'),
(98, 2, 32, '2026-06-01 12:16:14', 'annulée', '2026-06-01 12:16:17', 'benevole'),
(99, 2, 31, '2026-06-01 12:17:57', 'annulée', '2026-06-01 12:35:53', 'admin'),
(100, 2, 31, '2026-06-01 12:18:03', 'annulée', '2026-06-01 12:35:53', 'admin'),
(101, 2, 31, '2026-06-01 12:18:04', 'annulée', '2026-06-01 12:35:58', 'admin'),
(102, 2, 31, '2026-06-01 12:18:04', 'annulée', '2026-06-01 12:35:58', 'admin'),
(103, 2, 31, '2026-06-01 12:18:05', 'annulée', '2026-06-01 12:35:57', 'admin'),
(104, 2, 31, '2026-06-01 12:18:05', 'annulée', '2026-06-01 12:35:50', 'admin'),
(105, 2, 1, '2026-06-01 12:18:15', 'annulée', '2026-06-01 12:36:17', 'admin'),
(106, 2, 19, '2026-06-01 12:18:52', 'annulée', '2026-06-01 12:18:54', 'benevole'),
(107, 2, 30, '2026-06-01 12:18:56', 'annulée', '2026-06-01 12:36:12', 'admin'),
(108, 2, 30, '2026-06-01 12:19:05', 'annulée', '2026-06-01 12:36:08', 'admin'),
(109, 2, 30, '2026-06-01 12:19:11', 'annulée', '2026-06-01 12:36:07', 'admin'),
(110, 2, 30, '2026-06-01 12:19:20', 'annulée', '2026-06-01 12:36:06', 'admin'),
(111, 2, 32, '2026-06-01 12:19:24', 'annulée', '2026-06-01 12:32:56', 'benevole'),
(112, 2, 30, '2026-06-01 12:20:40', 'annulée', '2026-06-01 12:36:02', 'admin'),
(113, 2, 1, '2026-06-01 12:22:02', 'active', NULL, NULL),
(114, 2, 1, '2026-06-01 12:23:37', 'active', NULL, NULL),
(115, 2, 1, '2026-06-01 12:24:33', 'annulée', '2026-06-01 12:36:18', 'admin'),
(116, 2, 30, '2026-06-01 12:27:54', 'annulée', '2026-06-01 12:36:01', 'admin'),
(117, 2, 30, '2026-06-01 12:30:32', 'annulée', '2026-06-01 12:36:01', 'admin'),
(118, 2, 30, '2026-06-01 12:30:41', 'annulée', '2026-06-01 12:36:14', 'admin'),
(119, 2, 30, '2026-06-01 12:32:34', 'annulée', '2026-06-01 12:36:13', 'admin'),
(120, 2, 32, '2026-06-01 12:32:52', 'annulée', '2026-06-01 12:32:55', 'benevole'),
(121, 2, 18, '2026-06-01 12:33:02', 'annulée', '2026-06-01 12:39:39', 'benevole'),
(122, 2, 32, '2026-06-01 12:36:53', 'annulée', '2026-06-01 12:36:54', 'benevole'),
(123, 2, 12, '2026-06-01 12:39:50', 'annulée', '2026-06-01 12:45:03', 'benevole'),
(124, 2, 31, '2026-06-01 12:42:48', 'annulée', '2026-06-01 12:45:24', 'benevole'),
(125, 2, 31, '2026-06-01 12:42:54', 'annulée', '2026-06-01 12:45:25', 'benevole'),
(126, 2, 31, '2026-06-01 12:43:00', 'annulée', '2026-06-01 12:45:25', 'benevole'),
(127, 2, 31, '2026-06-01 12:43:13', 'annulée', '2026-06-01 12:45:26', 'benevole'),
(128, 2, 31, '2026-06-01 12:43:18', 'annulée', '2026-06-01 12:45:29', 'benevole'),
(129, 2, 31, '2026-06-01 12:43:19', 'annulée', '2026-06-01 12:45:28', 'benevole'),
(130, 2, 31, '2026-06-01 12:43:19', 'annulée', '2026-06-01 12:45:28', 'benevole'),
(131, 2, 31, '2026-06-01 12:43:19', 'annulée', '2026-06-01 12:45:30', 'benevole'),
(132, 2, 31, '2026-06-01 12:43:19', 'annulée', '2026-06-01 12:45:42', 'benevole'),
(133, 2, 31, '2026-06-01 12:43:19', 'annulée', '2026-06-01 12:45:30', 'benevole'),
(134, 2, 31, '2026-06-01 12:43:19', 'annulée', '2026-06-01 12:45:22', 'benevole'),
(135, 2, 31, '2026-06-01 12:43:19', 'annulée', '2026-06-01 12:45:19', 'benevole'),
(136, 2, 31, '2026-06-01 12:43:20', 'annulée', '2026-06-01 12:45:19', 'benevole'),
(137, 2, 31, '2026-06-01 12:43:20', 'annulée', '2026-06-01 12:45:18', 'benevole'),
(138, 2, 31, '2026-06-01 12:43:20', 'annulée', '2026-06-01 12:45:18', 'benevole'),
(139, 2, 31, '2026-06-01 12:43:20', 'annulée', '2026-06-01 12:45:17', 'benevole'),
(140, 2, 31, '2026-06-01 12:43:20', 'annulée', '2026-06-01 12:45:16', 'benevole'),
(141, 2, 31, '2026-06-01 12:43:20', 'annulée', '2026-06-01 12:45:16', 'benevole'),
(142, 2, 31, '2026-06-01 12:43:21', 'annulée', '2026-06-01 12:45:15', 'benevole'),
(143, 2, 31, '2026-06-01 12:43:21', 'annulée', '2026-06-01 12:45:15', 'benevole'),
(144, 2, 31, '2026-06-01 12:43:21', 'annulée', '2026-06-01 12:45:13', 'benevole'),
(145, 2, 31, '2026-06-01 12:43:24', 'annulée', '2026-06-01 12:45:13', 'benevole'),
(146, 2, 31, '2026-06-01 12:43:24', 'annulée', '2026-06-01 12:45:10', 'benevole'),
(147, 2, 31, '2026-06-01 12:43:29', 'annulée', '2026-06-01 12:45:12', 'benevole'),
(148, 2, 31, '2026-06-01 12:43:29', 'annulée', '2026-06-01 12:45:07', 'benevole'),
(149, 2, 31, '2026-06-01 12:43:33', 'annulée', '2026-06-01 12:45:07', 'benevole'),
(150, 2, 31, '2026-06-01 12:43:33', 'annulée', '2026-06-01 12:45:06', 'benevole'),
(151, 2, 31, '2026-06-01 12:44:56', 'annulée', '2026-06-01 12:45:06', 'benevole'),
(152, 2, 31, '2026-06-01 12:45:41', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `nom`) VALUES
(1, 'admin'),
(2, 'benevole'),
(3, 'visiteur');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_role` int DEFAULT NULL,
  `id_benevole` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `mot_de_passe`, `id_role`, `id_benevole`) VALUES
(1, 'admin@benovaide.fr', '1234', 1, 1),
(2, 'benevole@benovaide.fr', '1234', 2, 2),
(3, 'jean.dupont@gmail.com', '1234', 2, 1),
(4, 'marie.martin@gmail.com', '1234', 2, 2),
(5, 'lucas.bernard@gmail.com', '1234', 2, 3),
(12, 'djfklsdklf@gmai.com', 'dfsdfd', 2, 41),
(13, 'kldsfjjkdsl@gmail.com', '1234', 2, 42);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `benevole`
--
ALTER TABLE `benevole`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_role` (`id_role`);

--
-- Indexes for table `mission`
--
ALTER TABLE `mission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_benevole` (`id_benevole`),
  ADD KEY `id_mission` (`id_mission`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_benevole` (`id_benevole`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `benevole`
--
ALTER TABLE `benevole`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `mission`
--
ALTER TABLE `mission`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `participation`
--
ALTER TABLE `participation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `benevole`
--
ALTER TABLE `benevole`
  ADD CONSTRAINT `benevole_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`);

--
-- Constraints for table `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `participation_ibfk_1` FOREIGN KEY (`id_benevole`) REFERENCES `benevole` (`id`),
  ADD CONSTRAINT `participation_ibfk_2` FOREIGN KEY (`id_mission`) REFERENCES `mission` (`id`);

--
-- Constraints for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`id_benevole`) REFERENCES `benevole` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
