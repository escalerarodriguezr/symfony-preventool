<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Service;

use Preventool\Domain\BaselineStudy\Model\BaselineStudy;
use Preventool\Domain\BaselineStudy\Repository\BaselineStudyComplianceRepository;
use Preventool\Domain\BaselineStudy\Repository\BaselineStudyRepository;
use Preventool\Domain\Shared\Model\Value\CompliancePercentage;
use Preventool\Domain\Shared\Model\Value\Uuid;


class UpdateBaselineStudyComplianceByIndicator
{
    public function __construct(
        private readonly BaselineStudyRepository $baselineStudyRepository,
        private readonly BaselineStudyComplianceRepository $complianceRepository
    )
    {
    }

    public function __invoke(Uuid $indicatorId): void
    {

        $indicator = $this->baselineStudyRepository->findById($indicatorId);
        $workplace = $indicator->getWorkplace();
        $category = $indicator->getCategory();

        $allCategoryIndicators = $this->baselineStudyRepository->findAllByWorkplaceAndCategory(
            $workplace,
            $category
        );

        $categoryTotal = 0;

        /**
         * @var BaselineStudy $categoryIndicator
         */
        foreach ($allCategoryIndicators as $categoryIndicator){
            $categoryTotal += $categoryIndicator->getCompliancePercentage()->value;
        }

        $categoryPercentage = floor(
            $categoryTotal/(count($allCategoryIndicators))
        );

        $categoryPercentage = intval($categoryPercentage);

        $baselineStudyCompliance = $this->complianceRepository->findByWorkplace(
            $workplace
        );

        $baselineStudyCompliance->recalculateByCategoryAndCategoryPercentage(
            $category,
            new CompliancePercentage($categoryPercentage)
        );

        $this->complianceRepository->save($baselineStudyCompliance);
    }

}