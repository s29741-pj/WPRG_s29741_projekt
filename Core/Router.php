<?php

require_once __DIR__ . '/../Controller/RenderController.php';
require_once __DIR__ . '/../Controller/UserController.php';
require_once __DIR__ . '/../Controller/TicketController.php';
require_once __DIR__ . '/../Controller/CommentController.php';
require_once __DIR__ . '/../Auth/LoginController.php';
require_once __DIR__ . '/../Auth/LogoutController.php';


class Router
{
    public function route($uri, $method)
    {
//        echo "Routing... URI: $uri, METHOD: $method<br>";
        $render_controller = new RenderController();
        $ticket_controller = new TicketController();
        $comment_controller = new CommentController();
        $loginController = LoginController::getInstance();
        $logoutController = new LogoutController();
//        $user_controller = new UserController();

        $parsed = parse_url($uri);
        $path = $parsed['path'];
//        $query_string = ($parsed['query'] ?? '');
//        echo "Parsed path: $path<br>";

        if ($path === '/ticketpro_app/') {
            $render_controller->loginPage();
//            header('Location: /ticketpro/login');
        } elseif ($path === '/ticketpro_app/test' && $method === 'GET') {
            echo "Router działa!";
        } elseif ($path === '/ticketpro_app/ticket' && $method === 'GET') {
            $render_controller->ticketMenu();
        } elseif ($path === '/ticketpro_app/ticket/create' && $method === 'GET') {
            $render_controller->ticketCreate();
        } elseif ($path === '/ticketpro_app/ticket/view' && $method === 'POST') {
            $render_controller->ticketView();
        } elseif ($path === '/ticketpro_app/ticket/view' && $method === 'GET') {
            $render_controller->ticketViewRender();
        } elseif ($path === '/ticketpro_app/ticket/search' && $method === 'GET') {
            $render_controller->advSearch();
        } elseif ($path === '/ticketpro_app/debug' && $method === 'GET') {
            echo "Router działa i działa .htaccess";
        } elseif ($path === '/ticketpro_app/login' && $method === 'POST') {
            if (isset($_POST['username'], $_POST['password'])) {
                $email = trim($_POST['username']);
                $password = $_POST['password'];
                $loginController->loginAction($email, $password);
            } else {
                echo "Brak wymaganych danych logowania.";
                header("Location: /ticketpro_app/login_page.php");
                exit;
            }
        }elseif ($path === '/ticketpro_app/logout' && $method === 'GET') {
            $logoutController->logout();
        }
        elseif ($path === '/ticketpro_app/ticket/edit' && $method === 'POST' && isset($_POST['ticket_id'])) {
            $ticket_controller->editTicket($_POST, $_FILES);
        }elseif ($path === '/ticketpro_app/comment/add' && $method === 'POST' && isset($_POST['ticket_id'])) {
            $comment_controller->addComment($_POST['ticket_id'],date('Y-m-d'),$_POST['comment'],1);
        }
        else {
            echo "No matching route found.<br>";
        }
    }

}