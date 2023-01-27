<?php

namespace tests\Meals\Functional\Fake\Provider;

use Meals\Application\Component\Provider\DishProviderInterface;
use Meals\Domain\Dish\Dish;

class FakeDishProvider implements DishProviderInterface
{
    private Dish $dish;

    public function getDish(int $dishId): Dish
    {
        return $this->dish;
    }

    public function setDish(Dish $dish)
    {
        $this->dish = $dish;
    }
}