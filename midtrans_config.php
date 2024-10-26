<?php
require_once 'vendor/autoload.php'; // pastikan autoload Composer disertakan

use Dotenv\Dotenv;

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Set Midtrans Configuration from .env
\Midtrans\Config::$serverKey = $_ENV['MIDTRANS_SERVER_KEY'];
\Midtrans\Config::$clientKey = $_ENV['MIDTRANS_CLIENT_KEY'];
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;
