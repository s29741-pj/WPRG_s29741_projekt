<?php

class Department
{
    public int $department_id;
    public int $user_id;
    public string $department_name;

    public function __construct (int $department_id, int $user_id, string $department_name)
    {
        $this->department_id = $department_id;
        $this->user_id = $user_id;
        $this->department_name = $department_name;
    }

}