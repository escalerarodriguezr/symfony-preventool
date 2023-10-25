<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\UpdateWorkplace;

use Preventool\Domain\Shared\Bus\Command\Command;

class UpdateWorkplaceCommand implements Command
{
    public function __construct(
        public readonly ?string $actionAdminId,
        public readonly ?string $companyId,
        public readonly  ?string $id,
        public readonly ?string $name,
        public readonly ?string $contactPhone,
        public readonly ?string $address,
        public readonly ?int $numberOfWorkers
    )
    {
    }

}