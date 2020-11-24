<?php
ini_set('display_errors', 1);
date_default_timezone_set('America/Sao_Paulo');
use app\lib\Router;

include_once './../vendor/autoload.php';


$route = [
    'method' => strtolower($_SERVER['REQUEST_METHOD']),
    'url' => strtolower($_SERVER['REQUEST_URI']),
];
$router = new Router($route);
