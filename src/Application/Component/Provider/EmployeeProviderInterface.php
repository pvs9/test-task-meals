<?php

declare(strict_types=1);

namespace Meals\Application\Component\Provider;

use Meals\Domain\Employee\Employee;

interface EmployeeProviderInterface
{
    public function getEmployee(int $employeeId): Employee;
}
