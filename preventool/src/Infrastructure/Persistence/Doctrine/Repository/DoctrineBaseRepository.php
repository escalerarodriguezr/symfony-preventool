<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Doctrine\DBAL\Connection;

abstract class DoctrineBaseRepository
{
    protected ObjectRepository $objectRepository;

    public function __construct(
        private readonly ManagerRegistry $managerRegistry,
        private readonly Connection $connection
    ) {
        $this->objectRepository = $this->getEntityManager()->getRepository($this->entityClass());
    }

    abstract protected static function entityClass(): string;


    protected function getEntityManager(): EntityManager | ObjectManager
    {
        $entityManager = $this->managerRegistry->getManager();

        if ($entityManager->isOpen()) {
            return $entityManager;
        }

        return $this->managerRegistry->resetManager();
    }


    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    protected function saveEntity(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    protected function removeEntity(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    protected function executeFetchQuery(string $query, array $params = []): array
    {
        return $this->connection->executeQuery($query, $params)->fetchAllAssociative();
    }


    /**
     * @throws \Doctrine\DBAL\Exception
     */
    protected function executeInsertQuery(string $query, array $params = []): void
    {
        $this->connection->executeQuery($query, $params);
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

}