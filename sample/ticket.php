<?php

include_once('_inc_start.php');

use Paolo\AssemblaAPI\Ticket as AssemblaTicket;

$tickets = AssemblaTicket::init([
    'ASSEMBLA_KEY' => $_ENV['ASSEMBLA_KEY'],
    'ASSEMBLA_SECRET' => $_ENV['ASSEMBLA_SECRET'],
    'ASSEMBLA_SPACE' =>  $_ENV['ASSEMBLA_SPACE'],
    'ASSEMBLA_MILESTONE' =>  $_ENV['ASSEMBLA_MILESTONE']
]);

var_dump($tickets->fetch());
