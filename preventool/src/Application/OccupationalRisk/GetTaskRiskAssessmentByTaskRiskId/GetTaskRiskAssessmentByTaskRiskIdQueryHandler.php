<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\GetTaskRiskAssessmentByTaskRiskId;

use Preventool\Application\OccupationalRisk\Response\TaskRiskAssessmentResponse;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class GetTaskRiskAssessmentByTaskRiskIdQueryHandler implements QueryHandler
{

    public function __construct(
        private readonly TaskRiskRepository $taskRiskRepository
    )
    {
    }

    public function __invoke(
        GetTaskRiskAssessmentByTaskRiskIdQuery $query
    ): ?TaskRiskAssessmentResponse
    {
        $taskRiskId = new Uuid($query->taskRiskId);
        $taskRisk = $this->taskRiskRepository->findById($taskRiskId);
        $taskRiskAssessment = $taskRisk->getTaskRiskAssessment();

        if($taskRiskAssessment === null){
            return null;
        }

        return TaskRiskAssessmentResponse::createFromModel($taskRiskAssessment);

    }


}