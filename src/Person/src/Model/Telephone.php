<?php

namespace Person\Model;

use App\Abstract\BaseModel;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Hook;
use Cycle\ORM\Entity\Behavior\Event\Mapper\Command;
use OpenApi\Attributes as OAT;

#[Entity(
    table: 'telephone',
    role: 'telephone'
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
class Telephone extends BaseModel
{
    #[OAT\Property(type: 'string')]
    #[Column(type: "string", length: 255)]
    protected string $number;

    public function getNumber(): string {
        return $this->number;
    }

    public function setNumber($number): void {
        $this->number = $number;
    }
}
