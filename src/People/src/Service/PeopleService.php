<?php

namespace People\Service;

use People\Model\User;
use People\Repository\PeopleRepository;

class PeopleService
{
    protected $peopleRepository;

    public function __construct(PeopleRepository $peopleRepository)
    {
        $this->peopleRepository = $peopleRepository;
    }

    public function getUser($id)
    {
        return $this->peopleRepository->findById($id);
    }

    public function getAllUsers()
    {
        return $this->peopleRepository->fetchAll();
    }
}
