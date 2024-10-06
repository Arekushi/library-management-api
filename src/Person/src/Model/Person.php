<?php

namespace Person\Model;

use App\Abstract\BasicModel;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Person\Repository\PersonRepository;

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
#[Entity(table: 'person', role: 'person', repository: PersonRepository::class)]
class Person extends BasicModel {
    #[Column(type: "string", length: 255)]
    protected $name;

    #[Column(type: "string", length: 255)]
    protected $email;
}
