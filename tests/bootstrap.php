<?php

declare(strict_types=1);

namespace tests\Meals;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use tests\Meals\Functional\FunctionalTestCase;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$loader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__));
$loader->load('services.php');
$containerBuilder->compile();
FunctionalTestCase::setContainer($containerBuilder);
