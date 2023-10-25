<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\GetTaskRiskById;

use Preventool\Application\OccupationalRisk\Response\TaskRiskResponse;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class GetTaskRiskByIdQueryHandler implements QueryHandler
{


    public function __construct(
        private readonly TaskRiskRepository $taskRiskRepository
    )
    {
    }

    public function __invoke(
        GetTaskRiskByIdQuery $query
    ): TaskRiskResponse
    {
        $taskRiskId = new Uuid($query->taskRiskId);
        $taskRisk = $this->taskRiskRepository->findById($taskRiskId);
        return TaskRiskResponse::createFromModel($taskRisk);
    }


}