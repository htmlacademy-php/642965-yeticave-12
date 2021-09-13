CREATE DATABASE yeticave_12
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dt_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name_lot CHAR(128) NOT NULL,
  description CHAR(255),
  image CHAR(128),
  price_start INT NOT NULL ,
  dt_complete TIMESTAMP,
  bid_step INT NOT NULL,
  category_id INT,
  user_id INT,
  bid_id INT
);
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name_cat CHAR(64) NOT NULL,
  symbol CHAR(64) NOT NULL
);
CREATE TABLE bids (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  price INT NOT NULL,
  lot_id INT,
  user_id INT
);
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dt_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email CHAR(64) NOT NULL,
  first_name CHAR(64) NOT NULL,
  password CHAR(64) NOT NULL,
  contacts TEXT NOT NULL
);
CREATE UNIQUE INDEX email ON users(email);
