<?php
declare(strict_types=1);

namespace Preventool\Domain\Workplace\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class WorkplaceNotBelongToCompanyException extends \DomainException
{
    public static function withWokplaceIdAndCompanyId(Uuid $workplaceId, Uuid $companyId): self
    {
        return new self(
            sprintf(
                'Workplace with id "%s" not belong to Company with id %s',
                $workplaceId->value,
                $companyId->value
            )
        );
    }

}