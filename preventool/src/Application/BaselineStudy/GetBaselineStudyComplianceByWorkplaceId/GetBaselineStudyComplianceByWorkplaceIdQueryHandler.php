<?php
declare(strict_types=1);

namespace Preventool\Application\BaselineStudy\GetBaselineStudyComplianceByWorkplaceId;

use Preventool\Application\BaselineStudy\Response\BaselineStudyComplianceResponse;
use Preventool\Domain\BaselineStudy\Repository\BaselineStudyComplianceRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class GetBaselineStudyComplianceByWorkplaceIdQueryHandler implements QueryHandler
{


    public function __construct(
        private readonly WorkplaceRepository $workplaceRepository,
        private readonly BaselineStudyComplianceRepository $studyComplianceRepository
    )
    {
    }

    public function __invoke(
        GetBaselineStudyComplianceByWorkplaceIdQuery $query
    ): BaselineStudyComplianceResponse
    {

        $workPlace = $this->workplaceRepository->findById(
            new Uuid($query->workplaceId)
        );

        $baselineStudyCompliance = $this->studyComplianceRepository->findByWorkplace($workPlace);

        return BaselineStudyComplianceResponse::createFromModel($baselineStudyCompliance);

    }

}