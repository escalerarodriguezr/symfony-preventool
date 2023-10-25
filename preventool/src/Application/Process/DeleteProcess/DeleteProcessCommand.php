<?php
declare(strict_types=1);

namespace Preventool\Application\Process\DeleteProcess;

use Preventool\Domain\Shared\Bus\Command\Command;

class DeleteProcessCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $workplaceId,
        public readonly string $processId
    )
    {
    }
}