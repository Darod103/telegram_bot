<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Controller\BalanceController;
use App\Controller\InfoController;
use TelegramBot\Api\Client;
use App\Router\Router;
use App\Controller\StartController;
use App\Controller\MessageController;
use App\Services\EnvServices;
use App\Services\Logger;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Location: '.EnvServices::getByKey('TELEGRAM_BOT_LINK'), true, 302);
    exit;
}

try {
    
    $bot = new Client(EnvServices::getByKey('TELEGRAM_BOT_TOKEN'));

   
    $router = new Router($bot);

    
    $router->command('start', [StartController::class, 'handle']);
    $router->text([MessageController::class, 'handle']);
    $router->command('info', [InfoController::class, 'handle']);
    $router->callback([BalanceController::class, 'show']);

    $router->run();

} catch (\Throwable $e) {
    Logger::error('Ошибка запуска бота', ['error' => $e->getMessage()]);
}