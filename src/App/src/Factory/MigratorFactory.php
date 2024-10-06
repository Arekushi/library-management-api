<?php

declare(strict_types=1);

namespace App\Factory;

use Cycle\Database\DatabaseManager;
use Cycle\Migrations\Config\MigrationConfig;
use Cycle\Migrations\FileRepository;
use Cycle\Migrations\Migrator;
use Psr\Container\ContainerInterface;

class MigratorFactory
{
    public function __invoke(ContainerInterface $container): Migrator
    {
        $config = new MigrationConfig([
            'directory' => __DIR__ . '/../../../../data/migrations',
            'table' => 'migrations',
        ]);

        $dbal = $container->get(DatabaseManager::class);
        $migrator = new Migrator($config, $dbal, new FileRepository($config));

        return $migrator;
    }
}
