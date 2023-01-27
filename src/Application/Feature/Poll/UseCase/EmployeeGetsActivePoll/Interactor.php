<?php

declare(strict_types=1);

namespace Meals\Application\Feature\Poll\UseCase\EmployeeGetsActivePoll;

use Meals\Application\Component\Provider\EmployeeProviderInterface;
use Meals\Application\Component\Provider\PollProviderInterface;
use Meals\Application\Component\Validator\PollIsActiveValidator;
use Meals\Application\Component\Validator\UserHasAccessToViewPollsValidator;
use Meals\Domain\Poll\Poll;

class Interactor
{
    public function __construct(
        private EmployeeProviderInterface $employeeProvider,
        private PollProviderInterface $pollProvider,
        private UserHasAccessToViewPollsValidator $userHasAccessToPollsValidator,
        private PollIsActiveValidator $pollIsActiveValidator
    ) {}

    public function getActivePoll(int $employeeId, int $pollId): Poll
    {
        $employee = $this->employeeProvider->getEmployee($employeeId);
        $poll = $this->pollProvider->getPoll($pollId);

        $this->userHasAccessToPollsValidator->validate($employee->getUser());

        $this->pollIsActiveValidator->validate($poll);

        return $poll;
    }
}
