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
    public function route($route, $method)
    {
        $render_controller = new RenderController();
        $ticket_controller = new TicketController();
        $comment_controller = new CommentController();
        $loginController = new LoginController();
        $logoutController = new LogoutController();
        $registerController = new RegisterController();

        $msg = new Msg();

        // $route pochodzi teraz z $_GET['route'], np. 'login', 'ticket/create', itd.
        // Domyślna strona logowania
        if ($route === '/' || $route === '' || $route === 'login_page') {
            $render_controller->loginPage();
        } elseif ($route === 'test' && $method === 'GET') {
            echo "Router działa!";
        } elseif ($route === 'ticket' && $method === 'GET') {
            $render_controller->ticketMenu();
        } elseif ($route === 'ticket/create' && $method === 'GET') {
            $render_controller->ticketCreate();
        } elseif ($route === 'ticket/view' && $method === 'POST') {
            $render_controller->ticketView();
        } elseif ($route === 'ticket/view' && $method === 'GET') {
            $render_controller->ticketViewRender();
        } elseif ($route === 'debug' && $method === 'GET') {
            echo "Router działa bez .htaccess";
        } elseif ($route === 'login' && $method === 'POST') {
            if (isset($_POST['username'], $_POST['password'])) {
                $email = trim($_POST['username']);
                $password = $_POST['password'];
                $loginController->loginAction($email, $password);
            } else {
                header("Location: index.php?route=login_page");
                exit;
            }
        } elseif ($route === 'register' && $method === 'POST') {
            if (isset($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password'])) {
                $name = trim($_POST['name']);
                $surname = trim($_POST['surname']);
                $email = trim($_POST['email']);
                $password = $_POST['password'];
                $registerController->registerAction($name, $surname, $email, $password);
            } else {
                header("Location: index.php?route=login_page");
                exit;
            }
        } elseif ($route === 'logout' && $method === 'GET') {
            $logoutController->logout();
        } elseif ($route === 'ticket/edit' && $method === 'POST' && isset($_POST['ticket_id'])) {
            $ticket_controller->editTicket($_POST, $_FILES);
        } elseif ($route === 'ticket/add' && $method === 'POST') {
            $ticket_controller->addTicket($_POST, $_FILES);
        } elseif ($route === 'comment/add' && $method === 'POST' && isset($_POST['ticket_id'])) {
            $comment_controller->addComment($_POST['ticket_id'], date('Y-m-d'), $_POST['comment'], 1);
        } elseif ($route === 'ticket/delete' && $method === 'POST') {
            $ticket_controller->removeTicket($_POST['ticket_id']);
        } elseif ($route === 'login/guest' && $method === 'POST') {
            $loginController->loginAsGuest();
        } elseif ($route === 'ticket/filter' && $method === 'POST') {
            $render_controller->ticketMenuWithFilter();
        } elseif ($route === 'admin' && $method === 'GET') {
            $render_controller->adminPanel();
        } elseif ($route === 'admin/users' && $method === 'GET') {
            $render_controller->manageUsers();
        } elseif ($route === 'admin/departments' && $method === 'GET') {
            $render_controller->manageDepartments();
        } elseif ($route === 'admin/roles' && $method === 'GET') {
            $render_controller->manageRoles();
        } elseif ($route === 'admin/comments' && $method === 'GET') {
            $render_controller->manageComments();
        } elseif ($route === 'admin/users/edit' && $method === 'GET') {
            $userController = new UserController();
            $userController->editUserForm($_GET['id']);
        } elseif ($route === 'admin/users/edit' && $method === 'POST') {
            $userController = new UserController();
            $userController->updateUser($_POST);
        } elseif ($route === 'admin/users/delete' && $method === 'GET') {
            $userController = new UserController();
            $userController->deleteUser($_GET['id']);
        } elseif ($route === 'admin/departments/edit' && $method === 'GET') {
            $departmentController = new DepartmentController();
            $departmentController->editDepartmentForm($_GET['id']);
        } elseif ($route === 'admin/departments/edit' && $method === 'POST') {
            $departmentController = new DepartmentController();
            $departmentController->updateDepartment($_POST);
        } elseif ($route === 'admin/departments/delete' && $method === 'GET') {
            $departmentController = new DepartmentController();
            $departmentController->deleteDepartment($_GET['id']);
        } elseif ($route === 'admin/departments/add' && $method === 'GET') {
            $departmentController = new DepartmentController();
            $departmentController->addDepartmentForm();
        } elseif ($route === 'admin/departments/add' && $method === 'POST') {
            $departmentController = new DepartmentController();
            $departmentController->storeDepartment($_POST);
        } elseif ($route === 'admin/roles/add' && $method === 'GET') {
            $roleController = new RoleController();
            $roleController->addRoleForm();
        } elseif ($route === 'admin/roles/add' && $method === 'POST') {
            $roleController = new RoleController();
            $roleController->storeRole($_POST);
        } elseif ($route === 'admin/roles/edit' && $method === 'GET') {
            $roleController = new RoleController();
            $roleController->editRoleForm($_GET['id']);
        } elseif ($route === 'admin/roles/edit' && $method === 'POST') {
            $roleController = new RoleController();
            $roleController->updateRole($_POST);
        } elseif ($route === 'admin/roles/delete' && $method === 'GET') {
            $roleController = new RoleController();
            $roleController->deleteRole($_GET['id']);
        } elseif ($route === 'admin/comments/edit' && $method === 'GET') {
            $comment_controller = new CommentController();
            $comment_controller->editCommentForm((int)$_GET['id']);
        } elseif ($route === 'admin/comments/edit' && $method === 'POST') {
            $comment_controller = new CommentController();
            $comment_controller->updateComment($_POST);
        } elseif ($route === 'admin/comments/delete' && $method === 'GET') {
            $comment_controller = new CommentController();
            $comment_controller->deleteComment((int)$_GET['id']);
        } elseif ($route === 'register_page' && $method === 'GET') {
            $render_controller->registerPage();
        } elseif ($route === 'forgotten' && $method === 'GET') {
            $viewPath = __DIR__ . '/../Views/login/forgotten_password.php';
            renderSite($viewPath);
        } elseif ($route === 'forgotten' && $method === 'POST') {
            if (isset($_POST['email'], $_POST['password'])) {
                $loginController->resetPasswordSimple($_POST['email'], $_POST['password']);
            } else {
                header("Location: index.php?route=forgotten");
                exit;
            }
        } elseif ($route === 'activate_account' && $method === 'GET') {
            if (isset($_GET['token'])) {
                $registerController->activateAccount($_GET['token']);
            } else {
                echo "No activation token provided.";
            }
        } elseif ($route === 'reset_password_request' && $method === 'POST') {
            if (isset($_POST['email'])) {
                $loginController->resetPasswordRequest($_POST['email']);
            } else {
                echo "Email is required.";
            }
        } elseif ($route === 'reset_password' && $method === 'GET') {
            $viewPath = __DIR__ . '/../Views/login/reset_password.php';
            renderSite($viewPath);
        } elseif ($route === 'reset_password_confirm' && $method === 'POST') {
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
        } elseif ($route === 'logout_session' && $method === 'POST') {
            session_start();
            session_unset();
            session_destroy();
            http_response_code(200);
            exit;
        } elseif ($route === 'attachment/delete' && isset($_GET['attachment_id'], $_GET['ticket_id'])) {
            $controller = new TicketController();
            $controller->removeAttachment($_GET['attachment_id'], $_GET['ticket_id']);
            exit;
        } elseif ($route === 'attachment/preview' && isset($_GET['file'])) {
            $file_url = $_GET['file'];
            require 'Views/attachment/preview.php';
            exit;
        } else {
            echo "No matching route found.<br>";
        }
    }
}