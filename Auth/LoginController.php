<?php

use FlashMsg\msg;

require_once __DIR__ . '/../Flash/Msg.php';
require_once __DIR__ . '/../Repository/RoleRepository.php';

class LoginController
{
    private static ?LoginController $instance = null;

    private PDO $pdo;
    private Msg $msg;

    private  RoleRepository $roleRepository;


    public function __construct()
    {
        $this->pdo = connectToDB();
        $this->msg = Msg::getInstance();
        $this->roleRepository = RoleRepository::getInstance();
    }

    public static function getInstance(): LoginController {
        if (self::$instance === null) {
            self::$instance = new LoginController();
        }
        return self::$instance;
    }


    public function loginAction($email, $password): void {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
//        var_dump($user);
//        exit;
        session_start();


        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['department_id'] = $user['department_id'];
            $this->msg->set_flash('login_success','Login successful.');
//            exit(var_dump($_SESSION['user_id']));
            header("Location: /ticketpro_app/ticket");
            exit;
        } else {
            $this->msg->set_flash('login_error','Incorrect login or password. Try again.');
            header("Location: /ticketpro_app/");
        }
    }

    public function loginAsGuest(): void {
        $roles = $this->roleRepository->listRoles();
        session_start();
        $_SESSION['role_id'] = $roles[3]->getRoleId();
        header("Location: /ticketpro_app/ticket");
        exit;
    }

    function is_logged_in(): bool {
        return isset($_SESSION['user_id']);
    }

    function is_admin(): bool {
        return ($_SESSION['role'] ?? '') === 'admin';
    }

    function is_owner(): bool {
        return ($_SESSION['role'] ?? '') === 'owner';
    }

    function is_user(): bool {
        return ($_SESSION['role'] ?? '') === 'user';
    }

    function is_guest(): bool {
        return ($_SESSION['role'] ?? '') === 'guest';
    }





}