<?php

namespace Library\Test;

use App\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;
use AutoMapperPlus\AutoMapper;
use Library\Repository\BookRepository;
use Library\Service\BookService;
use PHPUnit\Framework\MockObject\MockObject;

class BookServiceTest extends TestCase
{
    private BookService $service;

    /** @var BookRepository|MockObject */
    private $repository;

    /** @var AutoMapper|MockObject */
    private $mapper;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(BookRepository::class);
        $this->mapper = $this->createMock(AutoMapper::class);

        /** @phpstan-ignore-next-line */
        $this->service = new BookService($this->repository);

        /** @phpstan-ignore-next-line */
        $this->service->setMapper($this->mapper);
    }

    public function testGetByIdBook()
    {
        $book = [
            'uuid' => '1',
            'title' => 'Sample Book',
            'isbn' => '123-4567890123'
        ];

        $this->repository->expects($this->once())
            ->method('getById')
            ->with('1')
            ->willReturn($book);

        $result = $this->service->getById('1');
        $this->assertEquals($book, $result);
    }

    public function testCreateBook()
    {
        $book = (object)[
            'uuid' => '1',
            'title' => 'Sample Book',
            'isbn' => '123-4567890123',
            'description' => 'A book description',
            'copies' => 10
        ];

        $this->mapper->expects($this->once())
            ->method('map')
            ->with($this->equalTo($book))
            ->willReturn($book);

        $this->repository->expects($this->once())
            ->method('createOne')
            ->with($this->equalTo($book))
            ->willReturn($book);

        $result = $this->service->create($book);

        $this->assertEquals($book, $result);
    }

    public function testGetAllBooks()
    {
        $books = [
            ['uuid' => '1', 'title' => 'Sample Book', 'isbn' => '123-4567890123'],
            ['uuid' => '2', 'title' => 'Another Book', 'isbn' => '987-6543210987']
        ];

        $this->repository->expects($this->once())
            ->method('getAll')
            ->willReturn($books);

        $result = $this->service->getAll();
        $this->assertEquals($books, $result);
    }

    public function testDeleteBook()
    {
        $bookId = '1';
        $book = ['uuid' => $bookId, 'title' => 'Sample Book', 'isbn' => '123-4567890123'];

        $this->repository->expects($this->once())
            ->method('getById')
            ->with($bookId)
            ->willReturn($book);

        $this->repository->expects($this->once())
            ->method('deleteOne')
            ->with($book);

        $result = $this->service->delete($bookId);
        $this->assertEquals($book, $result);
    }

    public function testDeleteBookNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->repository->expects($this->once())
            ->method('getById')
            ->with('1')
            ->willReturn(null);

        $this->service->delete('1');
    }

    public function testEditBookNotFound()
    {
        $this->expectException(NotFoundException::class);

        $this->repository->expects($this->once())
            ->method('getById')
            ->with('1')
            ->willReturn(null);

        $this->service->edit('1', []);
    }
}
