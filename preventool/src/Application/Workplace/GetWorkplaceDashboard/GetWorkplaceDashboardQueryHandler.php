<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\GetWorkplaceDashboard;

use Preventool\Application\Workplace\GetWorkplaceDashboard\Response\WorkplaceDashboardResponse;
use Preventool\Domain\BaselineStudy\Repository\BaselineStudyComplianceRepository;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class GetWorkplaceDashboardQueryHandler implements QueryHandler
{

    public function __construct(
        private readonly WorkplaceRepository $workplaceRepository,
        private readonly BaselineStudyComplianceRepository $baselineStudyComplianceRepository,
        private readonly TaskRiskRepository $taskRiskRepository

    )
    {
    }

    public function __invoke(
        GetWorkplaceDashboardQuery $query
    ): WorkplaceDashboardResponse
    {
        $workplaceId = new Uuid($query->workplaceId);

        $workplace = $this->workplaceRepository->findById($workplaceId);
        $baselineStudyCompliance = $this->baselineStudyComplianceRepository->findByWorkplace($workplace);
        
        $taskRiskCountStatus = $this->taskRiskRepository->countOfStatusByWorkplaceQuery(
            $workplace
        );

        return WorkplaceDashboardResponse::build(
            $baselineStudyCompliance,
            $taskRiskCountStatus
        );

    }


}