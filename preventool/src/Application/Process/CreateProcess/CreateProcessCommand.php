<?php
declare(strict_types=1);

namespace Preventool\Application\Process\CreateProcess;

use Preventool\Domain\Shared\Bus\Command\Command;

class CreateProcessCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $workplaceId,
        public readonly string $processId,
        public readonly string $name,
        public readonly ?string $description
    )
    {
    }
}