<?php
require __DIR__ . '/../vendor/autoload.php';

use TelegramBot\Api\Client;
use App\Services\EnvServices;

// // Логируем тело POST-запроса от Telegram
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $raw = file_get_contents('php://input');

//     // Создаем папку logs, если её нет
//     $logDir = __DIR__ . '/../logs';
//     if (!is_dir($logDir)) {
//         mkdir($logDir, 0777, true);
//     }

//     // Записываем в файл
//     file_put_contents($logDir . '/post.log', "---\n" . $raw . "\n", FILE_APPEND);
// }

$bot = new Client(EnvServices::getByKey('TELEGRAM_BOT_TOKEN'));

$bot->on(function ($update) use ($bot) {
    $message = $update->getMessage();
    if ($message) {
        $chatId = $message->getChat()->getId();
        $name = $message->getFrom()->getUsername() ?? 'пользователь';
        $bot->sendMessage($chatId, "Бот тебя слышит, ${name}!");
    }
}, fn () => true);

$bot->run();