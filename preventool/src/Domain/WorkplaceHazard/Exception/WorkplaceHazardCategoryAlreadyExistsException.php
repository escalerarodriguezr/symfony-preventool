<?php
declare(strict_types=1);

namespace Preventool\Domain\WorkplaceHazard\Exception;

use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;

class WorkplaceHazardCategoryAlreadyExistsException extends \DomainException
{
    public static function withNameForWorkplace(
        Name $name,
        Uuid $workplaceId
    ): self
    {
        return new self(
            sprintf(
                'WorkplaceHazardCategory with name %s already exists for workplace %s',
                $name->value,
                $workplaceId->value
            )
        );
    }

}