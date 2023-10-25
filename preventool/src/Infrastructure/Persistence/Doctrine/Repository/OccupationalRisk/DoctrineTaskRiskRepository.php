<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\OccupationalRisk;

use Preventool\Application\OccupationalRisk\Response\TaskRiskResponse;
use Preventool\Domain\OccupationalRisk\Exception\TaskRiskNotFoundException;
use Preventool\Domain\OccupationalRisk\Model\TaskRisk;
use Preventool\Domain\OccupationalRisk\Model\Value\TaskRiskStatus;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository\CountOfStatusByWorkplaceQueryResponse;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;

class DoctrineTaskRiskRepository extends DoctrineBaseRepository implements TaskRiskRepository
{
    protected static function entityClass(): string
    {
        return TaskRisk::class;
    }

    public function save(TaskRisk $taskRisk): void
    {
        $this->saveEntity($taskRisk);
    }

    public function findById(Uuid $id): TaskRisk
    {
        $criteria = [
            'id' => $id->value
        ];
       $model = $this->objectRepository->findOneBy($criteria);

       if($model === null){
           throw TaskRiskNotFoundException::withId($id);
       }

       return $model;
    }

    public function delete(TaskRisk $model): void
    {
        $this->removeEntity($model);
    }

    public function countOfStatusByWorkplaceQuery(Workplace $workplace): CountOfStatusByWorkplaceQueryResponse
    {
        $query =
        <<<'SQL'
            SELECT
                COUNT(tr.id) as total,
                CAST(SUM(IF(tr.status = :pending, 1, 0)) as integer) as pending,
                CAST(SUM(IF(tr.status = :draft, 1, 0)) as integer) as draft,
                CAST(SUM(IF(tr.status = :revised, 1, 0)) as integer) as revised,
                CAST(SUM(IF(tr.status = :approved, 1, 0)) as integer) as approved
            FROM task_risk tr
                INNER JOIN task_hazard th ON tr.task_hazard_id = th.id
                INNER JOIN process_activity_task pat on th.process_activity_task_id = pat.id
                INNER JOIN process_activity pa on pat.process_activity_id = pa.id
                INNER JOIN process p on pa.process_id = p.id
            WHERE p.workplace_id = :workplaceId
            AND th.deleted_at IS NULL 
        SQL;


        $params = [
            'pending' => TaskRiskStatus::PENDING_ASSESSMENT,
            'draft' => TaskRiskStatus::DRAFT_ASSESSMENT,
            'revised' => TaskRiskStatus::REVISED_ASSESSMENT,
            'approved' => TaskRiskStatus::APPROVED_ASSESSMENT,
            'workplaceId' => $workplace->getId()->value,
        ];

        $response = $this->executeFetchQuery($query,$params)[0];

        return new CountOfStatusByWorkplaceQueryResponse(
            $response['total'],
            $response['pending'] ?? 0,
            $response['draft'] ?? 0,
            $response['revised'] ?? 0,
            $response['approved'] ?? 0,
        );


        //        $query = sprintf(
//        'SELECT
//            COUNT(tr.id) as Total,
//            CAST(SUM(IF(tr.status = "%s", 1, 0)) as integer) as pending,
//            CAST(SUM(IF(tr.status = "%s", 1, 0)) as integer) as draft,
//            CAST(SUM(IF(tr.status = "%s", 1, 0)) as integer) as revised,
//            CAST(SUM(IF(tr.status = "%s", 1, 0)) as integer) as approved
//        FROM task_risk tr
//            INNER JOIN task_hazard th ON tr.task_hazard_id = th.id
//            INNER JOIN process_activity_task pat on th.process_activity_task_id = pat.id
//            INNER JOIN process_activity pa on pat.process_activity_id = pa.id
//            INNER JOIN process p on pa.process_id = p.id
//        WHERE p.workplace_id = "%s"',
//            TaskRiskStatus::PENDING_ASSESSMENT,
//            TaskRiskStatus::DRAFT_ASSESSMENT,
//            TaskRiskStatus::REVISED_ASSESSMENT,
//            TaskRiskStatus::APPROVED_ASSESSMENT,
//            $workplace->getId()->value
//        );
//
//
//
//        $response = $this->getConnection()->executeQuery($query)->fetchAllAssociative();

    }


}