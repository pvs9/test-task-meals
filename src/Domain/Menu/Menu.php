<?php

namespace Meals\Domain\Menu;

use Meals\Domain\Dish\DishList;

class Menu
{
    public function __construct(
        private int $id,
        private string $title,
        private DishList $dishes
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDishes(): DishList
    {
        return $this->dishes;
    }
}
