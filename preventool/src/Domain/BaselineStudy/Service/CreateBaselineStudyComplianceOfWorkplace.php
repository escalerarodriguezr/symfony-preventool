<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Service;

use Preventool\Domain\BaselineStudy\Model\BaselineStudyCompliance;
use Preventool\Domain\BaselineStudy\Repository\BaselineStudyComplianceRepository;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Domain\Shared\Model\Value\CompliancePercentage;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class CreateBaselineStudyComplianceOfWorkplace
{


    public function __construct(
        private readonly IdentityGenerator $identityGenerator,
        private readonly BaselineStudyComplianceRepository $studyComplianceRepository


    )
    {
    }

    public function __invoke(
        Workplace $workplace
    ): void
    {

        $uuid = new Uuid($this->identityGenerator->generateId());
        $zeroCompliancePercentage = new CompliancePercentage(0);

        $baselineStudyCompliance = new BaselineStudyCompliance(
            $uuid,
            $workplace,
            $zeroCompliancePercentage,
            $zeroCompliancePercentage,
            $zeroCompliancePercentage,
            $zeroCompliancePercentage,
            $zeroCompliancePercentage,
            $zeroCompliancePercentage,
            $zeroCompliancePercentage,
            $zeroCompliancePercentage,
            $zeroCompliancePercentage
        );

        $baselineStudyCompliance->setCreatorAdmin($workplace->getCreatorAdmin());

        $this->studyComplianceRepository->save($baselineStudyCompliance);
    }


}