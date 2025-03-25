<?php

namespace App\Services;

use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

/*
 * Класс ButtonService
 *
 * Этот класс отвечает за создание кнопок для Telegram-бота.
 */

class ButtonService
{
    public static function balanceButton(): inLineKeyboardMarkup
    {
        return new InlineKeyboardMarkup([
            [
                ['text' => '💰 Мой баланс', 'callback_data' => 'show_balance'],
            ]
        ]);
    }
    public static function linkButton(): InlineKeyboardMarkup
    {
        return new InlineKeyboardMarkup([
            [
                ['text' => '🐙 Мой GitHub', 'url' => 'https://github.com/Darod103'],
                ['text' => '✈️ Мой Telegram', 'url' => 'https://t.me/Darod103'],
            ]
        ]);
    }

}