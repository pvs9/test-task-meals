<?php

declare(strict_types=1);

namespace Meals\Domain\User\Permission;

use MyCLabs\Enum\Enum;

class Permission extends Enum
{
    public const VIEW_ACTIVE_POLLS = 'viewActivePolls'; // возможность видеть активные опросы
    public const PARTICIPATION_IN_POLLS = 'participationInPolls'; // возможность участвовать в опросах
}
