-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Čtv 16. pro 2021, 07:47
-- Verze serveru: 10.3.28-MariaDB
-- Verze PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `linux-nggcv`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `knowledgebase`
--

CREATE TABLE `knowledgebase` (
  `id_contribution` int(11) NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
  `text` text DEFAULT NULL,
  `anotace` text NOT NULL,
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `mail_generation`
--

CREATE TABLE `mail_generation` (
  `ID` int(11) NOT NULL,
  `MAIL_FROM_MAIL` varchar(65) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `MAIL_FROM_NAME` varchar(65) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `HEADER` varchar(65) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `TEXT` text CHARACTER SET latin2 COLLATE latin2_bin NOT NULL
) ENGINE=Aria DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabulky `prelim_order`
--

CREATE TABLE `prelim_order` (
  `id` int(11) NOT NULL,
  `type_of_computer` set('pc','ntb','placeholder') DEFAULT NULL,
  `age_of_computer` int(11) DEFAULT NULL,
  `contact` text NOT NULL,
  `adv_info` text DEFAULT NULL,
  `contact_from` time DEFAULT NULL,
  `contact_till` time DEFAULT NULL,
  `date_of_request` datetime DEFAULT current_timestamp(),
  `state` text NOT NULL DEFAULT 'added_now'
) ENGINE=Aria DEFAULT CHARSET=latin1;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `knowledgebase`
--
ALTER TABLE `knowledgebase`
  ADD PRIMARY KEY (`id_contribution`);

--
-- Klíče pro tabulku `mail_generation`
--
ALTER TABLE `mail_generation`
  ADD PRIMARY KEY (`ID`);

--
-- Klíče pro tabulku `prelim_order`
--
ALTER TABLE `prelim_order`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `knowledgebase`
--
ALTER TABLE `knowledgebase`
  MODIFY `id_contribution` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `mail_generation`
--
ALTER TABLE `mail_generation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `prelim_order`
--
ALTER TABLE `prelim_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
