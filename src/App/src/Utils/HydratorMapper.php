<?php

namespace App\Utils;

use App\Attribute\RelatedCollection;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\ReflectionHydrator;
use ReflectionClass;
use ReflectionProperty;

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

        if (!in_array(HydratorInterface::class, class_implements($hydratorClass))) {
            throw new \InvalidArgumentException("O hydrator fornecido não implementa HydratorInterface.");
        }

        $classInstance = new $class();
        $hydrator = new $hydratorClass();

        // Iterar sobre cada campo da classe
        foreach ($data as $key => $value) {
            $reflectionClass = new ReflectionClass($class);

            if (!$reflectionClass->hasProperty($key)) {
                continue;
            }

            if (is_array($value) && self::isListOfObjects($class, $key)) {
                $relatedClass = self::getRelatedClass($class, $key)->getRelatedClass();
                $mappedItems = array_map(
                    fn($item) => self::map($item, $relatedClass, $hydratorClass),
                    $value
                );

                self::addItemsToCollection($classInstance, $key, $mappedItems);
            } else {
                $hydrator->hydrate([$key => $value], $classInstance);
            }
        }

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

    private static function getRelatedClass(string $class, string $property): RelatedCollection
    {
        $reflectionClass = new ReflectionClass($class);

        if (!$reflectionClass->hasProperty($property)) {
            throw new \InvalidArgumentException("A propriedade {$property} não existe na classe {$class}.");
        }

        /** @var ReflectionProperty $reflectedProperty */
        $reflectedProperty = $reflectionClass->getProperty($property);

        $attributes = $reflectedProperty->getAttributes(RelatedCollection::class);

        if (!empty($attributes)) {
            return $attributes[0]->newInstance();
        }

        throw new \RuntimeException("A classe relacionada para a propriedade {$property} não pôde ser determinada.");
    }

    private static function isListOfObjects(string $class, string $property): bool
    {
        $reflectionClass = new ReflectionClass($class);
        if (!$reflectionClass->hasProperty($property)) {
            throw new \InvalidArgumentException("A propriedade {$property} não existe na classe {$class}.");
        }

        /** @var ReflectionProperty $reflectedProperty */
        $reflectedProperty = $reflectionClass->getProperty($property);
        $propertyType = $reflectedProperty->getType();

        if ($propertyType && $propertyType->getName() === 'array') {
            $attributes = $reflectedProperty->getAttributes(RelatedCollection::class);

            if (!empty($attributes)) {
                return true;
            }
        }

        return false;
    }

    private static function addItemsToCollection(object $classInstance, string $property, array $items): void
    {
        $mapping = self::getRelatedClass(get_class($classInstance), $property);
        $getMethod = $mapping->getGetMethod();
        $setMethod = $mapping->getSetMethod();
        $hasGetter = method_exists($classInstance, $getMethod);
        $hasSetter = method_exists($classInstance, $setMethod);

        if ($hasGetter && $hasSetter) {
            foreach ($items as $item) {
                $itens = $classInstance->{$getMethod}();
                $itens[] = $item;
                $classInstance->{$setMethod}($itens);
            }
        } else {
            throw new \InvalidArgumentException("Método {$getMethod} ou {$setMethod} não existe para a propriedade {$property}.");
        }
    }
}
