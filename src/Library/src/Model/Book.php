<?php

namespace Library\Model;

use App\Abstract\BaseModel;
use App\Attribute\RelatedCollection;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Cycle\ORM\Entity\Behavior\Hook;
use Cycle\ORM\Entity\Behavior\Event\Mapper\Command;
use Library\Repository\BookRepository;
use OpenApi\Attributes as OAT;

#[Entity(
    table: 'book',
    role: 'book',
    repository: BookRepository::class
)]
#[Hook(
    callable: [BaseModel::class, 'onCreate'],
    events: Command\OnCreate::class
)]
#[Hook(
    callable: [BaseModel::class, 'onUpdate'],
    events: Command\OnUpdate::class
)]
#[OAT\Schema(schema: 'Book')]
class Book extends BaseModel
{
    #[OAT\Property(type: 'string')]
    #[Column(type: 'string', length: 255)]
    protected $title;

    #[OAT\Property(type: 'string')]
    #[Column(type: 'string', length: 255)]
    protected $isbn;

    #[OAT\Property(type: 'string')]
    #[Column(type: 'string', length: 255)]
    protected $description;

    #[OAT\Property(type: 'string')]
    #[Column(type: 'string', length: 255)]
    protected $publisher;

    #[OAT\Property(type: 'int')]
    #[Column(type: 'int')]
    protected $copies;

    #[OAT\Property(type: 'int')]
    #[Column(type: 'int')]
    protected $publicationYear;

    #[OAT\Property(type: 'array', items: new OAT\Items(ref: '#/components/schemas/Loan'))]
    #[HasMany(target: Loan::class)]
    #[RelatedCollection(
        Loan::class
    )]
    protected array $loans = [];

    public function getPublicationYear()
    {
        return $this->publicationYear;
    }

    public function setPublicationYear($publicationYear): self
    {
        $this->publicationYear = $publicationYear;
        return $this;
    }

    public function getCopies()
    {
        return $this->copies;
    }

    public function setCopies($copies): self
    {
        $this->copies = $copies;
        return $this;
    }

    public function minusOneCopy()
    {
        $this->copies -= 1;
    }

    public function plusOneCopy()
    {
        $this->copies += 1;
    }

    public function getPublisher()
    {
        return $this->publisher;
    }

    public function setPublisher($publisher): self
    {
        $this->publisher = $publisher;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function setIsbn($isbn): self
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getLoans(): array
    {
        return $this->loans;
    }

    public function setLoans(array $loans)
    {
        $this->loans = $loans;
    }
}
