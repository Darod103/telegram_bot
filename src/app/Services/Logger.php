<?php

namespace App\Services;

/**
 * Class Logger
 *
 * Сервис логирования ошибок и сообщений в файл.
 */
class Logger
{

    private static string $logFilePath = __DIR__ . '/../../../logs/app.log';
    
    /**
     * Логирует сообщение об ошибке.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function error(string $message, array $context = []): void
    {
        self::writeLog('ERROR', $message, $context);
    }

    /**
     * Логирует сообщение об информации.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function info(string $message, array $context = []): void
    {
        self::writeLog('INFO', $message, $context);
    }

    /**
     * Записывает сообщение в лог-файл.
     *
     * @param string $level
     * @param string $message
     * @param array $context
     * @return void
     */
    private static function writeLog(string $level, string $message, array $context = []): void
    {
        $logDir = dirname(self::$logFilePath);

        if (!is_dir($logDir)) {
            mkdir($logDir, 0775, true);
        }

        $time = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? json_encode($context, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : '';

        $logMessage = "[$time][$level] $message" . ($contextStr ? "\n$contextStr" : '') . "\n\n";

        file_put_contents(self::$logFilePath, $logMessage, FILE_APPEND);
    }

}