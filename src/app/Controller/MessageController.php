<?php

namespace App\Controller;
use App\Model\User;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Message;

/**
 * Class MessageController
 *
 * Контроллер для обработки сообщений.
 */
class MessageController
{
    public function handel(Message $message, Client $bot):void
    {
        $text = trim($message->getText());
        $chatId = $message->getChat()->getId();
        if(is_numeric(str_replace(',','.',$text))){
            $bot->sendMessage($chatId, "Вы ввели число: $text");
        }else{
            $bot->sendMessage($chatId, "Вы ввели текст: $text");
        }
    }
}