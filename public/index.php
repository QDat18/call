<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Maintenance mode
if (file_exists(__DIR__.'/../Project_Final/storage/framework/maintenance.php')) {
    require __DIR__.'/../Project_Final/storage/framework/maintenance.php';
}

// Autoload
require __DIR__ . '/../Project_Final/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/../Project_Final/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
