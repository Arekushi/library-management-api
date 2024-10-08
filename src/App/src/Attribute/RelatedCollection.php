<?php

namespace App\Attribute;

use Attribute;
use Doctrine\Inflector\InflectorFactory;

/**
 * Attribute to indicate that a property represents a related collection of objects.
 *
 * This class is used to reference the class of an array (collection) of objects.
 * It simplifies the handling of related collections within an entity by dynamically
 * generating `get` and `set` methods to access and modify these collections.
 *
 * The names of the accessor (`getMethod`) and modifier (`setMethod`) methods are
 * automatically generated based on the related class name using pluralization.
 *
 * @Attribute(Attribute::TARGET_PROPERTY)
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class RelatedCollection
{
    public function __construct(
        private string $relatedClass,
        private ?string $getMethod = null,
        private ?string $setMethod = null,
    ) {
        $inflector = InflectorFactory::create()->build();
        $parts = explode('\\', $relatedClass);
        $pluralProperty = $inflector->pluralize(end($parts));

        if (is_null($this->setMethod)) {
            $this->setMethod = 'set' . ucfirst($pluralProperty);
        }

        if (is_null($this->getMethod)) {
            $this->getMethod = 'get' . ucfirst($pluralProperty);
        }
    }

    public function getRelatedClass(): string
    {
        return $this->relatedClass;
    }

    public function getSetMethod(): string
    {
        return $this->setMethod;
    }

    public function getGetMethod(): string
    {
        return $this->getMethod;
    }
}
