<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\Process;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Preventool\Domain\Process\Exception\ProcessActivityTaskAlreadyExistsException;
use Preventool\Domain\Process\Exception\ProcessActivityTaskNotFoundException;
use Preventool\Domain\Process\Model\ProcessActivityTask;
use Preventool\Domain\Process\Repository\ProcessActivityTaskRepository;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;

final class DoctrineProcessActivityTaskRepository extends DoctrineBaseRepository implements ProcessActivityTaskRepository
{
    protected static function entityClass(): string
    {
        return ProcessActivityTask::class;
    }

    public function save(ProcessActivityTask $processActivityTask): void
    {
        try {
            $this->saveEntity($processActivityTask);
        }catch (UniqueConstraintViolationException $exception) {
            throw ProcessActivityTaskAlreadyExistsException::withNameForProcessActivity(
                $processActivityTask->getName(),
                $processActivityTask->getProcessActivity()
            );
        }
    }

    public function delete(ProcessActivityTask $processActivityTask): void
    {
        $this->removeEntity($processActivityTask);
    }


    public function findById(Uuid $id): ProcessActivityTask
    {
        $criteria = [
            'id' => $id->value
        ];
        $model = $this->objectRepository->findOneBy($criteria);

        if($model === null){
            throw ProcessActivityTaskNotFoundException::withId($id);
        }

        return $model;
    }

    public function getAllByProcessActivityId(Uuid $processActivityId): array
    {
        $criteria = [
            'processActivity' => $processActivityId->value
        ];
        $order = [
            'taskOrder' => 'ASC'
        ];

        return $this->objectRepository->findBy(
            $criteria,
            $order
        );
    }


}