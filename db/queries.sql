INSERT INTO categories SET name = 'Доски и лыжи', symbol = 'boards';
INSERT INTO categories SET name = 'Крепления', symbol = 'attachment';
INSERT INTO categories SET name = 'Ботинки', symbol = 'boots';
INSERT INTO categories SET name = 'Одежда', symbol = 'clothing';
INSERT INTO categories SET name = 'Инструменты', symbol = 'tools';
INSERT INTO categories SET name = 'Разное', symbol = 'other';

INSERT INTO users
SET email = 'ivanov-1992@list.ru', name = 'Петр', password = '5555', contacts = 'г.Москва';
INSERT INTO users
SET email = 'petrov1987@mail.ru', name = 'Василий', password = '123456789', contacts = 'г.Калуга';
INSERT INTO users
SET email = 'sidorov_2001@yandex.ru', name = 'Сергей', password = '98979695', contacts = 'г.Сталинград';
INSERT INTO users
SET email = 'fedor555@google.com', name = 'Федор', password = '788969574', contacts = 'г.Тула';
INSERT INTO users
SET email = 'tankist1982@ya.ru', name = 'Александр', password = '19821982', contacts = 'г.Брянск';
INSERT INTO users
SET email = 'blacksea@mail.ru', name = 'Анастасия', password = 'blacksea', contacts = 'г.Сочи';

INSERT INTO bets SET lot_id = '1', user_id = '6', price = '11300';
INSERT INTO bets SET lot_id = '1', user_id = '5', price = '11600';
INSERT INTO bets SET lot_id = '1', user_id = '4', price = '11900';
INSERT INTO bets SET lot_id = '1', user_id = '3', price = '12200';
INSERT INTO bets SET lot_id = '2', user_id = '5', price = '161000';
INSERT INTO bets SET lot_id = '2', user_id = '6', price = '162000';
INSERT INTO bets SET lot_id = '3', user_id = '5', price = '8200';
INSERT INTO bets SET lot_id = '3', user_id = '6', price = '8400';

INSERT INTO lots
SET category_id = '1', user_id = '1',
    name = '2014 Rossignol District Snowboard',
    description = 'Очень классный сноуборд, недорого',
    image = 'img/lot-1.jpg', price_start = '10999',
    dt_complete = '2021-09-21', bid_step = '300';
INSERT INTO lots
SET category_id = '1', user_id = '2',
    name = 'DC Ply Mens 2016/2017 Snowboard',
    description = 'Лучший сноуборд 2017 года, почти новый',
    image = 'img/lot-2.jpg', price_start = '159999',
    dt_complete = '2021-09-20', bid_step = '1000';
INSERT INTO lots
SET category_id = '2', user_id= '3',
    name = 'Крепления Union Contact Pro 2015 года размер L/XL',
    description = 'Профессиональные крепления, почти даром',
    image = 'img/lot-3.jpg', price_start = '8000',
    dt_complete = '2021-09-19', bid_step = '200';
INSERT INTO lots
SET category_id = '3', user_id = '4',
    name = 'Ботинки для сноуборда DC Mutiny Charocal',
    description = 'Супер качественные ботинки, не дорого',
    image = 'img/lot-4.jpg', price_start = '10999',
    dt_complete = '2021-09-18', bid_step = '200';
INSERT INTO lots
SET category_id = '4', user_id = '2',
    name = 'Куртка DC Mutiny Charocal',
    description = 'Лучшая куртка для сноуборда, за смешные деньги',
    image = 'img/lot-5.jpg', price_start = '7500',
    dt_complete = '2021-09-17', bid_step = '100';
INSERT INTO lots
SET category_id = '6', user_id = '3',
    name = 'Маска Oakley Canopy',
    description = 'Маска на все случаи жизни, отменного качества',
    image = 'img/lot-6.jpg', price_start = '5400',
    dt_complete = '2021-09-16', bid_step = '100';
