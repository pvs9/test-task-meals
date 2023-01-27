<?php

declare(strict_types=1);

namespace Meals\Application\Component\Provider;

use Meals\Domain\Employee\Employee;
use Meals\Domain\Poll\Poll;
use Meals\Domain\Poll\PollResult;

interface PollResultProviderInterface
{
    public function findOneByEmployeeAndPoll(Employee $employee, Poll $poll): ?PollResult;

    public function getLastSavedId(): int;

    public function savePollResult(PollResult $pollResult): PollResult;
}