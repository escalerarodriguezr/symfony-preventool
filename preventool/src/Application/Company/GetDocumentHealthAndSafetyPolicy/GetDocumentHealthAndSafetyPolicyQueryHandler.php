<?php
declare(strict_types=1);

namespace Preventool\Application\Company\GetDocumentHealthAndSafetyPolicy;

use Preventool\Domain\Company\Exception\CompanyNotFoundException;
use Preventool\Domain\Company\Exception\DocumentHealthAndSafetyPolicyOfCompanyNotFoundException;
use Preventool\Domain\Company\Exception\HealthAndSafetyPolicyOfCompanyNotFoundException;
use Preventool\Domain\Company\Repository\CompanyRepository;
use Preventool\Domain\Company\Repository\HealthAndSafetyPolicyRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Infrastructure\FileStorage\DigitalOceanFileStorageManager;

class GetDocumentHealthAndSafetyPolicyQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly CompanyRepository $companyRepository,
        private readonly HealthAndSafetyPolicyRepository $healthAndSafetyPolicyRepository
    )
    {
    }

    public function __invoke(
        GetDocumentHealthAndSafetyPolicyQuery $query
    ): string
    {

        $companyId = new Uuid($query->companyId);
        $company = $this->companyRepository->findById(
            $companyId
        );

        if( empty($company) ){
            throw CompanyNotFoundException::withId(
                $companyId
            );
        }

        $policy = $this->healthAndSafetyPolicyRepository->findByCompanyOrNull(
            $company
        );

        if( empty($policy) ){
            throw HealthAndSafetyPolicyOfCompanyNotFoundException::withCompanyId(
                $companyId
            );
        }

        if( empty($policy->getDocumentResource()) ){
            throw DocumentHealthAndSafetyPolicyOfCompanyNotFoundException::withCompanyId(
                $companyId
            );
        }



        $prefix = sprintf(
            DigitalOceanFileStorageManager::COMPANY_HEALTH_SAFTEY_POLICY,
            $companyId->value
        );

        $path = sprintf(
            '%s/%s',
            $prefix,
            $policy->getDocumentResource()
        );

        return $path;
    }


}