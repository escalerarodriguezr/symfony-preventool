<?php
declare(strict_types=1);

namespace Preventool\Domain\Workplace\Exception;

use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Shared\Model\Value\Name;

class WorkplaceAlreadyExistsException extends \DomainException
{
    public static function forCompanyWithName(
        Company $company,
        Name $name
    ): self
    {
        throw new self(
            sprintf('Workplace with %s name already exists for the company %s',
            $name->value,
            $company->getLegalName()->value
            )
        );
    }

}