<?php

namespace Person\Service;

use Person\Repository\PersonRepository;

class PersonService
{
    protected $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function getPerson($id)
    {
        return $this->personRepository->findById($id);
    }

    public function getAllPersons()
    {
        return $this->personRepository->fetchAll();
    }

    public function createPerson($person) {
        return $this->personRepository->createOne($person);
    }
}
