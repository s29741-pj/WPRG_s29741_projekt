<?php
require_once __DIR__ . '/../Repository/TicketRepository.php';
require_once __DIR__ . '/../Repository/DepartmentRepository.php';
require_once __DIR__ . '/../Repository/UserRepository.php';
require_once __DIR__ . '/../Model/Ticket.php';
require_once __DIR__ . '/../Core/Render.php';



class Controller
{
    private $ticketRepo= null;
    private $departmentRepo = null;
    private $userRepo = null;
    public function __construct()
    {
        $this->ticketRepo = TicketRepository::getInstance();
        $this->departmentRepo = DepartmentRepository::getInstance();
        $this->userRepo = UserRepository::getInstance();
    }

    public function ticketMenu()
    {
        $ticket_list = $this->ticketRepo->getTickets();

        $viewPath = __DIR__ . '/../Views/ticket/ticket_menu.php';
        renderSite($viewPath, ['tickets' => $ticket_list]);
    }


    public function ticketCreate()
    {
        $viewPath = __DIR__ . '/../Views/ticket/ticket_create.php';
        render($viewPath);
    }

    public function ticketViewRender()
    {
        $viewPath = __DIR__ . '/../Views/ticket/ticket_view.php';
        render($viewPath);
    }

    public function ticketView()
    {
        $users = $this->userRepo->getUsers();
        $departments = $this->departmentRepo->getDepartments();
        $viewPath = __DIR__ . '/../Views/ticket/ticket_view.php';
        $ticket_list = $this->ticketRepo->getTickets();
        $selected_ticket = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ticket_id'])) {
            $ticket_id = $_POST['ticket_id'];
            $selected_ticket = $ticket_list[$ticket_id-1];
        }

       ;
        render($viewPath, ['selected_ticket' => $selected_ticket,'departments' => $departments, 'users' => $users]);

    }

    public function advSearch()
    {
        $viewPath = __DIR__ . '/../Views/search/adv_search.php';
        render($viewPath);
    }
}