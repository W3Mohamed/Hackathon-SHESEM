-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 07 avr. 2025 à 16:41
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hackathon`
--

-- --------------------------------------------------------

--
-- Structure de la table `plante`
--

DROP TABLE IF EXISTS `plante`;
CREATE TABLE IF NOT EXISTS `plante` (
  `id_plant` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `superficie_minimale` float DEFAULT NULL,
  `saison_adequate` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `luminosite` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `systeme_d_irrigation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frequence_arrosage` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantite_arrosage` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temps_plein` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_de_sol` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distance_entre_plantes` float DEFAULT NULL,
  `hauteur_maximale` float DEFAULT NULL,
  `largeur_maximale` float DEFAULT NULL,
  `resistance_au_froid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resistance_aux_pests` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utilisation_recommandee` text COLLATE utf8mb4_unicode_ci,
  `niveau_d_entretien` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_de_culture` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_plantation` date DEFAULT NULL,
  PRIMARY KEY (`id_plant`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `plante`
--

INSERT INTO `plante` (`id_plant`, `libelle`, `categorie`, `superficie_minimale`, `saison_adequate`, `luminosite`, `systeme_d_irrigation`, `frequence_arrosage`, `quantite_arrosage`, `temps_plein`, `type_de_sol`, `distance_entre_plantes`, `hauteur_maximale`, `largeur_maximale`, `resistance_au_froid`, `resistance_aux_pests`, `utilisation_recommandee`, `niveau_d_entretien`, `type_de_culture`, `date_plantation`) VALUES
(1, 'Tomate', 'Légume', 0.25, 'Printemps', 'Plein soleil', 'Goutte à goutte', '1/2', '500ml', '90 jours', 'Argilo-sableux', 50, 180, 60, 'Sensible', 'Sensible aux mildious', 'Salades, sauces', 'Modéré', 'Plein terre', '2024-03-15'),
(2, 'Courgette', 'Légume', 1, 'Printemps-Été', 'Plein soleil', 'Arrosage manuel', '1/3', '1L', '60 jours', 'Riche en humus', 100, 70, 100, 'Modérée', 'Sensible aux aleurodes', 'Ratatouille, grillades', 'Facile', 'Plein terre', '2024-04-01');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

