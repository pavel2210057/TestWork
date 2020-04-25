CREATE DATABASE test;
USE test;
CREATE TABLE users(
                      id INTEGER AUTO_INCREMENT PRIMARY KEY,
                      name TEXT NOT NULL,
                      surname TEXT NOT NULL,
                      mail VARCHAR(64) NOT NULL UNIQUE,
                      pass TEXT NOT NULL,
                      avatar_url TEXT
);