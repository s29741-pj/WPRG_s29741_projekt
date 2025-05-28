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

    public function getDepartments(): array
    {
        $stmt = $this->pdo->query("
            SELECT
                department_id,
                user_id,
                department_name
            FROM Departments
            Order by department_id;
            ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => Department::fromArray($row), $rows);

    }
}