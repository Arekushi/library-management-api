<?php

declare(strict_types=1);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

use Cycle\Database\Config;

return [
    'database' => [
        'default' => 'default',
        'databases' => [
            'default' => ['connection' => 'postgres']
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
            ),
        ],
    ],
];
