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

    public function editTicket(array $post, array $files)
    {
        $ticket_id = $post['ticket_id'];
        $title = $post['title'] ?? '';
        $priority = $post['priority'] ?? '';
        $department_id = $post['department'] ?? '';
        $responsible_id = $post['responsible'] ?? '';
        $date_deadline = $post['date_deadline'] ?? '';
        $is_resolved = isset($post['is_resolved']) ? 1 : 0;


        $this->ticketRepo->editTicket($ticket_id, $title, $priority, $department_id, $responsible_id, $date_deadline, $is_resolved);

        header('Location: /ticketpro/ticket');
        exit;
    }

}