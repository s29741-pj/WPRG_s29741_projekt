<?php

class User
{
    public int $user_id;
    public int $account_type;
    public string $name;
    public string $surname;
    public string $email;

    public function __construct(int $user_id, int $account_type, string $name, string $surname, string $email)
    {
        $this->user_id = $user_id;
        $this->account_type = $account_type;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['user_id'], $data['account_type'], $data['name'], $data['surname'], $data['email']);
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function getAccountType(): int
    {
        return $this->account_type;
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
    public function setUserId(int $user_id){
        $this->user_id = $user_id;
    }
    public function setAccountType(int $account_type){
        $this->account_type = $account_type;
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
}