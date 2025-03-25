<?php

namespace App\Controller;

use App\Model\User;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\CallbackQuery;

/**
 * Контроллер для обработки запроса на получение баланса пользователя.
 *
 * Этот контроллер отвечает за отображение текущего баланса пользователя в ответ на нажатие кнопки.
 */
class BalanceController
{
    /**
     * Метод для обработки запроса на получение баланса.
     * Выводит текущий баланс пользователя в ответ на нажатие кнопки.
     *
     * @param CallbackQuery $query
     * @param Client $bot
     * @return void
     */
    public function show(CallbackQuery $query, Client $bot): void
    {
        $chatId = $query->getMessage()->getChat()->getId();
        $userId = $query->getFrom()->getId();
        $user = new User($userId);
        $balance = number_format($user->getBalance(), 2, '.', ' ');

        $text = "💼 Ваш баланс: <b>{$balance} $</b>";
        $bot->answerCallbackQuery($query->getId());
        $bot->sendMessage($chatId, $text, 'HTML');
    }

}