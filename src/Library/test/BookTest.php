<?php

namespace Library\Test;

use Library\Model\Book;
use Library\Model\Loan;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testCreateBook()
    {
        $book = new Book();
        $book->setTitle('Sample Book Title');
        $book->setIsbn('123-4567890123');
        $book->setDescription('A sample description');
        $book->setPublisher('Sample Publisher');
        $book->setCopies(5);
        $book->setPublicationYear(2024);

        $this->assertEquals('Sample Book Title', $book->getTitle());
        $this->assertEquals('123-4567890123', $book->getIsbn());
        $this->assertEquals('A sample description', $book->getDescription());
        $this->assertEquals('Sample Publisher', $book->getPublisher());
        $this->assertEquals(5, $book->getCopies());
        $this->assertEquals(2024, $book->getPublicationYear());
    }

    public function testUpdateBookDetails()
    {
        $book = new Book();
        $book->setTitle('Original Title');
        $book->setPublisher('Original Publisher');

        $book->setTitle('Updated Title');
        $book->setPublisher('Updated Publisher');

        $this->assertEquals('Updated Title', $book->getTitle());
        $this->assertEquals('Updated Publisher', $book->getPublisher());
    }

    public function testAddAndRetrieveLoans()
    {
        $book = new Book();

        $loan1 = new Loan();
        $loan2 = new Loan();

        $book->setLoans([$loan1, $loan2]);

        $this->assertCount(2, $book->getLoans());
        $this->assertSame($loan1, $book->getLoans()[0]);
        $this->assertSame($loan2, $book->getLoans()[1]);
    }

    public function testUpdateCopies()
    {
        $book = new Book();
        $book->setCopies(10);

        $book->minusOneCopy();
        $this->assertEquals(9, $book->getCopies());

        $book->plusOneCopy();
        $this->assertEquals(10, $book->getCopies());
    }

    public function testSetAndGetPublicationYear()
    {
        $book = new Book();
        $book->setPublicationYear(2020);

        $this->assertEquals(2020, $book->getPublicationYear());
    }

    public function testSetAndGetIsbn()
    {
        $book = new Book();
        $book->setIsbn('978-3-16-148410-0');

        $this->assertEquals('978-3-16-148410-0', $book->getIsbn());
    }

    public function testSetAndGetDescription()
    {
        $book = new Book();
        $book->setDescription('A detailed description of the book.');

        $this->assertEquals('A detailed description of the book.', $book->getDescription());
    }
}
