-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2024 at 11:34 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eduwave1`
--

-- --------------------------------------------------------

--
-- Table structure for table `avis`
--

CREATE TABLE `avis` (
  `id` int(11) NOT NULL,
  `cours_id` int(11) NOT NULL,
  `etoiles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `avis`
--

INSERT INTO `avis` (`id`, `cours_id`, `etoiles`) VALUES
(41, 35, 5),
(42, 35, 3),
(43, 35, 1),
(45, 36, 2),
(46, 36, 3),
(47, 38, 3),
(48, 37, 2),
(49, 37, 5),
(50, 37, 3),
(51, 37, 4),
(52, 37, 4),
(53, 39, 3),
(54, 39, 5),
(55, 39, 4),
(56, 37, 4),
(57, 37, 5),
(58, 35, 4),
(59, 35, 4),
(60, 35, 4),
(61, 36, 3),
(62, 40, 3),
(63, 37, 4),
(64, 38, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categoriecodepromo`
--

CREATE TABLE `categoriecodepromo` (
  `id` int(100) NOT NULL,
  `code` varchar(200) NOT NULL,
  `value` float NOT NULL,
  `nb_users` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categoriecodepromo`
--

INSERT INTO `categoriecodepromo` (`id`, `code`, `value`, `nb_users`) VALUES
(12, 'aaz', 0.2, 1),
(13, '1az', 0.2, 1),
(16, '12z', 0.4, 5),
(20, 'hello123', 0.1, 5),
(23, 'hi000', 0.6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date_commentaire` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id` int(10) NOT NULL,
  `publication_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commentaire`
--

INSERT INTO `commentaire` (`id`, `contenu`, `date_commentaire`, `utilisateur_id`, `publication_id`) VALUES
(1, 'hdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdf', '2024-05-29 23:00:00', 75, 2),
(2, 'hfghjfgd', '2024-05-20 23:00:00', 59, 2),
(3, 'hgfdsh', '2024-05-04 09:33:23', 59, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) NOT NULL,
  `coursName` varchar(50) NOT NULL,
  `coursDescription` varchar(255) NOT NULL,
  `coursImage` varchar(255) NOT NULL,
  `coursPrix` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cours`
--

INSERT INTO `cours` (`id`, `coursName`, `coursDescription`, `coursImage`, `coursPrix`, `idCategory`) VALUES
(35, 'francais ', 'Cours validation', 'C:\\Users\\razan\\OneDrive\\Desktop\\integration\\DevHarmony\\src\\main\\resources\\418677530_360055920329676_2489057018682850579_n.png', 123, 36),
(36, 'englais', 'hello ', 'C:\\Users\\LENOVO\\Downloads\\cours-en-ligne.png', 230, 37),
(37, 'allemand', 'danke shon', 'C:\\Users\\LENOVO\\Downloads\\livre.png', 255, 37),
(38, 'turkish', 'cok guzel', 'C:\\Users\\LENOVO\\Downloads\\croissance.png', 260, 37),
(39, 'turkish', 'cok guzel', 'C:\\Users\\LENOVO\\Downloads\\croissance.png', 260, 36),
(40, 'valid', 'valid', 'C:\\Users\\razan\\Downloads\\418677530_360055920329676_2489057018682850579_n.png', 123, 37);

-- --------------------------------------------------------

--
-- Table structure for table `courscategory`
--

CREATE TABLE `courscategory` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courscategory`
--

INSERT INTO `courscategory` (`id`, `categoryName`) VALUES
(36, 'phy'),
(37, 'svt');

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messenger_messages`
--

INSERT INTO `messenger_messages` (`id`, `body`, `headers`, `queue_name`, `created_at`, `available_at`, `delivered_at`) VALUES
(1, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;N;i:1;N;i:2;s:1380:\\\"<!DOCTYPE html>\n<html lang=\\\"en\\\">\n<head>\n    <meta charset=\\\"UTF-8\\\">\n    <title>New Publication Created</title>\n    <style>\n        body {\n            font-family: Arial, sans-serif;\n            background-color: #f9f9f9;\n            color: #333;\n            margin: 0;\n            padding: 20px;\n        }\n        .container {\n            max-width: 600px;\n            margin: 0 auto;\n            background-color: #ffffff;\n            padding: 20px;\n            border: 1px solid #ddd;\n            border-radius: 8px;\n            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);\n        }\n        h1 {\n            font-size: 24px;\n            color: #2c3e50;\n            text-align: center;\n        }\n        p {\n            font-size: 16px;\n            line-height: 1.5;\n        }\n        ul {\n            list-style-type: none;\n            padding: 0;\n        }\n        li {\n            padding: 8px 0;\n        }\n    </style>\n</head>\n<body>\n    <div class=\\\"container\\\">\n        <h1>New Publication Created</h1>\n        <p>A new publication has been created:</p>\n        <ul>\n            <li><strong>Title:</strong> hdshwdfhdshwdfhdshwd</li>\n            <li><strong>Content:</strong> hdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdf</li>\n            <li><strong>Date of Publication:</strong> 2024-05-04 00:00:00</li>\n        </ul>\n    </div>\n</body>\n</html>\n\\\";i:3;s:5:\\\"utf-8\\\";i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:15:\\\"PIDEV@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:10:\\\"Relcamtion\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:25:\\\"mahourabensalem@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:23:\\\"New Publication Created\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2024-05-04 11:23:22', '2024-05-04 11:23:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `idplan` int(11) NOT NULL,
  `nom` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE `publication` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date_publication` timestamp NOT NULL DEFAULT current_timestamp(),
  `utilisateur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publication`
--

INSERT INTO `publication` (`id`, `titre`, `contenu`, `date_publication`, `utilisateur_id`) VALUES
(2, 'hdshwdfhdshwdfhdshwd', 'hdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdfhdshwdf', '2024-05-03 23:00:00', 90);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `id_user` int(10) NOT NULL,
  `id_cours` int(11) DEFAULT NULL,
  `resStatus` tinyint(1) NOT NULL,
  `date_reservation` datetime NOT NULL,
  `id_codepromo` int(100) NOT NULL,
  `prixd` float NOT NULL,
  `paidStatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(10) NOT NULL,
  `nom_role` varchar(255) NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `idtask` int(11) NOT NULL,
  `nomcour` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `etat` varchar(10) NOT NULL DEFAULT 'en attente',
  `idplan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `nom` varchar(15) NOT NULL,
  `prenom` varchar(15) NOT NULL,
  `role` varchar(15) NOT NULL,
  `age` int(10) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `num_tel` int(8) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `resetcode` int(20) DEFAULT NULL,
  `confirmcode` varchar(25) DEFAULT NULL,
  `statuscode` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `role`, `age`, `image`, `num_tel`, `email`, `mdp`, `status`, `resetcode`, `confirmcode`, `statuscode`) VALUES
(53, 'aziz', 'laabidi', 'Eleve', NULL, NULL, NULL, 'mohamedazizlabidi25@gmail.com', '$2a$10$Z7bfxnchsqGwzgaq0Pb1GumuChcEICdZcSp1xmb/Qd3OQEYRPyZGC', 'Active', NULL, 'verified', NULL),
(59, 'issaoui', 'nesrine', 'Eleve', NULL, NULL, NULL, 'nesrineissaoui05@gmail.com', 'nesrineissaoui05@gmail.com', 'Active', NULL, '116750', NULL),
(75, 'jemai', 'lilia', 'Enseignant', 24, 'lilia-662a7c3d1b27f.jpg', 27438527, 'liliajemai00@gmail.com', 'a51b486c534d1a7d235a0797bcaf937c', 'Active', NULL, '131959', NULL),
(90, 'jemai', 'lilia', 'Etudiant', 25, 'lilia-662f94973d443.jpg', 27438527, 'liliajemai2@gmail.com', 'd99acccf', 'Active', 636132, '963454', NULL),
(92, 'jemai', 'lilia', 'Etudiant', 23, 'lilia-662fa14c00402.jpg', 27438527, 'lilia.jemai@esprit.tn', '85cc951d', 'Active', 409446, '423588', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_avis` (`cours_id`);

--
-- Indexes for table `categoriecodepromo`
--
ALTER TABLE `categoriecodepromo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nxvcjndhjg` (`utilisateur_id`);

--
-- Indexes for table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`idCategory`);

--
-- Indexes for table `courscategory`
--
ALTER TABLE `courscategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`idplan`);

--
-- Indexes for table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nxvcjn` (`utilisateur_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_codepromo` (`id_codepromo`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_cours` (`id_cours`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`idtask`),
  ADD KEY `idplan` (`idplan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `categoriecodepromo`
--
ALTER TABLE `categoriecodepromo`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cours`
--
ALTER TABLE `cours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `courscategory`
--
ALTER TABLE `courscategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `idplan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publication`
--
ALTER TABLE `publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `idtask` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `fk_avis` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `nxvcjndhjg` FOREIGN KEY (`utilisateur_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`idCategory`) REFERENCES `courscategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `publication`
--
ALTER TABLE `publication`
  ADD CONSTRAINT `nxvcjn` FOREIGN KEY (`utilisateur_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_codepromo`) REFERENCES `categoriecodepromo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`idplan`) REFERENCES `plan` (`idplan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
