<?php

require_once __DIR__ . '/../Controller/TicketController.php';


class Router
{
    public function route($uri, $method){
//        echo "Routing... URI: $uri, METHOD: $method<br>";
        $controller = new TicketController();

        $parsed = parse_url($uri);
        $path = $parsed['path'];
        $query_string = ($parsed['query'] ?? '');

//        echo "Parsed path: $path<br>";

        if($path === '/ticketpro/'){
            header('Location: /ticketpro/ticket');
        }


        if ($path === '/ticketpro/ticket' && $method === 'GET') {
            $controller->listTickets();
        } elseif ($path === '/ticketpro/ticket/edit' && $method === 'GET'){
            $controller->ticketEdit();
        }else {
          echo "No matching route found.<br>";
        }

    }

}