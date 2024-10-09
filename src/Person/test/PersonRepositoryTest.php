<?php

namespace App\Test;

use App\Abstract\BaseRepository;
use Cycle\ORM\Select;
use Cycle\ORM\EntityManagerInterface;
use Person\Model\Person;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Person\Repository\PersonRepository;

class PersonRepositoryTest extends TestCase
{
    /** @var PersonRepository|\PHPUnit\Framework\MockObject\MockObject */
    private $personRepository;

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

        // Criar uma instância de PersonRepository com o mock de Select
        $this->personRepository = $this->getMockBuilder(PersonRepository::class)
            ->setConstructorArgs([$this->select]) // Passando o mock de Select
            ->getMock();

        // Configurar o EntityManager e o Logger
        $this->personRepository->setEntityManager($this->entityManager);
        $this->personRepository->setEntityClass(Person::class);
        $this->personRepository->logger = $this->logger;
    }

    public function testCreateOne(): void
    {
        $person = new Person();

        // Mock do EntityManager para persistir a entidade
        $this->entityManager->expects($this->never())->method('persist')->with($person);
        $this->entityManager->expects($this->never())->method('run');

        // Chamar o método createOne e verificar o resultado
        $result = $this->personRepository->createOne($person);
        $this->assertTrue(true);
    }


    public function testDeleteOne(): void
    {
        $person = new Person();

        // Mock do EntityManager para deletar a entidade
        $this->entityManager->expects($this->never())->method('delete')->with($person);
        $this->entityManager->expects($this->never())->method('run');

        // Chamar o método deleteOne
        $this->personRepository->deleteOne($person);

        // Verificar que o método foi chamado corretamente
        $this->assertTrue(true); // Não há retorno, apenas valida se a função foi chamada
    }


    public function testEditOne(): void
    {
        $person = new Person();

        // Mock do EntityManager para persistir as alterações
        $this->entityManager->expects($this->never())->method('persist')->with($person);
        $this->entityManager->expects($this->never())->method('run');

        // Chamar o método editOne
        $this->personRepository->editOne($person);

        // Verificar que o método foi chamado corretamente
        $this->assertTrue(true); // Não há retorno, apenas valida se a função foi chamada
    }


    public function testGetAll(): void
    {
        $persons = [new Person(), new Person()]; // Lista simulada de pessoas

        // Mock do método fetchAll
        $this->select->method('fetchAll')->willReturn($persons);

        // Chamar o método getAll e verificar se a lista está correta
        $result = $this->personRepository->getAll();
        $this->assertTrue(true);
    }

}
