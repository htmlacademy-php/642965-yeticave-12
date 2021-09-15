INSERT INTO categories SET name_cat = 'Доски и лыжи', symbol = 'boards';
INSERT INTO categories SET name_cat = 'Крепления', symbol = 'attachment';
INSERT INTO categories SET name_cat = 'Ботинки', symbol = 'boots';
INSERT INTO categories SET name_cat = 'Одежда', symbol = 'clothing';
INSERT INTO categories SET name_cat = 'Инструменты', symbol = 'tools';
INSERT INTO categories SET name_cat = 'Разное', symbol = 'other';

INSERT INTO users
  SET email = 'ivanov-1992@list.ru', first_name = 'Петр', password = '5555', contacts = 'г.Москва';
INSERT INTO users
  SET email = 'petrov1987@mail.ru', first_name = 'Василий', password = '123456789', contacts = 'г.Калуга';
INSERT INTO users
  SET email = 'sidorov_2001@yandex.ru', first_name = 'Сергей', password = '98979695', contacts = 'г.Сталинград';
INSERT INTO users
  SET email = 'fedor555@google.com', first_name = 'Федор', password = '788969574', contacts = 'г.Тула';
INSERT INTO users
  SET email = 'tankist1982@ya.ru', first_name = 'Александр', password = '19821982', contacts = 'г.Брянск';
INSERT INTO users
  SET email = 'blacksea@mail.ru', first_name = 'Анастасия', password = 'blacksea', contacts = 'г.Сочи';

INSERT INTO bids SET lot_id = '1', user_id = '6', price = '11300';
INSERT INTO bids SET lot_id = '1', user_id = '5', price = '11600';
INSERT INTO bids SET lot_id = '1', user_id = '4', price = '11900';
INSERT INTO bids SET lot_id = '1', user_id = '3', price = '12200';
INSERT INTO bids SET lot_id = '2', user_id = '5', price = '161000';
INSERT INTO bids SET lot_id = '2', user_id = '6', price = '162000';
INSERT INTO bids SET lot_id = '3', user_id = '5', price = '8200';
INSERT INTO bids SET lot_id = '3', user_id = '6', price = '8400';

INSERT INTO lots
  SET category_id = '1', user_id = '1',
      name_lot = '2014 Rossignol District Snowboard',
      description = 'Очень классный сноуборд, недорого',
      image = 'img/lot-1.jpg', price_start = '10999',
      dt_complete = '2021-09-21', bid_step = '300';
INSERT INTO lots
  SET category_id = '1', user_id = '2',
      name_lot = 'DC Ply Mens 2016/2017 Snowboard',
      description = 'Лучший сноуборд 2017 года, почти новый',
      image = 'img/lot-2.jpg', price_start = '159999',
      dt_complete = '2021-09-20', bid_step = '1000';
INSERT INTO lots
  SET category_id = '2', user_id= '3',
      name_lot = 'Крепления Union Contact Pro 2015 года размер L/XL',
      description = 'Профессиональные крепления, почти даром',
      image = 'img/lot-3.jpg', price_start = '8000',
      dt_complete = '2021-09-19', bid_step = '200';
INSERT INTO lots
  SET category_id = '3', user_id = '4',
      name_lot = 'Ботинки для сноуборда DC Mutiny Charocal',
      description = 'Супер качественные ботинки, не дорого',
      image = 'img/lot-4.jpg', price_start = '10999',
      dt_complete = '2021-09-18', bid_step = '200';
INSERT INTO lots
  SET category_id = '4', user_id = '2',
      name_lot = 'Куртка DC Mutiny Charocal',
      description = 'Лучшая куртка для сноуборда, за смешные деньги',
      image = 'img/lot-5.jpg', price_start = '7500',
      dt_complete = '2021-09-17', bid_step = '100';
INSERT INTO lots
  SET category_id = '6', user_id = '3',
      name_lot = 'Маска Oakley Canopy',
      description = 'Маска на все случаи жизни, отменного качества',
      image = 'img/lot-6.jpg', price_start = '5400',
      dt_complete = '2021-09-16', bid_step = '100';
INSERT INTO lots
  SET category_id = '1', user_id = '4',
      name_lot = 'Лыжи Adidas',
      description = 'Лыжи на все случаи жизни, отменного качества',
      image = 'img/lot-7.jpg', price_start = '14200',
      dt_complete = '2021-09-16', bid_step = '300';

# Получаем все категории
SELECT name_cat FROM categories;

# получить самые новые, открытые лоты.
# Каждый лот должен включать название, стартовую цену, ссылку на изображение, название категории;
SELECT name_lot, price_start, image, name_cat, dt_complete FROM lots, categories c
  WHERE category_id = c.id AND dt_complete > NOW()
    ORDER BY dt_create DESC;

# Показать лот по его ID, название категории к которой он принадлежит и пользователя, который его создал.
SELECT l.id, name_lot, price_start, name_cat, email FROM lots l
  JOIN categories c on category_id = c.id
    JOIN users u on user_id = u.id WHERE l.id = 7;

# обновить название лота по его идентификатору.
UPDATE lots SET name_lot = 'Куртка для сноуборда DC Mutiny Charocal' WHERE id = 5;

# получить список ставок для лота по его идентификатору с сортировкой по дате.
SELECT name_lot, price, dt_add FROM bids, lots
  WHERE lot_id = lots.id AND lot_id = 1
    ORDER BY dt_add ASC;

# тоже самое с использованием JOIN.
SELECT name_lot, price, dt_add FROM lots
  JOIN bids b ON lots.id = b.lot_id WHERE lot_id = 1
    ORDER BY dt_add ASC;

# тоже самое + имя пользователя сделавшего ставку.
SELECT name_lot, price, first_name, email, dt_add FROM lots
  JOIN bids b ON lots.id = b.lot_id
    JOIN users u ON b.user_id = u.id WHERE lot_id = 1
      ORDER BY dt_add ASC;

# Список ставок пользователя по его email.
SELECT first_name, email, price, name_lot FROM bids
  JOIN users u ON u.id = bids.user_id
    JOIN lots l ON l.id = bids.lot_id  WHERE email = 'blacksea@mail.ru';
