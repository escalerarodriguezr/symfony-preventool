<?php
declare(strict_types=1);

namespace Preventool\Application\Process\DeleteActivityTask;

use Preventool\Domain\Shared\Bus\Command\Command;

class DeleteActivityTaskCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $taskId
    )
    {
    }
}