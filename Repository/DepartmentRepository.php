<?php

require_once __DIR__ . '/../Core/Data.php';
require_once __DIR__ . '/../Model/Department.php';

class DepartmentRepository
{
    private static ?DepartmentRepository $instance = null;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = connectToDB();
    }

    public static function getInstance(): DepartmentRepository {
        if (self::$instance === null) {
            self::$instance = new DepartmentRepository();
        }
        return self::$instance;
    }

    public function listDepartments(): array
    {
        $stmt = $this->pdo->query("
            SELECT
                department_id,
                department_name,
                department_head
            FROM Departments
            Order by department_id;
            ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => Department::fromArray($row), $rows);

    }

    public function addDepartment(string $department_name, int $department_head): void
    {
        $stmt = $this->pdo->prepare("
        INSERT INTO Departments (department_name, department_head)
        VALUES (?, ?)
    ");
        $stmt->execute([$department_name, $department_head]);
    }

    public function getDepartmentById(?int $department_id): ?Department
    {
        $stmt = $this->pdo->prepare("
        SELECT
            department_id,
            department_name,
            department_head
        FROM Departments
        WHERE department_id = ?
    ");
        $stmt->execute([$department_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Jeśli nie znaleziono działu, zwróć null
        if (!$row) {
            return null;
        }

        // Zwróć obiekt Department
        return Department::fromArray($row);
    }

    public function updateDepartment(int $department_id, string $department_name, int $department_head): void
    {
        $stmt = $this->pdo->prepare("
        UPDATE Departments 
        SET department_name = ?, department_head = ?
        WHERE department_id = ?
    ");
        $stmt->execute([$department_name, $department_head, $department_id]);
    }

    public function deleteDepartment(int $department_id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM Departments WHERE department_id = ?");
        $stmt->execute([$department_id]);
    }
}