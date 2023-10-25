<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\DeleteWorkplace;

use Preventool\Domain\Shared\Bus\Command\Command;

class DeleteWorkplaceCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $companyId,
        public readonly string $workplaceId
    )
    {
    }
}