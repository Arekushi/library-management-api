<?php

namespace App\Abstract;

use Cycle\Annotated\Annotation\Column;
use Cycle\ORM\Entity\Behavior\Event\Mapper\Command;
use DateTimeImmutable;
use ReflectionClass;
use Ramsey\Uuid\Uuid;
use Throwable;

abstract class BaseModel
{
    #[Column(type: 'string', primary: true)]
    protected string $uuid;

    #[Column(type: 'datetime')]
    protected DateTimeImmutable $createdAt;

    #[Column(type: 'datetime', nullable: true)]
    protected ?DateTimeImmutable $updatedAt = null;

    public static function onCreate(Command\OnCreate $event): void
    {
        $event->state->register('uuid', Uuid::uuid4()->toString());
        $event->state->register('createdAt', new DateTimeImmutable());
        $event->state->register('updatedAt', new DateTimeImmutable());
    }

    public static function onUpdate(Command\OnUpdate $event): void
    {
        $event->state->register('updatedAt', new DateTimeImmutable());
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function __toString(): string
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();
        $output = [];

        foreach ($properties as $property) {
            try {
                $property->setAccessible(true);
                $name = $property->getName();
                $value = $property->getValue($this);
                $output[] = "$name: $value";
            } catch(Throwable $e) {
                $name = $property->getName();
                $value = null;
                $output[] = "$name: $value";
            }
        }

        return implode(', ', $output);
    }
}
