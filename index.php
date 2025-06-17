<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/Core/Router.php';
require_once __DIR__ . '/Controller/RenderController.php';

// Pobierz trasę z parametru GET 'route', domyślnie '/'
$route = $_GET['route'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

$router = new Router();
$router->route($route, $method);

?>







