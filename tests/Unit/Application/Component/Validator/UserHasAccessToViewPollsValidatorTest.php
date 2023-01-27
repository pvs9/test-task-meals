<?php

declare(strict_types=1);

namespace tests\Meals\Unit\Application\Component\Validator;

use Meals\Application\Component\Validator\Exception\AccessDeniedException;
use Meals\Application\Component\Validator\UserHasAccessToViewPollsValidator;
use Meals\Domain\User\Permission\Permission;
use Meals\Domain\User\Permission\PermissionList;
use Meals\Domain\User\User;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class UserHasAccessToViewPollsValidatorTest extends TestCase
{
    use ProphecyTrait;

    public function testSuccessful()
    {
        $permissionList = $this->prophesize(PermissionList::class);
        $permissionList->hasPermission(Permission::VIEW_ACTIVE_POLLS)->willReturn(true);

        $user = $this->prophesize(User::class);
        $user->getPermissions()->willReturn($permissionList->reveal());

        $validator = new UserHasAccessToViewPollsValidator();
        verify($validator->validate($user->reveal()))->null();
    }

    public function testFail()
    {
        $this->expectException(AccessDeniedException::class);

        $permissionList = $this->prophesize(PermissionList::class);
        $permissionList->hasPermission(Permission::VIEW_ACTIVE_POLLS)->willReturn(false);

        $user = $this->prophesize(User::class);
        $user->getPermissions()->willReturn($permissionList->reveal());

        $validator = new UserHasAccessToViewPollsValidator();
        $validator->validate($user->reveal());
    }
}
