-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 19 Décembre 2017 à 06:20
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ngbdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `online` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `user_id`, `date_created`, `thumb`, `slug`, `category_id`, `online`) VALUES
(1, 'fermentum metus. Aenean sed pede', 'Lorem ipsum dolor sit amet,', 2, '2017-09-03 11:21:36', 'default.png', 'consectetuer adipiscing elit. Etiam laoreet,', '4', 1),
(2, 'posuere cubilia Curae; Phasellus ornare.', 'Lorem ipsum dolor sit amet,', 2, '2018-02-07 12:37:30', 'default.png', 'Integer eu lacus. Quisque imperdiet,', '10', 1),
(3, 'lorem, auctor quis, tristique ac,', 'Lorem', 3, '2018-11-06 16:41:49', 'default.png', 'euismod in, dolor. Fusce feugiat.', '7', 1),
(4, 'odio tristique pharetra. Quisque ac', 'Lorem ipsum dolor sit', 5, '2017-02-13 11:49:53', 'default.png', 'et ipsum cursus vestibulum. Mauris', '8', 1),
(5, 'rhoncus. Nullam velit dui, semper', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 5, '2017-10-26 02:46:13', 'default.png', 'tellus. Aenean egestas hendrerit neque.', '10', 1),
(6, 'ac turpis egestas. Aliquam fringilla', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 4, '2018-10-07 20:11:49', 'default.png', 'non, bibendum sed, est. Nunc', '8', 1),
(7, 'sociis natoque penatibus et magnis', 'Lorem ipsum dolor sit amet, consectetuer', 2, '2018-10-01 11:40:52', 'default.png', 'blandit mattis. Cras eget nisi', '2', 1),
(8, 'tristique senectus et netus et', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 5, '2017-06-17 00:45:39', 'default.png', 'semper. Nam tempor diam dictum', '5', 1),
(9, 'molestie pharetra nibh. Aliquam ornare,', 'Lorem ipsum dolor sit', 3, '2017-10-02 07:50:08', 'default.png', 'egestas hendrerit neque. In ornare', '7', 1),
(10, 'quis, pede. Praesent eu dui.', 'Lorem ipsum dolor sit amet, consectetuer', 5, '2017-09-23 07:13:36', 'default.png', 'odio. Phasellus at augue id', '9', 1),
(11, 'pede nec ante blandit viverra.', 'Lorem ipsum dolor sit', 4, '2018-06-12 22:56:17', 'default.png', 'volutpat. Nulla dignissim. Maecenas ornare', '10', 1),
(12, 'Fusce feugiat. Lorem ipsum dolor', 'Lorem', 4, '2018-04-15 18:29:43', 'default.png', 'vel quam dignissim pharetra. Nam', '4', 1),
(13, 'sagittis augue, eu tempor erat', 'Lorem ipsum dolor sit amet, consectetuer', 2, '2017-10-08 06:32:54', 'default.png', 'venenatis lacus. Etiam bibendum fermentum', '2', 1),
(14, 'pellentesque, tellus sem mollis dui,', 'Lorem ipsum dolor sit amet,', 5, '2017-12-12 01:00:50', 'default.png', 'ridiculus mus. Proin vel arcu', '5', 1),
(15, 'sociis natoque penatibus et magnis', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 1, '2017-08-08 18:46:08', 'default.png', 'placerat velit. Quisque varius. Nam', '1', 1),
(16, 'amet lorem semper auctor. Mauris', 'Lorem', 2, '2018-02-08 15:43:40', 'default.png', 'sem molestie sodales. Mauris blandit', '4', 1),
(17, 'mi pede, nonummy ut, molestie', 'Lorem ipsum dolor sit amet,', 5, '2018-05-29 14:50:15', 'default.png', 'felis. Donec tempor, est ac', '3', 1),
(18, 'vestibulum, neque sed dictum eleifend,', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 2, '2017-04-04 08:45:45', 'default.png', 'non lorem vitae odio sagittis', '8', 1),
(19, 'mauris sit amet lorem semper', 'Lorem ipsum dolor', 1, '2017-11-09 15:06:33', 'default.png', 'eget nisi dictum augue malesuada', '6', 1),
(20, 'faucibus orci luctus et ultrices', 'Lorem', 4, '2017-09-18 09:08:12', 'default.png', 'Vestibulum ut eros non enim', '2', 1),
(21, 'ipsum primis in faucibus orci', 'Lorem ipsum dolor sit', 1, '2017-02-12 23:23:54', 'default.png', 'semper cursus. Integer mollis. Integer', '10', 1),
(22, 'aliquet vel, vulputate eu, odio.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 1, '2017-04-24 20:24:09', 'default.png', 'fringilla mi lacinia mattis. Integer', '2', 1),
(23, 'Etiam laoreet, libero et tristique', 'Lorem ipsum dolor sit', 4, '2018-02-21 03:54:17', 'default.png', 'magna, malesuada vel, convallis in,', '9', 1),
(24, 'eu nibh vulputate mauris sagittis', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 5, '2017-04-01 00:18:54', 'default.png', 'ante. Vivamus non lorem vitae', '5', 1),
(25, 'ligula. Aenean gravida nunc sed', 'Lorem ipsum', 5, '2017-12-02 14:57:05', 'default.png', 'nec, mollis vitae, posuere at,', '4', 1),
(26, 'parturient montes, nascetur ridiculus mus.', 'Lorem ipsum dolor sit', 2, '2017-08-20 19:42:43', 'default.png', 'quis, pede. Suspendisse dui. Fusce', '2', 1),
(27, 'sapien. Cras dolor dolor, tempus', 'Lorem', 3, '2017-05-31 09:47:37', 'default.png', 'Quisque tincidunt pede ac urna.', '7', 1),
(28, 'eu augue porttitor interdum. Sed', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 1, '2017-04-27 05:05:46', 'default.png', 'mollis. Duis sit amet diam', '5', 1),
(29, 'diam eu dolor egestas rhoncus.', 'Lorem ipsum dolor sit amet,', 4, '2018-02-24 08:57:42', 'default.png', 'Nulla eget metus eu erat', '8', 1),
(30, 'commodo auctor velit. Aliquam nisl.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 3, '2018-05-07 20:11:22', 'default.png', 'eu, eleifend nec, malesuada ut,', '3', 1),
(31, 'odio. Phasellus at augue id', 'Lorem ipsum', 3, '2017-04-07 04:18:28', 'default.png', 'fringilla. Donec feugiat metus sit', '7', 1),
(32, 'eleifend. Cras sed leo. Cras', 'Lorem ipsum dolor sit', 4, '2017-04-21 13:52:12', 'default.png', 'id, erat. Etiam vestibulum massa', '2', 1),
(33, 'montes, nascetur ridiculus mus. Proin', 'Lorem ipsum', 2, '2017-05-07 02:34:38', 'default.png', 'porttitor eros nec tellus. Nunc', '4', 1),
(34, 'justo nec ante. Maecenas mi', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 4, '2017-11-28 22:32:30', 'default.png', 'Cum sociis natoque penatibus et', '10', 1),
(35, 'tellus. Aenean egestas hendrerit neque.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 3, '2017-12-20 21:59:37', 'default.png', 'Vivamus nisi. Mauris nulla. Integer', '9', 1),
(36, 'rutrum urna, nec luctus felis', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 2, '2018-05-27 01:10:47', 'default.png', 'orci tincidunt adipiscing. Mauris molestie', '6', 1),
(37, 'metus. Aliquam erat volutpat. Nulla', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 4, '2018-05-25 17:53:26', 'default.png', 'eget, volutpat ornare, facilisis eget,', '3', 1),
(38, 'dictum cursus. Nunc mauris elit,', 'Lorem ipsum dolor sit amet,', 3, '2018-10-31 19:55:52', 'default.png', 'facilisis non, bibendum sed, est.', '8', 1),
(39, 'lobortis tellus justo sit amet', 'Lorem ipsum dolor sit', 5, '2018-08-19 14:01:02', 'default.png', 'eleifend, nunc risus varius orci,', '8', 1),
(40, 'luctus vulputate, nisi sem semper', 'Lorem ipsum dolor', 2, '2018-07-30 23:39:38', 'default.png', 'tincidunt orci quis lectus. Nullam', '5', 1),
(41, 'scelerisque neque. Nullam nisl. Maecenas', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 1, '2017-08-31 07:30:07', 'default.png', 'a, malesuada id, erat. Etiam', '5', 1),
(42, 'ante dictum cursus. Nunc mauris', 'Lorem ipsum dolor sit amet,', 3, '2017-11-14 13:39:07', 'default.png', 'Quisque ac libero nec ligula', '7', 1),
(43, 'imperdiet, erat nonummy ultricies ornare,', 'Lorem', 1, '2018-10-04 04:52:18', 'default.png', 'Nunc sed orci lobortis augue', '6', 1),
(44, 'sollicitudin adipiscing ligula. Aenean gravida', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 3, '2017-02-18 01:11:35', 'default.png', 'faucibus orci luctus et ultrices', '2', 1),
(45, 'semper rutrum. Fusce dolor quam,', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 5, '2017-12-15 13:15:56', 'default.png', 'Phasellus in felis. Nulla tempor', '6', 1),
(46, 'venenatis lacus. Etiam bibendum fermentum', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 3, '2017-04-01 10:28:53', 'default.png', 'quis massa. Mauris vestibulum, neque', '4', 1),
(47, 'velit eu sem. Pellentesque ut', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1, '2017-06-06 02:10:15', 'default.png', 'fermentum metus. Aenean sed pede', '5', 1),
(48, 'ipsum. Phasellus vitae mauris sit', 'Lorem ipsum dolor sit amet, consectetuer', 1, '2018-02-12 10:28:34', 'default.png', 'tortor. Nunc commodo auctor velit.', '4', 1),
(49, 'eleifend vitae, erat. Vivamus nisi.', 'Lorem ipsum dolor sit amet,', 3, '2018-04-20 12:12:37', 'default.png', 'velit egestas lacinia. Sed congue,', '6', 1),
(50, 'eu eros. Nam consequat dolor', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 5, '2018-12-07 14:48:46', 'default.png', 'non, bibendum sed, est. Nunc', '10', 1),
(51, 'rhoncus. Donec est. Nunc ullamcorper,', 'Lorem ipsum dolor sit', 5, '2018-03-02 14:11:23', 'default.png', 'velit. Pellentesque ultricies dignissim lacus.', '7', 1),
(52, 'consectetuer euismod est arcu ac', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 5, '2017-12-05 19:56:43', 'default.png', 'semper pretium neque. Morbi quis', '1', 1),
(53, 'interdum. Nunc sollicitudin commodo ipsum.', 'Lorem ipsum dolor sit amet, consectetuer', 1, '2017-01-29 15:10:27', 'default.png', 'felis purus ac tellus. Suspendisse', '5', 1),
(54, 'ridiculus mus. Aenean eget magna.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 3, '2017-07-28 03:02:37', 'default.png', 'ante, iaculis nec, eleifend non,', '6', 1),
(55, 'urna. Nullam lobortis quam a', 'Lorem ipsum dolor sit', 3, '2017-01-12 23:13:52', 'default.png', 'malesuada vel, venenatis vel, faucibus', '2', 1),
(56, 'tincidunt tempus risus. Donec egestas.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 3, '2017-05-19 23:38:50', 'default.png', 'enim mi tempor lorem, eget', '10', 1),
(57, 'vulputate ullamcorper magna. Sed eu', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 3, '2018-09-17 10:36:29', 'default.png', 'augue. Sed molestie. Sed id', '3', 1),
(58, 'netus et malesuada fames ac', 'Lorem', 4, '2017-03-26 00:45:16', 'default.png', 'Cum sociis natoque penatibus et', '3', 1),
(59, 'nec, eleifend non, dapibus rutrum,', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 4, '2017-05-19 12:32:23', 'default.png', 'interdum. Curabitur dictum. Phasellus in', '7', 1),
(60, 'tempor erat neque non quam.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 2, '2017-08-24 19:27:08', 'default.png', 'dui quis accumsan convallis, ante', '1', 1),
(61, 'mauris. Morbi non sapien molestie', 'Lorem', 2, '2018-11-20 09:14:33', 'default.png', 'Vestibulum ante ipsum primis in', '8', 1),
(62, 'non enim commodo hendrerit. Donec', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 2, '2017-11-16 05:15:33', 'default.png', 'mauris blandit mattis. Cras eget', '10', 1),
(63, 'sem magna nec quam. Curabitur', 'Lorem ipsum dolor sit amet, consectetuer', 5, '2017-05-06 10:00:12', 'default.png', 'pharetra nibh. Aliquam ornare, libero', '7', 1),
(64, 'elit, pellentesque a, facilisis non,', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 5, '2018-10-13 00:42:10', 'default.png', 'penatibus et magnis dis parturient', '3', 1),
(65, 'diam eu dolor egestas rhoncus.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 2, '2017-07-29 08:37:48', 'default.png', 'egestas. Aliquam fringilla cursus purus.', '7', 1),
(66, 'Integer urna. Vivamus molestie dapibus', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 3, '2018-08-21 14:16:56', 'default.png', 'Phasellus ornare. Fusce mollis. Duis', '4', 1),
(67, 'ligula elit, pretium et, rutrum', 'Lorem ipsum dolor sit', 1, '2017-06-18 23:43:41', 'default.png', 'nulla. Integer vulputate, risus a', '9', 1),
(68, 'lectus pede, ultrices a, auctor', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 3, '2017-07-30 04:30:27', 'default.png', 'congue, elit sed consequat auctor,', '9', 1),
(69, 'sed tortor. Integer aliquam adipiscing', 'Lorem ipsum dolor sit amet, consectetuer', 2, '2017-02-18 10:47:08', 'default.png', 'elit elit fermentum risus, at', '8', 1),
(70, 'libero et tristique pellentesque, tellus', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1, '2017-05-24 09:39:17', 'default.png', 'Cras dolor dolor, tempus non,', '3', 1),
(71, 'Vivamus non lorem vitae odio', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 1, '2018-10-26 05:07:59', 'default.png', 'euismod enim. Etiam gravida molestie', '5', 1),
(72, 'erat, eget tincidunt dui augue', 'Lorem ipsum dolor', 1, '2017-07-21 23:27:23', 'default.png', 'semper, dui lectus rutrum urna,', '4', 1),
(73, 'montes, nascetur ridiculus mus. Proin', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 1, '2018-04-12 02:41:39', 'default.png', 'fermentum risus, at fringilla purus', '3', 1),
(74, 'a felis ullamcorper viverra. Maecenas', 'Lorem ipsum dolor', 3, '2017-03-27 03:47:24', 'default.png', 'dolor. Donec fringilla. Donec feugiat', '1', 1),
(75, 'augue eu tellus. Phasellus elit', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 2, '2018-04-22 03:30:03', 'default.png', 'rutrum lorem ac risus. Morbi', '8', 1),
(76, 'litora torquent per conubia nostra,', 'Lorem ipsum dolor sit amet,', 5, '2018-11-24 02:00:20', 'default.png', 'sociis natoque penatibus et magnis', '1', 1),
(77, 'interdum. Nunc sollicitudin commodo ipsum.', 'Lorem ipsum dolor', 2, '2018-02-28 17:40:20', 'default.png', 'Nunc sollicitudin commodo ipsum. Suspendisse', '8', 1),
(78, 'Curabitur ut odio vel est', 'Lorem ipsum dolor sit amet,', 2, '2017-04-13 21:13:10', 'default.png', 'ultricies dignissim lacus. Aliquam rutrum', '7', 1),
(79, 'Etiam bibendum fermentum metus. Aenean', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1, '2018-04-23 23:00:47', 'default.png', 'tincidunt dui augue eu tellus.', '6', 1),
(80, 'Quisque fringilla euismod enim. Etiam', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 5, '2017-09-03 16:52:58', 'default.png', 'sit amet massa. Quisque porttitor', '4', 1),
(81, 'taciti sociosqu ad litora torquent', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 4, '2017-02-25 06:53:51', 'default.png', 'sem semper erat, in consectetuer', '6', 1),
(82, 'vitae aliquam eros turpis non', 'Lorem ipsum dolor', 4, '2018-04-22 10:34:38', 'default.png', 'nisi. Cum sociis natoque penatibus', '3', 1),
(83, 'turpis vitae purus gravida sagittis.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 3, '2017-06-19 23:56:33', 'default.png', 'Quisque fringilla euismod enim. Etiam', '6', 1),
(84, 'lacinia. Sed congue, elit sed', 'Lorem ipsum dolor sit', 3, '2017-04-19 13:39:22', 'default.png', 'lacus. Etiam bibendum fermentum metus.', '3', 1),
(85, 'molestie tortor nibh sit amet', 'Lorem ipsum dolor sit amet, consectetuer', 5, '2018-11-08 22:47:01', 'default.png', 'nec, euismod in, dolor. Fusce', '6', 1),
(86, 'mauris ipsum porta elit, a', 'Lorem ipsum', 2, '2017-03-04 13:03:15', 'default.png', 'Praesent interdum ligula eu enim.', '6', 1),
(87, 'non, hendrerit id, ante. Nunc', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 2, '2017-12-12 23:59:28', 'default.png', 'augue malesuada malesuada. Integer id', '8', 1),
(88, 'libero. Integer in magna. Phasellus', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 4, '2018-02-26 23:29:32', 'default.png', 'mattis velit justo nec ante.', '4', 1),
(89, 'Mauris ut quam vel sapien', 'Lorem', 2, '2017-10-26 21:13:30', 'default.png', 'Mauris vel turpis. Aliquam adipiscing', '10', 1),
(90, 'arcu. Vivamus sit amet risus.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 3, '2018-08-18 21:28:35', 'default.png', 'arcu. Vivamus sit amet risus.', '6', 1),
(91, 'fermentum convallis ligula. Donec luctus', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 2, '2018-06-22 02:33:32', 'default.png', 'feugiat metus sit amet ante.', '5', 1),
(92, 'dis parturient montes, nascetur ridiculus', 'Lorem ipsum', 4, '2017-07-09 17:25:45', 'default.png', 'et, lacinia vitae, sodales at,', '8', 1),
(93, 'purus, in molestie tortor nibh', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 4, '2018-06-10 19:11:48', 'default.png', 'vitae risus. Duis a mi', '7', 1),
(94, 'luctus aliquet odio. Etiam ligula', 'Lorem ipsum', 5, '2018-12-04 14:54:18', 'default.png', 'imperdiet ullamcorper. Duis at lacus.', '8', 1),
(95, 'vitae risus. Duis a mi', 'Lorem ipsum', 4, '2018-04-04 06:40:47', 'default.png', 'Suspendisse non leo. Vivamus nibh', '1', 1),
(96, 'lorem ipsum sodales purus, in', 'Lorem ipsum dolor sit amet, consectetuer', 5, '2017-06-10 09:18:29', 'default.png', 'mus. Donec dignissim magna a', '2', 1),
(97, 'nec tempus scelerisque, lorem ipsum', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 5, '2018-07-19 07:57:25', 'default.png', 'quis diam. Pellentesque habitant morbi', '1', 1),
(98, 'Vestibulum ante ipsum primis in', 'Lorem ipsum dolor sit amet,', 3, '2017-06-17 23:15:36', 'default.png', 'et nunc. Quisque ornare tortor', '1', 1),
(99, 'sem. Nulla interdum. Curabitur dictum.', 'Lorem ipsum dolor', 3, '2018-08-08 23:57:31', 'default.png', 'eget lacus. Mauris non dui', '7', 1),
(100, 'lacus. Aliquam rutrum lorem ac', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 2, '2017-03-17 11:56:41', 'default.png', 'Duis a mi fringilla mi', '6', 1);

-- --------------------------------------------------------

--
-- Structure de la table `blog`
--

CREATE TABLE `blog` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `category_id` int(10) DEFAULT NULL,
  `online` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blog`
--

INSERT INTO `blog` (`id`, `title`, `content`, `user_id`, `date_created`, `thumb`, `slug`, `category_id`, `online`) VALUES
(1, 'quis urna. Nunc quis arcu', 'Lorem ipsum dolor sit', 3, '2017-11-17 02:19:54', 'Ngpictures.jpg', 'Aliquam rutrum lorem ac risus.', 7, 1),
(2, 'Lorem ipsum dolor sit amet,', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 4, '2018-06-10 16:55:57', 'Ngpictures.jpg', 'cursus vestibulum. Mauris magna. Duis', 4, 1),
(3, 'ridiculus mus. Donec dignissim magna', 'Lorem ipsum dolor sit amet,', 1, '2017-10-06 00:58:09', 'Ngpictures.jpg', 'tristique neque venenatis lacus. Etiam', 5, 1),
(4, 'dignissim lacus. Aliquam rutrum lorem', 'Lorem ipsum dolor', 5, '2018-10-25 13:43:31', 'Ngpictures.jpg', 'magna tellus faucibus leo, in', 1, 1),
(5, 'justo nec ante. Maecenas mi', 'Lorem ipsum dolor sit amet, consectetuer', 4, '2017-04-08 02:26:59', 'Ngpictures.jpg', 'tellus justo sit amet nulla.', 7, 1),
(6, 'Ut sagittis lobortis mauris. Suspendisse', 'Lorem ipsum dolor', 1, '2018-05-27 12:55:49', 'Ngpictures.jpg', 'Duis elementum, dui quis accumsan', 4, 1),
(7, 'ipsum. Donec sollicitudin adipiscing ligula.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 5, '2017-09-07 12:33:31', 'Ngpictures.jpg', 'aliquet lobortis, nisi nibh lacinia', 3, 1),
(8, 'vel nisl. Quisque fringilla euismod', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 1, '2018-10-13 05:54:37', 'Ngpictures.jpg', 'natoque penatibus et magnis dis', 3, 1),
(9, 'Pellentesque ut ipsum ac mi', 'Lorem ipsum dolor sit amet, consectetuer', 3, '2017-10-20 20:28:10', 'Ngpictures.jpg', 'libero et tristique pellentesque, tellus', 3, 1),
(10, 'urna. Nunc quis arcu vel', 'Lorem', 3, '2017-02-24 19:32:57', 'Ngpictures.jpg', 'luctus et ultrices posuere cubilia', 9, 1),
(11, 'et magnis dis parturient montes,', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 2, '2018-02-05 14:36:22', 'Ngpictures.jpg', 'magna nec quam. Curabitur vel', 5, 1),
(12, 'dui, in sodales elit erat', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 2, '2017-10-01 00:37:02', 'Ngpictures.jpg', 'semper tellus id nunc interdum', 5, 1),
(13, 'imperdiet, erat nonummy ultricies ornare,', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 2, '2018-05-19 10:52:15', 'Ngpictures.jpg', 'felis. Nulla tempor augue ac', 10, 1),
(14, 'egestas hendrerit neque. In ornare', 'Lorem ipsum', 5, '2017-04-14 18:06:34', 'Ngpictures.jpg', 'volutpat nunc sit amet metus.', 9, 1),
(15, 'neque. Morbi quis urna. Nunc', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 3, '2017-03-31 02:48:58', 'Ngpictures.jpg', 'massa. Quisque porttitor eros nec', 6, 1),
(16, 'tristique senectus et netus et', 'Lorem ipsum dolor sit amet, consectetuer', 2, '2017-01-07 06:57:53', 'Ngpictures.jpg', 'pede, malesuada vel, venenatis vel,', 2, 1),
(17, 'tortor at risus. Nunc ac', 'Lorem', 2, '2018-09-09 03:04:11', 'Ngpictures.jpg', 'aliquet. Phasellus fermentum convallis ligula.', 3, 1),
(18, 'in, cursus et, eros. Proin', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 4, '2018-06-24 20:34:32', 'Ngpictures.jpg', 'ac tellus. Suspendisse sed dolor.', 2, 1),
(19, 'Aenean eget magna. Suspendisse tristique', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 2, '2018-09-07 06:08:34', 'Ngpictures.jpg', 'tempus risus. Donec egestas. Duis', 4, 1),
(20, 'non leo. Vivamus nibh dolor,', 'Lorem ipsum dolor', 1, '2017-02-02 03:11:10', 'Ngpictures.jpg', 'tristique pellentesque, tellus sem mollis', 9, 1),
(21, 'tempus eu, ligula. Aenean euismod', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 2, '2018-06-09 19:31:50', 'Ngpictures.jpg', 'Integer id magna et ipsum', 9, 1),
(22, 'hendrerit consectetuer, cursus et, magna.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 4, '2018-08-30 15:11:04', 'Ngpictures.jpg', 'ornare tortor at risus. Nunc', 4, 1),
(23, 'posuere at, velit. Cras lorem', 'Lorem ipsum dolor sit', 3, '2017-08-25 01:33:14', 'Ngpictures.jpg', 'dictum cursus. Nunc mauris elit,', 8, 1),
(24, 'sem mollis dui, in sodales', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 2, '2018-06-07 05:41:14', 'Ngpictures.jpg', 'eu, accumsan sed, facilisis vitae,', 5, 1),
(25, 'eu, euismod ac, fermentum vel,', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 4, '2017-12-22 22:22:11', 'Ngpictures.jpg', 'a feugiat tellus lorem eu', 1, 1),
(26, 'at arcu. Vestibulum ante ipsum', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 4, '2017-01-21 01:07:49', 'Ngpictures.jpg', 'Aenean massa. Integer vitae nibh.', 2, 1),
(27, 'cursus. Integer mollis. Integer tincidunt', 'Lorem ipsum', 2, '2018-09-12 23:40:00', 'Ngpictures.jpg', 'Nullam suscipit, est ac facilisis', 4, 1),
(28, 'imperdiet non, vestibulum nec, euismod', 'Lorem ipsum dolor sit', 4, '2017-06-24 08:07:31', 'Ngpictures.jpg', 'consectetuer mauris id sapien. Cras', 1, 1),
(29, 'rutrum eu, ultrices sit amet,', 'Lorem ipsum dolor sit amet, consectetuer', 5, '2018-08-29 20:39:26', 'Ngpictures.jpg', 'nulla magna, malesuada vel, convallis', 7, 1),
(30, 'tellus faucibus leo, in lobortis', 'Lorem ipsum dolor sit amet,', 1, '2018-01-21 18:17:14', 'Ngpictures.jpg', 'tortor at risus. Nunc ac', 9, 1),
(31, 'Phasellus in felis. Nulla tempor', 'Lorem ipsum dolor sit', 5, '2018-06-28 19:43:22', 'Ngpictures.jpg', 'sollicitudin adipiscing ligula. Aenean gravida', 2, 1),
(32, 'sem egestas blandit. Nam nulla', 'Lorem ipsum dolor sit', 4, '2018-01-19 06:38:45', 'Ngpictures.jpg', 'dictum. Proin eget odio. Aliquam', 2, 1),
(33, 'orci. Donec nibh. Quisque nonummy', 'Lorem', 3, '2018-05-13 11:20:25', 'Ngpictures.jpg', 'a odio semper cursus. Integer', 2, 1),
(34, 'ut, pellentesque eget, dictum placerat,', 'Lorem ipsum dolor sit amet, consectetuer', 4, '2018-08-27 22:09:35', 'Ngpictures.jpg', 'euismod enim. Etiam gravida molestie', 1, 1),
(35, 'urna, nec luctus felis purus', 'Lorem ipsum dolor sit amet, consectetuer', 3, '2018-10-08 11:52:58', 'Ngpictures.jpg', 'vitae semper egestas, urna justo', 2, 1),
(36, 'ipsum non arcu. Vivamus sit', 'Lorem ipsum dolor sit', 2, '2017-09-04 12:20:46', 'Ngpictures.jpg', 'mi pede, nonummy ut, molestie', 4, 1),
(37, 'montes, nascetur ridiculus mus. Proin', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 4, '2016-12-18 06:16:22', 'Ngpictures.jpg', 'molestie in, tempus eu, ligula.', 2, 1),
(38, 'augue malesuada malesuada. Integer id', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 3, '2017-11-07 10:30:17', 'Ngpictures.jpg', 'lorem ac risus. Morbi metus.', 3, 1),
(39, 'magnis dis parturient montes, nascetur', 'Lorem ipsum dolor', 2, '2017-03-09 23:26:41', 'Ngpictures.jpg', 'natoque penatibus et magnis dis', 5, 1),
(40, 'erat nonummy ultricies ornare, elit', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 2, '2018-10-12 09:44:30', 'Ngpictures.jpg', 'pellentesque, tellus sem mollis dui,', 1, 1),
(41, 'Sed malesuada augue ut lacus.', 'Lorem ipsum dolor sit amet,', 1, '2017-12-28 22:52:36', 'Ngpictures.jpg', 'turpis non enim. Mauris quis', 4, 1),
(42, 'Mauris non dui nec urna', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 3, '2017-02-14 09:08:15', 'Ngpictures.jpg', 'pede. Suspendisse dui. Fusce diam', 10, 1),
(43, 'sagittis placerat. Cras dictum ultricies', 'Lorem', 4, '2017-02-02 09:55:27', 'Ngpictures.jpg', 'ornare placerat, orci lacus vestibulum', 10, 1),
(44, 'vitae erat vel pede blandit', 'Lorem ipsum dolor sit amet, consectetuer', 4, '2017-02-02 20:21:45', 'Ngpictures.jpg', 'per inceptos hymenaeos. Mauris ut', 9, 1),
(45, 'quis urna. Nunc quis arcu', 'Lorem ipsum dolor sit amet,', 1, '2018-02-05 21:14:38', 'Ngpictures.jpg', 'nulla ante, iaculis nec, eleifend', 7, 1),
(46, 'nisl sem, consequat nec, mollis', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 4, '2017-11-18 00:06:00', 'Ngpictures.jpg', 'gravida non, sollicitudin a, malesuada', 2, 1),
(47, 'risus quis diam luctus lobortis.', 'Lorem ipsum', 1, '2018-06-06 21:24:48', 'Ngpictures.jpg', 'tempor diam dictum sapien. Aenean', 4, 1),
(48, 'gravida sagittis. Duis gravida. Praesent', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 2, '2017-02-09 14:29:54', 'Ngpictures.jpg', 'at, nisi. Cum sociis natoque', 3, 1),
(49, 'dictum eu, eleifend nec, malesuada', 'Lorem ipsum', 2, '2018-04-11 01:47:52', 'Ngpictures.jpg', 'tincidunt adipiscing. Mauris molestie pharetra', 1, 1),
(50, 'dui quis accumsan convallis, ante', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 5, '2017-09-17 03:35:22', 'Ngpictures.jpg', 'velit eu sem. Pellentesque ut', 7, 1),
(51, 'eget nisi dictum augue malesuada', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 4, '2017-11-22 19:37:25', 'Ngpictures.jpg', 'non nisi. Aenean eget metus.', 6, 1),
(52, 'Quisque imperdiet, erat nonummy ultricies', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 5, '2018-09-30 07:45:35', 'Ngpictures.jpg', 'enim. Sed nulla ante, iaculis', 5, 1),
(53, 'Nulla facilisis. Suspendisse commodo tincidunt', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 5, '2017-02-17 20:42:56', 'Ngpictures.jpg', 'ullamcorper magna. Sed eu eros.', 7, 1),
(54, 'Vivamus euismod urna. Nullam lobortis', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 3, '2017-06-04 23:38:18', 'Ngpictures.jpg', 'eget nisi dictum augue malesuada', 10, 1),
(55, 'neque vitae semper egestas, urna', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 3, '2017-01-03 20:39:51', 'Ngpictures.jpg', 'nec, malesuada ut, sem. Nulla', 7, 1),
(56, 'In tincidunt congue turpis. In', 'Lorem ipsum dolor sit', 3, '2017-04-28 23:48:48', 'Ngpictures.jpg', 'tincidunt nibh. Phasellus nulla. Integer', 10, 1),
(57, 'ornare, lectus ante dictum mi,', 'Lorem ipsum dolor sit amet,', 3, '2017-07-02 12:41:23', 'Ngpictures.jpg', 'Praesent interdum ligula eu enim.', 3, 1),
(58, 'vitae odio sagittis semper. Nam', 'Lorem', 1, '2017-10-23 05:16:06', 'Ngpictures.jpg', 'ante dictum cursus. Nunc mauris', 1, 1),
(59, 'non dui nec urna suscipit', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 1, '2018-05-18 01:50:57', 'Ngpictures.jpg', 'magnis dis parturient montes, nascetur', 2, 1),
(60, 'velit eu sem. Pellentesque ut', 'Lorem ipsum dolor', 3, '2018-10-20 18:01:29', 'Ngpictures.jpg', 'mattis ornare, lectus ante dictum', 6, 1),
(61, 'ridiculus mus. Donec dignissim magna', 'Lorem ipsum dolor sit amet, consectetuer', 3, '2017-01-01 14:23:43', 'Ngpictures.jpg', 'et netus et malesuada fames', 5, 1),
(62, 'turpis vitae purus gravida sagittis.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 1, '2018-04-27 16:25:34', 'Ngpictures.jpg', 'dignissim tempor arcu. Vestibulum ut', 5, 1),
(63, 'pellentesque, tellus sem mollis dui,', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1, '2018-11-02 00:11:31', 'Ngpictures.jpg', 'nulla. Donec non justo. Proin', 2, 1),
(64, 'orci. Ut sagittis lobortis mauris.', 'Lorem ipsum dolor sit', 3, '2018-10-21 07:01:22', 'Ngpictures.jpg', 'nec ante. Maecenas mi felis,', 2, 1),
(65, 'Donec egestas. Duis ac arcu.', 'Lorem ipsum dolor', 3, '2018-08-18 09:00:13', 'Ngpictures.jpg', 'sit amet, consectetuer adipiscing elit.', 1, 1),
(66, 'arcu. Sed et libero. Proin', 'Lorem ipsum dolor', 2, '2018-07-19 19:14:36', 'Ngpictures.jpg', 'Aliquam fringilla cursus purus. Nullam', 10, 1),
(67, 'Quisque varius. Nam porttitor scelerisque', 'Lorem ipsum dolor sit', 3, '2017-01-04 10:22:39', 'Ngpictures.jpg', 'odio tristique pharetra. Quisque ac', 4, 1),
(69, 'auctor vitae, aliquet nec, imperdiet', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 5, '2017-06-09 18:55:59', 'Ngpictures.jpg', 'Donec est mauris, rhoncus id,', 10, 1),
(70, 'diam. Duis mi enim, condimentum', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1, '2018-03-09 04:44:17', 'Ngpictures.jpg', 'molestie pharetra nibh. Aliquam ornare,', 6, 1),
(71, 'eu arcu. Morbi sit amet', 'Lorem', 2, '2018-10-14 22:36:15', 'Ngpictures.jpg', 'ac nulla. In tincidunt congue', 7, 1),
(72, 'amet luctus vulputate, nisi sem', 'Lorem', 5, '2017-07-22 03:00:22', 'Ngpictures.jpg', 'dis parturient montes, nascetur ridiculus', 9, 1),
(73, 'Maecenas libero est, congue a,', 'Lorem ipsum dolor sit amet, consectetuer', 1, '2018-07-18 12:19:30', 'Ngpictures.jpg', 'ligula. Donec luctus aliquet odio.', 8, 1),
(74, 'Proin velit. Sed malesuada augue', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 1, '2017-02-09 05:36:57', 'Ngpictures.jpg', 'sagittis semper. Nam tempor diam', 1, 1),
(75, 'in, tempus eu, ligula. Aenean', 'Lorem ipsum dolor sit amet,', 5, '2018-02-25 08:04:03', 'Ngpictures.jpg', 'et arcu imperdiet ullamcorper. Duis', 6, 1),
(76, 'nibh enim, gravida sit amet,', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 2, '2018-04-21 01:02:13', 'Ngpictures.jpg', 'Donec feugiat metus sit amet', 2, 1),
(77, 'mauris ut mi. Duis risus', 'Lorem ipsum dolor sit', 3, '2018-05-21 20:38:06', 'Ngpictures.jpg', 'venenatis a, magna. Lorem ipsum', 1, 1),
(78, 'ipsum ac mi eleifend egestas.', 'Lorem', 3, '2018-10-07 11:04:37', 'Ngpictures.jpg', 'pede et risus. Quisque libero', 6, 1),
(79, 'sagittis semper. Nam tempor diam', 'Lorem ipsum dolor sit', 2, '2016-12-26 22:11:40', 'Ngpictures.jpg', 'amet ornare lectus justo eu', 2, 1),
(80, 'fermentum arcu. Vestibulum ante ipsum', 'Lorem ipsum dolor sit amet,', 5, '2018-08-02 07:32:13', 'Ngpictures.jpg', 'rutrum urna, nec luctus felis', 3, 1),
(81, 'rutrum. Fusce dolor quam, elementum', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 5, '2018-09-30 17:34:28', 'Ngpictures.jpg', 'id sapien. Cras dolor dolor,', 4, 1),
(82, 'molestie. Sed id risus quis', 'Lorem ipsum dolor sit amet,', 1, '2017-06-27 13:44:51', 'Ngpictures.jpg', 'vestibulum lorem, sit amet ultricies', 8, 1),
(83, 'arcu. Vestibulum ut eros non', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 4, '2017-10-31 09:32:27', 'Ngpictures.jpg', 'magnis dis parturient montes, nascetur', 9, 1),
(84, 'vitae diam. Proin dolor. Nulla', 'Lorem ipsum dolor sit amet,', 2, '2017-02-18 13:48:07', 'Ngpictures.jpg', 'amet metus. Aliquam erat volutpat.', 9, 1),
(85, 'penatibus et magnis dis parturient', 'Lorem', 4, '2017-06-20 22:12:30', 'Ngpictures.jpg', 'id, libero. Donec consectetuer mauris', 4, 1),
(86, 'vel, vulputate eu, odio. Phasellus', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 4, '2016-12-18 03:07:37', 'Ngpictures.jpg', 'risus. In mi pede, nonummy', 10, 1),
(87, 'sollicitudin adipiscing ligula. Aenean gravida', 'Lorem ipsum dolor sit amet,', 1, '2018-08-15 14:27:52', 'Ngpictures.jpg', 'Nullam feugiat placerat velit. Quisque', 6, 1),
(88, 'dictum. Phasellus in felis. Nulla', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 2, '2017-09-13 15:25:26', 'Ngpictures.jpg', 'Phasellus nulla. Integer vulputate, risus', 10, 1),
(89, 'diam. Pellentesque habitant morbi tristique', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 1, '2017-01-15 01:35:29', 'Ngpictures.jpg', 'non enim. Mauris quis turpis', 6, 1),
(90, 'lectus ante dictum mi, ac', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 5, '2018-07-24 06:52:39', 'Ngpictures.jpg', 'lobortis ultrices. Vivamus rhoncus. Donec', 10, 1),
(91, 'vehicula risus. Nulla eget metus', 'Lorem ipsum', 1, '2017-02-25 11:13:33', 'Ngpictures.jpg', 'risus. Donec nibh enim, gravida', 10, 1),
(92, 'tincidunt orci quis lectus. Nullam', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 2, '2018-04-24 07:44:47', 'Ngpictures.jpg', 'hendrerit id, ante. Nunc mauris', 6, 1),
(93, 'nec quam. Curabitur vel lectus.', 'Lorem ipsum dolor sit', 2, '2018-01-21 12:52:00', 'Ngpictures.jpg', 'Donec elementum, lorem ut aliquam', 1, 1),
(94, 'ante blandit viverra. Donec tempus,', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 1, '2017-07-21 17:25:17', 'Ngpictures.jpg', 'sed consequat auctor, nunc nulla', 6, 1),
(95, 'ullamcorper viverra. Maecenas iaculis aliquet', 'Lorem', 3, '2018-05-28 02:00:28', 'Ngpictures.jpg', 'vel, faucibus id, libero. Donec', 4, 1),
(96, 'tincidunt tempus risus. Donec egestas.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 5, '2017-08-24 00:24:00', 'Ngpictures.jpg', 'facilisis, magna tellus faucibus leo,', 5, 1),
(97, 'aliquet lobortis, nisi nibh lacinia', 'Lorem', 2, '2017-08-25 18:31:34', 'Ngpictures.jpg', 'magnis dis parturient montes, nascetur', 8, 1),
(98, 'nulla magna, malesuada vel, convallis', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed', 3, '2017-01-27 10:40:18', 'Ngpictures.jpg', 'mi felis, adipiscing fringilla, porttitor', 5, 1),
(99, 'id, ante. Nunc mauris sapien,', 'Lorem ipsum', 2, '2017-04-08 23:36:45', 'Ngpictures.jpg', 'ipsum nunc id enim. Curabitur', 9, 1),
(100, 'Praesent luctus. Curabitur egestas nunc', 'Lorem ipsum dolor', 3, '2017-07-09 04:12:01', 'Ngpictures.jpg', 'eros. Proin ultrices. Duis volutpat', 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'anniverseraire'),
(2, 'art'),
(3, 'musique'),
(4, 'mode et fashion'),
(5, 'religion'),
(6, 'culture'),
(7, 'technologie'),
(8, 'evenement'),
(9, 'autres'),
(10, 'black and white');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `articles` int(10) UNSIGNED DEFAULT NULL,
  `galery` int(10) UNSIGNED DEFAULT NULL,
  `blog` int(10) UNSIGNED DEFAULT NULL,
  `nggalery` int(10) UNSIGNED DEFAULT NULL,
  `comment` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `articles`, `galery`, `blog`, `nggalery`, `comment`, `date_created`) VALUES
(1, 5, NULL, NULL, 64, NULL, '&lt;p&gt;cool&lt;/p&gt;', '2017-12-19 08:04:34');

-- --------------------------------------------------------

--
-- Structure de la table `following`
--

CREATE TABLE `following` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `follower_id` int(11) UNSIGNED NOT NULL,
  `followed_id` int(11) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gallery`
--

CREATE TABLE `gallery` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `thumb` varchar(1000) NOT NULL,
  `description` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(255) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `article_id` int(10) UNSIGNED DEFAULT NULL,
  `photo_id` int(10) UNSIGNED DEFAULT NULL,
  `blog_id` int(10) UNSIGNED DEFAULT NULL,
  `ngphoto_id` int(10) UNSIGNED DEFAULT NULL,
  `date_created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `article_id`, `photo_id`, `blog_id`, `ngphoto_id`, `date_created`) VALUES
(47, 5, NULL, NULL, 98, NULL, '2017-12-16 22:23:22'),
(55, 5, NULL, NULL, 100, NULL, '2017-12-16 22:26:55'),
(3, 5, 98, NULL, NULL, NULL, '2017-12-16 00:18:22'),
(5, 5, NULL, NULL, 87, NULL, '2017-12-16 20:14:11'),
(51, 5, NULL, NULL, 99, NULL, '2017-12-16 22:25:29'),
(15, 5, NULL, NULL, 97, NULL, '2017-12-16 20:33:32'),
(56, 5, NULL, NULL, 96, NULL, '2017-12-16 22:27:28'),
(58, 5, 100, NULL, NULL, NULL, '2017-12-16 22:28:18');

-- --------------------------------------------------------

--
-- Structure de la table `ng_gallery`
--

CREATE TABLE `ng_gallery` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '1',
  `thumb` varchar(1000) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `online`
--

CREATE TABLE `online` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `online_time` timestamp NOT NULL,
  `date_created` timestamp NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facebook_id` bigint(255) DEFAULT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` longtext NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `bio` text,
  `avatar` varchar(255) NOT NULL,
  `confirmation_token` varchar(60) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `remember_token` varchar(60) DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT NULL,
  `rank` varchar(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `facebook_id`, `name`, `email`, `password`, `phone`, `bio`, `avatar`, `confirmation_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`, `status`, `rank`) VALUES
(4, 0, 'vv', 'v@v.com', '$2y$10$q075C0PNw3.Y49fU5c4Yt.7a9gJlDMot91TTGIBK.z/xaFuEaK5uy', NULL, NULL, 'default.jpg', NULL, '2017-12-13 21:27:01', NULL, NULL, '3998.5a31873c63', NULL, 'user'),
(5, NULL, 'bernard_ng', 'ng@ng.com', '$2y$10$RYlVy9yaHjQ8agTlsjnbyuSE2q5sv5ecXzaSYZE2GvtdIoEXcJ/3.', NULL, NULL, 'default.jpg', NULL, '2017-12-16 00:09:39', NULL, NULL, NULL, NULL, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `verses`
--

CREATE TABLE `verses` (
  `id` int(11) UNSIGNED NOT NULL,
  `text` varchar(1000) NOT NULL,
  `ref` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `verses`
--

INSERT INTO `verses` (`id`, `text`, `ref`) VALUES
(1, 'Et vous, enfants de Sion, soyez dans l\'allégresse', 'Joë.2:23\r'),
(2, 'Pour moi, m\'approcher de Dieu, c\'est mon bien', 'Ps.73:28\r'),
(3, 'Maintenant donc ces trois choses demeurent: la foi, l\'espérance, la charité ', '1Co.13:13\r'),
(4, 'Celui qui a construit toutes choses, c\'est Dieu', 'Hé.3:4\r'),
(5, 'Montre-moi ce que je ne vois pas', 'Job 34:32\r'),
(6, 'L\'Éternel a de la bonté pour qui espère en lui', 'La.3:25\r'),
(7, 'Le bonheur est pour ceux qui craignent Dieu', 'Ec.8:12\r'),
(8, 'Grâces soient rendues à Dieu pour son don ineffable!', '2Co.9:15\r'),
(9, 'Grâces soient rendues à Dieu, qui nous donne la victoire par notre Seigneur Jésus-Christ! ', '1Co.15:57\r'),
(10, 'Donne aujourd\'hui du succès à ton serviteur', 'Né.1:11\r'),
(11, 'Béni soit le Seigneur chaque jour! Quand on nous accable, Dieu nous délivre', 'Ps.68:20\r'),
(12, 'Je te bénirai, ... et tu seras une source de bénédictions', 'Ge.12:2\r'),
(13, 'Il bénira ceux qui craignent l\'Éternel', 'Ps.115:13\r'),
(14, 'Heureux l\'homme qui supporte patiemment la tentation', 'Ja.1:12\r'),
(15, 'Heureux celui à qui la transgression est remise, à qui le péché est pardonné!', 'Ps.32:1\r'),
(16, 'Heureux vous qui pleurez maintenant, car vous serez dans la joie!', 'Lu.6:21\r'),
(17, 'La parole est près de toi, dans ta bouche et dans ton cœur', 'Ro.10:8\r'),
(18, 'La fin de toutes choses est proche', '1Pi.4:7\r'),
(19, 'Dieu était en Christ, réconciliant le monde avec lui-même', '2Co.5:19\r'),
(20, 'Dieu nous a donne la vie éternellement,...et cette vie éternelle est dans son Fils', '1Jn.5:11\r'),
(21, 'Dieu est amour', '1Jn.4:8\r'),
(22, 'Dieu est lumière et il n\'y a point en lui de ténèbres', '1Jn.1:5\r'),
(23, 'Dieu peut vous combler de toutes sortes de grâces ', '2Co.9:8\r'),
(24, 'Et mon Dieu pourvoira à tous vos besoins ', 'Ph.4:19\r'),
(25, 'Dieu est notre refuge', 'Ps.62:9\r'),
(26, 'Voici, notre Dieu que nous servons peut nous délivrer de la fournaise ardente', 'Da.3:17\r'),
(27, 'Car c\'est Dieu qui produit en vous le vouloir et le faire, selon son bon plaisir', 'Ph.2:13\r'),
(28, 'Moi, l\'Éternel, ton Dieu, je t\'instruis pour ton bien', 'És.48:17\r'),
(29, 'Où est Dieu, mon créateur, qui inspire des chants d\'allégresse pendant la nuit', 'Job 35:10\r'),
(30, 'Que le Dieu de la persévérance.. vous donne d\'avoir les mêmes sentiments...', 'Ro.15:5\r'),
(31, 'Veillez et priez, afin que vous ne tombiez pas dans la tentation', 'Mt.26:41\r'),
(32, 'Veillez, demeurez fermes dans la foi', '1Co.16:13\r'),
(33, 'Garde ton coeur plus que toute autre chose', 'Pr.4:23\r'),
(34, 'Je rappellerai les oeuvres de l\'Éternel, Car je me souviens de tes merveilles d\'autrefois', 'Ps.77:12\r'),
(35, 'Je prendrai plaisir à leur faire du bien', 'Jé.32:41\r'),
(36, 'Je ferai d\'elle un sujet de bénédiction', 'Éz.34:26\r'),
(37, 'Sois fidèle jusqu\'à la mort, et je te donnerai la couronne de vie', 'Ap.2:10\r'),
(38, 'Soyez pleins d\'affection les uns pour les autres, par honneur, usez de prévenances réciproques', 'Ro.12:10\r'),
(39, 'Ayez un même sentiment, vivez en paix', '2Co.13:11\r'),
(40, 'Mettez en pratique la parole', 'Ja.1:22\r'),
(41, 'Soyez saints dans toute votre conduite, selon qu\'il est écrit ', '1Pi.1:15\r'),
(42, 'Vous serez saints, car je suis saint', '1Pi.1:16\r'),
(43, 'Rappelle-leur d\'être soumis ..., d\'être prêts à toute bonne oeuvre', 'Ti.3:1\r'),
(44, 'Recevez avec douceur la parole qui a été planté en vous, et qui peut sauver vos âmes ', 'Ja.1:21\r'),
(45, 'En lui vous avez été comblés de toutes les richesses ', '1Co.1:5\r'),
(46, 'Protège-moi, à l\'ombre de tes ailes', 'Ps.17:8\r'),
(47, 'Il y a beaucoup de paix pour ceux qui aiment ta loi, et il ne leur arrive aucun malheur', 'Ps.119:165\r'),
(48, 'Les plus grandes et les plus précieuses promesses', '2Pi.1:4\r'),
(49, 'La foi sans œuvres est morte', 'Ja.2:26\r'),
(50, 'Ainsi la foi vient de ce qu\'on entend, et ce qu\'on entend vient de la parole de Christ ', 'Ro.10:17\r'),
(51, 'Croyez-vous que je puisse faire cela? ', 'Mt.9:28\r'),
(52, 'Celui qui croit en elle ne sera point confus', '1Pi.2:6\r'),
(53, 'Leur joie sera éternelle', 'És.61:7\r'),
(54, 'C\'est devant l\'Éternel ton Dieu que tu feras servir à ta joie tous les biens que tu posséderas', 'De.12:18\r'),
(55, 'Cherchez-moi, et vous vivrez!', 'Am.5:4\r'),
(56, 'Les choses visibles sont passagères, et les invisibles sont éternelles', '2Co.4:18\r'),
(57, 'Entraîne-moi après toi! Nous courrons! ', 'Ca.1:4\r'),
(58, 'Dans toutes leurs détresses ils n\'ont pas été sans secours', 'És.63:9\r'),
(59, 'Qui vous tenez dans la maison de l\'Éternel, dans les parvis de la maison de notre Dieu! ', 'Ps.134:2\r'),
(60, 'Invoque-moi, et je te répondrai', 'Jé.33:3\r'),
(61, 'Je crie au Dieu Très Haut, au Dieu qui agit en ma faveur', 'Ps.57:3\r'),
(62, 'Remets ton sort à l\'Éternel, et il te soutiendra ', 'Ps.55:23\r'),
(63, 'Bien-aimé, nous sommes maintenant enfant de Dieu ', '1Jn.3:2\r'),
(64, 'Croissez dans la grâce ', '2Pi.3:18\r'),
(65, 'Béni soit Dieu et notre Seigneur J-C...qui nous a régénérés,...pour un héritage...', '1Pi.1:3,4\r'),
(66, 'Si quelqu\'un veut venir après moi, qu\'il renonce à lui-même, qu\'il se charge chaque jour de sa croix, et qu\'il me suive', 'Lu.9:23\r'),
(67, 'Je dirai tes oeuvres puissantes, Seigneur Éternel! ', 'Ps.71:16\r'),
(68, 'Que vous discerniez quelle est la volonté de Dieu, ce qui est bon, agréable et parfait', 'Ro.12:2\r'),
(69, 'Il nous a engendrés selon sa volonté, par la parole de vérité', 'Ja.1:18\r'),
(70, 'Voici maintenant le jour du salut', '2Co.6:2\r'),
(71, 'Tous vous êtes un en Jésus-Christ', 'Ga.3:28\r'),
(72, 'Faites tout pour la gloire de Dieu ', '1Co.10:31\r'),
(73, 'Déchargez-vous sur lui de tous vos soucis, car lui-même prend soin de vous', '1Pi.5:7\r'),
(74, 'Tout ce qui est à moi est à toi, et ce qui est à toi est à moi', 'Jn.17:10\r'),
(75, 'Mais dans toutes ces choses nous sommes plus que vainqueurs ', 'Ro.8:37\r'),
(76, 'Que tout ce que vous faites se fasse avec charité! ', '1Co.16:14\r'),
(77, 'Il fait tout à merveille', 'Mc.7:37\r'),
(78, 'Tous ceux qui sont conduits par l\'Esprit de Dieu sont fils de Dieu', 'Ro.8:14\r'),
(79, 'Tout ce que Dieu fait durera toujours', 'Ec.3:14\r'),
(80, 'Pendant qu\'il faisait encore très sombre, il se leva, et sortit pour aller dans un lieu désert, où il pria', 'Mc.1:35\r'),
(81, 'Car quiconque invoquera le nom du Seigneur sera sauvé', 'Ro.10:13\r'),
(82, 'Toute grâce excellente... descend d\'en haut ', 'Ja.1:17\r'),
(83, 'Vous êtes manifestement une lettre de Christ', '2Co.3:3\r'),
(84, 'Vous avez goûté que le Seigneur est bon', '1Pi.2:3\r'),
(85, 'Tout est à vous, et vous êtes à Christ, et Christ est à Dieu ', '1Co.3:23\r'),
(86, 'Vous avez été rachetés à un grand prix', '1Co.6:20\r'),
(87, 'Vous obtiendrez la couronne incorruptible de la gloire', '1Pi.5:4\r'),
(88, 'Or nous, nous n\'avons pas reçu l\'esprit du monde, mais l\'Esprit qui vient de Dieu', '1Co.2:12\r'),
(89, 'Vous avez été rapprochés par le sang de Christ', 'Ép.2:13\r'),
(90, 'Il fit sortir son peuple dans l\'allégresse, ses élus au milieu des cris de joie', 'Ps.105:43\r'),
(91, 'Là où est l\'Esprit du Seigneur, là est la liberté', '2Co.3:17\r'),
(92, 'Là où je suis, là aussi sera mon Serviteur', 'Jn.12:26\r'),
(93, 'Ils annonçaient la parole de Dieu avec assurance', 'Ac.4:31\r'),
(94, 'Si quelqu\'un parle, que ce soit comme annonçant les oracles de Dieu', '1Pi.4:11\r'),
(95, 'Sanctifiez dans vos cœurs Christ le Seigneur', '1Pi.3:15\r'),
(96, 'Seigneur! tous mes désirs sont devant toi ', 'Ps.38:10\r'),
(97, 'Accomplis ton œuvre dans le cours des années, ô Éternel!', 'Ha.3:2\r'),
(98, 'Tu adoreras le Seigneur, ton Dieu, et tu le serviras lui seul ', 'Mt.4:10\r'),
(99, 'L\'Éternel est ma force et le sujet de mes louanges', 'És.12:2\r'),
(100, 'L\'Éternel bénit son peuple et le rend heureux', 'Ps.29:11\r'),
(101, 'Car l\'Éternel Dieu est un soleil et un bouclier... ', 'Ps.84:12\r'),
(102, 'L\'Éternel est le rocher des siècles', 'Ps.27:4\r'),
(103, 'L\'Éternel sera ta lumière à toujours', 'És.60:20\r'),
(104, 'L\'Éternel est refuge pour son peuple', 'Joë.3:16\r'),
(105, 'Le Seigneur est plein de miséricorde et de compassion', 'Ja.5:11\r'),
(106, 'L\'Éternel a fait retomber sur lui l\'iniquité de nous tous', 'És.53:6\r'),
(107, 'L\'Éternel donne la grâce et la gloire', 'Ps.84:12\r'),
(108, 'L\'Éternel est bon,... Il connaît ceux qui se confient en lui', 'Na.1:7\r'),
(109, 'L\'Éternel agira en ma faveur', 'Ps.138:8\r'),
(110, 'L\'Éternel, l\'Éternel, Dieu miséricordieux et compatissant', 'Ex.34:6\r'),
(111, 'Je ne me souviendrai plus de leur péché', 'Jé.31:34\r'),
(112, 'Il vient, notre Dieu, il ne reste pas en silence', 'Ps.50:3\r'),
(113, 'Que la volonté du Seigneur se fasse!', 'Ac.21:14\r'),
(114, 'Que ta bonté soit ma consolation, Comme tu l\'as promis à ton serviteur!', 'Ps.119:76\r'),
(115, 'Que ta main me soit en aide! ', 'Ps.119:173\r'),
(116, 'Je voudrais séjourner éternellement dans ta tente', 'Ps.61:5\r'),
(117, 'Que nous portions des fruits pour Dieu ', 'Ro.7:4\r'),
(118, 'Qu\'il demandent avec foi, sans douter', 'Ja.1:6\r'),
(119, 'Qu\'il l\'a demande (la sagesse) à Dieu, qui donne à tous simplement et sans reproche ', 'Ja.1:5\r'),
(120, 'Afin que nous reçussions l\'adoption', 'Ga.4:5\r'),
(121, 'Le don gratuit de Dieu, c\'est la vie éternelle en Jésus-Christ notre Seigneur', 'Ro.6:23\r'),
(122, 'Vous avez reçu gratuitement, donnez gratuitement', 'Mt.10:8\r'),
(123, 'Dieu ne se repent pas de ses dons et de son appel ', 'Ro.11:29\r'),
(124, 'Par les oeuvres la foi fut rendue parfaite ', 'Ja.2:22\r'),
(125, 'L\'œuvre de la justice sera la paix', 'És.32:17\r'),
(126, 'Prends courage, mon enfant, tes péchés te sont pardonnés', 'Mt.9:2\r'),
(127, 'Croyez que la patience de notre Seigneur est votre salut', '2Pi.3:15\r'),
(128, 'Vous aussi, soyez patients, affermissez vos cœurs', 'Ja.5:8\r'),
(129, 'Le rachat de leur âme est cher, et n\'aura jamais lieu', 'Ps.49:9\r'),
(130, 'Rachetez le temps, car les jours sont mauvais', 'Ép.5:16\r'),
(131, 'Recherchez la charité. Aspirez aussi aux dons spirituels', '1Co.14:1\r'),
(132, 'L\'agneau qui a été immolé est digne de recevoir la puissance,... et la louange', 'Ap.5:12\r'),
(133, 'Les choses anciennes sont passées, voici, toutes choses sont devenues nouvelles ', '2Co.5:17\r'),
(134, 'L\'Esprit de gloire, l\'Esprit de Dieu, repose sur vous', '1Pi.4:14\r'),
(135, 'Soyez fervents d\'esprit. Servez le Seigneur', 'Ro.12:11\r'),
(136, 'Il y a un seul Dieu ... un Seul médiateur entre Dieu et les hommes, Jésus-Christ homme', '1Ti.2:5\r'),
(137, 'Si Dieu est pour nous, qui sera contre nous?', 'Ro.8:31\r'),
(138, 'Si tu le cherches, il se laissera trouver par toi', '1Ch.28:9\r'),
(139, 'Encore un peu, ... celui qui doit venir viendra et  il ne tardera pas', 'Hé.10:37\r'),
(140, 'Votre vie est cachée avec Christ en Dieu', 'Col.3:3\r'),
(141, 'Il bénit la demeure des justes', 'Pr.3:33\r'),
(142, 'Il a fait avec moi une alliance éternelle', '2S.23:5\r'),
(143, 'Vous avez été scellés du Saint-esprit', 'Ép.1:13\r'),
(144, 'Car l\'Éternel connaît la voie des justes, et la voie des pécheurs mène à la ruine', 'Ps.1:6\r'),
(145, 'Votre Père sait de quoi vous avez besoin, avant que vous le lui demandiez', 'Mt.6:8\r'),
(146, 'La connaissance enfle, mais la charité édifie', '1Co.8:1\r'),
(147, 'Je serai pour vous un père, et vous serez pour moi des fils et des filles', '2Co.6:18\r'),
(148, 'Et que quiconque crois est justifié par lui de toutes les choses', 'Ac.13:39\r'),
(149, 'Ils célébreront les voies de l\'Éternel', 'Ps.138:5\r'),
(150, 'Je disais: Tu m\'appelleras: Mon père!', 'Jé.3:19\r'),
(151, 'Je vous donnerai un cœur nouveau', 'Éz.36:26\r'),
(152, 'En elle était la vie, et la vie était la lumière des hommes', 'Jn.1:4\r'),
(153, 'Et tous ceux qui le touchaient étaient guéris.', 'Mc.6:56\r'),
(154, 'Et nous, nous avons connu l\'amour que Dieu a pour nous ', '1Jn.4:16\r'),
(155, 'Gloire à Dieu dans les lieux très hauts, et paix sur la terre parmi les hommes qu\'Il agrée! ', 'Lu.2:14\r'),
(156, 'Et pour attendre des cieux son Fils', '1Th.1:10\r'),
(157, 'J\'établirai ma demeure au milieu de vous', 'Lé.26:11\r'),
(158, 'Et ma parole et ma prédication ... une démonstration d\'Esprit et de puissance', '1Co.2:4\r'),
(159, 'Et c\'est ainsi qu\'Abraham, ayant persévéré, obtint l\'effet de la promesse.', 'Hé.6:15\r'),
(160, 'Et le roi leur répondra: ... c\'est à moi que vous les avez faites. ', 'Mt.25:40\r'),
(161, 'Car l\'agneau qui est au milieu du trône les paîtra et les conduira aux sources des eaux de la vie', 'Ap.7:17\r'),
(162, 'Car l\'Éternel prend plaisir à son peuple', 'Ps.149:4\r'),
(163, 'Le jour de l\'Éternel est proche', 'So.1:7\r'),
(164, 'Car sa bonté pour nous est grande, et sa fidélité dure à toujours. ', 'Ps.117:2\r'),
(165, 'Car je vais créer des nouveaux cieux et une nouvelle terre', 'És.65:17\r'),
(166, 'C\'est pourquoi encore l\'Amen par lui est prononcé par nous à sa gloire.', '2Co.1:20\r'),
(167, 'Car la vie a été manifestée ', '1Jn.1:2\r'),
(168, 'Car mon joug est doux, et mon fardeau léger. ', 'Mt.11:30\r'),
(169, 'Car celui qui a pitié d\'eux sera leur guide', 'És.49:10\r'),
(170, 'Car nous sommes ouvriers avec Dieu.', '1Co.3:9\r'),
(171, 'Nous sommes, en effet, pour Dieu la bonne odeur de Christ', '2Co.2:15\r'),
(172, 'Car le Père lui-même vous aime', 'Jn.16:27\r'),
(173, 'Car la prédication de la croix est... une puissance de Dieu.', '1Co.1:18\r'),
(174, 'Venez et attachez-vous à l\'Éternel', 'Jé.50:5\r'),
(175, 'La vérité sort de ma bouche et ma parole ne sera point révoquée', 'És.45:23\r'),
(176, 'Jésus ... toujours vivant pour intercéder en leur faveur', 'é.7:22,25\r'),
(177, 'Élie était un homme de la même nature que nous ', 'Ja.5:17\r'),
(178, 'Ayant donc de telles promesses, bien-aimés, purifions-nous ', '2Co.7:1\r'),
(179, 'Le nom de l\'Éternel est une tour forte', 'Pr.18:10\r'),
(180, 'Il a été tenté comme nous en toutes choses, sans commettre de péché.', 'Hé.4:15\r'),
(181, 'Celui qui fait la volonté de Dieu demeure éternellement. ', '1Jn.2:17\r'),
(182, 'Car l\'Éternel est bon, sa bonté dure toujours... ', 'Ps.100:5\r'),
(183, 'Éternel! ta bonté atteint jusqu\'aux cieux', 's.36:6\r'),
(184, 'Et maintenant, petits enfants, demeurez en lui', '1Jn.2:28\r'),
(185, 'Ceux qui me cherchent me trouvent.', 'Pr.8:17\r'),
(186, 'Mon âme est attachée à toi, ta droite me soutient.', 'Ps.63:9\r'),
(187, 'C\'est vers toi que je crie, ô Éternel', 'Joë.1:19\r'),
(188, 'Chacun recevra sa propre récompense selon son propre travail.', '1Co.3:8\r'),
(189, 'Que ton nom est magnifique sur toute la terre! ', 'Ps.8:10\r'),
(190, 'Que tes pensées, ô Dieu, me semblent impénétrables! ', 'Ps.139:17\r'),
(191, 'Que ses jugements sont insondables, et ses voies incompréhensibles! ', 'Ro.11:33\r'),
(192, 'Comme un berger, il paîtra son troupeau', 'És.40:11\r'),
(193, 'Qu\'ils sont beaux les pieds de ceux qui annoncent la paix', 'Ro.10:15\r'),
(194, 'Quand je suis dans la crainte, en toi je me confie.', 'Ps.56:4\r'),
(195, 'Celui que tu bénis est béni, et que celui que tu maudis est maudit. ', 'No.22:6\r'),
(196, 'Il nous affermira aussi jusqu\'à la fin', '1Co.1:8\r'),
(197, 'J-C s\'est donné lui-même pour nos péché', 'Ga.1:4\r'),
(198, 'Le sang de Jésus son fils nous purifie de tout péché.', '1Jn.1:7\r'),
(199, 'Si quelqu\'un est en Christ, il est une nouvelle créature. ', '2Co.5:1\r'),
(200, 'Si quelqu\'un entre par moi il sera sauvé', 'Jn.10:9\r'),
(201, 'Si quelqu\'un a soif, qu\'il vienne à moi, et qu\'il boive. ', 'Jn.7:37\r'),
(202, 'Quel est donc le serviteur fidèle et prudent?', 'Mt.24:45\r'),
(203, 'Mais si quelqu\'un aime Dieu, celui-là est connu de lui. ', '1Co.8:3\r'),
(204, 'Si quelqu\'un me sert, qu\'il me suive', 'Jn.12:26\r'),
(205, 'Quand on tourne vers lui les regards, on est rayonnant de joie', 'Ps.34:6\r'),
(206, 'Celui qui me suit...aura la lumière de la vie.', 'Jn.8:12\r'),
(207, 'Celui qui sème peu moissonnera peu, et celui qui sème abondamment moissonnera abondamment.', '2Co.9:6\r'),
(208, 'Les hommes intègres héritent le bonheur', 'Pr.28:18\r'),
(209, 'Celui qui peut faire par la puissance qui agit en nous, ... à lui soit la gloire', 'Ép.3:20,21\r'),
(210, 'Mieux vaut chercher un refuge en l\'Éternel que de se confier à l\'homme', 'Ps.118:8\r'),
(211, 'L\'amour de Dieu est répandu dans nos cœurs par le Saint Esprit qui nous a été donné. ', 'Ro.5:5\r'),
(212, 'L\'Amour de Dieu a été manifesté envers nous', '1Jn.4:9\r'),
(213, 'Toutes choses concourent au bien de ceux qui aiment Dieu', 'Ro.8:28\r'),
(214, 'L\'homme dont le regard est bienveillant sera béni ', 'Pr.22:9\r'),
(215, 'Mon amour ne s\'éloignera point de toi', 'És.54:10\r'),
(216, 'La miséricorde triomphe du jugement. ', 'Ja.2:13\r'),
(217, 'Ta droite me soutient, Et je deviens grand par ta bonté.', 'Ps.18:36\r'),
(218, 'La prière fervente du juste a une grande efficace. ', 'Ja.5:16\r'),
(219, 'L\'Éternel peut te donner bien plus que cela.', '2Ch.25:9\r'),
(220, 'La prière de la foi sauvera le malade', 'Ja.5:15\r'),
(221, 'Il écoute la prière des justes.', 'Pr.15:29\r'),
(222, 'Je changerai les devant eux les ténèbres en lumière', 'És.42:16\r'),
(223, 'Nous sommes fous à cause de Christ', '1Co.4:10\r'),
(224, 'Nous marcherons, nous, au nom de l\'Éternel, notre Dieu, à toujours et à perpétuité.', 'Mi.4:5\r'),
(225, 'Nous qui sommes des jours, soyons sobres', '1Th.5:8\r'),
(226, 'Nous avons dans le ciel un édifice qui est l\'ouvrage de Dieu', '2Co.5:1\r'),
(227, 'Nous, nous prêchons Christ crucifié', '1Co.1:23\r'),
(228, 'Car nous marchons par la foi et non par la vue', '2Co.5:7\r'),
(229, 'Sa colère dure un instant, Mais sa grâce toute la vie', 'Ps.30:6\r'),
(230, 'C\'est en l\'Éternel que je cherche un refuge. ', 'Ps.11:1\r'),
(231, 'En lui mon coeur se confie, et je suis secouru', 'Ps.28:7\r'),
(232, 'J\'espère en ton secours, ô Éternel!', 'Ge.49:18\r'),
(233, 'Que ta bénédiction soit sur ton peuple!', 'Ps.3:9\r'),
(234, 'J\'écrirai sur lui le nom de mon Dieu,... et mon nom nouveau.', 'Ap.3:12\r'),
(235, 'Regarde si je suis sur une mauvaise voie, et conduis-moi sur la voie de l\'éternité! ', 'Ps.139:24\r'),
(236, 'On l\'appellera Admirable, Conseiller, Dieu puissant', 'És.9:5\r'),
(237, 'Mon peuple demeurera dans le séjour de la paix', 'És.32:18\r'),
(238, 'Voici, le jour de l\'Éternel arrive', 'Za.14:1\r'),
(239, 'C\'est l\'heure de vous réveiller enfin du sommeil', 'Ro.13:11\r'),
(240, 'Éternel! enseigne-moi ta voie ', 'Ps.27:11\r'),
(241, 'Enseigne-moi à faire ta volonté! Car tu es mon Dieu. ', 'Ps.143:10\r'),
(242, 'Venez, et montons...afin qu\'il nous enseigne ses voies', 'És.2:3\r'),
(243, 'Apprenez à faire le bien', 'És.1:17\r'),
(244, 'Notre communion est avec le Père et avec son Fils Jésus-Christ. ', '1Jn.1:3\r'),
(245, 'Ne crains rien, je viens à ton secours.', 'És.41:13\r'),
(246, 'Ne craignez pas, et que vos mains se fortifient!', 'Za.8:13\r'),
(247, 'Mais je ne fais pour moi-même aucun cas de ma vie', 'Ac.20:24\r'),
(248, 'Mon âme, bénis l\'Éternel, Et n\'oublie aucun de ses bienfaits! ', 'Ps.103:2\r'),
(249, 'Celui qui n\'a point connu le péché, il l\'a fait devenir péché pour nous', '2Co.5:21\r'),
(250, 'Le Seigneur ne tarde pas dans l\'accomplissement de la promesse', '2Pi.3:9\r'),
(251, 'L\'espérance des misérables ne périt pas à toujours.', 'Ps.9:19\r'),
(252, 'N\'attristez pas le Saint-esprit de Dieu ', 'Ép.4:30\r'),
(253, 'La richesse ne sert à rien, mais la justice délivre de la mort. ', 'Pr.11:4\r'),
(254, 'Ne jugez point, afin que vous ne soyez point jugés. ', 'Mt.7:1\r'),
(255, 'L\'homme ne vivra pas de pain seulement, mais de toute parole qui sort de la bouche de Dieu.', 'Mt.4:4\r'),
(256, 'Non! Nous servirons l\'Éternel.', 'Jos.24:21\r'),
(257, 'Ne nous rendras-tu pas à la vie, afin que ton peuple se réjouisse en toi? ', 'Ps.85:7\r'),
(258, 'Poursuivez toujours le bien', '1Th.5:15\r'),
(259, 'D\'ailleurs, quand vous souffririez pour la justice, vous seriez heureux. ', '1Pi.3:14\r'),
(260, 'Mais au sein de leur détresse ils sont retournes à l\'Eternel ... ils l\'ont trouvé', '2Ch.15:4\r'),
(261, 'Mais, par ce que l\'Éternel vous aime ', 'De.7:8\r'),
(262, 'Nous portons ce trésor dans des vases de terre ', '2Co.4:7\r'),
(263, 'Et toi, Éternel, ne t\'éloigne pas! Toi qui es ma force, viens en hâte à mon secours! ', 'Ps.22:20\r'),
(264, 'Mais maintenant, Christ est ressuscité des morts', '1Co.15:20\r'),
(265, 'Mais Noé trouva grâce aux yeux de l\'Éternel.', 'Ge.6:8\r'),
(266, 'O profondeur de la richesse, de la sagesse et de la science de Dieu!', 'Ro.11:33\r'),
(267, 'Il se réjouit sans cesse de ton nom, et il se glorifie de ta justice.', 'Ps.89:17\r'),
(268, 'Mais revêtez-vous du Seigneur Jésus-Christ ', 'Ro.13:14\r'),
(269, 'Mais revêtez-vous du Seigneur Jésus-Christ ', 'Ro.13:14\r'),
(270, 'Fortifiez-vous dans le Seigneur et par sa force toute puissante.', 'Ép.6:10\r'),
(271, 'Revêtons les armes de la lumière.', 'Ro.13:12\r'),
(272, 'Reviens à moi, car je t\'ai racheté.', 'És.44:22\r'),
(273, 'Je suis l\'ami de tous ceux qui te craignent', 'Ps.119:63\r'),
(274, 'Il n\'y a aucune différence, en effet, entre le Juif et le Grec, puisqu\'ils ont tous un même Seigneur', 'Ro.10:12\r'),
(275, 'Bien qu\'Il fût fils, l\'obéissance par les choses qu\'il a souffertes', 'Hé.5:8\r'),
(276, 'L\'attente des justes n\'est que joie, mais l\'espérance des méchants périra. ', 'Pr.10:28\r'),
(277, 'Maintenez-vous dans l\'amour de Dieu, en attendant la miséricorde de notre Seigneur Jésus-Christ', 'Jude.21\r'),
(278, 'Lui qui a porté lui-même nos péchés en son corps sur le bois ', '1Pi.2:24\r'),
(279, 'Il agit de tout son cœur, et il réussit dans tout ce qu\'il entreprit', '2Ch.31:21\r'),
(280, 'Il est le médiateur d\'une nouvelle alliance', 'Hé.9:15\r'),
(281, 'C\'est lui qui rachètera Israël de toutes ses iniquités.', 'Ps.130:8\r'),
(282, 'Car il délivrera le pauvre qui crie, et le malheureux qui n\'a point d\'aide.', 'Ps.72:12\r'),
(283, 'Il a satisfait l\'âme altérée, Il a comblé de biens l\'âme affamée.', 'Ps.107:9\r'),
(284, 'Il n\'a pas honte de les appeler frères.', 'Hé.2:11\r'),
(285, 'Il me fait reposer dans de verts pâturages, Il me dirige près des eaux paisibles.', 'Ps.23:2\r'),
(286, 'Dans leur bouche il ne s\'est point trouvé de mensonge, car ils sont irrépréhensibles.', 'Ap.14:5\r'),
(287, 'Ils périront, mais tu subsisteras', 'Ps.102:27\r'),
(288, 'Heureux le peuple qui connaît le son de la trompette', ' Il marche à la'),
(289, 'Ils ont lavé leurs robes, et ils les ont blanchies dans le sang de l\'agneau.', 'Ap.7:14 \r'),
(290, 'Étant donc justifiés par la foi, nous avons la paix avec Dieu par notre Seigneur Jésus-Christ ', 'Ro.5:1\r'),
(291, 'C\'est dans la tranquillité et le repos que sera votre salut', 'És.30:15\r'),
(292, 'Pardonne-moi ceux que j\'ignore. ', 'Ps.19:3\r'),
(293, 'Nous sommes pressés de toute manière, mais non réduits à l\'extrémité ', '2Co.4:8\r'),
(294, 'Nous attestons que le Père a envoyé le Fils comme Sauveur du monde. ', '1Jn.4:14\r'),
(295, 'La révélation de tes paroles éclaire, elle donne de l\'intelligence aux simples. ', 'Ps.119:130\r'),
(296, 'Les yeux du Seigneur sont sur les justes', '1Pi.3:12\r'),
(297, 'Christ, notre Pâque été immolé', '1Co.5:7\r'),
(298, 'Je rassasierai de pain ses indigents', 'Ps.132:15\r'),
(299, 'Souviens-toi de moi selon ta miséricorde, à cause de ta bonté, ô Éternel!', 'Ps.25:7\r'),
(300, 'Celui qui vaincra héritera ces choses, je serai son Dieu, et il sera mon fils.', 'Ap.21:7\r'),
(301, 'J\'ai combattu le bon combat', '2Ti.4:7\r'),
(302, 'Je suis bien humilié: Éternel, rends-moi la vie selon ta parole!', 'Ps.119:117\r'),
(303, 'Le Seigneur connaît ceux qui lui appartiennent', '2Ti.2:19\r'),
(304, 'Prosternez-vous devant l\'Éternel avec des ornements sacrés. ', 'Ps.96:9\r'),
(305, 'Soumettez-vous donc à Dieu, résistez au diable, et il fuira loin de vous. ', 'Ja.4:7\r'),
(306, 'La sagesse d\'en haut est ... pleine de miséricorde et de bons fruits', 'Ja.3:17\r'),
(307, 'Il y a d\'abondantes joies devant ta face, des délices éternelles à ta droite. ', 'Ps.16:11\r'),
(308, 'Mettez dans votre cœur et dans votre âme ces paroles que je vous dis.', 'De.11:18\r'),
(309, 'Notre secours est dans le nom de l\'Éternel, qui a fait les cieux et la terre. ', 'Ps.124:8\r'),
(310, 'Souviens-toi favorablement de moi, ô mon Dieu!', 'Né.13:31\r'),
(311, 'Écoute la voix de l\'Éternel dans ce que je te dis', 'Jé.38:20\r'),
(312, 'Celui qui agit selon la vérité vient de à la lumière', 'Jn.3:21\r'),
(313, 'Envoie ta lumière et ta fidélité! ', 'Ps.43:3\r'),
(314, 'Recommande ton sort à l\'Éternel, Mets en lui ta confiance, et il agira. ', 'Ps.37:5\r'),
(315, 'Espère en l\'Éternel, et il te délivrera.', 'Pr.20:22\r'),
(316, 'Que tes bien-aimés jouissent du bonheur!', '2Ch.6:41\r'),
(317, 'Mais celui qui persévérera jusqu\'à la fin sera sauvé', 'Mt.24:13\r'),
(318, 'Je dis à l\'Éternel: mon refuge et ma forteresse, mon Dieu en qui je me confie! ', 'Ps.91:2\r'),
(319, 'Approchez-vous de Dieu, et il s\'approchera de vous. ', 'Ja.4:8\r'),
(320, 'Je reviendrai, et je vous prendrai avec moi', 'Jn.14:3\r'),
(321, 'Mon Dieu, prête l\'oreille et écoute!', 'Da.9:18\r'),
(322, 'Soyez réconciliés avec Dieu!', '2Co.5:20\r'),
(323, 'Je vous recevrai comme un parfum d\'une agréable odeur', 'Éz.20:41\r'),
(324, 'Celui qui vient à moi n\'aura jamais faim', 'Jn.6:35\r'),
(325, 'L\'avènement du Seigneur est proche.', 'Ja.5:8\r'),
(326, 'Les eaux jailliront dans le désert', 'És.35:6\r'),
(327, 'Glorifiez donc Dieu dans votre corps et dans votre esprit', '1Co.6:20\r'),
(328, 'Vos péchés vous sont pardonnés à cause de son nom. ', '1Jn.2:12\r'),
(329, 'À cause de ton nom tu me conduiras, tu me dirigeras. ', 'Ps.31:4\r'),
(330, 'La joie de l\'Éternel sera votre force.', 'Né.8:10\r'),
(331, 'Soyez dans la joie, perfectionnez-vous, consolez-vous, ayez un même sentiment, vivez en paix', '2Co.13:11\r'),
(332, 'Ne sachez-vous pas que vous êtes le temple de Dieu?', '1Co.3:16\r'),
(333, 'Celui qui a l\'esprit calme est un homme intelligent.', 'Pr.17:27\r'),
(334, 'Lui par les meurtrissures duquel vous avez été guéris. ', '1Pi.2:24\r'),
(335, 'Placez-vous sur les chemins, regardez, et demandez quel sont les anciens sentiers', 'Jé.6:16\r'),
(336, 'Tout ce qui est né de Dieu triomphe du monde', '1Jn.5:4\r'),
(337, 'Que le Seigneur de la paix vous donne lui-même la paix en tout temps, de toute manière', '2Th.3:16\r'),
(338, 'Saint, saint, saint est le Seigneur Dieu, le Tout Puisant, qui était, qui est, et qui vient! ', 'Ap.4:8\r'),
(339, 'Saint, saint, saint est l\'Éternel des armées!', 'És.6:3\r'),
(340, 'Voici, ton roi vient à toi, plein de douceur, et monté sur un âne, sur un ânon, le petit d\'une ânesse. ', 'Mt.21:5\r'),
(341, 'Ce Jésus, ... reviendras de la même façon', 'Ac.1:11\r'),
(342, 'Mais lui, ... peut sauver parfaitement...', 'Hé.7:24-25\r'),
(343, 'Ma puissance s\'accomplit dans la faiblesse', '2Co.12:9\r'),
(344, 'Que votre parole soit toujours accompagnée de grâce', 'Col.4:6\r'),
(345, 'Mais la parole du Seigneur demeure éternellement.', '1Pi.1:25\r'),
(346, 'Ta parole est une lampe à mes pieds, et une lumière sur mon sentier.', 'Ps.119:105\r'),
(347, 'Dieu résiste aux l\'orgueilleux, Mais il fait grâce aux humbles. ', 'Ja.4:6\r'),
(348, 'Humiliez-vous devant le Seigneur, et il vous élèvera. ', 'Ja.4:10\r'),
(349, 'Voyez quel amour le Père nous a témoigné', '1Jn.3:1\r'),
(350, 'En achevant notre sanctification dans la crainte de Dieu', '2Co.7:1\r'),
(351, 'Mais celui qui s\'attache au Seigneur est avec lui un seul esprit. ', '1Co.6:17\r'),
(352, 'Maintenez-vous dans l\'amour de Dieu', 'Jude.21\r'),
(353, 'Dieu nous a sauvés, et nous a adressé une sainte vocation', '2Ti.1:9\r'),
(354, 'Notre capacité vient de Dieu', '2Co.3:5\r'),
(355, 'Recherchez la paix avec tous, et la sanctification, sans laquelle personne ne verra le Seigneur', 'Hé.12:14\r'),
(356, 'Demeurez fermes dans un même esprit', 'Ph.1:27\r'),
(357, 'Il gardera les pas de ses bien-aimés.', '1S.2:9\r'),
(358, 'Ils étaient étrangers et voyageurs sur la terre', 'Hé.11:13\r'),
(359, 'La crainte de l\'Éternel est une source de vie ', 'Pr.14:27\r'),
(360, 'La crainte du Seigneur, c\'est  la sagesse', 'Job 28:28\r'),
(361, 'Mon fils, retiens mes paroles, et garde avec toi mes préceptes.', 'Pr.7:1\r'),
(362, 'L\'amitié de l\'Éternel est pour ceux qui le craignent', 'Ps.25:14\r'),
(363, 'Courez de manière à remporter', '1Co.9:24\r'),
(364, 'Que votre lumière luise ainsi devant les hommes', 'Mt.5:16\r'),
(365, 'Comme Christ est ressuscité des morts par la gloire du Père, de même nous aussi nous marchions en nouveauté de vie.', 'Ro.6:4\r'),
(366, 'De même aussi l\'Esprit nous aide dans notre faiblesse ', 'Ro.8:26\r'),
(367, 'Je te couvre de l\'ombre de ma main', 'És.51:16\r'),
(368, 'Craignez seulement le l\'Éternel et servez-le fidèlement', '1S.12:24\r'),
(369, 'Mais vous craindrez l\'Éternel votre Dieu', '2 R.17:39\r'),
(370, 'Celui qui est en vous est plus grand que celui qui est dans le monde. ', '1Jn.4:4\r'),
(371, 'Il ne brisera point le roseau cassé', 'Mt.12:20\r'),
(372, 'Tu seras comme un jardin arrosé', 'És.58:11\r'),
(373, 'Tu as été guéri, ne pèche plus', 'Jn.5:14\r'),
(374, 'Toi qui sondes les cœurs et les reins, Dieu juste!', 'Ps.7:10\r'),
(375, 'Car tu es bon, Seigneur, tu pardonnes, Tu es plein d\'amour pour tous ceux qui t\'invoquent. ', 'Ps.86:5\r'),
(376, 'Les ténèbres se dissipent et la lumière véritable paraît déjà. ', '1Jn.2:8\r'),
(377, 'Le salut vient de l\'Éternel. ', 'Jon.2:10\r'),
(378, 'Ils retournèrent ... les exhortant à persévérer dans la foi', 'Ac.14:22\r'),
(379, 'Les malheureux le voient et se réjouissent', 'Ps.69:33\r'),
(380, 'Car ils ne pourront plus mourir,... étant fils de la résurrection. ', 'Lu.20:36\r'),
(381, 'Notre consolation abonde par Christ', '2Co.1:5\r'),
(382, 'Je me confie dans la bonté de Dieu, éternellement et à jamais.', 'Ps.52:10\r'),
(383, 'C\'est en confessant de la bouche qu\'on parvient au salut', 'Ro.10:10\r'),
(384, 'Accomplis envers ton serviteur ta promesse', 'Ps.119:38\r'),
(385, 'Le temple de Dieu est saint, et c\'est ce que vous êtes. ', '1Co.3:17\r'),
(386, 'La religion pure consiste .. à se préserver des souillures du monde. ', 'Ja.1:27\r'),
(387, 'Car le royaume de Dieu ne consiste pas en paroles, mais en puissance.', '1Co.4:20\r'),
(388, 'Qu\'il fasse ce qui lui semblera bon!', '1S.3:18\r'),
(389, 'Car il est mort, et c\'est pour le péché qu\'il est mort une fois pour toutes', 'Ro.6:10\r'),
(390, 'Que voulez-vous que je fasse pour vous?', 'Mc.10:36\r'),
(391, 'Nous ne cessons de prier Dieu ... que vous soyez remplis de la connaissance de sa volonté', 'Col.1:9\r'),
(392, 'Afin que notre joie soit parfaite. ', '1Jn.1:4\r'),
(393, 'Je cherche ta face, ô Éternel!', 'Ps.27:8\r'),
(394, 'Je regarderai vers l\'Eternel,...mon Dieu m\'exaucera.', 'Mi.7:7\r'),
(395, 'Je vous ai donné un exemple, afin que vous fassiez comme je vous ai fait.', 'Jn.13:15\r'),
(396, 'Je suis le cep. Vous êtes les sarments.', 'Jn.15:5\r'),
(397, 'Et moi, je crie à Dieu, et l\'Éternel me sauvera. ', 'Ps.55:17\r'),
(398, 'Je veux faire ta volonté, mon Dieu! ', 'Ps.40:9\r'),
(399, 'Je suis rempli de force, de l\'esprit de l\'Éternel ', 'Mi.3:8\r'),
(400, 'J\'aime la piété et non les sacrifices', 'Os.6:6\r'),
(401, 'Je n\'ai point honte de l\'Évangile', 'Ro.1:16\r'),
(402, 'Je suis au milieu de vous comme celui qui sert.', 'Lu.22:27\r'),
(403, 'Je ferai passer devant toi toute ma bonté', 'Ex.33:19\r'),
(404, 'Je serai avec toi pour te sauver et te délivrer', 'Jé.15:20\r'),
(405, 'Je ne me souviendrai plus de tes péchés.', 'És.43:25\r'),
(406, 'Je suis la lumière du monde', 'Jn.9:5\r'),
(407, 'Je suis ton bouclier, et ta récompense sera grande', 'Ge.15:1\r'),
(408, 'J\'ai vu la souffrance de mon peuple...', 'Ex.3:7\r'),
(409, 'Je te ferai connaître ce que tu dois faire', '1S.16:3\r'),
(410, 'Moi, le Dieu d\'Israël, je ne les abandonnerai pas', 'És.41:17\r'),
(411, 'Moi, l\'Éternel, j\'éprouve le cœur', 'Jé.17:10\r'),
(412, 'Or sans la foi il est impossible de lui être (à Dieu) agréable', 'Heb.11:6\r'),
(413, 'Toi, demeure dans les choses que tu as apprises, et reconnues certaines', '2Tim.3:14\r'),
(414, 'Rendez grâce au père...qui nous a délivrés de la puissance des ténèbres ', 'Col.1:13\r'),
(415, 'C\'est par grâce que vous êtes sauvés', 'Eph.2:5\r'),
(416, 'Heureux celui qui veille, et qui garde ses vêtements', 'Rv.16:15\r'),
(417, 'Heureux celui qui garde les paroles de la prophétie de ce livre! ', 'Rv.22:7\r'),
(418, 'Car Dieu ne nous a pas destinés à la colère, mais à l\'acquisition du salut par notre Seigneur Jésus Christ', '1Thes.5:9\r'),
(419, 'Dieu a envoyé dans nos cœurs l\'Esprit de son Fils', 'Gal.4:6\r'),
(420, 'Demeurons fermes dans la foi que nous professons.', 'Heb.4:14\r'),
(421, 'Sois fidèle jusqu\'à la mort, et je te donnerai la couronne de vie.', 'Rv.2:10\r'),
(422, 'Soyez reconnaissants.', 'Col.3:15\r'),
(423, 'Persévérez dans la prière, veillez-y avec actions de grâces.', 'Col.4:2\r'),
(424, 'Et, sans contredit, le mystère de la piété est grand: celui qui a été manifesté en chair...', '1Tim.3:16\r'),
(425, 'Tes œuvres sont grandes et admirables, Seigneur Dieu tout puissant! ', 'Rv.15:3\r'),
(426, 'C\'est, en effet, une grande source de gain que la piété avec le contentement', '1Tim.6:6\r'),
(427, 'La foi est une ferme assurance des choses qu\'on espère, une démonstration de celles qu\'on ne voit pas. ', 'Heb.11:1\r'),
(428, 'Car, en Jésus Christ, ni la circoncision ni l\'incirconcision n\'a de valeur, mais la foi qui est agissante par la charité.', 'Gal.5:6\r'),
(429, 'Le Seigneur est fidèle, il vous affermira et vous préservera du malin. ', '2Thes.3:3\r'),
(430, 'Je mettrai mes lois dans leur esprit, Je les écrirai dans leur cœur', 'Heb.8:10\r'),
(431, 'Veille sur toi-même et sur ton enseignement, persévère dans ces choses', '1Tim.4:16\r'),
(432, 'Donnant un enseignement pur, digne', 'Ti.2:7\r'),
(433, 'Car vous êtes tous fils de Dieu par la foi en Jésus Christ', 'Gal.3:26\r'),
(434, 'Faites tout au nom du Seigneur Jésus', 'Col.3:17\r'),
(435, 'Examinez toutes choses, retenez ce qui est bon', '1Thes.5:21\r'),
(436, 'Je puis tout par celui qui me fortifie. ', 'Phil.4:13\r'),
(437, 'Je les (toutes choses) regarde comme de la boue, afin de gagner Christ', 'Phil.3:8\r'),
(438, 'Je regarde toutes choses comme de la boue, afin de gagner Christ, ', 'Phil.3:8\r'),
(439, 'Soyez toujours joyeux.', '1Thes.5:16\r'),
(440, 'Vous n\'avez pas encore résisté jusqu\'au sang, en luttant contre le péché. ', 'Heb.12:4\r'),
(441, 'Le Seigneur est proche. ', 'Phil.4:5\r'),
(442, 'Et que la paix de Christ... règne dans vos cœurs', 'Col.3:15\r'),
(443, 'Approchons-nous donc avec assurance du trône de la grâce ', 'Heb.4:16\r'),
(444, 'Il dit cela, quoique ses œuvres eussent été achevées depuis la création du monde. ', 'Heb.4:3\r'),
(445, 'Ne nous lassons pas de faire le bien', 'Gal.6:9\r'),
(446, 'Retiens ce que tu as, afin que personne ne prenne ta couronne.', 'Rv.3:11\r'),
(447, 'Car Christ est ma vie, et la mort m\'est un gain.', 'Phil.1:21\r'),
(448, 'Et que celui qui a soif vienne, que celui qui veut, prenne de l\'eau de la vie, gratuitement.', 'Rv.22:17\r'),
(449, 'Conduisez-vous d\'une manière digne de l\'Évangile de Christ', 'Phil.1:27\r'),
(450, 'Rendez grâces en toutes choses', '1Thes.5:18\r'),
(451, 'Jésus, nous le voyons couronné de gloire et d\'honneur à cause de la mort qu\'il a soufferte...', 'Heb.2:9\r'),
(452, 'Vous avez été scellés du Saint-Esprit qui avait été promis', 'Eph.1:13\r'),
(453, 'Vous avez tout pleinement en lui', 'Col.2:10\r'),
(454, 'Ce n\'est plus moi qui vis, c\'est Christ qui vit en moi ', 'Gal.2:20\r'),
(455, 'Ce que Dieu veut, c\'est votre sanctification', '1Thes.4:3\r'),
(456, 'Vous êtes tous des enfants de la lumière et des enfants du jour. ', '1Thes.5:5\r'),
(457, 'Ce n\'est pas un esprit de timidité que Dieu nous a donné, mais un esprit de force, d\'amour et de sagesse.', '2Tim.1:7\r'),
(458, 'Car nous n\'avons point ici-bas de cité permanente, mais nous cherchons celle qui est à venir.', 'Heb.13:14\r'),
(459, 'Car Dieu ne nous a pas appelés à l\'impureté, mais à la sanctification.', '1Thes.4:7\r'),
(460, 'Car la parole de Dieu est vivante et efficace', 'Heb.4:12\r'),
(461, 'Car Dieu a tant aimé le monde qu\'il a donné son Fils unique, afin que quiconque croit en lui ne périsse point, mais qu\'il ait la vie éternelle.', 'Jn.3:16\r'),
(462, 'Car je sais en qui j\'ai cru...', '2Tim.1:12\r'),
(463, 'Car la grâce de Dieu, source de salut pour tous les hommes, a été manifestée. ', 'Ti.2:11\r'),
(464, 'Jésus Christ est le même hier, aujourd\'hui, et éternellement. ', 'Heb.13:8\r'),
(465, 'Si donc nous avons la nourriture et le vêtement, cela nous suffira. ', '1Tim.6:8\r'),
(466, 'Soyez remplis de l\'esprit ', 'Eph.5:18\r'),
(467, 'Quelle est envers nous qui croyons l\'infinie grandeur de sa puissance', 'Eph.1:19\r'),
(468, 'Qu\'il illumine les yeux de votre coeur, pour que vous sachiez ...quelle est la richesse de la gloire de son héritage qu\'il réserve //', 'aux saints'),
(469, 'Si vous entendez sa voix, n\'endurcissez pas vos coeurs', 'Heb.3:7-8\r'),
(470, 'Moi, je reprends et je châtie tous ceux que j\'aime. Aie donc du zèle, et repens-toi.', 'Rv.3:19\r'),
(471, 'Rendez-vous, par la charité, serviteurs les uns des autres.', 'Gal.5:13\r'),
(472, 'Faites en tout temps par l\'Esprit toutes sortes de prières et de supplications.', 'Eph.6:18\r'),
(473, 'En lui nous avons la rédemption par son sang, la rémission des péchés', 'Eph.1:7\r'),
(474, 'Nous sommes devenus participants de Christ', 'Heb.3:14\r'),
(475, 'Exhortez-vous les uns les autres chaque jour.', 'Heb.3:13\r'),
(476, 'N\'abandonnons pas notre assemblée', 'Heb.10:25\r'),
(477, 'Ne dormons donc point comme les autres, mais veillons et soyons sobres.', '1Thes.5:6\r'),
(478, 'Ne vous inquiétez de rien', 'Phil.4:6\r'),
(479, 'Ne néglige pas le don qui est en toi', '1Tim.4:14\r'),
(480, 'Priez sans cesse.', '1Thes.5:17\r'),
(481, 'Affectionnez-vous aux choses d\'en haut, et non à celles qui sont sur la terre. ', 'Col.3:2\r'),
(482, 'Il nous a sauvés, non à cause des oeuvres...mais selon sa miséricorde', 'Ti.3:5\r'),
(483, 'Ils l\'ont vaincu à cause du sang de l\'agneau et à cause de la parole de leur témoignage', 'Rv.12:11\r'),
(484, 'Laissant les éléments de la parole de Christ, tendons à ce qui est parfait...', 'Heb.6:1\r'),
(485, 'Il s\'est donne lui-même pour nos péchés...', 'Gal.1:4\r'),
(486, 'Faites connaître vos besoins à Dieu', 'Phil.4:6\r'),
(487, 'Mais le fruit de l\'Esprit, c\'est l\'amour, la joie, la paix, ...', 'Gal.5:22\r'),
(488, 'À celui qui vaincra, je donnerai à manger de l\'arbre de vie, qui est dans le paradis de Dieu. ', 'Rv.2:7\r'),
(489, 'Celui qui vaincra, je le ferai asseoir avec moi sur mon trône', 'Rv.3:21\r'),
(490, 'Combats le bon combat de la foi, saisis la vie éternelle', '1Tim.6:12\r'),
(491, 'Devenez donc les imitateurs de Dieu, comme des enfants bien-aimés', 'Eph.5:1\r'),
(492, 'Comprenez quelle est la volonté du Seigneur.', 'Eph.5:17\r'),
(493, 'Considérez, en effet, celui qui a supporté contre sa personne une telle opposition de la part des pécheurs', 'Heb.12:3\r'),
(494, 'Marchez selon l\'Esprit', 'Gal.5:16\r'),
(495, 'Marchez comme des enfants de lumière!', 'Eph.5:8\r'),
(496, 'Le juste vivra par la foi. ', 'Rom.1:17\r'),
(497, 'Recherche la justice, la piété, la foi, la charité, la patience, la douceur. ', '1Tim.6:11\r'),
(498, 'Prêche la parole, insiste en toute occasion, favorable ou non...', '2Tim.4:2\r'),
(499, 'Réjouissez-vous toujours dans le Seigneur, je le répète, réjouissez-vous. ', 'Phil.4:4\r'),
(500, 'Courons avec persévérance dans la carrière qui nous est ouverte', 'Heb.12:1\r'),
(501, 'Que le juste pratique encore la justice', 'Rv.22:11\r'),
(502, 'Je viens bientôt. ', 'Rv.3:11\r'),
(503, 'Que votre parole soit toujours accompagnée de grâce, assaisonnée de sel', 'Col.4:6\r'),
(504, 'Que la parole de Christ habite parmi vous abondamment', 'Col.3:16\r'),
(505, 'Demeurez donc fermes, et ne vous laissez pas mettre de nouveau sous le joug de la servitude. ', 'Gal.5:1\r'),
(506, 'Ceux qui sont à Jésus Christ ont crucifié la chair...', 'Gal.5:24\r'),
(507, 'Vous avez besoin de persévérance, afin qu\'après avoir accompli la volonté de Dieu, vous obteniez ce qui vous est promis.', 'Heb.10:36\r'),
(508, 'Fortifiez donc vos mains languissantes et vos genoux affaiblis', 'Heb.12:12\r'),
(509, 'Toi donc, mon enfant, fortifie-toi dans la grâce qui est en Jésus Christ. ', '2Tim.2:1\r'),
(510, 'Fortifiez-vous dans le Seigneur, et par sa force toute-puissante. ', 'Eph.6:10\r'),
(511, 'Nous mettons notre espérance dans le Dieu vivant, qui est le Sauveur de tous les hommes, principalement des croyants.', '1Tim.4:10\r'),
(512, 'Garde le bon dépôt, par le Saint-Esprit qui habite en nous.', '2Tim.1:14\r'),
(513, 'Christ en vous, l\'espérance de la gloire', 'Col.1:27\r'),
(514, 'Christ, qui nous a aimés, et qui s\'est livre lui-même...', 'Eph.5:2\r'),
(515, 'Jésus Christ est venu dans le monde pour sauver les pécheurs', '1Tim.1:15\r'),
(516, 'Je suis l\'alpha et l\'oméga, dit le Seigneur Dieu, celui qui est, qui était, et qui vient, le Tout Puissant.', 'Rv.1:8\r'),
(517, 'J\'ai mis devant toi une porte ouverte, que personne ne peut fermer.', 'Rv.3:8');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ng_gallery`
--
ALTER TABLE `ng_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `online`
--
ALTER TABLE `online`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `verses`
--
ALTER TABLE `verses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `following`
--
ALTER TABLE `following`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT pour la table `ng_gallery`
--
ALTER TABLE `ng_gallery`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `online`
--
ALTER TABLE `online`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `verses`
--
ALTER TABLE `verses`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=518;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;