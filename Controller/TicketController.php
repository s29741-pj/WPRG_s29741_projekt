<?php
require_once __DIR__ . '/../Repository/TicketRepository.php';
require_once __DIR__ . '/../Model/Ticket.php';

class TicketController
{
    private TicketRepository $ticketRepo;
    public function __construct(){
        $this->ticketRepo = new TicketRepository();
    }

    private function render(string $view, array $data = []) {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        var_dump(array_keys($data)); // Should show ["tickets"]
        var_dump(isset($tickets)); // Should be true
        echo "dupa";
        include $view;
    }


    public function listTickets(){
        $ticket_list =  $this->ticketRepo->getTickets();
        $viewPath =  __DIR__ . '/../Views/ticket/ticket_list.php';
        var_dump($ticket_list); // Make sure it's an array of Ticket objects
        $this->render( $viewPath, ['tickets' => $ticket_list]);
    }
}