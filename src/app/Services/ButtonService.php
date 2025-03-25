<?php

namespace App\Services;

use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
class ButtonService
{
    public static function balanceButton():inLineKeyboardMarkup
    {
        return new InlineKeyboardMarkup([
            [
                ['text' => '💰 Мой баланс', 'callback_data' => 'show_balance'],
            ]
        ]);
    }

}