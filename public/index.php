<?php
require __DIR__ . '/../vendor/autoload.php';

use TelegramBot\Api\Client;
use App\Services\EnvServices;
use App\Core\Database;

$pdo = Database::connect();
$stmt = $pdo->query("SHOW TABLES");
$tables = $stmt->fetchAll();

var_dump($tables);



// $bot = new Client(EnvServices::getByKey('TELEGRAM_BOT_TOKEN'));

// $bot->on(function ($update) use ($bot) {
//     $message = $update->getMessage();
//     if ($message) {
//         $chatId = $message->getChat()->getId();
//         $name = $message->getFrom()->getUsername() ?? 'пользователь';
//         $bot->sendMessage($chatId, "Бот тебя слышит, ${name}!");
//     }
// }, fn () => true);

// $bot->run();