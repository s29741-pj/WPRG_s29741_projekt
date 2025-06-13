<?php

class User
{
    private int $user_id;
    private int $role_id;
    private string $name;
    private string $surname;
    private string $email;
    private ?int $department_id;

    public function __construct(int $user_id, int $role_id, string $name, string $surname, string $email, ?int $department_id)
    {
        $this->user_id = $user_id;
        $this->role_id = $role_id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->department_id = $department_id;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['user_id'], $data['role_id'], $data['name'], $data['surname'], $data['email'], isset($data['department_id']) ? (int)$data['department_id'] : null
        );
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function getAccountType(): int
    {
        return $this->role_id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getSurname(): string
    {
        return $this->surname;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUserRole(){
        return $this->role_id;
    }
    public function setUserId(int $user_id){
        $this->user_id = $user_id;
    }
    public function assignRole(int $role_id){
        $this->role_id = $role_id;
    }
    public function setName(string $name){
        $this->name = $name;
    }
    public function setSurname(string $surname){
        $this->surname = $surname;
    }
    public function setEmail(string $email){
        $this->email = $email;
    }

    public function getUserDepartment(): ?int
    {
        return $this->department_id;
    }


}