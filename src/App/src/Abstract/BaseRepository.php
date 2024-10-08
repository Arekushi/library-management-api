<?php

namespace App\Abstract;

use Cycle\ORM\Select\Repository;
use Cycle\Schema\Definition\Entity;
use Cycle\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Abstract class BaseRepository.
 *
 * This class extends the Cycle ORM Repository and provides methods for common
 * database operations, such as retrieving, creating, updating, and deleting entities.
 */
abstract class BaseRepository extends Repository
{
    protected EntityManagerInterface $entityManager;

    protected string $entityClass;

    public LoggerInterface $logger;

    /**
     * Sets the EntityManager instance.
     *
     * @param EntityManagerInterface $entityManager The EntityManager instance to set.
     *
     * @return void
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Sets the entity class name.
     *
     * @param string $entityClass The name of the entity class to set.
     *
     * @return void
     */
    public function setEntityClass(string $entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * Gets the entity class name.
     *
     * @return string The name of the entity class.
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    /**
     * Retrieves the first entity ordered by creation date.
     *
     * @return Entity|null The first entity or null if none found.
     */
    public function getFirst()
    {
        return $this->select()->orderBy('created_at')->limit(1)->fetchOne();
    }

    /**
     * Retrieves the last entity ordered by creation date (descending).
     *
     * @return Entity|null The last entity or null if none found.
     */
    public function getLast()
    {
        return $this->select()->orderBy('created_at', 'DESC')->limit(1)->fetchOne();
    }

    /**
     * Retrieves an entity by its unique identifier (UUID).
     *
     * @param string $id The unique identifier of the entity.
     *
     * @return Entity|null The entity with the specified ID or null if not found.
     */
    public function getById(string $id)
    {
        $obj = $this->select()->where(['uuid' => $id])->fetchOne();
        return $obj;
    }

    /**
     * Retrieves all entities.
     *
     * @return Entity[] An array of all entities.
     */
    public function getAll()
    {
        $all = $this->select()->fetchAll();
        return $all;
    }

    /**
     * Creates and persists a new entity.
     *
     * @param $obj The entity object to create.
     *
     * @return Entity The created entity.
     */
    public function createOne($obj)
    {
        $this->entityManager->persist($obj);
        $this->entityManager->run();
        return $obj;
    }

    /**
     * Deletes a specified entity.
     *
     * @param $obj The entity object to delete.
     *
     * @return void
     */
    public function deleteOne($obj)
    {
        $this->entityManager->delete($obj);
        $this->entityManager->run();
    }

    /**
     * Edits (updates) an existing entity.
     *
     * @param $obj The entity object to update.
     *
     * @return void
     */
    public function editOne($obj)
    {
        $this->entityManager->persist($obj);
        $this->entityManager->run();
    }
}
