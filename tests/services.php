<?php

declare(strict_types=1);

namespace tests\Meals;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $configurator) {

    $services = $configurator->services()
        ->defaults()
        ->public()
        ->autowire()
        ->autoconfigure()
    ;

    $services->load('Meals\\Application\\', '../src/Application/*');
    $services->load('tests\\Meals\\Functional\\Fake\\', '../tests/Functional/Fake/*');
};
