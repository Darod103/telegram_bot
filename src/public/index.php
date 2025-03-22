<?php
require '../vendor/autoload.php';
use App\Services\EnvServices;

$token = EnvServices::getByKey('TELEGRAM_BOT_TOKEN');
var_dump($token);
