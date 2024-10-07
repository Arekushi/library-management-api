<?php

declare(strict_types=1);

use App\Factory\CustomNotFoundHandlerFactory;
use App\Factory\CycleORMFactory;
use App\Factory\DatabaseManagerFactory;
use App\Factory\ExceptionHandlerMiddlewareFactory;
use App\Factory\LoggerFactory;
use App\Factory\LoggingMiddlewareFactory;
use App\Factory\MigratorFactory;
use App\Handler\CustomNotFoundHandler;
use App\Middleware\ExceptionHandlerMiddleware;
use App\Middleware\LoggingMiddleware;
use Psr\Log\LoggerInterface;

use Cycle\ORM\ORM;
use Cycle\Database\DatabaseManager;
use Cycle\Migrations\Migrator;
use Mezzio\LaminasView\LaminasViewRendererFactory;
use Mezzio\Template\TemplateRendererInterface;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.

    'dependencies' => [

        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            // Fully\Qualified\ClassOrInterfaceName::class => Fully\Qualified\ClassName::class,
        ],

        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
        ],

        // Use 'factories' for services provided by callbacks/factory classes.
        'factories' => [
            // Fully\Qualified\ClassName::class => Fully\Qualified\FactoryName::class,
            LoggerInterface::class => LoggerFactory::class,
            LoggingMiddleware::class => LoggingMiddlewareFactory::class,
            DatabaseManager::class => DatabaseManagerFactory::class,
            ORM::class => CycleORMFactory::class,
            Migrator::class => MigratorFactory::class,
            TemplateRendererInterface::class => LaminasViewRendererFactory::class,
            ExceptionHandlerMiddleware::class => ExceptionHandlerMiddlewareFactory::class,
            CustomNotFoundHandler::class => CustomNotFoundHandlerFactory::class
        ],
    ]
];
