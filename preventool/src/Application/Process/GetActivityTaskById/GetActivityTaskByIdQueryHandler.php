<?php
declare(strict_types=1);

namespace Preventool\Application\Process\GetActivityTaskById;

use Preventool\Application\Process\Response\ProcessActivityTaskResponse;
use Preventool\Domain\Process\Repository\ProcessActivityTaskRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class GetActivityTaskByIdQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly ProcessActivityTaskRepository $processActivityTaskRepository
    )
    {
    }

    public function __invoke(
        GetActivityTaskByIdQuery $query
    ): ProcessActivityTaskResponse
    {
        $taskId = new Uuid($query->taskId);
        $task = $this->processActivityTaskRepository->findById($taskId);
        return ProcessActivityTaskResponse::createFromModel($task);
    }


}