<?php
declare(strict_types=1);

namespace Preventool\Application\Process\UpdateProcessActivityTask;

use Preventool\Domain\Shared\Bus\Command\Command;

class UpdateProcessActivityTaskCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $taskId,
        public readonly ?string $name,
        public readonly ?string $description
    )
    {
    }
}