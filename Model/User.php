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

}