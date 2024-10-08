<?php

namespace App\Abstract;

use Cycle\ORM\Select\Repository;
use Cycle\Schema\Definition\Entity;
use Cycle\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

abstract class BasicRepository extends Repository
{

    protected EntityManagerInterface $entityManager;

    protected string $entityClass;

    public LoggerInterface $logger;

    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
    }

    public function getEntityClass()
    {
        return $this->entityClass;
    }

    public function getFirst(): ?Entity
    {
        return $this->select()->orderBy('created_at')->limit(1)->fetchOne();
    }

    public function getLast(): ?Entity
    {
        return $this->select()->orderBy('created_at', 'DESC')->limit(1)->fetchOne();
    }

    public function getById($id)
    {
        $obj = $this->select()->where(['uuid' => $id])->fetchOne();
        return $obj;
    }

    public function getAll()
    {
        $all = $this->select()->fetchAll();
        return $all;
    }

    public function createOne($obj)
    {
        $this->entityManager->persist($obj);
        $this->entityManager->run();
        return $obj;
    }

    public function deleteOne($obj)
    {
        $this->entityManager->delete($obj);
        $this->entityManager->run();
    }

    public function editOne($obj)
    {
        $this->entityManager->persist($obj);
        $this->entityManager->run();
    }
}
