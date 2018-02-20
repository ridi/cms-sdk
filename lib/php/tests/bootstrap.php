<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../vendor/autoload.php';

if (is_readable('.env')) {
    $dotenv = new Dotenv\Dotenv(__DIR__, '.env');
    $dotenv->load();
}
