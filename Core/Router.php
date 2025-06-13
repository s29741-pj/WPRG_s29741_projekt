<?php

use FlashMsg\Msg;

require_once __DIR__ . '/../Controller/RenderController.php';
require_once __DIR__ . '/../Controller/UserController.php';
require_once __DIR__ . '/../Controller/TicketController.php';
require_once __DIR__ . '/../Controller/CommentController.php';
require_once __DIR__ . '/../Auth/LoginController.php';
require_once __DIR__ . '/../Auth/LogoutController.php';
require_once __DIR__ . '/../Auth/RegisterController.php';
require_once __DIR__ . '/../Controller/DepartmentController.php';
require_once __DIR__ . '/../Controller/RoleController.php';


class Router
{
    public function route($uri, $method)
    {
//        echo "Routing... URI: $uri, METHOD: $method<br>";
        $render_controller = new RenderController();
        $ticket_controller = new TicketController();
        $comment_controller = new CommentController();
        $loginController = new LoginController();
        $logoutController = new LogoutController();
        $registerController = new RegisterController();

        $msg = new Msg();

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
        } elseif ($path === '/ticketpro_app/debug' && $method === 'GET') {
            echo "Router działa i działa .htaccess";
        } elseif ($path === '/ticketpro_app/login' && $method === 'POST') {
            if (isset($_POST['username'], $_POST['password'])) {
                $email = trim($_POST['username']);
                $password = $_POST['password'];
                $loginController->loginAction($email, $password);
            } else {
                header("Location: /ticketpro_app/login_page.php");
                exit;
            }
        } elseif ($path === '/ticketpro_app/register' && $method === 'POST') {
            if (isset($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password'])) {
                $name = trim($_POST['name']);
                $surname = trim($_POST['surname']);
                $email = trim($_POST['email']);
                $password = $_POST['password'];
                $registerController->registerAction($name, $surname, $email, $password);
            } else {
                header("Location: /ticketpro_app/login_page.php");
                exit;
            }
        } elseif ($path === '/ticketpro_app/logout' && $method === 'GET') {
            $logoutController->logout();
        } elseif ($path === '/ticketpro_app/ticket/edit' && $method === 'POST' && isset($_POST['ticket_id'])) {
//            exit($_POST['priority']);
            $ticket_controller->editTicket($_POST, $_FILES);
        } elseif ($path === '/ticketpro_app/ticket/add' && $method === 'POST') {
            $ticket_controller->addTicket($_POST, $_FILES);
        } elseif ($path === '/ticketpro_app/comment/add' && $method === 'POST' && isset($_POST['ticket_id'])) {
            $comment_controller->addComment($_POST['ticket_id'], date('Y-m-d'), $_POST['comment'], 1);
        } elseif ($path === '/ticketpro_app/ticket/delete' && $method === 'POST') {
            $ticket_controller->removeTicket($_POST['ticket_id']);
        } elseif ($path === '/ticketpro_app/login/guest' && $method === 'POST') {
            $loginController->loginAsGuest();
        } elseif ($path === '/ticketpro_app/ticket/filter' && $method === 'POST') {
            $render_controller->ticketMenuWithFilter();
        } elseif ($path === '/ticketpro_app/admin' && $method === 'GET') {
            $render_controller->adminPanel();
        } elseif ($path === '/ticketpro_app/admin/users' && $method === 'GET') {
            $render_controller->manageUsers();
        } elseif ($path === '/ticketpro_app/admin/departments' && $method === 'GET') {
            $render_controller->manageDepartments();
        } elseif ($path === '/ticketpro_app/admin/roles' && $method === 'GET') {
            $render_controller->manageRoles();
        } elseif ($path === '/ticketpro_app/admin/comments' && $method === 'GET') {
            $render_controller->manageComments();
        } elseif ($path === '/ticketpro_app/admin/users/edit' && $method === 'GET') {
            $userController = new UserController();
            $userController->editUserForm($_GET['id']); // usr edycja
        } elseif ($path === '/ticketpro_app/admin/users/edit' && $method === 'POST') {
            $userController = new UserController();
            $userController->updateUser($_POST); // zapis
        } elseif ($path === '/ticketpro_app/admin/users/delete' && $method === 'GET') {
            $userController = new UserController();
            $userController->deleteUser($_GET['id']); //  delete
        } elseif ($path === '/ticketpro_app/admin/departments/edit' && $method === 'GET') {
            $departmentController = new DepartmentController();
            $departmentController->editDepartmentForm($_GET['id']); // dial edycja
        } elseif ($path === '/ticketpro_app/admin/departments/edit' && $method === 'POST') {
            $departmentController = new DepartmentController();
            $departmentController->updateDepartment($_POST); // dzial update
        } elseif ($path === '/ticketpro_app/admin/departments/delete' && $method === 'GET') {
            $departmentController = new DepartmentController();
            $departmentController->deleteDepartment($_GET['id']); // Usunięcie działu
        } elseif ($path === '/ticketpro_app/admin/departments/add' && $method === 'GET') {
            $departmentController = new DepartmentController();
            $departmentController->addDepartmentForm(); // Formularz dodawania działu
        } elseif ($path === '/ticketpro_app/admin/departments/add' && $method === 'POST') {
            $departmentController = new DepartmentController();
            $departmentController->storeDepartment($_POST); // Zapis nowego działu
        } elseif ($path === '/ticketpro_app/admin/roles/add' && $method === 'GET') {
            $roleController = new RoleController();
            $roleController->addRoleForm();
        } elseif ($path === '/ticketpro_app/admin/roles/add' && $method === 'POST') {
            $roleController = new RoleController();
            $roleController->storeRole($_POST);
        } elseif ($path === '/ticketpro_app/admin/roles/edit' && $method === 'GET') {
            $roleController = new RoleController();
            $roleController->editRoleForm($_GET['id']);
        } elseif ($path === '/ticketpro_app/admin/roles/edit' && $method === 'POST') {
            $roleController = new RoleController();
            $roleController->updateRole($_POST);
        } elseif ($path === '/ticketpro_app/admin/roles/delete' && $method === 'GET') {
            $roleController = new RoleController();
            $roleController->deleteRole($_GET['id']);
        } elseif ($path === '/ticketpro_app/admin/comments/edit' && $method === 'GET') {
            $comment_controller = new CommentController();
            $comment_controller->editCommentForm((int)$_GET['id']);
        } elseif ($path === '/ticketpro_app/admin/comments/edit' && $method === 'POST') {
            $comment_controller = new CommentController();
            $comment_controller->updateComment($_POST);
        } elseif ($path === '/ticketpro_app/admin/comments/delete' && $method === 'GET') {
            $comment_controller = new CommentController();
            $comment_controller->deleteComment((int)$_GET['id']);
        } elseif ($path === '/ticketpro_app/register_page' && $method === 'GET') {
            $render_controller->registerPage();
        } elseif ($path === '/ticketpro_app/forgotten') {
            $render_controller->forgottenPassword();
        } elseif ($path === '/ticketpro_app/activate_account' && $method === 'GET') {
            if (isset($_GET['token'])) {
                $registerController->activateAccount($_GET['token']);
            } else {
                echo "No activation token provided.";
            }
        } elseif ($path === '/ticketpro_app/reset_password_request' && $method === 'POST') {
            if (isset($_POST['email'])) {
                $loginController->resetPasswordRequest($_POST['email']);
            } else {
                echo "Email is required.";
            }
        } elseif ($path === '/ticketpro_app/reset_password' && $method === 'GET') {
            $viewPath = __DIR__ . '/../Views/login/reset_password.php';
            renderSite($viewPath);
        } elseif ($path === '/ticketpro_app/reset_password_confirm' && $method === 'POST') {
            if (isset($_POST['token'], $_POST['password'], $_POST['password_confirm'])) {
                if ($_POST['password'] !== $_POST['password_confirm']) {
                    $msg->set_flash('reset_error', 'Passwords do not match.');
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit;
                }
                $loginController->resetPassword($_POST['token'], $_POST['password']);
            } else {
                echo "All fields are required.";
            }
        } elseif ($path === '/ticketpro_app/logout_session' && $method === 'POST') {
            session_start();
            session_unset();
            session_destroy();
            http_response_code(200);
            exit;
        } else {
            echo "No matching route found.<br>";
        }
    }
}