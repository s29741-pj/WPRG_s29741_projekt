<?php

class ticketController
{

    private $ticketRepo = null;
    private $departmentRepo = null;
    private $userRepo = null;

    public function __construct()
    {
        $this->ticketRepo = TicketRepository::getInstance();
        $this->departmentRepo = DepartmentRepository::getInstance();
        $this->userRepo = UserRepository::getInstance();
    }

    public function editTicket()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_data'])) {
//            chcę tu przekazać listę z danymi usera
            $department_id = $this->departmentRepo->getIdByName();
            $responsible_id = $this->userRepo->getUserIdByEmail($responsible)

        }//        $ticket_id, $title, $priority, $department, $responsible, $attachment, $is_resolved, $date_deadline

        ;


        $this->ticketRepo->editTicket($ticket_id, $title, $priority, $department_id, $responsible_id, $attachment, $is_resolved, $date_deadline);

    }

}