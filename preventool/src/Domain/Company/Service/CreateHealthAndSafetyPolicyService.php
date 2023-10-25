<?php
declare(strict_types=1);

namespace Preventool\Domain\Company\Service;

use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Company\Model\HealthAndSafetyPolicy;
use Preventool\Domain\Company\Repository\HealthAndSafetyPolicyRepository;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Domain\Shared\Model\Value\DocumentStatus;
use Preventool\Domain\Shared\Model\Value\Uuid;

class CreateHealthAndSafetyPolicyService
{


    public function __construct(
        private readonly HealthAndSafetyPolicyRepository $healthAndSafetyPolicyRepository,
        protected readonly IdentityGenerator $identityGenerator

    )
    {
    }

    public function __invoke(
        Company $company,
        Admin $actionAdmin
    ): HealthAndSafetyPolicy
    {
        $policyId = new Uuid($this->identityGenerator->generateId());
        $policy = new HealthAndSafetyPolicy(
            $policyId,
            $company,
            new DocumentStatus(DocumentStatus::PENDING)
        );


        $policy->setCreatorAdmin(
            $actionAdmin
        );

        $this->healthAndSafetyPolicyRepository->save(
            $policy
        );

        return $policy;
    }


}