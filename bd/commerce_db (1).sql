-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  jeu. 24 oct. 2024 à 16:18
-- Version du serveur :  8.0.18
-- Version de PHP :  7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `commerce_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `avantages`
--

DROP TABLE IF EXISTS `avantages`;
CREATE TABLE IF NOT EXISTS `avantages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `avantages`
--

INSERT INTO `avantages` (`id`, `titre`, `description`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Avantage 1', 'Possibilité de mise à disposition ponctuelle d’un logement, selon la nature des fonctions occupées.', '1669537052.avif', '2022-11-27 07:17:32', '2022-11-27 07:17:32'),
(2, 'Avantage 2', 'Accès à des ateliers « bien-être au travail » dispensés par des professionnels bénévoles : relaxation, réflexologie plantaire, shiatsu, amma assis, massage californien…', '1669537090.avif', '2022-11-27 07:18:10', '2022-11-27 07:18:10'),
(3, 'Avantage 3', '28 jours de congés annuels (25 + 3 jours de fractionnement).', '1669537124.avif', '2022-11-27 07:18:44', '2022-11-27 07:18:44'),
(4, 'Avantage 4', 'Formation continue tout au long du parcours professionnel au centre hospitalier, possibilité de congé de formation professionnelle, possibilité d’évolution professionnelle.', '1669537149.avif', '2022-11-27 07:19:09', '2022-11-27 07:19:09');

-- --------------------------------------------------------

--
-- Structure de la table `avenues`
--

DROP TABLE IF EXISTS `avenues`;
CREATE TABLE IF NOT EXISTS `avenues` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idQuartier` int(11) NOT NULL,
  `nomAvenue` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `avenues`
--

INSERT INTO `avenues` (`id`, `idQuartier`, `nomAvenue`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tmk', '2022-11-17 11:00:05', '2022-11-17 11:00:05'),
(2, 1, '7 bougie', '2022-11-17 11:00:28', '2022-11-17 11:00:28'),
(3, 1, 'Katoyi konde', '2022-11-17 11:00:52', '2022-11-17 11:01:10');

-- --------------------------------------------------------

--
-- Structure de la table `basics`
--

DROP TABLE IF EXISTS `basics`;
CREATE TABLE IF NOT EXISTS `basics` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `apropos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `travail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `don` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `structure` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `basics`
--

INSERT INTO `basics` (`id`, `apropos`, `travail`, `don`, `structure`, `created_at`, `updated_at`) VALUES
(1, '<p>DREAM OF DRC est une startup œuvrant dans le domaine numérique qui se concentre dans l’apport globale des solutions technologiques efficaces aux entreprises qui souffrent&nbsp; dans le besoin&nbsp;!</p><p>Nous proposons des solutions technologiques efficaces et durables adaptées aux besoins de la communauté en fonction de leur moyen disponible tout en tenant compte de leur situation budgétaire à un cout faible. &nbsp;</p><p>Secourir les entreprises&nbsp; &nbsp;reste encore un devoir de DREAM OF DRC, à cella nous nous sommes engagés d’apporter les solutions par nos services dans tous les aspects technologiques que les entreprises et la jeunesse africaine éprouvent comme difficulté pour l’émergence de leurs activités&nbsp;!</p><p>«DREAM OF DRC» s’était engagée de travailler durablement à l’appui au système informatique là où le besoin existe, pour ce faire la start-up participe à la création des formations en informatique et partout en RDC, dans des villages ou zones reculées, territoires connus comme fragile où les capacités techniques, matérielles des structures d’offres de service de base de l’État/Gouvernement s’avèrent peu efficace ou inaccessible.</p><p><br>La technologie dont nous parlons fera en sorte de contribuer à l\'émergence de toute la jeunesse et la société en particulier.<br>Nous devons considérer la technologie actuelle comme une arme efficace pour changer le monde.</p>', '<p>travail</p>', '<p>nous faire un don</p>', '<p>notre structure de gestion</p>', '2022-01-29 19:14:06', '2022-12-24 15:12:58');

-- --------------------------------------------------------

--
-- Structure de la table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cat` int(11) DEFAULT NULL,
  `slug` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat` int(11) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `blogs`
--

INSERT INTO `blogs` (`id`, `titre`, `description`, `photo`, `id_cat`, `slug`, `etat`, `user_id`, `created_at`, `updated_at`) VALUES
(13, 'Vos données médicales en un seul clic', '&lt;p&gt;Good&lt;/p&gt;', '1690639098.jpg', 3, 'vos-donnees-me-8tdccvj3', 1, 4, '2022-10-18 12:27:18', '2023-07-29 11:58:18'),
(14, 'Publication d’un nouveau rapport sur les épidémies', '&lt;p&gt;Nous allons ouvrir deux agences en dehors de la RDC en Mars 2023&lt;/p&gt;', '1690639055.png', 4, 'publication-d--iiqtuvxk', 1, 4, '2022-10-18 12:30:31', '2023-07-29 11:57:35'),
(15, 'Votre santé notre priorité', '&lt;p&gt;Good&lt;/p&gt;', '1690638999.jpg', 2, 'votre-sante-not-mqnxvv0u', 1, 4, '2022-11-27 06:25:17', '2023-07-29 11:56:39');

-- --------------------------------------------------------

--
-- Structure de la table `busness_plans`
--

DROP TABLE IF EXISTS `busness_plans`;
CREATE TABLE IF NOT EXISTS `busness_plans` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_entreprise` int(11) NOT NULL,
  `busness_plan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `busness_plans`
--

INSERT INTO `busness_plans` (`id`, `id_entreprise`, `busness_plan`, `created_at`, `updated_at`) VALUES
(1, 6, '1654172695.zip', '2022-06-02 10:24:55', '2022-06-02 10:24:55'),
(2, 1, '1655413619.zip', '2022-06-16 19:06:59', '2022-06-16 19:06:59');

-- --------------------------------------------------------

--
-- Structure de la table `carousels`
--

DROP TABLE IF EXISTS `carousels`;
CREATE TABLE IF NOT EXISTS `carousels` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `carousels`
--

INSERT INTO `carousels` (`id`, `titre`, `description`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'IHUSI HOTEL', 'IHUSI HOTEL', '1728245948.jpg', '2022-10-19 10:19:49', '2024-10-06 18:19:08'),
(4, 'IHUSI HOTEL', 'IHUSI HOTEL', '1728245909.jpg', '2022-11-28 13:18:22', '2024-10-06 18:18:29');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `categorie_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `user_id`, `categorie_name`, `created_at`, `updated_at`) VALUES
(1, 4, 'SUCREE', '2024-01-03 10:40:51', '2024-01-03 10:40:51'),
(2, 4, 'BOISSON', '2024-01-03 10:41:05', '2024-01-03 10:41:05');

-- --------------------------------------------------------

--
-- Structure de la table `category_articles`
--

DROP TABLE IF EXISTS `category_articles`;
CREATE TABLE IF NOT EXISTS `category_articles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category_articles`
--

INSERT INTO `category_articles` (`id`, `nom`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Actualité', 'actualite-6wr13f0o', '2022-10-18 10:36:14', '2022-11-27 05:56:10'),
(2, 'Santé', 'sante-o0cw23wu', '2022-10-18 10:36:25', '2022-11-27 05:56:19'),
(3, 'Communiqué', 'communique-pteklr0u', '2022-10-18 10:37:33', '2022-11-27 05:56:27'),
(4, 'Corona virus', 'corona-virus-v72c5qg4', '2022-10-18 10:51:39', '2022-11-27 05:57:04');

-- --------------------------------------------------------

--
-- Structure de la table `choixes`
--

DROP TABLE IF EXISTS `choixes`;
CREATE TABLE IF NOT EXISTS `choixes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `choixes`
--

INSERT INTO `choixes` (`id`, `titre`, `description`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'La proximité de l’établissement', 'La position géographique de l’hôpital est un critère important qu’il faut prendre en considération. Ne pas choisir un établissement trop éloigné de son domicile peut être rassurant à la fois pour permettre un retour rapide après l’intervention, mais aussi pour simplifier un éventuel suivi médical.\n\nD’autre part, dans le cas d’une hospitalisation prolongée, une proximité avec l’établissement de santé choisi permet à votre entourage de vous rendre visite plus régulièrement.', '1669537363.avif', '2022-11-27 07:22:43', '2022-11-27 07:22:43'),
(2, 'Les spécialités hospitalières', 'En fonction des raisons de votre hospitalisation, vous pouvez être amené à choisir un hôpital selon les spécialités qui y sont pratiquées. En effet, chaque établissement de santé ne dispose pas des mêmes services et développe des domaines d’expertise particuliers en plus des domaines d’intervention classiques.\n\nEn résumé, si votre choix s’oriente vers un hôpital spécialisé dans votre problématique santé, vous êtes assuré de pouvoir bénéficier de soins fiables réalisés par des praticiens expérimentés. Néanmoins, ces établissements présentent généralement des délais de prise en charge plus longs.', '1669537400.jpg', '2022-11-27 07:23:20', '2022-11-27 07:23:20'),
(3, 'La notoriété de l’établissement', 'Tous les établissements de santé sont évalués et notés sur différents critères dont le niveau d’activité, le nombre de cas traités dans chaque discipline, l’équipement matériel, ainsi que le niveau de technicité.\n\nPuis tous les quatre ans, la Haute Autorité de Santé ( HAS) établit des certifications visant à évaluer la qualité d’un établissement (public ou privé), et d’un ou plusieurs services, à l’aide d’indicateurs sur les « bonnes pratiques » cliniques.', '1669537441.png', '2022-11-27 07:24:01', '2022-11-27 07:24:01'),
(4, 'Le budget', 'Vous pensez avoir trouvé l’hôpital idéal ? Toutefois, avez-vous songé à vérifier les tarifs qui y sont pratiqués, mais aussi et surtout les montants qui vous seront remboursés par votre complémentaire santé ? Les conditions de prise en charge sont un élément important dans le choix de votre établissement de santé, ils vous permettront de prévoir un budget pour vos frais d’hospitalisation.', '1669537469.png', '2022-11-27 07:24:29', '2022-11-27 07:24:29');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `noms` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pieceidentite` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroPiece` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clients_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `noms`, `sexe`, `contact`, `mail`, `adresse`, `pieceidentite`, `numeroPiece`, `photo`, `slug`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'GLODI MALEY', 'Homme', '0992992063', 'glodi@gmail.com', 'HIMBI', 'CARTE', '00000', 'avatar.png', 'glodi-maleyglodi-tygqj83m', 4, '2024-01-03 12:16:36', '2024-01-03 12:16:36');

-- --------------------------------------------------------

--
-- Structure de la table `communes`
--

DROP TABLE IF EXISTS `communes`;
CREATE TABLE IF NOT EXISTS `communes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idVille` int(11) NOT NULL,
  `nomCommune` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `communes`
--

INSERT INTO `communes` (`id`, `idVille`, `nomCommune`, `created_at`, `updated_at`) VALUES
(1, 1, 'Goma', '2022-11-17 10:58:39', '2022-11-17 10:58:39'),
(2, 1, 'Karisimbi', '2022-11-17 10:58:49', '2022-11-17 10:58:49');

-- --------------------------------------------------------

--
-- Structure de la table `contact_infos`
--

DROP TABLE IF EXISTS `contact_infos`;
CREATE TABLE IF NOT EXISTS `contact_infos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contact_infos`
--

INSERT INTO `contact_infos` (`id`, `name`, `email`, `telephone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(5, 'MALEY', 'glodimaley@gmail.com', '+243992992063', 'SALUTATION', 'BONJOUR', '2022-12-29 10:00:38', '2022-12-29 10:02:13');

-- --------------------------------------------------------

--
-- Structure de la table `decisions`
--

DROP TABLE IF EXISTS `decisions`;
CREATE TABLE IF NOT EXISTS `decisions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `decisions`
--

INSERT INTO `decisions` (`id`, `titre`, `description`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Décision  1', '28 jours de congés annuels (25 + 3 jours de fractionnement).', '1669536926.jpg', '2022-11-27 07:14:53', '2022-11-27 07:20:02'),
(2, 'Décision 2', 'Formation continue tout au long du parcours professionnel au centre hospitalier, possibilité de congé de formation professionnelle, possibilité d’évolution professionnelle.', '1669536915.png', '2022-11-27 07:15:15', '2022-11-27 07:20:10'),
(3, 'Décision  3', 'Prise en charge des frais de transports en commun domicile/travail à hauteur de 50% des frais engagés.', '1669536953.jpg', '2022-11-27 07:15:54', '2022-11-27 07:19:39');

-- --------------------------------------------------------

--
-- Structure de la table `detail_factures`
--

DROP TABLE IF EXISTS `detail_factures`;
CREATE TABLE IF NOT EXISTS `detail_factures` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `facture_id` bigint(20) UNSIGNED NOT NULL,
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `puVente` double(9,2) NOT NULL,
  `qteVente` double(9,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_factures_facture_id_foreign` (`facture_id`),
  KEY `detail_factures_produit_id_foreign` (`produit_id`),
  KEY `detail_factures_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

DROP TABLE IF EXISTS `entreprises`;
CREATE TABLE IF NOT EXISTS `entreprises` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ceo` int(11) NOT NULL,
  `nomEntreprise` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptionEntreprise` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `emailEntreprise` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresseEntreprise` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephoneEntreprise` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `solutionEntreprise` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rccm` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '0',
  `idsecteur` int(11) NOT NULL,
  `idforme` int(11) NOT NULL,
  `idPays` int(11) NOT NULL,
  `idProvince` int(11) NOT NULL,
  `edition` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `linkedin` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `siteweb` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `invPersonnel` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `invHub` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `invRecherche` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `chiffreAffaire` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbremploye` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_theme` int(11) DEFAULT NULL,
  `id_odd` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`id`, `ceo`, `nomEntreprise`, `descriptionEntreprise`, `emailEntreprise`, `adresseEntreprise`, `telephoneEntreprise`, `solutionEntreprise`, `rccm`, `etat`, `idsecteur`, `idforme`, `idPays`, `idProvince`, `edition`, `facebook`, `linkedin`, `twitter`, `siteweb`, `invPersonnel`, `invHub`, `invRecherche`, `chiffreAffaire`, `nbremploye`, `logo`, `slug`, `created_at`, `updated_at`, `id_theme`, `id_odd`) VALUES
