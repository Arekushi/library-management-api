<?php

namespace Person\Test;

use Person\Model\Person;
use Person\Model\Telephone;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testCreatePerson()
    {
        $person = new Person();
        $person->setName('John Doe');
        $person->setEmail('john@example.com');

        $this->assertEquals('John Doe', $person->getName());
        $this->assertEquals('john@example.com', $person->getEmail());
    }

    public function testAddTelephonesToPerson()
    {
        $person = new Person();

        $telephone1 = new Telephone();
        $telephone1->setNumber('123456789');

        $telephone2 = new Telephone();
        $telephone2->setNumber('987654321');

        $person->setTelephones([$telephone1, $telephone2]);

        $this->assertCount(2, $person->getTelephones());
        $this->assertEquals('123456789', $person->getTelephones()[0]->getNumber());
        $this->assertEquals('987654321', $person->getTelephones()[1]->getNumber());
    }

    public function testUpdatePersonDetails()
    {
        $person = new Person();
        $person->setName('Jane Doe');
        $person->setEmail('jane@example.com');

        $person->setName('Jane Smith');
        $person->setEmail('jane.smith@example.com');

        $this->assertEquals('Jane Smith', $person->getName());
        $this->assertEquals('jane.smith@example.com', $person->getEmail());
    }

    public function testSetAndGetUuid()
    {
        $person = new Person();
        $uuid = '123e4567-e89b-12d3-a456-426614174000';
        $reflection = new \ReflectionClass($person);
        $property = $reflection->getProperty('uuid');
        $property->setAccessible(true);
        $property->setValue($person, $uuid);

        $this->assertEquals($uuid, $person->getUuid());
    }

    public function testSetAndGetCreatedAt()
    {
        $person = new Person();
        $createdAt = new \DateTimeImmutable('2024-10-08');
        $reflection = new \ReflectionClass($person);
        $property = $reflection->getProperty('createdAt');
        $property->setAccessible(true);
        $property->setValue($person, $createdAt);

        $this->assertEquals($createdAt, $person->getCreatedAt());
    }

    public function testSetAndGetUpdatedAt()
    {
        $person = new Person();
        $updatedAt = new \DateTimeImmutable('2024-10-08');
        $reflection = new \ReflectionClass($person);
        $property = $reflection->getProperty('updatedAt');
        $property->setAccessible(true);
        $property->setValue($person, $updatedAt);

        $this->assertEquals($updatedAt, $person->getUpdatedAt());
    }
}
