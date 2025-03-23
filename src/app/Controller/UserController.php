<?php

namespace App\Controller;

use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Update;

/**
 * Class UserController
 *
 * Контроллер для обработки команд пользователей.
 *
 * @package App\Controller
 */
class UserController
{
    public function handle(Update $update, Client $bot):void
    {
        $chatId = $update->getMessage()->getChat()->getId();
        $userName = $update->getMessage()->getFrom()->getUsername();
        $text = "👋 Привет, $userName!\nЭто тестовый контроллер.\nБот работает!";
        $bot->sendMessage($chatId, $text);
    }

}