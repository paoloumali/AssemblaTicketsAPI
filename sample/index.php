<?php

include_once('_inc_start.php');

use Paolo\AssemblaAPI\BaseAPI as AssemblaAPI;

$api = AssemblaAPI::init([
    'X-Api-Key' => $_ENV['ASSEMBLA_API_KEY'],
    'X-Api-Secret' => $_ENV['ASSEMBLA_API_SECRET'],
    'space' =>  $_ENV['ASSEMBLA_SPACE']
]);

var_dump($api->fetch());
