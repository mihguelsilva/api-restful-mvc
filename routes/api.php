<?php
use \App\Controllers\AdminController;
use \App\Controllers\AuthController;
use \App\Middlewares\AuthMiddleware;
use \App\Controllers\HomeController;

$router->get('/usuarios', [HomeController::class, 'index']);
$router->post('/usuarios', [HomeController::class, 'store']);
$router->post('/login', [AuthController::class, 'login']);

// rotas protegidas
$router->middleware('/admin', 'GET', [AuthMiddleware::class, 'handle']);
$router->get('/admin', [AdminController::class, 'index']);
?>