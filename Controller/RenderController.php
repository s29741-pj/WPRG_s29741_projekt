<?php
require_once __DIR__ . '/../Repository/TicketRepository.php';
require_once __DIR__ . '/../Repository/DepartmentRepository.php';
require_once __DIR__ . '/../Repository/UserRepository.php';
require_once __DIR__ . '/../Repository/AttachmentRepository.php';
//require_once __DIR__ . '/../Repository/CommentRepository.php';
require_once __DIR__ . '/../Model/Ticket.php';
require_once __DIR__ . '/../Core/Render.php';
require_once __DIR__ . '/../Flash/Msg.php';
use FlashMsg\msg;




class RenderController
{
    private $ticketRepo= null;
    private $departmentRepo = null;
    private $userRepo = null;
    private $attachmentRepo = null;


//    private $commentRepo = null;
    public function __construct()
    {
        $this->ticketRepo = TicketRepository::getInstance();
        $this->departmentRepo = DepartmentRepository::getInstance();
        $this->userRepo = UserRepository::getInstance();
        $this->attachmentRepo = AttachmentRepository::getInstance();
//        $this->commentRepo = CommentRepository::getInstance();
    }

    public function loginPage(){
        $viewPath = __DIR__ . '/../Views/login/login_page.php';
        renderSite($viewPath);
    }

    public function registerPage(){
        $viewPath = __DIR__ . '/../Views/login/register_page.php';
        renderSite($viewPath);
    }

    public function ticketMenu()
    {
        $ticket_list = $this->ticketRepo->getTickets();
        $attachment_list = $this->attachmentRepo->getAttachments();
//        exit(var_dump($ticket_list));


        $viewPath = __DIR__ . '/../Views/ticket/ticket_menu.php';
        renderSite($viewPath, ['ticket_list' => $ticket_list, 'attachment_list' => $attachment_list]);
    }


    public function ticketCreate()
    {
        $users = $this->userRepo->getUsers();
        $departments = $this->departmentRepo->getDepartments();

        $viewPath = __DIR__ . '/../Views/ticket/ticket_create.php';
        render($viewPath,['users' => $users, 'departments' => $departments]);
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
        $attachment_list = $this->attachmentRepo->getAttachments();

        $selected_ticket = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ticket_id'])) {
            $ticket_id = $_POST['ticket_id'];
            $selected_ticket = $ticket_list[$ticket_id-1];
        }


        render($viewPath, ['selected_ticket' => $selected_ticket,'departments' => $departments, 'users' => $users, 'attachment_list' => $attachment_list]);

    }

    public function advSearch()
    {
        $viewPath = __DIR__ . '/../Views/search/adv_search.php';
        render($viewPath);
    }
}