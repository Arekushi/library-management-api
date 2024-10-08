<?php

namespace Person\Model;

use App\Abstract\BaseModel;
use App\Attribute\RelatedCollection;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Cycle\ORM\Entity\Behavior\Hook;
use Person\Repository\PersonRepository;
use Cycle\ORM\Entity\Behavior\Event\Mapper\Command;
use OpenApi\Attributes as OAT;

#[Entity(
    table: 'person',
    role: 'person',
    repository: PersonRepository::class
)]
#[Hook(
    callable: [BaseModel::class, 'onCreate'],
    events: Command\OnCreate::class
)]
#[Hook(
    callable: [BaseModel::class, 'onUpdate'],
    events: Command\OnUpdate::class
)]
#[OAT\Schema(schema: 'Person')]
class Person extends BaseModel
{
    #[OAT\Property(type: 'string')]
    #[Column(type: "string", length: 255)]
    protected $name;

    #[OAT\Property(type: 'string')]
    #[Column(type: "string", length: 255)]
    protected $email;

    #[OAT\Property(type: 'array', items: new OAT\Items(ref: '#/components/schemas/Telephone'))]
    #[HasMany(target: Telephone::class)]
    #[RelatedCollection(
        Telephone::class
    )]
    protected array $telephones = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getTelephones(): array
    {
        return $this->telephones;
    }

    public function setTelephones(array $telephones)
    {
        $this->telephones = $telephones;
    }
}
