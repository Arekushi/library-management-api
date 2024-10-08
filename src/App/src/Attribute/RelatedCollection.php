<?php

namespace App\Attribute;

use Attribute;
use Doctrine\Inflector\InflectorFactory;

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
