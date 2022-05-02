-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 02. kvě 2022, 22:32
-- Verze serveru: 10.4.22-MariaDB
-- Verze PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `sportisimo`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_by`, `created_at`, `edited_at`, `edited_by`) VALUES
(1, 'Adidas', 2, '2022-05-02 22:27:41', NULL, NULL),
(2, 'Nike', 2, '2022-05-02 22:27:49', '2022-05-02 22:27:59', 2),
(3, 'Reebok', 2, '2022-05-02 22:28:06', NULL, NULL),
(4, 'Vans', 2, '2022-05-02 22:28:18', NULL, NULL),
(6, 'Loap', 2, '2022-05-02 22:28:29', NULL, NULL),
(7, 'Lotto', 2, '2022-05-02 22:28:33', NULL, NULL),
(8, 'Willard', 2, '2022-05-02 22:28:39', NULL, NULL),
(9, 'HiTec', 2, '2022-05-02 22:28:49', NULL, NULL),
(10, 'Umbro', 2, '2022-05-02 22:28:58', NULL, NULL),
(11, 'Puma', 2, '2022-05-02 22:29:03', NULL, NULL),
(12, 'New Balance', 2, '2022-05-02 22:29:08', NULL, NULL),
(13, 'Under Armour', 2, '2022-05-02 22:29:17', NULL, NULL),
(14, 'Warner Bros', 2, '2022-05-02 22:29:45', NULL, NULL),
(15, 'Salomon', 2, '2022-05-02 22:30:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(2, 'admin', '$2y$10$cKHycHYjcKx0PbFJJYt7weVfg94TlG0zwuVGj6FNkffwc9APge0AC', 'petrondrisek@seznam.cz');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
