<?php

include_once('_inc_start.php');

use Paolo\AssemblaAPI\BaseAPI as AssemblaAPI;

$api = AssemblaAPI::init([
    'ASSEMBLA_KEY' => $_ENV['ASSEMBLA_KEY'],
    'ASSEMBLA_SECRET' => $_ENV['ASSEMBLA_SECRET'],
    'space' =>  $_ENV['ASSEMBLA_SPACE']
]);

var_dump($api->fetch());
