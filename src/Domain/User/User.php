<?php

declare(strict_types=1);

namespace Meals\Domain\User;

use Meals\Domain\User\Permission\Permission;
use Meals\Domain\User\Permission\PermissionList;

class User
{
    public function __construct(private int $id, private PermissionList $permissions)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPermissions(): PermissionList
    {
        return $this->permissions;
    }
}
