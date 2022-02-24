<?php

require __DIR__ . '/../vendor/autoload.php';

// make .env values available from $_ENV var
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// errors
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

use Paolo\AssemblaAPI\API as AssemblaAPI;

$api = new AssemblaAPI([
    'X-Api-Key' => $_ENV['ASSEMBLA_API_KEY'],
    'X-Api-Secret' => $_ENV['ASSEMBLA_API_SECRET'],
    'space' =>  $_ENV['ASSEMBLA_SPACE']
]);

var_dump($api->fetch());
