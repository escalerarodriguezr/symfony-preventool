<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Exception;

use Preventool\Domain\Workplace\Model\Workplace;

class BaselineStudyComplianceOfWorkplaceAlreadyExistsException extends \DomainException
{
    public static function forWorkplace(Workplace $workplace):self
    {
        return new self(
            sprintf(
                'BaselineStudyCompliance of workplace %s already exists',
                $workplace->getId()->value
            )
        );
    }

}