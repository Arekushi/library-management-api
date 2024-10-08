<?php

namespace Person\Service;

use App\Abstract\BaseService;
use Person\Repository\PersonRepository;

class PersonService extends BaseService
{
    public function __construct(PersonRepository $repository)
    {
        $this->repository = $repository;
    }
}
