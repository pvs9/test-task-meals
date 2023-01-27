<?php

declare(strict_types=1);

namespace Meals\Application\Component\Validator;

use Meals\Application\Component\Validator\Exception\PollParticipationUnavailableException;

class ItIsTimeToParticipateInPollValidator
{
    public function validate(): void
    {
        $time = localtime(null, true);

        if (
            $time['tm_wday'] !== 1 ||
            $time['tm_hour'] < 6 ||
            $time['tm_hour'] > 22
        ) {
            throw new PollParticipationUnavailableException();
        }
    }
}