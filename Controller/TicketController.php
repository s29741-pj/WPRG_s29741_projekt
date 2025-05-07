<?php
require_once __DIR__ . '/../Repository/TicketRepository.php';
require_once __DIR__ . '/../Model/Ticket.php';
require_once __DIR__ . '/../Core/View.php';

class TicketController
{
    private TicketRepository $ticketRepo;
    public function __construct(){
        $this->ticketRepo = new TicketRepository();
    }


    public function listTickets(){
        $ticket_list =  $this->ticketRepo->getTickets();
        $viewPath = __DIR__ . '/../Views/ticket/ticket_list.php';
//        var_dump($ticket_list);
        renderSite( $viewPath, ['tickets' => $ticket_list]);
    }

    public function ticketMenu(){
        $viewPath =  __DIR__ . '/../Views/ticket/ticket_menu.php';
        render($viewPath);
    }
    public function ticketEdit(){
        $viewPath =  __DIR__ . '/../Views/ticket/ticket_edit.php';
        render($viewPath);
    }

    public function ticketCreate(){
        $viewPath =  __DIR__ . '/../Views/ticket/ticket_create.php';
        render($viewPath);
    }

    public function advSearch(){
        $viewPath =  __DIR__ . '/../Views/search/adv_search.php';
        render($viewPath);
    }
}