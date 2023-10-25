<?php
declare(strict_types=1);

namespace Preventool\Domain\Workplace\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class WorkplaceNotFoundException extends \DomainException
{
    public static function withId(Uuid $id): self
    {
        return new self(
            sprintf('Workplace with id "%s" not found',$id->value)
        );
    }

}