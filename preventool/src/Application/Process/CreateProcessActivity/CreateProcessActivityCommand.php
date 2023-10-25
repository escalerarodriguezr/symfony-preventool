<?php
declare(strict_types=1);

namespace Preventool\Application\Process\CreateProcessActivity;

use Preventool\Domain\Shared\Bus\Command\Command;

class CreateProcessActivityCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $processId,
        public readonly string $activityId,
        public readonly string $name,
        public readonly ?string $description
    )
    {
    }
}