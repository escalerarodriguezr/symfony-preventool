<?php
declare(strict_types=1);

namespace Preventool\Application\Company\Response;

use DateTimeInterface;
use Preventool\Domain\Company\Model\Company;

class CompanyResponse
{
    const ID = 'id';
    const NAME = 'name';
    const LEGAL_NAME = 'legalName';
    const LEGAL_DOCUMENT = 'legalDocument';
    const ADDRESS = 'address';
    const SECTOR = 'sector';
    const ACTIVE = 'active';
    const CREATOR_ID = 'creatorId';
    const UPDATER_ID = 'updaterId';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    private function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $legalName,
        public readonly string $legalDocument,
        public readonly string $address,
        public readonly string $sector,
        public readonly bool $active,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt

    )
    {
    }

    public static function createFromCompany(
        Company $company
    ): self
    {
        return new self(
            $company->getId()->value,
            $company->getName()->value,
            $company->getLegalName()->value,
            $company->getLegalDocument()->value,
            $company->getAddress()->value,
            $company->getSector()->value,
            $company->isActive(),
            $company->getCreatorAdmin() ? $company->getCreatorAdmin()->getId()->value : null,
            $company->getUpdaterAdmin() ? $company->getUpdaterAdmin()->getId()->value : null,
            $company->getCreatedAt(),
            $company->getUpdatedAt()
        );
    }

    public function toArray(): array
    {
        return [
            self::ID => $this->id,
            self::NAME => $this->name,
            self::LEGAL_NAME => $this->legalName,
            self::LEGAL_DOCUMENT => $this->legalDocument,
            self::ADDRESS => $this->address,
            self::SECTOR => $this->sector,
            self::ACTIVE => $this->active,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339),
        ];
    }


}