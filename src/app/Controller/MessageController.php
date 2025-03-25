<?php

namespace App\Controller;

use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Message;
use App\Model\User;

class MessageController
{
    //максимальная сумма пополнения
    private const MAX_AMOUNT = '1000000000';


    public function handle(Message $message, Client $bot): void
    {

        $chatId = $message->getChat()->getId();
        $userId = $message->getFrom()->getId();


        $text = str_replace([' ', ','], ['', '.'], $message->getText());

        $user = new User($userId);

        if (is_numeric($text)) {
            $amount = floatval($text);
            
            if ($amount > self::MAX_AMOUNT || $amount == 0) {
                $bot->sendMessage(
                    $chatId,
                    "❌ <b>Ошибка:</b>\n\nСумма пополнения должна быть больше 0 и меньше " . number_format(self::MAX_AMOUNT, 2, '.', ' ') . " $",
                    'HTML'
                );
                return;
            }
            if ($user->updateBalance($amount)) {
                if ($amount >= 0) {
                    $bot->sendMessage(
                        $chatId,
                        "✅ Ваш баланс пополнен на: <b>" . number_format($amount, 2, '.', ' ') . " $</b>\n💰 Текущий баланс: <b>" . number_format($user->getBalance(), 2, '.', ' ') . " $</b>",
                        'HTML'
                    );
                } else {
                    $bot->sendMessage(
                        $chatId,
                        "С вашего счета списано: <b>" . number_format(abs($amount), 2, '.', ' ') . " $</b>\n💰 Текущий баланс: <b>" . number_format($user->getBalance(), 2, '.', ' ') . " $</b>",
                        'HTML'
                    );
                }
            } else {
                $bot->sendMessage(
                    $chatId,
                    "❌ <b>Ошибка:</b>\nНедостаточно средств для списания <b>" . number_format(abs($amount), 2, '.', ' ') . " $</b>\n💰 Текущий баланс: <b>" . number_format($user->getBalance(), 2, '.', ' ') . " $</b>",
                    'HTML'
                );
            }
        } else {
            $bot->sendMessage(
                $chatId,
                "🤔 <b>Ой, кажется, я запутался!</b>\n\nВы написали: <code>" . htmlspecialchars($message->getText()) . "</code>\n\nЯ понимаю только числа.\nПожалуйста, отправьте  <b>число</b> или ➖ <b>отрицательное число</b>. 😊",
                'HTML'
            );
        }
    }
}