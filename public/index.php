<?php
require __DIR__ . '/../vendor/autoload.php';

use TelegramBot\Api\Client;
use App\Router\Router;
use App\Controller\UserController;
use App\Controller\MessageController;
use App\Services\EnvServices;
use App\Services\Logger;


try {
    
    $bot = new Client(EnvServices::getByKey('TELEGRAM_BOT_TOKEN'));

   
    $router = new Router($bot);

    
    $router->command('start', [UserController::class, 'handle']);
    $router->text([MessageController::class, 'handle']);

    $router->run();

} catch (\Throwable $e) {
    Logger::error('Ошибка запуска бота', ['error' => $e->getMessage()]);
}