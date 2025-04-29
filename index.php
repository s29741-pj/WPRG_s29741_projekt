<?php
//echo "INDEX.PHP HIT<br>";

require_once 'Core/Router.php';
require_once 'Controller/TicketController.php';

$router = new Router();
$router->route($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

?>







