CREATE DATABASE dulmi_skincare;
USE dulmi_skincare;

CREATE TABLE admin(
id INT(3) PRIMARY KEY,
username VARCHAR(10),
email VARCHAR(50),
password VARCHAR(255) );

CREATE TABLE users(
id INT(50) PRIMARY KEY,
username VARCHAR(10),
email VARCHAR(50),
password VARCHAR(225) );

CREATE TABLE category(
categoryId INT(5) PRIMARY KEY,
category VARCHAR(50) );

CREATE TABLE items(
item_ID INT(11) PRIMARY KEY,
item_name VARCHAR(50),
image_path VARCHAR(500),
quantity INT(11),
price DECIMAL(11,3),
categoryId INT(11),  
FOREIGN KEY (categoryId) REFERENCES category(categoryId),
description VARCHAR(500));
