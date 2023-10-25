<?php
declare(strict_types=1);

namespace Preventool\Domain\Company\Exception;

use Preventool\Domain\Company\Model\Value\LegalDocument;

class CompanyAlreadyExistsException extends \DomainException
{
    public static function withLegalDocument(LegalDocument $legalDocument)
    {
        throw new self(
            sprintf(
                'Company with %s legalDocument already exists',
                $legalDocument->value
            )
        );
    }

}