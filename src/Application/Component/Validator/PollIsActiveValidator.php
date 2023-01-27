<?php

declare(strict_types=1);

namespace Meals\Application\Component\Validator;

use Meals\Application\Component\Validator\Exception\PollIsNotActiveException;
use Meals\Domain\Poll\Poll;

class PollIsActiveValidator
{
    public function validate(Poll $poll): void
    {
        if (!$poll->isActive()) {
            throw new PollIsNotActiveException();
        }
    }
}
