<?php
declare(strict_types=1);

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'db' => [
                'driver' => 'pdo_mysql',
                'host' => '172.21.0.2',// getenv('MYSQL_HOST'),
                'dbname' => 'alter-solutions',//getenv('MYSQL_DATABASE'),
                'user' => 'root', //getenv('MYSQL_USER'),
                'password' => '201125', //getenv('MYSQL_PASSWORD'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'driverOptions' => [
                    // Turn off persistent connections
                    PDO::ATTR_PERSISTENT => false,
                    // Enable exceptions
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // Emulate prepared statements
                    PDO::ATTR_EMULATE_PREPARES => true,
                    // Set default fetch mode to array
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ],
            ]
        ],
    ]);
};