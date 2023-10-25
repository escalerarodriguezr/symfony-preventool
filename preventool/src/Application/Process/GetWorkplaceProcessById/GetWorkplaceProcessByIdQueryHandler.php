<?php
declare(strict_types=1);

namespace Preventool\Application\Process\GetWorkplaceProcessById;

use Preventool\Application\Process\Response\ProcessResponse;
use Preventool\Domain\Process\Repository\ProcessRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class GetWorkplaceProcessByIdQueryHandler implements QueryHandler
{


    public function __construct(
        private readonly WorkplaceRepository $workplaceRepository,
        private readonly ProcessRepository $processRepository
    )
    {
    }

    public function __invoke(
        GetWorkplaceProcessByIdQuery $query
    ): ProcessResponse
    {
        $workplaceId = new Uuid($query->workplaceId);
        $processId = new Uuid($query->processId);

        $workplace = $this->workplaceRepository->findById($workplaceId);

        $process = $this->processRepository->findByWorkplaceAndId(
            $workplace,
            $processId
        );

        return ProcessResponse::createFromModel($process);
    }


}