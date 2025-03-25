<?php

namespace App\Controller;
use App\Model\User;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\CallbackQuery;


class BalanceController
{
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