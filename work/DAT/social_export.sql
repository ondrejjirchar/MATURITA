-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 20. úno 2023, 11:17
-- Verze serveru: 10.4.27-MariaDB
-- Verze PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `social`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `comment`
--

CREATE TABLE `comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `wall_id` int(10) UNSIGNED NOT NULL,
  `content` varchar(255) NOT NULL,
  `posted` datetime DEFAULT NULL,
  `player_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `comment`
--

INSERT INTO `comment` (`id`, `wall_id`, `content`, `posted`, `player_id`) VALUES
(1, 4, 'Non scholae, sed vitae discimus.', '2023-02-20 11:09:53', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `game`
--

CREATE TABLE `game` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `game`
--

INSERT INTO `game` (`id`, `name`, `description`) VALUES
(1, 'Dota 2', NULL),
(2, 'Prey', NULL),
(3, 'Red Dead Redemption 2', NULL),
(4, 'Grand Theft Auto 5 / GTA Online', NULL),
(5, 'Forza Horizon 5', NULL),
(6, 'God of War', NULL),
(7, 'Final Fantasy XIV Online', NULL),
(8, 'Hollow Knight', NULL),
(9, 'Crusader Kings 3', NULL),
(10, 'Half-Life: Alyx', NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `player`
--

CREATE TABLE `player` (
  `id` int(10) UNSIGNED NOT NULL,
  `nickname` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `player`
--

INSERT INTO `player` (`id`, `nickname`, `password`) VALUES
(1, 'commodore', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9'),
(2, 'egon666', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9'),
(3, 'sia', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9'),
(4, 'golem555', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9'),
(5, 'Thanos', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9'),
(6, 'Kronos', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9'),
(7, 'alicebehindthelookingglass', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9'),
(8, 'gandalph', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9'),
(9, 'evoque', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9'),
(10, 'bookofdeath', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9');

-- --------------------------------------------------------

--
-- Struktura tabulky `player_has_game`
--

CREATE TABLE `player_has_game` (
  `player_id` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `player_has_game`
--

INSERT INTO `player_has_game` (`player_id`, `game_id`) VALUES
(1, 1),
(1, 10),
(2, 1),
(2, 7),
(3, 4),
(4, 1),
(4, 4),
(4, 6),
(4, 7),
(5, 1),
(5, 4),
(6, 4),
(7, 1),
(7, 7),
(7, 10),
(8, 3),
(8, 6),
(9, 7),
(10, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `player_has_player`
--

CREATE TABLE `player_has_player` (
  `player_id` int(10) UNSIGNED NOT NULL,
  `player_id_friend` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `player_has_player`
--

INSERT INTO `player_has_player` (`player_id`, `player_id_friend`) VALUES
(1, 2),
(1, 4),
(1, 5),
(1, 7),
(4, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `wall`
--

CREATE TABLE `wall` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `info` text DEFAULT NULL,
  `player_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `wall`
--

INSERT INTO `wall` (`id`, `name`, `info`, `player_id`) VALUES
(1, 'My G@me P@ge', 'Nothing to mention here.', 1),
(4, 'Egon is here', NULL, 2),
(5, 'Hi! I am Sia.', 'Bla blaaaa blaa bla blblblaaaaa bla bla.', 3),
(6, 'Shit happens!', 'Where is my daddy?', 4),
(7, 'Santa does not exist!', 'The are no rules, You are gonna die anyway.', 5),
(8, 'Best of Titans.', 'Father of Zeus.', 6),
(9, 'Behind the looking glass', NULL, 7),
(10, 'My wall', 'I am not grey, I am white.', 8),
(11, 'evoque', NULL, 9),
(12, 'My wall', 'I love my life.', 10);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_wall1_idx` (`wall_id`),
  ADD KEY `fk_comment_player1_idx` (`player_id`);

--
-- Indexy pro tabulku `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname_UNIQUE` (`nickname`);

--
-- Indexy pro tabulku `player_has_game`
--
ALTER TABLE `player_has_game`
  ADD PRIMARY KEY (`player_id`,`game_id`),
  ADD KEY `fk_player_has_game_game1_idx` (`game_id`),
  ADD KEY `fk_player_has_game_player_idx` (`player_id`);

--
-- Indexy pro tabulku `player_has_player`
--
ALTER TABLE `player_has_player`
  ADD PRIMARY KEY (`player_id`,`player_id_friend`),
  ADD KEY `fk_player_has_player_player2_idx` (`player_id_friend`),
  ADD KEY `fk_player_has_player_player1_idx` (`player_id`);

--
-- Indexy pro tabulku `wall`
--
ALTER TABLE `wall`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_wall_player1_idx` (`player_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `game`
--
ALTER TABLE `game`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pro tabulku `player`
--
ALTER TABLE `player`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pro tabulku `wall`
--
ALTER TABLE `wall`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_player1` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comment_wall1` FOREIGN KEY (`wall_id`) REFERENCES `wall` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `player_has_game`
--
ALTER TABLE `player_has_game`
  ADD CONSTRAINT `fk_player_has_game_game1` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_player_has_game_player` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `player_has_player`
--
ALTER TABLE `player_has_player`
  ADD CONSTRAINT `fk_player_has_player_player1` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_player_has_player_player2` FOREIGN KEY (`player_id_friend`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `wall`
--
ALTER TABLE `wall`
  ADD CONSTRAINT `fk_wall_player1` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
