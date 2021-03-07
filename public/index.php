<?php

use Core\Kernel;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../env.php';

$kernel = new Kernel();
$kernel->start();
