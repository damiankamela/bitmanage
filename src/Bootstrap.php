<?php

namespace BitManage;

use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$environment = 'dev';

$whoops = new \Whoops\Run;

if ($environment !== 'prod') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else {
    $whoops->pushHandler(function ($e) {
        echo 'Unexpected error has occurred.';
    });
}
$whoops->register();

$dotenv = new Dotenv(__DIR__ . '/../');
$dotenv->load();