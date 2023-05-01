-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 29 avr. 2023 à 13:53
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `artplus`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE `abonnement` (
  `id_transaction` int(11) DEFAULT NULL,
  `Id_abon` int(11) NOT NULL,
  `date_abon` date NOT NULL,
  `id_cours` int(11) NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nom_u` varchar(255) DEFAULT NULL,
  `prenom_u` varchar(255) DEFAULT NULL,
  `age` int(11) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `role` varchar(30) NOT NULL,
  `genere` int(11) NOT NULL,
  `pwd` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `Id_Cart` int(11) NOT NULL,
  `Id_Prod` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart_items`
--

CREATE TABLE `cart_items` (
  `Id_Cart_Item` int(11) NOT NULL,
  `Id_Cart` int(11) NOT NULL,
  `Quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie_cours`
--

CREATE TABLE `categorie_cours` (
  `Id_cat` int(11) NOT NULL,
  `Nom_cat` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie_prod`
--

CREATE TABLE `categorie_prod` (
  `id_cat_prod` int(11) NOT NULL,
  `nom_cat_prod` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `Id_Cmd` int(11) NOT NULL,
  `Date_Cmd` date NOT NULL,
  `Date_Liv` date NOT NULL,
  `Id_Cart` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `idcom` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date` date NOT NULL,
  `id` int(11) DEFAULT NULL,
  `idsujet` int(11) DEFAULT NULL,
  `nblike` int(11) NOT NULL,
  `nbdislike` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `Id_c` int(11) NOT NULL,
  `Titre_c` varchar(255) NOT NULL,
  `Sous_categorie` int(11) NOT NULL,
  `Niveau_c` int(11) NOT NULL,
  `Fichier_c` longblob NOT NULL,
  `Description_c` longtext NOT NULL,
  `date_c` date NOT NULL,
  `prix` double NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dislikee`
--

CREATE TABLE `dislikee` (
  `id_dislike` int(11) NOT NULL,
  `id_commentaire` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220221141530', '2023-04-29 03:40:08', 1643),
('DoctrineMigrations\\Version20220221145227', '2023-04-29 03:40:09', 385);

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE `evenement` (
  `id_ev` int(11) NOT NULL,
  `titre_ev` varchar(100) NOT NULL,
  `categorie_ev` varchar(50) NOT NULL,
  `description_ev` varchar(200) NOT NULL,
  `image_ev` longblob NOT NULL,
  `adresse_ev` varchar(30) NOT NULL,
  `date_ev` datetime NOT NULL DEFAULT current_timestamp(),
  `nbre_places` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `level_cours`
--

CREATE TABLE `level_cours` (
  `Id_level` int(11) NOT NULL,
  `Nom_level` varchar(30) NOT NULL,
  `Id_c` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `likee`
--

CREATE TABLE `likee` (
  `id_like` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `id_commentaire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participation`
--

CREATE TABLE `participation` (
  `id_part` int(11) NOT NULL,
  `date_participation` datetime NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL,
  `id_ev` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `points`
--

CREATE TABLE `points` (
  `id_points` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `Id_Prod` int(11) NOT NULL,
  `id_cat_prod` int(11) NOT NULL,
  `Type_Prod` varchar(20) NOT NULL,
  `Description_Prod` text NOT NULL,
  `Prix_Prod` int(11) NOT NULL,
  `Url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `question_ass`
--

CREATE TABLE `question_ass` (
  `Id_Q_Ass` int(11) NOT NULL,
  `Type_Q_Ass` varchar(20) NOT NULL,
  `Description_Q_Ass` text NOT NULL,
  `Id_Rec` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `question_quiz`
--

CREATE TABLE `question_quiz` (
  `id_quest` int(11) NOT NULL,
  `id_quiz` int(11) DEFAULT NULL,
  `desc_question` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

CREATE TABLE `quiz` (
  `id_quiz` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `titre` varchar(100) NOT NULL,
  `option1` varchar(100) NOT NULL,
  `option2` varchar(100) NOT NULL,
  `option3` varchar(100) NOT NULL,
  `option4` varchar(100) NOT NULL,
  `question` varchar(100) NOT NULL,
  `reponse_correcte` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `id` int(11) DEFAULT NULL,
  `Id_Rec` int(11) NOT NULL,
  `Type_Rec` varchar(20) NOT NULL,
  `Description_Rec` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponse_ass`
--

CREATE TABLE `reponse_ass` (
  `Id_Rep_Ass` int(11) NOT NULL,
  `Type_Rep_Ass` varchar(20) NOT NULL,
  `Que_Rep_Ass` text NOT NULL,
  `Description_Rep_Ass` text NOT NULL,
  `Id_Rec` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponse_quiz`
--

CREATE TABLE `reponse_quiz` (
  `id_rep` int(11) NOT NULL,
  `id_quest` int(11) DEFAULT NULL,
  `option1` varchar(100) NOT NULL,
  `option2` varchar(100) NOT NULL,
  `option3` varchar(100) NOT NULL,
  `option4` varchar(100) NOT NULL,
  `reponse_correcte` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponse_utilisateur`
--

CREATE TABLE `reponse_utilisateur` (
  `id_rep` int(11) NOT NULL,
  `reponse` varchar(100) NOT NULL,
  `id` int(11) NOT NULL,
  `id_quiz` int(11) NOT NULL,
  `id_quest` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sous_categorie`
--

CREATE TABLE `sous_categorie` (
  `ID_sc` int(11) NOT NULL,
  `Nom_sc` varchar(30) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `Id_cat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sujet`
--

CREATE TABLE `sujet` (
  `idsujet` int(11) NOT NULL,
  `titresujet` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date` date NOT NULL,
  `accepter` int(11) NOT NULL,
  `nbcom` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `idtopic` int(11) NOT NULL,
  `photo` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

CREATE TABLE `topic` (
  `idtopic` int(11) NOT NULL,
  `titretopic` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `accepter` tinyint(1) NOT NULL,
  `nbsujet` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `hide` int(11) NOT NULL,
  `imageName` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `created_At` datetime NOT NULL DEFAULT current_timestamp(),
  `nom_carte` varchar(255) NOT NULL,
  `numero_carte` varchar(255) NOT NULL,
  `exp_mois` int(11) NOT NULL,
  `exp_annee` int(11) NOT NULL,
  `cvc` int(11) NOT NULL,
  `paymentIntent_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `activation_token` varchar(50) DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `last_login_date` datetime NOT NULL,
  `disable_token` varchar(65) DEFAULT NULL,
  `phone_number` int(11) NOT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `usertag` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`Id_abon`),
  ADD KEY `id_cours` (`id_cours`),
  ADD KEY `id_transaction` (`id_transaction`);

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`Id_Cart`),
  ADD KEY `Id_Prod` (`Id_Prod`),
  ADD KEY `iduser` (`id`);

--
-- Index pour la table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`Id_Cart_Item`),
  ADD KEY `Id_Cart` (`Id_Cart`);

--
-- Index pour la table `categorie_cours`
--
ALTER TABLE `categorie_cours`
  ADD PRIMARY KEY (`Id_cat`);

--
-- Index pour la table `categorie_prod`
--
ALTER TABLE `categorie_prod`
  ADD PRIMARY KEY (`id_cat_prod`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`Id_Cmd`),
  ADD KEY `fk_commande_cart` (`Id_Cart`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`idcom`),
  ADD KEY `fk_idsujet` (`idsujet`),
  ADD KEY `fk_idusercom` (`id`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`Id_c`),
  ADD KEY `Sous_categorie` (`Sous_categorie`),
  ADD KEY `utilisateur` (`id`);

--
-- Index pour la table `dislikee`
--
ALTER TABLE `dislikee`
  ADD PRIMARY KEY (`id_dislike`),
  ADD KEY `fk_comdislike` (`id_commentaire`),
  ADD KEY `fk_userdislike` (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`id_ev`),
  ADD KEY `iduser` (`id`);

--
-- Index pour la table `level_cours`
--
ALTER TABLE `level_cours`
  ADD PRIMARY KEY (`Id_level`),
  ADD KEY `cours` (`Id_c`);

--
-- Index pour la table `likee`
--
ALTER TABLE `likee`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `fk_user` (`id`),
  ADD KEY `fk_com` (`id_commentaire`);

--
-- Index pour la table `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`id_part`),
  ADD KEY `idev` (`id_ev`),
  ADD KEY `iduser` (`id`);

--
-- Index pour la table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id_points`),
  ADD KEY `iduser` (`id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`Id_Prod`),
  ADD KEY `id_cat_prod` (`id_cat_prod`);

--
-- Index pour la table `question_ass`
--
ALTER TABLE `question_ass`
  ADD PRIMARY KEY (`Id_Q_Ass`),
  ADD KEY `idreclamation` (`Id_Rec`),
  ADD KEY `Id_Rec` (`Id_Rec`);

--
-- Index pour la table `question_quiz`
--
ALTER TABLE `question_quiz`
  ADD PRIMARY KEY (`id_quest`),
  ADD KEY `id_quiz_2` (`id_quiz`),
  ADD KEY `id_quiz` (`id_quiz`);

--
-- Index pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id_quiz`),
  ADD KEY `iduser` (`id`);

--
-- Index pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`Id_Rec`),
  ADD KEY `iduser` (`id`);

--
-- Index pour la table `reponse_ass`
--
ALTER TABLE `reponse_ass`
  ADD PRIMARY KEY (`Id_Rep_Ass`),
  ADD KEY `idreclamation` (`Id_Rec`);

--
-- Index pour la table `reponse_quiz`
--
ALTER TABLE `reponse_quiz`
  ADD PRIMARY KEY (`id_rep`),
  ADD KEY `idquestion` (`id_quest`);

--
-- Index pour la table `reponse_utilisateur`
--
ALTER TABLE `reponse_utilisateur`
  ADD PRIMARY KEY (`id_rep`),
  ADD KEY `idquest` (`id_quest`),
  ADD KEY `iduser` (`id`),
  ADD KEY `idquiz` (`id_quiz`);

--
-- Index pour la table `sous_categorie`
--
ALTER TABLE `sous_categorie`
  ADD PRIMARY KEY (`ID_sc`),
  ADD KEY `categorie_cours` (`Id_cat`);

--
-- Index pour la table `sujet`
--
ALTER TABLE `sujet`
  ADD PRIMARY KEY (`idsujet`),
  ADD KEY `fk_iduser` (`id`),
  ADD KEY `fk_idtopic` (`idtopic`);

--
-- Index pour la table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`idtopic`),
  ADD KEY `fk_userid` (`iduser`),
  ADD KEY `utilisateur` (`id`);

--
-- Index pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `abonnement`
--
ALTER TABLE `abonnement`
  MODIFY `Id_abon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `Id_Cart` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `Id_Cart_Item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categorie_cours`
--
ALTER TABLE `categorie_cours`
  MODIFY `Id_cat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categorie_prod`
--
ALTER TABLE `categorie_prod`
  MODIFY `id_cat_prod` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `Id_Cmd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `idcom` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `Id_c` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dislikee`
--
ALTER TABLE `dislikee`
  MODIFY `id_dislike` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `id_ev` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `level_cours`
--
ALTER TABLE `level_cours`
  MODIFY `Id_level` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `likee`
--
ALTER TABLE `likee`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `participation`
--
ALTER TABLE `participation`
  MODIFY `id_part` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `points`
--
ALTER TABLE `points`
  MODIFY `id_points` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `Id_Prod` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `question_ass`
--
ALTER TABLE `question_ass`
  MODIFY `Id_Q_Ass` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `question_quiz`
--
ALTER TABLE `question_quiz`
  MODIFY `id_quest` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id_quiz` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `Id_Rec` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reponse_ass`
--
ALTER TABLE `reponse_ass`
  MODIFY `Id_Rep_Ass` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reponse_quiz`
--
ALTER TABLE `reponse_quiz`
  MODIFY `id_rep` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reponse_utilisateur`
--
ALTER TABLE `reponse_utilisateur`
  MODIFY `id_rep` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sous_categorie`
--
ALTER TABLE `sous_categorie`
  MODIFY `ID_sc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sujet`
--
ALTER TABLE `sujet`
  MODIFY `idsujet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `topic`
--
ALTER TABLE `topic`
  MODIFY `idtopic` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD CONSTRAINT `FK_351268BB6A25C826` FOREIGN KEY (`id_transaction`) REFERENCES `transaction` (`id`);

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `FK_880E0D76BF396750` FOREIGN KEY (`id`) REFERENCES `topic` (`id`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_6EEAA67DEF0C0217` FOREIGN KEY (`Id_Cart`) REFERENCES `cart` (`Id_Cart`);

--
-- Contraintes pour la table `points`
--
ALTER TABLE `points`
  ADD CONSTRAINT `FK_27BA8E29BF396750` FOREIGN KEY (`id`) REFERENCES `admin` (`id`);

--
-- Contraintes pour la table `question_quiz`
--
ALTER TABLE `question_quiz`
  ADD CONSTRAINT `FK_FAFC177D2F32E690` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`);

--
-- Contraintes pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `FK_A412FA92BF396750` FOREIGN KEY (`id`) REFERENCES `admin` (`id`);

--
-- Contraintes pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `FK_CE606404BF396750` FOREIGN KEY (`id`) REFERENCES `admin` (`id`);

--
-- Contraintes pour la table `reponse_ass`
--
ALTER TABLE `reponse_ass`
  ADD CONSTRAINT `FK_13E7E092C54061A0` FOREIGN KEY (`Id_Rec`) REFERENCES `reclamation` (`Id_Rec`);

--
-- Contraintes pour la table `reponse_quiz`
--
ALTER TABLE `reponse_quiz`
  ADD CONSTRAINT `FK_9879B3D1AD92B927` FOREIGN KEY (`id_quest`) REFERENCES `question_quiz` (`id_quest`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
