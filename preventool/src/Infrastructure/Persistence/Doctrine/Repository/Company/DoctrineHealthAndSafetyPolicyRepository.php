<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\Repository\Company;

use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Company\Model\HealthAndSafetyPolicy;
use Preventool\Domain\Company\Repository\HealthAndSafetyPolicyRepository;
use Preventool\Infrastructure\Persistence\Doctrine\Repository\DoctrineBaseRepository;

class DoctrineHealthAndSafetyPolicyRepository extends DoctrineBaseRepository implements HealthAndSafetyPolicyRepository
{
    protected static function entityClass(): string
    {
        return HealthAndSafetyPolicy::class;
    }

    public function save(
        HealthAndSafetyPolicy $healthAndSafetyPolicy
    ): void
    {
        $this->saveEntity($healthAndSafetyPolicy);
    }

    public function findByCompanyOrNull(Company $company): ?HealthAndSafetyPolicy
    {
        return $this->objectRepository->findOneBy([
            'company' => $company->getId()->value
        ]);
    }


}