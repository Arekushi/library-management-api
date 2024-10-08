<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Cycle\ORM\ORM;
use Psr\Container\ContainerInterface;
use Sirix\Cycle\Service\MigratorService;

/** @var ContainerInterface $container */
$container = require 'config/container.php';

/** @var MigratorService $migrator */
$migrator = $container->get(MigratorService::class);

/** @var ORM $orm */
$orm = $container->get('orm');

$migrator->rollback();
