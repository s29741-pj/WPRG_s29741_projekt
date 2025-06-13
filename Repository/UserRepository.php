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

    public function listUsers(): array
    {
        $stmt = $this->pdo->query("
            SELECT
                user_id,
                role_id,
                name,
                surname,
                email,
                department_id
            FROM Users
            Order by user_id;
            ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => User::fromArray($row), $rows);

    }

    public function getUserDepartment(int $user_id) {
        $stmt = $this->pdo->query("
            SELECT
                department_id
            FROM users
            WHERE user_id = $user_id
        ");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['department_id'];
    }


    public function getUserIdByEmail($email){
        $stmt = $this->pdo->query("
            SELECT
                user_id,
            FROM Users
            WHERE email = '$email'
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsers(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY user_id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUser(int $user_id, int $role_id, string $name, string $surname, string $email, int $department_id): void
    {
        $stmt = $this->pdo->prepare("
        UPDATE users 
        SET role_id = ?, name = ?, surname = ?, email = ?, department_id = ?
        WHERE user_id = ?
    ");
        $stmt->execute([$role_id, $name, $surname, $email, $department_id, $user_id]);
    }

    public function deleteUser(int $user_id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
    }

    public function getUserById(int $id): User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new Exception("User not found.");
        }

        return User::fromArray($data);
    }


}