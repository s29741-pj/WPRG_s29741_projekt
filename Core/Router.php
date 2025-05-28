<?php

require_once __DIR__ . '/../Controller/RenderController.php';
require_once __DIR__ . '/../Controller/UserController.php';
require_once __DIR__ . '/../Controller/TicketController.php';


class Router
{
    public function route($uri, $method)
    {
//        echo "Routing... URI: $uri, METHOD: $method<br>";
        $controller = new RenderController();
        $user_controller = new UserController();
        $ticket_controller = new TicketController();

        $parsed = parse_url($uri);
        $path = $parsed['path'];
//        $query_string = ($parsed['query'] ?? '');
//        echo "Parsed path: $path<br>";

        if ($path === '/ticketpro/') {
            header('Location: /ticketpro/ticket');
        }


        if ($path === '/ticketpro/ticket' && $method === 'GET') {
            $controller->ticketMenu();
        } elseif ($path === '/ticketpro/ticket/create' && $method === 'GET') {
            $controller->ticketCreate();
        } elseif ($path === '/ticketpro/ticket/view' && $method === 'POST') {
            $controller->ticketView();
        } elseif ($path === '/ticketpro/ticket/view' && $method === 'GET') {
            $controller->ticketViewRender();
        } elseif ($path === '/ticketpro/ticket/search' && $method === 'GET') {
            $controller->advSearch();
        } elseif ($path === '/ticketpro/login' && $method === 'GET') {
            $user_controller->login();
        } elseif ($path === '/ticketpro/ticket/edit' && $method === 'POST' && isset($_POST['ticket_id'])) {
            $ticket_controller->editTicket($_POST, $_FILES);
        } else {
            echo "No matching route found.<br>";
        }
    }

}