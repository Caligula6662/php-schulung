-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Nov 2020 um 11:54
-- Server-Version: 10.3.16-MariaDB
-- PHP-Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `benutzerverwatlung`
--
CREATE DATABASE IF NOT EXISTS `benutzerverwatlung` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `benutzerverwatlung`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `acc_id` int(11) NOT NULL,
  `acc_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acc_password` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acc_signature` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_avatarpath` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'css/images/avatar_dummy.png',
  `sta_id` int(11) NOT NULL DEFAULT 1,
  `rol_id` int(11) NOT NULL DEFAULT 3,
  `usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `rol_id` int(11) NOT NULL,
  `rol_label` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `roles`
--

INSERT INTO `roles` (`rol_id`, `rol_label`) VALUES
(1, 'Administrator'),
(2, 'Moderator'),
(3, 'User');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `sta_id` int(11) NOT NULL,
  `sta_label` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `states`
--

INSERT INTO `states` (`sta_id`, `sta_label`) VALUES
(1, 'open'),
(2, 'closed');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `usr_id` int(11) NOT NULL,
  `usr_firstname` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usr_lastname` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usr_email` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usr_birthdate` date DEFAULT NULL,
  `usr_street` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usr_housenumber` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usr_zip` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usr_city` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usr_country` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usr_registerdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indizes für die Tabelle `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indizes für die Tabelle `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`sta_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `accounts`
--
ALTER TABLE `accounts`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `roles`
--
ALTER TABLE `roles`
  MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `states`
--
ALTER TABLE `states`
  MODIFY `sta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
