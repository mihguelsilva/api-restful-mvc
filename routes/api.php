<?php
use \App\Controllers\AdminController;
use \App\Controllers\AuthController;
use \App\Middlewares\AuthMiddleware;
use \App\Controllers\UserController;

$router->post('/login', [AuthController::class, 'login']);

// rotas administrativas
$router->middleware('/usuarios', 'GET', [AuthMiddleware::class, 'handle', ['admin', 'user', 'editor']]);
$router->get('/usuarios', [UserController::class, 'index']);

$router->middleware('/usuarios/store', 'POST', [AuthMiddleware::class, 'handle', ['admin']]);
$router->post('/usuarios/store', [UserController::class, 'store']);

$router->middleware('/admin', 'GET', [AuthMiddleware::class, 'handle', ['admin', 'editor']]);
$router->get('/admin', [AdminController::class, 'index']);

$router->middleware('/usuarios/delete/{id}', 'DELETE', [AuthMiddleware::class, 'handle', ['admin']]);
$router->delete('/usuarios/delete/{id}', [UserController::class, 'delete']);

$router->middleware('/usuarios/update/{id}', 'PUT', [AuthMiddleware::class, 'handle', ['admin']]);
$router->put('/usuarios/update/{id}', [UserController::class, 'update']);
?>