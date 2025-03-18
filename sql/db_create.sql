-- SQLBook: Code
CREATE DATABASE IF NOT EXISTS `TP2LPBDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `TP2LPBDB`;

CREATE TABLE IF NOT EXISTS `Personnes` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `first_name` varchar(50) NOT NULL,
    `last_name` varchar(50) NOT NULL,
    `gender` ENUM('M', 'F'),
    `birth_date` DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS `Mariages` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `id_personne1` int NOT NULL,
    `id_personne2` int NOT NULL,
    `mariage_date` DATE NOT NULL,
    `divorce_date` DATE,
    `divorce_reason` varchar(255),
    UNIQUE (id_personne1, id_personne2)
);

ALTER TABLE `Mariages`
ADD FOREIGN KEY (`id_personne1`) REFERENCES `Personnes` (`id`);

ALTER TABLE `Mariages`
ADD FOREIGN KEY (`id_personne2`) REFERENCES `Personnes` (`id`);

SET NAMES 'utf8mb4' COLLATE 'utf8mb4_general_ci'