<?php

declare(strict_types=1);

namespace Meals\Application\Component\Provider;

use Meals\Domain\Dish\Dish;
use Meals\Domain\Employee\Employee;
use Meals\Domain\Poll\Poll;
use Meals\Domain\Poll\PollList;
use Meals\Domain\Poll\PollResult;

interface PollProviderInterface
{
    public function getActivePolls(): PollList;

    public function getPoll(int $pollId): Poll;
}
