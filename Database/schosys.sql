-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 17 nov. 2020 à 21:32
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `schosys`
--

-- --------------------------------------------------------

--
-- Structure de la table `anneeacad`
--

CREATE TABLE `anneeacad` (
  `idAnnee` int(11) NOT NULL,
  `annee` varchar(10) DEFAULT NULL,
  `encours` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `idClasse` varchar(30) NOT NULL,
  `codeClasse` varchar(10) NOT NULL,
  `libelleClasse` varchar(150) DEFAULT NULL,
  `idNiveau` varchar(30) NOT NULL,
  `idFiliere` varchar(30) NOT NULL,
  `validationTC` int(11) NOT NULL DEFAULT '12',
  `validationSP` int(11) NOT NULL DEFAULT '12',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `classe_ue`
--

CREATE TABLE `classe_ue` (
  `idUE` varchar(30) NOT NULL,
  `idClasse` varchar(252) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ecu`
--

CREATE TABLE `ecu` (
  `idECU` varchar(30) NOT NULL,
  `codeECU` varchar(10) NOT NULL,
  `libelleECU` varchar(150) DEFAULT NULL,
  `idUE` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `idEtudiant` varchar(30) NOT NULL,
  `matricule` varchar(10) NOT NULL,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `sexe` char(1) DEFAULT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `datenaissance` date DEFAULT NULL,
  `lieunaissance` varchar(30) DEFAULT NULL,
  `nationalite` varchar(30) DEFAULT NULL,
  `codeStatut` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `etudier`
--

CREATE TABLE `etudier` (
  `idClasse` varchar(30) NOT NULL,
  `idEtudiant` varchar(30) NOT NULL,
  `idAnnee` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

CREATE TABLE `evaluation` (
  `idEvaluation` varchar(30) NOT NULL,
  `codeEval` varchar(10) NOT NULL,
  `libelleEval` varchar(150) DEFAULT NULL,
  `idECU` varchar(30) NOT NULL,
  `codeTypeEval` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `idFiliere` varchar(30) NOT NULL,
  `codeFiliere` varchar(10) NOT NULL,
  `libelleFiliere` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

CREATE TABLE `niveau` (
  `idNiveau` varchar(30) NOT NULL,
  `codeNiveau` varchar(10) NOT NULL,
  `libelleNiveau` varchar(100) NOT NULL,
  `duree` int(11) NOT NULL,
  `cycle` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `obtenir`
--

CREATE TABLE `obtenir` (
  `idEvaluation` varchar(30) NOT NULL,
  `idEtudiant` varchar(30) NOT NULL,
  `note` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `profiluser`
--

CREATE TABLE `profiluser` (
  `codeProfil` varchar(10) NOT NULL,
  `libelleProfil` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `profiluser`
--

INSERT INTO `profiluser` (`codeProfil`, `libelleProfil`, `created_at`, `update_at`) VALUES
('AD', 'Administrateur', '2020-10-26 18:53:15', '2020-10-26 18:53:15'),
('CS', 'Chef Sco', '2020-10-26 18:53:15', '2020-10-26 18:53:15'),
('DA', 'Directeur adjoint', '2020-10-26 18:53:15', '2020-10-26 18:53:15'),
('SC', 'SecrÃ©taire', '2020-10-26 18:53:15', '2020-10-26 18:53:15');

-- --------------------------------------------------------

--
-- Structure de la table `semestre`
--

CREATE TABLE `semestre` (
  `codeSemestre` int(11) NOT NULL,
  `libelleSemestre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE `statut` (
  `codeStatut` varchar(10) NOT NULL,
  `libelleStatut` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`codeStatut`, `libelleStatut`, `created_at`, `update_at`) VALUES
('PSST', 'Passant', '2020-10-26 18:53:50', '2020-10-26 18:53:50'),
('RDBT', 'Redoublant', '2020-10-26 18:53:50', '2020-10-26 18:53:50');

-- --------------------------------------------------------

--
-- Structure de la table `typeeval`
--

CREATE TABLE `typeeval` (
  `codeTypeEval` varchar(10) NOT NULL,
  `libelleTypeEval` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typeeval`
--

INSERT INTO `typeeval` (`codeTypeEval`, `libelleTypeEval`, `created_at`, `update_at`) VALUES
('CC', 'Controle continu', '2020-10-26 18:54:33', '2020-10-26 18:54:33'),
('EF', 'Examen Final', '2020-10-26 18:54:33', '2020-10-26 18:54:33'),
('RP', 'Reprise', '2020-10-26 18:54:33', '2020-10-26 18:54:33');

-- --------------------------------------------------------

--
-- Structure de la table `typeue`
--

CREATE TABLE `typeue` (
  `codeTypeUE` varchar(10) NOT NULL,
  `libelleTypeUE` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typeue`
--

INSERT INTO `typeue` (`codeTypeUE`, `libelleTypeUE`, `created_at`, `update_at`) VALUES
('SP', 'SpÃ©cialitÃ©', '2020-10-26 18:55:23', '2020-10-26 18:55:23'),
('TC', 'Tronc Commun', '2020-10-26 18:55:23', '2020-10-26 18:55:23');

-- --------------------------------------------------------

--
-- Structure de la table `ue`
--

CREATE TABLE `ue` (
  `idUE` varchar(30) NOT NULL,
  `codeUE` varchar(10) NOT NULL,
  `libelleUE` varchar(150) DEFAULT NULL,
  `coef` int(11) DEFAULT NULL,
  `codeTypeUE` varchar(10) DEFAULT NULL,
  `semestre` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `username` varchar(30) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `firstname` varchar(30) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) DEFAULT NULL,
  `codeProfil` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`username`, `name`, `firstname`, `email`, `password`, `codeProfil`, `created_at`, `update_at`) VALUES
('Abbayatta', 'AKPINFA', 'Ange', 'angecarlosakpinfa@gmail.com', 'Abbayatta', 'AD', '2020-10-26 18:57:23', '2020-10-26 18:57:23'),
('cscs', 'Jacques', 'Ayik', 'alinkoen@gmail.com', '147159', 'CS', '2020-10-26 18:57:23', '2020-10-26 18:57:23'),
('rayid01', 'ADEKAMBI', 'Souleimane', 'rayidjeri@gmail.com', '147schoosys159', 'DA', '2020-10-26 18:57:23', '2020-10-26 18:57:23'),
('scsc', 'Daddy', 'yanki', 'daddyska@gmail.com', '147159', 'SC', '2020-10-26 18:57:23', '2020-10-26 18:57:23');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `anneeacad`
--
ALTER TABLE `anneeacad`
  ADD PRIMARY KEY (`idAnnee`);

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`idClasse`),
  ADD KEY `classe_ibfk_1` (`idNiveau`),
  ADD KEY `classe_ibfk_2` (`idFiliere`);

--
-- Index pour la table `classe_ue`
--
ALTER TABLE `classe_ue`
  ADD PRIMARY KEY (`idUE`,`idClasse`),
  ADD KEY `classe_ue_ibfk_2` (`idClasse`);

--
-- Index pour la table `ecu`
--
ALTER TABLE `ecu`
  ADD PRIMARY KEY (`idECU`),
  ADD KEY `codeUE` (`idUE`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`idEtudiant`),
  ADD KEY `codeStatut` (`codeStatut`);

--
-- Index pour la table `etudier`
--
ALTER TABLE `etudier`
  ADD PRIMARY KEY (`idClasse`,`idEtudiant`,`idAnnee`),
  ADD KEY `etudier_ibfk_2` (`idEtudiant`),
  ADD KEY `etudier_ibfk_3` (`idAnnee`);

--
-- Index pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`idEvaluation`),
  ADD KEY `evaluation_ibfk_1` (`idECU`),
  ADD KEY `evaluation_ibfk_2` (`codeTypeEval`);

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`idFiliere`);

