<?php

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

    public function registerAction(string $email, string $password)
    {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch())
        {
            echo "Email jest już zarejestrowany.";
            exit;
        }
        // Hashuj hasło
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Zapisz do bazy
        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        if ($stmt->execute([$email, $hashed])) {
//            tu przekierowanie na login_page
        } else {
            echo "Błąd podczas rejestracji.";
//            tu przekierowanie na login_page
        }
    }

}