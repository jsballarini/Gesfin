<?php
session_start();

// Autoload simples das classes
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/repositories/',
        __DIR__ . '/../app/models/',
        __DIR__ . '/../app/services/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Carrega rotas
$routes = require_once __DIR__ . '/../app/config/routes.php';

// Captura método e URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Formata a chave da rota (ex: GET|/login)
$routeKey = $method . '|' . $uri;

if (array_key_exists($routeKey, $routes)) {
    $controllerName = $routes[$routeKey][0];
    $actionName = $routes[$routeKey][1];

    $controller = new $controllerName();
    $controller->$actionName();
} else {
    // Rota não encontrada
    http_response_code(404);
    echo "<h1>404 - Página não encontrada</h1>";
}