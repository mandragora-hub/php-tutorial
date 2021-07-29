<?php

use App\Controllers\HomeController;
use App\Controllers\AuthController;

$app->get('/', HomeController::class . ':index');
$app->get('/signup', AuthController::class . ':index')->setName('auth.signup');
$app->post('/signup', AuthController::class . ':signup');
