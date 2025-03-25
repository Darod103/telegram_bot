<?php

namespace App\Controller;

use App\Model\User;
use App\Services\ButtonService;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Message;

/**
 * Контроллер для обработки команды /start.
 *
 * Этот контроллер отвечает за приветственное сообщение и регистрацию нового пользователя.
 */
class StartController
{
    /**
     * Метод для обработки команды /start.
     * Выводит приветственное сообщение и информацию о регистрации.
     *
     * @param Message $message
     * @param Client $bot
     * @return void
     */
    public function handle(Message $message, Client $bot): void
    {
        $chatId = $message->getChat()->getId();
        $userId = $message->getFrom()->getId();
        $name = $message->getFrom()->getUsername() ?? 'пользователь';
        $user = new User($userId);
        if ($user->isNew()) {
            $welcome = <<<HTML
👋 <b>Привет, $name!</b>

Вы успешно зарегистрированы в системе.
Ваш текущий баланс: <b>0.00 $</b>

Для пополнения баланса просто отправьте сумму.
Например:
<code>100</code> — пополнит на 100 $
<code>-50</code> — попытается списать 50 $
HTML;
            $bot->sendMessage($chatId,$welcome, 'HTML');
            return;
        }
        $text = "👋 Привет  $name! Всё работает 👌";
        $bot->sendMessage($chatId, $text, 'HTML',false,null,ButtonService::balanceButton());
    }
}