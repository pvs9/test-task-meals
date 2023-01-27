<?php

declare(strict_types=1);

namespace Meals\Application\Feature\Poll\UseCase\EmployeeParticipatesInPoll;

use Meals\Application\Component\Provider\DishProviderInterface;
use Meals\Application\Component\Provider\EmployeeProviderInterface;
use Meals\Application\Component\Provider\PollProviderInterface;
use Meals\Application\Component\Provider\PollResultProviderInterface;
use Meals\Application\Component\Validator\ItIsTimeToParticipateInPollValidator;
use Meals\Application\Component\Validator\PollHasSuchDishValidator;
use Meals\Application\Component\Validator\PollIsActiveValidator;
use Meals\Application\Component\Validator\UserHasAccessToParticipateInPollsValidator;
use Meals\Application\Feature\Poll\UseCase\EmployeeParticipatesInPoll\Exception\EmployeeAlreadyParticipatedInPollException;
use Meals\Domain\Poll\PollResult;

class Interactor
{
    public function __construct(
        private EmployeeProviderInterface $employeeProvider,
        private PollProviderInterface $pollProvider,
        private PollResultProviderInterface $pollResultProvider,
        private DishProviderInterface $dishProvider,
        private UserHasAccessToParticipateInPollsValidator $userHasAccessToParticipateInPollsValidator,
        private PollIsActiveValidator $pollIsActiveValidator,
        private PollHasSuchDishValidator $pollHasSuchDishValidator,
        private ItIsTimeToParticipateInPollValidator $timeToParticipateInPollValidator
    ) {}

    public function participateInPoll(int $employeeId, int $pollId, int $dishId): PollResult
    {
        $employee = $this->employeeProvider->getEmployee($employeeId);
        $poll = $this->pollProvider->getPoll($pollId);
        $dish = $this->dishProvider->getDish($dishId);

        $this->userHasAccessToParticipateInPollsValidator->validate($employee->getUser());

        $this->pollIsActiveValidator->validate($poll);
        $this->timeToParticipateInPollValidator->validate();
        $this->pollHasSuchDishValidator->validate($poll, $dish);

        $existingPollResult = $this->pollResultProvider->findOneByEmployeeAndPoll(
            $employee,
            $poll
        );

        if (!is_null($existingPollResult)) {
            throw new EmployeeAlreadyParticipatedInPollException();
        }

        $newId = $this->pollResultProvider->getLastSavedId() + 1;
        $pollResult = new PollResult(
            $newId,
            $poll,
            $employee,
            $dish,
            $employee->getFloor()
        );

        return $this->pollResultProvider->savePollResult($pollResult);
    }
}