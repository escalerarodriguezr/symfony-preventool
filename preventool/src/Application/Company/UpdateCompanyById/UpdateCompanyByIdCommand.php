<?php
declare(strict_types=1);

namespace Preventool\Application\Company\UpdateCompanyById;

use Preventool\Domain\Shared\Bus\Command\Command;

class UpdateCompanyByIdCommand implements Command
{

    public function __construct(
        public readonly ?string $actionAdminId,
        public readonly ?string $id,
        public readonly ?string $name,
        public readonly ?string $legalName,
        public readonly ?string $legalDocument,
        public readonly ?string $address,
        public readonly ?string $sector
    )
    {
    }

}