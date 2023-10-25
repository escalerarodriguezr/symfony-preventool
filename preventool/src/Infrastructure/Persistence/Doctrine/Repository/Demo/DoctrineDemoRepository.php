<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\Demo;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Preventool\Domain\Demo\Model\Demo;
use Preventool\Domain\Demo\Repository\DemoRepository;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;

final class DoctrineDemoRepository extends DoctrineBaseRepository implements DemoRepository
{
    protected static function entityClass(): string
    {
        return Demo::class;
    }

    public function save(Demo $demo): void
    {
        $this->saveEntity($demo);
    }

    public function remove(Demo $demo): void
    {
        $this->removeEntity($demo);
    }


    public function findById(string $id): ?Demo
    {
       return $this->objectRepository->findOneBy(['id' => $id]);
    }


}