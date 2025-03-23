<?php
require_once __DIR__ . '/../vendor/autoload.php';

use TelegramBot\Api\BotApi;
use App\Services\EnvServices;

try {
    $token = EnvServices::getByKey('TELEGRAM_BOT_TOKEN');
    $webhookUrl = EnvServices::getByKey('TELEGRAM_BOT_WEBHOOK_URL');

    if (!$webhookUrl || !$token) {
        throw new \Exception('.env: TELEGRAM_BOT_TOKEN или TELEGRAM_BOT_WEBHOOK_URL не заданы');
    }

    $bot = new BotApi($token);
    $bot->setWebhook($webhookUrl);

    echo "Webhook установлен успешно: $webhookUrl\n";

} catch (\TelegramBot\Api\Exception $e) {
    echo "Telegram API ошибка: " . $e->getMessage() . "\n";

} catch (\Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}