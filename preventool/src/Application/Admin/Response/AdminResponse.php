<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\Response;

use DateTimeInterface;

class AdminResponse
{
    const ID = 'id';
    const NAME = 'name';
    const LAST_NAME = 'lastName';
    const EMAIL = 'email';
    const TYPE = 'type';
    const ROLE = 'role';
    const ACTIVE = 'active';
    const CREATOR_ID = 'creatorId';
    const UPDATER_ID = 'updaterId';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $type,
        public readonly string $role,
        public readonly bool $active,
        public readonly ?string $creatorId,
        public readonly ?string $updaterId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt
    )
    {
    }

    public function toArray(): array
    {
        return [
            self::ID => $this->id,
            self::NAME => $this->name,
            self::LAST_NAME => $this->lastName,
            self::EMAIL => $this->email,
            self::TYPE => $this->type,
            self::ROLE => $this->role,
            self::ACTIVE => $this->active,
            self::CREATOR_ID => $this->creatorId,
            self::UPDATER_ID => $this->updaterId,
            self::CREATED_AT => $this->createdAt->format(DateTimeInterface::RFC3339),
            self::UPDATED_AT => $this->updatedAt->format(DateTimeInterface::RFC3339),
        ];
    }
}