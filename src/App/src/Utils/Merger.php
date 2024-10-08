<?php

namespace App\Utils;

use App\Attribute\RelatedCollection;
use Exception;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\HydratorInterface;
use ReflectionClass;
use ReflectionProperty;

class Merger
{
    public static function merge(
        $oldObj,
        $request,
        array $ignoreProperties = [],
        bool $overwriteFalsy = false,
        bool $replace = false
    ) {
        $reflection = new ReflectionClass($oldObj);

        foreach ($request as $key => $value) {
            if (in_array($key, $ignoreProperties)) {
                continue;
            }

            if ($reflection->hasProperty($key)) {
                $property = $reflection->getProperty($key);
                $relatedCollectionAttr = self::getRelatedCollectionAttribute($property);
                $isArray = $relatedCollectionAttr !== null;

                if ($isArray) {
                    $setMethod = $relatedCollectionAttr->getSetMethod();
                    $getMethod = $relatedCollectionAttr->getGetMethod();
                    $hasSetter = method_exists($oldObj, $setMethod);
                    $hasGetter = method_exists($oldObj, $getMethod);

                    if ($hasGetter && $hasSetter) {
                        if ($replace) {
                            $oldObj->{$setMethod}([]);
                        }

                        foreach ($value as $newItemData) {
                            $relatedClass = $relatedCollectionAttr->getRelatedClass();
                            $newItem = HydratorMapper::map($newItemData, $relatedClass, ClassMethodsHydrator::class);
                            $itens = $oldObj->{$getMethod}();
                            $itens[] = $newItem;

                            $oldObj->{$setMethod}($itens);
                        }
                    }
                } else {
                    if ($overwriteFalsy || $value !== null) {
                        $property->setAccessible(true);
                        $property->setValue($oldObj, $value);
                    }
                }
            }
        }

        return $oldObj;
    }

    protected static function getRelatedCollectionAttribute(ReflectionProperty $property)
    {
        $attributes = $property->getAttributes(RelatedCollection::class);
        return $attributes ? $attributes[0]->newInstance() : null;
    }
}
