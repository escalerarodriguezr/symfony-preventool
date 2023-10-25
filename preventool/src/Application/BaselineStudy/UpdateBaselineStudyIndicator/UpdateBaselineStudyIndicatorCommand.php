<?php
declare(strict_types=1);

namespace Preventool\Application\BaselineStudy\UpdateBaselineStudyIndicator;

use Preventool\Domain\Shared\Bus\Command\Command;

class UpdateBaselineStudyIndicatorCommand implements Command
{


    public function __construct(
        public readonly string $actionAdminId,
        public readonly string $workplaceId,
        public readonly string $indicator,
        public readonly ?int $compliancePercentage,
        public readonly ?string $observations
    )
    {
    }
}