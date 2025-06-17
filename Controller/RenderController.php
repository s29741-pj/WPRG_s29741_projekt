<?php
require_once __DIR__ . '/../Repository/TicketRepository.php';
require_once __DIR__ . '/../Repository/DepartmentRepository.php';
require_once __DIR__ . '/../Repository/UserRepository.php';
require_once __DIR__ . '/../Repository/AttachmentRepository.php';
//require_once __DIR__ . '/../Repository/CommentRepository.php';
require_once __DIR__ . '/../Model/Ticket.php';
require_once __DIR__ . '/../Core/Render.php';
require_once __DIR__ . '/../Flash/Msg.php';

use FlashMsg\Msg;

class RenderController
{
    private $ticketRepo = null;
    private $departmentRepo = null;
    private $userRepo = null;
    private $attachmentRepo = null;

    // private $commentRepo = null;
    public function __construct()
    {
        $this->ticketRepo = TicketRepository::getInstance();
        $this->departmentRepo = DepartmentRepository::getInstance();
        $this->userRepo = UserRepository::getInstance();
        $this->attachmentRepo = AttachmentRepository::getInstance();
        // $this->commentRepo = CommentRepository::getInstance();
    }

    public function loginPage()
    {
        $viewPath = __DIR__ . '/../Views/login/login_page.php';
        renderSite($viewPath);
    }

    public function registerPage()
    {
        $viewPath = __DIR__ . '/../Views/login/register_page.php';
        renderSite($viewPath);
    }

    public function forgottenPassword()
    {
        $viewPath = __DIR__ . '/../Views/login/forgotten_password.php';
        renderSite($viewPath);
    }

    public function ticketMenu()
    {
        $ticket_list = $this->ticketRepo->getTickets();
        $attachment_list = $this->attachmentRepo->getAttachments();

        $viewPath = __DIR__ . '/../Views/ticket/ticket_menu.php';
        renderSite($viewPath, ['ticket_list' => $ticket_list, 'attachment_list' => $attachment_list]);
    }

    public function ticketCreate()
    {
        $users = $this->userRepo->listUsers();
        $departments = $this->departmentRepo->listDepartments();

        $viewPath = __DIR__ . '/../Views/ticket/ticket_create.php';
        render($viewPath, ['users' => $users, 'departments' => $departments]);
    }

    public function ticketViewRender()
    {
        $viewPath = __DIR__ . '/../Views/ticket/ticket_view.php';
        render($viewPath);
    }

    public function ticketView()
    {
        $users = $this->userRepo->listUsers();
        $departments = $this->departmentRepo->listDepartments();
        $viewPath = __DIR__ . '/../Views/ticket/ticket_view.php';
        $ticket_list = $this->ticketRepo->getTickets();
        $attachment_list = $this->attachmentRepo->getAttachments();

        $selected_ticket = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ticket_id'])) {
            $ticket_id = $_POST['ticket_id'];
            $selected_ticket = $ticket_list[$ticket_id - 1] ?? null;
        }

        render($viewPath, [
            'selected_ticket' => $selected_ticket,
            'departments' => $departments,
            'users' => $users,
            'attachment_list' => $attachment_list
        ]);
    }

    public function ticketMenuWithFilter()
    {
        $filter = $_POST['filter'] ?? 'all';
        $filterDate = $_POST['filter_date'] ?? null;
        $priority = $_POST['priority'] ?? null;

        $ticket_list = $this->ticketRepo->getFilteredTickets($filter, $filterDate, $priority);
        $attachment_list = $this->attachmentRepo->getAttachments();

        $viewPath = __DIR__ . '/../Views/ticket/ticket_menu.php';
        renderSite($viewPath, ['ticket_list' => $ticket_list, 'attachment_list' => $attachment_list]);
    }

    public function adminPanel()
    {
        if (!isset($_SESSION['role_id']) || (int)$_SESSION['role_id'] != 1) {
            header("Location: index.php?route=ticket");
            exit;
        }

        $viewPath = __DIR__ . '/../Views/admin/admin_panel.php';
        renderSite($viewPath);
    }

    public function manageUsers()
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
            header("Location: index.php?route=ticket");
            exit;
        }

        $userRepo = UserRepository::getInstance();
        $departmentRepo = DepartmentRepository::getInstance();
        $roleRepo = RoleRepository::getInstance();

        $users = $userRepo->listUsers();
        $departments = $departmentRepo->listDepartments();
        $roles = $roleRepo->listRoles();

        $viewPath = __DIR__ . '/../Views/admin/admin_panel.php';
        renderSite($viewPath, [
            'users' => $users,
            'departments' => $departments,
            'roles' => $roles,
            'activeSection' => 'users'
        ]);
    }

    public function manageDepartments()
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
            header("Location: index.php?route=ticket");
            exit;
        }

        $departmentRepo = DepartmentRepository::getInstance();
        $departments = $departmentRepo->listDepartments();

        $viewPath = __DIR__ . '/../Views/admin/admin_panel.php';
        renderSite($viewPath, [
            'departments' => $departments,
            'activeSection' => 'departments'
        ]);
    }

    public function manageRoles()
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
            header("Location: index.php?route=ticket");
            exit;
        }

        $roleRepo = RoleRepository::getInstance();
        $roles = $roleRepo->listRoles();

        $viewPath = __DIR__ . '/../Views/admin/admin_panel.php';
        renderSite($viewPath, [
            'roles' => $roles,
            'activeSection' => 'roles'
        ]);
    }

    public function manageComments()
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
            header("Location: index.php?route=ticket");
            exit;
        }

        $commentRepo = CommentRepository::getInstance();
        $comments = $commentRepo->getComments();

        $viewPath = __DIR__ . '/../Views/admin/admin_panel.php';
        renderSite($viewPath, [
            'comments' => $comments,
            'activeSection' => 'comments'
        ]);
    }
}