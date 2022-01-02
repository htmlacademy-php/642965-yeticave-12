-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 30 2021 г., 10:27
-- Версия сервера: 5.7.33
-- Версия PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `yeticave_new`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bets`
--

CREATE TABLE `bets` (
  `id` int(11) NOT NULL,
  `dt_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `price` int(11) NOT NULL,
  `lot_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `bets`
--

INSERT INTO `bets` (`id`, `dt_create`, `price`, `lot_id`, `user_id`) VALUES
(10, '2021-11-23 00:34:45', 33000, 15, 15),
(11, '2021-11-23 11:39:05', 4000, 12, 14),
(12, '2021-11-23 13:06:05', 2200, 13, 13),
(14, '2021-11-23 13:16:44', 34000, 15, 14),
(29, '2021-11-23 23:07:53', 3400, 13, 15),
(47, '2021-11-25 17:44:00', 34700, 15, 15),
(48, '2021-11-25 20:52:36', 17000, 7, 15),
(49, '2021-11-25 20:57:20', 17500, 7, 14),
(50, '2021-11-25 22:36:32', 18000, 7, 13),
(51, '2021-11-25 22:56:38', 8400, 3, 13),
(52, '2021-11-25 23:08:52', 11500, 1, 13),
(53, '2021-11-26 00:02:00', 1700, 14, 13),
(54, '2021-11-26 00:06:59', 18300, 7, 15),
(55, '2021-11-26 00:17:44', 8700, 3, 14),
(56, '2021-11-26 00:20:43', 12500, 1, 14),
(57, '2021-11-26 00:21:47', 12800, 1, 15),
(58, '2021-11-28 20:53:43', 35200, 15, 16),
(59, '2021-11-28 21:32:00', 36000, 15, 14),
(60, '2021-11-28 22:04:30', 2000, 14, 16),
(61, '2021-11-28 22:05:16', 36700, 15, 16),
(62, '2021-11-28 22:06:28', 19000, 7, 16),
(63, '2021-11-29 10:39:13', 5500, 6, 16),
(64, '2021-11-29 17:26:55', 38000, 15, 15),
(67, '2021-12-04 22:30:38', 56000, 2, 17),
(68, '2021-12-04 23:22:28', 2100, 14, 15),
(69, '2021-12-04 23:25:45', 60000, 2, 15),
(70, '2021-12-04 23:26:19', 4300, 12, 15),
(71, '2021-12-05 13:01:42', 2200, 14, 16),
(72, '2021-12-05 13:19:00', 3500, 13, 16),
(73, '2021-12-05 13:19:34', 4600, 12, 16),
(74, '2021-12-05 14:20:30', 39000, 15, 16),
(75, '2021-12-09 21:47:42', 2750, 16, 15),
(76, '2021-12-10 22:41:11', 3000, 16, 17),
(77, '2021-12-10 23:20:58', 2500, 14, 18),
(78, '2021-12-14 22:44:47', 600, 17, 13),
(79, '2021-12-15 10:26:57', 900, 17, 14),
(80, '2021-12-19 18:45:03', 15500, 18, 13),
(81, '2021-12-19 18:45:51', 20000, 18, 18),
(82, '2021-12-28 23:47:43', 20000, 7, 15),
(83, '2021-12-28 23:48:09', 2500, 17, 13),
(84, '2021-12-28 23:50:16', 5000, 12, 15),
(85, '2021-12-28 23:52:35', 21000, 18, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `symbol` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `symbol`) VALUES
(1, 'Доски и лыжи', 'boards'),
(2, 'Крепления', 'attachment'),
(3, 'Ботинки', 'boots'),
(4, 'Одежда', 'clothing'),
(5, 'Инструменты', 'tools'),
(6, 'Разное', 'other');

-- --------------------------------------------------------

--
-- Структура таблицы `lots`
--

CREATE TABLE `lots` (
  `id` int(11) NOT NULL,
  `dt_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(128) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `image` varchar(128) DEFAULT NULL,
  `price_start` int(11) NOT NULL,
  `dt_complete` datetime DEFAULT NULL,
  `bid_step` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_winner_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `lots`
--

