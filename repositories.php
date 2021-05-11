<?php
declare(strict_types=1);

use ASPTest\Domain\Factory\UserFactory;
use ASPTest\Repository\UserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(UserRepository::class),
        UserFactory::class => \DI\autowire(UserFactory::class),
    ]);
};
