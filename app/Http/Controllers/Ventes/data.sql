-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 15 oct. 2024 à 01:44
-- Version du serveur : 10.5.12-MariaDB-0+deb11u1
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cema_cimak`
--

-- --------------------------------------------------------

--
-- Structure de la table `tcema_examen_medical`
--

CREATE TABLE `tcema_examen_medical` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `refPatient` int(11) NOT NULL,
  `categorie_examen` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_nationnal` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taille` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poids` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `m30` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tour_taille` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PAS1` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PAD1` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PAS2` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PAD2` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PAS3` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PAD3` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ouls` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `televisage` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gorge` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sinus` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tympan` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pupilles_fond` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `molite` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pupilles_egalite` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `yeux` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poumons` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coeur` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `systemevasculaire` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abdomen` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anus_rectum` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `systeme_genitaux` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `systeme_endo` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `membre_superieur` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `muscle_squelettes` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reflexes_neuro` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signe_psychiatrique` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peau_lymphatique` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signes_systematique` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marques` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oeildroit_noncorrige` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oeildroit_corrige` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oeilgauche_noncorrige` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oeilgauche_corrige` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deux_oeil_noncorrige` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deux_oeil_corrige` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perception_couleur` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plaque_types` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_plaque_erreur` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voix_conversations_droit` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voix_conversation_gauche` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oeildroit_noncorrige2` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oeildroit_corrige2` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oeilgauche_noncorrige2` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oeilgauche_corrige2` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deux_oeil_noncorrige2` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deux_oeil_corrige2` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz_droit_500` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz_droit_1000` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz_droit_2000` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz_droit_3000` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz_gauche_500` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz_gauche_1000` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz_gauche_2000` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz_gauche_3000` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz_test` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz_obligatoire` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lunette` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lentille_contact` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ECG` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Rx_thorax` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autres_pieces` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `examen_urinaire` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `glucose` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proteine` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sang` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autres_examens` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bilan_sanguin` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `glucode2` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creatinine` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uree` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lipidogramme` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acide_urique` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hb` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conclusion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tcema_examen_medical`
--

INSERT INTO `tcema_examen_medical` (`id`, `refPatient`, `categorie_examen`, `id_nationnal`, `taille`, `poids`, `m30`, `tour_taille`, `PAS1`, `PAD1`, `PAS2`, `PAD2`, `PAS3`, `PAD3`, `ouls`, `televisage`, `gorge`, `sinus`, `tympan`, `pupilles_fond`, `molite`, `pupilles_egalite`, `yeux`, `poumons`, `coeur`, `systemevasculaire`, `abdomen`, `anus_rectum`, `systeme_genitaux`, `systeme_endo`, `membre_superieur`, `muscle_squelettes`, `reflexes_neuro`, `signe_psychiatrique`, `peau_lymphatique`, `signes_systematique`, `marques`, `oeildroit_noncorrige`, `oeildroit_corrige`, `oeilgauche_noncorrige`, `oeilgauche_corrige`, `deux_oeil_noncorrige`, `deux_oeil_corrige`, `perception_couleur`, `plaque_types`, `num_plaque_erreur`, `voix_conversations_droit`, `voix_conversation_gauche`, `oeildroit_noncorrige2`, `oeildroit_corrige2`, `oeilgauche_noncorrige2`, `oeilgauche_corrige2`, `deux_oeil_noncorrige2`, `deux_oeil_corrige2`, `hz_droit_500`, `hz_droit_1000`, `hz_droit_2000`, `hz_droit_3000`, `hz_gauche_500`, `hz_gauche_1000`, `hz_gauche_2000`, `hz_gauche_3000`, `hz_test`, `hz_obligatoire`, `hz_type`, `lunette`, `lentille_contact`, `ECG`, `Rx_thorax`, `autres_pieces`, `examen_urinaire`, `glucose`, `proteine`, `sang`, `autres_examens`, `bilan_sanguin`, `glucode2`, `creatinine`, `uree`, `lipidogramme`, `acide_urique`, `hb`, `conclusion`, `author`, `created_at`, `updated_at`) VALUES
(1, 150, 'Initial', '0', '168', '47', 'Normal', '2', '120', '75', '120', '70', '111', '74', 'Régulier', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'NON', 'OUI', 'NON', 'OUI', 'OUI', 'NON', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', '6,6nDp', '6,6nDp', '6,6nDp', '6,6nDp', '6,6nDp', '6,6nDp', 'OUI', '0000', '000', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', '5000', '5000', '5000', '5000', '5000', '5000', '5000', '5000', 'OUI', 'OUI', '5000', 'OUI', 'OUI', 'Normal', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'MIREILLE MILOLO', '2024-08-26 18:58:38', '2024-08-26 18:58:38'),
(2, 93, 'Initial', NULL, '168', '47', '17', '60', '120', '75', '120', '73', '111', '74', 'Régulier', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', '10/10', '10/10', '10/10', '10/10', '10/10', '10/10', 'OUI', NULL, NULL, 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'OUI', 'OUI', NULL, 'OUI', 'OUI', 'Normal', 'Normale', 'Normale', 'Normale', 'Normal', 'Normal', 'Normal', 'Normal', 'Normale', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Bon état de santé', 'Dr Freddy MUKOSO NG\'EKIEB', '2024-08-28 11:46:50', '2024-08-28 11:46:50'),
(3, 148, 'Initial', NULL, '172', '59', '20', '63', '128', '72', '120', '70', '121', '68', 'Régulier', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', '10/10', '10/10', '10/10', '10/10', '10/10', '10/10', 'OUI', NULL, NULL, 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'OUI', 'OUI', NULL, 'OUI', 'OUI', 'Normal', 'Normale', 'Normale', 'Normale', 'Normal', 'Normal', 'Normal', 'Normal', 'Normale', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Bon état de santé', 'Dr Freddy MUKOSO NG\'EKIEB', '2024-08-29 11:06:08', '2024-08-29 11:06:08'),
(4, 165, 'Initial', 'OP1062734', '157', '60', '19.3', '60', '100', '60', '105', '59', '105', '53', 'Régulier', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'normal', 'normal', 'normal', 'normal', 'normal', 'normal', 'OUI', NULL, NULL, 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'normal', 'normal', 'normal', 'normal', 'normal', 'normal', 'normal', 'normal', 'OUI', 'OUI', NULL, 'NON', 'NON', 'Normal', 'Normale', 'Normale', 'Normale', 'normal', 'normal', 'normal', 'normal', 'Normale', 'normal', 'normal', 'normal', 'normal', 'normal', 'normal', 'Bon état de santé', 'Dr Freddy MUKOSO NG\'EKIEB', '2024-09-02 06:37:01', '2024-09-02 06:37:01'),
(5, 149, 'Initial', NULL, '164', '54', '17', '65', '111', '79', '110', '78', '112', '75', 'Régulier', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'OUI', NULL, NULL, 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'OUI', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'OUI', 'OUI', NULL, 'OUI', 'OUI', 'Normal', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Normale', 'Bon état de santé', 'Dr Freddy MUKOSO NG\'EKIEB', '2024-09-02 10:55:20', '2024-09-02 10:55:20');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tcema_examen_medical`
--
ALTER TABLE `tcema_examen_medical`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tcema_examen_medical`
--
ALTER TABLE `tcema_examen_medical`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