INSERT INTO `lots` (`id`, `dt_create`, `name`, `description`, `image`, `price_start`, `dt_complete`, `bid_step`, `category_id`, `user_id`, `user_winner_id`) VALUES
(1, '2021-10-30 13:19:11', '2014 Rossignol District Snowboard', 'Очень классный сноуборд, недорого', 'img/lot-1.jpg', 11000, '2021-12-31 00:00:00', 300, 1, 1, 0),
(2, '2021-10-29 13:20:07', 'DC Ply Mens 2016/2017 Snowboard', 'Лучший сноуборд 2017 года, почти новый', 'img/lot-2.jpg', 55000, '2021-12-31 00:00:00', 1000, 1, 2, 0),
(3, '2021-10-29 13:20:07', 'Крепления Union Contact Pro 2015 года размер L/XL', 'Профессиональные крепления, почти даром', 'img/lot-3.jpg', 8000, '2021-12-25 00:00:00', 200, 2, 3, 14),
(4, '2021-10-29 13:20:07', 'Ботинки для сноуборда DC Mutiny Charocal', 'Супер качественные ботинки, не дорого', 'img/lot-4.jpg', 14000, '2021-12-21 00:00:00', 200, 3, 4, 0),
(5, '2021-10-29 13:20:07', 'Куртка для сноуборда DC Mutiny Charocal', 'Лучшая куртка для сноуборда, за смешные деньги', 'img/lot-5.jpg', 7500, '2021-12-23 00:00:00', 100, 4, 2, 0),
(6, '2021-10-29 13:20:07', 'Маска Oakley Canopy', 'Маска на все случаи жизни, отменного качества', 'img/lot-6.jpg', 5400, '2021-12-31 00:00:00', 100, 6, 3, 0),
(7, '2021-10-29 13:20:07', 'Лыжи Adidas', 'Лыжи на все случаи жизни, отменного качества', 'img/lot-7.jpg', 16500, '2021-12-31 00:00:00', 300, 1, 4, 0),
(12, '2021-11-05 12:15:03', 'Шапка ушанка', 'Отличная шапка для занятий зимними видами спорта. ', 'uploads/шапка.jpg', 3500, '2021-12-29 00:00:00', 300, 4, 13, 15),
(13, '2021-11-05 12:18:13', 'Лыжные палки', 'Лыжные палки отличного отечественного качества', 'uploads/prod_2908116_4.jpg', 2000, '2021-12-26 20:00:00', 100, 6, 14, 16),
(14, '2021-11-07 10:22:29', 'Санки', 'Отличные санки для спуска со снежных вершин.', 'uploads/санки.jpg', 1500, '2021-12-31 23:55:00', 100, 6, 14, 0),
(15, '2021-11-13 22:37:29', 'Лыжи Fischer', 'Топовые лыжи для горных спусков', 'uploads/fischer.jpg', 32000, '2021-12-31 19:30:00', 500, 1, 13, 0),
(16, '2021-12-09 21:46:19', 'Босоножки', 'Очень красивые! И очень дешевые.', 'uploads/shooz.jpg', 2500, '2021-12-26 00:00:00', 200, 4, 13, 17),
(17, '2021-12-14 22:44:02', 'боксерские перчатки', 'Профессиональные боксерские перчатки', 'uploads/box.jpg', 300, '2021-12-31 00:00:00', 300, 6, 19, 0),
(18, '2021-12-19 18:44:12', 'Телевизор', 'Продаю супер классный телевизор', 'uploads/DOFFLER_32DH_46-T2_.jpg', 15000, '2021-12-29 00:00:00', 500, 6, 15, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `dt_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `contacts` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `dt_create`, `email`, `name`, `password`, `contacts`) VALUES
(1, '2021-10-29 13:16:54', 'ivanov-1992@list.ru', 'Петр', '5555', 'г.Москва'),
(2, '2021-10-29 13:16:54', 'petrov1987@mail.ru', 'Петров', '123456789', 'г.Калуга'),
(3, '2021-10-29 13:16:54', 'sidorov_2001@yandex.ru', 'Сергей', '98979695', 'г.Сталинград'),
(4, '2021-10-29 13:16:54', 'fedor555@google.com', 'Федор', '788969574', 'г.Тула'),
(5, '2021-10-29 13:16:54', 'tankist1982@ya.ru', 'Александр', '19821982', 'г.Брянск'),
(6, '2021-10-29 13:16:54', 'blacksea@mail.ru', 'Анастасия', 'blacksea', 'г.Сочи'),
(13, '2021-11-05 12:13:44', 'grin-1982@list.ru', 'Григорий', '$2y$10$CLLWsGlxjQRZjjjsa30jMuPDtlnmODFmxdkGx0qssAeEo8KSS5k..', 'г.Тула, тел: 8(910)777-55-33, звонить вечером. '),
(14, '2021-11-05 12:16:24', 'grey.tula@mail.ru', 'Рудольф', '$2y$10$n2WgK8Ctv0cIW3LVXpNStur38ijOcAd2G4vyvXKUfLkC3XKhy/3cu', 'Звоните в воскресенье.'),
(15, '2021-11-07 11:49:43', 'yulen_ka-87@mail.ru', 'Юлия', '$2y$10$PcjI7a04KJaT792tOzuRF.3Oj1heYzUDTVZtFMRoX2fIDrxNNEY8q', 'Звоните в воскресенье после 9-ти вечера.'),
(16, '2021-11-27 19:47:48', 'glebush_2006@list.ru', 'Глеб', '$2y$10$pZ8PVhAkMbHPwI0HPcTZtuVyj4ZeejizLZ7Rl/Bd5KLbH5UyWrfEe', 'Глебу Григорьевичу звонить после 20.00 по выходным'),
(17, '2021-11-29 23:05:32', 'vasya@mail.ru', 'Василий', '$2y$10$GdKOVhVZxNfCmoDjDWI9TOfrdZv0PGe.zS0BSP4dp9tltzxI6iYD6', 'Звонить только в рабочее время.'),
(18, '2021-12-10 23:20:13', 'Vladik_2014@yandex.ru', 'Владик', '$2y$10$GKG.tzgJ2jTKJB4TraBq1uyjVGn4CyGbmiloODuf2cbOLjtuzj/rm', 'Привет, я Владик!'),
(19, '2021-12-14 22:40:56', 'petr@gmail.com', 'Петр', '$2y$10$xpVu8lBjASV6d9pbXMkHGe2VnFaJjP/olJAE7xB2dZ3B5n3/LCxIa', 'фaaa фааа фааа');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bets`
--
ALTER TABLE `bets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lot_id` (`lot_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date_complete` (`dt_complete`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);
ALTER TABLE `lots` ADD FULLTEXT KEY `lots_search` (`name`,`description`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bets`
--
ALTER TABLE `bets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bets`
--
ALTER TABLE `bets`
  ADD CONSTRAINT `bets_ibfk_1` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`),
  ADD CONSTRAINT `bets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `lots`
--
ALTER TABLE `lots`
  ADD CONSTRAINT `lots_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `lots_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
