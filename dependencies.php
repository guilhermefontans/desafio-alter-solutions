<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        PDO::class => function (ContainerInterface $container) {
            $config = $container->get('settings')['db'];
            $conn = new \PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['user'], $config['password']);
            return $conn;
        }
    ]);
};
