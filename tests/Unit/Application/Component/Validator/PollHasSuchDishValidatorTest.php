<?php

declare(strict_types=1);

namespace tests\Meals\Unit\Application\Component\Validator;

use Meals\Application\Component\Validator\Exception\AccessDeniedException;
use Meals\Application\Component\Validator\Exception\PollHasNoSuchDishException;
use Meals\Application\Component\Validator\PollHasSuchDishValidator;
use Meals\Application\Component\Validator\UserHasAccessToParticipateInPollsValidator;
use Meals\Domain\Dish\Dish;
use Meals\Domain\Dish\DishList;
use Meals\Domain\Menu\Menu;
use Meals\Domain\Poll\Poll;
use Meals\Domain\User\Permission\Permission;
use Meals\Domain\User\Permission\PermissionList;
use Meals\Domain\User\User;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class PollHasSuchDishValidatorTest extends TestCase
{
    use ProphecyTrait;

    public function testSuccessful()
    {
        $dish = $this->prophesize(Dish::class);

        $dishList = $this->prophesize(DishList::class);
        $dishList->hasDish($dish->reveal())->willReturn(true);

        $menu = $this->prophesize(Menu::class);
        $menu->getDishes()->willReturn($dishList->reveal());

        $poll = $this->prophesize(Poll::class);
        $poll->getMenu()->willReturn($menu->reveal());

        $validator = new PollHasSuchDishValidator();
        verify($validator->validate($poll->reveal(), $dish->reveal()))->null();
    }

    public function testFail()
    {
        $this->expectException(PollHasNoSuchDishException::class);

        $dish = $this->prophesize(Dish::class);

        $dishList = $this->prophesize(DishList::class);
        $dishList->hasDish($dish->reveal())->willReturn(false);

        $menu = $this->prophesize(Menu::class);
        $menu->getDishes()->willReturn($dishList->reveal());

        $poll = $this->prophesize(Poll::class);
        $poll->getMenu()->willReturn($menu->reveal());

        $validator = new PollHasSuchDishValidator();
        $validator->validate($poll->reveal(), $dish->reveal());
    }
}