(1, 1, 'SOTTEH', '​\nChiffre d\'affaire annuel généré par l\'entreprise\n1000\nDescription de l\'entreprise', 'info.softech@gmail.com', 'kakasecurity@gmail.com', '+243817883541', 'la solution', 'CD/12/35-234/GOMA', 1, 1, 1, 1, 1, '2021', 'https://fonts.google.com/icons?icon.query=attach+money', 'https://web.whatsapp.com/', 'https://web.whatsapp.com/', 'https://fonts.google.com/icons?icon.query=attach+money', '10', '200', '800', '1000', '1-5', '1690617671.png', 'sotteh-9gt4u0oj', '2022-06-01 10:37:53', '2023-07-29 06:01:11', 1, 1),
(12, 4, 'IHUSI HOTEL', 'san city', 'ihusi@gmail.com', 'GOMA', '+243992829076', 'san city', '000000', 0, 2, 2, 1, 1, '2021', 'caritas', 'caritas', 'caritas', 'www.caritas.net', '2000', '3000', '2000', '2000', '5-10', '1719320703.jpg', 'caritas-developp-3xx0bjq5', '2023-09-18 09:21:15', '2024-06-25 11:05:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

DROP TABLE IF EXISTS `factures`;
CREATE TABLE IF NOT EXISTS `factures` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `dateVente` date NOT NULL,
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `factures_user_id_foreign` (`user_id`),
  KEY `factures_client_id_foreign` (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `forme_juridiques`
--

DROP TABLE IF EXISTS `forme_juridiques`;
CREATE TABLE IF NOT EXISTS `forme_juridiques` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomForme` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `forme_juridiques_nomforme_unique` (`nomForme`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `forme_juridiques`
--

INSERT INTO `forme_juridiques` (`id`, `nomForme`, `created_at`, `updated_at`) VALUES
(1, 'Etablissement', '2022-05-31 11:43:52', '2022-05-31 11:43:52'),
(2, 'SARL', '2022-05-31 11:44:19', '2022-05-31 11:44:19'),
(3, 'SASU', '2022-05-31 11:44:29', '2022-05-31 11:44:29'),
(4, 'ASBL', '2022-05-31 11:44:48', '2022-05-31 11:44:48');

-- --------------------------------------------------------

--
-- Structure de la table `galeries`
--

DROP TABLE IF EXISTS `galeries`;
CREATE TABLE IF NOT EXISTS `galeries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `galeries`
--

INSERT INTO `galeries` (`id`, `photo`, `created_at`, `updated_at`) VALUES
(19, '1690639328.jpg', '2022-12-29 01:48:05', '2023-07-29 12:02:08'),
(20, '1690639313.png', '2022-12-29 01:48:14', '2023-07-29 12:01:53'),
(21, '1690639300.jpg', '2022-12-29 01:48:24', '2023-07-29 12:01:40'),
(22, '1690639287.png', '2022-12-29 01:48:32', '2023-07-29 12:01:27');

-- --------------------------------------------------------

--
-- Structure de la table `link_canvases`
--

DROP TABLE IF EXISTS `link_canvases`;
CREATE TABLE IF NOT EXISTS `link_canvases` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ceo` int(11) NOT NULL,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `link_canvases`
--

INSERT INTO `link_canvases` (`id`, `ceo`, `titre`, `message`, `created_at`, `updated_at`) VALUES
(1, 6, 'Problème', 'problème 1 ok', '2022-06-08 17:17:49', '2022-06-10 13:39:32'),
(2, 6, 'Solution', 'solution 1', '2022-06-08 17:18:12', '2022-06-08 17:18:12'),
(4, 6, 'Proposition de valeur unique', 'proposition 1', '2022-06-08 17:18:36', '2022-06-08 17:18:36'),
(5, 6, 'Proposition de valeur unique', 'proposition 3', '2022-06-08 17:18:46', '2022-06-08 17:18:46'),
(6, 6, 'Proposition de valeur unique', 'proposition 4', '2022-06-08 17:18:55', '2022-06-08 17:18:55'),
(7, 6, 'Avantage déloyale', 'avantage 1', '2022-06-08 17:19:08', '2022-06-08 17:19:08'),
(8, 6, 'Avantage déloyale', '2', '2022-06-08 17:19:20', '2022-06-08 17:19:20'),
(9, 6, 'Segment de client', 'Segment 1', '2022-06-08 17:19:34', '2022-06-08 17:19:34'),
(10, 6, 'Segment de client', 'Segment 2', '2022-06-08 17:19:46', '2022-06-08 17:19:46'),
(11, 6, 'Indicateur', 'Indicateur 1', '2022-06-08 17:20:00', '2022-06-08 17:20:00'),
(12, 6, 'Indicateur', 'Indicateur 2', '2022-06-08 17:20:09', '2022-06-08 17:20:09'),
(13, 6, 'Canaux', 'Canaux 1', '2022-06-08 17:20:20', '2022-06-08 17:20:20'),
(14, 6, 'Structure des coûts', 'Structure 1', '2022-06-08 17:20:34', '2022-06-08 17:20:34'),
(15, 6, 'Sources revenus', 'Source de revenus 1', '2022-06-08 17:20:52', '2022-06-08 17:20:52'),
(16, 6, 'Sources revenus', 'Source de revenus 2', '2022-06-08 17:21:04', '2022-06-08 17:21:04'),
(17, 6, 'Sources revenus', 'Source de revenus 2', '2022-06-08 17:21:15', '2022-06-08 17:21:15'),
(18, 6, 'Canaux', 'Canaux 2', '2022-06-08 17:21:31', '2022-06-08 17:21:31'),
(19, 9, 'Proposition de valeur unique', 'cool', '2022-06-08 17:57:06', '2022-06-08 17:57:06'),
(20, 6, 'Solution', 'solution ok', '2022-06-09 06:36:46', '2022-06-09 06:36:46'),
(21, 6, 'Avantage déloyale', 'coucou', '2022-06-10 12:05:22', '2022-06-10 12:05:22'),
(23, 1, 'Solution', 'solution ok plus', '2022-06-16 19:18:02', '2022-06-16 19:35:53'),
(24, 1, 'Proposition de valeur unique', 'proposition', '2022-06-16 19:18:11', '2022-06-16 19:18:29'),
(25, 1, 'Problème', 'problème 1', '2022-06-16 19:19:06', '2022-06-16 19:19:06'),
(26, 1, 'Problème', 'problème 2', '2022-06-16 19:19:14', '2022-06-16 19:19:14'),
(27, 1, 'Solution', 'solution ok', '2022-06-16 19:35:39', '2022-06-16 19:35:39'),
(28, 1, 'Canaux', 'ok', '2022-07-13 21:01:31', '2022-07-13 21:01:31');

-- --------------------------------------------------------

--
-- Structure de la table `link_canvas_deuxes`
--

DROP TABLE IF EXISTS `link_canvas_deuxes`;
CREATE TABLE IF NOT EXISTS `link_canvas_deuxes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_coach` int(11) NOT NULL,
  `ceo` int(11) NOT NULL,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `link_canvas_deuxes`
--

INSERT INTO `link_canvas_deuxes` (`id`, `id_coach`, `ceo`, `titre`, `message`, `created_at`, `updated_at`) VALUES
(2, 4, 6, 'Problème', 'probleme correction 2', '2022-06-11 05:18:48', '2022-06-14 14:19:44'),
(3, 4, 6, 'Solution', 'solution correction 1', '2022-06-11 05:19:15', '2022-06-11 05:19:15'),
(4, 4, 6, 'Solution', 'solution correction ok', '2022-06-11 05:19:31', '2022-06-23 07:32:13'),
(5, 4, 6, 'Proposition de valeur unique', 'proposition correction 1', '2022-06-11 05:19:49', '2022-06-11 05:19:49'),
(6, 4, 6, 'Proposition de valeur unique', 'proposition correction 2', '2022-06-11 05:20:04', '2022-06-11 05:20:04'),
(7, 4, 6, 'Avantage déloyale', 'avantage correction 1', '2022-06-11 05:20:20', '2022-06-11 05:20:20'),
(8, 4, 6, 'Segment de client', 'segment correction 1', '2022-06-11 05:20:33', '2022-06-11 05:20:33'),
(9, 4, 6, 'Segment de client', 'segment correction 2', '2022-06-11 05:20:42', '2022-06-11 05:20:42'),
(10, 4, 6, 'Indicateur', 'indicateur correction 1', '2022-06-11 05:20:56', '2022-06-11 05:20:56'),
(11, 4, 6, 'Canaux', 'canaux de distribution correction 1', '2022-06-11 05:21:18', '2022-06-11 05:21:18'),
(12, 4, 6, 'Canaux', 'canaux de distribution correction 2', '2022-06-11 05:21:30', '2022-06-11 05:21:30'),
(13, 4, 6, 'Structure des coûts', 'structure de cout correction 1', '2022-06-11 05:21:48', '2022-06-11 05:21:48'),
(14, 4, 6, 'Structure des coûts', 'structure de cout correction 400$', '2022-06-11 05:22:48', '2022-06-11 05:22:48'),
(16, 4, 6, 'Sources revenus', 'source de revenu  correction 2', '2022-06-11 05:23:23', '2022-06-11 05:23:23'),
(18, 4, 6, 'Problème', 'ok', '2022-06-11 07:20:49', '2022-06-11 07:20:49');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `message`, `created_at`, `updated_at`, `receiver_id`, `image`) VALUES
(3, 2, 'oui bonjour', '2022-06-17 18:39:35', '2022-06-17 18:39:35', NULL, NULL),
(4, 6, 'Ni sawa?', '2022-06-17 18:39:48', '2022-06-17 18:39:48', NULL, NULL),
(5, 3, '👍', '2022-06-17 18:39:56', '2022-06-17 18:39:56', NULL, NULL),
(8, 12, 'ok boos', '2022-06-17 18:49:51', '2022-06-17 18:49:51', NULL, NULL),
(9, 4, 'ok boos', '2022-06-17 19:00:46', '2022-06-17 19:00:46', NULL, NULL),
(10, 4, '😍lool!😘', '2022-06-17 19:25:38', '2022-06-17 19:25:38', NULL, NULL),
(11, 6, NULL, '2022-06-17 19:26:45', '2022-06-17 19:26:45', NULL, 'chat/c8rXMNO6RcO58qKg592tyZHQVd3arxZoNgEkv50l.png'),
(13, 6, '😍👍 ok boos', '2022-06-17 19:55:06', '2022-06-17 19:55:06', NULL, NULL),
(14, 4, NULL, '2022-06-17 19:55:39', '2022-06-17 19:55:39', NULL, '1655502939.jpg'),
(15, 4, 'sawa🍊', '2022-06-17 19:58:09', '2022-06-17 19:58:09', NULL, NULL),
(16, 12, '😍 mdr!', '2022-06-17 19:58:33', '2022-06-17 19:58:33', NULL, NULL),
(17, 11, '🤐 je la boucle!', '2022-06-17 20:10:49', '2022-06-17 20:10:49', NULL, NULL),
(18, 12, 'On the local everything works fine, when I upload an image it will upload in storage folder and link of it will appear in public folder but since I moved to live host and production mode my images will upload in storage folder but nothing in my public_html/storage and I\'m not able to get them in my front-end.', '2022-06-17 20:21:58', '2022-06-17 20:21:58', NULL, NULL),
(20, 11, NULL, '2022-06-17 20:44:40', '2022-06-17 20:44:40', NULL, NULL),
(23, 4, NULL, '2022-06-18 08:32:58', '2022-06-18 08:32:58', NULL, '1655548378.png'),
(25, 4, 'ça va?', '2022-06-18 11:08:25', '2022-06-18 11:08:25', 14, NULL),
(27, 12, 'Ni sawa?', '2022-06-18 11:09:02', '2022-06-18 11:09:02', 4, NULL),
(28, 12, 'Ndiyo ni sawa?', '2022-06-18 11:09:28', '2022-06-18 11:09:28', 4, NULL),
(29, 4, 'Na weye?', '2022-06-18 11:09:40', '2022-06-18 11:09:40', 12, NULL),
(30, 12, 'On the local everything works fine, when I upload an image it will upload in storage folder and link of it will appear in public folder but since I moved to live host and production mode my images will upload in storage folder but nothing in my public_html/storage and I\'m not able to get them in my front-end.', '2022-06-18 11:10:00', '2022-06-18 11:10:00', 4, NULL),
(33, 4, '👍😍 bonjour', '2022-06-18 12:11:03', '2022-06-18 12:11:03', 15, NULL),
(46, 4, 'Hi bro!', '2022-06-18 13:22:06', '2022-06-18 13:22:06', 10, NULL),
(47, 4, NULL, '2022-06-18 13:23:46', '2022-06-18 13:23:46', NULL, '1655565826.png'),
(48, 1, 'Bonjour', '2022-06-18 13:27:18', '2022-06-18 13:27:18', 11, NULL),
(49, 1, 'Bonjour!', '2022-06-18 13:27:32', '2022-06-18 13:27:32', 4, NULL),
(50, 1, 'Hi😍', '2022-06-18 13:27:56', '2022-06-18 13:27:56', NULL, NULL),
(52, 1, 'hi boos!', '2022-06-18 13:39:32', '2022-06-18 13:39:32', 4, NULL),
(53, 4, 'hi to! _a va?', '2022-06-18 13:40:00', '2022-06-18 13:40:00', 1, NULL),
(54, 1, 'oui oui et toi?', '2022-06-18 13:40:19', '2022-06-18 13:40:19', 4, NULL),
(55, 4, 'moi aussi👩‍💻👩‍💻', '2022-06-18 13:41:10', '2022-06-18 13:41:10', 1, NULL),
(56, 4, '👍', '2022-06-18 13:42:00', '2022-06-18 13:42:00', 1, NULL),
(57, 1, 'ok', '2022-06-18 13:42:10', '2022-06-18 13:42:10', 4, NULL),
(58, 4, 'hi boos', '2022-06-18 13:44:02', '2022-06-18 13:44:02', NULL, NULL),
(59, 1, 'hi to', '2022-06-18 13:44:43', '2022-06-18 13:44:43', NULL, NULL),
(60, 1, 'dfff', '2022-06-18 13:55:43', '2022-06-18 13:55:43', 4, NULL),
(61, 4, 'ok', '2022-06-20 11:05:49', '2022-06-20 11:05:49', 14, NULL),
(62, 4, '👍', '2022-06-20 11:08:29', '2022-06-20 11:08:29', 15, NULL),
(63, 4, 'hi ☝️', '2022-06-20 11:10:42', '2022-06-20 11:10:42', 11, NULL),
(64, 4, 'Bonjour👍', '2022-06-23 07:44:12', '2022-06-23 07:44:12', 1, NULL),
(65, 1, 'oui bonjour', '2022-06-23 07:44:31', '2022-06-23 07:44:31', 4, NULL),
(66, 4, 'ok', '2022-06-23 07:44:53', '2022-06-23 07:44:53', NULL, NULL),
(67, 4, '👍 salut', '2022-07-02 11:33:00', '2022-07-02 11:33:00', 12, NULL),
(68, 12, 'ok boss', '2022-07-02 11:33:16', '2022-07-02 11:33:16', 4, NULL),
(69, 4, '😃', '2022-07-07 11:20:53', '2022-07-07 11:20:53', 12, NULL),
(70, 11, 'Bonjour boss', '2022-07-07 13:51:06', '2022-07-07 13:51:06', 18, NULL),
(71, 11, 'Bonjour boss', '2022-07-07 13:51:18', '2022-07-07 13:51:18', 17, NULL),
(72, 11, 'Bonjour boss', '2022-07-07 13:51:25', '2022-07-07 13:51:25', 14, NULL),
(73, 11, 'Hi boss!', '2022-07-07 13:52:00', '2022-07-07 13:52:00', 13, NULL),
(74, 11, 'Bonjour boss!🌏🏚️', '2022-07-07 13:52:47', '2022-07-07 13:52:47', 4, NULL),
(75, 11, 'Sawa les gars!👍', '2022-07-07 13:54:04', '2022-07-07 13:54:04', NULL, NULL),
(76, 3, 'hi', '2022-07-13 20:47:51', '2022-07-13 20:47:51', 21, NULL),
(77, 3, 'ni sawa😀👍', '2022-07-13 20:48:10', '2022-07-13 20:48:10', 17, NULL),
(78, 3, 'ni sawa boss?', '2022-07-13 20:48:39', '2022-07-13 20:48:39', 4, NULL),
(79, 4, 'salut', '2022-07-15 15:18:02', '2022-07-15 15:18:02', 12, NULL),
(80, 4, '👍 ni sawa?', '2022-07-15 15:18:22', '2022-07-15 15:18:22', 12, NULL),
(81, 3, 'Bonjour!', '2022-07-15 18:15:44', '2022-07-15 18:15:44', 18, NULL),
(82, 3, NULL, '2022-07-15 18:16:11', '2022-07-15 18:16:11', NULL, '1657916170.jpg'),
(83, 3, '👍😍', '2022-07-15 18:16:17', '2022-07-15 18:16:17', NULL, NULL),
(84, 4, 'salut boss👍', '2022-10-17 21:48:25', '2022-10-17 21:48:25', 11, NULL),
(85, 4, 'bonjour!', '2022-10-17 21:49:39', '2022-10-17 21:49:39', NULL, NULL),
(86, 4, 'hi', '2022-10-18 10:41:03', '2022-10-18 10:41:03', 12, NULL),
(87, 4, NULL, '2022-10-18 10:41:41', '2022-10-18 10:41:41', NULL, '1666096901.svg'),
(88, 4, NULL, '2022-10-18 10:41:43', '2022-10-18 10:41:43', NULL, NULL),
(89, 4, NULL, '2022-10-18 10:41:55', '2022-10-18 10:41:55', NULL, '1666096915.png'),
(90, 4, 'hi', '2022-10-18 10:41:59', '2022-10-18 10:41:59', NULL, NULL),
(91, 3, 'bonjour', '2022-11-28 09:29:35', '2022-11-28 09:29:35', 19, NULL),
(92, 3, 'Bonjour', '2022-11-28 09:30:53', '2022-11-28 09:30:53', 11, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=399 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2022_01_14_120826_create_roles_table', 2),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 3),
(7, '2014_10_12_000000_create_users_table', 4),
(8, '2022_01_29_121045_create_sites_table', 5),
(9, '2022_01_29_150923_create_basics_table', 6),
(10, '2022_01_29_202952_create_services_table', 7),
(12, '2022_02_01_141050_create_partenaires_table', 9),
(13, '2022_02_01_170959_create_galeries_table', 10),
(14, '2022_02_01_204506_create_videos_table', 11),
(15, '2022_05_31_105154_create_pays_table', 12),
(16, '2022_05_31_113453_create_provinces_table', 13),
(17, '2022_05_31_115613_create_secteurs_table', 14),
(18, '2022_05_31_123221_create_forme_juridiques_table', 15),
(19, '2022_05_31_210441_create_entreprises_table', 16),
(20, '2022_06_02_091439_create_pitches_table', 17),
(21, '2022_06_02_114822_create_busness_plans_table', 18),
(22, '2022_06_04_060844_create_link_canvases_table', 19),
(23, '2022_06_04_061458_create_swots_table', 19),
(24, '2022_06_04_095039_create_photo_entreprises_table', 20),
(25, '2022_06_04_105425_create_video_entreprises_table', 21),
(26, '2022_06_11_062250_create_link_canvas_deuxes_table', 22),
(27, '2022_06_11_062454_create_swot_deuxes_table', 22),
(28, '2022_06_16_095405_create_mot_semaines_table', 23),
(31, '2022_06_17_095822_create_messages_table', 24),
(32, '2022_06_17_103443_add_receiver_id_field_to_messages', 24),
(33, '2022_06_17_143153_add_image_column_to_messages', 24),
(35, '2022_07_07_082850_create_theme_formes_table', 25),
(36, '2022_07_07_081205_create_odd_formes_table', 26),
(37, '2022_07_08_120716_create_user_attendaces_table', 27),
(39, '2022_07_13_101911_create_teams_table', 28),
(41, '2022_08_29_124727_create_category_articles_table', 29),
(42, '2022_01_31_083252_create_blogs_table', 30),
(43, '2022_10_19_082855_create_territoires_table', 31),
(44, '2022_09_03_181439_create_contact_infos_table', 32),
(45, '2022_09_04_212957_create_carousels_table', 33),
(46, '2022_09_19_142233_create_villes_table', 34),
(47, '2022_09_20_053623_create_communes_table', 34),
(48, '2022_09_20_074025_create_quartiers_table', 34),
(49, '2022_09_20_083452_create_avenues_table', 34),
(50, '2022_10_19_173744_create_textos_table', 34),
(51, '2022_09_02_080310_create_temoignages_table', 35),
(52, '2022_09_02_091353_create_valeurs_table', 35),
(53, '2022_09_02_100234_create_choixes_table', 36),
(54, '2022_09_02_103441_create_decisions_table', 36),
(55, '2022_09_02_111224_create_avantages_table', 36),
(56, '2022_09_02_112731_create_service_entreps_table', 36),
(57, '2022_09_02_093738_create_role_services_table', 37),
(58, '2022_09_02_121010_create_sou_service_entreps_table', 38),
(59, '2023_01_01_023402_create_tcarte_table', 39),
(60, '2023_01_01_023658_create_tdata_malade_table', 40),
(61, '2023_01_01_023728_create_trdv_malade_table', 40),
(62, '2023_07_23_024051_create_tdata_rapportmedical_table', 41),
(69, '2023_08_08_085334_create_thopital_table', 42),
(158, '2023_06_23_075442_create_tconf_list_menu_table', 56),
(159, '2023_06_23_075744_create_tconf_affectation_menu_table', 56),
(160, '2023_07_15_080326_create_tconf_crud_access_table', 56),
(161, '2023_09_05_040515_create_tconf_historique_information_table', 57),
(179, '2023_12_20_094603_create_categories_table', 58),
(181, '2023_12_20_094605_create_produits_table', 58),
(184, '2023_12_20_094604_create_clients_table', 59),
(185, '2023_12_20_094651_create_factures_table', 59),
(186, '2023_12_20_094706_create_detail_factures_table', 59),
(191, '2022_10_01_030845_create_tagent_table', 61),
(193, '2023_06_12_100788_create_tperso_lieuaffectation_table', 61),
(194, '2023_06_12_100789_create_tperso_mutuelle_table', 61),
(195, '2023_06_12_100790_create_tperso_typecontrat_table', 61),
(196, '2023_06_12_100791_create_tperso_categorie_agent_table', 61),
(197, '2023_06_12_100792_create_tperso_mois_table', 61),
(198, '2023_06_12_100793_create_tperso_categorie_rubrique_table', 61),
(199, '2023_06_12_100795_create_tperso_raison_familiale_table', 61),
(200, '2023_06_12_100796_create_tperso_annee_table', 61),
(201, '2023_06_12_100797_create_tperso_categorie_service_table', 61),
(202, '2023_06_12_100798_create_tperso_service_personnel_table', 61),
(205, '2023_06_12_102703_create_tperso_dependant_table', 62),
(206, '2023_06_12_102937_create_tperso_demande_soin_table', 62),
(207, '2023_06_12_104039_create_tperso_sortie_agent_table', 62),
(208, '2023_06_12_104423_create_tperso_entete_conge_table', 62),
(209, '2023_06_12_104424_create_tperso_autre_conge_table', 62),
(210, '2023_06_12_104443_create_tperso_maternite_table', 62),
(211, '2023_06_12_104548_create_tperso_controle_conge_table', 62),
(212, '2023_06_12_105748_create_tperso_maladie_conge_table', 62),
(213, '2023_06_12_105841_create_tperso_conge_familiale_table', 62),
(214, '2023_06_12_110012_create_tperso_conge_annuel_table', 62),
(215, '2023_06_12_110355_create_tperso_appreciation_agent_table', 62),
(216, '2023_06_12_112927_create_tperso_fiche_paie_table', 62),
(217, '2023_06_12_112928_create_tperso_entete_paiement_table', 62),
(218, '2023_06_12_112929_create_tperso_parametre_rubrique_table', 62),
(219, '2023_06_12_112930_create_tperso_detail_affectation_ribrique_table', 62),
(220, '2023_06_12_113221_create_tperso_detail_paiement_sal_table', 62),
(221, '2023_06_21_202014_create_tperso_avance_salaire_table', 62),
(227, '2024_05_11_095115_create_tperso_livrables_table', 62),
(228, '2024_05_11_095218_create_tperso_paie_projet_table', 62),
(229, '2024_05_11_102046_create_tperso_affectation_tache_table', 62),
(237, '2024_05_11_095031_create_tperso_activites_projet_table', 67),
(238, '2024_05_24_063604_create_tperso_division_table', 68),
(239, '2024_05_24_063942_create_tperso_categorie_archivage_table', 68),
(240, '2024_05_24_063943_create_tperso_service_archivage_table', 68),
(241, '2024_05_24_064019_create_tperso_archivages_table', 68),
(242, '2024_05_24_064238_create_tperso_promotion_stage_table', 68),
(243, '2024_05_24_064301_create_tperso_domaine_stage_table', 68),
(244, '2024_05_24_064409_create_tperso_option_stage_table', 68),
(245, '2024_05_24_064454_create_tperso_annee_stage_table', 68),
(246, '2024_05_24_064615_create_tperso_institution_stage_table', 68),
(247, '2024_05_24_064616_create_tperso_stages_table', 68),
(248, '2024_05_24_064644_create_tperso_parcours_stage_table', 68),
(249, '2024_05_29_131655_create_tperso_annexe_table', 69),
(253, '2024_05_24_064455_create_tperso_type_stage_table', 72),
(258, '2024_06_25_190228_create_tperso_heure_travail_table', 75),
(260, '2023_06_12_100786_create_tperso_partenaire_table', 77),
(261, '2023_06_12_100787_create_tperso_poste_table', 77),
(262, '2023_06_12_102699_create_tperso_projets_table', 78),
(263, '2023_06_12_102700_create_tperso_parametre_salairebase_table', 78),
(264, '2023_06_12_102701_create_tperso_affectation_agent_table', 78),
(265, '2023_06_12_102702_create_tperso_rubrique_table', 79),
(269, '2024_07_02_123229_create_tperso_enmission_table', 79),
(270, '2024_07_02_124706_create_tperso_bareme_table', 79),
(271, '2023_06_12_113220_create_tperso_detail_paie_salaire_table', 80),
(274, '2024_07_31_094155_create_tperso_correspondance_table', 82),
(275, '2024_07_31_120445_create_tperso_timesheet_table', 82),
(281, '2024_08_08_181153_create_tchecklist_table', 83),
(282, '2024_06_25_163542_create_tperso_presences_agent_table', 84),
(283, '2024_09_16_105135_create_tperso_presences_temp_table', 85),
(284, '2022_09_20_053624_create_tlog_emplacements_table', 86),
(285, '2022_09_20_053625_create_tperso_categorie_circonstance_table', 87),
(286, '2022_09_20_074026_create_tfin_typeposition_table', 87),
(287, '2022_09_20_074027_create_tfin_classe_table', 87),
(288, '2022_09_20_074028_create_tfin_typecompte_table', 87),
(289, '2022_09_20_074029_create_tfin_compte_table', 87),
(290, '2022_09_20_074030_create_tfin_souscompte_table', 87),
(291, '2022_09_20_074031_create_tfin_ssouscompte_table', 87),
(292, '2022_09_20_074032_create_tfin_typeproduit_table', 87),
(293, '2022_09_20_074033_create_tfin_typeoperation_table', 87),
(294, '2022_09_20_074034_create_tconf_banque', 87),
(295, '2022_09_20_083453_create_tvente_services_table', 87),
(296, '2022_09_20_083454_create_tvente_tva_table', 87),
(297, '2022_09_20_083455_create_tvente_unite_table', 88),
(298, '2022_09_20_083456_create_tvente_module_table', 89),
(300, '2022_09_20_083458_create_tvente_categorie_fournisseur_table', 89),
(305, '2022_10_04_173723_create_tcategoriemedecin_table', 89),
(306, '2022_10_04_173723_create_tfonctionmedecin_table', 89),
(307, '2022_10_04_174459_create_tcompte_table', 90),
(308, '2022_10_04_174459_create_tdepense_table', 90),
(309, '2022_11_14_063842_create_tconf_modepaiement_table', 90),
(310, '2023_01_01_023729_create_tt_treso_bloc_table', 90),
(311, '2023_01_01_023730_create_tt_treso_categorie_rubrique_table', 90),
(312, '2023_01_01_023731_create_tt_treso_rubrique_table', 90),
(313, '2023_01_01_023732_create_tt_treso_provenance_table', 90),
(314, '2023_01_01_023733_create_tt_treso_entete_etatbesoin_table', 90),
(315, '2023_01_01_023734_create_tt_treso_detail_etatbesoin_table', 90),
(316, '2023_02_23_194247_create_ttreso_entete_angagement_table', 90),
(317, '2023_02_23_195710_create_tt_treso_detail_angagement_table', 90),
(318, '2023_04_11_095148_create_tfin_cloture_caisse', 90),
(319, '2023_06_12_113222_create_tperso_detail_paiement_sal_table', 91),
(320, '2023_06_12_113223_create_tvente_fournisseur_table', 91),
(321, '2023_06_12_113224_create_tvente_categorie_produit_table', 91),
(322, '2023_06_12_113225_create_tlog_produit_table', 91),
(323, '2023_06_12_113226_create_tlog_service_table', 91),
(324, '2023_06_15_124716_create_tlog_entete_entree_table', 91),
(325, '2023_06_15_125036_create_tlog_entete_sortie_table', 91),
(326, '2023_06_15_125151_create_tlog_entete_requisition_table', 91),
(327, '2023_06_15_125217_create_tlog_detail_entree_table', 91),
(328, '2023_06_15_125244_create_tlog_detail_requisition_table', 91),
(329, '2023_06_15_125309_create_tlog_detail_sortie_table', 91),
(330, '2023_06_30_084321_create_tfin_cloture_comptabilite_table', 91),
(332, '2023_08_23_061900_create_tvente_client_table', 91),
(333, '2023_08_23_061945_create_tvente_produit_table', 91),
(334, '2023_08_23_061946_create_tvente_entete_requisition_table', 91),
(335, '2023_08_23_061947_create_tvente_detail_requisition_table', 91),
(338, '2023_08_24_064046_create_tvente_taux_table', 91),
(339, '2023_08_24_081648_create_thotel_billard_table', 92),
(340, '2023_08_24_081750_create_thotel_classe_chambre_table', 92),
(341, '2023_08_24_081809_create_thotel_chambre_table', 92),
(342, '2023_08_24_081831_create_thotel_salle_table', 92),
(343, '2023_08_24_081858_create_thotel_reservation_chambre_table', 92),
(344, '2023_08_24_081919_create_thotel_paiement_chambre_table', 92),
(345, '2023_08_24_081945_create_thotel_reservation_salle_table', 92),
(346, '2023_08_24_082014_create_thotel_paiement_salle_table', 92),
(347, '2023_08_24_082015_create_tvente_entete_vente_table', 92),
(349, '2023_08_24_082017_create_tvente_paiement_table', 93),
(350, '2023_08_24_082109_create_thotel_incident_reservation_salle_table', 93),
(351, '2023_09_24_123122_create_tsalon_produit_table', 93),
(352, '2023_09_24_123415_create_tsalon_entete_vente_table', 93),
(353, '2023_09_24_123439_create_tsalon_detail_vente_table', 93),
(354, '2023_09_24_123513_create_tsalon_paiement_table', 93),
(355, '2023_09_24_123514_create_tcar_vehicule_table', 93),
(356, '2023_09_24_123515_create_tcar_producteur_table', 93),
(357, '2023_09_24_123516_create_tcar_entete_mouvement_table', 93),
(358, '2023_09_24_123517_create_tcar_produit_table', 93),
(359, '2023_09_25_100757_create_tcar_detail_entree_table', 93),
(360, '2023_09_25_100902_create_tcar_detail_solde_table', 93),
(361, '2023_09_26_065320_create_tcar_paiement_table', 93),
(362, '2023_09_26_070055_create_tcar_emballage_table', 93),
(363, '2023_09_28_085750_create_tcar_detail_casse_table', 93),
(364, '2023_09_29_093047_create_tcar_annexe_table', 93),
(365, '2024_05_05_110109_create_tperso_typecirconstanceconge_table', 93),
(366, '2024_05_11_102047_create_tperso_demandeconge_table', 94),
(367, '2024_09_20_194900_create_tperso_annexe_projet_table', 94),
(369, '2024_09_26_120749_create_tvente_paiement_commande_table', 94),
(371, '2024_09_26_120853_create_tvente_detail_transfert_table', 94),
(372, '2024_09_27_120147_create_tvente_entete_commandeclient_table', 94),
(373, '2024_09_27_120209_create_tvente_detail_commandeclient_table', 94),
(374, '2022_09_20_083457_create_tvente_autorisation_table', 95),
(376, '2022_09_20_083460_create_tvente_validations_table', 95),
(378, '2022_09_20_083462_create_tvente_parametre_tva_table', 95),
(379, '2024_09_26_120650_create_tvente_detail_unite_table', 95),
(381, '2023_08_23_061831_create_tvente_categorie_client_table', 96),
(382, '2024_10_02_023455_create_tvente_param_systeme_table', 97),
(383, '2024_10_02_024702_create_tvente_entete_inventaire_table', 97),
(384, '2024_10_02_024729_create_tvente_detail_inventaire_table', 97),
(385, '2022_09_20_083459_create_tvente_entete_paiecommande_table', 98),
(386, '2022_09_20_083461_create_tvente_entete_paievente_table', 98),
(387, '2023_08_23_062054_create_tvente_entete_entree_table', 98),
(389, '2024_09_26_120823_create_tvente_entete_transfert_table', 98),
(390, '2024_10_02_103752_create_tvente_entete_cuisine_table', 98),
(391, '2024_10_02_103959_create_tvente_detail_cuisine_table', 98),
(392, '2023_08_23_062137_create_tvente_detail_entree_table', 99),
(393, '2024_10_18_190828_create_tvente_user_service_table', 100),
(394, '2023_08_24_082016_create_tvente_detail_vente_table', 101),
(396, '2024_10_19_071248_create_tvente_devise_table', 101),
(397, '2024_10_19_070802_create_tvente_stock_service_table', 102),
(398, '2024_10_22_143714_create_tvente_annexe_commande_table', 103);

-- --------------------------------------------------------

--
-- Structure de la table `mot_semaines`
--

DROP TABLE IF EXISTS `mot_semaines`;
CREATE TABLE IF NOT EXISTS `mot_semaines` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mot_semaines`
--

INSERT INTO `mot_semaines` (`id`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Jeune développeur, développer pour ton avenir et celui de ton pays!', '2022-06-16 08:41:05', '2022-06-16 08:41:28'),
(2, 'Jeune entrepreneur, entreprends pour ton avenir et celui de ton pays!', '2022-06-16 08:41:42', '2022-06-16 08:42:48');

-- --------------------------------------------------------

--
-- Structure de la table `odd_formes`
--

DROP TABLE IF EXISTS `odd_formes`;
CREATE TABLE IF NOT EXISTS `odd_formes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `odd` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptionOdd` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `icone` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `odd_formes_odd_unique` (`odd`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `odd_formes`
--

INSERT INTO `odd_formes` (`id`, `odd`, `descriptionOdd`, `icone`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'ODD n°1 - Pas de pauvreté ', 'Éliminer la pauvreté sous toutes ses formes et partout dans le monde', '1657191300.png', NULL, '2022-07-07 08:36:28', '2022-07-07 08:55:00'),
(2, 'ODD n°2 - Faim « Zéro »', 'Éliminer la faim, assurer la sécurité alimentaire, améliorer la nutrition et promouvoir l’agriculture durable', '1657191329.jpg', NULL, '2022-07-07 08:55:29', '2022-07-07 08:55:29'),
(3, 'ODD n°3 - Bonne santé et bien-être', 'Permettre à tous de vivre en bonne santé et promouvoir le bien-être de tous à tout âge', '1657191353.png', NULL, '2022-07-07 08:55:53', '2022-07-07 08:55:53'),
(4, 'ODD n°4 - Éducation de qualité', 'Assurer à tous une éducation équitable, inclusive et de qualité et des possibilités d’apprentissage tout au long de la vie', '1657191386.png', NULL, '2022-07-07 08:56:26', '2022-07-07 08:56:26'),
(5, ' ODD n°5 - Égalité entre les sexes', 'Parvenir à l’égalité des sexes et autonomiser toutes les femmes et toutes les filles', '1657191407.png', NULL, '2022-07-07 08:56:47', '2022-07-07 08:56:47'),
(6, 'ODD n°6 - Eau propre et assainissement', 'Garantir l’accès de tous à des services d’alimentation en eau et d’assainissement gérés de façon durable', '1657191438.png', NULL, '2022-07-07 08:57:18', '2022-07-07 08:57:18'),
(7, 'ODD n°7 - Énergie propre et d\'un coût abordable', 'Garantir l’accès de tous à des services énergétiques fiables, durables et modernes, à un coût abordable', '1657191461.png', NULL, '2022-07-07 08:57:41', '2022-07-07 08:57:41'),
(8, 'ODD n°8 - Travail décent et croissance économique', 'Promouvoir une croissance économique soutenue, partagée et durable, le plein emploi productif et un travail décent pour tous', '1657191484.png', NULL, '2022-07-07 08:58:04', '2022-07-07 08:58:04'),
(9, 'ODD n°9 - Industrie, innovation et infrastructure', 'Bâtir une infrastructure résiliente, promouvoir une industrialisation durable qui profite à tous et encourager l’innovation', '1657191508.png', NULL, '2022-07-07 08:58:28', '2022-07-07 08:58:28'),
(10, 'ODD n°10 - Inégalités réduites', 'Réduire les inégalités dans les pays et d’un pays à l’autre', '1657191535.png', NULL, '2022-07-07 08:58:55', '2022-07-07 08:58:55'),
(11, 'ODD n°11 - Villes et communautés durable', 'Faire en sorte que les villes et les établissements humains soient ouverts à tous, sûrs, résilients et durables', '1657191560.png', NULL, '2022-07-07 08:59:20', '2022-07-07 08:59:20'),
(12, 'ODD n°12 - Consommation et production responsables', 'Établir des modes de consommation et de production durables', '1657191588.png', NULL, '2022-07-07 08:59:48', '2022-07-07 08:59:48'),
(13, 'ODD n°13 - Lutte contre les changements climatiques', 'Prendre d’urgence des mesures pour lutter contre les changements climatiques et leurs répercussions', '1657191614.png', NULL, '2022-07-07 09:00:14', '2022-07-07 09:00:14'),
(14, 'ODD n°14 - Vie aquatique', 'Conserver et exploiter de manière durable les océans, les mers et les ressources marines aux fins du développement durable', '1657191645.png', NULL, '2022-07-07 09:00:45', '2022-07-07 09:00:45'),
(15, 'ODD n°15 - Vie terrestre', 'Préserver et restaurer les écosystèmes terrestres, en veillant à les exploiter de façon durable, gérer durablement les forêts, lutter contre la désertification, enrayer et inverser le processus de dégradation des terres et mettre fin à l’appauvrissement de la biodiversité', '1657191673.png', NULL, '2022-07-07 09:01:13', '2022-07-07 09:01:13'),
(16, 'ODD n°16 - Paix, justice et institutions efficaces', 'Promouvoir l’avènement de sociétés pacifiques et inclusives aux fins du développement durable, assurer l’accès de tous à la justice et mettre en place, à tous les niveaux, des institutions efficaces, responsables et ouvertes à tous', '1657191698.png', NULL, '2022-07-07 09:01:38', '2022-07-07 09:01:38'),
(17, 'ODD n°17 - Partenariats pour la réalisation des objectifs', 'Renforcer les moyens de mettre en œuvre le Partenariat mondial pour le développement durable et le revitaliser', '1657191723.png', NULL, '2022-07-07 09:02:03', '2022-07-07 09:02:03');

-- --------------------------------------------------------

--
-- Structure de la table `partenaires`
--

DROP TABLE IF EXISTS `partenaires`;
CREATE TABLE IF NOT EXISTS `partenaires` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `partenaires`
--

INSERT INTO `partenaires` (`id`, `nom`, `url`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'CIMAK', 'https://cimak.com/', '1690639438.png', '2022-02-01 14:35:09', '2023-07-29 12:03:58'),
(2, 'CEDC', 'https://cedcs.com/', '1690639570.jpg', '2022-02-01 15:42:14', '2023-07-29 12:06:10'),
(4, 'Hôpital Doc', 'https://docs.com/', '1690639618.jpg', '2022-02-01 15:46:58', '2023-07-29 12:06:58');

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('admin@gmail.com', '6VlxJrIolFDFtQuNdjHC33BdDCuf14oM1DB6IPGr3Tu3w6kzqULofYD3EKBG', '2022-01-27 10:46:27'),
('admin@gmail.com', 'QWaQileVQL5bBtuacovFbHQ5ivK6bV5KtmyTQkxXKiAmsc6R3Aog0inK6xWh', '2022-06-21 03:37:51'),
('admin@gmail.com', 'xlNkfexyLicDg2TXOZ119GSnIcPpTtXiQ47VoM5WziIXq3OtXTTdbxMVWfyx', '2022-06-21 03:40:33');

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomPays` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id`, `nomPays`, `created_at`, `updated_at`) VALUES
(1, 'RDCongo', '2022-05-31 09:29:28', '2022-06-13 17:01:44'),
(2, 'Cameroun', '2022-05-31 09:29:51', '2022-05-31 09:29:51');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo_entreprises`
--

DROP TABLE IF EXISTS `photo_entreprises`;
CREATE TABLE IF NOT EXISTS `photo_entreprises` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_entreprise` int(11) NOT NULL,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `photo_entreprises`
--

INSERT INTO `photo_entreprises` (`id`, `id_entreprise`, `photo`, `created_at`, `updated_at`) VALUES
(1, 6, '1654338319.JPG', '2022-06-04 08:25:19', '2022-06-04 08:25:19'),
(2, 6, '1654338330.JPG', '2022-06-04 08:25:30', '2022-06-04 08:25:30'),
(3, 6, '1654338342.JPG', '2022-06-04 08:25:42', '2022-06-04 08:25:42'),
(4, 6, '1654338355.jpg', '2022-06-04 08:25:55', '2022-06-04 08:25:55'),
(5, 6, '1654338363.jpg', '2022-06-04 08:26:03', '2022-06-04 08:26:03'),
(6, 6, '1654338371.jpg', '2022-06-04 08:26:11', '2022-06-04 08:26:11'),
(7, 6, '1654338380.jpg', '2022-06-04 08:26:20', '2022-06-04 08:26:20'),
(8, 6, '1654338388.jpg', '2022-06-04 08:26:28', '2022-06-04 08:26:28'),
(9, 6, '1654338405.jpg', '2022-06-04 08:26:45', '2022-06-04 08:26:45'),
(10, 6, '1654338414.jpg', '2022-06-04 08:26:54', '2022-06-04 08:26:54'),
(11, 6, '1654338419.png', '2022-06-04 08:26:59', '2022-06-04 08:26:59'),
(13, 1, '1655413663.jpg', '2022-06-16 19:07:43', '2022-06-16 19:07:43'),
(14, 1, '1655413672.png', '2022-06-16 19:07:52', '2022-06-16 19:07:52'),
(15, 1, '1655413681.png', '2022-06-16 19:08:01', '2022-06-16 19:08:01');

-- --------------------------------------------------------

--
-- Structure de la table `pitches`
--

DROP TABLE IF EXISTS `pitches`;
CREATE TABLE IF NOT EXISTS `pitches` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_entreprise` int(11) NOT NULL,
  `pitch` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pitches`
--

INSERT INTO `pitches` (`id`, `id_entreprise`, `pitch`, `created_at`, `updated_at`) VALUES
(1, 6, '1654170157.pptx', '2022-06-02 09:42:37', '2022-06-02 09:42:37'),
(2, 1, '1655413576.pptx', '2022-06-16 19:06:16', '2022-06-16 19:06:16');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categorie_id` bigint(20) UNSIGNED NOT NULL,
  `produit_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pu` double(8,2) NOT NULL,
  `qte` double(8,2) NOT NULL,
  `devise` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double(8,2) NOT NULL,
  `unite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produits_categorie_id_foreign` (`categorie_id`),
  KEY `produits_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `categorie_id`, `produit_name`, `pu`, `qte`, `devise`, `taux`, `unite`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'EAU', 1.00, 0.00, 'USD', 2600.00, 'Litre', 4, '2024-01-03 11:01:18', '2024-01-03 11:01:18'),
(2, 2, 'PRIMUS', 3.00, 0.00, 'USD', 2600.00, 'Litre', 4, '2024-01-03 11:04:22', '2024-01-03 11:04:22'),
(3, 1, 'ORANGE', 2.00, 0.00, 'USD', 2600.00, 'Litre', 4, '2024-01-03 11:04:45', '2024-01-03 11:04:45');

-- --------------------------------------------------------

--
-- Structure de la table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idPays` int(11) NOT NULL,
  `nomProvince` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `provinces`
--

INSERT INTO `provinces` (`id`, `idPays`, `nomProvince`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nord-Kivu', '2022-05-31 09:49:58', '2022-05-31 09:49:58'),
(2, 1, 'Kinshasa', '2022-05-31 09:50:12', '2022-05-31 09:50:12'),
(3, 1, 'Tshopo', '2022-05-31 09:50:57', '2022-05-31 09:51:42'),
(4, 2, 'Douala', '2022-05-31 09:51:17', '2022-05-31 09:51:25'),
(6, 1, 'Sud kivu', '2022-11-17 10:57:48', '2022-11-17 10:57:48');

-- --------------------------------------------------------

--
-- Structure de la table `quartiers`
--

DROP TABLE IF EXISTS `quartiers`;
CREATE TABLE IF NOT EXISTS `quartiers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idCommune` int(11) NOT NULL,
  `nomQuartier` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `quartiers`
--

INSERT INTO `quartiers` (`id`, `idCommune`, `nomQuartier`, `created_at`, `updated_at`) VALUES
(1, 2, 'Mabanga sud', '2022-11-17 10:59:11', '2022-11-17 10:59:11'),
(2, 1, 'Mabanga nord', '2022-11-17 10:59:24', '2022-11-17 10:59:24');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin', NULL, '2024-08-01 19:00:33'),
(2, 'rh', NULL, '2024-08-01 19:00:48'),
(3, 'administration', NULL, '2024-08-01 19:01:37'),
(4, 'coordonateur', '2024-08-01 19:01:18', '2024-08-01 19:01:18'),
(5, 'agent', '2024-08-01 19:01:50', '2024-08-01 19:01:50'),
(6, 'finance', '2024-08-01 19:02:06', '2024-08-01 19:02:06');

-- --------------------------------------------------------

--
-- Structure de la table `role_services`
--

DROP TABLE IF EXISTS `role_services`;
CREATE TABLE IF NOT EXISTS `role_services` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_services`
--

INSERT INTO `role_services` (`id`, `titre`, `description`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'L\'égalité', 'Elle implique l\'absence de discrimination (race, religion, ethnie, âge...) et le devoir de soigner chacun, quels que soient son état de santé et sa situation sociale. L\'hôpital travaille en relation avec les autres professions et institutions compétentes, ainsi qu\'avec les associations d\'insertion et de lutte contre l\'exclusion.', '1669538157.avif', '2022-11-27 07:35:57', '2022-11-27 07:35:57'),
(2, 'La neutralité', 'Elle doit être respectée. Les soins sont donnés en faisant abstraction des croyances et opinions des malades.', '1669538178.avif', '2022-11-27 07:36:18', '2022-11-27 07:36:18'),
(3, 'La continuité', 'L\'hôpital public se caractérise notamment par ses obligations spécifiques en matière d\'accueil en urgence. Il doit mettre en place un système de permanence des soins, de même qu\'un service minimum en cas de grève, et assurer l\'ensemble des traitements, préventifs, curatifs et palliatifs.', '1669538197.avif', '2022-11-27 07:36:37', '2022-11-27 07:36:37'),
(4, 'L\'adaptabilité', 'Les réorganisations et les mutations sont étudiées et réalisées en vue de l\'intérêt général et des besoins de la population. Le patient a droit à un service de qualité et les services rendus doivent être évalués avec rigueur.', '1669538218.avif', '2022-11-27 07:36:58', '2022-11-27 07:36:58');

-- --------------------------------------------------------

--
-- Structure de la table `secteurs`
--

DROP TABLE IF EXISTS `secteurs`;
CREATE TABLE IF NOT EXISTS `secteurs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomSecteur` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `secteurs_nomsecteur_unique` (`nomSecteur`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `secteurs`
--

INSERT INTO `secteurs` (`id`, `nomSecteur`, `created_at`, `updated_at`) VALUES
(1, 'Mine', '2022-05-31 10:22:06', '2022-05-31 10:24:03'),
(2, 'Numérique', '2022-05-31 10:22:17', '2022-05-31 10:22:17'),
(3, 'Heath tech', '2022-05-31 10:22:29', '2022-05-31 10:22:29'),
(4, 'Fin tech', '2022-05-31 10:22:50', '2022-05-31 10:26:28'),
(5, 'Agro transformation', '2022-05-31 10:23:12', '2022-05-31 10:23:12'),
(6, 'Elevage', '2022-05-31 10:23:31', '2022-07-02 11:30:17');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `icone` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `titre`, `description`, `icone`, `created_at`, `updated_at`) VALUES
(1, 'l\'inspiration esthétique', 'Activités qui visent à répondre à des intérêts ou des besoins culturels. Sans prendre la forme de biens matériels, ils en facilitent la production et la diffusion', 'home', '2022-01-31 07:55:31', '2022-10-19 07:55:18'),
(2, 'Loisirs et santé mentale et physique', 'Les loisirs pratiqués dans la nature, par exemple la marche ou bien les jeux sportifs dans les parcs et les espaces verts urbains, jouent un rôle important dans le maintien de la santé mentale et physique.', 'extension', '2022-01-31 07:58:29', '2022-10-19 07:58:13'),
(3, 'Tourisme', 'Les joies de la nature attirent des millions de voyageurs partout dans le monde. Ce service écosystémique culturel est à la fois bénéfique, s\'agissant des visiteurs, et lucratif, s\'agissant des prestataires de services de tourisme vert.', 'design_services', '2022-01-31 07:58:58', '2022-10-19 07:57:07'),
(7, 'Conscience et inspiration esthétiques dans la culture, l\'art et le design', 'Les animaux, les plantes et les écosystèmes sont une source d\'inspiration essentielle dans l\'art, la culture et le design; de plus en plus, ils inspirent aussi la science.', 'open_with', '2022-07-21 09:48:43', '2022-10-19 07:57:44');

-- --------------------------------------------------------

--
-- Structure de la table `service_entreps`
--

DROP TABLE IF EXISTS `service_entreps`;
CREATE TABLE IF NOT EXISTS `service_entreps` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `service_entreps`
--

INSERT INTO `service_entreps` (`id`, `nom`, `titre`, `description`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Formation des acteurs des santés en matière de technologie ', 'Formation des acteurs des santés en matière de technologie ', '&lt;p&gt;&lt;i&gt;&lt;strong&gt;Neurology&lt;/strong&gt;&lt;/i&gt; is the branch of medicine dealing with the diagnosis and treatment of all categories of conditions and disease involving the brain, the spinal&amp;nbsp;...&lt;/p&gt;', '1690640066.png', '2022-11-27 07:04:39', '2023-07-29 12:14:26'),
(2, 'Vente des cartes médicales', 'Vente des cartes médicales', '&lt;p&gt;&lt;i&gt;&lt;strong&gt;Cardiology&lt;/strong&gt;&lt;/i&gt; is a branch of medicine that deals with disorders of the heart and the cardiovascular system. The field includes medical diagnosis and treatment&amp;nbsp;...&lt;/p&gt;', '1690640000.png', '2022-11-27 07:05:40', '2023-07-29 12:13:20'),
(3, 'Concpetion', 'Conception des sites web et des bases de données au sein des entreprises', '&lt;p&gt;&lt;i&gt;&lt;strong&gt;Gastroenterology&lt;/strong&gt;&lt;/i&gt; is the branch of medicine focused on the digestive system and its disorders. &lt;i&gt;&lt;strong&gt;Gastroenterology&lt;/strong&gt;&lt;/i&gt;. Stomach colon rectum diagram-en.svg.&lt;/p&gt;', '1690639947.png', '2022-11-27 07:07:09', '2023-07-29 12:12:27');

-- --------------------------------------------------------

--
-- Structure de la table `sites`
--

DROP TABLE IF EXISTS `sites`;
CREATE TABLE IF NOT EXISTS `sites` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel1` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel2` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel3` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mission` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `objectif` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `politique` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `condition` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `logo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sites`
--

INSERT INTO `sites` (`id`, `nom`, `description`, `email`, `adresse`, `tel1`, `tel2`, `tel3`, `token`, `about`, `mission`, `objectif`, `politique`, `condition`, `logo`, `facebook`, `linkedin`, `twitter`, `youtube`, `created_at`, `updated_at`) VALUES
(2, 'IHUSI-HOTEL', 'Hotelerie', 'info@softech.org', 'Goma, quartier des volcans', '+243818472003', '+243971681767', '+243843044444', 'XYH34d258jhgd0Tdn', NULL, 'L’accès à des services professionnels de développement des start-ups, en particulier l’accélération, est\nune étape très importante pour les start-ups. Trouver la bonne structure, au bon endroit et au bon prix\nest crucial et pourtant la procédure la plus difficile. De plus, plus de 75% des jeunes entreprises dans la\nphase initiale de leur aventure entrepreneuriale s&#39;effondrent en RDC.\nAinsi, le Hub UJN en partenariat avec le Laboratoire d’Accélération du PNUD compte encourager la\nmentalité d&#39;innovation entrepreneuriale, stimuler la croissance économique, et créer des emplois\ndécents (ODD 8) afin de contribuer à la réduction de la pauvreté (ODD 1) en République Démocratique\ndu Congo, mais aussi dans le but de renforcer les capacités en innovation des porteurs des solutions\nretenus sur Goma, Beni et Kisangani, le programme prévoit d’organiser un Boot camp pour une durée\nde 2 semaines.', 'Objectif global : Organiser un boot camp à Goma en faveur des 15 porteurs des solutions innovantes\nretenus dans le cadre du projet JINNOV pour la phase de l’expérimentation.\nObjectifs spécifiques :\n- Améliorer les connaissances entrepreneuriales des 15 jeunes entrepreneurs en leurs donnant des\nformations sur les thèmes : Design Thinking, Discipline entrepreneurship, Anthropologie, les 7\nHabitudes des gens qui réussissent ce qu’ils entreprennent pendant les 2 semaines ;\n- Expérimenter les 15 solutions proposées par les jeunes entrepreneurs ;\n- Amener les 15 jeunes entrepreneurs porteurs des solutions à atteindre leurs objectifs entrepreneurials ;\n- Perfectionner le business Plan des 15 jeunes porteurs des solutions ;\n3. Résultats attendus\n- 15 porteurs de solutions sont formés au travers du Boot Camp à Goma ;\n- 15 jeunes entrepreneurs sont coachés ;\n- 15 porteurs des solutions font l’expérimentations de leurs projets ;\n- 15 porteurs des solutions pitchent leurs projets.\n- 15 porteurs des solutions ont un BP mis à jour après l’expérimentation ;\n4. Méthodologie\n- Exposé court sur la théorie générale relative à la matière ;\n- Échanges pratiques, réception du feed-back des apprenants et Exposés des projets par les\napprenants ;\n- Descente pour expérimentation.\n5. Lieu et durée :\nGoma Pendant 2 semaines', 'la politique', 'notre condition', '1719320544.jpg', 'https://web.facebook.com/Dream-of-drc-114107447382924', 'https://www.linkedin.com/in/dream-of-drc-startup-872765217/', 'https://twitter.com/drc_dream', 'https://youtube.com/', '2022-01-29 13:53:28', '2024-06-25 11:03:00');

-- --------------------------------------------------------

--
-- Structure de la table `sou_service_entreps`
--

DROP TABLE IF EXISTS `sou_service_entreps`;
CREATE TABLE IF NOT EXISTS `sou_service_entreps` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_service` int(11) NOT NULL,
  `nom` varchar(450) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix` varchar(450) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sou_service_entreps`
--

INSERT INTO `sou_service_entreps` (`id`, `id_service`, `nom`, `titre`, `description`, `photo`, `prix`, `created_at`, `updated_at`) VALUES
(1, 1, 'Opération interne', 'Opération interne', '&lt;p&gt;Opération interne description&lt;/p&gt;', '1669621801.jpg', '2à', '2022-11-28 06:50:01', '2022-11-28 06:50:01'),
(2, 1, 'Sous services 2', 'Sous services 2', '&lt;p&gt;A un moment où personne ne s’y attend, le marketing digital devient de plus en plus une clé indispensable pour le succès des entreprises. Aujourd’hui, l’internet prend une grande partie de préoccupations dans la vie des humains, il devient d’ailleurs une partie des humains. Ce qui explique la simplicité de la communication et rend indispensable la numérisation des processus de communication pour atteindre un nombre suffisant des personnes selon la cible de l’entreprise.&lt;/p&gt;', '1669669354.webp', '50', '2022-11-28 20:02:34', '2022-11-28 20:02:34'),
(3, 1, 'Sous service 3', 'Sous service 3', '&lt;p&gt;La plupart des gens diraient que les grandes entreprises l’ont fait et ont réussi et y tireraient des préjugés pour mettre des obstacles devant leur propre détermination ;&amp;nbsp;Pourtant, selon l’expérience, nous sommes convaincus qu\'il y aura toujours une place spéciale pour les petites startups dans les affaires.&amp;nbsp;Les jeunes entrepreneurs ont un avantage sur leurs plus gros concurrents.&amp;nbsp;Ainsi, alors que les grandes sociétés du monde ont du mal à atteindre le seuil de leurs frais généraux de plusieurs milliards de dollars, les plus petites startups se servant du marketing digital réalisent déjà des bénéfices.&amp;nbsp;Quels avantages ces jeunes startups ont-elles sur le marché ?&amp;nbsp;&lt;/p&gt;', '1669669398.png', '40', '2022-11-28 20:03:18', '2022-11-28 20:03:18');

-- --------------------------------------------------------

--
-- Structure de la table `swots`
--

DROP TABLE IF EXISTS `swots`;
CREATE TABLE IF NOT EXISTS `swots` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ceo` int(11) NOT NULL,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `swots`
--

INSERT INTO `swots` (`id`, `ceo`, `titre`, `message`, `created_at`, `updated_at`) VALUES
(1, 6, 'Forces', 'force 1', '2022-06-11 13:31:11', '2022-06-11 13:31:11'),
(2, 6, 'Forces', 'force 2', '2022-06-11 13:31:24', '2022-06-11 13:31:24'),
(3, 6, 'Faiblesses', 'Faiblesse 1', '2022-06-11 13:31:43', '2022-06-11 13:31:43'),
(4, 6, 'Faiblesses', 'Faiblesse 2', '2022-06-11 13:31:53', '2022-06-11 13:31:53'),
(5, 6, 'Faiblesses', 'Faiblesse 3', '2022-06-11 13:32:03', '2022-06-11 13:32:03'),
(6, 6, 'Opportunités', 'Opportunité 1', '2022-06-11 13:32:30', '2022-06-11 13:32:30'),
(7, 6, 'Opportunités', 'Opportunité 2', '2022-06-11 13:32:41', '2022-06-11 13:32:41'),
(8, 6, 'Opportunités', 'Opportunité 3', '2022-06-11 13:32:51', '2022-06-11 13:32:51'),
(9, 6, 'Menaces', 'Menace 1', '2022-06-11 13:33:15', '2022-06-11 13:33:15'),
(10, 6, 'Menaces', 'Menace 2', '2022-06-11 13:33:25', '2022-06-11 13:33:25'),
(11, 6, 'Menaces', 'Menace 3', '2022-06-11 13:33:35', '2022-06-11 13:33:35'),
(12, 6, 'Menaces', 'Menace 4', '2022-06-11 13:33:45', '2022-06-11 13:33:45'),
(13, 1, 'Forces', 'force 1', '2022-06-16 19:32:26', '2022-06-16 19:32:26'),
(14, 1, 'Forces', 'force 2', '2022-06-16 19:32:34', '2022-06-16 19:32:34'),
(15, 1, 'Faiblesses', 'faiblesse', '2022-06-16 19:32:48', '2022-06-16 19:32:48'),
(16, 1, 'Opportunités', 'opportunité', '2022-06-16 19:33:03', '2022-06-16 19:33:03'),
(17, 1, 'Menaces', 'menace 1', '2022-06-16 19:33:20', '2022-06-16 19:33:33');

-- --------------------------------------------------------

--
-- Structure de la table `swot_deuxes`
--

DROP TABLE IF EXISTS `swot_deuxes`;
CREATE TABLE IF NOT EXISTS `swot_deuxes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_coach` int(11) NOT NULL,
  `ceo` int(11) NOT NULL,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `swot_deuxes`
--

INSERT INTO `swot_deuxes` (`id`, `id_coach`, `ceo`, `titre`, `message`, `created_at`, `updated_at`) VALUES
(1, 4, 6, 'Forces', 'SWOT analysis (or SWOT matrix) is a strategic planning technique used to help a person or organization identify strengths, weaknesses, opportunities, ...', '2022-06-11 15:54:12', '2022-06-11 17:13:20'),
(4, 4, 6, 'Opportunités', 'correction opportunité', '2022-06-11 15:55:00', '2022-06-11 15:55:00'),
(10, 4, 6, 'Menaces', 'correction menace', '2022-06-11 15:56:16', '2022-06-11 17:12:11'),
(11, 4, 6, 'Faiblesses', 'Faiblesse 13434334', '2022-06-11 17:11:41', '2022-06-11 17:11:55'),
(12, 4, 6, 'Faiblesses', 'swot · GitHub Topicshttps://github.com › topics › swot\nTraduire cette page\nSWOT analysis (or SWOT matrix) is a strategic planning technique used to help a person or organization identify strengths, weaknesses, opportunities, and ...', '2022-06-11 17:39:16', '2022-06-11 17:39:16'),
(13, 4, 6, 'Faiblesses', 'Conducting a SWOT Analysis. Based on the situation analysis, organizations analyze their strengths, weaknesses, opportunities, and threats, or conduct what\'s ...', '2022-06-11 17:40:01', '2022-06-11 17:40:01'),
(14, 4, 6, 'Forces', 'Comprehend the relationships among business, corporate, and international strategy. Know the inputs into a SWOT analysis.', '2022-06-11 17:51:06', '2022-06-11 17:51:06'),
(15, 4, 6, 'Opportunités', 'fullstack web developer. hardworking student developer at isig goma', '2022-06-11 17:51:38', '2022-06-11 17:51:38'),
(16, 4, 6, 'Menaces', 'First, GitHub has more than eight hundred permanent employees. GitHub developers are generally tasked with the development and maintenance of certain projects ...', '2022-06-11 17:52:19', '2022-06-11 17:52:19');

-- --------------------------------------------------------

--
-- Structure de la table `tagent`
--

DROP TABLE IF EXISTS `tagent`;
CREATE TABLE IF NOT EXISTS `tagent` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `matricule_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noms_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datenaissance_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lieunaissnce_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinceOrigine_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etatcivil_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refAvenue_agent` bigint(20) UNSIGNED NOT NULL,
  `nummaison_agent` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '000',
  `contact_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fonction_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialite_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Categorie_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `niveauEtude_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anneeFinEtude_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Ecole_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conjoint_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomPere_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomMere_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Nationalite_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Collectivite_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Territoire_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EmployeurAnt_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PersRef_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cartes` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `envie` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tagent_refavenue_agent_foreign` (`refAvenue_agent`)
) ENGINE=MyISAM AUTO_INCREMENT=254 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tagent`
--

INSERT INTO `tagent` (`id`, `matricule_agent`, `noms_agent`, `sexe_agent`, `datenaissance_agent`, `lieunaissnce_agent`, `provinceOrigine_agent`, `etatcivil_agent`, `refAvenue_agent`, `nummaison_agent`, `contact_agent`, `mail_agent`, `grade_agent`, `fonction_agent`, `specialite_agent`, `Categorie_agent`, `niveauEtude_agent`, `anneeFinEtude_agent`, `Ecole_agent`, `conjoint_agent`, `nomPere_agent`, `nomMere_agent`, `Nationalite_agent`, `Collectivite_agent`, `Territoire_agent`, `EmployeurAnt_agent`, `PersRef_agent`, `photo`, `slug`, `cartes`, `envie`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, '00000000000000000005', 'RWANIKA ARAMEE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2026-05-24 12:58:00', '2010-09-24 02:31:00'),
(2, '00000000000000000006', 'YAMWENZIYO EDDY', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'NON', 'OUI', 'admin', 'NON', 'admin', '2026-06-24 05:58:00', '2016-09-24 05:56:00'),
(3, '00000000000000000007', 'RAYMOND IDUMBO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'NON', 'OUI', 'admin', 'NON', 'admin', '2004-07-24 08:53:00', '2016-09-24 05:56:00'),
(4, '00000000000000000008', 'ASSOUMPTA KAMANZI', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2005-07-24 08:53:00', '2017-09-24 05:56:00'),
(5, '00000000000000000009', 'KAVUO WEMA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2006-07-24 08:53:00', '2018-09-24 05:56:00'),
(6, '00000000000000000010', 'AKONKWA CIMANUKA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2007-07-24 08:53:00', '2019-09-24 05:56:00'),
(7, '00000000000000000011', 'DEODATUS MIHIGO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2008-07-24 08:53:00', '2020-09-24 05:56:00'),
(8, '00000000000000000012', 'HELENE LIMBO', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2009-07-24 08:53:00', '2021-09-24 05:56:00'),
(9, '00000000000000000013', 'SEMAYIRA IMELDA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2010-07-24 08:53:00', '2022-09-24 05:56:00'),
(10, '00000000000000000014', 'ATIBAGUE MYRIAM', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2011-07-24 08:53:00', '2023-09-24 05:56:00'),
(11, '00000000000000000015', 'DHEGO GILBERT', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2012-07-24 08:53:00', '2024-09-24 05:56:00'),
(12, '00000000000000000016', 'INGABIRE YVETTE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2013-07-24 08:53:00', '2025-09-24 05:56:00'),
(13, '00000000000000000017', 'CIVUGO RAYMONDE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2014-07-24 08:53:00', '2026-09-24 05:56:00'),
(14, '00000000000000000018', 'KENDAKENDA CLAUDINE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2015-07-24 08:53:00', '2027-09-24 05:56:00'),
(15, '00000000000000000019', 'BAVANGE JEAN-CLAUDE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2016-07-24 08:53:00', '2028-09-24 05:56:00'),
(16, '00000000000000000020', 'IGNACE RUNANGU', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2017-07-24 08:53:00', '2029-09-24 05:56:00'),
(17, '00000000000000000021', 'SIFA FRANCINE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2018-07-24 08:53:00', '2030-09-24 05:56:00'),
(18, '00000000000000000022', 'SIFA ROMAINE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2019-07-24 08:53:00', '2001-10-24 05:56:00'),
(19, '00000000000000000023', 'SIFA CHRISTINE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2020-07-24 08:53:00', '2002-10-24 05:56:00'),
(20, '00000000000000000024', 'MARCELINE NKUMBU', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2021-07-24 08:53:00', '2003-10-24 05:56:00'),
(21, '00000000000000000025', 'BETTY KATUNGU', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2022-07-24 08:53:00', '2004-10-24 05:56:00'),
(22, '00000000000000000026', 'LAURENT BENGEHYA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2023-07-24 08:53:00', '2005-10-24 05:56:00'),
(23, '00000000000000000027', 'NAKALIO JULIETTE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2024-07-24 08:53:00', '2006-10-24 05:56:00'),
(24, '00000000000000000028', 'KABUYRE JEAN DE DIEU', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2025-07-24 08:53:00', '2007-10-24 05:56:00'),
(25, '00000000000000000029', 'IZABAYO JEAN-CLAUDE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2026-07-24 08:53:00', '2008-10-24 05:56:00'),
(26, '00000000000000000030', 'MUKOSA REGINE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2027-07-24 08:53:00', '2009-10-24 05:56:00'),
(27, '00000000000000000031', 'DUSHIME ISAAC', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2028-07-24 08:53:00', '2010-10-24 05:56:00'),
(28, '00000000000000000032', 'MUSHAMUKA RENE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2029-07-24 08:53:00', '2011-10-24 05:56:00'),
(29, '00000000000000000033', 'KAHAMBU KITEKOMUNDU', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2030-07-24 08:53:00', '2012-10-24 05:56:00'),
(30, '00000000000000000034', 'MAISHA ZIMULINDA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2031-07-24 08:53:00', '2013-10-24 05:56:00'),
(31, '00000000000000000035', 'KAMBALE KATSONGO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2001-08-24 08:53:00', '2014-10-24 05:56:00'),
(32, '00000000000000000036', 'KITI MUJINYA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2002-08-24 08:53:00', '2015-10-24 05:56:00'),
(33, '00000000000000000037', 'MUHINDO KASUNGANO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2003-08-24 08:53:00', '2016-10-24 05:56:00'),
(34, '00000000000000000038', 'KAMBALE KASIKA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2004-08-24 08:53:00', '2017-10-24 05:56:00'),
(35, '00000000000000000039', 'PALUKU KISABWE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2005-08-24 08:53:00', '2018-10-24 05:56:00'),
(36, '00000000000000000040', 'KAMALA DEODATTA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2006-08-24 08:53:00', '2019-10-24 05:56:00'),
(37, '00000000000000000041', 'ANTOINNETTE HANGI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2007-08-24 08:53:00', '2020-10-24 05:56:00'),
(38, '00000000000000000042', 'YVONNE BAMBANZE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2008-08-24 08:53:00', '2021-10-24 05:56:00'),
(39, '00000000000000000043', 'MARIE DESANGES', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2009-08-24 08:53:00', '2022-10-24 05:56:00'),
(40, '00000000000000000044', 'KAKULE ALBERT', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2010-08-24 08:53:00', '2023-10-24 05:56:00'),
(41, '00000000000000000045', 'ZIGABE EMMANUEL', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2011-08-24 08:53:00', '2024-10-24 05:56:00'),
(42, '00000000000000000046', 'KAHINDO BERNADETTE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2012-08-24 08:53:00', '2025-10-24 05:56:00'),
(43, '00000000000000000048', 'LUC KIKANDI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2013-08-24 08:53:00', '2026-10-24 05:56:00'),
(44, '00000000000000000049', 'ZABURI KAVIRA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2014-08-24 08:53:00', '2027-10-24 05:56:00'),
(45, '00000000000000000050', 'JEAN BOSCO KOKOSE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2015-08-24 08:53:00', '2028-10-24 05:56:00'),
(46, '00000000000000000051', 'BANGIRAHE LOUIS', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2016-08-24 08:53:00', '2029-10-24 05:56:00'),
(47, '00000000000000000052', 'AKILIMALI JUAKALI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2017-08-24 08:53:00', '2030-10-24 05:56:00'),
(48, '00000000000000000053', 'NGUMBI KITABANGA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2018-08-24 08:53:00', '2031-10-24 05:56:00'),
(49, '00000000000000000054', 'Sr MANDROSI LOMBOSI', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2019-08-24 08:53:00', '2001-11-24 06:56:00'),
(50, '00000000000000000055', 'DEOGRATIAS NSENGIMANA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2020-08-24 08:53:00', '2002-11-24 06:56:00'),
(51, '00000000000000000056', 'BALINGENE KIOTHA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2021-08-24 08:53:00', '2003-11-24 06:56:00'),
(52, '00000000000000000057', 'KAVUGHO MULINDA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2022-08-24 08:53:00', '2004-11-24 06:56:00'),
(53, '00000000000000000059', 'BUKE ANGELE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2023-08-24 08:53:00', '2005-11-24 06:56:00'),
(54, '00000000000000000060', 'LYDIE WARIDI KONE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2024-08-24 08:53:00', '2006-11-24 06:56:00'),
(55, '00000000000000000061', 'KIBANDJA MISHIKI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2025-08-24 08:53:00', '2007-11-24 06:56:00'),
(56, '00000000000000000062', 'CLAUDE KAMBALE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2026-08-24 08:53:00', '2008-11-24 06:56:00'),
(57, '00000000000000000063', 'TRESOR DUNIA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2027-08-24 08:53:00', '2009-11-24 06:56:00'),
(58, '00000000000000000064', 'CHRISTOPHE CIMANUKA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2028-08-24 08:53:00', '2010-11-24 06:56:00'),
(59, '00000000000000000065', 'MALASI BUSHUANDA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2029-08-24 08:53:00', '2011-11-24 06:56:00'),
(60, '00000000000000000066', 'ZENA KAMBERE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2030-08-24 08:53:00', '2012-11-24 06:56:00'),
(61, '00000000000000000067', 'AYISI CHRISTINE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2031-08-24 08:53:00', '2013-11-24 06:56:00'),
(62, '00000000000000000068', 'NICOLE BINOMBE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2001-09-24 08:53:00', '2014-11-24 06:56:00'),
(63, '00000000000000000069', 'LUSAMBA MILOLO', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2002-09-24 08:53:00', '2015-11-24 06:56:00'),
(64, '00000000000000000070', 'KALIVANDA KATUNGU', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2003-09-24 08:53:00', '2016-11-24 06:56:00'),
(65, '00000000000000000071', 'NUSULA TWAHA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2004-09-24 08:53:00', '2017-11-24 06:56:00'),
(66, '00000000000000000072', 'SAFINA JUSTINE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2005-09-24 08:53:00', '2018-11-24 06:56:00'),
(67, '00000000000000000073', 'MPENZI MPALA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2006-09-24 08:53:00', '2019-11-24 06:56:00'),
(68, '00000000000000000074', 'BAABO KANANE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2007-09-24 08:53:00', '2020-11-24 06:56:00'),
(69, '00000000000000000075', 'IDI BANDU', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2008-09-24 08:53:00', '2021-11-24 06:56:00'),
(70, '00000000000000000076', 'OWANDJI OMANA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2009-09-24 08:53:00', '2022-11-24 06:56:00'),
(71, '00000000000000000077', 'SABIN MUSUBAO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2010-09-24 08:53:00', '2023-11-24 06:56:00'),
(72, '00000000000000000078', 'MUSAFIRI SADIKI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2011-09-24 08:53:00', '2024-11-24 06:56:00'),
(73, '00000000000000000079', 'Sr MARIE_CHANTAL', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2012-09-24 08:53:00', '2025-11-24 06:56:00'),
(74, '00000000000000000080', 'ARSENE KISANGANI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2013-09-24 08:53:00', '2026-11-24 06:56:00'),
(75, '00000000000000000083', 'NYAMAMBICHI KIKA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2014-09-24 08:53:00', '2027-11-24 06:56:00'),
(76, '00000000000000000084', 'ELIE TUSIKILIZANE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2015-09-24 08:53:00', '2028-11-24 06:56:00'),
(77, '00000000000000000085', 'BASILE BASHIMBE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2016-09-24 08:53:00', '2029-11-24 06:56:00'),
(78, '00000000000000000086', 'JOSIAS MUISHA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2017-09-24 08:53:00', '2030-11-24 06:56:00'),
(79, '00000000000000000087', 'JOEL SAFARI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2018-09-24 08:53:00', '2001-12-24 06:56:00'),
(80, '00000000000000000088', 'FERDINAND LUENDO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2019-09-24 08:53:00', '2002-12-24 06:56:00'),
(81, '00000000000000000089', 'KANAMUGIRE VIANNEY', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2020-09-24 08:53:00', '2003-12-24 06:56:00'),
(82, '00000000000000000090', 'BIENVENU MOLO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2021-09-24 08:53:00', '2004-12-24 06:56:00'),
(83, '00000000000000000091', 'RICHARD KABUYRE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2022-09-24 08:53:00', '2005-12-24 06:56:00'),
(84, '00000000000000000092', 'KULIMUSHI KANINGU', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2023-09-24 08:53:00', '2006-12-24 06:56:00'),
(85, '00000000000000000093', 'MUPENZI KITALYABOSHI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2024-09-24 08:53:00', '2007-12-24 06:56:00'),
(86, '00000000000000000094', 'FRANCISCA ICHIMPAYE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2025-09-24 08:53:00', '2008-12-24 06:56:00'),
(87, '00000000000000000095', 'MATUMO KAYENGA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2026-09-24 08:53:00', '2009-12-24 06:56:00'),
(88, '00000000000000000096', 'FURAHA YAMANSHO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2027-09-24 08:53:00', '2010-12-24 06:56:00'),
(89, '00000000000000000097', 'BAHATI SHANDWE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2028-09-24 08:53:00', '2011-12-24 06:56:00'),
(90, '00000000000000000098', 'SAMUEL KABIONA SAUEL', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2029-09-24 08:53:00', '2012-12-24 06:56:00'),
(91, '00000000000000000099', 'Abbé BAHATI RUBAMBIZA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2030-09-24 08:53:00', '2013-12-24 06:56:00'),
(92, '00000000000000000100', 'CLAUDINE KAFIRONGO', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2001-10-24 08:53:00', '2014-12-24 06:56:00'),
(93, '00000000000000000101', 'DUSHIME SHIRAKERA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2002-10-24 08:53:00', '2015-12-24 06:56:00'),
(94, '00000000000000000102', 'DENOE KAYIHURA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2003-10-24 08:53:00', '2016-12-24 06:56:00'),
(95, '00000000000000000103', 'AMANI BAKULIKIRA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2004-10-24 08:53:00', '2017-12-24 06:56:00'),
(96, '00000000000000000104', 'Dr MIHANDA ETIENNE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2005-10-24 08:53:00', '2018-12-24 06:56:00'),
(97, '00000000000000000105', 'MAGUY MALAGANO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2006-10-24 08:53:00', '2019-12-24 06:56:00'),
(98, '00000000000000000106', 'NABY NASIBU', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2007-10-24 08:53:00', '2020-12-24 06:56:00'),
(99, '00000000000000000107', 'NKINGA GABRIEL', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2008-10-24 08:53:00', '2021-12-24 06:56:00'),
(100, '00000000000000000108', 'PASCAL BASHUME', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2009-10-24 08:53:00', '2022-12-24 06:56:00'),
(101, '00000000000000000109', 'SAIDI GASTON', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2010-10-24 08:53:00', '2023-12-24 06:56:00'),
(102, '00000000000000000110', 'LIKOKO PLACIDE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2011-10-24 08:53:00', '2024-12-24 06:56:00'),
(103, '00000000000000000111', 'JEANNOT KASSA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2012-10-24 08:53:00', '2025-12-24 06:56:00'),
(104, '00000000000000000113', 'EUGNE GASHABUKA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2013-10-24 08:53:00', '2026-12-24 06:56:00'),
(105, '00000000000000000114', 'JEAN-CLAUDE KARUME', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2014-10-24 08:53:00', '2027-12-24 06:56:00'),
(106, '00000000000000000115', 'MARTINE KALIZA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2015-10-24 08:53:00', '2028-12-24 06:56:00'),
(107, '00000000000000000116', 'CHIMENE MWANAWEKA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2016-10-24 08:53:00', '2029-12-24 06:56:00'),
(108, '00000000000000000117', 'FIRMIN NTIRIKWENDERA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2017-10-24 08:53:00', '2030-12-24 06:56:00'),
(109, '00000000000000000118', 'DAVID MUKISA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2018-10-24 08:53:00', '2031-12-24 06:56:00'),
(110, '00000000000000000119', 'EUGENE MWANGAZA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2019-10-24 08:53:00', '2001-01-25 06:56:00'),
(111, '00000000000000000120', 'OLEMBE MUSANGI', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2020-10-24 08:53:00', '2002-01-25 06:56:00'),
(112, '00000000000000000121', 'TUMAINI BONANE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2021-10-24 08:53:00', '2003-01-25 06:56:00'),
(113, '00000000000000000122', 'ZISHEBA RAYMOND', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2022-10-24 08:53:00', '2004-01-25 06:56:00'),
(114, '00000000000000000123', 'BAHATI DHESSA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2023-10-24 08:53:00', '2005-01-25 06:56:00'),
(115, '00000000000000000124', 'MAOMBI SENGA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2024-10-24 08:53:00', '2006-01-25 06:56:00'),
(116, '00000000000000000125', 'AMANI RENATE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2025-10-24 08:53:00', '2007-01-25 06:56:00'),
(117, '00000000000000000126', 'KATEMBO MICHEL', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2026-10-24 08:53:00', '2008-01-25 06:56:00'),
(118, '00000000000000000127', 'KASEREKA KASAKIRWA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2027-10-24 08:53:00', '2009-01-25 06:56:00'),
(119, '00000000000000000128', 'GRACE MAKASI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2028-10-24 08:53:00', '2010-01-25 06:56:00'),
(120, '00000000000000000129', 'BATENCHI AUGUSTIN', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2029-10-24 08:53:00', '2011-01-25 06:56:00'),
(121, '00000000000000000131', 'MATEMANE LOUIS', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2030-10-24 08:53:00', '2012-01-25 06:56:00'),
(122, '00000000000000000132', 'PRINCE IRENGE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2031-10-24 08:53:00', '2013-01-25 06:56:00'),
(123, '00000000000000000133', 'IDUMBO MUKUCHA ARSENE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2001-11-24 09:53:00', '2014-01-25 06:56:00'),
(124, '00000000000000000134', 'KAKWISHA BIGOGO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2002-11-24 09:53:00', '2015-01-25 06:56:00'),
(125, '00000000000000000135', 'BYAMUNGU KAGENZI', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2003-11-24 09:53:00', '2016-01-25 06:56:00'),
(126, '00000000000000000137', 'Abbé TOUSSAINT SERUTOKE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2004-11-24 09:53:00', '2017-01-25 06:56:00'),
(127, '00000000000000000138', 'Sr MARIE JEANNE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2005-11-24 09:53:00', '2018-01-25 06:56:00'),
(128, '00000000000000000139', 'RUGAMIKA BINJA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2006-11-24 09:53:00', '2019-01-25 06:56:00'),
(129, '00000000000000000140', 'NGOMWEGI UYERA RACHEL', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2007-11-24 09:53:00', '2020-01-25 06:56:00'),
(130, '00000000000000000141', 'CHRYSOSTOME RENZAHO', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2008-11-24 09:53:00', '2021-01-25 06:56:00'),
(131, '00000000000000000142', 'PIERRE KAMUMBELE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2009-11-24 09:53:00', '2022-01-25 06:56:00'),
(132, '00000000000000000144', 'NTSII CHRISTINE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2010-11-24 09:53:00', '2023-01-25 06:56:00'),
(133, '00000000000000000145', 'BIENVENU ASSANI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2011-11-24 09:53:00', '2024-01-25 06:56:00'),
(134, '00000000000000000146', 'SEBAGENZI NOELLA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2012-11-24 09:53:00', '2025-01-25 06:56:00'),
(135, '00000000000000000147', 'DORCAS NDEZE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2013-11-24 09:53:00', '2026-01-25 06:56:00'),
(136, '00000000000000000148', 'EMMANUEL RWANGANO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2014-11-24 09:53:00', '2027-01-25 06:56:00'),
(137, '00000000000000000149', 'USHINDI SEBUKOZO ALLIANCE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2015-11-24 09:53:00', '2028-01-25 06:56:00'),
(138, '00000000000000000150', 'KAVUGHO VUTHANA NAYLLAN', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2016-11-24 09:53:00', '2029-01-25 06:56:00'),
(139, '00000000000000000151', 'HABINEZA GATSAMA MARIE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2017-11-24 09:53:00', '2030-01-25 06:56:00'),
(140, '00000000000000000152', 'KABUO NGOWIRE MERVEILLE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2018-11-24 09:53:00', '2031-01-25 06:56:00'),
(141, '00000000000000000153', 'JACQUES KIBERITI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2019-11-24 09:53:00', '2001-02-25 06:56:00'),
(142, '00000000000000000154', 'LAPINO LUHAVO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2020-11-24 09:53:00', '2002-02-25 06:56:00'),
(143, '00000000000000000155', 'KISHABAGA MWENGE CHRISTIAN', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2021-11-24 09:53:00', '2003-02-25 06:56:00'),
(144, '00000000000000000156', 'MANIRAKIZA FABIEN', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2022-11-24 09:53:00', '2004-02-25 06:56:00'),
(145, '00000000000000000157', 'KAMBALE MUSAMBALI JUSTIN', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2023-11-24 09:53:00', '2005-02-25 06:56:00'),
(146, '00000000000000000158', 'MUSUBAO ERIC', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2024-11-24 09:53:00', '2006-02-25 06:56:00'),
(147, '00000000000000000159', 'KIROHA MWIZA YVETTE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2025-11-24 09:53:00', '2007-02-25 06:56:00'),
(148, '00000000000000000160', 'ZIRIBUGIRE HABAMUNGU', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2026-11-24 09:53:00', '2008-02-25 06:56:00'),
(149, '00000000000000000161', 'JEAN DAMASCENE MATUMAINI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2027-11-24 09:53:00', '2009-02-25 06:56:00'),
(150, '00000000000000000162', 'MUTSUVA MASOMEKO ERIC', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2028-11-24 09:53:00', '2010-02-25 06:56:00'),
(151, '00000000000000000163', 'KWABENE MILENGE DIDIER', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2029-11-24 09:53:00', '2011-02-25 06:56:00'),
(152, '00000000000000000164', 'OMER DJUMA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2030-11-24 09:53:00', '2012-02-25 06:56:00'),
(153, '00000000000000000165', 'JOSEPHINE MASIKA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2001-12-24 09:53:00', '2013-02-25 06:56:00'),
(154, '00000000000000000166', 'NYOTA LUKOO NONO', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2002-12-24 09:53:00', '2014-02-25 06:56:00'),
(155, '00000000000000000167', 'NICOLE KAVIRA', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2003-12-24 09:53:00', '2015-02-25 06:56:00'),
(156, '00000000000000000168', 'FAVRE KABONGO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2004-12-24 09:53:00', '2016-02-25 06:56:00'),
(157, '00000000000000000169', 'FLEURCY HANGI', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2005-12-24 09:53:00', '2017-02-25 06:56:00'),
(158, '00000000000000000170', 'SOLANGE KIGANI', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2006-12-24 09:53:00', '2018-02-25 06:56:00'),
(159, '00000000000000000171', 'SIFA SIBOMANA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2007-12-24 09:53:00', '2019-02-25 06:56:00'),
(160, '00000000000000000172', 'MATENGA ISSA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2008-12-24 09:53:00', '2020-02-25 06:56:00'),
(161, '00000000000000000173', 'ALPHA PALUKU', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2009-12-24 09:53:00', '2021-02-25 06:56:00'),
(162, '00000000000000000174', 'UMWAMI JULIENNE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2010-12-24 09:53:00', '2022-02-25 06:56:00'),
(163, '00000000000000000175', 'AJUAMUNGU BIRITSENE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2011-12-24 09:53:00', '2023-02-25 06:56:00');
INSERT INTO `tagent` (`id`, `matricule_agent`, `noms_agent`, `sexe_agent`, `datenaissance_agent`, `lieunaissnce_agent`, `provinceOrigine_agent`, `etatcivil_agent`, `refAvenue_agent`, `nummaison_agent`, `contact_agent`, `mail_agent`, `grade_agent`, `fonction_agent`, `specialite_agent`, `Categorie_agent`, `niveauEtude_agent`, `anneeFinEtude_agent`, `Ecole_agent`, `conjoint_agent`, `nomPere_agent`, `nomMere_agent`, `Nationalite_agent`, `Collectivite_agent`, `Territoire_agent`, `EmployeurAnt_agent`, `PersRef_agent`, `photo`, `slug`, `cartes`, `envie`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(164, '00000000000000000176', 'MAKABE BUUNDA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2012-12-24 09:53:00', '2024-02-25 06:56:00'),
(165, '00000000000000000177', 'POKEA SOLANGE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2013-12-24 09:53:00', '2025-02-25 06:56:00'),
(166, '00000000000000000178', 'HORTANCE BANDU', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2014-12-24 09:53:00', '2026-02-25 06:56:00'),
(167, '00000000000000000179', 'SERUHUNGO GONZAGUE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2015-12-24 09:53:00', '2027-02-25 06:56:00'),
(168, '00000000000000000180', 'PENDEKI BAHATI', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2016-12-24 09:53:00', '2028-02-25 06:56:00'),
(169, '00000000000000000181', 'YVETTE FUNI', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2017-12-24 09:53:00', '2001-03-25 05:56:00'),
(170, '00000000000000000182', 'STEVE LUBALA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2018-12-24 09:53:00', '2002-03-25 06:56:00'),
(171, '00000000000000000183', 'LAGUY MASTAKI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2019-12-24 09:53:00', '2003-03-25 06:56:00'),
(172, '00000000000000000184', 'BIRINDWA JERRY', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2020-12-24 09:53:00', '2004-03-25 06:56:00'),
(173, '00000000000000000185', 'KIKANDI APOLINE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2021-12-24 09:53:00', '2005-03-25 06:56:00'),
(174, '00000000000000000186', 'FLAVIEN KYAHI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2022-12-24 09:53:00', '2006-03-25 06:56:00'),
(175, '00000000000000000187', 'MBUSA SYAKOLERA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2023-12-24 09:53:00', '2007-03-25 05:56:00'),
(176, '00000000000000000188', 'SHADRACK KOMBI', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2024-12-24 09:53:00', '2008-03-25 06:56:00'),
(177, '00000000000000000189', 'NDUHIRAHE SERAPHIN', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2025-12-24 09:53:00', '2009-03-25 06:56:00'),
(178, '00000000000000000190', 'MBAYU CRISPIN', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2026-12-24 09:53:00', '2010-03-25 06:56:00'),
(179, '00000000000000000191', 'SHEMATSI GLOIRE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2027-12-24 09:53:00', '2011-03-25 06:56:00'),
(180, '00000000000000000192', 'AMULI MICHEL', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2028-12-24 09:53:00', '2012-03-25 05:56:00'),
(181, '00000000000000000193', 'HAKIZUWERA BONTANYI', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2029-12-24 09:53:00', '2013-03-25 06:56:00'),
(182, '00000000000000000194', 'JANVIER BAENI', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2030-12-24 09:53:00', '2014-03-25 06:56:00'),
(183, '00000000000000000195', 'ANSIMA JULIENNE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2031-12-24 09:53:00', '2015-03-25 06:56:00'),
(184, '00000000000000000196', 'KOMBI FLORIBERT', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2001-01-25 09:53:00', '2016-03-25 06:56:00'),
(185, '00000000000000000197', 'IRENGE FLORENTIN', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2002-01-25 09:53:00', '2017-03-25 06:56:00'),
(186, '00000000000000000198', 'LEONZE LEDU', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2003-01-25 09:53:00', '2018-03-25 05:56:00'),
(187, '00000000000000000199', 'URAYENEZA BAHATI', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2004-01-25 09:53:00', '2019-03-25 06:56:00'),
(188, '00000000000000000200', 'IRANZI DIDIER', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2005-01-25 09:53:00', '2020-03-25 06:56:00'),
(189, '00000000000000000201', 'MUVINGI DIEUME', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2006-01-25 09:53:00', '2021-03-25 06:56:00'),
(190, '00000000000000000202', 'BUINGO MWANGA', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2007-01-25 09:53:00', '2022-03-25 06:56:00'),
(191, '00000000000000000203', 'SERUTOKE MARIE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2008-01-25 09:53:00', '2023-03-25 06:56:00'),
(192, '00000000000000000204', 'KITIKIRA MWISHA', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2009-01-25 09:53:00', '2024-03-25 06:56:00'),
(193, '00000000000000000205', 'JEMIMA MUNGERE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2010-01-25 09:53:00', '2025-03-25 06:56:00'),
(194, '00000000000000000206', 'CLAUDINE KENDAKENDA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2011-01-25 09:53:00', '2026-03-25 06:56:00'),
(195, '00000000000000000207', 'LUTALA MBALULA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2012-01-25 09:53:00', '2027-03-25 06:56:00'),
(196, '00000000000000000208', 'MUTHEOSY ALINE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2013-01-25 09:53:00', '2028-03-25 06:56:00'),
(197, '00000000000000000209', 'LONGONGA STANISLAS', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2014-01-25 09:53:00', '2029-03-25 05:56:00'),
(198, '00000000000000000210', 'NGWASI AIMERANCE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2015-01-25 09:53:00', '2030-03-25 06:56:00'),
(199, '00000000000000000211', 'CHRISTOPHE RUBAKARE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2016-01-25 09:53:00', '2031-03-25 06:56:00'),
(200, '00000000000000000212', 'KAPALATA SEMIVUMBI', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2017-01-25 09:53:00', '2001-04-25 05:56:00'),
(201, '00000000000000000213', 'ABDOUL KARIM', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2018-01-25 09:53:00', '2002-04-25 05:56:00'),
(202, '00000000000000000214', 'NIYIBIZI HONORE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2019-01-25 09:53:00', '2003-04-25 05:56:00'),
(203, '00000000000000000215', 'JULES MUHIMA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2020-01-25 09:53:00', '2004-04-25 05:56:00'),
(204, '00000000000000000216', 'JP SILIMI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2021-01-25 09:53:00', '2005-04-25 05:56:00'),
(205, '00000000000000000218', 'EDWIGE KOMBI', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2022-01-25 09:53:00', '2006-04-25 05:56:00'),
(206, '00000000000000000219', 'CHANCY CHIMANA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2023-01-25 09:53:00', '2007-04-25 05:56:00'),
(207, '00000000000000000220', 'FAIDA MUHIMA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2024-01-25 09:53:00', '2008-04-25 05:56:00'),
(208, '00000000000000000221', 'FEZA SCOLASTIQUE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2025-01-25 09:53:00', '2009-04-25 05:56:00'),
(209, '00000000000000000222', 'JUVENAL NZABANITA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2026-01-25 09:53:00', '2010-04-25 05:56:00'),
(210, '00000000000000000223', 'YANNICK LUKONGE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2027-01-25 09:53:00', '2011-04-25 05:56:00'),
(211, '00000000000000000224', 'BAHATI MUNIDO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2028-01-25 09:53:00', '2012-04-25 05:56:00'),
(212, '00000000000000000225', 'KABOLO LUCIEN', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2029-01-25 09:53:00', '2013-04-25 05:56:00'),
(213, '00000000000000000226', 'RUBUGA DIEUDONNE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2030-01-25 09:53:00', '2014-04-25 05:56:00'),
(214, '00000000000000000227', 'BERNADETTE KAHINDO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2031-01-25 09:53:00', '2015-04-25 05:56:00'),
(215, '00000000000000000228', 'LILIANE YUMULA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2001-02-25 09:53:00', '2016-04-25 05:56:00'),
(216, '00000000000000000229', 'FEZA MESHE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2002-02-25 09:53:00', '2017-04-25 05:56:00'),
(217, '00000000000000000230', 'FAUSTIN MUNGUIKO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2003-02-25 09:53:00', '2018-04-25 05:56:00'),
(218, '00000000000000000231', 'AUGUSTIN KAMALA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2004-02-25 09:53:00', '2019-04-25 05:56:00'),
(219, '00000000000000000232', 'ADELARD KAMBALE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2005-02-25 09:53:00', '2020-04-25 05:56:00'),
(220, '00000000000000000233', 'BAHATI MOîSE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2006-02-25 09:53:00', '2021-04-25 05:56:00'),
(221, '00000000000000000234', 'KITIMA BIN ISIAKA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2007-02-25 09:53:00', '2022-04-25 05:56:00'),
(222, '00000000000000000235', 'LOKOLE', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2008-02-25 09:53:00', '2023-04-25 05:56:00'),
(223, '00000000000000000236', 'EDITH NGASHANI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2009-02-25 09:53:00', '2024-04-25 05:56:00'),
(224, '00000000000000000237', 'KAVIRA MUSIVA', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2010-02-25 09:53:00', '2025-04-25 05:56:00'),
(225, '00000000000000000238', 'GUIDO SEMAHANE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2011-02-25 09:53:00', '2026-04-25 05:56:00'),
(226, '00000000000000000239', 'CLAUDE MAONGEZI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2012-02-25 09:53:00', '2027-04-25 05:56:00'),
(227, '00000000000000000240', 'DAVID NYANGE', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2013-02-25 09:53:00', '2028-04-25 05:56:00'),
(228, '00000000000000000241', 'UWINEZA BIGATI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2014-02-25 09:53:00', '2029-04-25 05:56:00'),
(229, '00000000000000000242', 'UWINEZA SEMIVUMBI', 'Femme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2015-02-25 09:53:00', '2030-04-25 05:56:00'),
(230, '00000000000000000243', 'AISHA RASHIDI', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2016-02-25 09:53:00', '2001-05-25 05:56:00'),
(231, '00000000000000000244', 'NJELE YUMULA', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2017-02-25 09:53:00', '2002-05-25 05:56:00'),
(232, '00000000000000000245', 'NDAKOLA MUHOMBO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2018-02-25 09:53:00', '2003-05-25 05:56:00'),
(233, '00000000000000000246', 'NGENDO LUKEBA', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2019-02-25 09:53:00', '2004-05-25 05:56:00'),
(234, '00000000000000000247', 'HAKIZIMANA BOSCO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2020-02-25 09:53:00', '2005-05-25 05:56:00'),
(235, '00000000000000000248', 'BAZAMANZA KAMONYO', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2021-02-25 09:53:00', '2006-05-25 05:56:00'),
(236, '00000000000000000249', 'NEEMA NGIRABAKUNZI', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2022-02-25 09:53:00', '2007-05-25 05:56:00'),
(237, '00000000000000000250', 'BICHENGWA MUKOSA', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2023-02-25 09:53:00', '2008-05-25 05:56:00'),
(238, '00000000000000000251', 'KUBUYA HAMULI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2024-02-25 09:53:00', '2009-05-25 05:56:00'),
(239, '00000000000000000252', 'SYAUSWA CLAUDE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2025-02-25 09:53:00', '2010-05-25 05:56:00'),
(240, '00000000000000000253', 'UWIMANA BIENFAIT', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2026-02-25 09:53:00', '2011-05-25 05:56:00'),
(241, '00000000000000000254', 'TSONGO MUSAVULI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2027-02-25 09:53:00', '2012-05-25 05:56:00'),
(242, '00000000000000000255', 'EVARISTE MBAYMA', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2028-02-25 09:53:00', '2013-05-25 05:56:00'),
(243, '00000000000000000256', 'KAHAMBU SIRIMWENGE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2001-03-25 08:53:00', '2014-05-25 05:56:00'),
(244, '00000000000000000257', 'DUSENGE SEBAZUNGU', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2002-03-25 09:53:00', '2015-05-25 05:56:00'),
(245, '00000000000000000258', 'BUSANGA NKUBA', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2003-03-25 09:53:00', '2016-05-25 05:56:00'),
(246, '00000000000000000259', 'OGUSANE SEFU', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2004-03-25 09:53:00', '2017-05-25 05:56:00'),
(247, '00000000000000000260', 'DAIKU MOMBI', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2005-03-25 09:53:00', '2018-05-25 05:56:00'),
(248, '00000000000000000261', 'BINJA BLANDINE', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2006-03-25 09:53:00', '2019-05-25 05:56:00'),
(249, '00000000000000000262', 'MUNENWA KWIZA', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2007-03-25 08:53:00', '2020-05-25 05:56:00'),
(250, '00000000000000000263', 'HABARUGIRA BIGIRAYIKI', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2008-03-25 09:53:00', '2021-05-25 05:56:00'),
(251, '00000000000000000264', 'NSAMBA SELEMANI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2009-03-25 09:53:00', '2022-05-25 05:56:00'),
(252, '00000000000000000265', 'BYAMUNGU HAMULI', 'Homme', NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2010-03-25 09:53:00', '2023-05-25 05:56:00'),
(253, '00000000000000000266', 'KWIZA MUNENWA', NULL, NULL, NULL, NULL, 'Marié(e)', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avatar.png', NULL, 'OUI', 'OUI', 'admin', 'NON', 'admin', '2011-03-25 09:53:00', '2024-05-25 05:56:00');

-- --------------------------------------------------------

--
-- Structure de la table `tcarte`
--

DROP TABLE IF EXISTS `tcarte`;
CREATE TABLE IF NOT EXISTS `tcarte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refUser` int(11) NOT NULL,
  `dateExpiration` date NOT NULL,
  `numeroCarte` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codeSecret` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `noms_profil` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse_profil` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_profil` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `datenaissance_profil` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `groupesanguin` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe_profil` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_profil` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_profil` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tcarte`
--

INSERT INTO `tcarte` (`id`, `refUser`, `dateExpiration`, `numeroCarte`, `codeSecret`, `noms_profil`, `adresse_profil`, `telephone_profil`, `datenaissance_profil`, `groupesanguin`, `sexe_profil`, `mail_profil`, `photo_profil`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-01-04', '0044', '1234', 'CIZA BLAISE', 'OFFICE', '+243992992063', '1998-01-04', 'A+', 'M', 'member@gmail.com', 'avatar.png', '2023-01-03 23:00:00', '2023-07-29 08:28:46'),
(2, 1, '2023-07-28', '00000', '1234', 'AKILIMALI BADESI GULAIN', 'GOMA, HIMBI', '+243992992063', '1991-01-01', 'AB+', 'M', 'joel@gmail.com', 'avatar.png', '2023-07-28 04:58:05', '2023-07-29 09:51:33');

-- --------------------------------------------------------

--
-- Structure de la table `tcar_annexe`
--

DROP TABLE IF EXISTS `tcar_annexe`;
CREATE TABLE IF NOT EXISTS `tcar_annexe` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteMvt` bigint(20) UNSIGNED NOT NULL,
  `pdfMouvement` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desicriptionPDF` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tcar_annexe_refentetemvt_foreign` (`refEnteteMvt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tcar_detail_casse`
--

DROP TABLE IF EXISTS `tcar_detail_casse`;
CREATE TABLE IF NOT EXISTS `tcar_detail_casse` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteMvt` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `puCasse` double NOT NULL,
  `qteCasse` double NOT NULL,
  `devise` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tcar_detail_casse_refentetemvt_foreign` (`refEnteteMvt`),
  KEY `tcar_detail_casse_refproduit_foreign` (`refProduit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tcar_detail_entree`
--

DROP TABLE IF EXISTS `tcar_detail_entree`;
CREATE TABLE IF NOT EXISTS `tcar_detail_entree` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteMvt` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `puEntree` double NOT NULL,
  `qteEntree` double NOT NULL,
  `devise` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tcar_detail_entree_refentetemvt_foreign` (`refEnteteMvt`),
  KEY `tcar_detail_entree_refproduit_foreign` (`refProduit`),
  KEY `tcar_detail_entree_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tcar_detail_solde`
--

DROP TABLE IF EXISTS `tcar_detail_solde`;
CREATE TABLE IF NOT EXISTS `tcar_detail_solde` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteMvt` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `puSolde` double NOT NULL,
  `qteSolde` double NOT NULL,
  `devise` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tcar_detail_solde_refentetemvt_foreign` (`refEnteteMvt`),
  KEY `tcar_detail_solde_refproduit_foreign` (`refProduit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tcar_emballage`
--

DROP TABLE IF EXISTS `tcar_emballage`;
CREATE TABLE IF NOT EXISTS `tcar_emballage` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteMvt` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `puEmballage` double NOT NULL,
  `qteEmballage` double NOT NULL,
  `devise` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tcar_emballage_refentetemvt_foreign` (`refEnteteMvt`),
  KEY `tcar_emballage_refproduit_foreign` (`refProduit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tcar_entete_mouvement`
--

DROP TABLE IF EXISTS `tcar_entete_mouvement`;
CREATE TABLE IF NOT EXISTS `tcar_entete_mouvement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refVehicule` int(11) NOT NULL,
  `refProvenance` int(11) NOT NULL,
  `dateMvt` date NOT NULL,
  `numBS` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numCD` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numSR` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Chauffeur` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tcar_paiement`
--

DROP TABLE IF EXISTS `tcar_paiement`;
CREATE TABLE IF NOT EXISTS `tcar_paiement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteMvt` bigint(20) UNSIGNED NOT NULL,
  `montant_paie` double NOT NULL,
  `date_paie` date NOT NULL,
  `modepaie` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `devise` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `libellepaie` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refBanque` bigint(20) UNSIGNED NOT NULL,
  `numeroBordereau` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tcar_paiement_refentetemvt_foreign` (`refEnteteMvt`),
  KEY `tcar_paiement_refbanque_foreign` (`refBanque`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tcar_producteur`
--

DROP TABLE IF EXISTS `tcar_producteur`;
CREATE TABLE IF NOT EXISTS `tcar_producteur` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_producteur` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse_prod` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_prod` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_prod` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `autres_details` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tcar_produit`
--

DROP TABLE IF EXISTS `tcar_produit`;
CREATE TABLE IF NOT EXISTS `tcar_produit` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pu` double NOT NULL,
  `devise` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tcar_vehicule`
--

DROP TABLE IF EXISTS `tcar_vehicule`;
CREATE TABLE IF NOT EXISTS `tcar_vehicule` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_vehicule` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `couleur` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numPlaque` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tcategoriemedecin`
--

DROP TABLE IF EXISTS `tcategoriemedecin`;
CREATE TABLE IF NOT EXISTS `tcategoriemedecin` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tcategoriemedecin_designation_unique` (`designation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tchecklist`
--

DROP TABLE IF EXISTS `tchecklist`;
CREATE TABLE IF NOT EXISTS `tchecklist` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refAgent` bigint(20) UNSIGNED NOT NULL,
  `checklist` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `motivation` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `cv` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `diplome` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `carteidentite` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `actenaissance` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `actenaissanceenfant` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `aptitudephysique` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `viemoeurs` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `servicerendu` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `ficheidentite` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `contrattravail` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `jobdescription` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `actemariage` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `briefingmission` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `datebriefingmission` date DEFAULT NULL,
  `organigramme` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `dateorganigramme` date DEFAULT NULL,
  `briefingposte` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `datebriefingposte` date DEFAULT NULL,
  `planstrategique` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `dateplanstrategique` date DEFAULT NULL,
  `briefinggestion` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `datebriefinggestion` date DEFAULT NULL,
  `mannuel` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `datemannuel` date DEFAULT NULL,
  `evaluationstaff` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `datestaff1` date DEFAULT NULL,
  `datestaff2` date DEFAULT NULL,
  `datestaff3` date DEFAULT NULL,
  `periodeconge` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `dateconge1` date DEFAULT NULL,
  `dateconge2` date DEFAULT NULL,
  `dateconge3` date DEFAULT NULL,
  `briefingsecurite` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `datebriefingsecurite` date DEFAULT NULL,
  `notification` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `notefinance` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `datenotefinance` date DEFAULT NULL,
  `attesteservice` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `dateattesteservice` date DEFAULT NULL,
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NON',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tchecklist_refagent_foreign` (`refAgent`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tchecklist`
--

INSERT INTO `tchecklist` (`id`, `refAgent`, `checklist`, `motivation`, `cv`, `diplome`, `carteidentite`, `actenaissance`, `actenaissanceenfant`, `aptitudephysique`, `viemoeurs`, `servicerendu`, `ficheidentite`, `contrattravail`, `jobdescription`, `actemariage`, `briefingmission`, `datebriefingmission`, `organigramme`, `dateorganigramme`, `briefingposte`, `datebriefingposte`, `planstrategique`, `dateplanstrategique`, `briefinggestion`, `datebriefinggestion`, `mannuel`, `datemannuel`, `evaluationstaff`, `datestaff1`, `datestaff2`, `datestaff3`, `periodeconge`, `dateconge1`, `dateconge2`, `dateconge3`, `briefingsecurite`, `datebriefingsecurite`, `notification`, `notefinance`, `datenotefinance`, `attesteservice`, `dateattesteservice`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 'OUI', 'OUI', 'OUI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'KAKULE JEAN', '2024-08-10 12:32:43', '2024-08-10 12:35:49');

-- --------------------------------------------------------

--
-- Structure de la table `tcompte`
--

DROP TABLE IF EXISTS `tcompte`;
CREATE TABLE IF NOT EXISTS `tcompte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refMvt` bigint(20) UNSIGNED NOT NULL,
  `refSscompte` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tcompte_refmvt_foreign` (`refMvt`),
  KEY `tcompte_refsscompte_foreign` (`refSscompte`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tconf_affectation_menu`
--

DROP TABLE IF EXISTS `tconf_affectation_menu`;
CREATE TABLE IF NOT EXISTS `tconf_affectation_menu` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refRole` int(11) NOT NULL,
  `refMenu` int(11) NOT NULL,
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tconf_affectation_menu`
--

INSERT INTO `tconf_affectation_menu` (`id`, `refRole`, `refMenu`, `author`, `created_at`, `updated_at`) VALUES
(19, 1, 6, 'administrateur', '2024-05-20 10:52:09', '2024-05-20 10:52:09'),
(16, 1, 20, 'administrateur', '2024-05-20 10:51:05', '2024-05-20 10:51:05'),
(15, 1, 7, 'administrateur', '2024-05-20 10:50:46', '2024-05-20 10:50:46'),
(14, 1, 1, 'administrateur', '2024-05-20 10:50:35', '2024-05-20 10:50:35'),
(10, 1, 10, 'CIZA BLAISE', '2023-06-23 05:56:58', '2023-06-23 05:56:58'),
(20, 1, 18, 'administrateur', '2024-05-20 10:52:27', '2024-05-20 10:52:27'),
(18, 1, 5, 'administrateur', '2024-05-20 10:51:54', '2024-05-20 10:51:54'),
(17, 1, 19, 'administrateur', '2024-05-20 10:51:34', '2024-05-20 10:51:34');

-- --------------------------------------------------------

--
-- Structure de la table `tconf_banque`
--

DROP TABLE IF EXISTS `tconf_banque`;
CREATE TABLE IF NOT EXISTS `tconf_banque` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_banque` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numerocompte` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_mode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refSscompte` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tconf_banque_nom_banque_unique` (`nom_banque`),
  KEY `tconf_banque_refsscompte_foreign` (`refSscompte`),
  KEY `tconf_banque_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tconf_banque`
--

INSERT INTO `tconf_banque` (`id`, `nom_banque`, `numerocompte`, `nom_mode`, `refSscompte`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(1, 'CAISSE', '000', 'CASH', 5, 'KAKULE JEAN', 4, '2024-10-06 08:34:17', '2024-10-06 08:34:17'),
(2, 'EQUITY', '0000000', 'BANQUE', 4, 'KAKULE JEAN', 4, '2024-10-06 08:34:38', '2024-10-06 08:34:38'),
(3, 'ECOBANK', '000000', 'BANQUE', 4, 'KAKULE JEAN', 4, '2024-10-06 08:35:08', '2024-10-06 08:35:08');

-- --------------------------------------------------------

--
-- Structure de la table `tconf_crud_access`
--

DROP TABLE IF EXISTS `tconf_crud_access`;
CREATE TABLE IF NOT EXISTS `tconf_crud_access` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refRole` int(11) NOT NULL,
  `insert` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `update` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `load` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tconf_crud_access`
--

INSERT INTO `tconf_crud_access` (`id`, `refRole`, `insert`, `update`, `delete`, `load`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 'OUI', 'OUI', 'OUI', 'OUI', 'administrateur', '2023-10-02 16:45:09', '2023-10-04 12:35:53');

-- --------------------------------------------------------

--
-- Structure de la table `tconf_historique_information`
--

DROP TABLE IF EXISTS `tconf_historique_information`;
CREATE TABLE IF NOT EXISTS `tconf_historique_information` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_operation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail_operation` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_entree` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail_information` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_created` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tables` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `champs` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valeurs` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tconf_historique_information`
--

INSERT INTO `tconf_historique_information` (`id`, `user_id`, `user_name`, `type_operation`, `detail_operation`, `date_entree`, `detail_information`, `user_created`, `tables`, `champs`, `valeurs`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 'administrateur', 'Suppression', 'Suppresion dans la table tvente_detail_vente par administrateur', '2023-10-04 14:34:45', 'Suppression du produit : TURBO KING sur la facture n° 3 par l\'utilisateur administrateur', 'administrateur', 'tvente_detail_vente', 'id', '7', '2023-10-04 12:46:49', '2023-10-04 12:46:49', NULL),
(2, 4, 'administrateur', 'Suppression', 'Suppresion dans la table tsalon_detail_vente par administrateur', '2023-12-21 03:09:46', 'Suppression du service : COIFFURE SIMPLE sur la vente n° 3 par l\'utilisateur administrateur', 'administrateur', 'tsalon_detail_vente', 'id', '5', '2023-12-21 02:10:55', '2023-12-21 02:10:55', NULL),
(3, 4, 'administrateur', 'Suppression', 'Suppresion dans la table tperso_fiche_paie par administrateur', '2024-07-10 23:06:43', 'Suppression de la fiche de Paiement en date du : 2024-07-10 par l\'utilisateur administrateur', 'administrateur', 'tperso_fiche_paie', 'id', '4', '2024-07-11 17:40:45', '2024-07-11 17:40:45', NULL),
(4, 4, 'administrateur', 'Suppression', 'Suppresion dans la table tperso_fiche_paie par administrateur', '2024-07-10 23:06:43', 'Suppression de la fiche de Paiement en date du : 2024-07-10 par l\'utilisateur administrateur', 'administrateur', 'tperso_fiche_paie', 'id', '4', '2024-07-11 17:40:58', '2024-07-11 17:40:58', NULL),
(5, 4, 'KAKULE JEAN', 'Suppression', 'Suppresion dans la table tvente_paiement par KAKULE JEAN', '2024-10-06 10:36:56', 'Suppression d\'un paiement du montant de : 30 en date du 2024-10-06 pour la vente des Produits n° 1 par l\'utilisateur KAKULE JEAN', 'KAKULE JEAN', 'tvente_paiement', 'id', '1', '2024-10-06 08:49:16', '2024-10-06 08:49:16', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tconf_list_menu`
--

DROP TABLE IF EXISTS `tconf_list_menu`;
CREATE TABLE IF NOT EXISTS `tconf_list_menu` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_menu` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `numero_menu` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `tconf_list_menu`
--

INSERT INTO `tconf_list_menu` (`id`, `name_menu`, `numero_menu`, `created_at`, `updated_at`) VALUES
(1, 'Article', '1', '2023-06-23 07:32:25', '2023-06-23 07:32:25'),
(2, 'Ventes & Stock', '2', '2023-06-23 07:32:41', '2023-06-23 07:32:41'),
(3, 'Resérvations', '3', '2023-06-23 07:34:28', '2023-06-23 07:34:28'),
(4, 'Billards', '4', '2023-06-23 07:34:56', '2023-06-23 07:34:56'),
(5, 'Finances', '5', '2023-06-23 07:35:18', '2023-06-23 07:35:18'),
(6, 'Logistique', '6', '2023-06-23 07:35:41', '2023-06-23 07:35:41'),
(7, 'RH', '7', '2023-06-23 07:36:02', '2023-06-23 07:36:02'),
(8, 'Véhicules', '8', '2023-06-23 07:36:26', '2023-06-23 07:36:26'),
(9, 'Salon de Beauté', '9', '2023-06-23 07:36:43', '2023-06-23 07:36:43'),
(18, 'Paramètre', '18', '2023-06-23 07:40:04', '2023-06-23 07:40:04'),
(19, 'Projets', '10', '2024-05-20 07:48:33', '2024-05-20 07:48:33'),
(20, 'Archivages', '11', '2024-05-20 07:49:04', '2024-05-20 07:49:04');

-- --------------------------------------------------------

--
-- Structure de la table `tconf_modepaiement`
--

DROP TABLE IF EXISTS `tconf_modepaiement`;
CREATE TABLE IF NOT EXISTS `tconf_modepaiement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tconf_modepaiement_designation_unique` (`designation`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tconf_modepaiement`
--

INSERT INTO `tconf_modepaiement` (`id`, `designation`, `created_at`, `updated_at`) VALUES
(1, 'CASH', '2024-10-06 08:29:47', '2024-10-06 08:29:47'),
(2, 'BANQUE', '2024-10-06 08:29:56', '2024-10-06 08:29:56');

-- --------------------------------------------------------

--
-- Structure de la table `tdata_malade`
--

DROP TABLE IF EXISTS `tdata_malade`;
CREATE TABLE IF NOT EXISTS `tdata_malade` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_maladie` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_categoriemaladie` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plainte` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `historique` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `antecedent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `complementanamnese` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `examenphysique` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnostiquePres` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TypeConsultation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateDetailCons` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateConsultation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricule_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `noms_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `datenaissance_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieunaissnce_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinceOrigine_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `etatcivil_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fonction_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialite_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Categorie_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveauEtude_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `anneeFinEtude_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Ecole_medecin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Poids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Taille` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TA` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Temperature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `FC` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `FR` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Oxygene` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateTriage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateMouvement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numroBon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Statut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateSortieMvt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `motifSortieMvt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Typemouvement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `noms` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Categorie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomAvenue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomQuartier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomCommune` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomVille` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomProvince` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomPays` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe_malade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateNaissance_malade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `etatcivil_malade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroMaison_malade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fonction_malade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personneRef_malade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fonctioPersRef_malade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contactPersRef_malade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `organisation_malade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroCarte_malade` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateExpiration_malade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PrixCons` double NOT NULL,
  `age_malade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exames_labo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prescription_medicaments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `maladie_chronique` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hopital` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tdata_malade`
--

INSERT INTO `tdata_malade` (`id`, `nom_maladie`, `nom_categoriemaladie`, `plainte`, `historique`, `antecedent`, `complementanamnese`, `examenphysique`, `diagnostiquePres`, `TypeConsultation`, `dateDetailCons`, `dateConsultation`, `matricule_medecin`, `noms_medecin`, `sexe_medecin`, `datenaissance_medecin`, `lieunaissnce_medecin`, `provinceOrigine_medecin`, `etatcivil_medecin`, `contact_medecin`, `mail_medecin`, `grade_medecin`, `fonction_medecin`, `specialite_medecin`, `Categorie_medecin`, `niveauEtude_medecin`, `anneeFinEtude_medecin`, `Ecole_medecin`, `Poids`, `Taille`, `TA`, `Temperature`, `FC`, `FR`, `Oxygene`, `dateTriage`, `dateMouvement`, `numroBon`, `Statut`, `dateSortieMvt`, `motifSortieMvt`, `Typemouvement`, `noms`, `contact`, `mail`, `Categorie`, `photo`, `nomAvenue`, `nomQuartier`, `nomCommune`, `nomVille`, `nomProvince`, `nomPays`, `sexe_malade`, `dateNaissance_malade`, `etatcivil_malade`, `numeroMaison_malade`, `fonction_malade`, `personneRef_malade`, `fonctioPersRef_malade`, `contactPersRef_malade`, `organisation_malade`, `numeroCarte_malade`, `dateExpiration_malade`, `PrixCons`, `age_malade`, `exames_labo`, `prescription_medicaments`, `maladie_chronique`, `hopital`, `created_at`, `updated_at`) VALUES
(1, 'MALARIE', 'EPIDEMIIE', 'MAUX DE TETE', 'DEPUIS ENFANCE', 'LES PARENTS', 'Ok', 'OK OK', 'MALARIE', 'CURATIVE', '2023-01-01', '2023-01-01', '003456', 'Dr. Justin', 'M', '1985-01-01', 'GOMA', 'NORD-KIVU', 'MARIE', '0992992063', 'justin@gmail.com', 'MEDECIN', 'MEDECIN', 'orthopédiste', 'OK', 'OK', 'OK', 'ISTM', '80', '1', '40-90', '30', '60', '30', '90', '2023-01-01', '2023-01-01', '0456', 'SORTIE', '2023-01-02', 'OK', 'CONSULATATION', 'BLAISE CIZA', '0992992063', 'ciza@gmail.com', 'ABONNE', 'avatar.png', 'DU LAC', 'HIMBI', 'GOMA', 'GOMA', 'NORD-KIVU', 'RDC', 'M', '1994-01-01', 'MARIE', '008', 'MECANICIEN', 'MURHULA', 'MECANICIEN', '0992992063', 'CARITAS', '1', '2025-01-01', 10, '28', 'GOUTE EPAISSE', 'PARACETAMOLE', 'DIABHETE', 'KYESHERO', '2023-01-01 01:39:35', '2023-01-01 01:39:35');

-- --------------------------------------------------------

--
-- Structure de la table `tdepense`
--

DROP TABLE IF EXISTS `tdepense`;
CREATE TABLE IF NOT EXISTS `tdepense` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `montant` double NOT NULL,
  `montantLettre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motif` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateOperation` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refMvt` bigint(20) UNSIGNED NOT NULL,
  `refCompte` bigint(20) UNSIGNED NOT NULL,
  `refBanque` bigint(20) UNSIGNED NOT NULL,
  `modepaie` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroBordereau` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux_dujour` double NOT NULL,
  `AcquitterPar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StatutAcquitterPar` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DateAcquitterPar` datetime NOT NULL,
  `ApproCoordi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StatutApproCoordi` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DateApproCoordi` datetime NOT NULL,
  `numeroBE` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tdepense_refmvt_foreign` (`refMvt`),
  KEY `tdepense_refcompte_foreign` (`refCompte`),
  KEY `tdepense_refbanque_foreign` (`refBanque`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `biographie` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat` int(11) NOT NULL DEFAULT '1',
  `facebook` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `linkedin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `twitter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `telephone` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `teams`
--

INSERT INTO `teams` (`id`, `nom`, `email`, `titre`, `biographie`, `photo`, `etat`, `facebook`, `linkedin`, `twitter`, `telephone`, `created_at`, `updated_at`) VALUES
(3, 'AIRLY CHIRUZA', 'chiruza@gmail.com', 'PDG', 'PDG', '1672311526.PNG', 1, 'https://web.facebook.com/bienfait.ijambo', '', 'https://dreamofdrc.com/', '+243 991653604', '2022-07-13 11:17:05', '2022-12-29 09:58:46'),
(4, 'MALEY MUSEMA Glodi', 'glodimaley@gmail.com', 'DSIG', 'DSIG', '1672311447.PNG', 1, 'https://web.facebook.com/patronat.shabanisumaili.9', 'linkedin.com/in/sumaili-shabani-roger-patrôna-7426a71a1', 'https://twitter.com/RogerPatrona', '+243817883541', '2022-07-13 11:19:07', '2022-12-29 09:57:27'),
(5, 'AKILIMALI BADESI GULAIN', 'badesi@gmail.com', 'CO', 'CO', '1690639713.jpg', 1, 'https://web.facebook.com/benitalkim', 'https://www.linkedin.com/in/benit-bahati-536500179/?originalSubdomain=cd', 'https://twitter.com/BenitAlkim', '+243823268000', '2022-07-13 11:19:45', '2023-07-29 12:08:33'),
(7, 'Dr JUSTIN', 'drjustin@gmail.com', 'Dicteur Marquetting', 'Dicteur Marquetting', '1690639784.jpg', 1, 'https://web.facebook.com/judith.kabano.5', '', '', '+243818472003', '2022-07-13 11:25:59', '2023-07-29 12:09:44');

-- --------------------------------------------------------

--
-- Structure de la table `temoignages`
--

DROP TABLE IF EXISTS `temoignages`;
CREATE TABLE IF NOT EXISTS `temoignages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fonction` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `temoignages`
--

INSERT INTO `temoignages` (`id`, `nom`, `fonction`, `message`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Sifa tumba', 'Patiente', 'J\'ai appris que la santé publique n\'est pas une opération chirurgicale ; elle nécessite du temps et de la patience si l\'on veut ...', '1669534610.jpg', '2022-11-27 06:36:34', '2022-11-27 06:37:15'),
(2, 'Roger sifiwa', 'Patient', 'Vos professionnels de la santé étaient tous exceptionnels. Que ce soit tard le soir ou tôt le matin, leur engagement et leur niveau de soins n\'ont jamais ...', '1669534682.webp', '2022-11-27 06:38:02', '2022-11-27 06:38:02'),
(3, 'Jojo Yozo', 'Patient et entrepreneur', 'Vos professionnels de la santé étaient tous exceptionnels. Que ce soit tard le soir ou tôt le matin, leur engagement et leur niveau de soins n\'ont jamais ...', '1669534718.jpg', '2022-11-27 06:38:38', '2022-11-27 06:38:38'),
(4, 'Huley frontene', 'Medecin commandant', 'Vos professionnels de la santé étaient tous exceptionnels. Que ce soit tard le soir ou tôt le matin, leur engagement et leur niveau de soins n\'ont jamais ...', '1669534775.jpg', '2022-11-27 06:39:35', '2022-11-27 06:39:35');

-- --------------------------------------------------------

--
-- Structure de la table `territoires`
--

DROP TABLE IF EXISTS `territoires`;
CREATE TABLE IF NOT EXISTS `territoires` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomTerritoire` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `territoires_nomterritoire_unique` (`nomTerritoire`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `territoires`
--

INSERT INTO `territoires` (`id`, `nomTerritoire`, `created_at`, `updated_at`) VALUES
(1, 'Mwenga', '2022-10-19 06:53:17', '2022-10-19 06:53:17'),
(2, 'Shabunda', '2022-10-19 06:53:26', '2022-10-19 06:53:26'),
(3, 'Pangi', '2022-10-19 06:53:34', '2022-10-19 06:53:34'),
(4, 'Walikale', '2022-10-19 06:53:41', '2022-10-19 06:53:41');

-- --------------------------------------------------------

--
-- Structure de la table `textos`
--

DROP TABLE IF EXISTS `textos`;
CREATE TABLE IF NOT EXISTS `textos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `phone` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `etat` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tfin_classe`
--

DROP TABLE IF EXISTS `tfin_classe`;
CREATE TABLE IF NOT EXISTS `tfin_classe` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_classe` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_classe` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tfin_classe_nom_classe_unique` (`nom_classe`),
  UNIQUE KEY `tfin_classe_numero_classe_unique` (`numero_classe`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_classe`
--

INSERT INTO `tfin_classe` (`id`, `nom_classe`, `numero_classe`, `author`, `created_at`, `updated_at`) VALUES
(1, 'Marchandise', '3', 'KAKULE JEAN', '2024-10-05 10:02:10', '2024-10-05 10:03:39'),
(2, 'Externe', '4', 'KAKULE JEAN', '2024-10-05 10:02:40', '2024-10-05 10:03:22'),
(3, 'Tresorerie', '5', 'KAKULE JEAN', '2024-10-05 10:02:58', '2024-10-05 10:02:58'),
(4, 'Charges', '6', 'KAKULE JEAN', '2024-10-05 10:03:55', '2024-10-05 10:03:55'),
(5, 'Produit', '7', 'KAKULE JEAN', '2024-10-05 10:04:06', '2024-10-05 10:04:06');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_cloture_caisse`
--

DROP TABLE IF EXISTS `tfin_cloture_caisse`;
CREATE TABLE IF NOT EXISTS `tfin_cloture_caisse` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refSscompte` bigint(20) UNSIGNED NOT NULL,
  `date_cloture` date NOT NULL,
  `montant_cloture` double NOT NULL,
  `taux_dujour` double NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tfin_cloture_caisse_date_cloture_unique` (`date_cloture`),
  KEY `tfin_cloture_caisse_refsscompte_foreign` (`refSscompte`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tfin_cloture_comptabilite`
--

DROP TABLE IF EXISTS `tfin_cloture_comptabilite`;
CREATE TABLE IF NOT EXISTS `tfin_cloture_comptabilite` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numerOperation` int(11) NOT NULL,
  `dateCloture` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tauxdujour` double NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tfin_compte`
--

DROP TABLE IF EXISTS `tfin_compte`;
CREATE TABLE IF NOT EXISTS `tfin_compte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refClasse` bigint(20) UNSIGNED NOT NULL,
  `refTypecompte` bigint(20) UNSIGNED NOT NULL,
  `refPosition` bigint(20) UNSIGNED NOT NULL,
  `nom_compte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_compte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tfin_compte_nom_compte_unique` (`nom_compte`),
  UNIQUE KEY `tfin_compte_numero_compte_unique` (`numero_compte`),
  KEY `tfin_compte_refclasse_foreign` (`refClasse`),
  KEY `tfin_compte_reftypecompte_foreign` (`refTypecompte`),
  KEY `tfin_compte_refposition_foreign` (`refPosition`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_compte`
--

INSERT INTO `tfin_compte` (`id`, `refClasse`, `refTypecompte`, `refPosition`, `nom_compte`, `numero_compte`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Marchandise', '31', 'KAKULE JEAN', '2024-10-05 10:06:00', '2024-10-05 10:06:00'),
(2, 2, 1, 1, 'Fournisseur', '40', 'KAKULE JEAN', '2024-10-05 10:06:26', '2024-10-05 10:07:06'),
(3, 2, 1, 1, 'Client', '41', 'KAKULE JEAN', '2024-10-05 10:06:47', '2024-10-05 10:06:47'),
(4, 3, 1, 1, 'Banque', '52', 'KAKULE JEAN', '2024-10-05 10:07:36', '2024-10-05 10:07:36'),
(5, 3, 1, 1, 'Caisse', '57', 'KAKULE JEAN', '2024-10-05 10:07:55', '2024-10-05 10:07:55'),
(6, 4, 1, 1, 'Variation de stock', '63', 'KAKULE JEAN', '2024-10-05 10:08:37', '2024-10-05 10:08:37'),
(7, 4, 1, 1, 'Charges divers', '60', 'KAKULE JEAN', '2024-10-05 10:09:11', '2024-10-05 10:09:11'),
(8, 5, 1, 1, 'Ventes diverses', '70', 'KAKULE JEAN', '2024-10-05 10:09:40', '2024-10-05 10:09:40');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_souscompte`
--

DROP TABLE IF EXISTS `tfin_souscompte`;
CREATE TABLE IF NOT EXISTS `tfin_souscompte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refCompte` bigint(20) UNSIGNED NOT NULL,
  `nom_souscompte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_souscompte` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tfin_souscompte_nom_souscompte_unique` (`nom_souscompte`),
  UNIQUE KEY `tfin_souscompte_numero_souscompte_unique` (`numero_souscompte`),
  KEY `tfin_souscompte_refcompte_foreign` (`refCompte`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_souscompte`
--

INSERT INTO `tfin_souscompte` (`id`, `refCompte`, `nom_souscompte`, `numero_souscompte`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 'Marchandise', '31.0', 'KAKULE JEAN', '2024-10-05 10:10:10', '2024-10-05 10:10:10'),
(2, 2, 'Fournisseur', '40.0', 'KAKULE JEAN', '2024-10-05 10:10:30', '2024-10-05 10:10:30'),
(3, 3, 'Client', '41.0', 'KAKULE JEAN', '2024-10-05 10:10:50', '2024-10-05 10:10:50'),
(4, 4, 'Banque', '52.0', 'KAKULE JEAN', '2024-10-05 10:11:10', '2024-10-05 10:11:10'),
(5, 5, 'Caisse', '57.0', 'KAKULE JEAN', '2024-10-05 10:11:27', '2024-10-05 10:11:27'),
(6, 8, 'Ventes diverses', '70.1', 'KAKULE JEAN', '2024-10-05 10:11:50', '2024-10-05 10:18:31'),
(7, 6, 'Variation stock', '63.0', 'KAKULE JEAN', '2024-10-05 10:12:22', '2024-10-05 10:13:36'),
(8, 7, 'Charges diverses', '60.3', 'KAKULE JEAN', '2024-10-05 10:14:00', '2024-10-05 10:14:00');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_ssouscompte`
--

DROP TABLE IF EXISTS `tfin_ssouscompte`;
CREATE TABLE IF NOT EXISTS `tfin_ssouscompte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refSousCompte` bigint(20) UNSIGNED NOT NULL,
  `nom_ssouscompte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_ssouscompte` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tfin_ssouscompte_nom_ssouscompte_unique` (`nom_ssouscompte`),
  UNIQUE KEY `tfin_ssouscompte_numero_ssouscompte_unique` (`numero_ssouscompte`),
  KEY `tfin_ssouscompte_refsouscompte_foreign` (`refSousCompte`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_ssouscompte`
--

INSERT INTO `tfin_ssouscompte` (`id`, `refSousCompte`, `nom_ssouscompte`, `numero_ssouscompte`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 'Marchandise', '32.0.1', 'KAKULE JEAN', '2024-10-05 10:14:42', '2024-10-05 10:14:42'),
(2, 2, 'Fournisseur', '40.0.1', 'KAKULE JEAN', '2024-10-05 10:15:48', '2024-10-05 10:15:48'),
(3, 3, 'Client', '41.0.1', 'KAKULE JEAN', '2024-10-05 10:16:10', '2024-10-05 10:16:10'),
(4, 4, 'Banque', '52.0.1', 'KAKULE JEAN', '2024-10-05 10:16:34', '2024-10-05 10:16:34'),
(5, 5, 'Caisse', '57.0.1', 'KAKULE JEAN', '2024-10-05 10:17:02', '2024-10-05 10:17:02'),
(7, 7, 'Variation de stock', '63.0.1', 'KAKULE JEAN', '2024-10-05 10:25:13', '2024-10-05 10:25:13'),
(8, 8, 'Charges diveres', '60.0.1', 'KAKULE JEAN', '2024-10-05 10:26:11', '2024-10-05 10:26:11'),
(9, 6, 'Ventes diverses', '70.0.1', 'KAKULE JEAN', '2024-10-05 10:26:44', '2024-10-05 10:26:44');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_typecompte`
--

DROP TABLE IF EXISTS `tfin_typecompte`;
CREATE TABLE IF NOT EXISTS `tfin_typecompte` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_typecompte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tfin_typecompte_nom_typecompte_unique` (`nom_typecompte`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_typecompte`
--

INSERT INTO `tfin_typecompte` (`id`, `nom_typecompte`, `author`, `created_at`, `updated_at`) VALUES
(1, 'Actif', 'KAKULE JEAN', '2024-10-05 10:05:02', '2024-10-05 10:05:02'),
(2, 'Passif', 'KAKULE JEAN', '2024-10-05 10:05:08', '2024-10-05 10:05:08');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_typeoperation`
--

DROP TABLE IF EXISTS `tfin_typeoperation`;
CREATE TABLE IF NOT EXISTS `tfin_typeoperation` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_typeoperation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tfin_typeoperation_nom_typeoperation_unique` (`nom_typeoperation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tfin_typeposition`
--

DROP TABLE IF EXISTS `tfin_typeposition`;
CREATE TABLE IF NOT EXISTS `tfin_typeposition` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_typeposition` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tfin_typeposition_nom_typeposition_unique` (`nom_typeposition`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tfin_typeposition`
--

INSERT INTO `tfin_typeposition` (`id`, `nom_typeposition`, `author`, `created_at`, `updated_at`) VALUES
(1, 'D', 'KAKULE JEAN', '2024-10-05 10:05:17', '2024-10-05 10:05:17'),
(2, 'C', 'KAKULE JEAN', '2024-10-05 10:05:24', '2024-10-05 10:05:24');

-- --------------------------------------------------------

--
-- Structure de la table `tfin_typeproduit`
--

DROP TABLE IF EXISTS `tfin_typeproduit`;
CREATE TABLE IF NOT EXISTS `tfin_typeproduit` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_typeproduit` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tfin_typeproduit_nom_typeproduit_unique` (`nom_typeproduit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tfonctionmedecin`
--

DROP TABLE IF EXISTS `tfonctionmedecin`;
CREATE TABLE IF NOT EXISTS `tfonctionmedecin` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tfonctionmedecin_designation_unique` (`designation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `theme_formes`
--

DROP TABLE IF EXISTS `theme_formes`;
CREATE TABLE IF NOT EXISTS `theme_formes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomTheme` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `theme_formes`
--

INSERT INTO `theme_formes` (`id`, `nomTheme`, `created_at`, `updated_at`) VALUES
(1, 'Protection sociale', '2022-07-07 07:33:10', '2022-07-07 07:33:10'),
(2, 'Insécurité alimentaire', '2022-07-07 07:33:22', '2022-07-07 07:33:22'),
(3, 'Éruption volcanique', '2022-07-07 07:33:31', '2022-07-07 07:33:31'),
(4, 'Santé et bien être', '2022-07-07 07:33:42', '2022-07-07 07:33:42'),
(5, 'Environnement et Écologie', '2022-07-07 07:33:53', '2022-07-07 07:33:53');

-- --------------------------------------------------------

--
-- Structure de la table `thopital`
--

DROP TABLE IF EXISTS `thopital`;
CREATE TABLE IF NOT EXISTS `thopital` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thotel_billard`
--

DROP TABLE IF EXISTS `thotel_billard`;
CREATE TABLE IF NOT EXISTS `thotel_billard` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refClient` bigint(20) UNSIGNED NOT NULL,
  `montant_paie` double NOT NULL,
  `devise` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `date_paie` date NOT NULL,
  `heure_debut` datetime NOT NULL,
  `heure_fin` datetime NOT NULL,
  `libelle` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thotel_billard_refclient_foreign` (`refClient`),
  KEY `thotel_billard_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thotel_chambre`
--

DROP TABLE IF EXISTS `thotel_chambre`;
CREATE TABLE IF NOT EXISTS `thotel_chambre` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_chambre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_chambre` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refClasse` int(11) NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `thotel_chambre_nom_chambre_unique` (`nom_chambre`),
  UNIQUE KEY `thotel_chambre_numero_chambre_unique` (`numero_chambre`),
  KEY `thotel_chambre_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thotel_classe_chambre`
--

DROP TABLE IF EXISTS `thotel_classe_chambre`;
CREATE TABLE IF NOT EXISTS `thotel_classe_chambre` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix_chambre` double NOT NULL,
  `devise` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `thotel_classe_chambre_designation_unique` (`designation`),
  KEY `thotel_classe_chambre_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thotel_incident_reservation_salle`
--

DROP TABLE IF EXISTS `thotel_incident_reservation_salle`;
CREATE TABLE IF NOT EXISTS `thotel_incident_reservation_salle` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refReservation` bigint(20) UNSIGNED NOT NULL,
  `montant_incident` double NOT NULL,
  `devise` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `autres_details` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thotel_incident_reservation_salle_refreservation_foreign` (`refReservation`),
  KEY `thotel_incident_reservation_salle_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thotel_paiement_chambre`
--

DROP TABLE IF EXISTS `thotel_paiement_chambre`;
CREATE TABLE IF NOT EXISTS `thotel_paiement_chambre` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refReservation` bigint(20) UNSIGNED NOT NULL,
  `montant_paie` double NOT NULL,
  `devise` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `date_paie` date NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thotel_paiement_chambre_refreservation_foreign` (`refReservation`),
  KEY `thotel_paiement_chambre_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thotel_paiement_salle`
--

DROP TABLE IF EXISTS `thotel_paiement_salle`;
CREATE TABLE IF NOT EXISTS `thotel_paiement_salle` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refReservation` bigint(20) UNSIGNED NOT NULL,
  `montant_paie` double NOT NULL,
  `devise` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `date_paie` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thotel_paiement_salle_refreservation_foreign` (`refReservation`),
  KEY `thotel_paiement_salle_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thotel_reservation_chambre`
--

DROP TABLE IF EXISTS `thotel_reservation_chambre`;
CREATE TABLE IF NOT EXISTS `thotel_reservation_chambre` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refClient` bigint(20) UNSIGNED NOT NULL,
  `refChmabre` bigint(20) UNSIGNED NOT NULL,
  `date_entree` date NOT NULL,
  `date_sortie` date NOT NULL,
  `heure_debut` datetime NOT NULL,
  `heure_sortie` datetime NOT NULL,
  `libelle` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix_unitaire` double NOT NULL,
  `devise` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `reduction` double NOT NULL,
  `observation` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_reservation` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_accompagner` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays_provenance` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thotel_reservation_chambre_refclient_foreign` (`refClient`),
  KEY `thotel_reservation_chambre_refchmabre_foreign` (`refChmabre`),
  KEY `thotel_reservation_chambre_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thotel_reservation_salle`
--

DROP TABLE IF EXISTS `thotel_reservation_salle`;
CREATE TABLE IF NOT EXISTS `thotel_reservation_salle` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refClient` bigint(20) UNSIGNED NOT NULL,
  `refSalle` bigint(20) UNSIGNED NOT NULL,
  `date_ceremonie` date NOT NULL,
  `heure_debut` datetime NOT NULL,
  `heure_sortie` datetime NOT NULL,
  `date_reservation` date NOT NULL,
  `prix_unitaire` double NOT NULL,
  `taux` double NOT NULL,
  `reduction` double NOT NULL,
  `observation` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thotel_reservation_salle_refclient_foreign` (`refClient`),
  KEY `thotel_reservation_salle_refsalle_foreign` (`refSalle`),
  KEY `thotel_reservation_salle_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thotel_salle`
--

DROP TABLE IF EXISTS `thotel_salle`;
CREATE TABLE IF NOT EXISTS `thotel_salle` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix_salle` double NOT NULL,
  `devise` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `thotel_salle_designation_unique` (`designation`),
  KEY `thotel_salle_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tlog_detail_entree`
--

DROP TABLE IF EXISTS `tlog_detail_entree`;
CREATE TABLE IF NOT EXISTS `tlog_detail_entree` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteEntree` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `puEntree` double NOT NULL,
  `qteEntree` double NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tlog_detail_entree_refenteteentree_foreign` (`refEnteteEntree`),
  KEY `tlog_detail_entree_refproduit_foreign` (`refProduit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tlog_detail_requisition`
--

DROP TABLE IF EXISTS `tlog_detail_requisition`;
CREATE TABLE IF NOT EXISTS `tlog_detail_requisition` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteCmd` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `puCmd` double NOT NULL,
  `qteCmd` double NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tlog_detail_requisition_refentetecmd_foreign` (`refEnteteCmd`),
  KEY `tlog_detail_requisition_refproduit_foreign` (`refProduit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tlog_detail_sortie`
--

DROP TABLE IF EXISTS `tlog_detail_sortie`;
CREATE TABLE IF NOT EXISTS `tlog_detail_sortie` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteSortie` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `puSortie` double NOT NULL,
  `qteSortie` double NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tlog_detail_sortie_refentetesortie_foreign` (`refEnteteSortie`),
  KEY `tlog_detail_sortie_refproduit_foreign` (`refProduit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tlog_emplacements`
--

DROP TABLE IF EXISTS `tlog_emplacements`;
CREATE TABLE IF NOT EXISTS `tlog_emplacements` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_emplacement` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tlog_entete_entree`
--

DROP TABLE IF EXISTS `tlog_entete_entree`;
CREATE TABLE IF NOT EXISTS `tlog_entete_entree` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refFournisseur` bigint(20) UNSIGNED NOT NULL,
  `dateEntree` date NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tlog_entete_entree_reffournisseur_foreign` (`refFournisseur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tlog_entete_requisition`
--

DROP TABLE IF EXISTS `tlog_entete_requisition`;
CREATE TABLE IF NOT EXISTS `tlog_entete_requisition` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refFournisseur` bigint(20) UNSIGNED NOT NULL,
  `dateCmd` date NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tlog_entete_requisition_reffournisseur_foreign` (`refFournisseur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tlog_entete_sortie`
--

DROP TABLE IF EXISTS `tlog_entete_sortie`;
CREATE TABLE IF NOT EXISTS `tlog_entete_sortie` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refService` bigint(20) UNSIGNED NOT NULL,
  `nom_agent` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateSortie` date NOT NULL,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tlog_entete_sortie_refservice_foreign` (`refService`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tlog_produit`
--

DROP TABLE IF EXISTS `tlog_produit`;
CREATE TABLE IF NOT EXISTS `tlog_produit` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pu` double NOT NULL,
  `qte` double NOT NULL,
  `refCategorie` bigint(20) UNSIGNED NOT NULL,
  `refEnplacement` bigint(20) UNSIGNED NOT NULL,
  `devise` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tlog_produit_designation_unique` (`designation`),
  KEY `tlog_produit_refcategorie_foreign` (`refCategorie`),
  KEY `tlog_produit_refenplacement_foreign` (`refEnplacement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tlog_service`
--

DROP TABLE IF EXISTS `tlog_service`;
CREATE TABLE IF NOT EXISTS `tlog_service` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tlog_service_designation_unique` (`designation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_activites_projet`
--

DROP TABLE IF EXISTS `tperso_activites_projet`;
CREATE TABLE IF NOT EXISTS `tperso_activites_projet` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `projet_id` bigint(20) UNSIGNED NOT NULL,
  `description_tache` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut_tache` date NOT NULL,
  `duree_tache` int(11) NOT NULL,
  `date_fin_tache` date NOT NULL,
  `nbr_heureJour` int(11) NOT NULL,
  `cout_heure` double NOT NULL,
  `statut_tache` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Attente',
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_activites_projet_projet_id_foreign` (`projet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_activites_projet`
--

INSERT INTO `tperso_activites_projet` (`id`, `projet_id`, `description_tache`, `date_debut_tache`, `duree_tache`, `date_fin_tache`, `nbr_heureJour`, `cout_heure`, `statut_tache`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 'Enregistrement des beneficiaires', '2024-05-29', 2, '2024-05-31', 8, 3, 'Attente', 'administrateur', '2024-05-28 09:44:41', '2024-05-28 09:44:41');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_affectation_agent`
--

DROP TABLE IF EXISTS `tperso_affectation_agent`;
CREATE TABLE IF NOT EXISTS `tperso_affectation_agent` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refAgent` bigint(20) UNSIGNED NOT NULL,
  `refServicePerso` bigint(20) UNSIGNED NOT NULL,
  `refCategorieAgent` bigint(20) UNSIGNED NOT NULL,
  `refPoste` bigint(20) UNSIGNED NOT NULL,
  `refLieuAffectation` bigint(20) UNSIGNED NOT NULL,
  `refMutuelle` bigint(20) UNSIGNED NOT NULL,
  `refTypeContrat` bigint(20) UNSIGNED NOT NULL,
  `param_salaire_id` bigint(20) UNSIGNED NOT NULL,
  `fammiliale` double NOT NULL DEFAULT '0',
  `logement` double NOT NULL DEFAULT '0',
  `transport` double NOT NULL DEFAULT '0',
  `sal_brut` double NOT NULL DEFAULT '0',
  `sal_brut_imposable` double NOT NULL DEFAULT '0',
  `inss_qpo` double NOT NULL DEFAULT '0',
  `inss_qpp` double NOT NULL DEFAULT '0',
  `cnss` double NOT NULL DEFAULT '0',
  `inpp` double NOT NULL DEFAULT '0',
  `onem` double NOT NULL DEFAULT '0',
  `ipr` double NOT NULL DEFAULT '0',
  `mission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `dateAffectation` date NOT NULL,
  `dureecontrat` int(11) NOT NULL,
  `dureeLettre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateFin` date NOT NULL,
  `dateDebutEssaie` date NOT NULL,
  `dateFinEssaie` date NOT NULL,
  `JourTrail1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `JourTrail2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `heureTrail1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `heureTrail2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TempsPause` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrConge` int(11) NOT NULL,
  `nbrCongeLettre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomOffice` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postnomOffice` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualifieOffice` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codeAgent` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `directeur` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numCNSS` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numImpot` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numcpteBanque` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `BanqueAgant` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `autresDetail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `conge` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `etat_contrat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Encours',
  `author` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_affectation_agent_refagent_foreign` (`refAgent`),
  KEY `tperso_affectation_agent_refserviceperso_foreign` (`refServicePerso`),
  KEY `tperso_affectation_agent_refcategorieagent_foreign` (`refCategorieAgent`),
  KEY `tperso_affectation_agent_refposte_foreign` (`refPoste`),
  KEY `tperso_affectation_agent_reflieuaffectation_foreign` (`refLieuAffectation`),
  KEY `tperso_affectation_agent_refmutuelle_foreign` (`refMutuelle`),
  KEY `tperso_affectation_agent_reftypecontrat_foreign` (`refTypeContrat`),
  KEY `tperso_affectation_agent_param_salaire_id_foreign` (`param_salaire_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_affectation_agent`
--

INSERT INTO `tperso_affectation_agent` (`id`, `refAgent`, `refServicePerso`, `refCategorieAgent`, `refPoste`, `refLieuAffectation`, `refMutuelle`, `refTypeContrat`, `param_salaire_id`, `fammiliale`, `logement`, `transport`, `sal_brut`, `sal_brut_imposable`, `inss_qpo`, `inss_qpp`, `cnss`, `inpp`, `onem`, `ipr`, `mission`, `dateAffectation`, `dureecontrat`, `dureeLettre`, `dateFin`, `dateDebutEssaie`, `dateFinEssaie`, `JourTrail1`, `JourTrail2`, `heureTrail1`, `heureTrail2`, `TempsPause`, `nbrConge`, `nbrCongeLettre`, `nomOffice`, `postnomOffice`, `qualifieOffice`, `codeAgent`, `directeur`, `numCNSS`, `numImpot`, `numcpteBanque`, `BanqueAgant`, `autresDetail`, `conge`, `etat_contrat`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 1, 1, 2, 1, 1, 5, 315.675, 176, 1548.925, 1004.6375, 52.6125, 136.7925, 189.405, 21.045, 2.1045, 139.175625, 'NON', '2024-07-04', 12, 'DOUZE MOIS', '2025-07-04', '2024-07-04', '2024-07-14', 'LUNDI', 'VENDREDI', '08H00', '16H00', '12H00', 20, 'VINGT JOUR', 'CARITAS', 'CARITAS', 'CARITAS', '0000', 'KAKULE JEAN', '000', '000', '000', 'EQUITY', '000', 'OUI', 'Encours', 'administrateur', 'NON', 'user', '2024-07-04 08:38:41', '2024-07-10 10:50:41'),
(2, 2, 2, 1, 1, 1, 2, 1, 4, 0, 45, 176, 371, 142.5, 7.5, 19.5, 27, 3, 0.3, 9.855, 'NON', '2024-07-04', 6, 'SIX MOIS', '2025-01-04', '2024-07-04', '2024-07-07', 'LUNDI', 'VENDREDI', '08H00', '16H00', '12H00', 2, 'DEUX JOURS', 'CARITAS', 'CARITAS', 'CARITAS', '000', 'KAKULE JEAN', '00', '00', '00', 'RAW BANK', '00', 'NON', 'Encours', 'administrateur', 'NON', 'user', '2024-07-04 08:47:36', '2024-09-16 10:43:52'),
(3, 3, 2, 1, 2, 1, 2, 1, 4, 0, 45, 110, 305, 142.5, 7.5, 19.5, 27, 3, 0.3, 9.855, 'NON', '2024-07-04', 6, 'SIX MOIS', '2025-01-04', '2024-07-04', '2024-07-26', 'LUNDI', 'VENDREDI', '08H00', '16H00', '12H00', 30, 'TRENTE', 'CARITAS', 'CARITAS', 'CARITAS', '00', 'KAKULE JEAN', '00', '00', '00', 'RAW BANK', '00', 'NON', 'Encours', 'administrateur', 'NON', 'user', '2024-07-04 08:55:50', '2024-07-04 08:55:50'),
(4, 91, 1, 2, 71, 1, 2, 1, 5, 0, 0.6, 0, 2.6, 1.9, 0.1, 0.26, 0.36, 0.04, 0.004, 0.057, 'NON', '2024-09-27', 3, 'TROIS', '2024-12-27', '2024-09-25', '2024-09-25', 'LUNDI', 'SAMEDI', '12H00', '14H00', '13H00', 2, 'DEUX', 'XXX', 'XXX', 'XX', '00', 'Abbé BAHATI RUBAMBIZA', '00', '00', '00', 'ECO-BANK', 'XX', 'NON', 'Encours', 'KAKULE JEAN', 'NON', 'user', '2024-09-25 07:24:41', '2024-09-25 07:24:41');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_affectation_tache`
--

DROP TABLE IF EXISTS `tperso_affectation_tache`;
CREATE TABLE IF NOT EXISTS `tperso_affectation_tache` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `activite_id` bigint(20) UNSIGNED NOT NULL,
  `affectation_id` bigint(20) UNSIGNED NOT NULL,
  `date_affect_tache` date NOT NULL,
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_affectation_tache_activite_id_foreign` (`activite_id`),
  KEY `tperso_affectation_tache_affectation_id_foreign` (`affectation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_affectation_tache`
--

INSERT INTO `tperso_affectation_tache` (`id`, `activite_id`, `affectation_id`, `date_affect_tache`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-05-28', 'administrateur', '2024-05-28 10:08:32', '2024-05-28 10:08:32');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_annee`
--

DROP TABLE IF EXISTS `tperso_annee`;
CREATE TABLE IF NOT EXISTS `tperso_annee` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_annee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_annee`
--

INSERT INTO `tperso_annee` (`id`, `name_annee`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, '2024', 'NON', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tperso_annee_stage`
--

DROP TABLE IF EXISTS `tperso_annee_stage`;
CREATE TABLE IF NOT EXISTS `tperso_annee_stage` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_annee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_annee_stage`
--

INSERT INTO `tperso_annee_stage` (`id`, `name_annee`, `author`, `created_at`, `updated_at`) VALUES
(1, '2023-2024', 'administrateur', '2024-05-28 11:00:46', '2024-05-28 11:00:46'),
(2, '2024-2025', 'administrateur', '2024-05-28 11:00:57', '2024-05-28 11:00:57');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_annexe`
--

DROP TABLE IF EXISTS `tperso_annexe`;
CREATE TABLE IF NOT EXISTS `tperso_annexe` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `noms_annexe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `refAgent` bigint(20) UNSIGNED NOT NULL,
  `annexe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_annexe_refagent_foreign` (`refAgent`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_annexe`
--

INSERT INTO `tperso_annexe` (`id`, `noms_annexe`, `refAgent`, `annexe`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 'ATTESTATION DE NAISSANCE', 1, '1716990694.jpg', '', 'NON', 'user', '2024-05-29 11:51:34', '2024-05-29 11:51:34');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_annexe_projet`
--

DROP TABLE IF EXISTS `tperso_annexe_projet`;
CREATE TABLE IF NOT EXISTS `tperso_annexe_projet` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `noms_annexe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refAgent` bigint(20) UNSIGNED NOT NULL,
  `annexe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_annexe_projet_refagent_foreign` (`refAgent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_appreciation_agent`
--

DROP TABLE IF EXISTS `tperso_appreciation_agent`;
CREATE TABLE IF NOT EXISTS `tperso_appreciation_agent` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refAffectation` bigint(20) UNSIGNED NOT NULL,
  `periodeDu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connaissanceTheorique` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `appliDeontologie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `manipulation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prendConsideration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ponctualite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fiabilite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `espritEquipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `courtoisie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sensResponsabilite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sensEcoute` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `preparationExecution` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `organiseTravail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Propositions` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateAppreciation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suiveur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hierarchie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_appreciation_agent_refaffectation_foreign` (`refAffectation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_archivages`
--

DROP TABLE IF EXISTS `tperso_archivages`;
CREATE TABLE IF NOT EXISTS `tperso_archivages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_archive` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_archive` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fichier_archive` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_archivages_service_id_foreign` (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_archivages`
--

INSERT INTO `tperso_archivages` (`id`, `name_archive`, `description_archive`, `fichier_archive`, `service_id`, `author`, `created_at`, `updated_at`) VALUES
(1, 'FACTURE POUR ACHAT DES ORDINATEURS', 'FACTURE POUR ACHAT DES ORDINATTEURS', '1716900280.jpg', 2, '', '2024-05-28 10:44:40', '2024-05-28 10:44:40');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_autre_conge`
--

DROP TABLE IF EXISTS `tperso_autre_conge`;
CREATE TABLE IF NOT EXISTS `tperso_autre_conge` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteConge` bigint(20) UNSIGNED NOT NULL,
  `autreDetail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_autre_conge_refenteteconge_foreign` (`refEnteteConge`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_avance_salaire`
--

DROP TABLE IF EXISTS `tperso_avance_salaire`;
CREATE TABLE IF NOT EXISTS `tperso_avance_salaire` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refAffectation` bigint(20) UNSIGNED NOT NULL,
  `refMois` bigint(20) UNSIGNED NOT NULL,
  `refAnne` bigint(20) UNSIGNED NOT NULL,
  `montant_avance` double NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_avance_salaire_refaffectation_foreign` (`refAffectation`),
  KEY `tperso_avance_salaire_refmois_foreign` (`refMois`),
  KEY `tperso_avance_salaire_refanne_foreign` (`refAnne`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_avance_salaire`
--

INSERT INTO `tperso_avance_salaire` (`id`, `refAffectation`, `refMois`, `refAnne`, `montant_avance`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 30, 'administrateur', 'NON', 'user', '2024-07-10 20:54:13', '2024-07-10 20:54:13');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_bareme`
--

DROP TABLE IF EXISTS `tperso_bareme`;
CREATE TABLE IF NOT EXISTS `tperso_bareme` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `taux_bareme` double NOT NULL,
  `usd_bareme` double NOT NULL,
  `tranche1_bareme` double NOT NULL,
  `tranche2_bareme` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_categorie_agent`
--

DROP TABLE IF EXISTS `tperso_categorie_agent`;
CREATE TABLE IF NOT EXISTS `tperso_categorie_agent` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_categorie_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_categorie_agent`
--

INSERT INTO `tperso_categorie_agent` (`id`, `name_categorie_agent`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 'ADMINISTRATION', 'NON', 'user', NULL, NULL),
(2, 'TECHINIQUE', 'NON', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tperso_categorie_archivage`
--

DROP TABLE IF EXISTS `tperso_categorie_archivage`;
CREATE TABLE IF NOT EXISTS `tperso_categorie_archivage` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_categorie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_categorie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_categorie_archivage`
--

INSERT INTO `tperso_categorie_archivage` (`id`, `name_categorie`, `description_categorie`, `author`, `created_at`, `updated_at`) VALUES
(1, 'EXTERNE', 'EXTERNE', 'administrateur', '2024-05-28 10:31:20', '2024-05-28 10:31:20'),
(2, 'INTERNE', 'INTERNE', 'administrateur', '2024-05-28 10:31:33', '2024-05-28 10:31:33');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_categorie_circonstance`
--

DROP TABLE IF EXISTS `tperso_categorie_circonstance`;
CREATE TABLE IF NOT EXISTS `tperso_categorie_circonstance` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_categorie_rubrique`
--

DROP TABLE IF EXISTS `tperso_categorie_rubrique`;
CREATE TABLE IF NOT EXISTS `tperso_categorie_rubrique` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_categorie_rubrique` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_categorie_rubrique`
--

INSERT INTO `tperso_categorie_rubrique` (`id`, `name_categorie_rubrique`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 'AVANATGE', 'NON', 'user', NULL, NULL),
(2, 'RETENUE', 'NON', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tperso_categorie_service`
--

DROP TABLE IF EXISTS `tperso_categorie_service`;
CREATE TABLE IF NOT EXISTS `tperso_categorie_service` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_categorie_service` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_categorie_service`
--

INSERT INTO `tperso_categorie_service` (`id`, `name_categorie_service`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 'ADMINISTRATION', 'NON', 'user', NULL, NULL),
(2, 'SUPERVISEUR', 'NON', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tperso_conge_annuel`
--

DROP TABLE IF EXISTS `tperso_conge_annuel`;
CREATE TABLE IF NOT EXISTS `tperso_conge_annuel` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteConge` bigint(20) UNSIGNED NOT NULL,
  `autresDetail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_conge_annuel_refenteteconge_foreign` (`refEnteteConge`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_conge_familiale`
--

DROP TABLE IF EXISTS `tperso_conge_familiale`;
CREATE TABLE IF NOT EXISTS `tperso_conge_familiale` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteConge` bigint(20) UNSIGNED NOT NULL,
  `refRaison` bigint(20) UNSIGNED NOT NULL,
  `autreDetail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_conge_familiale_refenteteconge_foreign` (`refEnteteConge`),
  KEY `tperso_conge_familiale_refraison_foreign` (`refRaison`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_controle_conge`
--

DROP TABLE IF EXISTS `tperso_controle_conge`;
CREATE TABLE IF NOT EXISTS `tperso_controle_conge` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refAffectation` bigint(20) UNSIGNED NOT NULL,
  `refAnne` bigint(20) UNSIGNED NOT NULL,
  `nbrJour` int(11) NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_controle_conge_refaffectation_foreign` (`refAffectation`),
  KEY `tperso_controle_conge_refanne_foreign` (`refAnne`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_correspondance`
--

DROP TABLE IF EXISTS `tperso_correspondance`;
CREATE TABLE IF NOT EXISTS `tperso_correspondance` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `objet` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `messages` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Attente',
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_correspondance_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_correspondance`
--

INSERT INTO `tperso_correspondance` (`id`, `user_id`, `objet`, `messages`, `statut`, `author`, `created_at`, `updated_at`) VALUES
(1, 4, 'dd', 'bbb', 'Attente', 'KAKULE JEAN', '2024-08-02 05:03:12', '2024-08-02 05:03:12'),
(2, 4, 'Demande de conge', 'Demande de coge', 'Accordé', 'KAKULE JEAN', '2024-08-02 09:51:09', '2024-08-02 09:54:29');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_demandeconge`
--

DROP TABLE IF EXISTS `tperso_demandeconge`;
CREATE TABLE IF NOT EXISTS `tperso_demandeconge` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `affectation_id` bigint(20) UNSIGNED NOT NULL,
  `typecircintance_id` bigint(20) UNSIGNED NOT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `description_conge` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_demande` date NOT NULL,
  `date_depart` date NOT NULL,
  `nbr_joursollicite` int(11) NOT NULL,
  `date_reprise` date NOT NULL,
  `superviseur_conge` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `interimaire_conge` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resumetache_conge` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_fin_conge` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rh_conge` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coordinateur_conge` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `directeur_conge` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `congess` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `date_debut_accord` date NOT NULL,
  `date_fin_accord` date NOT NULL,
  `nbr_jouraccord` int(11) NOT NULL DEFAULT '0',
  `cumul_conge_annee` int(11) NOT NULL DEFAULT '0',
  `solde_conge_datedu` int(11) NOT NULL DEFAULT '0',
  `solde_conge_reprise` int(11) NOT NULL DEFAULT '0',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_demandeconge_affectation_id_foreign` (`affectation_id`),
  KEY `tperso_demandeconge_typecircintance_id_foreign` (`typecircintance_id`),
  KEY `tperso_demandeconge_annee_id_foreign` (`annee_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_demande_soin`
--

DROP TABLE IF EXISTS `tperso_demande_soin`;
CREATE TABLE IF NOT EXISTS `tperso_demande_soin` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refAffectation` bigint(20) UNSIGNED NOT NULL,
  `refMois` int(11) NOT NULL DEFAULT '1',
  `refAnnee` int(11) NOT NULL DEFAULT '1',
  `malade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `datenaissance` date NOT NULL,
  `degreparente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `medecinConsultant` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `divRH` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `AG` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateDemande` date NOT NULL,
  `factures` double NOT NULL DEFAULT '0',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_demande_soin_refaffectation_foreign` (`refAffectation`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_demande_soin`
--

INSERT INTO `tperso_demande_soin` (`id`, `refAffectation`, `refMois`, `refAnnee`, `malade`, `sexe`, `datenaissance`, `degreparente`, `medecinConsultant`, `divRH`, `AG`, `dateDemande`, `factures`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 'ACHILE', 'Homme', '2024-07-11', 'ENFANT', 'RACHEL UYERA', 'RACHEL UYERA', 'RACHEL UYERA', '2024-07-11', 20, 'administrateur', 'NON', 'user', '2024-07-10 20:53:37', '2024-07-10 20:53:37');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_dependant`
--

DROP TABLE IF EXISTS `tperso_dependant`;
CREATE TABLE IF NOT EXISTS `tperso_dependant` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `noms_dependant` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `refAgent` bigint(20) UNSIGNED NOT NULL,
  `sexe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_civile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `degre_parente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `annexe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_dependant_refagent_foreign` (`refAgent`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_dependant`
--

INSERT INTO `tperso_dependant` (`id`, `noms_dependant`, `refAgent`, `sexe`, `date_naissance`, `etat_civile`, `degre_parente`, `annexe`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 'KAKULE ACHILE', 1, 'Homme', '2008-12-31', 'Célibataire', 'ENFANT', 'avatar.png', '', 'NON', 'user', '2024-06-26 04:59:52', '2024-06-26 04:59:52');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_detail_affectation_ribrique`
--

DROP TABLE IF EXISTS `tperso_detail_affectation_ribrique`;
CREATE TABLE IF NOT EXISTS `tperso_detail_affectation_ribrique` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refAffectation` bigint(20) UNSIGNED NOT NULL,
  `refParametre` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_detail_affectation_ribrique_refaffectation_foreign` (`refAffectation`),
  KEY `tperso_detail_affectation_ribrique_refparametre_foreign` (`refParametre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_detail_paiement_sal`
--

DROP TABLE IF EXISTS `tperso_detail_paiement_sal`;
CREATE TABLE IF NOT EXISTS `tperso_detail_paiement_sal` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEntetePaie` bigint(20) UNSIGNED NOT NULL,
  `refDetailAffectRibrique` bigint(20) UNSIGNED NOT NULL,
  `taux` double NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_detail_paiement_sal_refentetepaie_foreign` (`refEntetePaie`),
  KEY `tperso_detail_paiement_sal_refdetailaffectribrique_foreign` (`refDetailAffectRibrique`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_detail_paie_salaire`
--

DROP TABLE IF EXISTS `tperso_detail_paie_salaire`;
CREATE TABLE IF NOT EXISTS `tperso_detail_paie_salaire` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refFichePaie` bigint(20) UNSIGNED NOT NULL,
  `refAffectation` bigint(20) UNSIGNED NOT NULL,
  `salaire_base_paie` double NOT NULL DEFAULT '0',
  `fammiliale_paie` double NOT NULL DEFAULT '0',
  `logement_paie` double NOT NULL DEFAULT '0',
  `transport_paie` double NOT NULL DEFAULT '0',
  `sal_brut_paie` double NOT NULL DEFAULT '0',
  `sal_brut_imposable_paie` double NOT NULL DEFAULT '0',
  `inss_qpo_paie` double NOT NULL DEFAULT '0',
  `inss_qpp_paie` double NOT NULL DEFAULT '0',
  `cnss_paie` double NOT NULL DEFAULT '0',
  `inpp_paie` double NOT NULL DEFAULT '0',
  `onem_paie` double NOT NULL DEFAULT '0',
  `ipr_paie` double NOT NULL DEFAULT '0',
  `avance_paie` double NOT NULL DEFAULT '0',
  `soins_paie` double NOT NULL DEFAULT '0',
  `jourpreste_paie` double NOT NULL DEFAULT '0',
  `salaire_horaire` double NOT NULL DEFAULT '0',
  `heure_supp1_paie` double NOT NULL DEFAULT '0',
  `heure_supp2_paie` double NOT NULL DEFAULT '0',
  `heure_supp3_paie` double NOT NULL DEFAULT '0',
  `assurances_paie` double NOT NULL DEFAULT '0',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_detail_paie_salaire_reffichepaie_foreign` (`refFichePaie`),
  KEY `tperso_detail_paie_salaire_refaffectation_foreign` (`refAffectation`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_detail_paie_salaire`
--

INSERT INTO `tperso_detail_paie_salaire` (`id`, `refFichePaie`, `refAffectation`, `salaire_base_paie`, `fammiliale_paie`, `logement_paie`, `transport_paie`, `sal_brut_paie`, `sal_brut_imposable_paie`, `inss_qpo_paie`, `inss_qpp_paie`, `cnss_paie`, `inpp_paie`, `onem_paie`, `ipr_paie`, `avance_paie`, `soins_paie`, `jourpreste_paie`, `salaire_horaire`, `heure_supp1_paie`, `heure_supp2_paie`, `heure_supp3_paie`, `assurances_paie`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1052.25, 5, 315.675, 176, 1548.925, 1004.6375, 52.6125, 136.7925, 189.405, 21.045, 2.1045, 139.175625, 0, 0, 0, 0, 0, 0, 0, 0, 'administrateur', 'NON', 'user', '2024-07-04 09:00:28', '2024-07-04 09:00:28'),
(2, 1, 2, 150, 0, 45, 176, 371, 142.5, 7.5, 19.5, 27, 3, 0.3, 9.855, 0, 0, 0, 0, 0, 0, 0, 0, 'administrateur', 'NON', 'user', '2024-07-04 09:00:28', '2024-07-04 09:00:28'),
(3, 1, 3, 150, 0, 45, 110, 305, 142.5, 7.5, 19.5, 27, 3, 0.3, 9.855, 0, 0, 0, 0, 0, 0, 0, 0, 'administrateur', 'NON', 'user', '2024-07-04 09:00:28', '2024-07-04 09:00:28'),
(4, 2, 1, 1052.25, 5, 315.675, 176, 1548.925, 1004.6375, 52.6125, 136.7925, 189.405, 21.045, 2.1045, 139.175625, 0, 0, 0, 0, 0, 0, 0, 0, 'administrateur', 'NON', 'user', '2024-07-09 05:25:40', '2024-07-09 05:25:40'),
(5, 2, 2, 150, 0, 45, 176, 371, 142.5, 7.5, 19.5, 27, 3, 0.3, 9.855, 0, 0, 0, 0, 0, 0, 0, 0, 'administrateur', 'NON', 'user', '2024-07-09 05:25:40', '2024-07-09 05:25:40'),
(6, 2, 3, 150, 0, 45, 110, 305, 142.5, 7.5, 19.5, 27, 3, 0.3, 9.855, 0, 0, 0, 0, 0, 0, 0, 0, 'administrateur', 'NON', 'user', '2024-07-09 05:25:40', '2024-07-09 05:25:40'),
(7, 3, 1, 1052.25, 5, 315.675, 176, 1548.925, 1004.6375, 52.6125, 136.7925, 189.405, 21.045, 2.1045, 139.175625, 0, 0, 0, 0, 0, 0, 0, 0, 'administrateur', 'NON', 'user', '2024-07-09 07:33:32', '2024-07-09 07:33:32'),
(8, 3, 2, 150, 0, 45, 176, 371, 142.5, 7.5, 19.5, 27, 3, 0.3, 9.855, 0, 0, 0, 0, 0, 0, 0, 0, 'administrateur', 'NON', 'user', '2024-07-09 07:33:32', '2024-07-09 07:33:32'),
(9, 3, 3, 250, 0, 75, 110, 435, 237.5, 12.5, 32.5, 45, 5, 0.5, 24.105, 0, 0, 0, 0, 0, 0, 0, 0, 'administrateur', 'NON', 'user', '2024-07-09 07:33:32', '2024-07-10 12:47:29'),
(10, 4, 1, 1052.25, 5, 315.675, 176, 1548.925, 1004.6375, 52.6125, 136.7925, 189.405, 21.045, 2.1045, 139.175625, 30, 20, 0, 0, 0, 0, 0, 15.78375, 'administrateur', 'NON', 'user', '2024-07-10 21:06:43', '2024-07-10 21:06:43'),
(11, 5, 1, 1052.25, 5, 315.675, 176, 1548.925, 1004.6375, 52.6125, 136.7925, 189.405, 21.045, 2.1045, 139.175625, 30, 20, 0, 0, 0, 0, 0, 15.78375, 'administrateur', 'NON', 'user', '2024-07-10 21:22:00', '2024-07-10 21:22:00'),
(12, 6, 1, 1052.25, 5, 315.675, 176, 1548.925, 1004.6375, 52.6125, 136.7925, 189.405, 21.045, 2.1045, 139.175625, 0, 0, 0, 0, 0, 0, 0, 15.78375, 'administrateur', 'NON', 'user', '2024-07-11 17:42:48', '2024-07-11 17:42:48'),
(13, 6, 2, 150, 0, 45, 176, 371, 142.5, 7.5, 19.5, 27, 3, 0.3, 9.855, 0, 0, 0, 0, 0, 0, 0, 2.25, 'administrateur', 'NON', 'user', '2024-07-11 17:42:48', '2024-07-11 17:42:48'),
(14, 6, 3, 150, 0, 45, 110, 305, 142.5, 7.5, 19.5, 27, 3, 0.3, 9.855, 0, 0, 0, 0, 0, 0, 0, 2.25, 'administrateur', 'NON', 'user', '2024-07-11 17:42:48', '2024-07-11 17:42:48'),
(15, 7, 1, 1052.25, 5, 315.675, 176, 1548.925, 1004.6375, 52.6125, 136.7925, 189.405, 21.045, 2.1045, 139.175625, 0, 0, 0, 0, 0, 0, 0, 15.78375, 'administrateur', 'NON', 'user', '2024-07-11 17:45:00', '2024-07-11 17:45:00'),
(16, 7, 2, 150, 0, 45, 176, 371, 142.5, 7.5, 19.5, 27, 3, 0.3, 9.855, 0, 0, 0, 0, 0, 0, 0, 2.25, 'administrateur', 'NON', 'user', '2024-07-11 17:45:00', '2024-07-11 17:45:00'),
(17, 7, 3, 200, 0, 60, 110, 370, 190, 10, 26, 36, 4, 0.4, 16.98, 0, 0, 0, 0, 0, 0, 0, 3, 'administrateur', 'NON', 'user', '2024-07-11 17:45:00', '2024-07-11 17:47:24'),
(18, 8, 1, 1052.25, 5, 315.675, 176, 1548.925, 1004.6375, 52.6125, 136.7925, 189.405, 21.045, 2.1045, 139.175625, 0, 0, 0, 0, 0, 0, 0, 15.78375, 'administrateur', 'NON', 'user', '2024-07-30 07:26:15', '2024-07-30 07:26:15'),
(19, 8, 2, 150, 0, 45, 176, 371, 142.5, 7.5, 19.5, 27, 3, 0.3, 9.855, 0, 0, 0, 0, 0, 0, 0, 2.25, 'administrateur', 'NON', 'user', '2024-07-30 07:26:16', '2024-07-30 07:26:16'),
(20, 8, 3, 150, 0, 45, 110, 305, 142.5, 7.5, 19.5, 27, 3, 0.3, 9.855, 0, 0, 0, 0, 0, 0, 0, 2.25, 'administrateur', 'NON', 'user', '2024-07-30 07:26:16', '2024-07-30 07:26:16');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_division`
--

DROP TABLE IF EXISTS `tperso_division`;
CREATE TABLE IF NOT EXISTS `tperso_division` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_division` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_division` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_division`
--

INSERT INTO `tperso_division` (`id`, `name_division`, `description_division`, `author`, `created_at`, `updated_at`) VALUES
(1, 'ADMINISTRATION', 'ADMINISTRATION', 'administrateur', '2024-05-28 10:30:42', '2024-05-28 10:30:42'),
(2, 'TECHNIQUE', 'TECHNIQUE', 'administrateur', '2024-05-28 10:31:00', '2024-05-28 10:31:00');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_domaine_stage`
--

DROP TABLE IF EXISTS `tperso_domaine_stage`;
CREATE TABLE IF NOT EXISTS `tperso_domaine_stage` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_domaine` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_domaine_stage`
--

INSERT INTO `tperso_domaine_stage` (`id`, `name_domaine`, `author`, `created_at`, `updated_at`) VALUES
(1, 'DOMAINE INFORMATIQUE', 'administrateur', '2024-05-28 10:47:16', '2024-05-28 10:47:16'),
(2, 'DOMAINE D\"ENVIRONNEMENT', 'administrateur', '2024-05-28 10:47:36', '2024-05-28 10:47:36');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_enmission`
--

DROP TABLE IF EXISTS `tperso_enmission`;
CREATE TABLE IF NOT EXISTS `tperso_enmission` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `affectation_id` bigint(20) UNSIGNED NOT NULL,
  `date_depart` date NOT NULL,
  `date_retour` date NOT NULL,
  `objets` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `autres_details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_enmission_affectation_id_foreign` (`affectation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_entete_conge`
--

DROP TABLE IF EXISTS `tperso_entete_conge`;
CREATE TABLE IF NOT EXISTS `tperso_entete_conge` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refAffectation` bigint(20) UNSIGNED NOT NULL,
  `refAnne` bigint(20) UNSIGNED NOT NULL,
  `dateJourAbsent` date NOT NULL,
  `dateDernierJour` date NOT NULL,
  `dateRetour` date NOT NULL,
  `controle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remplacement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `chefService` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hierarchie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_entete_conge_refaffectation_foreign` (`refAffectation`),
  KEY `tperso_entete_conge_refanne_foreign` (`refAnne`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_entete_paiement`
--

DROP TABLE IF EXISTS `tperso_entete_paiement`;
CREATE TABLE IF NOT EXISTS `tperso_entete_paiement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refFichePaie` bigint(20) UNSIGNED NOT NULL,
  `refAffectation` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_entete_paiement_reffichepaie_foreign` (`refFichePaie`),
  KEY `tperso_entete_paiement_refaffectation_foreign` (`refAffectation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_fiche_paie`
--

DROP TABLE IF EXISTS `tperso_fiche_paie`;
CREATE TABLE IF NOT EXISTS `tperso_fiche_paie` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dateFiche` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `refMois` bigint(20) UNSIGNED NOT NULL,
  `refAnne` bigint(20) UNSIGNED NOT NULL,
  `refBanque` bigint(20) UNSIGNED NOT NULL,
  `modepaie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_fiche_paie_refmois_foreign` (`refMois`),
  KEY `tperso_fiche_paie_refanne_foreign` (`refAnne`),
  KEY `tperso_fiche_paie_refbanque_foreign` (`refBanque`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_fiche_paie`
--

INSERT INTO `tperso_fiche_paie` (`id`, `dateFiche`, `refMois`, `refAnne`, `refBanque`, `modepaie`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, '2024-07-04', 1, 1, 1, 'CASH', 'administrateur', 'NON', 'user', '2024-07-04 09:00:28', '2024-07-04 09:00:28'),
(2, '2024-07-09', 2, 1, 1, 'CASH', 'administrateur', 'NON', 'user', '2024-07-09 05:25:39', '2024-07-09 05:25:39'),
(3, '2024-07-09', 3, 1, 2, 'BANQUE', 'administrateur', 'NON', 'user', '2024-07-09 07:33:32', '2024-07-09 07:33:32'),
(6, '2024-07-11', 5, 1, 2, 'BANQUE', 'administrateur', 'NON', 'user', '2024-07-11 17:42:48', '2024-07-11 17:42:48'),
(5, '2024-07-10', 4, 1, 2, 'BANQUE', 'administrateur', 'NON', 'user', '2024-07-10 21:22:00', '2024-07-10 21:22:00'),
(7, '2024-07-11', 6, 1, 2, 'BANQUE', 'administrateur', 'NON', 'user', '2024-07-11 17:45:00', '2024-07-11 17:45:00'),
(8, '2024-07-30', 7, 1, 2, 'BANQUE', 'administrateur', 'NON', 'user', '2024-07-30 07:26:15', '2024-07-30 07:26:15');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_heure_travail`
--

DROP TABLE IF EXISTS `tperso_heure_travail`;
CREATE TABLE IF NOT EXISTS `tperso_heure_travail` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `heure_debut` timestamp NOT NULL,
  `heure_fin` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_heure_travail`
--

INSERT INTO `tperso_heure_travail` (`id`, `heure_debut`, `heure_fin`, `created_at`, `updated_at`) VALUES
(1, '2024-01-01 07:00:00', '2024-12-31 15:00:00', '2024-01-01 07:00:00', '2024-12-31 15:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_institution_stage`
--

DROP TABLE IF EXISTS `tperso_institution_stage`;
CREATE TABLE IF NOT EXISTS `tperso_institution_stage` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_institution` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse_institution` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_institution` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_institution` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_institution_stage`
--

INSERT INTO `tperso_institution_stage` (`id`, `name_institution`, `adresse_institution`, `contact_institution`, `mail_institution`, `author`, `created_at`, `updated_at`) VALUES
(1, 'ISIG-GOMA', 'Q.MURARA', '0992992063', 'info@isig.ac.cd', 'administrateur', '2024-05-28 11:01:50', '2024-05-28 11:01:50'),
(2, 'ISC-GOMA', 'LE VOLCAN', '0990000000', 'isc@gmail.com', 'administrateur', '2024-05-28 11:02:26', '2024-05-28 11:02:26');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_lieuaffectation`
--

DROP TABLE IF EXISTS `tperso_lieuaffectation`;
CREATE TABLE IF NOT EXISTS `tperso_lieuaffectation` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_lieu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_lieu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_lieuaffectation`
--

INSERT INTO `tperso_lieuaffectation` (`id`, `nom_lieu`, `description_lieu`, `created_at`, `updated_at`) VALUES
(1, 'GOMA', 'GOMA', '2024-05-26 13:43:54', '2024-05-26 13:43:54'),
(2, 'SAKE', 'SAKE', '2024-05-26 13:45:11', '2024-05-26 13:45:11'),
(3, 'RUTSHURU', 'RUTSHURU', '2024-05-26 13:45:52', '2024-05-26 13:45:52');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_livrables`
--

DROP TABLE IF EXISTS `tperso_livrables`;
CREATE TABLE IF NOT EXISTS `tperso_livrables` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `activite_id` bigint(20) UNSIGNED NOT NULL,
  `designation_livrable` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_livrable` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fichiers` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_livrable` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_livrables_activite_id_foreign` (`activite_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_livrables`
--

INSERT INTO `tperso_livrables` (`id`, `activite_id`, `designation_livrable`, `description_livrable`, `fichiers`, `statut_livrable`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 'TACHE1 FINISH', 'TACHE1 FINISH', '1716898174.jpg', 'NON', '', '2024-05-28 10:09:34', '2024-05-28 10:09:34');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_maladie_conge`
--

DROP TABLE IF EXISTS `tperso_maladie_conge`;
CREATE TABLE IF NOT EXISTS `tperso_maladie_conge` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteConge` bigint(20) UNSIGNED NOT NULL,
  `autreDetail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `annexeMalade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_maladie_conge_refenteteconge_foreign` (`refEnteteConge`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_maternite`
--

DROP TABLE IF EXISTS `tperso_maternite`;
CREATE TABLE IF NOT EXISTS `tperso_maternite` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteConge` bigint(20) UNSIGNED NOT NULL,
  `dateAccouchement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `modeAccouchement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `autresDetail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `annexeMaternite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_maternite_refenteteconge_foreign` (`refEnteteConge`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_mois`
--

DROP TABLE IF EXISTS `tperso_mois`;
CREATE TABLE IF NOT EXISTS `tperso_mois` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_mois` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_mois`
--

INSERT INTO `tperso_mois` (`id`, `name_mois`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 'JANVIER', 'NON', 'user', NULL, NULL),
(2, 'FEVRIER', 'NON', 'user', NULL, NULL),
(3, 'MARS', 'NON', 'user', NULL, NULL),
(4, 'AVRIL', 'NON', 'user', NULL, NULL),
(5, 'MAI', 'NON', 'user', NULL, NULL),
(6, 'JUIN', 'NON', 'user', NULL, NULL),
(7, 'JUILLET', 'NON', 'user', NULL, NULL),
(8, 'AOUT', 'NON', 'user', NULL, NULL),
(9, 'SEPTEMBRE', 'NON', 'user', NULL, NULL),
(10, 'OCTOBRE', 'NON', 'user', NULL, NULL),
(11, 'NOVEMBRE', 'NON', 'user', NULL, NULL),
(12, 'DECMBRE', 'NON', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tperso_mutuelle`
--

DROP TABLE IF EXISTS `tperso_mutuelle`;
CREATE TABLE IF NOT EXISTS `tperso_mutuelle` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_mutuelle` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_mutuelle` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_mutuelle`
--

INSERT INTO `tperso_mutuelle` (`id`, `nom_mutuelle`, `description_mutuelle`, `created_at`, `updated_at`) VALUES
(1, 'KINGO', 'KINGO', '2024-05-26 13:43:09', '2024-05-26 13:43:09'),
(2, 'AFIA', 'AFIA', '2024-05-26 13:43:34', '2024-05-26 13:43:34');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_option_stage`
--

DROP TABLE IF EXISTS `tperso_option_stage`;
CREATE TABLE IF NOT EXISTS `tperso_option_stage` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_option` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `domaine_id` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_option_stage_domaine_id_foreign` (`domaine_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_option_stage`
--

INSERT INTO `tperso_option_stage` (`id`, `name_option`, `domaine_id`, `author`, `created_at`, `updated_at`) VALUES
(1, 'INFORMATIQUE DE GESTION', 1, 'administrateur', '2024-05-28 10:56:55', '2024-05-28 10:56:55'),
(2, 'RESEAU ET TELECOMMUNICATION', 1, 'administrateur', '2024-05-28 10:58:11', '2024-05-28 10:58:11');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_paie_projet`
--

DROP TABLE IF EXISTS `tperso_paie_projet`;
CREATE TABLE IF NOT EXISTS `tperso_paie_projet` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `activite_id` bigint(20) UNSIGNED NOT NULL,
  `montant_projet` double NOT NULL,
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_paie_projet_activite_id_foreign` (`activite_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_paie_projet`
--

INSERT INTO `tperso_paie_projet` (`id`, `activite_id`, `montant_projet`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 1000, 'administrateur', '2024-05-28 10:23:10', '2024-05-28 10:23:10');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_parametre_rubrique`
--

DROP TABLE IF EXISTS `tperso_parametre_rubrique`;
CREATE TABLE IF NOT EXISTS `tperso_parametre_rubrique` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refRubrique` bigint(20) UNSIGNED NOT NULL,
  `refCategorieAgent` bigint(20) UNSIGNED NOT NULL,
  `montant` double NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_parametre_rubrique_refrubrique_foreign` (`refRubrique`),
  KEY `tperso_parametre_rubrique_refcategorieagent_foreign` (`refCategorieAgent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_parametre_salairebase`
--

DROP TABLE IF EXISTS `tperso_parametre_salairebase`;
CREATE TABLE IF NOT EXISTS `tperso_parametre_salairebase` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categorie_id` bigint(20) UNSIGNED NOT NULL,
  `projet_id` bigint(20) UNSIGNED NOT NULL,
  `salaire_base` double NOT NULL,
  `salaire_prevu` double NOT NULL DEFAULT '0',
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_parametre_salairebase_categorie_id_foreign` (`categorie_id`),
  KEY `tperso_parametre_salairebase_projet_id_foreign` (`projet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_parametre_salairebase`
--

INSERT INTO `tperso_parametre_salairebase` (`id`, `categorie_id`, `projet_id`, `salaire_base`, `salaire_prevu`, `author`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1052.25, 0, 'administrateur', '2024-07-04 07:28:03', '2024-07-04 07:28:03'),
(2, 2, 2, 600, 0, 'administrateur', '2024-07-04 07:32:23', '2024-07-04 07:32:23'),
(3, 1, 1, 4000, 0, 'administrateur', '2024-07-04 07:32:43', '2024-07-04 07:32:43'),
(4, 1, 2, 150, 0, 'administrateur', '2024-07-04 07:32:58', '2024-07-04 07:32:58'),
(6, 71, 1, 3, 2, 'KAKULE JEAN', '2024-09-26 06:43:15', '2024-09-26 06:43:15');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_parcours_stage`
--

DROP TABLE IF EXISTS `tperso_parcours_stage`;
CREATE TABLE IF NOT EXISTS `tperso_parcours_stage` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `stage_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `date_debut_parcours` date NOT NULL,
  `date_fin_parcours` date NOT NULL,
  `tache_parcours` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apprecition_parcours` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_parcours_stage_stage_id_foreign` (`stage_id`),
  KEY `tperso_parcours_stage_service_id_foreign` (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_parcours_stage`
--

INSERT INTO `tperso_parcours_stage` (`id`, `stage_id`, `service_id`, `date_debut_parcours`, `date_fin_parcours`, `tache_parcours`, `apprecition_parcours`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-05-20', '2024-06-05', 'xxx', 'xxx', 'administrateur', '2024-05-28 11:17:01', '2024-05-28 11:17:01');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_partenaire`
--

DROP TABLE IF EXISTS `tperso_partenaire`;
CREATE TABLE IF NOT EXISTS `tperso_partenaire` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_org` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse_org` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_org` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_org` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rccm_org` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idnat_org` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_partenaire`
--

INSERT INTO `tperso_partenaire` (`id`, `nom_org`, `adresse_org`, `contact_org`, `mail_org`, `rccm_org`, `idnat_org`, `author`, `photo`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 'GOUVERNEMENT', 'GONGO', '0992992063', 'gouvernement@gmail.com', '0000', '0000', '', 'avatar.png', 'NON', 'user', '2024-07-04 06:31:14', '2024-07-04 06:31:14'),
(2, 'CARITAS', 'CARITAS', '0992992063', 'caritas@gmail.com', '000', '000', '', 'avatar.png', 'NON', 'user', '2024-07-09 03:51:55', '2024-07-09 03:51:55');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_poste`
--

DROP TABLE IF EXISTS `tperso_poste`;
CREATE TABLE IF NOT EXISTS `tperso_poste` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_poste` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_poste` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transport` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_poste`
--

INSERT INTO `tperso_poste` (`id`, `nom_poste`, `description_poste`, `transport`, `created_at`, `updated_at`) VALUES
(5, 'ASS. PSYCOSOCIAL (E)', 'ASS. PSYCOSOCIAL (E)', 0, '2004-07-24 07:36:00', '2004-07-24 07:36:00'),
(4, 'CAISSIERE', 'CAISSIERE', 0, '2004-07-24 07:36:00', '2004-07-24 07:36:00'),
(6, 'SUPERVISEUR', 'SUPERVISEUR', 0, '2005-07-24 07:36:00', '2005-07-24 07:36:00'),
(7, 'NUTRITIONNISTE', 'NUTRITIONNISTE', 0, '2006-07-24 07:36:00', '2006-07-24 07:36:00'),
(8, 'CHARGE (E) DE PROTECTION', 'CHARGE (E) DE PROTECTION', 0, '2007-07-24 07:36:00', '2007-07-24 07:36:00'),
(9, 'RENFORCEMENT DES CAPACITES', 'RENFORCEMENT DES CAPACITES', 0, '2008-07-24 07:36:00', '2008-07-24 07:36:00'),
(10, 'Ir AGRONOME', 'Ir AGRONOME', 0, '2009-07-24 07:36:00', '2009-07-24 07:36:00'),
(11, 'ANIMATEUR (TRICE) AGRICOLE', 'ANIMATEUR (TRICE) AGRICOLE', 0, '2010-07-24 07:36:00', '2010-07-24 07:36:00'),
(12, 'CHAUFFEUR', 'CHAUFFEUR', 0, '2011-07-24 07:36:00', '2011-07-24 07:36:00'),
(13, 'PROGRAM MANAGER', 'PROGRAM MANAGER', 0, '2012-07-24 07:36:00', '2012-07-24 07:36:00'),
(14, 'CHEF DU PERSONNEL', 'CHEF DU PERSONNEL', 0, '2013-07-24 07:36:00', '2013-07-24 07:36:00'),
(15, 'INSECT TECHNICIAN ASSISTANT', 'INSECT TECHNICIAN ASSISTANT', 0, '2014-07-24 07:36:00', '2014-07-24 07:36:00'),
(16, 'PROMOTEUR DE SANTE', 'PROMOTEUR DE SANTE', 0, '2015-07-24 07:36:00', '2015-07-24 07:36:00'),
(17, 'RECEPTIONNISTE', 'RECEPTIONNISTE', 0, '2016-07-24 07:36:00', '2016-07-24 07:36:00'),
(18, 'SENTINELLE', 'SENTINELLE', 0, '2017-07-24 07:36:00', '2017-07-24 07:36:00'),
(19, 'CLEANER', 'CLEANER', 0, '2018-07-24 07:36:00', '2018-07-24 07:36:00'),
(20, 'CHARGEE DES ACHATS', 'CHARGEE DES ACHATS', 0, '2019-07-24 07:36:00', '2019-07-24 07:36:00'),
(21, 'AGENT TERRAIN', 'AGENT TERRAIN', 0, '2020-07-24 07:36:00', '2020-07-24 07:36:00'),
(22, 'OFFICIER SECAL', 'OFFICIER SECAL', 0, '2021-07-24 07:36:00', '2021-07-24 07:36:00'),
(23, 'SUPERVISEUR DE NUTRITION', 'SUPERVISEUR DE NUTRITION', 0, '2022-07-24 07:36:00', '2022-07-24 07:36:00'),
(24, 'SUPERVISEUR WASH', 'SUPERVISEUR WASH', 0, '2023-07-24 07:36:00', '2023-07-24 07:36:00'),
(25, 'COORDO', 'COORDO', 0, '2024-07-24 07:36:00', '2024-07-24 07:36:00'),
(26, 'ASSISTANT COORDO', 'ASSISTANT COORDO', 0, '2025-07-24 07:36:00', '2025-07-24 07:36:00'),
(27, 'SUPERVISEUR SSP', 'SUPERVISEUR SSP', 0, '2026-07-24 07:36:00', '2026-07-24 07:36:00'),
(28, 'SECRETAIRE', 'SECRETAIRE', 0, '2027-07-24 07:36:00', '2027-07-24 07:36:00'),
(29, 'ASS. A LA COMMUNICATION', 'ASS. A LA COMMUNICATION', 0, '2028-07-24 07:36:00', '2028-07-24 07:36:00'),
(30, 'CHARGE (E) DE COMMUNICATION', 'CHARGE (E) DE COMMUNICATION', 0, '2029-07-24 07:36:00', '2029-07-24 07:36:00'),
(31, 'OFFICIER DE SECURITE', 'OFFICIER DE SECURITE', 0, '2030-07-24 07:36:00', '2030-07-24 07:36:00'),
(32, 'RELATIONS PUBLIQUES', 'RELATIONS PUBLIQUES', 0, '2031-07-24 07:36:00', '2031-07-24 07:36:00'),
(33, 'LOGISTICIEN(NE)', 'LOGISTICIEN(NE)', 0, '2001-08-24 07:36:00', '2001-08-24 07:36:00'),
(34, 'AGENT PAYEUR', 'AGENT PAYEUR', 0, '2002-08-24 07:36:00', '2002-08-24 07:36:00'),
(35, 'AIDE MECANICIEN', 'AIDE MECANICIEN', 0, '2003-08-24 07:36:00', '2003-08-24 07:36:00'),
(36, 'SUIVI ET EVALUATION', 'SUIVI ET EVALUATION', 0, '2004-08-24 07:36:00', '2004-08-24 07:36:00'),
(37, 'MAGASINIERE', 'MAGASINIERE', 0, '2005-08-24 07:36:00', '2005-08-24 07:36:00'),
(38, 'CHEF MECANICIEN', 'CHEF MECANICIEN', 0, '2006-08-24 07:36:00', '2006-08-24 07:36:00'),
(39, 'COORDO BPD_UP RUTSHURU', 'COORDO BPD_UP RUTSHURU', 0, '2007-08-24 07:36:00', '2007-08-24 07:36:00'),
(40, 'MECANICIEN', 'MECANICIEN', 0, '2008-08-24 07:36:00', '2008-08-24 07:36:00'),
(41, 'DEPENSES DE TERRAIN', 'DEPENSES DE TERRAIN', 0, '2009-08-24 07:36:00', '2009-08-24 07:36:00'),
(42, 'QUAL. PROGRAMME', 'QUAL. PROGRAMME', 0, '2010-08-24 07:36:00', '2010-08-24 07:36:00'),
(43, 'COORDONNATEUR DE PROJET', 'COORDONNATEUR DE PROJET', 0, '2011-08-24 07:36:00', '2011-08-24 07:36:00'),
(44, 'FIELD OFFICER', 'FIELD OFFICER', 0, '2012-08-24 07:36:00', '2012-08-24 07:36:00'),
(45, 'ASSISTANT PROGRAMME', 'ASSISTANT PROGRAMME', 0, '2013-08-24 07:36:00', '2013-08-24 07:36:00'),
(46, 'CHARGE DES BASES DES DONNEES', 'CHARGE DES BASES DES DONNEES', 0, '2014-08-24 07:36:00', '2014-08-24 07:36:00'),
(47, 'ATTACHEE AUX RH', 'ATTACHEE AUX RH', 0, '2015-08-24 07:36:00', '2015-08-24 07:36:00'),
(48, 'TRADUCTEUR', 'TRADUCTEUR', 0, '2016-08-24 07:36:00', '2016-08-24 07:36:00'),
(49, 'MRM 1612', 'MRM 1612', 0, '2017-08-24 07:36:00', '2017-08-24 07:36:00'),
(50, 'ASSISTANT TECHNIQUE', 'ASSISTANT TECHNIQUE', 0, '2018-08-24 07:36:00', '2018-08-24 07:36:00'),
(51, 'POINT FOCAL', 'POINT FOCAL', 0, '2019-08-24 07:36:00', '2019-08-24 07:36:00'),
(52, 'AUDITEUR INTERNE', 'AUDITEUR INTERNE', 0, '2020-08-24 07:36:00', '2020-08-24 07:36:00'),
(53, 'CHARGE DE REFERENCEMENT', 'CHARGE DE REFERENCEMENT', 0, '2021-08-24 07:36:00', '2021-08-24 07:36:00'),
(54, 'RESPONSABLE DES AVEC', 'RESPONSABLE DES AVEC', 0, '2022-08-24 07:36:00', '2022-08-24 07:36:00'),
(55, 'RESPONSABLE VOLET OBC', 'RESPONSABLE VOLET OBC', 0, '2023-08-24 07:36:00', '2023-08-24 07:36:00'),
(56, 'RESPONSABLET VOLET PSYCHOSOCIAL', 'RESPONSABLET VOLET PSYCHOSOCIAL', 0, '2024-08-24 07:36:00', '2024-08-24 07:36:00'),
(57, 'ASS. COORDO PROJET', 'ASS. COORDO PROJET', 0, '2025-08-24 07:36:00', '2025-08-24 07:36:00'),
(58, 'COMPTABLE', 'COMPTABLE', 0, '2026-08-24 07:36:00', '2026-08-24 07:36:00'),
(59, 'GENRE ET PROTECTION', 'GENRE ET PROTECTION', 0, '2027-08-24 07:36:00', '2027-08-24 07:36:00'),
(60, 'CHARGE(E) DES AGRs', 'CHARGE(E) DES AGRs', 0, '2028-08-24 07:36:00', '2028-08-24 07:36:00'),
(61, 'Ir CIVIL', 'Ir CIVIL', 0, '2029-08-24 07:36:00', '2029-08-24 07:36:00'),
(62, 'ASSISTANT FINANCIER', 'ASSISTANT FINANCIER', 0, '2030-08-24 07:36:00', '2030-08-24 07:36:00'),
(63, 'OFFICIER EDE PROTECTION', 'OFFICIER EDE PROTECTION', 0, '2031-08-24 07:36:00', '2031-08-24 07:36:00'),
(64, 'OFFICIER CASH', 'OFFICIER CASH', 0, '2001-09-24 07:36:00', '2001-09-24 07:36:00'),
(65, 'ANIMATEUR(TRICE)', 'ANIMATEUR(TRICE)', 0, '2002-09-24 07:36:00', '2002-09-24 07:36:00'),
(66, 'CHARGE DES QUESTION JURIDIQUES', 'CHARGE DES QUESTION JURIDIQUES', 0, '2003-09-24 07:36:00', '2003-09-24 07:36:00'),
(67, 'CHEF DE PROJET', 'CHEF DE PROJET', 0, '2004-09-24 07:36:00', '2004-09-24 07:36:00'),
(68, 'PSYCHOLOGUE', 'PSYCHOLOGUE', 0, '2005-09-24 07:36:00', '2005-09-24 07:36:00'),
(69, 'IT', 'IT', 0, '2006-09-24 07:36:00', '2006-09-24 07:36:00'),
(70, 'CHEF COMPTABLE', 'CHEF COMPTABLE', 0, '2007-09-24 07:36:00', '2007-09-24 07:36:00'),
(71, 'ADMINISTRATRICE DES FINANCES', 'ADMINISTRATRICE DES FINANCES', 0, '2008-09-24 07:36:00', '2008-09-24 07:36:00');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_presences_agent`
--

DROP TABLE IF EXISTS `tperso_presences_agent`;
CREATE TABLE IF NOT EXISTS `tperso_presences_agent` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `affectation_id` bigint(20) UNSIGNED NOT NULL,
  `date_presence` timestamp NOT NULL,
  `date_entree` timestamp NOT NULL,
  `date_sortie` timestamp NOT NULL,
  `retard` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `justifications` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Encours',
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_presences_agent_affectation_id_foreign` (`affectation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_presences_agent`
--

INSERT INTO `tperso_presences_agent` (`id`, `affectation_id`, `date_presence`, `date_entree`, `date_sortie`, `retard`, `justifications`, `author`, `created_at`, `updated_at`) VALUES
(14, 1, '2024-08-28 22:00:00', '2024-08-29 05:45:00', '2024-08-29 15:38:00', 'NON', 'Encours', 'Admin', '2024-09-16 16:21:20', '2024-09-16 16:21:20');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_presences_temp`
--

DROP TABLE IF EXISTS `tperso_presences_temp`;
CREATE TABLE IF NOT EXISTS `tperso_presences_temp` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `affectation_id` bigint(20) UNSIGNED NOT NULL,
  `date_presence` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_entree` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_sortie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `retard` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `justifications` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Encours',
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_presences_temp_affectation_id_foreign` (`affectation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=166 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_projets`
--

DROP TABLE IF EXISTS `tperso_projets`;
CREATE TABLE IF NOT EXISTS `tperso_projets` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `partenaire_id` bigint(20) UNSIGNED NOT NULL,
  `typecontrat_id` bigint(20) UNSIGNED NOT NULL,
  `description_projet` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `chef_projet` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut_projet` date NOT NULL,
  `duree_projet` int(11) NOT NULL,
  `date_fin_projet` date NOT NULL,
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_projets_partenaire_id_foreign` (`partenaire_id`),
  KEY `tperso_projets_typecontrat_id_foreign` (`typecontrat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_projets`
--

INSERT INTO `tperso_projets` (`id`, `partenaire_id`, `typecontrat_id`, `description_projet`, `chef_projet`, `date_debut_projet`, `duree_projet`, `date_fin_projet`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'VIVRE AUX DEPLACES', 'GOUVERNEUR', '2024-07-04', 100, '2024-10-12', 'administrateur', '2024-07-04 06:32:31', '2024-07-04 06:32:31'),
(2, 1, 1, 'DISTRIBUTION DES TELEPHONES', 'DIRECTEUR TECHNIQUE', '2024-07-04', 50, '2024-08-23', 'administrateur', '2024-07-04 06:34:58', '2024-07-04 06:34:58'),
(3, 2, 2, 'ADMINISTRATION  nnnn', 'ADMINISTRATION', '2024-07-09', 5, '2024-07-14', 'KAKULE JEAN', '2024-07-09 03:52:35', '2024-09-27 04:52:08');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_promotion_stage`
--

DROP TABLE IF EXISTS `tperso_promotion_stage`;
CREATE TABLE IF NOT EXISTS `tperso_promotion_stage` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_promotion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_promotion_stage`
--

INSERT INTO `tperso_promotion_stage` (`id`, `name_promotion`, `author`, `created_at`, `updated_at`) VALUES
(1, 'L1', 'administrateur', '2024-05-28 10:46:43', '2024-05-28 10:46:43'),
(2, 'L2', 'administrateur', '2024-05-28 10:46:50', '2024-05-28 10:46:50'),
(3, 'L3', 'administrateur', '2024-05-28 10:47:00', '2024-05-28 10:47:00');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_raison_familiale`
--

DROP TABLE IF EXISTS `tperso_raison_familiale`;
CREATE TABLE IF NOT EXISTS `tperso_raison_familiale` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_raison_famille` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_raison_familiale`
--

INSERT INTO `tperso_raison_familiale` (`id`, `name_raison_famille`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 'DEUIL', 'NON', 'user', NULL, NULL),
(2, 'ACCIDENT', 'NON', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tperso_rubrique`
--

DROP TABLE IF EXISTS `tperso_rubrique`;
CREATE TABLE IF NOT EXISTS `tperso_rubrique` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refSscompte` bigint(20) UNSIGNED NOT NULL,
  `refCatRubrique` bigint(20) UNSIGNED NOT NULL,
  `name_rubrique` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_rubrique_refsscompte_foreign` (`refSscompte`),
  KEY `tperso_rubrique_refcatrubrique_foreign` (`refCatRubrique`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_service_archivage`
--

DROP TABLE IF EXISTS `tperso_service_archivage`;
CREATE TABLE IF NOT EXISTS `tperso_service_archivage` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_service` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_service` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie_id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_service_archivage_categorie_id_foreign` (`categorie_id`),
  KEY `tperso_service_archivage_division_id_foreign` (`division_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_service_archivage`
--

INSERT INTO `tperso_service_archivage` (`id`, `name_service`, `description_service`, `categorie_id`, `division_id`, `author`, `created_at`, `updated_at`) VALUES
(1, 'MAINTENANCE', 'MAINTENANCE', 2, 2, 'administrateur', '2024-05-28 10:39:22', '2024-05-28 10:39:22'),
(2, 'INFORMATIQUE', 'INFORMATIQUE', 2, 2, 'administrateur', '2024-05-28 10:39:56', '2024-05-28 10:39:56');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_service_personnel`
--

DROP TABLE IF EXISTS `tperso_service_personnel`;
CREATE TABLE IF NOT EXISTS `tperso_service_personnel` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refCatService` bigint(20) UNSIGNED NOT NULL,
  `name_serv_perso` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_service_personnel_refcatservice_foreign` (`refCatService`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_service_personnel`
--

INSERT INTO `tperso_service_personnel` (`id`, `refCatService`, `name_serv_perso`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'COMPTABILITE', 'NON', 'user', NULL, NULL),
(2, 1, 'TRESORERIE', 'NON', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tperso_sortie_agent`
--

DROP TABLE IF EXISTS `tperso_sortie_agent`;
CREATE TABLE IF NOT EXISTS `tperso_sortie_agent` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refAffectation` bigint(20) UNSIGNED NOT NULL,
  `heureSortie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `heureRetourPrevue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateSortie` date NOT NULL,
  `motif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `heureRetour` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateRetour` date NOT NULL,
  `annexeSortie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelleannexe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `viseBRH` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_sortie_agent_refaffectation_foreign` (`refAffectation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_stages`
--

DROP TABLE IF EXISTS `tperso_stages`;
CREATE TABLE IF NOT EXISTS `tperso_stages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `institution_id` bigint(20) UNSIGNED NOT NULL,
  `personnel_id` bigint(20) UNSIGNED NOT NULL,
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `typestage_id` int(11) NOT NULL DEFAULT '1',
  `date_debut_stage` date NOT NULL,
  `date_fin_stage` date NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_stages_institution_id_foreign` (`institution_id`),
  KEY `tperso_stages_personnel_id_foreign` (`personnel_id`),
  KEY `tperso_stages_option_id_foreign` (`option_id`),
  KEY `tperso_stages_promotion_id_foreign` (`promotion_id`),
  KEY `tperso_stages_annee_id_foreign` (`annee_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_stages`
--

INSERT INTO `tperso_stages` (`id`, `institution_id`, `personnel_id`, `option_id`, `promotion_id`, `annee_id`, `typestage_id`, `date_debut_stage`, `date_fin_stage`, `author`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 3, 2, 1, '2024-05-01', '2024-05-31', 'administrateur', '2024-05-28 11:03:17', '2024-05-28 11:03:17');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_timesheet`
--

DROP TABLE IF EXISTS `tperso_timesheet`;
CREATE TABLE IF NOT EXISTS `tperso_timesheet` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `affectation_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `mois_id` bigint(20) UNSIGNED NOT NULL,
  `date_tache` date NOT NULL,
  `jour_preste` int(11) NOT NULL DEFAULT '1',
  `perdieme` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activite` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `heure_debut` timestamp NOT NULL,
  `heure_fin` timestamp NOT NULL,
  `temp_preste` timestamp NOT NULL,
  `ateste_agent` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `ateste_projet` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `ateste_coordo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `ateste_rh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_timesheet_affectation_id_foreign` (`affectation_id`),
  KEY `tperso_timesheet_user_id_foreign` (`user_id`),
  KEY `tperso_timesheet_annee_id_foreign` (`annee_id`),
  KEY `tperso_timesheet_mois_id_foreign` (`mois_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_timesheet`
--

INSERT INTO `tperso_timesheet` (`id`, `affectation_id`, `user_id`, `annee_id`, `mois_id`, `date_tache`, `jour_preste`, `perdieme`, `activite`, `heure_debut`, `heure_fin`, `temp_preste`, `ateste_agent`, `ateste_projet`, `ateste_coordo`, `ateste_rh`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 1, '2024-08-08', 1, 'OUI', 'Distribution des vivres', '2024-08-08 12:43:00', '2024-08-08 14:52:00', '2024-08-08 14:52:00', 'OUI', 'OUI', 'OUI', 'NON', 'KAKULE JEAN', '2024-08-08 08:30:05', '2024-08-08 08:57:32');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_typecirconstanceconge`
--

DROP TABLE IF EXISTS `tperso_typecirconstanceconge`;
CREATE TABLE IF NOT EXISTS `tperso_typecirconstanceconge` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_circontstance` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_circons` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie_id` bigint(20) UNSIGNED NOT NULL,
  `nbrjour_cirscons` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tperso_typecirconstanceconge_categorie_id_foreign` (`categorie_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tperso_typecontrat`
--

DROP TABLE IF EXISTS `tperso_typecontrat`;
CREATE TABLE IF NOT EXISTS `tperso_typecontrat` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_contrat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_contrat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_typecontrat`
--

INSERT INTO `tperso_typecontrat` (`id`, `nom_contrat`, `code_contrat`, `created_at`, `updated_at`) VALUES
(1, 'Contrat a durée determinée', 'CDD', '2024-05-26 13:39:44', '2024-05-26 13:39:44'),
(2, 'Contrat à durée inderminée', 'CDI', '2024-05-26 13:40:53', '2024-05-26 13:40:53');

-- --------------------------------------------------------

--
-- Structure de la table `tperso_type_stage`
--

DROP TABLE IF EXISTS `tperso_type_stage`;
CREATE TABLE IF NOT EXISTS `tperso_type_stage` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_typestage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tperso_type_stage`
--

INSERT INTO `tperso_type_stage` (`id`, `name_typestage`, `author`, `created_at`, `updated_at`) VALUES
(1, 'ACADEMIQUE', 'Admin', NULL, NULL),
(2, 'PREFESSIONNEL', 'Admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `trdv_malade`
--

DROP TABLE IF EXISTS `trdv_malade`;
CREATE TABLE IF NOT EXISTS `trdv_malade` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numeroCarte` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` int(11) NOT NULL,
  `dateRDV` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `noms` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `motif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trdv_malade`
--

INSERT INTO `trdv_malade` (`id`, `numeroCarte`, `refUser`, `dateRDV`, `noms`, `contact`, `lieu`, `motif`, `statut`, `author`, `created_at`, `updated_at`) VALUES
(1, '1', 1, '2023-01-25', 'KAKULE', '+243992992063', 'HOPITAL', 'OK', 'FINI', 'glodimaley@gmail.com', '2023-01-24 23:00:00', '2023-01-24 23:00:00'),
(2, 'D20231001', 1, '2023-07-28', 'KANDOLO MULENDA', '+243992992063', 'A la structure', 'Soins medicaux', 'Encours', 'administrateur lega', '2023-07-28 06:36:27', '2023-07-28 06:36:27');

-- --------------------------------------------------------

--
-- Structure de la table `tsalon_detail_vente`
--

DROP TABLE IF EXISTS `tsalon_detail_vente`;
CREATE TABLE IF NOT EXISTS `tsalon_detail_vente` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteVente` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `puVente` double NOT NULL,
  `qteVente` double NOT NULL,
  `devise` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tsalon_detail_vente_refentetevente_foreign` (`refEnteteVente`),
  KEY `tsalon_detail_vente_refproduit_foreign` (`refProduit`),
  KEY `tsalon_detail_vente_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tsalon_entete_vente`
--

DROP TABLE IF EXISTS `tsalon_entete_vente`;
CREATE TABLE IF NOT EXISTS `tsalon_entete_vente` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refClient` bigint(20) UNSIGNED NOT NULL,
  `dateVente` date NOT NULL,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tsalon_entete_vente_refclient_foreign` (`refClient`),
  KEY `tsalon_entete_vente_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tsalon_paiement`
--

DROP TABLE IF EXISTS `tsalon_paiement`;
CREATE TABLE IF NOT EXISTS `tsalon_paiement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteVente` bigint(20) UNSIGNED NOT NULL,
  `montant_paie` double NOT NULL,
  `date_paie` date NOT NULL,
  `modepaie` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `devise` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `libellepaie` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refBanque` int(11) NOT NULL,
  `numeroBordereau` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tsalon_paiement_refentetevente_foreign` (`refEnteteVente`),
  KEY `tsalon_paiement_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tsalon_produit`
--

DROP TABLE IF EXISTS `tsalon_produit`;
CREATE TABLE IF NOT EXISTS `tsalon_produit` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pu` double NOT NULL,
  `devise` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tsalon_produit_designation_unique` (`designation`),
  KEY `tsalon_produit_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ttreso_entete_angagement`
--

DROP TABLE IF EXISTS `ttreso_entete_angagement`;
CREATE TABLE IF NOT EXISTS `ttreso_entete_angagement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refProvenance` bigint(20) UNSIGNED NOT NULL,
  `refBloc` bigint(20) UNSIGNED NOT NULL,
  `motif` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateEngagement` datetime NOT NULL,
  `dateValiderDemandeur` datetime DEFAULT NULL,
  `StatutValiderDemandeur` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ValiderDemandeur` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateValidertDivision` datetime DEFAULT NULL,
  `StatutValiderDivision` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ValiderDivision` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateAtesterDivision` datetime DEFAULT NULL,
  `StatutAtesterDivision` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Atesterterdivision` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateValiderTresorerie` datetime DEFAULT NULL,
  `ValiderStatuttresorerie` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ValiderTresorerie` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateAtesterTresorerie` datetime DEFAULT NULL,
  `StatutAtesterTresorerie` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `AtesterterTresorier` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateValiderAdministration` datetime DEFAULT NULL,
  `ValiderStatutAdministration` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ValiderAdministrateur` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateAtesterAdministration` datetime DEFAULT NULL,
  `StatutAtesterAdministration` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `AtesterterAdministrateur` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateValiderDirection` datetime DEFAULT NULL,
  `ValiderStatutDirection` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ValiderDirecteur` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateAtesterDirection` datetime DEFAULT NULL,
  `StatutAtesterDirection` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `AtesterterDirecteur` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateValidertGerant` datetime DEFAULT NULL,
  `ValiderStatutGerant` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ValiderGerant` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateAtesterGerant` datetime DEFAULT NULL,
  `StatutAtesterGerant` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `AtesterterGerant` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refEtatbesoin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ttreso_entete_angagement_refprovenance_foreign` (`refProvenance`),
  KEY `ttreso_entete_angagement_refbloc_foreign` (`refBloc`),
  KEY `ttreso_entete_angagement_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_bloc`
--

DROP TABLE IF EXISTS `tt_treso_bloc`;
CREATE TABLE IF NOT EXISTS `tt_treso_bloc` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `desiBloc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tt_treso_bloc_desibloc_unique` (`desiBloc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_categorie_rubrique`
--

DROP TABLE IF EXISTS `tt_treso_categorie_rubrique`;
CREATE TABLE IF NOT EXISTS `tt_treso_categorie_rubrique` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `NomCateRubrique` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tt_treso_categorie_rubrique_nomcaterubrique_unique` (`NomCateRubrique`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_detail_angagement`
--

DROP TABLE IF EXISTS `tt_treso_detail_angagement`;
CREATE TABLE IF NOT EXISTS `tt_treso_detail_angagement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEntete` bigint(20) UNSIGNED NOT NULL,
  `refRubrique` bigint(20) UNSIGNED NOT NULL,
  `Qte` double NOT NULL,
  `PU` double NOT NULL,
  `taux` double NOT NULL,
  `devise` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tt_treso_detail_angagement_refentete_foreign` (`refEntete`),
  KEY `tt_treso_detail_angagement_refrubrique_foreign` (`refRubrique`),
  KEY `tt_treso_detail_angagement_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_detail_etatbesoin`
--

DROP TABLE IF EXISTS `tt_treso_detail_etatbesoin`;
CREATE TABLE IF NOT EXISTS `tt_treso_detail_etatbesoin` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEntete` bigint(20) UNSIGNED NOT NULL,
  `refRubrique` bigint(20) UNSIGNED NOT NULL,
  `Qte` double NOT NULL,
  `PU` double NOT NULL,
  `taux` double NOT NULL,
  `devise` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tt_treso_detail_etatbesoin_refentete_foreign` (`refEntete`),
  KEY `tt_treso_detail_etatbesoin_refrubrique_foreign` (`refRubrique`),
  KEY `tt_treso_detail_etatbesoin_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_entete_etatbesoin`
--

DROP TABLE IF EXISTS `tt_treso_entete_etatbesoin`;
CREATE TABLE IF NOT EXISTS `tt_treso_entete_etatbesoin` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refProvenance` bigint(20) UNSIGNED NOT NULL,
  `motifDepense` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DateElaboration` datetime NOT NULL,
  `AcquitterPar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StatutAcquitterPar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DateAcquitterPar` datetime NOT NULL,
  `ApproCoordi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StatutApproCoordi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DateApproCoordi` datetime NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tt_treso_entete_etatbesoin_refprovenance_foreign` (`refProvenance`),
  KEY `tt_treso_entete_etatbesoin_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_provenance`
--

DROP TABLE IF EXISTS `tt_treso_provenance`;
CREATE TABLE IF NOT EXISTS `tt_treso_provenance` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomProvenance` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codeProvenance` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tt_treso_provenance_nomprovenance_unique` (`nomProvenance`),
  UNIQUE KEY `tt_treso_provenance_codeprovenance_unique` (`codeProvenance`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tt_treso_rubrique`
--

DROP TABLE IF EXISTS `tt_treso_rubrique`;
CREATE TABLE IF NOT EXISTS `tt_treso_rubrique` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refcateRubrik` int(11) NOT NULL,
  `desiRubriq` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codeRubriq` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tt_treso_rubrique_desirubriq_unique` (`desiRubriq`),
  UNIQUE KEY `tt_treso_rubrique_coderubriq_unique` (`codeRubriq`),
  KEY `tt_treso_rubrique_refcaterubrik_foreign` (`refcateRubrik`),
  KEY `tt_treso_rubrique_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tvente_annexe_commande`
--

DROP TABLE IF EXISTS `tvente_annexe_commande`;
CREATE TABLE IF NOT EXISTS `tvente_annexe_commande` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `noms_annexe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refCommande` bigint(20) UNSIGNED NOT NULL,
  `annexe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `author_deleted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_annexe_commande_refcommande_foreign` (`refCommande`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_annexe_commande`
--

INSERT INTO `tvente_annexe_commande` (`id`, `noms_annexe`, `refCommande`, `annexe`, `author`, `deleted`, `author_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Facture fournisseur', 0, '1729609444.png', 'KAKULE JEAN', 'NON', 'user', '2024-10-22 13:04:04', '2024-10-22 13:04:04');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_autorisation`
--

DROP TABLE IF EXISTS `tvente_autorisation`;
CREATE TABLE IF NOT EXISTS `tvente_autorisation` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `niveau` int(11) NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_autorisation_role_id_foreign` (`role_id`),
  KEY `tvente_autorisation_module_id_foreign` (`module_id`),
  KEY `tvente_autorisation_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_autorisation`
--

INSERT INTO `tvente_autorisation` (`id`, `role_id`, `module_id`, `niveau`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 'KAKULE JEAN', 4, '2024-10-05 10:00:36', '2024-10-05 10:00:36'),
(2, 3, 2, 2, 'KAKULE JEAN', 4, '2024-10-05 10:00:54', '2024-10-05 10:00:54');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_categorie_client`
--

DROP TABLE IF EXISTS `tvente_categorie_client`;
CREATE TABLE IF NOT EXISTS `tvente_categorie_client` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `compte_client` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tvente_categorie_client_designation_unique` (`designation`),
  KEY `tvente_categorie_client_compte_client_foreign` (`compte_client`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_categorie_client`
--

INSERT INTO `tvente_categorie_client` (`id`, `designation`, `compte_client`, `author`, `created_at`, `updated_at`) VALUES
(1, 'CLIENT ORDINAIRE', 3, 'KAKULE JEAN', '2024-10-20 10:11:55', '2024-10-20 10:11:55'),
(2, 'CLIENT D\'HONAIRE', 3, 'KAKULE JEAN', '2024-10-20 10:12:19', '2024-10-20 10:12:19'),
(3, 'AGENT', 3, 'KAKULE JEAN', '2024-10-20 10:12:40', '2024-10-20 10:12:40');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_categorie_fournisseur`
--

DROP TABLE IF EXISTS `tvente_categorie_fournisseur`;
CREATE TABLE IF NOT EXISTS `tvente_categorie_fournisseur` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_categoriefss` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `compte_fss_bl` bigint(20) UNSIGNED NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tvente_categorie_fournisseur_nom_categoriefss_unique` (`nom_categoriefss`),
  KEY `tvente_categorie_fournisseur_compte_fss_bl_foreign` (`compte_fss_bl`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_categorie_fournisseur`
--

INSERT INTO `tvente_categorie_fournisseur` (`id`, `code`, `nom_categoriefss`, `compte_fss_bl`, `active`, `created_at`, `updated_at`) VALUES
(1, '0000', 'Fournisseur Cuisine', 2, 'OUI', '2024-10-05 10:30:29', '2024-10-05 10:30:29'),
(2, '0000', 'Fournisseur Boisson', 2, 'OUI', '2024-10-05 10:34:35', '2024-10-05 10:34:35');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_categorie_produit`
--

DROP TABLE IF EXISTS `tvente_categorie_produit`;
CREATE TABLE IF NOT EXISTS `tvente_categorie_produit` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `compte_achat` bigint(20) UNSIGNED NOT NULL,
  `compte_vente` bigint(20) UNSIGNED NOT NULL,
  `compte_variationstock` bigint(20) UNSIGNED NOT NULL,
  `compte_perte` bigint(20) UNSIGNED NOT NULL,
  `compte_produit` bigint(20) UNSIGNED NOT NULL,
  `compte_destockage` bigint(20) UNSIGNED NOT NULL,
  `compte_stockage` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tvente_categorie_produit_designation_unique` (`designation`),
  KEY `tvente_categorie_produit_compte_achat_foreign` (`compte_achat`),
  KEY `tvente_categorie_produit_compte_vente_foreign` (`compte_vente`),
  KEY `tvente_categorie_produit_compte_variationstock_foreign` (`compte_variationstock`),
  KEY `tvente_categorie_produit_compte_perte_foreign` (`compte_perte`),
  KEY `tvente_categorie_produit_compte_produit_foreign` (`compte_produit`),
  KEY `tvente_categorie_produit_compte_destockage_foreign` (`compte_destockage`),
  KEY `tvente_categorie_produit_compte_stockage_foreign` (`compte_stockage`),
  KEY `tvente_categorie_produit_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_categorie_produit`
--

INSERT INTO `tvente_categorie_produit` (`id`, `code`, `designation`, `compte_achat`, `compte_vente`, `compte_variationstock`, `compte_perte`, `compte_produit`, `compte_destockage`, `compte_stockage`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(1, '0000', 'BOISSON', 8, 9, 7, 8, 1, 7, 7, 'KAKULE JEAN', 4, '2024-10-05 10:42:10', '2024-10-05 10:42:10'),
(2, '0000', 'NOURRITURE', 8, 9, 7, 8, 1, 7, 7, 'KAKULE JEAN', 4, '2024-10-05 10:44:16', '2024-10-05 10:44:16');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_client`
--

DROP TABLE IF EXISTS `tvente_client`;
CREATE TABLE IF NOT EXISTS `tvente_client` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refCategieClient` bigint(20) UNSIGNED NOT NULL,
  `noms` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pieceidentite` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroPiece` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateLivrePiece` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieulivraisonCarte` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationnalite` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datenaissance` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieunaissance` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profession` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `occupation` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombreEnfant` int(11) NOT NULL,
  `dateArriverGoma` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arriverPar` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tvaapplique` tinyint(1) NOT NULL DEFAULT '1',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tvente_client_noms_unique` (`noms`),
  KEY `tvente_client_refcategieclient_foreign` (`refCategieClient`),
  KEY `tvente_client_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_client`
--

INSERT INTO `tvente_client` (`id`, `refCategieClient`, `noms`, `sexe`, `contact`, `mail`, `adresse`, `pieceidentite`, `numeroPiece`, `dateLivrePiece`, `lieulivraisonCarte`, `nationnalite`, `datenaissance`, `lieunaissance`, `profession`, `occupation`, `nombreEnfant`, `dateArriverGoma`, `arriverPar`, `photo`, `slug`, `tvaapplique`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(1, 1, 'CHRISTIAN', 'Homme', '0992992063', 'christian@gmail.com', 'Goma', 'CARTE', '0001', '2000-01-01', 'Attente', 'Attente', 'Attente', 'Attente', 'Attente', 'Attente', 0, '2000-01-01', 'Atente', 'avatar.png', 'christianchristi-emutk3au', 1, 'KAKULE JEAN', 4, '2024-10-20 10:54:16', '2024-10-20 10:54:16');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_detail_commandeclient`
--

DROP TABLE IF EXISTS `tvente_detail_commandeclient`;
CREATE TABLE IF NOT EXISTS `tvente_detail_commandeclient` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteCmd` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `compte_vente` bigint(20) UNSIGNED NOT NULL,
  `compte_variationstock` bigint(20) UNSIGNED NOT NULL,
  `compte_perte` bigint(20) UNSIGNED NOT NULL,
  `compte_produit` bigint(20) UNSIGNED NOT NULL,
  `compte_destockage` bigint(20) UNSIGNED NOT NULL,
  `pucmd` double NOT NULL,
  `qtecmd` double NOT NULL,
  `unitecmd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puBase` double NOT NULL,
  `qteBase` double NOT NULL,
  `uniteBase` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cmupcmd` double NOT NULL,
  `devise` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `montanttva` double NOT NULL DEFAULT '0',
  `montantreduction` double NOT NULL DEFAULT '0',
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_detail_commandeclient_refentetecmd_foreign` (`refEnteteCmd`),
  KEY `tvente_detail_commandeclient_refproduit_foreign` (`refProduit`),
  KEY `tvente_detail_commandeclient_compte_vente_foreign` (`compte_vente`),
  KEY `tvente_detail_commandeclient_compte_variationstock_foreign` (`compte_variationstock`),
  KEY `tvente_detail_commandeclient_compte_perte_foreign` (`compte_perte`),
  KEY `tvente_detail_commandeclient_compte_produit_foreign` (`compte_produit`),
  KEY `tvente_detail_commandeclient_compte_destockage_foreign` (`compte_destockage`),
  KEY `tvente_detail_commandeclient_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tvente_detail_cuisine`
--

DROP TABLE IF EXISTS `tvente_detail_cuisine`;
CREATE TABLE IF NOT EXISTS `tvente_detail_cuisine` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteVente` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `compte_vente` bigint(20) UNSIGNED NOT NULL,
  `compte_variationstock` bigint(20) UNSIGNED NOT NULL,
  `compte_perte` bigint(20) UNSIGNED NOT NULL,
  `compte_produit` bigint(20) UNSIGNED NOT NULL,
  `compte_destockage` bigint(20) UNSIGNED NOT NULL,
  `puVente` double NOT NULL,
  `qteVente` double NOT NULL,
  `uniteVente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puBase` double NOT NULL,
  `qteBase` double NOT NULL,
  `uniteBase` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cmupVente` double NOT NULL,
  `devise` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `montanttva` double NOT NULL DEFAULT '0',
  `montantreduction` double NOT NULL DEFAULT '0',
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_detail_cuisine_refentetevente_foreign` (`refEnteteVente`),
  KEY `tvente_detail_cuisine_refproduit_foreign` (`refProduit`),
  KEY `tvente_detail_cuisine_compte_vente_foreign` (`compte_vente`),
  KEY `tvente_detail_cuisine_compte_variationstock_foreign` (`compte_variationstock`),
  KEY `tvente_detail_cuisine_compte_perte_foreign` (`compte_perte`),
  KEY `tvente_detail_cuisine_compte_produit_foreign` (`compte_produit`),
  KEY `tvente_detail_cuisine_compte_destockage_foreign` (`compte_destockage`),
  KEY `tvente_detail_cuisine_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tvente_detail_entree`
--

DROP TABLE IF EXISTS `tvente_detail_entree`;
CREATE TABLE IF NOT EXISTS `tvente_detail_entree` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteEntree` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `compte_achat` bigint(20) UNSIGNED NOT NULL,
  `compte_variationstock` bigint(20) UNSIGNED NOT NULL,
  `compte_produit` bigint(20) UNSIGNED NOT NULL,
  `compte_stockage` bigint(20) UNSIGNED NOT NULL,
  `puEntree` double NOT NULL,
  `qteEntree` double NOT NULL,
  `uniteEntree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puBase` double NOT NULL,
  `qteBase` double NOT NULL,
  `uniteBase` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `devise` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `montanttva` double NOT NULL DEFAULT '0',
  `montantreduction` double NOT NULL DEFAULT '0',
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_detail_entree_refenteteentree_foreign` (`refEnteteEntree`),
  KEY `tvente_detail_entree_refproduit_foreign` (`refProduit`),
  KEY `tvente_detail_entree_compte_achat_foreign` (`compte_achat`),
  KEY `tvente_detail_entree_compte_variationstock_foreign` (`compte_variationstock`),
  KEY `tvente_detail_entree_compte_produit_foreign` (`compte_produit`),
  KEY `tvente_detail_entree_compte_stockage_foreign` (`compte_stockage`),
  KEY `tvente_detail_entree_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_detail_entree`
--

INSERT INTO `tvente_detail_entree` (`id`, `refEnteteEntree`, `refProduit`, `compte_achat`, `compte_variationstock`, `compte_produit`, `compte_stockage`, `puEntree`, `qteEntree`, `uniteEntree`, `puBase`, `qteBase`, `uniteBase`, `devise`, `taux`, `montanttva`, `montantreduction`, `active`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(19, 21, 1, 8, 7, 1, 7, 3, 2, 'Caisse24', 0.125, 24, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 23:51:04', '2024-10-15 23:51:04'),
(18, 20, 2, 8, 7, 1, 7, 2, 20, 'Pieces', 2, 1, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 11:33:20', '2024-10-15 11:33:20'),
(17, 19, 1, 8, 7, 1, 7, 10, 20, 'Caisse24', 0.41666666666667, 24, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 11:31:37', '2024-10-15 11:31:37'),
(20, 21, 2, 8, 7, 1, 7, 2, 4, 'Pieces', 2, 1, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 23:51:04', '2024-10-15 23:51:04'),
(21, 24, 1, 8, 7, 1, 7, 10, 2, 'Caisse24', 0.41666666666667, 24, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 01:56:14', '2024-10-16 01:56:14'),
(22, 24, 2, 8, 7, 1, 7, 2, 2, 'Pieces', 2, 1, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 01:56:15', '2024-10-16 01:56:15'),
(23, 25, 3, 8, 7, 1, 7, 0.448, 20, 'Caisse24', 0.018666666666667, 24, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 06:37:04', '2024-10-16 06:37:04'),
(24, 25, 3, 8, 7, 1, 7, 0.5, 10, 'Pieces', 0.5, 1, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 06:37:04', '2024-10-16 06:37:04'),
(25, 26, 4, 8, 7, 1, 7, 30, 6, 'Pieces', 1.5, 20, 'Mesure', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 07:03:53', '2024-10-16 07:03:53'),
(26, 27, 5, 8, 7, 1, 7, 14.4, 10, 'Caisse24', 0.6, 24, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 08:06:39', '2024-10-16 08:06:39'),
(27, 27, 5, 8, 7, 1, 7, 0.6, 48, 'Pieces', 0.6, 1, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 08:06:39', '2024-10-16 08:06:39'),
(28, 28, 6, 8, 7, 1, 7, 10, 2, 'Kilogramme', 0.01, 1000, 'Gramme', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 08:58:26', '2024-10-16 08:58:26'),
(29, 28, 6, 8, 7, 1, 7, 0.01, 500, 'Gramme', 0.01, 1, 'Gramme', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 08:58:26', '2024-10-16 08:58:26'),
(30, 29, 1, 8, 7, 1, 7, 40, 2, 'Caisse24', 1.6666666666667, 24, 'Pieces', 'USD', 2900, 16, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-18 20:19:03', '2024-10-18 20:19:03'),
(31, 29, 2, 8, 7, 1, 7, 3, 1, 'Pieces', 3, 1, 'Pieces', 'USD', 2900, 16, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-18 20:19:03', '2024-10-18 20:19:03');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_detail_inventaire`
--

DROP TABLE IF EXISTS `tvente_detail_inventaire`;
CREATE TABLE IF NOT EXISTS `tvente_detail_inventaire` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteVente` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `compte_achat` bigint(20) UNSIGNED NOT NULL,
  `compte_vente` bigint(20) UNSIGNED NOT NULL,
  `compte_variationstock` bigint(20) UNSIGNED NOT NULL,
  `compte_perte` bigint(20) UNSIGNED NOT NULL,
  `compte_produit` bigint(20) UNSIGNED NOT NULL,
  `compte_destockage` bigint(20) UNSIGNED NOT NULL,
  `compte_stockage` bigint(20) UNSIGNED NOT NULL,
  `puVente` double NOT NULL,
  `qteVente` double NOT NULL DEFAULT '0',
  `qteEntree` double NOT NULL DEFAULT '0',
  `uniteVente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puBase` double NOT NULL,
  `qteBase` double NOT NULL,
  `uniteBase` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cmupVente` double NOT NULL,
  `devise` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `montanttva` double NOT NULL DEFAULT '0',
  `montantreduction` double NOT NULL DEFAULT '0',
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_detail_inventaire_refentetevente_foreign` (`refEnteteVente`),
  KEY `tvente_detail_inventaire_refproduit_foreign` (`refProduit`),
  KEY `tvente_detail_inventaire_compte_achat_foreign` (`compte_achat`),
  KEY `tvente_detail_inventaire_compte_vente_foreign` (`compte_vente`),
  KEY `tvente_detail_inventaire_compte_variationstock_foreign` (`compte_variationstock`),
  KEY `tvente_detail_inventaire_compte_perte_foreign` (`compte_perte`),
  KEY `tvente_detail_inventaire_compte_produit_foreign` (`compte_produit`),
  KEY `tvente_detail_inventaire_compte_destockage_foreign` (`compte_destockage`),
  KEY `tvente_detail_inventaire_compte_stockage_foreign` (`compte_stockage`),
  KEY `tvente_detail_inventaire_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tvente_detail_requisition`
--

DROP TABLE IF EXISTS `tvente_detail_requisition`;
CREATE TABLE IF NOT EXISTS `tvente_detail_requisition` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteCmd` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `compte_achat` bigint(20) UNSIGNED NOT NULL,
  `compte_produit` bigint(20) UNSIGNED NOT NULL,
  `puCmd` double NOT NULL,
  `qteCmd` double NOT NULL,
  `uniteCmd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puBase` double NOT NULL,
  `qteBase` double NOT NULL,
  `uniteBase` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `devise` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `montanttva` double NOT NULL DEFAULT '0',
  `montantreduction` double NOT NULL DEFAULT '0',
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_detail_requisition_refentetecmd_foreign` (`refEnteteCmd`),
  KEY `tvente_detail_requisition_refproduit_foreign` (`refProduit`),
  KEY `tvente_detail_requisition_compte_achat_foreign` (`compte_achat`),
  KEY `tvente_detail_requisition_compte_produit_foreign` (`compte_produit`),
  KEY `tvente_detail_requisition_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_detail_requisition`
--

INSERT INTO `tvente_detail_requisition` (`id`, `refEnteteCmd`, `refProduit`, `compte_achat`, `compte_produit`, `puCmd`, `qteCmd`, `uniteCmd`, `puBase`, `qteBase`, `uniteBase`, `devise`, `taux`, `montanttva`, `montantreduction`, `active`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(14, 8, 5, 8, 1, 14.4, 1, 'Caisse24', 14.4, 1, 'Pieces', 'USD', 2900, 16, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-18 20:20:43', '2024-10-18 20:20:43'),
(9, 6, 1, 8, 1, 4, 4, 'Pieces', 4, 4, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-06 09:04:13', '2024-10-06 09:04:13'),
(10, 6, 1, 8, 1, 24, 4, 'Douzaine', 24, 48, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-06 09:04:13', '2024-10-06 09:04:13'),
(11, 7, 1, 8, 1, 4, 20, 'Pieces', 4, 20, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-06 09:36:13', '2024-10-06 09:36:13'),
(12, 7, 1, 8, 1, 24, 2, 'Douzaine', 24, 24, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-06 09:36:13', '2024-10-06 09:36:13'),
(13, 8, 1, 8, 1, 40, 2, 'Caisse24', 40, 2, 'Pieces', 'USD', 2900, 16, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-18 20:20:43', '2024-10-18 20:20:43'),
(15, 9, 3, 8, 1, 0.0037068965517241, 10, 'Caisse24', 0.0037068965517241, 10, 'Pieces', 'USD', 2900, 16, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-24 12:49:56', '2024-10-24 12:49:56'),
(16, 9, 2, 8, 1, 0.0010344827586207, 20, 'Pieces', 0.0010344827586207, 20, 'Pieces', 'USD', 2900, 0, 0, 'OUI', 'KAKULE JEAN', 4, '2024-10-24 12:49:56', '2024-10-24 12:49:56');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_detail_transfert`
--

DROP TABLE IF EXISTS `tvente_detail_transfert`;
CREATE TABLE IF NOT EXISTS `tvente_detail_transfert` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteTransfert` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `refDestination` bigint(20) UNSIGNED NOT NULL,
  `puTransfert` double NOT NULL,
  `qteTransfert` double NOT NULL,
  `uniteTransfert` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puBase` double NOT NULL,
  `qteBase` double NOT NULL,
  `uniteBase` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idStockService` int(11) NOT NULL DEFAULT '0',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_detail_transfert_refentetetransfert_foreign` (`refEnteteTransfert`),
  KEY `tvente_detail_transfert_refproduit_foreign` (`refProduit`),
  KEY `tvente_detail_transfert_refdestination_foreign` (`refDestination`),
  KEY `tvente_detail_transfert_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_detail_transfert`
--

INSERT INTO `tvente_detail_transfert` (`id`, `refEnteteTransfert`, `refProduit`, `refDestination`, `puTransfert`, `qteTransfert`, `uniteTransfert`, `puBase`, `qteBase`, `uniteBase`, `idStockService`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, 30, '', 0, 0, '', 1, 'KAKULE JEAN', 4, '2024-10-16 03:41:12', '2024-10-16 03:41:12'),
(2, 1, 1, 1, 40, 2, 'Caisse24', 4, 24, 'Pieces', 1, 'KAKULE JEAN', 4, '2024-10-16 03:49:25', '2024-10-16 03:49:25'),
(3, 1, 1, 1, 40, 2, 'Caisse24', 4, 24, 'Pieces', 1, 'KAKULE JEAN', 4, '2024-10-16 03:51:10', '2024-10-16 03:51:10'),
(4, 4, 1, 1, 40, 2, 'Caisse24', 4, 24, 'Pieces', 1, 'KAKULE JEAN', 4, '2024-10-16 04:54:03', '2024-10-16 04:54:03'),
(5, 4, 1, 1, 4, 10, 'Pieces', 4, 1, 'Pieces', 1, 'KAKULE JEAN', 4, '2024-10-16 04:54:03', '2024-10-16 04:54:03'),
(6, 5, 1, 1, 40, 2, 'Caisse24', 4, 24, 'Pieces', 1, 'KAKULE JEAN', 4, '2024-10-16 05:53:40', '2024-10-16 05:53:40'),
(7, 6, 3, 1, 10.75, 2, 'Caisse24', 0.448, 24, 'Pieces', 1, 'KAKULE JEAN', 4, '2024-10-16 06:44:50', '2024-10-16 06:44:50'),
(8, 7, 5, 1, 14.4, 2, 'Caisse24', 0.6, 24, 'Pieces', 1, 'KAKULE JEAN', 4, '2024-10-16 08:37:13', '2024-10-16 08:37:13'),
(9, 8, 1, 1, 40, 2, 'Caisse24', 4, 24, 'Pieces', 1, 'KAKULE JEAN', 4, '2024-10-18 20:16:48', '2024-10-18 20:16:48'),
(10, 9, 1, 1, 40, 2, 'Caisse24', 4, 24, 'Pieces', 1, 'KAKULE JEAN', 4, '2024-10-21 04:25:29', '2024-10-21 04:25:29'),
(11, 10, 1, 1, 40, 2, 'Caisse24', 4, 24, 'Pieces', 1, 'KAKULE JEAN', 4, '2024-10-21 04:25:51', '2024-10-21 04:25:51'),
(12, 11, 1, 1, 40, 2, 'Caisse24', 4, 24, 'Pieces', 1, 'KAKULE JEAN', 4, '2024-10-21 04:34:13', '2024-10-21 04:34:13'),
(13, 12, 2, 3, 3, 5, 'Pieces', 3, 1, 'Pieces', 0, 'KAKULE JEAN', 4, '2024-10-24 12:21:46', '2024-10-24 12:21:46'),
(14, 13, 2, 1, 3, 5, 'Pieces', 3, 1, 'Pieces', 0, 'KAKULE JEAN', 4, '2024-10-24 13:26:50', '2024-10-24 13:26:50');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_detail_unite`
--

DROP TABLE IF EXISTS `tvente_detail_unite`;
CREATE TABLE IF NOT EXISTS `tvente_detail_unite` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `refUnite` bigint(20) UNSIGNED NOT NULL,
  `puUnite` double NOT NULL,
  `qteUnite` double NOT NULL,
  `puBase` double NOT NULL,
  `qteBase` double NOT NULL,
  `estunite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_detail_unite_refproduit_foreign` (`refProduit`),
  KEY `tvente_detail_unite_refunite_foreign` (`refUnite`),
  KEY `tvente_detail_unite_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_detail_unite`
--

INSERT INTO `tvente_detail_unite` (`id`, `refProduit`, `refUnite`, `puUnite`, `qteUnite`, `puBase`, `qteBase`, `estunite`, `active`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, 1, 4, 1, 'OUI', 'OUI', 'KAKULE JEAN', 4, '2024-10-05 11:31:23', '2024-10-05 11:31:23'),
(2, 1, 2, 24, 12, 4, 1, 'NON', 'OUI', 'KAKULE JEAN', 4, '2024-10-05 11:33:10', '2024-10-05 11:33:10'),
(3, 1, 4, 40, 1, 4, 24, 'NON', 'OUI', 'KAKULE JEAN', 4, '2024-10-15 09:22:22', '2024-10-15 09:22:22'),
(4, 2, 1, 3, 1, 3, 1, 'OUI', 'OUI', 'KAKULE JEAN', 4, '2024-10-15 09:53:28', '2024-10-15 09:53:28'),
(5, 3, 1, 0.448, 1, 0.448, 1, 'OUI', 'OUI', 'KAKULE JEAN', 4, '2024-10-16 06:24:06', '2024-10-16 06:28:43'),
(6, 3, 4, 10.75, 1, 0.448, 24, 'NON', 'OUI', 'KAKULE JEAN', 4, '2024-10-16 06:25:46', '2024-10-16 06:27:08'),
(7, 4, 5, 1.5, 1, 1.5, 1, 'OUI', 'OUI', 'KAKULE JEAN', 4, '2024-10-16 06:54:36', '2024-10-16 07:01:39'),
(8, 4, 1, 30, 1, 1.5, 20, 'NON', 'OUI', 'KAKULE JEAN', 4, '2024-10-16 06:56:01', '2024-10-16 06:59:02'),
(9, 5, 1, 0.6, 1, 0.6, 1, 'OUI', 'OUI', 'KAKULE JEAN', 4, '2024-10-16 07:56:19', '2024-10-16 07:56:19'),
(10, 5, 4, 14.4, 1, 0.6, 24, 'NON', 'OUI', 'KAKULE JEAN', 4, '2024-10-16 08:01:26', '2024-10-16 08:01:26'),
(11, 6, 6, 0.01, 1, 0.01, 1, 'OUI', 'OUI', 'KAKULE JEAN', 4, '2024-10-16 08:52:53', '2024-10-16 08:52:53'),
(12, 6, 7, 10, 1, 0.01, 1000, 'NON', 'OUI', 'KAKULE JEAN', 4, '2024-10-16 08:53:54', '2024-10-16 08:53:54');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_detail_vente`
--

DROP TABLE IF EXISTS `tvente_detail_vente`;
CREATE TABLE IF NOT EXISTS `tvente_detail_vente` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEnteteVente` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `compte_vente` bigint(20) UNSIGNED NOT NULL,
  `compte_variationstock` bigint(20) UNSIGNED NOT NULL,
  `compte_perte` bigint(20) UNSIGNED NOT NULL,
  `compte_produit` bigint(20) UNSIGNED NOT NULL,
  `compte_destockage` bigint(20) UNSIGNED NOT NULL,
  `puVente` double NOT NULL,
  `qteVente` double NOT NULL,
  `uniteVente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puBase` double NOT NULL,
  `qteBase` double NOT NULL,
  `uniteBase` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cmupVente` double NOT NULL,
  `devise` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `montanttva` double NOT NULL DEFAULT '0',
  `montantreduction` double NOT NULL DEFAULT '0',
  `priseencharge` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NON',
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `idStockService` int(11) NOT NULL DEFAULT '1',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_detail_vente_refentetevente_foreign` (`refEnteteVente`),
  KEY `tvente_detail_vente_refproduit_foreign` (`refProduit`),
  KEY `tvente_detail_vente_compte_vente_foreign` (`compte_vente`),
  KEY `tvente_detail_vente_compte_variationstock_foreign` (`compte_variationstock`),
  KEY `tvente_detail_vente_compte_perte_foreign` (`compte_perte`),
  KEY `tvente_detail_vente_compte_produit_foreign` (`compte_produit`),
  KEY `tvente_detail_vente_compte_destockage_foreign` (`compte_destockage`),
  KEY `tvente_detail_vente_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_detail_vente`
--

INSERT INTO `tvente_detail_vente` (`id`, `refEnteteVente`, `refProduit`, `compte_vente`, `compte_variationstock`, `compte_perte`, `compte_produit`, `compte_destockage`, `puVente`, `qteVente`, `uniteVente`, `puBase`, `qteBase`, `uniteBase`, `cmupVente`, `devise`, `taux`, `montanttva`, `montantreduction`, `priseencharge`, `active`, `idStockService`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 9, 7, 8, 1, 7, 0.5559, 4, 'Pieces', 0.5559, 1, 'Pieces', 0.55590834818777, 'USD', 2900, 0, 0, 'NON', 'OUI', 1, 'KAKULE JEAN', 0, '2024-10-21 05:13:04', '2024-10-21 05:13:04'),
(2, 4, 1, 9, 7, 8, 1, 7, 0.5559, 2, 'Pieces', 0.5559, 1, 'Pieces', 0.55590834818777, 'USD', 2900, 0, 0, 'NON', 'OUI', 1, 'KAKULE JEAN', 4, '2024-10-21 12:05:13', '2024-10-21 12:05:13'),
(3, 5, 1, 9, 7, 8, 1, 7, 2, 2, 'Pieces', 2, 1, 'Pieces', 0.55590834818777, 'USD', 2900, 0.64, 0, 'NON', 'OUI', 0, 'KAKULE JEAN', 4, '2024-10-24 13:44:29', '2024-10-24 13:44:29'),
(4, 5, 2, 9, 7, 8, 1, 7, 2, 1, 'Pieces', 2, 1, 'Pieces', 2.037037037037, 'USD', 2900, 0, 0, 'NON', 'OUI', 0, 'KAKULE JEAN', 4, '2024-10-24 13:44:29', '2024-10-24 13:44:29');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_devise`
--

DROP TABLE IF EXISTS `tvente_devise`;
CREATE TABLE IF NOT EXISTS `tvente_devise` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_devise`
--

INSERT INTO `tvente_devise` (`id`, `designation`, `active`, `created_at`, `updated_at`) VALUES
(1, 'USD', 'OUI', '2024-10-19 18:57:56', '2024-10-19 18:57:56');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_entete_commandeclient`
--

DROP TABLE IF EXISTS `tvente_entete_commandeclient`;
CREATE TABLE IF NOT EXISTS `tvente_entete_commandeclient` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refClient` bigint(20) UNSIGNED NOT NULL,
  `refService` bigint(20) UNSIGNED NOT NULL,
  `refReservation` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `datecmd` date NOT NULL,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_entete_commandeclient_refclient_foreign` (`refClient`),
  KEY `tvente_entete_commandeclient_refservice_foreign` (`refService`),
  KEY `tvente_entete_commandeclient_refreservation_foreign` (`refReservation`),
  KEY `tvente_entete_commandeclient_module_id_foreign` (`module_id`),
  KEY `tvente_entete_commandeclient_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tvente_entete_cuisine`
--

DROP TABLE IF EXISTS `tvente_entete_cuisine`;
CREATE TABLE IF NOT EXISTS `tvente_entete_cuisine` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refClient` bigint(20) UNSIGNED NOT NULL,
  `refService` bigint(20) UNSIGNED NOT NULL,
  `refReservation` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `dateVente` date NOT NULL,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_entete_cuisine_refclient_foreign` (`refClient`),
  KEY `tvente_entete_cuisine_refservice_foreign` (`refService`),
  KEY `tvente_entete_cuisine_refreservation_foreign` (`refReservation`),
  KEY `tvente_entete_cuisine_module_id_foreign` (`module_id`),
  KEY `tvente_entete_cuisine_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tvente_entete_entree`
--

DROP TABLE IF EXISTS `tvente_entete_entree`;
CREATE TABLE IF NOT EXISTS `tvente_entete_entree` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refFournisseur` bigint(20) UNSIGNED NOT NULL,
  `refRecquisition` bigint(20) UNSIGNED DEFAULT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `refService` bigint(20) UNSIGNED NOT NULL,
  `dateEntree` date NOT NULL,
  `libelle` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transporteur` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau1` int(11) NOT NULL DEFAULT '0',
  `niveaumax` int(11) NOT NULL DEFAULT '0',
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_entete_entree_reffournisseur_foreign` (`refFournisseur`),
  KEY `tvente_entete_entree_refrecquisition_foreign` (`refRecquisition`),
  KEY `tvente_entete_entree_module_id_foreign` (`module_id`),
  KEY `tvente_entete_entree_refservice_foreign` (`refService`),
  KEY `tvente_entete_entree_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_entete_entree`
--

INSERT INTO `tvente_entete_entree` (`id`, `code`, `refFournisseur`, `refRecquisition`, `module_id`, `refService`, `dateEntree`, `libelle`, `transporteur`, `niveau1`, `niveaumax`, `active`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(5, '1', 1, 7, 1, 1, '2024-10-15', 'XXXX', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 10:22:56', '2024-10-15 10:22:56'),
(6, '2', 1, 7, 1, 1, '2024-10-15', 'XXXX', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 10:23:10', '2024-10-15 10:23:10'),
(7, '3', 1, 7, 1, 1, '2024-10-15', 'XXXX', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 10:27:18', '2024-10-15 10:27:18'),
(8, '4', 1, 7, 1, 1, '2024-10-15', 'XXXX', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 10:28:01', '2024-10-15 10:28:01'),
(9, '5', 1, 7, 1, 1, '2024-10-15', 'XXXX', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 10:29:20', '2024-10-15 10:29:20'),
(10, '6', 1, 7, 1, 1, '2024-10-15', 'XXXX', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 10:30:52', '2024-10-15 10:30:52'),
(11, '16', 1, 7, 2, 1, '2024-10-15', 'XXX', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 10:41:35', '2024-10-15 10:41:35'),
(12, '17', 1, 7, 2, 1, '2024-10-15', 'XX', 'XX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 10:43:03', '2024-10-15 10:43:03'),
(13, '18', 1, 7, 2, 1, '2024-10-14', 'XXX', 'XX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 10:46:31', '2024-10-15 10:46:31'),
(14, '19', 1, 6, 2, 1, '2024-10-15', 'XXXX', 'XXXx', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 10:53:30', '2024-10-15 10:53:30'),
(15, '20', 1, 7, 2, 1, '2024-10-15', 'XXX', 'XX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 10:55:12', '2024-10-15 10:55:12'),
(16, '21', 1, 7, 2, 1, '2024-10-15', 'XXX', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 11:08:17', '2024-10-15 11:08:17'),
(17, '22', 1, 7, 2, 1, '2024-10-15', 'XXX', 'XX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 11:09:22', '2024-10-15 11:09:22'),
(18, '23', 1, 5, 2, 1, '2024-10-15', 'XXX', 'XXXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 11:27:36', '2024-10-15 11:27:36'),
(19, '24', 1, 7, 2, 1, '2024-10-15', 'XXXX', 'XXXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 11:31:37', '2024-10-15 11:31:37'),
(20, '25', 1, 7, 2, 1, '2024-10-15', 'XXX', 'XXXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 11:33:20', '2024-10-15 11:33:20'),
(21, '26', 1, 7, 2, 1, '2024-10-16', 'XXX', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-15 23:51:04', '2024-10-15 23:51:04'),
(22, '27', 1, 7, 2, 1, '2024-10-16', 'XXX', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 01:49:48', '2024-10-16 01:49:48'),
(23, '28', 1, 7, 2, 1, '2024-10-16', 'XXX', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 01:50:04', '2024-10-16 01:50:04'),
(24, '29', 1, 7, 2, 1, '2024-10-16', 'XXX', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 01:56:14', '2024-10-16 01:56:14'),
(25, '31', 1, 7, 2, 3, '2024-10-16', 'XXX', 'xxx', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 06:37:04', '2024-10-16 06:37:04'),
(26, '12', 1, 7, 1, 1, '2024-10-16', 'XXX', 'XX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 07:03:53', '2024-10-16 07:03:53'),
(27, '33', 1, 7, 2, 3, '2024-10-16', 'xxx', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 08:06:38', '2024-10-16 08:06:38'),
(28, '35', 1, 6, 2, 3, '2024-10-16', 'xxx', 'XXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-16 08:58:26', '2024-10-16 08:58:26'),
(29, '36', 1, 7, 2, 1, '2024-10-19', 'XXX', 'XXXX', 0, 3, 'OUI', 'KAKULE JEAN', 4, '2024-10-18 20:19:03', '2024-10-18 20:19:03');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_entete_inventaire`
--

DROP TABLE IF EXISTS `tvente_entete_inventaire`;
CREATE TABLE IF NOT EXISTS `tvente_entete_inventaire` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refClient` bigint(20) UNSIGNED NOT NULL,
  `refService` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `dateVente` date NOT NULL,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_entete_inventaire_refclient_foreign` (`refClient`),
  KEY `tvente_entete_inventaire_refservice_foreign` (`refService`),
  KEY `tvente_entete_inventaire_module_id_foreign` (`module_id`),
  KEY `tvente_entete_inventaire_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tvente_entete_paiecommande`
--

DROP TABLE IF EXISTS `tvente_entete_paiecommande`;
CREATE TABLE IF NOT EXISTS `tvente_entete_paiecommande` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_entete_paie` date NOT NULL,
  `refService` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_entete_paiecommande_refservice_foreign` (`refService`),
  KEY `tvente_entete_paiecommande_module_id_foreign` (`module_id`),
  KEY `tvente_entete_paiecommande_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_entete_paiecommande`
--

INSERT INTO `tvente_entete_paiecommande` (`id`, `code`, `date_entete_paie`, `refService`, `module_id`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(1, '0', '2024-10-06', 1, 1, 'KAKULE JEAN', 0, '2024-10-06 08:10:49', '2024-10-06 08:10:49'),
(2, '0', '2024-10-06', 1, 1, 'KAKULE JEAN', 4, '2024-10-06 09:36:43', '2024-10-06 09:36:43'),
(3, '14', '2024-10-24', 1, 1, 'KAKULE JEAN', 4, '2024-10-24 12:34:53', '2024-10-24 12:34:53');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_entete_paievente`
--

DROP TABLE IF EXISTS `tvente_entete_paievente`;
CREATE TABLE IF NOT EXISTS `tvente_entete_paievente` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_entete_paie` date NOT NULL,
  `refService` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_entete_paievente_refservice_foreign` (`refService`),
  KEY `tvente_entete_paievente_module_id_foreign` (`module_id`),
  KEY `tvente_entete_paievente_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tvente_entete_requisition`
--

DROP TABLE IF EXISTS `tvente_entete_requisition`;
CREATE TABLE IF NOT EXISTS `tvente_entete_requisition` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refFournisseur` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `refService` bigint(20) UNSIGNED NOT NULL,
  `dateCmd` date NOT NULL,
  `libelle` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau1` int(11) NOT NULL DEFAULT '0',
  `niveaumax` int(11) NOT NULL DEFAULT '0',
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `montant` double NOT NULL DEFAULT '0',
  `paie` double NOT NULL DEFAULT '0',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_entete_requisition_reffournisseur_foreign` (`refFournisseur`),
  KEY `tvente_entete_requisition_module_id_foreign` (`module_id`),
  KEY `tvente_entete_requisition_refservice_foreign` (`refService`),
  KEY `tvente_entete_requisition_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_entete_requisition`
--

INSERT INTO `tvente_entete_requisition` (`id`, `code`, `refFournisseur`, `module_id`, `refService`, `dateCmd`, `libelle`, `niveau1`, `niveaumax`, `active`, `montant`, `paie`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(1, '0', 1, 1, 1, '2024-10-04', 'xxx', 0, 3, 'OUI', 0, 0, 'KAKULE JEAN', 4, '2024-10-05 11:17:33', '2024-10-05 11:17:33'),
(2, '0', 1, 1, 1, '2024-10-06', 'Commande', 0, 3, 'OUI', 0, 0, 'KAKULE JEAN', 4, '2024-10-06 05:42:12', '2024-10-06 05:42:12'),
(3, '0', 1, 1, 1, '2024-10-06', 'CMD', 0, 3, 'OUI', 0, 0, 'KAKULE JEAN', 4, '2024-10-06 06:49:04', '2024-10-06 06:49:04'),
(4, '0', 1, 1, 1, '2024-10-06', 'Com', 0, 3, 'OUI', 0, 0, 'KAKULE JEAN', 4, '2024-10-06 06:51:21', '2024-10-06 06:51:21'),
(5, '0', 1, 1, 1, '2024-10-06', 'Commande', 0, 3, 'OUI', 0, 0, 'KAKULE JEAN', 4, '2024-10-06 09:01:26', '2024-10-06 09:01:26'),
(6, '0', 1, 1, 1, '2024-10-06', 'Commande', 0, 3, 'OUI', 1168, 1000, 'KAKULE JEAN', 4, '2024-10-06 09:04:13', '2024-10-06 09:04:13'),
(7, '0', 1, 1, 1, '2024-10-06', 'xxxx', 0, 3, 'OUI', 656, 100, 'KAKULE JEAN', 4, '2024-10-06 09:36:13', '2024-10-06 09:36:13'),
(8, '13', 1, 1, 1, '2024-10-19', 'XXX', 0, 3, 'OUI', 94.4, 0, 'KAKULE JEAN', 4, '2024-10-18 20:20:42', '2024-10-18 20:20:42'),
(9, '15', 2, 1, 1, '2024-10-24', 'xxx', 0, 3, 'OUI', 0.057758620689654996, 0, 'KAKULE JEAN', 4, '2024-10-24 12:49:56', '2024-10-24 12:49:56');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_entete_transfert`
--

DROP TABLE IF EXISTS `tvente_entete_transfert`;
CREATE TABLE IF NOT EXISTS `tvente_entete_transfert` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refService` bigint(20) UNSIGNED NOT NULL,
  `date_transfert` date NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_entete_transfert_refservice_foreign` (`refService`),
  KEY `tvente_entete_transfert_module_id_foreign` (`module_id`),
  KEY `tvente_entete_transfert_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_entete_transfert`
--

INSERT INTO `tvente_entete_transfert` (`id`, `refService`, `date_transfert`, `module_id`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-10-16', 2, 'KAKULE JEAN', 4, '2024-10-16 03:32:17', '2024-10-16 03:32:17'),
(2, 1, '2024-10-23', 1, 'KAKULE JEAN', 4, '2024-10-16 04:51:41', '2024-10-16 04:51:41'),
(3, 1, '2024-10-23', 1, 'KAKULE JEAN', 4, '2024-10-16 04:52:55', '2024-10-16 04:52:55'),
(4, 1, '2024-10-23', 1, 'KAKULE JEAN', 4, '2024-10-16 04:54:03', '2024-10-16 04:54:03'),
(5, 1, '2024-10-16', 1, 'KAKULE JEAN', 4, '2024-10-16 05:53:40', '2024-10-16 05:53:40'),
(6, 3, '2024-10-16', 2, 'KAKULE JEAN', 4, '2024-10-16 06:44:50', '2024-10-16 06:44:50'),
(7, 3, '2024-10-16', 2, 'KAKULE JEAN', 4, '2024-10-16 08:37:13', '2024-10-16 08:37:13'),
(8, 3, '2024-10-19', 3, 'KAKULE JEAN', 4, '2024-10-18 20:16:48', '2024-10-18 20:16:48'),
(9, 3, '2024-10-21', 3, 'KAKULE JEAN', 4, '2024-10-21 04:25:28', '2024-10-21 04:25:28'),
(10, 3, '2024-10-21', 3, 'KAKULE JEAN', 4, '2024-10-21 04:25:51', '2024-10-21 04:25:51'),
(11, 3, '2024-10-21', 3, 'KAKULE JEAN', 4, '2024-10-21 04:34:13', '2024-10-21 04:34:13'),
(12, 1, '2024-10-24', 3, 'KAKULE JEAN', 4, '2024-10-24 12:21:46', '2024-10-24 12:21:46'),
(13, 3, '2024-10-24', 3, 'KAKULE JEAN', 4, '2024-10-24 13:26:50', '2024-10-24 13:26:50');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_entete_vente`
--

DROP TABLE IF EXISTS `tvente_entete_vente`;
CREATE TABLE IF NOT EXISTS `tvente_entete_vente` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refClient` bigint(20) UNSIGNED NOT NULL,
  `refService` bigint(20) UNSIGNED NOT NULL,
  `refReservation` bigint(20) UNSIGNED DEFAULT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `dateVente` date NOT NULL,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` double NOT NULL DEFAULT '0',
  `reduction` double NOT NULL DEFAULT '0',
  `totaltva` double NOT NULL DEFAULT '0',
  `paie` double NOT NULL DEFAULT '0',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_entete_vente_refclient_foreign` (`refClient`),
  KEY `tvente_entete_vente_refservice_foreign` (`refService`),
  KEY `tvente_entete_vente_refreservation_foreign` (`refReservation`),
  KEY `tvente_entete_vente_module_id_foreign` (`module_id`),
  KEY `tvente_entete_vente_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_entete_vente`
--

INSERT INTO `tvente_entete_vente` (`id`, `code`, `refClient`, `refService`, `refReservation`, `module_id`, `dateVente`, `libelle`, `montant`, `reduction`, `totaltva`, `paie`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(1, '0', 1, 1, NULL, 4, '2024-10-20', 'Vente des Prosuits', 2.2236, 0, 0, 0, 'KAKULE JEAN', 0, '2024-10-20 10:54:39', '2024-10-20 10:54:39'),
(2, '0', 1, 1, NULL, 4, '2024-10-21', 'XX', 0, 0, 0, 0, 'KAKULE JEAN', 4, '2024-10-21 12:01:33', '2024-10-21 12:01:33'),
(3, '0', 1, 1, NULL, 4, '2024-10-21', 'XX', 0, 0, 0, 0, 'KAKULE JEAN', 4, '2024-10-21 12:02:39', '2024-10-21 12:02:39'),
(4, '0', 1, 1, NULL, 4, '2024-10-21', 'XX', 1.1118, 0, 0, 0, 'KAKULE JEAN', 4, '2024-10-21 12:05:13', '2024-10-21 12:05:13'),
(5, '0', 1, 2, NULL, 4, '2024-10-24', 'XX', 6, 0, 0.64, 0, 'KAKULE JEAN', 4, '2024-10-24 13:44:29', '2024-10-24 13:44:29');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_fournisseur`
--

DROP TABLE IF EXISTS `tvente_fournisseur`;
CREATE TABLE IF NOT EXISTS `tvente_fournisseur` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refCategorieFss` bigint(20) UNSIGNED NOT NULL,
  `noms` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_fournisseur_refcategoriefss_foreign` (`refCategorieFss`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_fournisseur`
--

INSERT INTO `tvente_fournisseur` (`id`, `refCategorieFss`, `noms`, `contact`, `mail`, `adresse`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 'SUPER-MARCHE', '0992992063', 'super@gmail.com', 'GOMA', 'KAKULE JEAN', '2024-10-05 11:14:27', '2024-10-05 11:14:27'),
(2, 2, 'BRALIMA', '0992992063', 'bralima@gmail.com', 'GOMA', 'KAKULE JEAN', '2024-10-24 12:40:53', '2024-10-24 12:40:53');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_module`
--

DROP TABLE IF EXISTS `tvente_module`;
CREATE TABLE IF NOT EXISTS `tvente_module` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_module` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tvente_module_nom_module_unique` (`nom_module`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_module`
--

INSERT INTO `tvente_module` (`id`, `nom_module`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Commande/Recquisition', 'OUI', '2024-10-05 09:59:29', '2024-10-05 09:59:29'),
(2, 'Approvisionnement', 'OUI', '2024-10-05 09:59:47', '2024-10-05 09:59:47'),
(3, 'Transfert Stock', 'OUI', '2024-10-05 10:00:17', '2024-10-05 10:00:17'),
(4, 'Ventes', 'OUI', '2024-10-19 18:57:37', '2024-10-19 18:57:37');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_paiement`
--

DROP TABLE IF EXISTS `tvente_paiement`;
CREATE TABLE IF NOT EXISTS `tvente_paiement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refEntetepaie` bigint(20) UNSIGNED NOT NULL,
  `refEnteteVente` bigint(20) UNSIGNED NOT NULL,
  `refBanque` bigint(20) UNSIGNED NOT NULL,
  `montant_paie` double NOT NULL,
  `devise` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `date_paie` date NOT NULL,
  `modepaie` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libellepaie` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroBordereau` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_paiement_refentetepaie_foreign` (`refEntetepaie`),
  KEY `tvente_paiement_refentetevente_foreign` (`refEnteteVente`),
  KEY `tvente_paiement_refbanque_foreign` (`refBanque`),
  KEY `tvente_paiement_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tvente_paiement_commande`
--

DROP TABLE IF EXISTS `tvente_paiement_commande`;
CREATE TABLE IF NOT EXISTS `tvente_paiement_commande` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refEntetepaie` bigint(20) UNSIGNED NOT NULL,
  `refCommande` bigint(20) UNSIGNED NOT NULL,
  `refBanque` bigint(20) UNSIGNED NOT NULL,
  `montant_paie` double NOT NULL,
  `devise` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  `date_paie` date NOT NULL,
  `modepaie` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libellepaie` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroBordereau` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_paiement_commande_refentetepaie_foreign` (`refEntetepaie`),
  KEY `tvente_paiement_commande_refcommande_foreign` (`refCommande`),
  KEY `tvente_paiement_commande_refbanque_foreign` (`refBanque`),
  KEY `tvente_paiement_commande_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_paiement_commande`
--

INSERT INTO `tvente_paiement_commande` (`id`, `code`, `refEntetepaie`, `refCommande`, `refBanque`, `montant_paie`, `devise`, `taux`, `date_paie`, `modepaie`, `libellepaie`, `numeroBordereau`, `author`, `refUser`, `active`, `created_at`, `updated_at`) VALUES
(8, '1', 1, 6, 1, 1000, 'USD', 2900, '2024-10-05', 'CASH', 'Paiement Facture Commande', '000000000', 'KAKULE JEAN', 4, 'OUI', '2024-10-06 09:23:25', '2024-10-06 09:23:25'),
(9, '2', 2, 7, 1, 100, 'USD', 2900, '2024-10-06', 'CASH', 'Paiement Facture Commande', '000000000', 'KAKULE JEAN', 4, 'OUI', '2024-10-06 09:37:35', '2024-10-06 09:37:35');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_parametre_tva`
--

DROP TABLE IF EXISTS `tvente_parametre_tva`;
CREATE TABLE IF NOT EXISTS `tvente_parametre_tva` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tva_id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_parametre_tva_tva_id_foreign` (`tva_id`),
  KEY `tvente_parametre_tva_module_id_foreign` (`module_id`),
  KEY `tvente_parametre_tva_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tvente_param_systeme`
--

DROP TABLE IF EXISTS `tvente_param_systeme`;
CREATE TABLE IF NOT EXISTS `tvente_param_systeme` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `maxid` double NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_param_systeme_module_id_foreign` (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_param_systeme`
--

INSERT INTO `tvente_param_systeme` (`id`, `module_id`, `maxid`, `created_at`, `updated_at`) VALUES
(1, 1, 16, '2024-10-14 18:15:16', '2024-10-14 18:15:16'),
(2, 2, 37, '2024-10-14 18:15:27', '2024-10-14 18:15:27'),
(3, 3, 7, '2024-10-14 18:15:36', '2024-10-14 18:15:36');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_produit`
--

DROP TABLE IF EXISTS `tvente_produit`;
CREATE TABLE IF NOT EXISTS `tvente_produit` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refCategorie` bigint(20) UNSIGNED NOT NULL,
  `refUniteBase` bigint(20) UNSIGNED NOT NULL,
  `uniteBase` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pu` double NOT NULL,
  `qte` double NOT NULL,
  `cmup` double NOT NULL,
  `devise` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Oldcode` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000',
  `Newcode` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000',
  `tvaapplique` tinyint(1) NOT NULL DEFAULT '1',
  `estvendable` tinyint(1) NOT NULL DEFAULT '1',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tvente_produit_designation_unique` (`designation`),
  KEY `tvente_produit_refcategorie_foreign` (`refCategorie`),
  KEY `tvente_produit_refunitebase_foreign` (`refUniteBase`),
  KEY `tvente_produit_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_produit`
--

INSERT INTO `tvente_produit` (`id`, `designation`, `refCategorie`, `refUniteBase`, `uniteBase`, `pu`, `qte`, `cmup`, `devise`, `taux`, `Oldcode`, `Newcode`, `tvaapplique`, `estvendable`, `author`, `refUser`, `created_at`, `updated_at`) VALUES
(1, 'PRIMUS', 1, 1, 'Pieces', 3, 230, 0.55590834818777, 'USD', '0', '1', '0', 1, 1, 'KAKULE JEAN', 4, '2024-10-05 10:52:58', '2024-10-05 10:52:58'),
(2, 'VITALO', 1, 1, 'Pieces', 2, 17, 2.037037037037, 'USD', '0', '2', '0', 1, 1, 'KAKULE JEAN', 4, '2024-10-05 10:55:19', '2024-10-05 11:03:24'),
(3, 'SUCRE PF', 1, 1, 'Pieces', 2, 442, 0.028489795918368, 'USD', '2900', '0', '0', 0, 0, 'KAKULE JEAN', 4, '2024-10-16 06:21:41', '2024-10-16 06:21:41'),
(4, 'RED LABEL', 1, 5, 'Mesure', 1.5, 120, 1.5, 'USD', '2900', '0', '0', 0, 0, 'KAKULE JEAN', 4, '2024-10-16 06:51:45', '2024-10-16 06:57:24'),
(5, 'JUS AFIA', 1, 1, 'Pieces', 3, 240, 0.6, 'USD', '2900', '0', '0', 0, 0, 'KAKULE JEAN', 4, '2024-10-16 07:53:39', '2024-10-16 07:53:39'),
(6, 'SAUCISSON', 2, 6, 'Gramme', 0, 2500, 0.01, 'USD', '2900', '0', '0', 0, 0, 'KAKULE JEAN', 4, '2024-10-16 08:50:09', '2024-10-16 08:50:09');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_services`
--

DROP TABLE IF EXISTS `tvente_services`;
CREATE TABLE IF NOT EXISTS `tvente_services` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_services`
--

INSERT INTO `tvente_services` (`id`, `nom_service`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Bar&Resto', 'OUI', '2024-10-05 09:58:35', '2024-10-05 09:58:35'),
(2, 'Hotel', 'OUI', '2024-10-05 09:58:47', '2024-10-05 09:58:47'),
(3, 'Cuisine', 'OUI', '2024-10-05 09:59:05', '2024-10-05 09:59:05');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_stock_service`
--

DROP TABLE IF EXISTS `tvente_stock_service`;
CREATE TABLE IF NOT EXISTS `tvente_stock_service` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refService` bigint(20) UNSIGNED NOT NULL,
  `refProduit` bigint(20) UNSIGNED NOT NULL,
  `pu` double NOT NULL,
  `qte` double NOT NULL,
  `uniteBase` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cmup` double NOT NULL,
  `devise` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_stock_service_refservice_foreign` (`refService`),
  KEY `tvente_stock_service_refproduit_foreign` (`refProduit`),
  KEY `tvente_stock_service_refuser_foreign` (`refUser`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_stock_service`
--

INSERT INTO `tvente_stock_service` (`id`, `refService`, `refProduit`, `pu`, `qte`, `uniteBase`, `cmup`, `devise`, `taux`, `active`, `refUser`, `author`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0.55590834818777, 42, 'Pieces', 0.55590834818777, 'USD', '2900', 'OUI', 4, 'KAKULE JEAN', NULL, NULL),
(2, 3, 2, 2.037037037037, 5, 'Pieces', 2.037037037037, 'USD', '2900', 'OUI', 4, 'KAKULE JEAN', NULL, NULL),
(3, 1, 2, 2.037037037037, 5, 'Pieces', 2.037037037037, 'USD', '2900', 'OUI', 4, 'KAKULE JEAN', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tvente_taux`
--

DROP TABLE IF EXISTS `tvente_taux`;
CREATE TABLE IF NOT EXISTS `tvente_taux` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `taux` double NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_taux`
--

INSERT INTO `tvente_taux` (`id`, `taux`, `author`, `created_at`, `updated_at`) VALUES
(1, 2900, 'KAKULE JEAN', '2024-10-05 13:00:27', '2024-10-05 13:00:27');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_tva`
--

DROP TABLE IF EXISTS `tvente_tva`;
CREATE TABLE IF NOT EXISTS `tvente_tva` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `montant_tva` double NOT NULL,
  `libelle_tva` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_tva`
--

INSERT INTO `tvente_tva` (`id`, `montant_tva`, `libelle_tva`, `active`, `created_at`, `updated_at`) VALUES
(1, 16, 'TVA 16%', 'OUI', '2024-10-18 00:42:00', '2024-10-18 03:00:32'),
(2, 0, 'Exonéré de TVA (vente)', 'OUI', '2024-10-18 00:42:27', '2024-10-18 03:00:43');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_unite`
--

DROP TABLE IF EXISTS `tvente_unite`;
CREATE TABLE IF NOT EXISTS `tvente_unite` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_unite` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_unite` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tvente_unite_nom_unite_unique` (`nom_unite`),
  UNIQUE KEY `tvente_unite_code_unite_unique` (`code_unite`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_unite`
--

INSERT INTO `tvente_unite` (`id`, `nom_unite`, `code_unite`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Pieces', 'Pcs', 'OUI', '2024-10-05 09:48:01', '2024-10-05 09:48:01'),
(2, 'Douzaine', 'Dz', 'OUI', '2024-10-05 09:48:24', '2024-10-05 09:48:24'),
(3, 'Sixaine', 'Six', 'OUI', '2024-10-05 09:48:45', '2024-10-05 09:48:45'),
(4, 'Caisse24', 'C', 'OUI', '2024-10-15 09:18:34', '2024-10-15 09:18:34'),
(5, 'Mesure', 'MS', 'OUI', '2024-10-16 06:52:24', '2024-10-16 06:52:24'),
(6, 'Gramme', 'G', 'OUI', '2024-10-16 08:40:42', '2024-10-16 08:40:42'),
(7, 'Kilogramme', 'KG', 'OUI', '2024-10-16 08:41:00', '2024-10-16 08:41:00');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_user_service`
--

DROP TABLE IF EXISTS `tvente_user_service`;
CREATE TABLE IF NOT EXISTS `tvente_user_service` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `refService` bigint(20) UNSIGNED NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OUI',
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_user_service_refuser_foreign` (`refUser`),
  KEY `tvente_user_service_refservice_foreign` (`refService`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tvente_user_service`
--

INSERT INTO `tvente_user_service` (`id`, `refUser`, `refService`, `active`, `author`, `created_at`, `updated_at`) VALUES
(1, 4, 3, 'OUI', 'KAKULE JEAN', '2024-10-18 17:59:54', '2024-10-18 17:59:54'),
(2, 4, 1, 'OUI', 'KAKULE JEAN', '2024-10-24 13:36:20', '2024-10-24 13:36:20');

-- --------------------------------------------------------

--
-- Structure de la table `tvente_validations`
--

DROP TABLE IF EXISTS `tvente_validations`;
CREATE TABLE IF NOT EXISTS `tvente_validations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `niveau` int(11) NOT NULL,
  `codeOperation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refUser` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvente_validations_user_id_foreign` (`user_id`),
  KEY `tvente_validations_module_id_foreign` (`module_id`),
  KEY `tvente_validations_refuser_foreign` (`refUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_role` int(11) NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `telephone`, `adresse`, `avatar`, `sexe`, `id_role`, `remember_token`, `created_at`, `updated_at`, `active`) VALUES
(3, 'YOHARI KABUYAYA BEATRICE', 'yohari@gmail.com', NULL, '$2y$10$SuXgg26c5fmxUDzMbALDrenOiuoCwH7AHKw8.RjP0d5sSEByVSehW', '+243992992063', 'Mabanga sud;Tmk', '1643296874.jpg', 'M', 6, '$2y$10$e2IX1VqL9kzz7ceNtDLFQOcgfoXxyHGtukwX53ErHs5c6oIu1DdQy', NULL, '2024-08-01 19:16:36', 1),
(4, 'KAKULE JEAN', 'admin@gmail.com', NULL, '$2y$10$V0FmIG6fab5a1wxmwcwFUuHK5h.9SWChmP1LFXZ2676CCKnVeH1eG', '+243992992063', 'Mabanga sud;Tmk', '1643812713.jpg', 'M', 1, 'gaRDqKJrIC7nzlqDfuCc5dzw4xdqGigo0sMDlceIMbzbOubCX2BEOZJaftZk', NULL, '2024-08-01 19:08:00', 1),
(7, 'RACHEL UYERA', 'rachel@gmail.com', NULL, '$2y$10$tg9IK3Z5Pfc/eyKj76EFKeC1PvoXcS.N162pYxUbPE5BRAwMxmMve', '+243992992063', 'Mabanga sud;Tmk', '1643297170.jpg', 'M', 5, 'zCC3aTB8byH5vN9PUwqmwUIoJUfy9BLKuHf3aAvMr3X8lVwfhd4uweD2dg4i', '2022-01-27 13:14:47', '2024-08-01 20:11:22', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_attendaces`
--

DROP TABLE IF EXISTS `user_attendaces`;
CREATE TABLE IF NOT EXISTS `user_attendaces` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `id_role` int(11) NOT NULL DEFAULT '2',
  `nomP` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptionP` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avancementP` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `commentaire` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `id_theme` int(11) NOT NULL,
  `id_odd` int(11) NOT NULL,
  `date_naiss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbremploye` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_attendaces_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_attendaces`
--

INSERT INTO `user_attendaces` (`id`, `name`, `email`, `email_verified_at`, `password`, `telephone`, `adresse`, `avatar`, `sexe`, `active`, `id_role`, `nomP`, `descriptionP`, `avancementP`, `commentaire`, `id_theme`, `id_odd`, `date_naiss`, `nbremploye`, `created_at`, `updated_at`) VALUES
(1, 'Sumbu leonard', 'sumbu@gmail.com', NULL, '123456', '0817883541', 'virunga goma', NULL, 'F', 0, 2, 'julisha', 'brevet', 'prototypage 78', 'commentaire 1334', 3, 4, '1998-07-08', '15-20', '2022-07-08 12:13:43', '2022-07-08 12:21:34'),
(2, 'cool le boss', 'coucou@gmail.com', NULL, '12345678', '0817883541', 'Goma', NULL, 'M', 0, 2, 'Payondgo', 'description locale', 'ok', 'ok', 2, 2, '1999-07-08', '5-10', '2022-07-08 12:18:32', '2022-07-08 12:21:30'),
(5, 'susu kahembe', 'susu@gmail.com', NULL, '123456', '0817883541', 'Goma tmk', NULL, 'F', 0, 2, 'Goma chai', 'description de goma chai', 'prototypage', 'description de goma chai drc', 4, 3, '2022-07-08', '10-15', '2022-07-08 13:25:18', '2022-07-08 13:25:18'),
(6, 'sus leo', 'sus@gmail.com', NULL, '123456', '0817883541', 'goma', NULL, 'M', 0, 2, 'Goma chai', 'description Goma chai', 'prototypage', 'commentaire Goma chai', 4, 3, '2022-07-08', '5-10', '2022-07-08 13:29:44', '2022-07-08 13:29:44'),
(7, 'Kahembe tumba', 'kahembetumba@gmail.com', NULL, '12345678', '0817883541', 'Goma himbi', NULL, 'M', 0, 2, 'SoS Afia', 'ok', 'Prototype', 'Lol', 4, 3, '1997-07-13', '1-5', '2022-07-13 19:55:30', '2022-07-13 19:55:30');

-- --------------------------------------------------------

--
-- Structure de la table `valeurs`
--

DROP TABLE IF EXISTS `valeurs`;
CREATE TABLE IF NOT EXISTS `valeurs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `valeurs`
--

INSERT INTO `valeurs` (`id`, `nom`, `titre`, `description`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Efficacité', 'Efficacité', 'nous agissons rapidement pour que vous puissiez démarrer votre projet dans les plus brefs délais...', '1669534971.avif', '2022-11-27 06:42:51', '2022-11-27 06:42:51'),
(2, 'Qualité', 'Qualité', 'Notre seul moyen de vous garantir une tranquillité d’esprit maximale et de gagner votre confiance...', '1669534996.jpg', '2022-11-27 06:43:16', '2022-11-27 06:47:11'),
(3, 'Professionnalisme', 'Professionnalisme', 'Nous respectons nos engagements et répondons aux attentes..', '1669535040.png', '2022-11-27 06:44:00', '2022-12-24 14:40:34');

-- --------------------------------------------------------

--
-- Structure de la table `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `videos_titre_unique` (`titre`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `videos`
--

INSERT INTO `videos` (`id`, `titre`, `description`, `url`, `created_at`, `updated_at`) VALUES
(1, 'La santé mentale (1/2) - Joyce Meyer - Gérer mes émotions', 'Joyce nous explique pourquoi nos pensées ont un impact spirituel sur notre santé mentale.\n\nN°873-2 JMF EEL 873-2 - La santé mentale (1/2)', 'https://www.youtube.com/embed/P2bQ_G76qcw', '2022-02-02 13:09:12', '2022-11-28 21:57:54'),
(2, 'La santé mentale (2/2) - Joyce Meyer - Gérer mes émotions', 'Joyce nous explique pourquoi nos pensées ont un impact spirituel sur notre santé mentale.\nN°873-3 JMF EEL 873-3 - La santé mentale (2/2)', 'https://www.youtube.com/embed/IMMobD2RX-w?start=5', '2022-02-02 13:10:37', '2022-11-28 21:59:36'),
(4, 'La santé - 2mn avec Joyce Meyer - Pourquoi prendre soin de sa santé ? - Avoir des relations saines', 'Joyce nous invite à prendre soin de notre santé pour être heureux.\n1110-2 La poursuite de la joie et de la réjouissance', 'https://www.youtube.com/embed/HitoYDBynWg?start=5', '2022-07-11 10:38:02', '2022-11-28 22:00:50'),
(5, 'Nettoyez vos pensées (1/3) - Joyce Meyer - Maîtriser mes pensées', 'Joyce nous explique pourquoi nous devons faire attention à nos pensées.\nN°549-3 JMF EEL 549 3 Nettoyez vos pensées', 'https://www.youtube.com/embed/AmhyIu73uLM?start=5', '2022-07-11 10:39:27', '2022-11-28 22:03:02');

-- --------------------------------------------------------

--
-- Structure de la table `video_entreprises`
--

DROP TABLE IF EXISTS `video_entreprises`;
CREATE TABLE IF NOT EXISTS `video_entreprises` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ceo` int(11) NOT NULL,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `video_entreprises_titre_unique` (`titre`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video_entreprises`
--

INSERT INTO `video_entreprises` (`id`, `ceo`, `titre`, `description`, `url`, `created_at`, `updated_at`) VALUES
(1, 6, 'MAP DEMO API WITH CODEIGNITER(PHP) MYSQL', 'C\'est une vidéo de démonstration de l\'api google map en codeigniter avec mysql. la localisation des hôpitaux de la ville de Goma', 'https://www.youtube.com/embed/XTW6z0UhaPE', '2022-06-04 09:40:32', '2022-07-02 11:25:19'),
(2, 6, 'Apprendre à utiliser l\'application de transfert des bagages dans une agence aérienne', 'c\'est une application complète de la gestion de transfert de bagages', 'https://www.youtube.com/embed/H2rHGNJKNts', '2022-06-04 09:42:20', '2022-06-04 09:42:20'),
(3, 6, 'Flutter Backend | Flutter Laravel Backend PHP | Flutter Rest API | Flutter Http Post Request', 'Here you will learn how to create flutter app with backend with Laravel and PHP. Flutter Rest API use for sign up, sign in, login, logout with post, get HTTP request based on laravel admin panel based on PHP.  This works a s web backend as well. This backend is done using PHP Laravel', 'https://www.youtube.com/embed/kTrbcb21ENU', '2022-06-04 09:44:42', '2022-06-04 09:44:42'),
(4, 6, 'Flutter API Laravel - CRUD test POSTMAN y Device Video #3/3', 'CC English subtitles\n\nCRUD API Laravel - Flutter\nwe consume the services from flutter\n\nCRUD completo desde Laravel y consumismos sus servicios REST API desde Flutter\n\nContinuamos trabajando basados en los dos vídeos anteriores', 'https://www.youtube.com/embed/mdQ7eEeNefc', '2022-06-04 09:47:37', '2022-06-11 17:15:08'),
(5, 6, 'Flutter API Laravel - JWT Authenticacion - save state login Video #1', 'Creation of the API in Laravel, we consume the services with Flutter, initially we log in that allows us to maintain its status, it means that if you re-enter the App you should not ask for the login data, we will surely continue with a CRUD.', 'https://www.youtube.com/embed/h1JAAYGvm7M', '2022-06-04 09:49:32', '2022-06-04 09:49:32'),
(6, 6, 'Buld chat application in Vuejs - Vuetify UI Design, Messenger & Chating', 'In this tutorial we\'ll learn How to design a Modern Messenger & chating   dashboard application ( web design ) using vuetify and  vuejs 2 , material design icons, Font Awsome icons.\nSidebar, Card, Aavatar, list item, expantion .', 'https://www.youtube.com/embed/S1mAt8pKjUk', '2022-06-04 09:50:30', '2022-06-20 11:57:44'),
(10, 1, 'DOSSEH : \"Habitué\" (live @ Hip Hop Symphonique 3)', 'Dosseh a performé \"Habitué\" accompagné par The Ice Kream et l\'Orchestre Philharmonique de Radio France, enregistré à l\'occasion de Hip Hip symphonique 3, un concert coproduit par  Mouv’, l’Adami et l’orchestre philharmonique de Radio France.', 'https://youtu.be/BZyCRdgnu-0', '2022-06-16 19:11:43', '2022-06-16 19:11:43'),
(11, 1, 'Charlotte Dipanda - Coucou feat Singuila - Live au Grand Rex - Paris', 'Retrouve Charlotte Dipanda sur :\n\nSite Officiel : http://www.charlottedipandamusic.com', 'https://youtu.be/zeez4OmkgwU', '2022-06-16 19:11:58', '2022-06-16 19:13:29');

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

DROP TABLE IF EXISTS `villes`;
CREATE TABLE IF NOT EXISTS `villes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idProvince` int(11) NOT NULL,
  `nomVille` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`id`, `idProvince`, `nomVille`, `created_at`, `updated_at`) VALUES
(1, 1, 'Goma', '2022-11-17 10:57:21', '2022-11-17 10:57:21'),
(2, 6, 'Bukavu', '2022-11-17 10:58:20', '2022-11-17 10:58:20');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
