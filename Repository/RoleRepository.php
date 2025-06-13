<?php

require_once __DIR__ . '/../Core/Data.php';
require_once __DIR__ . '/../Model/Role.php';
class RoleRepository
{
    private static ?RoleRepository $instance = null;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = connectToDB();
    }

    public static function getInstance(): RoleRepository {
        if (self::$instance === null) {
            self::$instance = new RoleRepository();
        }
        return self::$instance;
    }

    public function listRoles(): array
    {
        $stmt = $this->pdo->query('SELECT role_id, role FROM roles');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => Role::fromArray($row),$rows);
    }

    public function getRoles(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM roles ORDER BY role_id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoleById(int $id): Role
    {
        $stmt = $this->pdo->prepare("SELECT * FROM roles WHERE role_id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return Role::fromArray($data);
    }

    public function addRole(string $role): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO roles (role) VALUES (?)");
        $stmt->execute([$role]);
    }

    public function updateRole(int $role_id, string $role): void
    {
        $stmt = $this->pdo->prepare("UPDATE roles SET role = ? WHERE role_id = ?");
        $stmt->execute([$role, $role_id]);
    }

    public function deleteRole(int $role_id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM roles WHERE role_id = ?");
        $stmt->execute([$role_id]);
    }



}



