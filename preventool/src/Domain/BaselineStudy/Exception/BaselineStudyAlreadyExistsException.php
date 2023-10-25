<?php
declare(strict_types=1);

namespace Preventool\Domain\BaselineStudy\Exception;

use Preventool\Domain\Workplace\Model\Workplace;

class BaselineStudyAlreadyExistsException extends \DomainException
{
    public static function forWorkplace(Workplace $workplace): self
    {
        return new self(
            sprintf(
                'BaselineStudy already exists for worplace %s',
                $workplace->getId()->value
            )
        );
    }

}