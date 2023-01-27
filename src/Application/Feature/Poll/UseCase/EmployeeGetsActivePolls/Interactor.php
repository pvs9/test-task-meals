<?php

declare(strict_types=1);

namespace Meals\Application\Feature\Poll\UseCase\EmployeeGetsActivePolls;

use Meals\Application\Component\Provider\PollProviderInterface;
use Meals\Application\Component\Provider\EmployeeProviderInterface;
use Meals\Application\Component\Validator\UserHasAccessToViewPollsValidator;
use Meals\Domain\Poll\PollList;

class Interactor
{
    public function __construct(
        private EmployeeProviderInterface $employeeProvider,
        private PollProviderInterface $pollProvider,
        private UserHasAccessToViewPollsValidator $userHasAccessToPollsValidator
    ) {}

    public function getActivePolls(int $employeeId): PollList
    {
        $employee = $this->employeeProvider->getEmployee($employeeId);

        $this->userHasAccessToPollsValidator->validate($employee->getUser());

        return $this->pollProvider->getActivePolls();
    }
}
