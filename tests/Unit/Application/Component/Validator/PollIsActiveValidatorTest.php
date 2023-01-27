<?php

declare(strict_types=1);

namespace tests\Meals\Unit\Application\Component\Validator;

use Meals\Application\Component\Validator\Exception\PollIsNotActiveException;
use Meals\Application\Component\Validator\PollIsActiveValidator;
use Meals\Domain\Poll\Poll;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class PollIsActiveValidatorTest extends TestCase
{
    use ProphecyTrait;

    public function testSuccessful()
    {
        $poll = $this->prophesize(Poll::class);
        $poll->isActive()->willReturn(true);

        $validator = new PollIsActiveValidator();
        verify($validator->validate($poll->reveal()))->null();
    }

    public function testFail()
    {
        $this->expectException(PollIsNotActiveException::class);

        $poll = $this->prophesize(Poll::class);
        $poll->isActive()->willReturn(false);

        $validator = new PollIsActiveValidator();
        $validator->validate($poll->reveal());
    }
}