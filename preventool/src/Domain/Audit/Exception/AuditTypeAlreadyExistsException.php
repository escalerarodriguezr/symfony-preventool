<?php

namespace Preventool\Domain\Audit\Exception;

use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Workplace\Model\Workplace;

class AuditTypeAlreadyExistsException extends \DomainException
{
    public static function forSystemWithName(
        Name $auditTypeName
    ): self
    {
        return new self(
            sprintf(
                'System AuditType with name: %s already exists',
                $auditTypeName->value
            )
        );
    }

    public static function forCompanyWithName(
        Name $auditTypeName,
        Company $company
    ): self
    {
        return new self(
            sprintf(
                'AuditType with name: %s for company %s already exists',
                $auditTypeName->value,
                $company->getId()->value
            )
        );
    }

    public static function forWorkplaceWithName(
        Name $auditTypeName,
        Workplace $workplace
    ): self
    {
        return new self(
            sprintf(
                'AuditType with name: %s for workplace %s already exists',
                $auditTypeName->value,
                $workplace->getId()->value
            )
        );
    }

}