-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 17 sep. 2026 à 22:07
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `poduits1`
--

CREATE TABLE `poduits1` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prix` decimal(10,2) NOT NULL,
  `Catégorie` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `poduits1`
--

INSERT INTO `poduits1` (`id`, `Nom`, `Prix`, `Catégorie`, `Description`, `Image`) VALUES
(1, 'Ordinateur Portable', 200.00, '', '', 'Top DEALS.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `produits1`
--

CREATE TABLE `produits1` (
  `id` int(11) NOT NULL,
  `Nom` varchar(100) NOT NULL,
  `Prix` decimal(10,0) NOT NULL,
  `Catégorie` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `produits1`
--

INSERT INTO `produits1` (`id`, `Nom`, `Prix`, `Catégorie`, `Description`, `Image`) VALUES
(1, 'Batterie rechargeable', 50, '', '', 'Batterie réchargeable.jpg'),
(2, 'Multimètre numérique', 25, 'Electronique', '', 'Multimètre numérique.jpg'),
(3, 'Fer à souder', 18, 'Electronique', '', 'Fer à souder.jpg'),
(4, 'Ordinateur Portable', 350, 'Informatique', '', 'Ordinateur Portable1.jpg'),
(5, 'Disque dur externe', 15, 'Informatique', '', 'Disque dur externe.jpg'),
(6, 'Routeur Wi-Fi', 50, 'Réseau', '', 'Routeur-WIFI.jpg'),
(7, 'RAM 8 Go', 25, 'Informatique', '', 'Memoire RAM2.jpg'),
(8, 'Interrupteur', 25, '', '', 'Interrupteur2.jpg'),
(9, 'Convertisseur de tension', 50, '', '', 'Convertisseur de tension2.jpg'),
(10, 'Pince ampèremétrique', 15, '', '', 'Pince ampèremétrique.jpg'),
(11, 'Disjoncteur ', 25, '', '', 'Disjoncteur.jpg'),
(12, 'Relais électrique', 15, '', '', 'Relais électrique.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `poduits1`
--
ALTER TABLE `poduits1`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits1`
--
ALTER TABLE `produits1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `poduits1`
--
ALTER TABLE `poduits1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `produits1`
--
ALTER TABLE `produits1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
