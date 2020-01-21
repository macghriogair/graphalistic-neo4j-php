<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotEnv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotEnv->load();