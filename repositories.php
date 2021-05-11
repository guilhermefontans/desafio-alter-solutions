<?php
declare(strict_types=1);

use ASPTest\Repository\UserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(UserRepository::class),
    ]);
};
