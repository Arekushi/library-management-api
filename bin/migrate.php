<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Cycle\Migrations\Migrator;
use Cycle\ORM\ORM;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = require 'config/container.php';

/** @var Migrator $migrator */
$migrator = $container->get(Migrator::class);

/** @var ORM $orm */
$orm = $container->get(ORM::class);

$migrator->run();
