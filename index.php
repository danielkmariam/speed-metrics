<?php

require_once __DIR__ . '/vendor/autoload.php';

$container = require(__DIR__ . '/config/container.php');


$application = $container['application'];
$application->run();
