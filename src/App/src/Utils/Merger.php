<?php

namespace App\Utils;

use App\Attribute\RelatedCollection;
use AutoMapperPlus\AutoMapper;
use ReflectionClass;
use ReflectionProperty;

class Merger
{
    /**
     * Merges data from a request object into an existing object.
     *
     * This method takes an existing object (`$oldObj`) and merges data from a request object (`$request`),
     * mapping new values where applicable. It supports mapping related collections through a custom attribute
     * (`RelatedCollection`), as well as controlling whether to ignore certain properties or overwrite falsy values.
     *
     * - If the property is part of a related collection (detected via `RelatedCollection` attribute),
     *   it maps and adds items to the collection using the provided setter and getter methods.
     * - Supports options to ignore specific properties, overwrite falsy values, and replace collections.
     *
     * @param object $oldObj The original object to be updated with new values.
     * @param object|array $request The incoming request data with new values to merge.
     * @param AutoMapper $mapper An instance of the `AutoMapper` to map request data to object properties.
     * @param array $ignoreProperties An array of property names that should not be updated during the merge.
     * @param bool $overwriteFalsy Whether falsy values (e.g., `false`, `0`, `''`) should overwrite existing values.
     * @param bool $replace Whether collections should be replaced entirely with the new data.
     *
     * @return object Returns the modified object with the merged values.
     */
    public static function merge(
        $oldObj,
        $request,
        AutoMapper $mapper,
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
                            $newItem = $mapper->map($newItemData, $relatedClass);
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
