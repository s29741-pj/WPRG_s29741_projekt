<?php

require_once __DIR__ . '/Core/Router.php';
require_once __DIR__ . '/Controller/RenderController.php';

$router = new Router();
$router->route($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

?>







