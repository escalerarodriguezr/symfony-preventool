<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\OccupationalRisk;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Preventool\Domain\OccupationalRisk\Exception\TaskRiskAssessmentAlreadyExitsException;
use Preventool\Domain\OccupationalRisk\Exception\TaskRiskAssessmentNotFoundException;
use Preventool\Domain\OccupationalRisk\Model\TaskRiskAssessment;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskAssessmentRepository;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;

class DoctrineTaskRiskAssessmentRepository extends DoctrineBaseRepository implements TaskRiskAssessmentRepository
{
    protected static function entityClass(): string
    {
        return TaskRiskAssessment::class;
    }

    public function save(TaskRiskAssessment $model): void
    {
        try{
            $this->saveEntity($model);

        }catch (UniqueConstraintViolationException $exception){
            throw TaskRiskAssessmentAlreadyExitsException::withTaskRiskId($model->getTaskRisk()->getId());
        }
    }

    public function delete(TaskRiskAssessment $model): void
    {
        $this->removeEntity($model);
    }

    public function findById(Uuid $id): TaskRiskAssessment
    {
       $criteria = [
           'id' => $id->value
       ];

       $model = $this->objectRepository->findOneBy($criteria);

       if($model===null){
           throw TaskRiskAssessmentNotFoundException::withId($id);
       }

       return $model;
    }

    public function findByTaskRiskId(Uuid $id): TaskRiskAssessment
    {
        $criteria = [
            'taskRisk' => $id->value
        ];

        $model = $this->objectRepository->findOneBy($criteria);

        if($model===null){
            throw TaskRiskAssessmentNotFoundException::withId($id);
        }

        return $model;
    }


}