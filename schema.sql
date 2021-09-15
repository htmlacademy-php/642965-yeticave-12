CREATE DATABASE yeticave_12
  DEFAULT CHARACTER SET utf8mb4;

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dt_create DATETIME DEFAULT CURRENT_TIMESTAMP,
  name_lot VARCHAR(128) NOT NULL,
  description VARCHAR(255),
  image VARCHAR(128),
  price_start INT NOT NULL ,
  dt_complete DATETIME,
  bid_step INT NOT NULL,
  category_id INT,
  user_id INT,
  user_winner_id INT
);
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name_cat VARCHAR(64) NOT NULL,
  symbol VARCHAR(64) NOT NULL
);
CREATE TABLE bids (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dt_add DATETIME DEFAULT CURRENT_TIMESTAMP,
  price INT NOT NULL,
  lot_id INT,
  user_id INT
);
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dt_registration DATETIME DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(64) NOT NULL,
  first_name VARCHAR(64) NOT NULL,
  password VARCHAR(64) NOT NULL,
  contacts TEXT NOT NULL
);
CREATE UNIQUE INDEX email ON users(email);
CREATE INDEX date_complete ON lots(dt_complete);
