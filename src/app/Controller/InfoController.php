<?php

namespace App\Controller;

use App\Services\ButtonService;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Message;


/**
 * Контроллер для обработки команды /info.
 *
 */
class InfoController
{
    /**
     * Метод для обработки команды /info.
     *Выводит информацию о боте и его технологиях.
     * @return void
     */
    public function handle(Message $message, Client $bot): void
    {
        $chatId = $message->getChat()->getId();
        $userName = $message->getFrom()->getUsername() ?? 'пользователь';

        $text = <<<HTML
👋 <b>Привет, $userName!</b>

Этот бот был создан как <b>тестовый проект</b> для демонстрации возможностей Telegram Bot API с использованием стека <b>PHP</b> и Docker.

🛠️ <b>Технологии:</b>
• Язык: <code>PHP</code>
• База данных: <code>MySQL</code>
• Веб-сервер: <code>NGINX</code>
• Контейнеризация: <code>Docker</code>
• SSL-сертификат: <code>Let's Encrypt</code> через <code>Certbot</code>

💡 Этот проект показывает, как можно легко обрабатывать команды, текстовые сообщения и кнопки внутри Telegram-бота.

Благодарю за использование! 🚀
HTML;

        $bot->sendMessage($chatId, $text, 'HTML',false,null,ButtonService::linkButton());
    }
}