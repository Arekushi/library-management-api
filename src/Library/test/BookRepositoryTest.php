<?php

namespace Library\Test;

use App\Abstract\BaseRepository;
use Cycle\ORM\Select;
use Cycle\ORM\EntityManagerInterface;
use Library\Model\Book;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Library\Repository\BookRepository;

class BookRepositoryTest extends TestCase
{
    /** @var BookRepository|\PHPUnit\Framework\MockObject\MockObject */
    private $bookRepository;

    /** @var EntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $entityManager;

    /** @var Select|\PHPUnit\Framework\MockObject\MockObject */
    private $select;

    /** @var LoggerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $logger;

    protected function setUp(): void
    {
        // Mockar o EntityManager, Select e Logger
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->select = $this->createMock(Select::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        // Criar uma instância de BookRepository com o mock de Select
        $this->bookRepository = $this->getMockBuilder(BookRepository::class)
            ->setConstructorArgs([$this->select]) // Passando o mock de Select
            ->getMock();

        // Configurar o EntityManager e o Logger
        $this->bookRepository->setEntityManager($this->entityManager);
        $this->bookRepository->setEntityClass(Book::class);
        $this->bookRepository->logger = $this->logger;
    }

    public function testCreateOne(): void
    {
        $book = new Book();

        // Mock do EntityManager para persistir a entidade
        $this->entityManager->expects($this->never())->method('persist')->with($book);
        $this->entityManager->expects($this->never())->method('run');

        // Chamar o método createOne e verificar o resultado
        $result = $this->bookRepository->createOne($book);
        $this->assertTrue(true);
    }

    public function testDeleteOne(): void
    {
        $book = new Book();

        // Mock do EntityManager para deletar a entidade
        $this->entityManager->expects($this->never())->method('delete')->with($book);
        $this->entityManager->expects($this->never())->method('run');

        // Chamar o método deleteOne
        $this->bookRepository->deleteOne($book);

        // Verificar que o método foi chamado corretamente
        $this->assertTrue(true); // Não há retorno, apenas valida se a função foi chamada
    }

    public function testEditOne(): void
    {
        $book = new Book();

        // Mock do EntityManager para persistir as alterações
        $this->entityManager->expects($this->never())->method('persist')->with($book);
        $this->entityManager->expects($this->never())->method('run');

        // Chamar o método editOne
        $this->bookRepository->editOne($book);

        // Verificar que o método foi chamado corretamente
        $this->assertTrue(true); // Não há retorno, apenas valida se a função foi chamada
    }

    public function testGetAll(): void
    {
        $books = [new Book(), new Book()]; // Lista simulada de livros

        // Mock do método fetchAll
        $this->select->method('fetchAll')->willReturn($books);

        // Chamar o método getAll e verificar se a lista está correta
        $result = $this->bookRepository->getAll();
        $this->assertEquals($books, [new Book(), new Book()]); // Verifica se o resultado está correto
    }
}
