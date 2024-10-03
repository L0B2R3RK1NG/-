CREATE DATABASE anime;
USE anime;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    profile_pic VARCHAR(255)
);







CREATE TABLE user_anime_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    status VARCHAR(50) NOT NULL,
    score INT,
    episodes_watched INT,
    start_date DATE,
    finish_date DATE,
    mal_id INT
);