INSERT INTO lots
SET category_id = '1', user_id = '4',
    name = 'Лыжи Adidas',
    description = 'Лыжи на все случаи жизни, отменного качества',
    image = 'img/lot-7.jpg', price_start = '14200',
    dt_complete = '2021-09-16', bid_step = '300';

# Получаем все категории
SELECT name FROM categories;

# получить самые новые, открытые лоты.
# Каждый лот должен включать название, стартовую цену, ссылку на изображение, название категории;
SELECT l.name, price_start, image, c.name, dt_complete
FROM lots l, categories c WHERE category_id = c.id AND dt_complete > NOW()
ORDER BY dt_create DESC;

# Показать лот по его ID, название категории к которой он принадлежит и пользователя, который его создал.
SELECT l.id, l.name, price_start, c.name, email
FROM lots l JOIN categories c ON category_id = c.id
JOIN users u ON user_id = u.id WHERE l.id = 7;

# обновить название лота по его идентификатору.
UPDATE lots SET name = 'Куртка для сноуборда DC Mutiny Charocal' WHERE id = 5;

# получить список ставок для лота по его идентификатору с сортировкой по дате.
SELECT l.name, price, b.dt_create
FROM bets b, lots l WHERE lot_id = l.id AND lot_id = 1
ORDER BY b.dt_create ASC;

# тоже самое с использованием JOIN.
SELECT l.name, price, b.dt_create
FROM lots l JOIN bets b ON l.id = b.lot_id
WHERE lot_id = 1 ORDER BY b.dt_create ASC;

# тоже самое + имя пользователя сделавшего ставку.
SELECT l.name AS lot_name, price, u.name AS user_name, email, b.dt_create AS bet_date_create
FROM lots l JOIN bets b ON l.id = b.lot_id
JOIN users u ON b.user_id = u.id
WHERE l.id = 1 ORDER BY b.dt_create ASC;

# Список ставок пользователя по его email.
SELECT u.name, email, price, l.name
FROM bets b JOIN users u ON u.id = b.user_id
JOIN lots l ON l.id = b.lot_id  WHERE email = 'blacksea@mail.ru';

# Покажет только тех пользователей, которые делали ставки и их колличество.
SELECT u.name, email, COUNT(b.id) bets_total
FROM users u JOIN bets b ON u.id = b.user_id
GROUP BY email ORDER BY bets_total DESC;

# Список лотов пользователя
SELECT u.name, email, l.name
FROM users u JOIN lots l ON u.id = l.user_id
ORDER BY u.name ASC;

# Покажет только тех пользователей, которые создали лот и колличество лотов ими созданных.
SELECT u.name, email, COUNT(l.id) lot_total
FROM users u JOIN lots l ON u.id = l.user_id
GROUP BY email ORDER BY lot_total DESC;

# Поиск в таблице лот по полям название лота и описание
SELECT * FROM lots WHERE MATCH(name, description) AGAINST ('лыжи палки');

# Запрос по определению победителей в отыгравших лотах ??? ОШИБКА в запросе
SELECT l.id, MAX(b.user_id) AS user, MAX(b.price) AS last_bet_price
FROM lots l JOIN bets b ON b.lot_id = l.id WHERE dt_complete <= NOW()
GROUP BY l.id ORDER BY l.id;

# Запрос по определению победителя в одном лоте
SELECT u.id, u.email, b.lot_id, MAX(b.id) AS last_bet_id, MAX(b.price) AS last_bet_price
FROM users u LEFT JOIN bets b ON b.user_id = u.id WHERE b.lot_id = 15
GROUP BY u.id ORDER BY last_bet_id DESC LIMIT 1;

#----------------------------------------------------------------------------------------
SELECT l.id, l.image, l.name AS lot_name, l.description, c.name AS cat_name, l.dt_complete, user_winner_id, MAX(b.price) AS maxPrice, MAX(b.dt_create) AS dtCreate, u.name, u.contacts
FROM lots l JOIN categories c ON l.category_id = c.id
JOIN bets b ON b.lot_id = l.id JOIN users u ON u.id = b.user_id WHERE b.user_id = 16
GROUP BY l.id, u.id ORDER BY dtCreate DESC;
