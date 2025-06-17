<?php

class Role
{
    private int $role_id;
    private string $role;

    public function __construct(int $role_id, string $role)
    {
        $this->role_id = $role_id;
        $this->role = $role;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['role_id'], $data['role']);
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRoleId(int $role_id): void
    {
        $this->role_id = $role_id;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }
}