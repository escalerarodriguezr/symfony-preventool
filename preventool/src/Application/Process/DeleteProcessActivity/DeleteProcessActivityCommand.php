<?php
declare(strict_types=1);

namespace Preventool\Application\Process\DeleteProcessActivity;

use Preventool\Domain\Shared\Bus\Command\Command;

class DeleteProcessActivityCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $activityId
    )
    {
    }
}