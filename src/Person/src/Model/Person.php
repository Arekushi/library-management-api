<?php

namespace Person\Model;

use App\Abstract\BasicModel;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Person\Repository\PersonRepository;

use Cycle\ORM\Entity\Behavior\Event\Mapper\Command;
use Cycle\ORM\Entity\Behavior;

/**
 *@OA\Schema(
 *  schema="Person",
 *  @OA\Property(
 *     property="name",
 *     type="string",
 *     description="Name of person"
 *  ),
 *  @OA\Property(
 *     property="email",
 *     type="string",
 *     description="Email of person"
 *  )
 *)
 */
#[Entity(
    table: 'person',
    role: 'person',
    repository: PersonRepository::class
)]
#[Behavior\Hook(
    callable: [BasicModel::class, 'onCreate'],
    events: Command\OnCreate::class
)]
#[Behavior\Hook(
    callable: [BasicModel::class, 'onUpdate'],
    events: Command\OnUpdate::class
)]
class Person extends BasicModel {
    #[Column(type: "string", length: 255)]
    protected $name;

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
