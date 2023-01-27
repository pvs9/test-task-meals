<?php

declare(strict_types=1);

namespace tests\Meals\Functional\Interactor;

use Meals\Application\Component\Validator\Exception\AccessDeniedException;
use Meals\Application\Component\Validator\Exception\PollHasNoSuchDishException;
use Meals\Application\Component\Validator\Exception\PollIsNotActiveException;
use Meals\Application\Component\Validator\Exception\PollParticipationUnavailableException;
use Meals\Application\Feature\Poll\UseCase\EmployeeParticipatesInPoll\Exception\EmployeeAlreadyParticipatedInPollException;
use Meals\Application\Feature\Poll\UseCase\EmployeeParticipatesInPoll\Interactor;
use Meals\Domain\Dish\Dish;
use Meals\Domain\Dish\DishList;
use Meals\Domain\Employee\Employee;
use Meals\Domain\Menu\Menu;
use Meals\Domain\Poll\Poll;
use Meals\Domain\Poll\PollResult;
use Meals\Domain\User\Permission\Permission;
use Meals\Domain\User\Permission\PermissionList;
use Meals\Domain\User\User;
use SlopeIt\ClockMock\ClockMock;
use tests\Meals\Functional\Fake\Provider\FakeDishProvider;
use tests\Meals\Functional\Fake\Provider\FakeEmployeeProvider;
use tests\Meals\Functional\Fake\Provider\FakePollProvider;
use tests\Meals\Functional\Fake\Provider\FakePollResultProvider;
use tests\Meals\Functional\FunctionalTestCase;

class EmployeeParticipatesInPollTest extends FunctionalTestCase
{
    protected function tearDown(): void
    {
        ClockMock::reset();
    }

    public function testSuccessful()
    {
        $dish = $this->getDish();
        $poll = $this->performTestMethod(
            $this->getEmployeeWithPermissions(),
            $this->getPollWithDish($dish,true, true),
            $dish,
            null
        );

        verify($poll)->equals($poll);
    }

    public function testEmployeeAlreadyParticipatedInPoll()
    {
        $this->expectException(EmployeeAlreadyParticipatedInPollException::class);

        $employee = $this->getEmployeeWithPermissions();
        $dish = $this->getDish();
        $poll = $this->getPollWithDish($dish,true, true);

        $pollResult = $this->performTestMethod(
            $employee,
            $poll,
            $dish,
            $this->getPollResult($employee, $poll, $dish)
        );
        verify($pollResult)->equals($pollResult);
    }

    public function testTimeIsNotInRange(): void
    {
        $this->expectException(PollParticipationUnavailableException::class);

        $dish = $this->getDish();
        $poll = $this->performTestMethod(
            $this->getEmployeeWithPermissions(),
            $this->getPollWithDish($dish,true, false),
            $dish,
            null
        );

        verify($poll)->equals($poll);
    }

    public function testDishIsNotInPoll(): void
    {
        $this->expectException(PollHasNoSuchDishException::class);

        $dish = $this->getDish();
        $poll = $this->performTestMethod(
            $this->getEmployeeWithPermissions(),
            $this->getPoll(true, true),
            $dish,
            null
        );

        verify($poll)->equals($poll);
    }

    public function testUserHasNoPermissions(): void
    {
        $this->expectException(AccessDeniedException::class);

        $dish = $this->getDish();
        $poll = $this->performTestMethod(
            $this->getEmployeeWithNoPermissions(),
            $this->getPollWithDish($dish, true, true),
            $dish,
            null
        );

        verify($poll)->equals($poll);
    }

    public function testPollIsNotActive(): void
    {
        $this->expectException(PollIsNotActiveException::class);

        $dish = $this->getDish();
        $poll = $this->performTestMethod(
            $this->getEmployeeWithPermissions(),
            $this->getPollWithDish($dish, false, true),
            $dish,
            null
        );

        verify($poll)->equals($poll);
    }

    private function performTestMethod(Employee $employee, Poll $poll, Dish $dish, ?PollResult $existingPollResult): PollResult
    {
        $this->getContainer()->get(FakeEmployeeProvider::class)->setEmployee($employee);
        $this->getContainer()->get(FakePollProvider::class)->setPoll($poll);
        $this->getContainer()->get(FakeDishProvider::class)->setDish($dish);
        $this->getContainer()->get(FakePollResultProvider::class)
            ->setFindOneByEmployeeAndPoll($existingPollResult);

        return $this->getContainer()
            ->get(Interactor::class)
            ->participateInPoll($employee->getId(), $poll->getId(), $dish->getId());
    }

    private function getEmployeeWithPermissions(): Employee
    {
        return new Employee(
            1,
            $this->getUserWithPermissions(),
            4,
            'Surname'
        );
    }

    private function getUserWithPermissions(): User
    {
        return new User(
            1,
            new PermissionList(
                [
                    new Permission(Permission::PARTICIPATION_IN_POLLS),
                ]
            ),
        );
    }

    private function getEmployeeWithNoPermissions(): Employee
    {
        return new Employee(
            1,
            $this->getUserWithNoPermissions(),
            4,
            'Surname'
        );
    }

    private function getUserWithNoPermissions(): User
    {
        return new User(
            1,
            new PermissionList([]),
        );
    }

    private function getPoll(bool $active, bool $correctTime): Poll
    {
        $this->setParticipationTime($correctTime);

        return new Poll(
            1,
            $active,
            new Menu(
                1,
                'title',
                new DishList([]),
            )
        );
    }

    private function getPollWithDish(Dish $dish, bool $active, bool $correctTime): Poll
    {
        $this->setParticipationTime($correctTime);

        return new Poll(
            1,
            $active,
            new Menu(
                1,
                'title',
                new DishList(
                    [
                        $dish,
                    ]
                ),
            )
        );
    }

    private function getPollResult(Employee $employee, Poll $poll, Dish $dish): PollResult
    {
        return new PollResult(
            1,
            $poll,
            $employee,
            $dish,
            $employee->getFloor()
        );
    }

    private function getDish(): Dish
    {
        return new Dish(
          1,
          'Title',
          'Description'
        );
    }

    private function setParticipationTime(bool $correct)
    {
        if ($correct) {
            ClockMock::freeze(new \DateTime('monday this week 22:00'));
        } else {
            ClockMock::freeze(new \DateTime('monday this week 23:00'));
        }
    }
}