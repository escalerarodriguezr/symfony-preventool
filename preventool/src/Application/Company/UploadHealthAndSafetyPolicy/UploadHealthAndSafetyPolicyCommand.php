<?php
declare(strict_types=1);

namespace Preventool\Application\Company\UploadHealthAndSafetyPolicy;

use Preventool\Domain\Shared\Bus\Command\Command;

class UploadHealthAndSafetyPolicyCommand implements Command
{
    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $companyId,
        public readonly string $documentResource
    )
    {
    }


}