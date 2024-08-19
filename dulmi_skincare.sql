CREATE DATABASE dulmi_skincare;
USE dulmi_skincare;

CREATE TABLE admin(
id INT(3) AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(10) UNIQUE,
email VARCHAR(50),
password VARCHAR(255) );

CREATE TABLE users(
user_Id INT(10)  AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(30) UNIQUE,
email VARCHAR(50),
password VARCHAR(225) );

CREATE TABLE category(
categoryId INT(5)  AUTO_INCREMENT PRIMARY KEY,
category VARCHAR(50) );

CREATE TABLE items(
item_ID INT(11)  AUTO_INCREMENT PRIMARY KEY,
item_name VARCHAR(50),
image_path VARCHAR(500),
quantity INT(11),
buying_price DECIMAL(10,3),
selling_price DECIMAL(10,3),
total_inventory DECIMAL(11,3),
categoryId INT(5),  
FOREIGN KEY (categoryId) REFERENCES category(categoryId),
description VARCHAR(500));

CREATE TABLE selling(
sell_ID INT(5)  AUTO_INCREMENT PRIMARY KEY,
user_Id INT(10),
FOREIGN KEY (user_Id) REFERENCES users(user_Id),
item_ID INT(11),
FOREIGN KEY (item_ID) REFERENCES items(item_ID),
quantity INT(50),
Amount DECIMAL(50,0),
Date DATETIME);
