<?php

declare(strict_types=1);

namespace tests\Meals\Unit\Application\Component\Validator;

use Meals\Application\Component\Validator\Exception\PollParticipationUnavailableException;
use Meals\Application\Component\Validator\ItIsTimeToParticipateInPollValidator;
use PHPUnit\Framework\TestCase;
use SlopeIt\ClockMock\ClockMock;

class ItIsTimeToParticipateInPollValidatorTest extends TestCase
{
    protected function tearDown(): void
    {
        ClockMock::reset();
    }

    /**
     * @dataProvider successfulOnMondaysProvider
     */
    public function testSuccessfulOnlyOnMondays(\DateTime $time, bool $shouldPass): void
    {
        ClockMock::freeze($time);

        if (!$shouldPass) {
            $this->expectException(PollParticipationUnavailableException::class);
        }

        $validator = new ItIsTimeToParticipateInPollValidator();

        if ($shouldPass) {
            verify($validator->validate())->null();
        } else {
            $validator->validate();
        }
    }

    /**
     * @dataProvider successfulInTimeRangeProvider
     */
    public function testSuccessfulOnlyInTimeRange(\DateTime $time, bool $shouldPass): void
    {
        ClockMock::freeze($time);

        if (!$shouldPass) {
            $this->expectException(PollParticipationUnavailableException::class);
        }

        $validator = new ItIsTimeToParticipateInPollValidator();

        if ($shouldPass) {
            verify($validator->validate())->null();
        } else {
            $validator->validate();
        }
    }

    public function successfulOnMondaysProvider(): array
    {
        return [
            [new \DateTime('monday this week 22:00'), true],
            [new \DateTime('tuesday this week 22:00'), false],
            [new \DateTime('wednesday this week 22:00'), false],
            [new \DateTime('thursday this week 22:00'), false],
            [new \DateTime('friday this week 22:00'), false],
            [new \DateTime('saturday this week 22:00'), false],
            [new \DateTime('sunday this week 22:00'), false],
        ];
    }

    public function successfulInTimeRangeProvider(): array
    {
        return [
            [new \DateTime('monday this week 00:00'), false],
            [new \DateTime('monday this week 04:00'), false],
            [new \DateTime('monday this week 06:00'), true],
            [new \DateTime('monday this week 10:00'), true],
            [new \DateTime('monday this week 14:00'), true],
            [new \DateTime('monday this week 18:00'), true],
            [new \DateTime('monday this week 22:00'), true],
        ];
    }
}