<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\ActivateWorkplace;

use Preventool\Domain\Shared\Bus\Command\Command;

class ActivateWorkplaceCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $workplaceId
    )
    {
    }
}