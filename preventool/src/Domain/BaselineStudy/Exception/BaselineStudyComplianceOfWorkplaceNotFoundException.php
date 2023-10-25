<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Exception;

use Preventool\Domain\Workplace\Model\Workplace;

class BaselineStudyComplianceOfWorkplaceNotFoundException extends \DomainException
{
    public static function forWorkplace(Workplace $workplace):self
    {
        return new self(
            sprintf(
                'BaselineStudyCompliance of workplace %s not found',
                $workplace->getId()->value
            )
        );
    }

}