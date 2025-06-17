<?php

use FlashMsg\Msg;

class RegisterController
{
    private PDO $pdo;
    private Msg $msg;

    public function __construct()
    {
        $this->pdo = connectToDB();
        $this->msg = new Msg();
    }

    public function registerAction($name, $surname, $email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->execute([$email]);
        session_start();

        if ($stmt->fetch()) {
            $this->msg->set_flash('register_error', 'Email address already in use.');
            header("Location: index.php?route=register_page");
            exit;
        }
        $activation_token = bin2hex(random_bytes(32));
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("
            INSERT INTO users (role_id, name, surname, email, password, is_active, activation_token) 
            VALUES (?, ?, ?, ?, ?, 0, ?)
        ");
        if ($stmt->execute([4, $name, $surname, $email, $hashed_password, $activation_token])) {
            $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
                . "://{$_SERVER['HTTP_HOST']}/~s29741/ticketpro_app";
            $activation_link = "$baseUrl/index.php?route=activate_account&token=$activation_token";

            $subject = "Account Activation";
            $message = "Dear $name,\n\nPlease click the link below to activate your account:\n\n$activation_link\n\nBest regards,\nTicketPro Team";
            $headers = "From: no-reply@ticketpro.com";

            if (mail($email, $subject, $message, $headers)) {
                $this->msg->set_flash('register_success', 'Check your email for the activation link.');
            } else {
                var_dump("Failed to send activation email.");
                exit;
                $this->msg->set_flash('register_error', 'Failed to send activation email.');
            }
            header("Location: index.php?route=register_page");
            exit;
        } else {
            $this->msg->set_flash('register_error', 'Failed to register account.');
            var_dump("Failed to send activation email.");
            exit;
            header("Location: index.php?route=register_page");
            exit;
        }
    }

    public function activateAccount($token)
    {
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE activation_token = ? AND is_active = 0");
        $stmt->execute([$token]);

        $user = $stmt->fetch();
        if ($user) {
            $stmt = $this->pdo->prepare("UPDATE users SET is_active = 1, activation_token = NULL WHERE user_id = ?");
            if ($stmt->execute([$user['user_id']])) {
                $this->msg->set_flash('register_success', 'Your account has been activated. You can now log in.');
                header("Location: index.php?route=login_page");
                exit;
            }
        }

        $this->msg->set_flash('register_error', 'Invalid or expired activation link.');
        header("Location: index.php?route=register_page");
        exit;
    }
}