<?php
require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo json_encode(['clientKey' => $_ENV['MIDTRANS_CLIENT_KEY']]);
