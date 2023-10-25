<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\GetWorkplaceOfCompanyById;

use Preventool\Application\Workplace\Response\WorkplaceResponse;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Exception\WorkplaceNotBelongToCompanyException;
use Preventool\Domain\Workplace\Repository\WorkplaceRepository;

class GetWorkplaceOfCompanyByIdQueryHandler implements QueryHandler
{


    public function __construct(
        private readonly WorkplaceRepository $workplaceRepository
    )
    {
    }

    public function __invoke(
        GetWorkplaceOfCompanyByIdQuery $query
    ): WorkplaceResponse
    {

        $workplaceId = new Uuid($query->workplaceId);
        $workplace = $this->workplaceRepository->findById(
            $workplaceId
        );


        $companyId = new Uuid($query->companyId);

        if( $workplace->getCompany()->getId()->value != $companyId->value ){
            throw WorkplaceNotBelongToCompanyException::withWokplaceIdAndCompanyId(
                $workplaceId,
                $companyId
            );
        }

        return WorkplaceResponse::createFromWorkplace($workplace);

    }


}