<?php

require_once __DIR__ . '/../Controller/TicketController.php';

//tu stop 23.04 cgpt zacząć od ✅ 3. Update the route condition (if needed)
class Router
{
    public function route($uri, $method){
        echo "Routing... URI: $uri, METHOD: $method<br>";
        $controller = new TicketController();

        $parsed = parse_url($uri);
        $path = $parsed['path'];
        $query_string = ($parsed['query'] ?? '');

        echo "Parsed path: $path<br>";


//        if($path === '/'){
//            header('Location: /ticket');
//        }

        if ($path === '/ticket' && $method === 'GET') {
            echo "Calling listTickets()<br>";
            $controller->listTickets();
        } else {
            echo "No matching route found.<br>";
        }

    }

}