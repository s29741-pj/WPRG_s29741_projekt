<?php

use FlashMsg\msg;

require_once __DIR__ . '/../Flash/Msg.php';

class LoginController
{
    private static ?LoginController $instance = null;

    private PDO $pdo;
    private Msg $msg;


    public function __construct()
    {
        $this->pdo = connectToDB();
        $this->msg = Msg::getInstance();
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
        session_start();


        if ($user && password_verify($password, $user['password'])) {
            // Logowanie udane
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['account_type'] = $user['account_type'];
            $_SESSION['department'] = $user['department_id'];
            $this->msg->set_flash('login_success','Login successful.');
            header("Location: /ticketpro_app/ticket");
            exit;
        } else {
            $this->msg->set_flash('login_error','Incorrect login or password. Try again.');
            header("Location: /ticketpro_app/");
        }
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