-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2020 a las 05:22:34
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `moviepass`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cinemas`
--

CREATE TABLE `cinemas` (
  `idCinema` int(11) NOT NULL,
  `cinemaName` varchar(255) NOT NULL,
  `openingTime` time DEFAULT NULL,
  `closingTime` time DEFAULT NULL,
  `ticket_value` float DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `Cinemadelete` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cinemas`
--

INSERT INTO `cinemas` (`idCinema`, `cinemaName`, `openingTime`, `closingTime`, `ticket_value`, `capacity`, `Cinemadelete`, `address`) VALUES
(1, 'Almendra', '03:00:00', '23:00:00', 150, 150, 0, 'a'),
(2, 'Avenida 4', '01:22:00', '22:22:00', 150, 150, 0, 'Mdp'),
(3, 'Avenida', '13:00:00', '19:57:00', 150, 150, 0, 'Mdp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditcardinfo`
--

CREATE TABLE `creditcardinfo` (
  `company` varchar(50) NOT NULL,
  `expirationDate` date NOT NULL,
  `number` bigint(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `creditcardinfo`
--

INSERT INTO `creditcardinfo` (`company`, `expirationDate`, `number`, `id`) VALUES
('Visa', '2020-11-01', 4716527179241111, 3),
('Mastercard', '2020-11-01', 5406376698813857, 4),
('Visa', '2020-11-01', 4929083578568533, 5),
('Mastercard', '2020-11-01', 5109883386773699, 6),
('Visa', '2020-11-01', 4807567293760901, 7),
('Visa', '2020-11-01', 4539521693384916, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `discountpolicy`
--

CREATE TABLE `discountpolicy` (
  `dayOfTheWeek` varchar(50) NOT NULL,
  `percentage` float NOT NULL,
  `name` varchar(50) NOT NULL,
  `minTickets` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `discountpolicy`
--

INSERT INTO `discountpolicy` (`dayOfTheWeek`, `percentage`, `name`, `minTickets`, `id`) VALUES
('Saturday', 0, 'discountSaturday', 0, 1),
('Sunday', 0, 'discountSunday', 0, 2),
('Monday', 0, 'discountMonday', 0, 3),
('Tuesday', 0.25, 'discountTuesday', 2, 4),
('Wednesday', 0.25, 'discountWednesday', 2, 5),
('Thursday', 0, 'discountThursday', 0, 6),
('Friday', 0, 'discountFriday', 0, 7),
('None', 0, 'discountNone', 0, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `functions`
--

CREATE TABLE `functions` (
  `id` int(11) NOT NULL,
  `time` time NOT NULL,
  `asistencia` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `idRoom` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `finishTime` time NOT NULL,
  `day` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `functions`
--

INSERT INTO `functions` (`id`, `time`, `asistencia`, `idMovie`, `idRoom`, `deleted`, `finishTime`, `day`) VALUES
(6, '07:48:00', 0, 635302, 1, 1, '09:45:54', '2020-10-29'),
(7, '06:16:00', 0, 528085, 1, 0, '08:10:08', '2020-11-27'),
(8, '04:49:00', 0, 413518, 1, 1, '06:49:55', '2020-09-30'),
(9, '03:42:00', 0, 413518, 1, 1, '05:42:55', '2020-10-28'),
(10, '02:31:00', 0, 556984, 4, 0, '04:41:55', '2020-10-27'),
(11, '15:37:00', 0, 413518, 1, 1, '17:37:55', '2020-10-29'),
(12, '05:40:00', 0, 590223, 1, 1, '07:29:55', '2020-10-29'),
(13, '07:26:00', 0, 556984, 1, 1, '09:36:55', '2020-10-27'),
(14, '05:39:00', 0, 556984, 1, 0, '07:49:55', '2020-10-31'),
(15, '22:01:00', 0, 635302, 1, 1, '23:58:54', '2020-10-29'),
(16, '22:58:00', 0, 635302, 1, 1, '00:55:54', '2020-10-29'),
(17, '12:09:00', 0, 413518, 1, 0, '14:09:55', '2020-11-30'),
(18, '14:30:00', 0, 556984, 5, 0, '16:40:55', '2020-11-30'),
(19, '04:31:00', 0, 413518, 1, 0, '06:31:55', '2020-11-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(12, 'Adventure'),
(14, 'Fantasy'),
(16, 'Animation'),
(18, 'Drama'),
(27, 'Horror'),
(28, 'Action'),
(35, 'Comedy'),
(36, 'History'),
(53, 'Thriller'),
(80, 'Crime'),
(878, 'Science Fiction'),
(9648, 'Mystery'),
(10402, 'Music'),
(10749, 'Romance'),
(10751, 'Family'),
(10752, 'War');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genresxmovies`
--

CREATE TABLE `genresxmovies` (
  `idMovie` int(11) DEFAULT NULL,
  `idGenre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `genresxmovies`
--

INSERT INTO `genresxmovies` (`idMovie`, `idGenre`) VALUES
(635302, 16),
(635302, 28),
(635302, 36),
(635302, 12),
(635302, 14),
(635302, 18),
(590223, 28),
(590223, 12),
(590223, 35),
(590223, 878),
(556984, 18),
(556984, 36),
(556984, 53),
(413518, 14),
(413518, 10751),
(413518, 12),
(413518, 18),
(528085, 878),
(528085, 53),
(528085, 18),
(539885, 28),
(539885, 80),
(539885, 18),
(539885, 53),
(724989, 28),
(724989, 53),
(337401, 28),
(337401, 12),
(337401, 18),
(337401, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `release_date` date DEFAULT NULL,
  `vote_average` smallint(6) DEFAULT NULL,
  `overview` longtext DEFAULT NULL,
  `poster_path` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `runtime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movies`
--

INSERT INTO `movies` (`id`, `title`, `release_date`, `vote_average`, `overview`, `poster_path`, `deleted`, `runtime`) VALUES
(337401, 'Mulan', '2020-09-04', 7, 'When the Emperor of China issues a decree that one man per family must serve in the Imperial Chinese Army to defend the country from Huns, Hua Mulan, the eldest daughter of an honored warrior, steps in to take the place of her ailing father. She is spirited, determined and quick on her feet. Disguised as a man by the name of Hua Jun, she is tested every step of the way and must harness her innermost strength and embrace her true potential.', '/aKx1ARwG55zZ0GpRvU2WrGrCG9o.jpg', 0, '01:55:39'),
(413518, 'Pinocchio', '2019-12-19', 6, 'In this live-action adaptation of the beloved fairytale, old woodcarver Geppetto fashions a wooden puppet, Pinocchio, who magically comes to life. Pinocchio longs for adventure and is easily led astray, encountering magical beasts, fantastical spectacles, while making friends and foes along his journey. However, his dream is to become a real boy, which can only come true if he finally changes his ways.', '/4w1ItwCJCTtSi9nPfJC1vU6NIVg.jpg', 0, '02:00:55'),
(528085, '2067', '2020-10-01', 5, 'A lowly utility worker is called to the future by a mysterious radio signal, he must leave his dying wife to embark on a journey that will force him to face his deepest fears in an attempt to change the fabric of reality and save humankind from its greatest environmental crisis yet.', '/7D430eqZj8y3oVkLFfsWXGRcpEG.jpg', 0, '01:54:08'),
(539885, 'Ava', '2020-07-02', 5, 'A black ops assassin is forced to fight for her own survival after a job goes dangerously wrong.', '/qzA87Wf4jo1h8JMk9GilyIYvwsA.jpg', 1, '01:36:16'),
(556984, 'The Trial of the Chicago 7', '2020-09-25', 7, 'What was intended to be a peaceful protest at the 1968 Democratic National Convention turned into a violent clash with police and the National Guard. The organizers of the protest — including Abbie Hoffman, Jerry Rubin, Tom Hayden and Bobby Seale — were charged with conspiracy to incite a riot and the trial that followed was one of the most notorious in history.', '/ahf5cVdooMAlDRiJOZQNuLqa1Is.jpg', 0, '02:10:55'),
(590223, 'Love and Monsters', '2020-10-16', 7, 'Seven years after the Monsterpocalypse, Joel Dawson, along with the rest of humanity, has been living underground ever since giant creatures took control of the land. After reconnecting over radio with his high school girlfriend Aimee, who is now 80 miles away at a coastal colony, Joel begins to fall for her again. As Joel realizes that there’s nothing left for him underground, he decides against all logic to venture out to Aimee, despite all the dangerous monsters that stand in his way.', '/r4Lm1XKP0VsTgHX4LG4syAwYA2I.jpg', 0, '01:49:55'),
(635302, 'Demon Slayer: Kimetsu no Yaiba - The Movie: Mugen Train', '2020-10-16', 7, 'Tanjirō Kamado, joined with Inosuke Hashibira, a boy raised by boars who wears a boar\'s head, and Zenitsu Agatsuma, a scared boy who reveals his true power when he sleeps, boards the Infinity Train on a new mission with the Fire Hashira, Kyōjurō Rengoku, to defeat a demon who has been tormenting the people and killing the demon slayers who oppose it!', '/h8Rb9gBr48ODIwYUttZNYeMWeUU.jpg', 0, '01:57:54'),
(724989, 'Hard Kill', '2020-10-23', 4, 'The work of billionaire tech CEO Donovan Chalmers is so valuable that he hires mercenaries to protect it, and a terrorist group kidnaps his daughter just to get it.', '/ugZW8ocsrfgI95pnQ7wrmKDxIe.jpg', 0, '01:38:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase`
--

CREATE TABLE `purchase` (
  `amount` float NOT NULL,
  `id` int(11) NOT NULL,
  `creditCardId` int(11) NOT NULL,
  `numberOfTickets` int(11) NOT NULL,
  `transactionDate` date NOT NULL DEFAULT current_timestamp(),
  `discountId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `purchase`
--

INSERT INTO `purchase` (`amount`, `id`, `creditCardId`, `numberOfTickets`, `transactionDate`, `discountId`) VALUES
(300, 51, 2, 1, '2020-11-09', 9),
(2250, 52, 6, 10, '2020-11-10', 4),
(2250, 53, 6, 10, '2020-11-10', 4),
(2250, 54, 6, 10, '2020-11-10', 4),
(2250, 55, 6, 10, '2020-11-10', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(2, 'Admin'),
(1, 'Client');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rooms`
--

CREATE TABLE `rooms` (
  `idRoom` int(11) NOT NULL,
  `roomName` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `idCinema` int(11) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rooms`
--

INSERT INTO `rooms` (`idRoom`, `roomName`, `capacity`, `idCinema`, `price`, `deleted`) VALUES
(1, 'Mulan', 200, 1, 300, 0),
(2, 'a', 150, 1, 150, 0),
(4, 'Avenida', 150, 2, 150, 0),
(5, 'Mulan', 150, 3, 150, 0),
(6, '    ', 300, 1, 50, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `idFunction` int(11) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idPayment` int(11) DEFAULT NULL,
  `seatNumber` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`id`, `idFunction`, `idUser`, `idPayment`, `seatNumber`) VALUES
(1, 17, 1, 51, 1),
(2, 7, 1, 52, 1),
(3, 7, 1, 52, 2),
(4, 7, 1, 52, 3),
(5, 7, 1, 52, 4),
(6, 7, 1, 52, 5),
(7, 7, 1, 52, 6),
(8, 7, 1, 52, 7),
(9, 7, 1, 52, 8),
(10, 7, 1, 52, 9),
(11, 7, 1, 52, 10),
(12, 7, 1, 53, 11),
(13, 7, 1, 53, 12),
(14, 7, 1, 53, 13),
(15, 7, 1, 53, 14),
(16, 7, 1, 53, 15),
(17, 7, 1, 53, 16),
(18, 7, 1, 53, 17),
(19, 7, 1, 53, 18),
(20, 7, 1, 53, 19),
(21, 7, 1, 53, 20),
(22, 7, 1, 54, 21),
(23, 7, 1, 54, 22),
(24, 7, 1, 54, 23),
(25, 7, 1, 54, 24),
(26, 7, 1, 54, 25),
(27, 7, 1, 54, 26),
(28, 7, 1, 54, 27),
(29, 7, 1, 54, 28),
(30, 7, 1, 54, 29),
(31, 7, 1, 54, 30),
(32, 7, 1, 55, 31),
(33, 7, 1, 55, 32),
(34, 7, 1, 55, 33),
(35, 7, 1, 55, 34),
(36, 7, 1, 55, 35),
(37, 7, 1, 55, 36),
(38, 7, 1, 55, 37),
(39, 7, 1, 55, 38),
(40, 7, 1, 55, 39),
(41, 7, 1, 55, 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_dni` bigint(11) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_birthday` date NOT NULL,
  `user_role` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_dni`, `user_email`, `user_birthday`, `user_role`, `deleted`) VALUES
(1, 'admin', '$2y$10$Y8uv.LImHjTsBXCoorLwnOUUlBBgViNUUJnoone7lWsNhZ1ZUIu8m', 9999999, 'dev.groupthree@gmail.com', '2020-10-15', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usersxcreditcardinfo`
--

CREATE TABLE `usersxcreditcardinfo` (
  `userid` int(11) NOT NULL,
  `creditCardId` int(11) NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usersxcreditcardinfo`
--

INSERT INTO `usersxcreditcardinfo` (`userid`, `creditCardId`, `deleted`, `id`) VALUES
(1, 3, 0, 2),
(1, 5, 0, 4),
(1, 6, 0, 5),
(1, 7, 0, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`idCinema`);

--
-- Indices de la tabla `creditcardinfo`
--
ALTER TABLE `creditcardinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `discountpolicy`
--
ALTER TABLE `discountpolicy`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `functions`
--
ALTER TABLE `functions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_functions_idMovies` (`idMovie`),
  ADD KEY `fk_functions_idRoom` (`idRoom`);

--
-- Indices de la tabla `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `genresxmovies`
--
ALTER TABLE `genresxmovies`
  ADD KEY `fk_idMovie` (`idMovie`),
  ADD KEY `fk_idGenre` (`idGenre`);

--
-- Indices de la tabla `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_purchase_discountId` (`discountId`),
  ADD KEY `fk_purchase_idCreditCard` (`creditCardId`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `unq_roles_name` (`role_name`);

--
-- Indices de la tabla `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`idRoom`),
  ADD UNIQUE KEY `roomName` (`roomName`,`idCinema`) USING BTREE,
  ADD KEY `fk_idcinema` (`idCinema`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tickets_idFunction` (`idFunction`),
  ADD KEY `fk_tickets_idUser` (`idUser`),
  ADD KEY `fk_tickets_idPayment` (`idPayment`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `unq_users_dni` (`user_dni`),
  ADD UNIQUE KEY `unq_users_email` (`user_email`),
  ADD UNIQUE KEY `unq_users_name` (`user_name`),
  ADD KEY `fk_users_role` (`user_role`);

--
-- Indices de la tabla `usersxcreditcardinfo`
--
ALTER TABLE `usersxcreditcardinfo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usersXcreditCardInfo_userid` (`userid`),
  ADD KEY `fk_usersXcreditCardInfo_creditCardId` (`creditCardId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `idCinema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `creditcardinfo`
--
ALTER TABLE `creditcardinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `discountpolicy`
--
ALTER TABLE `discountpolicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `functions`
--
ALTER TABLE `functions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10771;

--
-- AUTO_INCREMENT de la tabla `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rooms`
--
ALTER TABLE `rooms`
  MODIFY `idRoom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usersxcreditcardinfo`
--
ALTER TABLE `usersxcreditcardinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `functions`
--
ALTER TABLE `functions`
  ADD CONSTRAINT `fk_functions_idMovies` FOREIGN KEY (`idMovie`) REFERENCES `movies` (`id`),
  ADD CONSTRAINT `fk_functions_idRoom` FOREIGN KEY (`idRoom`) REFERENCES `rooms` (`idRoom`);

--
-- Filtros para la tabla `genresxmovies`
--
ALTER TABLE `genresxmovies`
  ADD CONSTRAINT `fk_idGenre` FOREIGN KEY (`idGenre`) REFERENCES `genres` (`id`),
  ADD CONSTRAINT `fk_idMovie` FOREIGN KEY (`idMovie`) REFERENCES `movies` (`id`);

--
-- Filtros para la tabla `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `fk_purchase_creditCardXUserId` FOREIGN KEY (`creditCardId`) REFERENCES `usersxcreditcardinfo` (`id`),
  ADD CONSTRAINT `fk_purchase_discountId` FOREIGN KEY (`discountId`) REFERENCES `discountpolicy` (`id`),
  ADD CONSTRAINT `fk_purchase_idCreditCard` FOREIGN KEY (`creditCardId`) REFERENCES `usersxcreditcardinfo` (`id`);

--
-- Filtros para la tabla `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `fk_idcinema` FOREIGN KEY (`idCinema`) REFERENCES `cinemas` (`idCinema`);

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_tickets_idFunction` FOREIGN KEY (`idFunction`) REFERENCES `functions` (`id`),
  ADD CONSTRAINT `fk_tickets_idPayment` FOREIGN KEY (`idPayment`) REFERENCES `purchase` (`id`),
  ADD CONSTRAINT `fk_tickets_idUser` FOREIGN KEY (`idUser`) REFERENCES `users` (`user_id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`user_role`) REFERENCES `roles` (`role_id`);

--
-- Filtros para la tabla `usersxcreditcardinfo`
--
ALTER TABLE `usersxcreditcardinfo`
  ADD CONSTRAINT `fk_usersXcreditCardInfo_creditCardId` FOREIGN KEY (`creditCardId`) REFERENCES `creditcardinfo` (`id`),
  ADD CONSTRAINT `fk_usersXcreditCardInfo_userid` FOREIGN KEY (`userid`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
