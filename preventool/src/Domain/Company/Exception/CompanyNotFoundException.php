<?php
declare(strict_types=1);

namespace Preventool\Domain\Company\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class CompanyNotFoundException extends \DomainException
{
    public static function withId(Uuid $id): self
    {
        throw new self(sprintf('Company with id "%s" not found', $id->value));
    }

}