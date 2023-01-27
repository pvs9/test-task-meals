<?php

declare(strict_types=1);

namespace Meals\Application\Component\Validator;

use Meals\Application\Component\Validator\Exception\PollHasNoSuchDishException;
use Meals\Domain\Dish\Dish;
use Meals\Domain\Poll\Poll;

class PollHasSuchDishValidator
{
    public function validate(Poll $poll, Dish $dish): void
    {
        if (!$poll->getMenu()->getDishes()->hasDish($dish)) {
            throw new PollHasNoSuchDishException();
        }
    }
}