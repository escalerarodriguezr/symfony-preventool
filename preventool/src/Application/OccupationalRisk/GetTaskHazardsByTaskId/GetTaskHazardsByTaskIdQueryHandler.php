<?php
declare(strict_types=1);

namespace Preventool\Application\OccupationalRisk\GetTaskHazardsByTaskId;

use Preventool\Application\OccupationalRisk\Response\TaskHazardResponse;
use Preventool\Application\WorkplaceHazard\Response\WorkplaceHazardResponse;
use Preventool\Domain\OccupationalRisk\Model\TaskHazard;
use Preventool\Domain\OccupationalRisk\Repository\TaskHazardRepository;
use Preventool\Domain\Process\Repository\ProcessActivityTaskRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazard;

class GetTaskHazardsByTaskIdQueryHandler implements QueryHandler
{

    public function __construct(
        private readonly TaskHazardRepository $taskHazardRepository
    )
    {
    }

    public function __invoke(
        GetTaskHazardsByTaskIdQuery $query
    ): array
    {
        $taskId = new Uuid($query->taskId);
        $taskHazards = $this->taskHazardRepository->getAllByTaskId($taskId);
        return array_map(fn (TaskHazard $model)=>TaskHazardResponse::createFromModel($model),$taskHazards);
    }


}