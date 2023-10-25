<?php

namespace Preventool\Application\Process\GetAllProcessActivityByProcessId;

use Preventool\Application\Process\Response\ProcessActivityResponse;
use Preventool\Domain\Process\Model\ProcessActivity;
use Preventool\Domain\Process\Repository\ProcessActivityRepository;

use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class GetAllProcessActivityByProcessIdQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly ProcessActivityRepository $processActivityRepository
    )
    {
    }

    public function __invoke(
        GetAllProcessActivityByProcessIdQuery $query
    ): array
    {
        $processId = new Uuid($query->processId);
        $collection = $this->processActivityRepository->getAllByProcessId($processId);
        return array_map(function (ProcessActivity $model) use($processId):array{
            return (ProcessActivityResponse::createFromModel($model, $processId))->toArray();
        }, $collection);

    }
}