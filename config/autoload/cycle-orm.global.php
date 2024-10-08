<?php

declare(strict_types=1);

use Cycle\Database\Config;
use Sirix\Cycle\Enum\SchemaProperty;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

return [
    'cycle' => [
        'default' => 'default',
        'databases' => [
            'default' => [
                'connection' => 'postgres',
            ]
        ],
        'connections' => [
            'postgres' => new Config\PostgresDriverConfig(
                connection: new Config\Postgres\TcpConnectionConfig(
                    database: $_ENV['DB_DATABASE'],
                    host: $_ENV['DB_HOST'],
                    port: $_ENV['DB_PORT'],
                    user: $_ENV['DB_USERNAME'],
                    password: $_ENV['DB_PASSWORD'],
                ),
                schema: 'public',
                queryCache: true,
            )
        ],
    ],
    'migrator' => [
        'directory' => (__DIR__ . '/../../data/migrations'),
        'table' => 'migrations'
    ],
    'entities' => [
        (__DIR__ . '/../../src/Person/src/Model'),
        (__DIR__ . '/../../src/Library/src/Model')
    ],
    'schema' => [
        'property' => SchemaProperty::GenerateMigrations,
        'cache' => true,
        'directory' => (__DIR__ . '/../../data/migrations')
    ],
];
