<?php

namespace Person\Test;

use App\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;
use AutoMapperPlus\AutoMapper;
use Person\Repository\PersonRepository;
use Person\Service\PersonService;
use PHPUnit\Framework\MockObject\MockObject;

class PersonServiceTest extends TestCase
{
    private PersonService $service;

    /** @var PersonRepository|MockObject */
    private $repository;

    /** @var AutoMapper|MockObject */
    private $mapper;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(PersonRepository::class);
        $this->mapper = $this->createMock(AutoMapper::class);

        /** @phpstan-ignore-next-line */
        $this->service = new PersonService($this->repository);

        /** @phpstan-ignore-next-line */
        $this->service->setMapper($this->mapper);
    }

    public function testGetByIdPerson()
    {
        $person = [
            'uuid' => '1',
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ];

        $this->repository->expects($this->once())
            ->method('getById')
            ->with('1')
            ->willReturn($person);

        $result = $this->service->getById('1');
        $this->assertEquals($person, $result);
    }

    public function testCreatePerson()
    {
        $person = (object)[
            'uuid' => '1',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com'
        ];

        $this->mapper->expects($this->once())
            ->method('map')
            ->with($this->equalTo($person))
            ->willReturn($person);

        $this->repository->expects($this->once())
            ->method('createOne')
            ->with($this->equalTo($person))
            ->willReturn($person);

        $result = $this->service->create($person);

        $this->assertEquals($person, $result);
    }

    public function testGetAllPersons()
    {
        $persons = [
            ['uuid' => '1', 'name' => 'John Doe', 'email' => 'john@example.com'],
            ['uuid' => '2', 'name' => 'Jane Doe', 'email' => 'jane@example.com']
        ];

        $this->repository->expects($this->once())
            ->method('getAll')
            ->willReturn($persons);

        $result = $this->service->getAll();
        $this->assertEquals($persons, $result);
    }

    public function testDeletePerson()
    {
        $personId = '1';
        $person = ['uuid' => $personId, 'name' => 'John Doe', 'email' => 'john@example.com'];

        $this->repository->expects($this->once())
            ->method('getById')
            ->with($personId)
            ->willReturn($person);

        $this->repository->expects($this->once())
            ->method('deleteOne')
            ->with($person);

        $result = $this->service->delete($personId);
        $this->assertEquals($person, $result);
    }

    public function testDeletePersonNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->repository->expects($this->once())
            ->method('getById')
            ->with('1')
            ->willReturn(null);

        $this->service->delete('1');
    }

    public function testEditPersonNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->repository->expects($this->once())
            ->method('getById')
            ->with('1')
            ->willReturn(null);

        $this->service->edit('1', []);
    }
}
