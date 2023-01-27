<?php

namespace Meals\Domain\Poll;

use Assert\Assertion;

class PollList
{
    /**
     * @param Poll[] $polls
     */
    public function __construct(private array $polls)
    {
        Assertion::allIsInstanceOf($polls, Poll::class);
    }

    /**
     * @return Poll[]
     */
    public function getPolls(): array
    {
        return $this->polls;
    }
}
