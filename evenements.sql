-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 28 fév. 2024 à 06:11
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbname`
--

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

CREATE TABLE `evenements` (
  `id` int(11) NOT NULL,
  `nom_cours` varchar(100) NOT NULL,
  `categories` varchar(15) DEFAULT NULL,
  `professeurs` varchar(255) DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `date_cours` date DEFAULT NULL,
  `salle` varchar(20) DEFAULT NULL,
  `nom_filiere` varchar(50) DEFAULT NULL,
  `code_filiere` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`id`, `nom_cours`, `categories`, `professeurs`, `heure_debut`, `heure_fin`, `date_cours`, `salle`, `nom_filiere`, `code_filiere`) VALUES
(1, 'Mathématiques', 'Cours', 'M. Dupont', '08:12:00', '10:13:00', '2024-03-05', 'Salle A', 'Informatique', 'INF101'),
(2, 'Biologie cellulaire', 'Cours', 'M. Mimpungu', '10:30:00', '12:30:00', '2024-03-10', 'Salle B', 'Biologie', 'BIO202'),
(3, 'Chimie organique', 'Cours', 'M. Durand', '14:20:00', '16:31:00', '2024-03-01', 'Salle C', 'Chimie', 'CHI303'),
(5, 'Biologie', 'TP Machine', 'Mme. Dubois', '08:13:00', '12:00:00', '2024-03-02', 'Laboratoire B', 'Biologie', 'BIO202'),
(6, 'Chimie organique', 'TP Machine', 'M. Bernard', '17:17:00', '20:06:00', '2024-03-14', 'Laboratoire C', 'Chimie', 'CHI303'),
(7, 'SGBD', 'Examens', 'M. Mimpungu', '09:10:00', '11:20:00', '2024-02-29', 'Amphi Wegener', 'Informatique de gestion', 'MIA101'),
(8, 'Vacances', 'Vacances', '', '00:00:00', '00:00:00', '2024-02-27', '', '', ''),
(9, 'Reunion', 'Reunion', 'Mrs. Kiwa Lusanga', '12:01:00', '12:45:00', '2024-03-08', 'Grande salle ', 'Informatique', 'INF101'),
(10, 'Soutenances', 'Soutenances', '', '09:30:00', '18:31:00', '2024-03-22', 'Grande salle ', 'Informatique de gestion', 'MIA101'),
(11, 'Soutenances', 'Soutenances', '', '09:30:00', '18:31:00', '2024-02-15', 'Grande salle ', 'Informatique', 'INF101'),
(12, 'Algorithmique', 'Examens', 'M. Deo', '09:30:00', '10:31:00', '2024-09-12', 'Grande salle ', 'Informatique', 'INF101');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `evenements`
--
ALTER TABLE `evenements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
