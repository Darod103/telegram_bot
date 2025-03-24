<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Router\Router;
use TelegramBot\Api\Client;
use App\Services\EnvServices;
use App\Controller\UserController;
use App\Services\Logger;

$bot = new Client(EnvServices::getByKey('TELEGRAM_BOT_TOKEN'));

$router = new Router($bot);
$router->command('start', [UserController::class, 'handle']);
$router->run();
