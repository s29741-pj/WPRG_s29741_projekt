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

//        $ticket_id, $title, $priority, $department, $responsible, $attachment, $is_resolved, $date_deadline

        session_start();
        $form_data = $_SESSION['form_data'];


        $department_id = $this->departmentRepo->getIdByName($form_data['department']);;
        $responsible_id = $this->userRepo->getUserIdByEmail($form_data['responsible']);


        $this->ticketRepo->editTicket($form_data['ticket_id'], $form_data['title'], $form_data['priority'], $department_id, $responsible_id, $form_data['attachment'], $form_data['date_closed'], $form_data['date_deadline']);

    }

}