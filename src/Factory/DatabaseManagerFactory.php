<?php

declare(strict_types=1);

namespace App\Factory;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\DatabaseManager;
use Psr\Container\ContainerInterface;

class DatabaseManagerFactory
{
    public function __invoke(ContainerInterface $container): DatabaseManager
    {
        $dbConfig = $container->get('config')['database'];
        return new DatabaseManager(new DatabaseConfig($dbConfig));
    }
}
