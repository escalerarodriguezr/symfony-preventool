<?php
declare(strict_types=1);

namespace Preventool\Domain\Audit\Exception;

use Aws\signer\Exception\signerException;

class CreateAuditTypeCommandInvalidCommandException extends \DomainException
{
    public static function companyAndWorkplaceSuppliedTogether(): self
    {
        return new self('CompanyId and WorkplaceId can nor be supplied together');
    }

}