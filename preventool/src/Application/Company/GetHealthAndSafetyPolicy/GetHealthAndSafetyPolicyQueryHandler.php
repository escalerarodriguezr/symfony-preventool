<?php
declare(strict_types=1);

namespace Preventool\Application\Company\GetHealthAndSafetyPolicy;

use Preventool\Application\Company\Response\HealthAndSafetyPolicyResponse;
use Preventool\Domain\Admin\Repository\AdminRepository;
use Preventool\Domain\Company\Exception\HealthAndSafetyPolicyOfCompanyNotFoundException;
use Preventool\Domain\Company\Repository\CompanyRepository;
use Preventool\Domain\Company\Repository\HealthAndSafetyPolicyRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class GetHealthAndSafetyPolicyQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly CompanyRepository $companyRepository,
        private readonly HealthAndSafetyPolicyRepository $healthAndSafetyPolicyRepository
    )
    {
    }

    public function __invoke(
        GetHealthAndSafetyPolicyQuery $query
    ): HealthAndSafetyPolicyResponse
    {
        $companyId = new Uuid($query->companyId);

        $company = $this->companyRepository->findById(
            $companyId
        );

        $policy = $this->healthAndSafetyPolicyRepository->findByCompanyOrNull(
            $company
        );

        if( empty($policy) ){
            throw HealthAndSafetyPolicyOfCompanyNotFoundException::withCompanyId(
                $companyId
            );
        }

        return HealthAndSafetyPolicyResponse::createFromModel(
            $policy
        );

    }


}