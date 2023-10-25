<?php
declare(strict_types=1);

namespace Preventool\Application\Process\GetProcessActivityById;

use Preventool\Application\Process\Response\ProcessActivityResponse;
use Preventool\Domain\Process\Repository\ProcessActivityRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class GetProcessActivityByIdQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly ProcessActivityRepository $processActivityRepository
    )
    {
    }

    public function __invoke(
        GetProcessActivityByIdQuery $query
    ): ProcessActivityResponse
    {
        $id = new Uuid($query->id);
        $processActivity = $this->processActivityRepository->findById($id);
        return ProcessActivityResponse::createFromModel($processActivity);
    }

}