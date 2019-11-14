-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 14-11-2019 a las 20:33:12
-- Versión del servidor: 5.7.21
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `snowtricks`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CB281BE2E` (`trick_id`),
  KEY `IDX_9474526CA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comment`
--

INSERT INTO `comment` (`id`, `trick_id`, `contenu`, `created_at`, `user_id`) VALUES
(4, 69, 'Super !', '2019-10-14 09:18:28', 6),
(5, 69, 'Merci pour le trick !', '2019-10-14 09:18:57', 6),
(6, 69, 'trop cool!', '2019-10-14 09:20:00', 6),
(7, 69, 'J\'adore les photos', '2019-10-14 11:23:14', 6),
(8, 70, 'Un grab impresionant!', '2019-10-14 09:26:12', 6),
(9, 70, 'Cool', '2019-10-14 09:27:15', 6),
(10, 70, 'Cool', '2019-10-14 09:33:11', 6),
(11, 70, 'Cool', '2019-10-14 09:33:36', 6),
(24, 82, 'ysdy', '2019-11-14 15:59:07', 20),
(25, 90, 'asfasf', '2019-11-14 20:18:19', 6),
(26, 90, 'asfasf', '2019-11-14 20:18:21', 6),
(27, 90, 'asfasf', '2019-11-14 20:18:23', 6),
(28, 90, 'asfasf', '2019-11-14 20:18:26', 6),
(29, 90, 'asfasf', '2019-11-14 20:18:30', 6),
(30, 90, 'asfasf', '2019-11-14 20:18:33', 6),
(31, 90, 'asfasf', '2019-11-14 20:18:35', 6),
(32, 90, 'asfasf', '2019-11-14 20:18:38', 6),
(33, 90, 'asfasf', '2019-11-14 20:18:41', 6),
(34, 90, 'asfasf', '2019-11-14 20:18:43', 6),
(35, 90, 'asfasf', '2019-11-14 20:18:46', 6),
(36, 90, 'aaaaaaaaaaaa', '2019-11-14 20:18:51', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190718190800', '2019-07-18 19:08:05'),
('20190805160952', '2019-08-05 16:10:05'),
('20190805161245', '2019-08-05 16:12:50'),
('20190819124302', '2019-08-19 12:43:08'),
('20190820154015', '2019-08-20 15:42:18'),
('20190924102226', '2019-09-25 18:24:29'),
('20190925182820', '2019-09-25 18:28:25'),
('20190925184646', '2019-09-25 18:46:53'),
('20190926001117', '2019-09-26 00:11:25'),
('20191005164323', '2019-10-05 16:43:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `picture`
--

DROP TABLE IF EXISTS `picture`;
CREATE TABLE IF NOT EXISTS `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_16DB4F89B281BE2E` (`trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `picture`
--

