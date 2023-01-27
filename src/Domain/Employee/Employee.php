<?php

declare(strict_types=1);

namespace Meals\Domain\Employee;

use Meals\Domain\User\User;

class Employee
{
    public function __construct(
        private int $id,
        private User $user,
        private int $floor,
        private string $surname
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getFloor(): int
    {
        return $this->floor;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }
}
