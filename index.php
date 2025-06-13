<?php

require_once __DIR__ . '/Core/Router.php';
require_once __DIR__ . '/Controller/RenderController.php';

function url(string $path): string
{
    return '/~s29741/ticketpro_app' . $path;
}


$router = new Router();
$router->route($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

?>







