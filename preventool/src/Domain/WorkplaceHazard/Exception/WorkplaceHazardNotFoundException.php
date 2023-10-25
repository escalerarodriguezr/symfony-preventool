<?php
declare(strict_types=1);

namespace Preventool\Domain\WorkplaceHazard\Exception;

use Preventool\Domain\Shared\Model\Value\Uuid;

class WorkplaceHazardNotFoundException extends \DomainException
{
    public static function withId(Uuid $id):self
    {
        return new self(
            sprintf(
                'WorkplaceHazard with id %s not found',
                $id->value
            )
        );
    }

}