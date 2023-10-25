<?php
declare(strict_types=1);

namespace Preventool\Domain\Company\Repository;

use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Company\Model\HealthAndSafetyPolicy;

interface HealthAndSafetyPolicyRepository
{
    public function save(HealthAndSafetyPolicy $healthAndSafetyPolicy): void;
    public function findByCompanyOrNull(Company $company): ?HealthAndSafetyPolicy;

}