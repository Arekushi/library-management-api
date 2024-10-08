<?php

namespace App\Utils;

class GenericMapper
{
    public static function map(array $data, string $className): object
    {
        $reflection = new \ReflectionClass($className);
        $constructor = $reflection->getConstructor();
        $params = $constructor ? $constructor->getParameters() : [];

        $args = [];

        foreach ($params as $param) {
            $paramName = $param->getName();
            if (array_key_exists($paramName, $data)) {
                $args[] = $data[$paramName];
            } elseif ($param->isDefaultValueAvailable()) {
                $args[] = $param->getDefaultValue();
            } else {
                throw new \InvalidArgumentException("Missing required parameter: {$paramName}");
            }
        }

        return $reflection->newInstanceArgs($args);
    }
}
