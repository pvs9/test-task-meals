<?php

declare(strict_types=1);

namespace Meals\Domain\Dish;

class Dish
{
    public function __construct(
        private int $id,
        private string $title,
        private string $description
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
