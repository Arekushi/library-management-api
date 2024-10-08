<?php

namespace Library\Model;

use App\Abstract\BaseModel;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\BelongsTo;
use Cycle\ORM\Entity\Behavior\Hook;
use Cycle\ORM\Entity\Behavior\Event\Mapper\Command;
use Library\Repository\LoanRepository;
use OpenApi\Attributes as OAT;
use Person\Model\Person;
use Cycle\Annotated\Annotation\ColumnType;

#[Entity(
    table: 'loan',
    role: 'loan',
    repository: LoanRepository::class
)]
#[Hook(
    callable: [BaseModel::class, 'onCreate'],
    events: Command\OnCreate::class
)]
#[Hook(
    callable: [BaseModel::class, 'onUpdate'],
    events: Command\OnUpdate::class
)]
#[OAT\Schema(schema: 'Loan')]
class Loan extends BaseModel
{
    #[BelongsTo(target: Person::class)]
    #[OAT\Property(ref: '#/components/schemas/Person')]
    protected Person $person;

    #[BelongsTo(target: Book::class)]
    #[OAT\Property(ref: '#/components/schemas/Book')]
    protected Book $book;

    #[Column(type: 'datetime')]
    #[OAT\Property(type: 'string', format: 'date-time')]
    protected \DateTimeImmutable $loanStartDate;

    #[Column(type: 'datetime')]
    #[OAT\Property(type: 'string', format: 'date-time')]
    protected \DateTimeImmutable $loanEndDate;

    #[Column(type: 'datetime', nullable: true)]
    #[OAT\Property(type: 'string', format: 'date-time')]
    protected ?\DateTimeImmutable $returnedDate;

    public function getPerson(): Person
    {
        return $this->person;
    }

    public function setPerson(Person $person): void
    {
        $this->person = $person;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function setBook(Book $book): void
    {
        $this->book = $book;
    }

    public function getLoanStartDate(): \DateTimeImmutable
    {
        return $this->loanStartDate;
    }

    public function setLoanStartDate(\DateTimeImmutable $loanStartDate): void
    {
        $this->loanStartDate = $loanStartDate;
    }

    public function getLoanEndDate(): \DateTimeImmutable
    {
        return $this->loanEndDate;
    }

    public function setLoanEndDate(\DateTimeImmutable $loanEndDate): void
    {
        $this->loanEndDate = $loanEndDate;
    }

    public function getReturnedDate(): ?\DateTimeImmutable
    {
        return $this->returnedDate;
    }

    public function setReturnedDate(?\DateTimeImmutable $returnedDate): void
    {
        $this->returnedDate = $returnedDate;
    }
}
