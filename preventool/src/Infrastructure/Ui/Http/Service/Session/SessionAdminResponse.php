<?php

namespace Preventool\Infrastructure\Ui\Http\Service\Session;

class SessionAdminResponse
{
    const ID = 'id';
    const EMAIL = 'email';
    const TYPE = 'type';
    const ROLE = 'role';
    const NAME = 'name';
    const LAST_NAME = 'lastName';


    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $type,
        public readonly string $role,
        public readonly string $name,
        public readonly string $lastName
    )
    {
    }

    public function toArray(): array
    {
        return [
            self::ID => $this->id,
            self::EMAIL => $this->email,
            self::TYPE => $this->type,
            self::ROLE => $this->role,
            self::NAME => $this->name,
            self::LAST_NAME => $this->lastName,
        ];
    }
}