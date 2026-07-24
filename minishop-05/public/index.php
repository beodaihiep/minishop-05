<?php

session_start();

$basePath = dirname(__DIR__);

require_once $basePath . '/config/database.php';
require_once $basePath . '/models/CategoryModel.php';
require_once $basePath . '/controllers/CategoryController.php';

// Whitelist controller và action theo chuẩn Phiếu 05
$controllers = [
    'category' => 'CategoryController',
];

$actions = ['index', 'create', 'edit', 'delete'];

$controllerParam = $_GET['controller'] ?? 'category';
$actionParam = $_GET['action'] ?? 'index';

if (!array_key_exists($controllerParam, $controllers)) {
    http_response_code(404);
    exit("404 Controller Not Found");
}

if (!in_array($actionParam, $actions, true)) {
    http_response_code(404);
    exit("404 Action Not Found");
}

$className = $controllers[$controllerParam];
$controller = new $className();
$controller->$actionParam();
