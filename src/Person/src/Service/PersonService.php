<?php

namespace Person\Service;

use Person\Model\User;
use Person\Repository\PersonRepository;

class PersonService
{
    protected $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function getUser($id)
    {
        return $this->personRepository->findById($id);
    }

    public function getAllUsers()
    {
        return $this->personRepository->fetchAll();
    }
}
