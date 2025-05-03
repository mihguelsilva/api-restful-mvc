<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';
require ROOT_DIR . DS . 'vendor' . DS . 'autoload.php';

use \App\Core\Request;
use \App\Core\Router;

// Inicia roteador
$router = new Router(new Request);

// Incluir rotas registradas
require ROOT_DIR . DS . 'routes' . DS . 'api.php';

// Verifica existência das rotas
$router->resolve();
?>