--
-- Index pour la table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`idNiveau`);

--
-- Index pour la table `obtenir`
--
ALTER TABLE `obtenir`
  ADD PRIMARY KEY (`idEvaluation`,`idEtudiant`),
  ADD KEY `obtenir_ibfk_2` (`idEtudiant`);

--
-- Index pour la table `profiluser`
--
ALTER TABLE `profiluser`
  ADD PRIMARY KEY (`codeProfil`);

--
-- Index pour la table `semestre`
--
ALTER TABLE `semestre`
  ADD PRIMARY KEY (`codeSemestre`);

--
-- Index pour la table `statut`
--
ALTER TABLE `statut`
  ADD PRIMARY KEY (`codeStatut`);

--
-- Index pour la table `typeeval`
--
ALTER TABLE `typeeval`
  ADD PRIMARY KEY (`codeTypeEval`);

--
-- Index pour la table `typeue`
--
ALTER TABLE `typeue`
  ADD PRIMARY KEY (`codeTypeUE`);

--
-- Index pour la table `ue`
--
ALTER TABLE `ue`
  ADD PRIMARY KEY (`idUE`),
  ADD KEY `ue_ibfk_1` (`codeTypeUE`),
  ADD KEY `semestre` (`semestre`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `users_ibfk_1` (`codeProfil`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `anneeacad`
--
ALTER TABLE `anneeacad`
  MODIFY `idAnnee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20212023;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `classe`
--
ALTER TABLE `classe`
  ADD CONSTRAINT `classe_ibfk_1` FOREIGN KEY (`idFiliere`) REFERENCES `filiere` (`idFiliere`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classe_ibfk_2` FOREIGN KEY (`idNiveau`) REFERENCES `niveau` (`idNiveau`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `classe_ue`
--
ALTER TABLE `classe_ue`
  ADD CONSTRAINT `classe_ue_ibfk_1` FOREIGN KEY (`idUE`) REFERENCES `ue` (`idUE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ecu`
--
ALTER TABLE `ecu`
  ADD CONSTRAINT `ecu_ibfk_1` FOREIGN KEY (`idUE`) REFERENCES `ue` (`idUE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`codeStatut`) REFERENCES `statut` (`codeStatut`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `etudier`
--
ALTER TABLE `etudier`
  ADD CONSTRAINT `etudier_ibfk_3` FOREIGN KEY (`idAnnee`) REFERENCES `anneeacad` (`idAnnee`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etudier_ibfk_6` FOREIGN KEY (`idClasse`) REFERENCES `classe` (`idClasse`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etudier_ibfk_7` FOREIGN KEY (`idEtudiant`) REFERENCES `etudiant` (`idEtudiant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_2` FOREIGN KEY (`codeTypeEval`) REFERENCES `typeeval` (`codeTypeEval`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evaluation_ibfk_3` FOREIGN KEY (`idECU`) REFERENCES `ecu` (`idECU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `obtenir`
--
ALTER TABLE `obtenir`
  ADD CONSTRAINT `obtenir_ibfk_1` FOREIGN KEY (`idEvaluation`) REFERENCES `evaluation` (`idEvaluation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `obtenir_ibfk_2` FOREIGN KEY (`idEtudiant`) REFERENCES `etudiant` (`idEtudiant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ue`
--
ALTER TABLE `ue`
  ADD CONSTRAINT `ue_ibfk_1` FOREIGN KEY (`codeTypeUE`) REFERENCES `typeue` (`codeTypeUE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ue_ibfk_2` FOREIGN KEY (`semestre`) REFERENCES `semestre` (`codeSemestre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`codeProfil`) REFERENCES `profiluser` (`codeProfil`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
