CREATE DATABASE song_recommendation_database;

CREATE TABLE `song_recommendation_database`.`users` ( 
    `id` INT NOT NULL AUTO_INCREMENT, 
    `username` VARCHAR(50) NOT NULL, 
    `email` VARCHAR(100) NOT NULL, 
    `password` VARCHAR(255) NOT NULL, 
    `role` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `song_recommendation_database`.`songs` ( 
    `id` INT NOT NULL, 
    `title` VARCHAR(255) NOT NULL, 
    `summary` VARCHAR(1000) NOT NULL, 
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO `song_recommendation_database`.`users` (`username`, `email`, `password`, `role`) VALUES ('a', '1463855272@qq.com', '$2y$10$z7nXkEABKtjHbjvFG3TDo.qj7M9jw0CzWRuHC8xyvztg1FbYnblXC', 2);

CREATE USER 'movieadmin' IDENTIFIED BY 'secretpassword';
GRANT INSERT, SELECT ON `song_recommendation_database`.* TO 'movieadmin' WITH GRANT OPTION;
GRANT SUPER ON *.* TO 'movieadmin';
