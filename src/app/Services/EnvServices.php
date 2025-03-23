<?php

namespace App\Services;
/**
 * Class EnvService
 *
 * Сервис для работы с переменными окружения, загружаемыми из файла .env.
 */
class EnvServices
{

    /**
     * Массив загруженных переменных окружения.
     *
     * @var array|null
     */
    private static ?array $env = null;

    /**
     * Метод загружает переменные из .env в массив $env.
     * Метод игнорирует пустые строки, пробелы и комментарии.
     * @return void
     */
    private static function load(): void
    {
        if (self::$env !== null) {
            return;
        }

        $filePath = dirname(__DIR__, 3) . '/.env';


        if (!file_exists($filePath)) {
            self::$env = [];
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $env = [];

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);

            if (str_contains($value, '#')) {
                $value = substr($value, 0, strpos($value, '#'));
            }

            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");

            $env[$key] = $value;

        }

        self::$env = $env;
    }

    /**
     * Получает значение переменной окружения по её ключу.
     *
     * @param string $key Ключ переменной окружения.
     *
     * @return string|bool Возвращает значение переменной или false, если ключ не найден.
     */
    public static function getByKey(string $key): string|false
    {
        self::load();
        return self::$env[$key] ?? false;
    }

    /**
     * Возвращает весь массив загруженных переменных окружения.
     *
     * @return array|bool Возвращает массив переменных окружения или false, если файл .env не найден.
     */
    public static function getAll(): array|false
    {
        self::load();
        return self::$env ?? false;
    }
}