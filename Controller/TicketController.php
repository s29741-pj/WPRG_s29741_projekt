<?php
require_once __DIR__ . '/../Repository/TicketRepository.php';
require_once __DIR__ . '/../Model/Ticket.php';
require_once __DIR__ . '/../Core/view.php';

class TicketController
{
    private TicketRepository $ticketRepo;
    public function __construct(){
        $this->ticketRepo = new TicketRepository();
    }


    public function listTickets(){
        $ticket_list =  $this->ticketRepo->getTickets();
        $viewPath =  __DIR__ . '/../Views/ticket/ticket_list.php';
//        var_dump($ticket_list);
        render( $viewPath, ['tickets' => $ticket_list]);
    }
}