<?php
class Department
{
    private int $department_id;
    private int $user_id;
    private string $department_name;

    private function __construct (int $department_id, int $user_id, string $department_name)
    {
        $this->department_id = $department_id;
        $this->user_id = $user_id;
        $this->department_name = $department_name;
    }
    public static function fromArray(array $data): self
    {
        return new self($data['department_id'], $data['user_id'], $data['department_name']);
    }

    public function getDepartmentId(): int
    {
        return $this->department_id;
    }
    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function getDepartmentName(): string
    {
        return $this->department_name;
    }

    public function setDepartmentId(int $department_id){
        $this->department_id = $department_id;
    }
    public function setUserId(int $user_id){
        $this->user_id = $user_id;
    }
    public function setDepartmentName(string $department_name){
        $this->department_name = $department_name;
    }

}