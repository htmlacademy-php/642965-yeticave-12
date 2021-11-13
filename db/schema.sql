CREATE DATABASE yeticave_new
  DEFAULT CHARACTER SET utf8mb4;

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dt_create DATETIME DEFAULT CURRENT_TIMESTAMP,
  name VARCHAR(128) NOT NULL,
  description VARCHAR(500),
  image VARCHAR(128),
  price_start INT NOT NULL ,
  dt_complete DATETIME,
  bid_step INT NOT NULL,
  category_id INT NOT NULL,
  user_id INT NOT NULL,
  user_winner_id INT
);
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(64) NOT NULL,
  symbol VARCHAR(64) NOT NULL
);
CREATE TABLE bids (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dt_create DATETIME DEFAULT CURRENT_TIMESTAMP,
  price INT NOT NULL,
  lot_id INT NOT NULL,
  user_id INT NOT NULL
);
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dt_create DATETIME DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(64) NOT NULL,
  name VARCHAR(64) NOT NULL,
  password VARCHAR(64) NOT NULL,
  contacts TEXT NOT NULL
);
CREATE UNIQUE INDEX email ON users(email);
CREATE INDEX date_complete ON lots(dt_complete);

ALTER TABLE lots
  ADD FOREIGN KEY (user_id)
  REFERENCES users(id);

ALTER TABLE lots
  ADD FOREIGN KEY (category_id)
  REFERENCES categories(id);

ALTER TABLE bids
  ADD FOREIGN KEY (lot_id)
  REFERENCES lots(id);

ALTER TABLE bids
  ADD FOREIGN KEY (user_id)
  REFERENCES users(id);

CREATE FULLTEXT INDEX lots_search ON lots (name, description)
