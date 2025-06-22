<?php
class Department
{
    private int $department_id;
    private string $department_name;
    private int $department_head;

    public function __construct(int $department_id, int $department_head, string $department_name)
    {
        $this->department_id = $department_id;
        $this->department_head = $department_head;
        $this->department_name = $department_name;
    }

    public static function fromArray(array $row): Department
    {
        $id = isset($row['department_id']) && $row['department_id'] !== null ? (int)$row['department_id'] : 0;
        $head = isset($row['department_head']) && $row['department_head'] !== null ? (int)$row['department_head'] : 0;
        $name = $row['department_name'] ?? '';
        return new Department($id, $head, $name);
    }

    public function getDepartmentId(): int
    {
        return $this->department_id;
    }

    public function getDepartmentHead(): int
    {
        return $this->department_head;
    }

    public function getDepartmentName(): string
    {
        return $this->department_name;
    }

    public function setDepartmentId(int $department_id): void
    {
        $this->department_id = $department_id;
    }

    public function setDepartmentHead(int $department_head): void
    {
        $this->department_head = $department_head;
    }

    public function setDepartmentName(string $department_name): void
    {
        $this->department_name = $department_name;
    }
}