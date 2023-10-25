<?php
declare(strict_types=1);

namespace Preventool\Application\AuditType\CreateAuditType;

use Preventool\Domain\Shared\Bus\Command\Command;

class CreateAuditTypeCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?string $companyId,
        public readonly ?string $workplaceId
    )
    {
    }
}