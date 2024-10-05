<?php

namespace People\Model;

use App\Abstract\BasicModel;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use People\Repository\PeopleRepository;

#[Entity(table: 'people', role: 'people', repository: PeopleRepository::class)]
class People extends BasicModel {
    #[Column(type: "string", length: 255)]
    protected $userName;

    #[Column(type: "string", length: 255)]
    protected $email;
}
