<?php

declare(strict_types=1);

namespace Swagger;

use Genxoft\SwaggerPhpModule\Handler\JsonAction;
use Genxoft\SwaggerPhpModule\Handler\UiAction;

/**
 * @OA\Info(
 *   version="1.0",
 *   title="Library Management API",
 *   description="A simple Rest API in Laminas Mezzio that manages book loans.",
 *   @OA\Contact(
 *     name="Alexandre Lima",
 *     email="alexandre.ferreira1445@gmail.com",
 *   ),
 * ),
 * @OA\Server(
 *   url="http://127.0.0.1:8080",
 *   description="local server",
 * )
 */
class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'routes' => $this->getRoutes(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
            ],
        ];
    }

    public function getRoutes(): array
    {
        return [
            [
                'name' => 'swagger_php.route.json',
                'path' => '/api/json',
                'middleware' => JsonAction::class,
                'allowed_methods' => ['GET'],
            ],
            [
                'name' => 'swagger_php.route.ui',
                'path' => '/api',
                'middleware' => UiAction::class,
                'allowed_methods' => ['GET'],
            ]
        ];
    }
}
