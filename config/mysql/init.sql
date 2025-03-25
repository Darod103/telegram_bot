CREATE DATABASE IF NOT EXISTS telegram_bot;

USE telegram_bot;

-- Создание таблицы `user`
CREATE TABLE IF NOT EXISTS `users` (
                                       `id` INT NOT NULL AUTO_INCREMENT,
                                       `telegram_id` BIGINT UNIQUE NOT NULL,
                                       `balance` DECIMAL(20,2) NOT NULL DEFAULT 0.00,
                                       PRIMARY KEY (`id`)
);