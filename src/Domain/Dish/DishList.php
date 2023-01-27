<?php

declare(strict_types=1);

namespace Meals\Domain\Dish;

use Assert\Assertion;

class DishList
{
    /**
     * @param Dish[] $dishes
     */
    public function __construct(private array $dishes)
    {
        Assertion::allIsInstanceOf($dishes, Dish::class);
    }

    /**
     * @return Dish[]
     */
    public function getDishes(): array
    {
        return $this->dishes;
    }

    public function hasDish(Dish $needle): bool
    {
        foreach ($this->dishes as $dish) {
            if ($dish->getId() === $needle->getId()) {
                return true;
            }
        }

        return false;
    }
}