INSERT INTO `picture` (`id`, `trick_id`, `name`) VALUES
(19, 69, '/pictures/bbd6dde2db10b6c29f012e210efbaa3d.jpeg'),
(20, 69, '/pictures/2537359ed87277756815e6443c47cb15.jpeg'),
(21, 70, '/pictures/0c5c49d5ac9afc6c376d2c1bdab011e2.jpeg'),
(22, 70, '/pictures/1b22b5d2742466d0e6b0c5739bfefda2.jpeg'),
(23, 70, '/pictures/1c2e11be3fe6f65e98470dbe1f97abac.jpeg'),
(24, 71, '/pictures/d071856039d103405699d75081bef6df.jpeg'),
(25, 71, '/pictures/6acfd34139b89252c2f90cc2602e8eb0.jpeg'),
(26, 72, '/pictures/1a0190aa52419c849c96054763b31f4f.jpeg'),
(27, 72, '/pictures/42f82b8ff7cf68dfe8d6271a13f3f0b3.jpeg'),
(28, 72, '/pictures/3525bb4ebc08609e3436295fb0c3b381.jpeg'),
(32, 74, '/pictures/a53b2ea88d4dc3ef92724142ebda8074.jpeg'),
(33, 74, '/pictures/9beb77b537d56d57032cf364f2036b3e.jpeg'),
(34, 74, '/pictures/5fa1a6ae55afcee43c0d0070d766dfa3.jpeg'),
(35, 76, '/pictures/22cdc2dedf581a6b97b3390e390f8d63.jpeg'),
(36, 76, '/pictures/11c508e5e6410f80206318db8af64786.jpeg'),
(37, 76, '/pictures/c55b364fb8df8850165612f1e5e354b7.jpeg'),
(38, 77, '/pictures/2ebb9de49c076b11b5e21ee85b3535bb.jpeg'),
(39, 77, '/pictures/43b7fa3ac4a9b21321f15ea1c6c056d2.jpeg'),
(40, 77, '/pictures/996985224ed64b910d600191c256eba2.jpeg'),
(41, 78, '/pictures/4d644eabd3d011afd64b8a17850040c7.jpeg'),
(42, 78, '/pictures/a1b45dba6dfdaa9cbbe9aa322445588a.jpeg'),
(43, 78, '/pictures/a2ca5a9589e992dfa29700389c781e21.jpeg'),
(50, 81, '/pictures/3c85909a8f3083683e32df25275f3f08.jpeg'),
(51, 81, '/pictures/7f4434ab42a2051fc7d5d8b6c2961429.jpeg'),
(52, 81, '/pictures/95047718a47386cb178948a2da9b3a20.jpeg'),
(53, 82, '/pictures/06b8a4fe10f7aa7ae6a24fdf363b054c.jpeg'),
(54, 82, '/pictures/d45ac8efd93d3e8edbdfab932c15034e.jpeg'),
(55, 82, '/pictures/98ef84fea91ea81c69c243eb37035fe9.jpeg'),
(65, 90, '/pictures/90b5d15bb4ca6d7c8a8cb11e2212eb4c.jpeg'),
(66, 90, '/pictures/e67ac4fdd75029721f6a109f91ae0040.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `token_password`
--

DROP TABLE IF EXISTS `token_password`;
CREATE TABLE IF NOT EXISTS `token_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration_date` datetime NOT NULL,
  `valid` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_419D9B56A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `token_password`
--

INSERT INTO `token_password` (`id`, `token`, `expiration_date`, `valid`, `user_id`) VALUES
(1, 'd7bb16a9c62b0afcab98558de616574b2ccc4ae24dc6c5aaf9161453a588df56', '2019-09-26 18:48:17', 0, 16),
(2, '2d09e307b6fc3ec657b71273a5d832fc39aa4842aa6a60f80be066d37cee99ea', '2019-10-22 21:36:33', 0, 18),
(3, '2140038892bbf74796581c8bb670b420abc63542185d69a2f31e8f2f275942e1', '2019-11-15 14:07:33', 1, 19),
(4, 'e7c09eb04936a1b820b738b300de9271df05f46885320747329ff9df7fee14cd', '2019-11-15 14:59:58', 1, 20),
(5, 'e7998a6a4e172183306daff35361850e1debeefe84c1a21a1eb73c2d50d91600', '2019-11-15 19:20:35', 1, 20),
(6, '8291795c6fd67e6ab0b614534b0b72e037908a964cb7664da5b1bef61d7f8d88', '2019-11-15 19:30:46', 1, 20),
(7, 'd35dc98e6b4f67c036c5ce3320c3754fc4f9d230f8a861f772a905464612309a', '2019-11-15 19:32:38', 1, 20),
(8, '6defc37337fbfd091275e918b824e0b1a1618bcbb2bcdc04678674cafe54e3c4', '2019-11-15 19:33:38', 0, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trick`
--

DROP TABLE IF EXISTS `trick`;
CREATE TABLE IF NOT EXISTS `trick` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D8F0A91EA76ED395` (`user_id`),
  KEY `IDX_D8F0A91EC54C8C93` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `trick`
--

INSERT INTO `trick` (`id`, `user_id`, `type_id`, `name`, `description`, `created_at`, `updated_at`, `picture`) VALUES
(69, 6, 4, 'Tail grab', 'Saisie de la partie arrière de la planche, avec la main arrière.', '2019-10-14 11:11:00', NULL, '/pictures/tailgrab.jpg'),
(70, 6, 4, 'Stalefish', 'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.', '2019-10-14 11:25:47', NULL, '/pictures/stalefish.jpg'),
(71, 6, 4, 'Nose grab', 'Saisie de la partie avant de la planche, avec la main avant.', '2019-10-14 11:35:56', NULL, '/pictures/nosegrab.jpg'),
(72, 6, 4, 'Japan air', 'saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.', '2019-10-14 11:37:20', NULL, '/pictures/japanair.jpg'),
(74, 6, 3, '720º', '720, sept deux pour deux tours complets.\r\nUne rotation peut être frontside ou backside : une rotation frontside correspond à une rotation orientée vers la carre backside.', '2019-10-14 11:40:51', NULL, '/pictures/7203.jpg'),
(76, 6, 3, '360º', '360, trois six pour un tour complet.\r\nOn désigne par le mot « rotation » uniquement des rotations horizontales ; les rotations verticales sont des flips. Le principe est d\'effectuer une rotation horizontale pendant le saut, puis d\'attérir en position switch ou normal.', '2019-10-14 11:51:08', '2019-10-15 10:15:24', '/pictures/3603.jpg'),
(77, 6, 1, 'Front flip', 'Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.', '2019-10-14 11:52:37', NULL, '/pictures/frontflip2.jpg'),
(78, 6, 1, 'Back flip', 'Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.', '2019-10-14 11:53:21', NULL, '/pictures/backflip3.jpg'),
(81, 6, 2, 'Nose slide', 'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.\r\nOn peut slider avec la planche centrée par rapport à la barre (celle-ci se situe approximativement au-dessous des pieds du rideur), mais aussi en nose slide, c\'est-à-dire l\'avant de la planche sur la barre, ou en tail slide, l\'arrière de la planche sur la barre.', '2019-10-14 11:57:30', NULL, '/pictures/noseslide3.jpg'),
(82, 6, 2, 'Tail slide', 'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.\r\nOn peut slider avec la planche centrée par rapport à la barre (celle-ci se situe approximativement au-dessous des pieds du rideur), mais aussi en nose slide, c\'est-à-dire l\'avant de la planche sur la barre, ou en tail slide, l\'arrière de la planche sur la barre.', '2019-10-14 11:58:27', NULL, '/pictures/tailslide2.jpg'),
(90, 6, 2, 'salutfasfas', 'eeeeeeeeeeeeeeefefef', '2019-11-14 20:18:07', '2019-11-14 21:03:17', '/pictures/wolf.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `type`
--

INSERT INTO `type` (`id`, `name`) VALUES
(1, 'Flip'),
(2, 'slide'),
(3, 'rotation'),
(4, 'grab');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, '', '', '', ''),
(3, 'pepe', '$2y$13$rsKXuL1wQJBgSQqdwipkDuTDkiY2ykM2ItOd.tYOzVdy4oB0nRAF6', 'farssffuu@hotmail.com', 'ROLE_USER'),
(4, 'zewi', '$2y$13$PhPbdxCqZYl9U2ejsUPACutNLTZquqkwxlJuz2st6hE5KGKDImcXy', 'farsdsffuu@hotmail.com', 'ROLE_USER'),
(5, 'zewiaewqwr', '$2y$13$SlM6Fi6cS5d8Ys8RdVEa0.UqGauYFYTcblP/0xWW.jKEGCYMTqPKK', 'farssssdsffuu@hotmail.com', 'ROLE_USER'),
(6, 'esepep', '$2y$13$bey.LGJdeHzYi5U72uRVXucL3x4shefqWFqs/GguCA37.lUscykt.', 'josemadridsgil90@gmail.com', 'ROLE_USER'),
(7, 'zemmaru', '$2y$13$zKQ.oJLusFYzaQcFCAtABOWRS9UPr9P9RSSDrwiaWpFtXk/oDK/hO', 'fffarfuu@hotmail.com', 'ROLE_ADMIN'),
(8, 'julien', '$2y$13$YR1ZAWu/JAsajjP48kiieOWuMLrujC56bfoapDVbf2yzF3qsSAuJ.', 'fsssarfuu@hotmail.com', 'ROLE_USER'),
(9, 'julie', '$2y$13$.y1y1hXOiELnWfwCBoywwe1sHm.MeTgrWx.mmAXgxR5yO8Bj6jx9q', 'farddddfuu@hotmail.com', 'ROLE_USER'),
(13, 'esepepito', '$2y$13$gJrVxuRJrVD/252WIgvZN.K0CtsvDjvQ0coQj8nGw4ocTJFSNpnem', 'farfuu@hotmail.com', 'ROLE_USER'),
(15, 'zemarita', '$2y$13$MJ4aeHFduqoP5JSeIGAnwuBnV6l.AkSNpCKUAf3njrFngx34n12ne', 'josemadridsgil90@gmail.com', 'ROLE_USER'),
(16, 'zxczxc', '$2y$13$RccSEhpEp5kUYrt.PJ5S1OS4VhX61bQN9Anrg5cTKDZwWyxs.nFgy', 'josemadridgi90@gmail.com', 'ROLE_USER'),
(18, 'eva', '$2y$13$AH/VHcB2AbsDUmnkPT3hTO8oYB4e4sSHL6PUDt/BSn/znbFRCQkIO', 'josemadridgildfg90@gmail.com', 'ROLE_USER'),
(19, 'se', '$2y$13$qvFSPjVocUIE/PQq2D9PJuOi7jo7E9OrDXKiqq1Ph5ICAcyrHZmE6', 'josemadrifdgil90@gmail.com', 'ROLE_USER'),
(20, 'robert', '$2y$13$g0laeIqpEA6AsjzLj8q4juAVIv67NZKU5jvwOUa/ERJrBdjHR94ke', 'josemadridgil90@gmail.com', 'ROLE_USER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CC7DA2CB281BE2E` (`trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `video`
--

INSERT INTO `video` (`id`, `trick_id`, `url`) VALUES
(26, 69, 'https://www.youtube.com/embed/_Qq-YoXwNQY'),
(27, 70, 'https://www.youtube.com/embed/f9FjhCt_w2U'),
(28, 71, 'https://www.youtube.com/embed/gZFWW4Vus-Q'),
(29, 72, 'https://www.youtube.com/embed/CzDjM7h_Fwo'),
(31, 74, 'https://www.youtube.com/embed/4JfBfQpG77o'),
(33, 76, 'https://www.youtube.com/embed/hUddT6FGCws'),
(34, 77, 'https://www.youtube.com/embed/xhvqu2XBvI0'),
(35, 78, 'https://www.youtube.com/embed/arzLq-47QFA'),
(38, 81, 'https://www.youtube.com/embed/oAK9mK7wWvw'),
(39, 82, 'https://www.youtube.com/embed/HRNXjMBakwM'),
(56, 90, 'https://www.youtube.com/embed/OK_JCtrrv-c'),
(57, 90, 'https://www.youtube.com/embed/OK_JCtrrv-c'),
(58, 90, 'https://www.youtube.com/embed/BmuzxHvyhF8');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9474526CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Filtros para la tabla `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `FK_16DB4F89B281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Filtros para la tabla `token_password`
--
ALTER TABLE `token_password`
  ADD CONSTRAINT `FK_419D9B56A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_D8F0A91EC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`);

--
-- Filtros para la tabla `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
