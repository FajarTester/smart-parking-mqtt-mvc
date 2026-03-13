
CREATE DATABASE smart_parkir;

USE smart_parkir;

CREATE TABLE user (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50),
password VARCHAR(50)
);

INSERT INTO user(username,password) VALUES ('admin','12345678');

CREATE TABLE    parkir (
id INT AUTO_INCREMENT PRIMARY KEY,
rfid VARCHAR(50),
waktu_masuk DATETIME,
waktu_keluar DATETIME,
status ENUM('IN', 'OUT', 'DONE') NOT NULL
);
