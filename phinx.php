<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => getenv('MYSQL_HOST'),
            'name' => getenv('MYSQL_DATABASE'),
            'user' => getenv('MYSQL_USER'),
            'pass' => getenv('MYSQL_PASSWORD'),
            'port' => getenv('MYSQL_PORT'),
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => '172.21.0.2',//getenv('MYSQL_HOST'),
            'name' => 'alter-solutions', //getenv('MYSQL_DATABASE'),
            'user' => 'root', //getenv('MYSQL_USER'),
            'pass' => '201125', //getenv('MYSQL_PASSWORD'),
            'port' => '3306', //getenv('MYSQL_PORT'),
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => getenv('MYSQL_HOST'),
            'name' => getenv('MYSQL_DATABASE'),
            'user' => getenv('MYSQL_USER'),
            'pass' => getenv('MYSQL_PASSWORD'),
            'port' => getenv('MYSQL_PORT'),
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
