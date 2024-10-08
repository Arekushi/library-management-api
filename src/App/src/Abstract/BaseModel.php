<?php

namespace App\Abstract;

use Cycle\Annotated\Annotation\Column;
use Cycle\ORM\Entity\Behavior\Event\Mapper\Command;
use DateTimeImmutable;
use ReflectionClass;
use Ramsey\Uuid\Uuid;
use Throwable;

/**
 * Abstract class BaseModel.
 *
 * This class serves as a base model for entities within the application.
 * It provides common properties and behaviors for managing unique identifiers
 * (UUIDs), creation and update timestamps, and a string representation of the entity.
 */
abstract class BaseModel
{
    #[Column(type: 'string', primary: true)]
    protected string $uuid;

    #[Column(type: 'datetime')]
    protected DateTimeImmutable $createdAt;

    #[Column(type: 'datetime', nullable: true)]
    protected ?DateTimeImmutable $updatedAt = null;

    /**
     * Handles the OnCreate event to initialize entity properties.
     *
     * This method sets the UUID and creation timestamp when a new entity is created.
     *
     * @param Command\OnCreate $event The event triggered during entity creation.
     *
     * @return void
     */
    public static function onCreate(Command\OnCreate $event): void
    {
        $event->state->register('uuid', Uuid::uuid4()->toString());
        $event->state->register('createdAt', new DateTimeImmutable());
        $event->state->register('updatedAt', new DateTimeImmutable());
    }

    /**
     * Handles the OnUpdate event to update the entity's updated timestamp.
     *
     * This method sets the updated timestamp when an existing entity is updated.
     *
     * @param Command\OnUpdate $event The event triggered during entity update.
     *
     * @return void
     */
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

    /**
     * Returns a string representation of the entity's properties.
     *
     * This method uses reflection to access and display all properties of the entity.
     *
     * @return string A string representation of the entity.
     */
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
            } catch (Throwable $e) {
                $name = $property->getName();
                $value = null;
                $output[] = "$name: $value";
            }
        }

        return implode(', ', $output);
    }
}
