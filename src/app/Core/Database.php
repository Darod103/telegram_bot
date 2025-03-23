<?php

namespace App\Core;

use App\Services\Logger;
use PDO;
use App\Services\EnvServices;
use PDOException;

/**
 * Class DbConnectionService
 *
 * Сервис для установки соединения с базой данных MySQL,
 * используя параметры из .env-файла.
 *
 * @package App\Services
 */
class Database
{
    private static ?PDO $pdo = null;

    /**
     * Получает PDO-соединение. Создаёт его, если не создано.
     * Использует параметры из .env-файла.
     * @return PDO
     */
    public static function connect(): PDO
    {
        if (self::$pdo === null) {
            $host = EnvServices::getByKey('DB_HOST');
            $db = EnvServices::getByKey('DB_NAME');
            $user = EnvServices::getByKey('DB_USER');
            $pass = EnvServices::getByKey('DB_PASSWORD');
            $charset = 'utf8mb4';

            // Проверяем, что все необходимые переменные окружения установлены
            if (!$host || !$db || !$user || $pass === false) {
                Logger::error('Отсутствуют переменные окружения для подключения к БД', [
                    'DB_HOST' => $host,
                    'DB_NAME' => $db,
                    'MYSQL_USER' => $user,
                    'MYSQL_PASSWORD' => $pass
                ]);
                throw new \RuntimeException("Ошибка конфигурации подключения к БД");
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                Logger::error('Ошибка подключения к базе данных: ' . $e->getMessage(), [
                    'dsn' => $dsn,
                    'user' => $user
                ]);
                throw new \RuntimeException("Ошибка подключения к базе данных");
            }
        }

        return self::$pdo;
    }

    /**
     * Закрывает текущее соединение с базой данных (обнуляет PDO).
     *
     * @return void
     */
    public static function closeConnection(): void
    {
        self::$pdo = null;
    }
}