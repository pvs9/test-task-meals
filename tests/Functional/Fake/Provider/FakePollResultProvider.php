<?php

declare(strict_types=1);

namespace tests\Meals\Functional\Fake\Provider;

use Meals\Application\Component\Provider\PollResultProviderInterface;
use Meals\Domain\Employee\Employee;
use Meals\Domain\Poll\Poll;
use Meals\Domain\Poll\PollResult;

class FakePollResultProvider implements PollResultProviderInterface
{
    private ?PollResult $findOneByEmployeeAndPollResult;

    public function findOneByEmployeeAndPoll(Employee $employee, Poll $poll): ?PollResult
    {
        return $this->findOneByEmployeeAndPollResult;
    }

    public function setFindOneByEmployeeAndPoll(?PollResult $pollResult): void
    {
        $this->findOneByEmployeeAndPollResult = $pollResult;
    }

    public function getLastSavedId(): int
    {
        return 1;
    }

    public function savePollResult(PollResult $pollResult): PollResult
    {
        return $pollResult;
    }
}