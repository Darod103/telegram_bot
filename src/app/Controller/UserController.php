<?php

namespace App\Controller;

use App\Model\User;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Message;

class UserController
{
    public function handle(Message $message, Client $bot): void
    {
        $chatId = $message->getChat()->getId();
        $name = $message->getFrom()->getUsername() ?? 'пользователь';

        $text = "Привет, $name! Всё работает 👌";
        $bot->sendMessage($chatId, $text);
    }
}