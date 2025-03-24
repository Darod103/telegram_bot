<?php

namespace App\Router;

use App\Services\Logger;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Message;

/**
 * Class Router
 *
 * Упрощённый маршрутизатор Telegram-команд.
 */
class Router
{
    private Client $bot;
    private array $commands = [];
    private ?array $onText = null;

    public function __construct(Client $bot)
    {
        $this->bot = $bot;
    }

    /**
     * Регистрирует команду.
     *
     * @param string $name
     * @param array $handler [ControllerClass, method]
     */
    public function command(string $name, array $handler): void
    {
        $this->commands[ltrim($name, '/')] = $handler;
    }

    /**
     * Обработчик для  (любой текст).
     *
     * @param array $handler
     */
    public function onText(array $handler): void
    {
        $this->onText = $handler;
    }

    /**
     * Запуск обработчиков.
     */
    public function run(): void
    {
        foreach ($this->commands as $command => $handler) {
            $this->bot->command($command, function (Message $message) use ($handler, $command) {
                $this->invoke($handler, $message);
            });
        }

        if ($this->onText) {
            $this->bot->on(function (Message $message) {
                $this->invoke($this->onText, $message);
            }, fn () => true);
        }
        $this->bot->run();
    }

    /**
     * Вызов контроллера.
     */
    private function invoke(array $handler, Message $message): void
    {
        [$class, $method] = $handler;
        $controller = new $class();

        if (method_exists($controller, $method)) {
            $controller->$method($message, $this->bot);
        } else {
            Logger::error("Метод $method не найден в $class");
        }
    }
}