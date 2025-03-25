<?php

namespace App\Router;

use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Update;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\CallbackQuery;
use App\Services\Logger;

/**
 * Class Router
 *
 * Маршрутизатор Telegram-команд .
 */
class Router
{
    protected Client $bot;

    public function __construct(Client $bot)
    {
        $this->bot = $bot;
    }

    /**
     * Регистрация команды.
     */
    public function command(string $name, callable|array $handler): void
    {
        $this->bot->command($name, function (Message $message) use ($handler, $name) {
            $this->invoke($handler, $message);
        });
    }

    /**
     * Обработка любого текстового сообщения (не команды).
     */
    public function text(callable|array $handler): void
    {
        $this->bot->on(function (Update $update) use ($handler) {
            $message = $update->getMessage();
            $this->invoke($handler, $message);
        }, fn(Update $update) => $update->getMessage()?->getText() !== null);
    }

    /**
     * Обработка callback-кнопок.
     */
    public function callback(callable|array $handler): void
    {
        $this->bot->callbackQuery(function (CallbackQuery $callbackQuery) use ($handler) {
            $this->invoke($handler, $callbackQuery);
        });
    }

    /**
     * Вызов обработчика.
     */
    protected function invoke(callable|array $handler, Message|CallbackQuery $entity): void
    {
        try {
            if (is_array($handler)) {
                [$class, $method] = $handler;
                $instance = is_string($class) ? new $class() : $class;
                $instance->$method($entity, $this->bot);
            } else {
                $handler($entity, $this->bot);
            }
        } catch (\Throwable $e) {
            Logger::error("Ошибка обработки запроса", [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Запуск роутера.
     */
    public function run(): void
    {
        $this->bot->run();
    }
}