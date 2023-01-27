<?php

declare(strict_types=1);

namespace tests\Meals\Functional;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class StaticContainer
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
