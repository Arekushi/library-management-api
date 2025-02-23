<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;
use Mezzio\Helper\ConfigProvider;

// To enable or disable caching, set the `ConfigAggregator::ENABLE_CACHE` boolean in
// `config/autoload/local.php`.
$cacheConfig = [
    'config_cache_path' => 'data/cache/config-cache.php',
];

$aggregator = new ConfigAggregator([
    \Sirix\Cycle\ConfigProvider::class,
    \Laminas\Hydrator\ConfigProvider::class,
    \Mezzio\Cors\ConfigProvider::class,
    \Mezzio\LaminasView\ConfigProvider::class,
    \Mezzio\Plates\ConfigProvider::class,
    \Genxoft\SwaggerPhpModule\ConfigProvider::class,
    \Mezzio\Tooling\ConfigProvider::class,
    \Mezzio\Helper\ConfigProvider::class,
    \Mezzio\Router\FastRouteRouter\ConfigProvider::class,
    \Laminas\HttpHandlerRunner\ConfigProvider::class,

    // Include cache configuration
    new ArrayProvider($cacheConfig),
    \Mezzio\ConfigProvider::class,
    \Mezzio\Router\ConfigProvider::class,
    \Laminas\Diactoros\ConfigProvider::class,
    ConfigProvider::class,
    // Swoole config to overwrite some services (if installed)
    // class_exists(\Mezzio\Swoole\ConfigProvider::class)
    //     ? \Mezzio\Swoole\ConfigProvider::class
    //     : function (): array {
    //         return [];
    //     },

    // My Modules
    \Swagger\ConfigProvider::class,
    \Person\ConfigProvider::class,
    \Library\ConfigProvider::class,

    // Load application config in a pre-defined order in such a way that local settings
    // overwrite global settings. (Loaded as first to last):
    //   - `global.php`
    //   - `*.global.php`
    //   - `local.php`
    //   - `*.local.php`
    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php'),

    // Load development config if it exists
    new PhpFileProvider(realpath(__DIR__) . '/development.config.php'),
], $cacheConfig['config_cache_path']);

return $aggregator->getMergedConfig();
