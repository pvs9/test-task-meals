<?php

declare(strict_types=1);

namespace tests\Meals\Functional;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FunctionalTestCase extends TestCase
{
    private static ContainerBuilder $container;

    public static function setContainer(ContainerBuilder $container)
    {
        self::$container = $container;
    }

    public function getContainer(): ContainerBuilder
    {
        return self::$container;
    }
}
