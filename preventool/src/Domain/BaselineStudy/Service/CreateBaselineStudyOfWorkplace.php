<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Service;


use Preventool\Domain\BaselineStudy\Model\BaselineStudy;
use Preventool\Domain\BaselineStudy\Model\Value\BaselineIndicatorCategory;
use Preventool\Domain\BaselineStudy\Repository\BaselineStudyRepository;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Domain\Shared\Model\Value\CompliancePercentage;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class CreateBaselineStudyOfWorkplace
{


    public function __construct(
        private readonly GetBaselineStudyIndicatorsService $indicatorsService,
        private readonly BaselineStudyRepository $baselineStudyRepository,
        private readonly IdentityGenerator $identityGenerator
    )
    {
    }

    public function __invoke(
        Workplace $workplace
    ): void
    {

        $categoryIndicators = $this->indicatorsService->__invoke();

        foreach ($categoryIndicators as $categoryIndicator){
            $indicators = $categoryIndicator['indicators'];
            foreach ($indicators as $indicator){
                $this->processIndicator(
                    $indicator['id'],
                    $indicator['category'],
                    $workplace
                );
            }
        }
    }

    private function processIndicator(
        string $indicator,
        string $category,
        Workplace $workplace
    ):void
    {

        $uuid = new Uuid($this->identityGenerator->generateId());
        $baselineCategoryIndicator = new BaselineIndicatorCategory($category);

        $baselineIndicator = new BaselineStudy(
            $uuid,
            $workplace,
            $baselineCategoryIndicator,
            $indicator,
            new CompliancePercentage(0)
        );

        $baselineIndicator->setCreatorAdmin(
            $workplace->getCreatorAdmin()
        );

        $this->baselineStudyRepository->save($baselineIndicator);

    }

}