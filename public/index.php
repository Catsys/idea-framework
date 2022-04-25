<?php

$routes = [
    'PUT:/stats' => [
        'controller' => '\App\Controllers\StatsController',
        'method' => 'create'
    ],
    'GET:/stats' => [
        'controller' => '\App\Controllers\StatsController',
        'method' => 'getStat'
    ],
];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = $_SERVER['REQUEST_METHOD'].':'.$path;

if (!isset($routes[$route])) {
    header("HTTP/1.1 404 Not Found");
    exit;
}
require_once "../boot.php";

$controller = new $routes[$route]['controller'];
$method = $routes[$route]['method'];
if (!is_callable([$controller, $method])) {
    header("HTTP/1.1 400 Bad Request");
    echo "method ".get_class($controller).'::'.$method." is not callable";
    exit;
}
$resp = $controller->$method();
if (is_array($resp)) {
    header("Content-type: application/json");
    echo json_encode($resp);
    exit;
}
echo $resp;
