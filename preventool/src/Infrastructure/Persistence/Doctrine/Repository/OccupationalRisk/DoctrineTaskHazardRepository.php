<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\OccupationalRisk;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Preventool\Domain\OccupationalRisk\Exception\TaskHazardAlreadyExitsException;
use Preventool\Domain\OccupationalRisk\Exception\TaskHazardNotFoundException;
use Preventool\Domain\OccupationalRisk\Model\TaskHazard;
use Preventool\Domain\OccupationalRisk\Repository\TaskHazardRepository;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;

class DoctrineTaskHazardRepository extends DoctrineBaseRepository implements TaskHazardRepository
{
    protected static function entityClass(): string
    {
        return TaskHazard::class;
    }

    public function save(TaskHazard $taskHazard): void
    {
        try {
            $this->saveEntity($taskHazard);
        }catch (UniqueConstraintViolationException $exception){
            throw TaskHazardAlreadyExitsException::withTaskIdAndHazardId(
                $taskHazard->getTask()->getId(),
                $taskHazard->getHazard()->getId()
            );
        }
    }

    public function getAllByTaskId(Uuid $taskId): array
    {
        $criteria = [
            'task' => $taskId->value
        ];

        $order = [
            'createdAt' => 'DESC'
        ];

        return $this->objectRepository->findBy($criteria,$order);
    }

    public function findById(Uuid $id): TaskHazard
    {
        $criteria = [
            'id' => $id->value
        ];

        $model = $this->objectRepository->findOneBy($criteria);

        if ($model === null){
            throw TaskHazardNotFoundException::withId($id);
        }

        return $model;

    }


    public function delete(TaskHazard $model): void
    {
        $this->removeEntity($model);
    }


}