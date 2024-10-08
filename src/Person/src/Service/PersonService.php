<?php

namespace Person\Service;

use App\Abstract\BasicService;
use Person\Repository\PersonRepository;

class PersonService extends BasicService
{
    public function __construct(PersonRepository $repository)
    {
        $this->repository = $repository;
    }
}
