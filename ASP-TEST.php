<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use ASPTest\Command\CreateUserCommand;
use ASPTest\Command\CreateUserPWDCommand;
use ASPTest\Domain\Encrypt;
use ASPTest\Domain\Factory\UserFactory;
use ASPTest\Repository\UserRepository;
use DI\ContainerBuilder;
use Symfony\Component\Console\Application;

$containerBuilder = new ContainerBuilder();

// Set up settings
$config = require __DIR__ . '/config.php';
$config($containerBuilder);

// Set up settings
$settings = require __DIR__ . '/dependencies.php';
$settings($containerBuilder);

// Set up settings
$repositories = require __DIR__ . '/repositories.php';
$repositories($containerBuilder);

$container = $containerBuilder->build();
$application = new Application();

$application->add(new CreateUserCommand(
    $container->get(UserRepository::class),
    $container->get(UserFactory::class)
));
$application->add(new CreateUserPWDCommand(
    $container->get(UserRepository::class),
    $container->get(Encrypt::class)
));
$application->run();