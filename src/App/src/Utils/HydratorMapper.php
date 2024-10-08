<?php

namespace App\Utils;

use Exception;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\ReflectionHydrator;
use ReflectionClass;

class HydratorMapper
{
    public static function map(
        object|array $data,
        string $class,
        string $hydratorClass = ReflectionHydrator::class
    ): object {
        if (is_object($data)) {
            if (get_class($data) === $class) {
                return $data;
            }

            $data = self::extractProperties($data);
        }

        if (!is_array($data)) {
            throw new \InvalidArgumentException("O dado fornecido deve ser um array ou um objeto.");
        }

        $classInstance = new $class();

        // Verificar se o $hydratorClass implementa a interface HydratorInterface
        if (!in_array(HydratorInterface::class, class_implements($hydratorClass))) {
            throw new \InvalidArgumentException("O hydrator fornecido não implementa HydratorInterface.");
        }

        $hydrator = new $hydratorClass();
        $hydrator->hydrate($data, $classInstance);

        return $classInstance;
    }

    public static function mapList(
        array $dataList,
        string $class,
        string $interface = ReflectionHydrator::class
    ): array {
        $mappedList = [];

        foreach ($dataList as $data) {
            $mappedList[] = self::map($data, $class, $interface);
        }

        return $mappedList;
    }

    public static function merge(
        $oldObj,
        $newData,
        string $hydratorClass = ClassMethodsHydrator::class
    )
    {
        if (!class_exists($hydratorClass) || !in_array(HydratorInterface::class, class_implements($hydratorClass))) {
            throw new Exception("O hydrator '$hydratorClass' não é válido ou não implementa HydratorInterface.");
        }

        $hydrator = new $hydratorClass();

        $oldData = $hydrator->extract($oldObj);
        $newData = (array)$newData;

        // Faz o merge dos dados
        foreach ($newData as $key => $value) {
            if ($value !== null) {
                $oldData[$key] = $value;
            }
        }

        return $hydrator->hydrate($oldData, $oldObj);
    }

    private static function extractProperties(object $object): array
    {
        $reflection = new ReflectionClass($object);
        $properties = [];

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $properties[$property->getName()] = $property->getValue($object);
        }

        return $properties;
    }
}
