<?php

namespace Person\Model;

use App\Abstract\BasicModel;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
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
    callable: [BasicModel::class, 'onCreate'],
    events: Command\OnCreate::class
)]
#[Hook(
    callable: [BasicModel::class, 'onUpdate'],
    events: Command\OnUpdate::class
)]
#[OAT\Schema(schema: 'Person')]
class Person extends BasicModel
{
    #[OAT\Property(type: 'string')]
    #[Column(type: "string", length: 255)]
    protected $name;

    #[OAT\Property(type: 'string')]
    #[Column(type: "string", length: 255)]
    protected $email;

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
}
