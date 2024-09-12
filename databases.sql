CREATE DATABASE anime;
USE anime;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    profile_pic VARCHAR(255)
);
-- sql code voor account toetevoegen 
INSERT INTO users (username, password, email, profile_pic) 
VALUES ('test-user1', '1234', 'testuser1@example.com', 'uploads/Standaard-avatar-300x300.jpg');



CREATE TABLE anime (
    anime_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image_url VARCHAR(255)
);
CREATE TABLE user_anime_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    anime_id INT NOT NULL,
    status VARCHAR(50) NOT NULL,
    score INT,
    episode_watched INT,
    start_date DATE,
    finish_date DATE,
    mal_id INT,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (anime_id) REFERENCES anime(anime_id)
);