<?php

namespace Preventool\Application\BaselineStudy\GetBaselineStudyIndicators;

use Preventool\Domain\BaselineStudy\Service\GetBaselineStudyIndicatorsService;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;

class GetBaselineStudyIndicatorsQueryHandler implements QueryHandler
{


    public function __construct(
        private readonly GetBaselineStudyIndicatorsService $getBaselineStudyIndicatorsService
    )
    {
    }

    public function __invoke(
        GetBaselineStudyIndicatorsQuery $query
    ): array
    {
        return $this->getBaselineStudyIndicatorsService->__invoke();
    }


}