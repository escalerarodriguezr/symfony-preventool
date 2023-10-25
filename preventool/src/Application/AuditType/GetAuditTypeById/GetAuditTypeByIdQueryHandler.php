<?php
declare(strict_types=1);

namespace Preventool\Application\AuditType\GetAuditTypeById;

use Aws\Middleware;
use Preventool\Application\AuditType\Response\AuditTypeResponse;
use Preventool\Domain\Audit\Repository\AuditTypeRepository;
use Preventool\Domain\Shared\Bus\Query\QueryHandler;
use Preventool\Domain\Shared\Model\Value\Uuid;

class GetAuditTypeByIdQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly AuditTypeRepository $auditTypeRepository
    )
    {
    }

    public function __invoke(
        GetAuditTypeByIdQuery $command
    ): AuditTypeResponse
    {
        $auditTypeId = new Uuid($command->id);
        $auditType = $this->auditTypeRepository->findById($auditTypeId);
        return AuditTypeResponse::createFromModel($auditType);
    }


}