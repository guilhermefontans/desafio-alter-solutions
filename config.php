<?php
declare(strict_types=1);

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'db' => [
                'host'     => getenv('MYSQL_HOST'),
                'dbname'   => getenv('MYSQL_DATABASE'),
                'user'     => getenv('MYSQL_USER'),
                'password' => getenv('MYSQL_PASSWORD'),
            ]
        ],
    ]);
};
