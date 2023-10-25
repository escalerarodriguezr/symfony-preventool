<?php
declare(strict_types=1);

namespace Preventool\Domain\Company\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class HealthAndSafetyPolicyOfCompanyNotFoundException extends \DomainException
{
    public static function withCompanyId(Uuid $id): self
    {
        throw new self(sprintf(
            'Health and Safety Policy of Company with id "%s" not found',
            $id->value
            )
        );
    }

}