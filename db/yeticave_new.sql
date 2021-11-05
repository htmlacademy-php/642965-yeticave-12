-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 05 2021 г., 15:53
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
-- Структура таблицы `bids`
--

CREATE TABLE `bids` (
  `id` int(11) NOT NULL,
  `dt_create` datetime DEFAULT CURRENT_TIMESTAMP,
  `price` int(11) NOT NULL,
  `lot_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `bids`
--

INSERT INTO `bids` (`id`, `dt_create`, `price`, `lot_id`, `user_id`) VALUES
(2, '2021-10-29 13:21:10', 11300, 1, 6),
(3, '2021-10-29 13:21:10', 11600, 1, 5),
(4, '2021-10-29 13:21:10', 11900, 1, 4),
(5, '2021-10-29 13:21:10', 12200, 1, 3),
(6, '2021-10-29 13:21:10', 161000, 2, 5),
(7, '2021-10-29 13:21:10', 162000, 2, 6),
(8, '2021-10-29 13:21:10', 8200, 3, 5),
(9, '2021-10-29 13:21:10', 8400, 3, 6);

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
  `user_winner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `lots`
--

INSERT INTO `lots` (`id`, `dt_create`, `name`, `description`, `image`, `price_start`, `dt_complete`, `bid_step`, `category_id`, `user_id`, `user_winner_id`) VALUES
(1, '2021-10-29 13:19:11', '2014 Rossignol District Snowboard', 'Очень классный сноуборд, недорого', 'img/lot-1.jpg', 10999, '2021-11-10 00:00:00', 300, 1, 1, NULL),
(2, '2021-10-29 13:20:07', 'DC Ply Mens 2016/2017 Snowboard', 'Лучший сноуборд 2017 года, почти новый', 'img/lot-2.jpg', 159999, '2021-11-07 00:00:00', 1000, 1, 2, NULL),
(3, '2021-10-29 13:20:07', 'Крепления Union Contact Pro 2015 года размер L/XL', 'Профессиональные крепления, почти даром', 'img/lot-3.jpg', 8000, '2021-11-09 00:00:00', 200, 2, 3, NULL),
(4, '2021-10-29 13:20:07', 'Ботинки для сноуборда DC Mutiny Charocal', 'Супер качественные ботинки, не дорого', 'img/lot-4.jpg', 10999, '2021-11-08 00:00:00', 200, 3, 4, NULL),
(5, '2021-10-29 13:20:07', 'Куртка для сноуборда DC Mutiny Charocal', 'Лучшая куртка для сноуборда, за смешные деньги', 'img/lot-5.jpg', 7500, '2021-11-08 00:00:00', 100, 4, 2, NULL),
(6, '2021-10-29 13:20:07', 'Маска Oakley Canopy', 'Маска на все случаи жизни, отменного качества', 'img/lot-6.jpg', 5400, '2021-11-07 00:00:00', 100, 6, 3, NULL),
(7, '2021-10-29 13:20:07', 'Лыжи Adidas', 'Лыжи на все случаи жизни, отменного качества', 'img/lot-7.jpg', 14200, '2021-11-09 00:00:00', 300, 1, 4, NULL),
(12, '2021-11-05 12:15:03', 'Шапка ушанка', 'Отличная шапка для занятий зимними видами спорта. ', 'uploads/шапка.jpg', 3500, '2021-11-15 00:00:00', 300, 4, 13, NULL),
(13, '2021-11-05 12:18:13', 'Лыжные палки', 'Лыжные палки отличного отечественного качества', 'uploads/prod_2908116_4.jpg', 2000, '2021-11-15 00:00:00', 100, 6, 14, NULL);

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
(2, '2021-10-29 13:16:54', 'petrov1987@mail.ru', 'Василий', '123456789', 'г.Калуга'),
(3, '2021-10-29 13:16:54', 'sidorov_2001@yandex.ru', 'Сергей', '98979695', 'г.Сталинград'),
(4, '2021-10-29 13:16:54', 'fedor555@google.com', 'Федор', '788969574', 'г.Тула'),
(5, '2021-10-29 13:16:54', 'tankist1982@ya.ru', 'Александр', '19821982', 'г.Брянск'),
(6, '2021-10-29 13:16:54', 'blacksea@mail.ru', 'Анастасия', 'blacksea', 'г.Сочи'),
(13, '2021-11-05 12:13:44', 'grin-1982@list.ru', 'Григорий', '$2y$10$CLLWsGlxjQRZjjjsa30jMuPDtlnmODFmxdkGx0qssAeEo8KSS5k..', 'Позвоните по телефону, вечером.'),
(14, '2021-11-05 12:16:24', 'grey.tula@mail.ru', 'Рудольф', '$2y$10$n2WgK8Ctv0cIW3LVXpNStur38ijOcAd2G4vyvXKUfLkC3XKhy/3cu', 'Звоните в воскресенье.');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bids`
--
ALTER TABLE `bids`
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
-- AUTO_INCREMENT для таблицы `bids`
--
ALTER TABLE `bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`),
  ADD CONSTRAINT `bids_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
