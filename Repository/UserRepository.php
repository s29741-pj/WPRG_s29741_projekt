<?php

require_once __DIR__ . '/../Core/Data.php';
require_once __DIR__ . '/../Model/User.php';

class UserRepository
{
    private static ?UserRepository $instance = null;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = connectToDB();
    }

    public static function getInstance(): UserRepository {
        if (self::$instance === null) {
            self::$instance = new UserRepository();
        }
        return self::$instance;
    }

    public function getUsers(): array
    {
        $stmt = $this->pdo->query("
            SELECT
                user_id,
                account_type,
                name,
                surname,
                email
            FROM Users
            Order by user_id;
            ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => User::fromArray($row), $rows);

    }


}