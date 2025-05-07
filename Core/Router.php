<?php

require_once __DIR__ . '/../Controller/TicketController.php';
require_once __DIR__ . '/../Controller/UserController.php';


class Router
{
    public function route($uri, $method)
    {
//        echo "Routing... URI: $uri, METHOD: $method<br>";
        $ticket_controller = new TicketController();
        $user_controller = new UserController();

        $parsed = parse_url($uri);
        $path = $parsed['path'];
//        $query_string = ($parsed['query'] ?? '');
//        echo "Parsed path: $path<br>";

        if ($path === '/ticketpro/') {
            header('Location: /ticketpro/ticket');
        }


        if ($path === '/ticketpro/ticket' && $method === 'GET') {
            $ticket_controller->ticketMenu();
        } elseif ($path === '/ticketpro/ticket/list' && $method === 'GET') {
            $ticket_controller->listTickets();
        } elseif ($path === '/ticketpro/ticket/edit' && $method === 'GET') {
            $ticket_controller->ticketEdit();
        } elseif ($path === '/ticketpro/ticket/create' && $method === 'GET') {
            $ticket_controller->ticketCreate();
        } elseif ($path === '/ticketpro/ticket/search' && $method === 'GET') {
            $ticket_controller->advSearch();
        } elseif ($path === '/ticketpro/login' && $method === 'GET') {
            $user_controller->login();
        } else {
            echo "No matching route found.<br>";
        }

    }

}