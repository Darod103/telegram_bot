<?php

namespace App\Router;

use App\Services\Logger;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Update;


/**
 * Class Router
 *
 * Класс маршрутизации для обработки входящих команд от Telegram.
 *
 * @package App\Router
 */
class Router
{
    private Client $bot;
    private array $commands = [];
    private ?array $fallback = null;

    public function __construct(Client $bot)
    {
        $this->bot = $bot;
    }

    /**
     * Регистрация команды.
     * @param string $name
     * @param array $handler
     * @return void
     */
    public function command(string $name, array $handler): void
    {
        $this->commands[ltrim($name, '/')] = $handler;
    }

    /**
     * Обработчик на любое сообщение, если команды не сработали.
     * @param array $handler
     * @return void
     */
    public function fallback(array $handler): void
    {
        $this->fallback = $handler;
    }

    /**
     * Запуск маршрутизатора.
     * @return void
     */
    public function run(): void
    {
        foreach ($this->commands as $command => $handler) {
            $this->bot->command($command, function (Update $update) use ($handler) {
                $this->invoke($handler, $update);
            });
        }

        if ($this->fallback) {
            $this->bot->on(function (Update $update) {
                $this->invoke($this->fallback, $update);
            }, fn() => true);
        }
    }

    /**
     * Вызов метода контроллера.
     * @param array $handler
     * @param Update $update
     * @return void
     */
    private function invoke(array $handler, Update $update): void
    {
        [$class, $method] = $handler;
        $instance = new $class();
        if (method_exists($instance, $method)) {
            $instance->$method($update, $this->bot);
        } else {
            Logger::error("Метод $method не найден в классе $class", [
                'class' => $class,
                'method' => $method
            ]);
        }
    }
}