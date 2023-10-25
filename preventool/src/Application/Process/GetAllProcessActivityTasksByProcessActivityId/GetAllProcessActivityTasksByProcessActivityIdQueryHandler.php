<?php
declare(strict_types=1);

namespace Preventool\Application\Process\GetAllProcessActivityTasksByProcessActivityId;

use Preventool\Application\Process\Response\ProcessActivityTaskResponse;
use Preventool\Domain\Process\Model\ProcessActivityTask;
use Preventool\Domain\Process\Repository\ProcessActivityTaskRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class GetAllProcessActivityTasksByProcessActivityIdQueryHandler implements QueryHandler
{


    public function __construct(
        private readonly ProcessActivityTaskRepository $processActivityTaskRepository
    )
    {
    }

    public function __invoke(
        GetAllProcessActivityTasksByProcessActivityIdQuery $query
    ):array
    {
        $processActivityId = new Uuid($query->processActivityId);
        $collection = $this->processActivityTaskRepository->getAllByProcessActivityId($processActivityId);
        return array_map(function (ProcessActivityTask $task) use ($processActivityId){
            return (ProcessActivityTaskResponse::createFromModel(
                $task,
                $processActivityId
            ))->toArray();
        },$collection);

    }


}