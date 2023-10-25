<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\Response;

use DateTimeInterface;
use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class WorkplaceResponse
{
    const ID = 'id';
    const COMPANY_ID = 'companyId';
    const NAME = 'name';
    const CONTACT_PHONE = 'contactPhone';

    const ADDRESS = 'address';
    const NUMBER_OF_WORKERS = 'numberOfWorkers';
    const ACTIVE = 'active';
    const CREATOR_ID = 'creatorId';
    const UPDATER_ID = 'updaterId';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    private function __construct(
        public readonly string $id,
        public readonly string $companyId,
        public readonly string $name,
        public readonly string $contactPhone,
        public readonly string $address,
        public readonly int $numberOfWorkers,
        public readonly bool $active,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt

    )
    {
    }

    public static function createFromWorkplaceAndCompanyId(
        Workplace $workplace,
        ?Uuid $companyId
    ): self
    {
        return new self(
            $workplace->getId()->value,
            $companyId->value,
            $workplace->getName()->value,
            $workplace->getContactPhone()->value,
            $workplace->getAddress()->value,
            $workplace->getNumberOfWorkers(),
            $workplace->isActive(),
            $workplace->getCreatorAdmin() ? $workplace->getCreatorAdmin()->getId()->value : null,
            $workplace->getUpdaterAdmin() ? $workplace->getUpdaterAdmin()->getId()->value : null,
            $workplace->getCreatedAt(),
            $workplace->getUpdatedAt()
        );
    }

    public static function createFromWorkplace(
        Workplace $workplace
    ): self
    {
        return new self(
            $workplace->getId()->value,
            $workplace->getCompany()->getId()->value,
            $workplace->getName()->value,
            $workplace->getContactPhone()->value,
            $workplace->getAddress()->value,
            $workplace->getNumberOfWorkers(),
            $workplace->isActive(),
            $workplace->getCreatorAdmin() ? $workplace->getCreatorAdmin()->getId()->value : null,
            $workplace->getUpdaterAdmin() ? $workplace->getUpdaterAdmin()->getId()->value : null,
            $workplace->getCreatedAt(),
            $workplace->getUpdatedAt()
        );
    }

    public function toArray(): array
    {
        return [
            self::ID => $this->id,
            self::COMPANY_ID => $this->companyId,
            self::NAME => $this->name,
            self::CONTACT_PHONE => $this->contactPhone,
            self::ADDRESS => $this->address,
            self::NUMBER_OF_WORKERS => $this->numberOfWorkers,
            self::ACTIVE => $this->active,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339),
        ];
    }

}