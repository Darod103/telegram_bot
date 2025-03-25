<?php

namespace App\Controller;

use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Message;
use App\Services\Logger;

class MessageController
{
    public function handle(Message $message, Client $bot): void
    {
        Logger::info('MessageController сработал', ['text' => $message->getText()]);
        
        $chatId = $message->getChat()->getId();
        $text = str_replace(' ','',$message->getText());
        
        if (is_numeric(str_replace(',', '.', $text))) {
            $bot->sendMessage($chatId, "Вы ввели число: $text");
        } else {
            $bot->sendMessage($chatId, "Вы ввели текст: $text");
        }
    }
}