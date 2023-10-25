<?php
declare(strict_types=1);

namespace Preventool\Application\Company\ApproveHealthAndSafetyPolicy;

use Preventool\Domain\Shared\Bus\Command\Command;

class ApproveHealthAndSafetyPolicyCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $companyId
    )
    {
    }
}