<?php

namespace Preventool\Application\BaselineStudy\GetWorkplaceBaselineStudyIndicatorsByCategory;

use Preventool\Domain\BaselineStudy\Model\BaselineStudy;
use Preventool\Domain\BaselineStudy\Model\Value\BaselineIndicatorCategory;
use Preventool\Domain\BaselineStudy\Repository\BaselineStudyRepository;
use Preventool\Domain\BaselineStudy\Service\GetBaselineStudyIndicatorsService;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class GetWorkplaceBaselineStudyIndicatorsByCategoryQueryHandler implements QueryHandler
{


    public function __construct(
        private readonly WorkplaceRepository $workplaceRepository,
        private readonly BaselineStudyRepository $baselineStudyRepository,
        private readonly GetBaselineStudyIndicatorsService $indicatorsService

    )
    {
    }

    public function __invoke(
        GetWorkplaceBaselineStudyIndicatorsByCategoryQuery $query
    ): array
    {
        $workplaceId = new Uuid($query->workplaceId);
        $workplace = $this->workplaceRepository->findById($workplaceId);

        $baselineCategoryIndicator = new BaselineIndicatorCategory($query->category);

        $baselineStudyValues = $this->baselineStudyRepository->findAllByWorkplaceAndCategory(
            $workplace,
            $baselineCategoryIndicator
        );

        $indicators = $this->indicatorsService->__invoke();

        $valuesArray = [];
        foreach ($baselineStudyValues as $studyValue){
            /**
             * @var BaselineStudy $studyValue
             */

            $valuesArray[$studyValue->getIndicator()]['compliancePercentage'] = $studyValue->getCompliancePercentage()->value;
            $valuesArray[$studyValue->getIndicator()]['observations'] = $studyValue->getObservations()?->value;

        }

        $categoryIndicators = [];
        foreach ($indicators[$baselineCategoryIndicator->value]['indicators'] as $indicator){
            $indicator['compliancePercentage'] = $valuesArray[$indicator['id']]['compliancePercentage'];
            $indicator['observations'] = $valuesArray[$indicator['id']]['observations'];
            $categoryIndicators[] = $indicator;
        }

        return $categoryIndicators;
    }


}