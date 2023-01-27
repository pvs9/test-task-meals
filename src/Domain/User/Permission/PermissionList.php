<?php

declare(strict_types=1);

namespace Meals\Domain\User\Permission;

use Assert\Assertion;

class PermissionList
{
    /**
     * @param Permission[] $permissions
     */
    public function __construct(private array $permissions)
    {
        Assertion::allIsInstanceOf($permissions, Permission::class);
    }

    /**
     * @return Permission[]
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function hasPermission(Permission $needle): bool
    {
        return in_array($needle, $this->getPermissions());
    }
}
