<?php

use FlashMsg\Msg;

require_once __DIR__ . '/../Flash/Msg.php';
require_once __DIR__ . '/../Repository/RoleRepository.php';

class LoginController
{
    private PDO $pdo;
    private Msg $msg;

    private  RoleRepository $roleRepository;


    public function __construct()
    {
        $this->pdo = connectToDB();
        $this->msg = new Msg();
        $this->roleRepository = RoleRepository::getInstance();
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

    public function resetPasswordRequest($email)
    {
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {

            $reset_token = bin2hex(random_bytes(32));
            $token_expiry = (new DateTime())->modify('+1 hour')->format('Y-m-d H:i:s');


            $stmt = $this->pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE user_id = ?");
            $stmt->execute([$reset_token, $token_expiry, $user['user_id']]);


            $reset_link = "http://$_SERVER[HTTP_HOST]/ticketpro_app/reset_password?token=$reset_token";


            $subject = "Password Reset Request";
            $message = "We received a request to reset your password.\n\nClick the link below to reset your password:\n\n$reset_link\n\nIf you didn't request this, ignore this email.";
            $headers = "From: no-reply@ticketpro.com";

            if (mail($email, $subject, $message, $headers)) {
                $this->msg->set_flash('reset_success', 'We have sent you an email with a password reset link.');
            } else {
                $this->msg->set_flash('reset_error', 'Failed to send reset email. Try again later.');
            }
        } else {
            $this->msg->set_flash('reset_error', 'No account found with this email.');
        }

        header("Location: /ticketpro_app/forgotten");
        exit;
    }

    public function resetPassword($token, $password)
    {

        $stmt = $this->pdo->prepare("
        SELECT user_id, reset_token_expiry FROM users 
        WHERE reset_token = ? AND reset_token_expiry > NOW()
    ");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE user_id = ?");
            $stmt->execute([$hashed_password, $user['user_id']]);

            $this->msg->set_flash('reset_success', 'Your password has been reset. You can now log in.');
            header("Location: /ticketpro_app/");
            exit;
        } else {
            $this->msg->set_flash('reset_error', 'Invalid or expired reset token.');
            header("Location: /ticketpro_app/forgotten");
            exit;
        }
    }



}