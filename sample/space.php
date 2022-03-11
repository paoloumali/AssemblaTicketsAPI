<?php

include_once('_inc_start.php');

use Paolo\AssemblaAPI\Space as AssemblaSpace;

$space = AssemblaSpace::init([
    'X-Api-Key' => $_ENV['ASSEMBLA_API_KEY'],
    'X-Api-Secret' => $_ENV['ASSEMBLA_API_SECRET'],
    'space' =>  $_ENV['ASSEMBLA_SPACE']
]);

var_dump($space->fetch());
//echo $space->fetch()->name;
