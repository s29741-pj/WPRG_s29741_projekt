<?php
use FlashMsg\msg;

class RegisterController
{
    private static ?RegisterController $instance = null;

    private PDO $pdo;
    private Msg $msg;

    public function __construct()
    {
        $this->pdo = connectToDB();
        $this->msg = Msg::getInstance();
    }

    public static function getInstance(): RegisterController {
        if (self::$instance === null) {
            self::$instance = new RegisterController();
        }
        return self::$instance;
    }

    public function registerAction($name, $surname, $email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->execute([$email]);
        session_start();

        if ($stmt->fetch())
        {
            $this->msg->set_flash('register_error','Email address already in use.');
            header("Location: /ticketpro_app/register_page");
            exit;
        }
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO users (account_type, name, surname, email, password) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([3,$name,$surname,$email, $hashed])) {
            $this->msg->set_flash('register_success','Sign up successful.');
            header("Location: /ticketpro_app/ticket");
            exit;
        } else {

            $this->msg->set_flash('register_error','Incorrect login or password. Try again.');
            header("Location: /ticketpro_app/register_page");
            exit;
        }
    }

}