-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 13, 2023 alle 11:00
-- Versione del server: 10.4.25-MariaDB
-- Versione PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_shoes`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `bought`
--

CREATE TABLE `bought` (
  `id` int(11) DEFAULT NULL,
  `username` varchar(16) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `price` double NOT NULL,
  `total_price` double NOT NULL,
  `date_of` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `bought`
--

INSERT INTO `bought` (`id`, `username`, `product_name`, `price`, `total_price`, `date_of`) VALUES
(3, 'goat', 'Nike Tiempo Premier', 349.99, 579.87, '2023-02-13 10:55:10'),
(5, 'goat', 'Nike Tiempo White and Gray', 289.99, 289.99, '2023-02-13 10:25:56'),
(10, 'goat', 'Nike Vapor Club', 129.99, 579.87, '2023-02-13 10:55:10'),
(6, 'goat', 'Nike Zoom Superfly', 99.89, 579.87, '2023-02-13 10:55:10'),
(3, 'toro', 'Nike Tiempo Premier', 349.99, 899.96, '2023-02-13 10:57:43'),
(4, 'toro', 'Nike Tiempo Total Black', 129.99, 899.96, '2023-02-13 10:57:43'),
(5, 'toro', 'Nike Tiempo White and Gray', 289.99, 899.96, '2023-02-13 10:57:43'),
(10, 'toro', 'Nike Vapor Club', 129.99, 899.96, '2023-02-13 10:57:43');

-- --------------------------------------------------------

--
-- Struttura della tabella `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `insert_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `cart`
--

INSERT INTO `cart` (`id`, `username`, `insert_date`) VALUES
(0, 'toro', '2023-02-13 10:59:30'),
(1, 'toro', '2023-02-13 10:59:27'),
(8, 'toro', '2023-02-13 10:59:22');

-- --------------------------------------------------------

--
-- Struttura della tabella `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `price` double NOT NULL,
  `field` varchar(32) NOT NULL,
  `height_cleats` double NOT NULL,
  `material` varchar(32) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `field`, `height_cleats`, `material`, `image`) VALUES
(0, 'Adidas Predator Orange', 89.99, 'Artificial grass', 16.5, 'Plastic', '../new_image/Adidas Predator Orange.jpg'),
(1, 'Joma Black and Orange', 99.99, 'Parquet', 0, 'Imitation leather', '../new_image/Joma Black and Orange.jpg'),
(2, 'Mizuno White and Blue', 199.99, 'Parquet', 0, 'Leather', '../new_image/Mizuno White and Blue.jpg'),
(3, 'Nike Tiempo Premier', 349.99, 'Parquet', 0, 'Leather', '../new_image/Nike Tiempo Premier.jpg'),
(4, 'Nike Tiempo Total Black', 129.99, 'Real grass', 16.5, 'Leather', '../new_image/Nike Tiempo Total Black.jpg'),
(5, 'Nike Tiempo White and Gray', 289.99, 'Artificial grass', 17.5, 'Leather', '../new_image/Nike Tiempo White and Gray.jpg'),
(6, 'Nike Zoom Superfly', 99.89, 'Artificial grass', 18.5, 'Imitation leather', '../new_image/Nike Zoom Superfly.jpg'),
(7, 'Puma Ultra Match Orange', 139.99, 'Artificial grass', 17.5, 'Leather', '../new_image/Puma Ultra Match Orange.jpg'),
(8, 'Puma Ultra Match Lightblue', 199.99, 'Artificial grass', 17.5, 'Leather', '../new_image/Puma Ultra Match Lightblue.jpg'),
(9, 'Umbro Soft Total Black', 149.99, 'Real grass', 16.5, 'Leather', '../new_image/Umbro Soft Total Black.jpg'),
(10, 'Nike Vapor Club', 129.99, 'Artificial grass', 17.5, 'Leather', '../new_image/Nike Vapor Club.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `insert_date` datetime NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `reviews`
--

INSERT INTO `reviews` (`id`, `username`, `insert_date`, `text`) VALUES
(3, 'goat', '2023-02-13 10:57:00', 'Delle vere piume al piede.'),
(3, 'toro', '2023-02-13 10:58:48', 'Confermo quanto detto da GOAT'),
(4, 'toro', '2023-02-13 10:59:10', 'Per i terreni in erba vera sono la scelta migliore.'),
(5, 'goat', '2023-02-13 10:54:51', 'Mai stato più felice di un acquisto. Consigliatissime!'),
(10, 'toro', '2023-02-13 10:58:34', 'Scarpe più belle in assoluto!');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `username` varchar(16) NOT NULL,
  `name` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `typeof` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`username`, `name`, `surname`, `email`, `password`, `typeof`) VALUES
('goat', 'Lionel', 'Messi', 'leo.messi@edu.unito.it', 'd416d170cdcac85d7745222903c4f9c7', 'user'),
('root', 'Michele', 'Merico', 'michele.merico@edu.unito.it', '3e137e0b245b36a6b4fbd731c4d68d97', 'root'),
('toro', 'Lautaro', 'Martinez', 'lautaro.martinez@edu.unito.it', 'ff7ef5dd802d8f6095991c3bf6653688', 'user');

-- --------------------------------------------------------

--
-- Struttura della tabella `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `insert_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `wishlist`
--

INSERT INTO `wishlist` (`id`, `username`, `insert_date`) VALUES
(3, 'goat', '2023-02-13 10:26:12'),
(4, 'goat', '2023-02-13 10:26:14'),
(4, 'toro', '2023-02-13 10:57:18'),
(6, 'toro', '2023-02-13 10:57:17');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `bought`
--
ALTER TABLE `bought`
  ADD PRIMARY KEY (`username`,`product_name`,`date_of`),
  ADD KEY `prodotto` (`id`);

--
-- Indici per le tabelle `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`,`username`,`insert_date`),
  ADD KEY `onUsername` (`username`);

--
-- Indici per le tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`,`username`,`insert_date`),
  ADD KEY `onUsernameReviews` (`username`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Indici per le tabelle `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`,`username`,`insert_date`) USING BTREE,
  ADD KEY `onUsernameWishlist` (`username`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `bought`
--
ALTER TABLE `bought`
  ADD CONSTRAINT `prodotto` FOREIGN KEY (`id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `onProduct` FOREIGN KEY (`id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `onUsername` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `onProductReviews` FOREIGN KEY (`id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `onUsernameReviews` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `onProductWishlist` FOREIGN KEY (`id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `onUsernameWishlist` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
