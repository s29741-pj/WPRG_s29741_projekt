<?php
//echo "INDEX.PHP HIT<br>";

require_once 'Core/Router.php';
require_once 'Controller/RenderController.php';

$router = new Router();
$router->route($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

?>







