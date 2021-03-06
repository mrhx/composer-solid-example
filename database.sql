-- Users
CREATE TABLE IF NOT EXISTS `user` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `created` DATETIME NOT NULL,
    `updated` DATETIME,
    `name` VARCHAR(20) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `country` CHAR(2) NOT NULL,
    `timezone` VARCHAR(100) NOT NULL
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
