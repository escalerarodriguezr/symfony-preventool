<?php

namespace Preventool\Infrastructure\Ui\Http\Service\Session;

class SessionResponse
{
    const ACTION_USER_ID = 'actionUserId';
    const ADMIN = 'actionAdmin';

    public function __construct(
        public readonly string $actionUserId,
        public readonly SessionAdminResponse $admin

    )
    {
    }

    public function toArray(): array
    {
        return [
            self::ACTION_USER_ID => $this->actionUserId,
            self::ADMIN => $this->admin->toArray()
        ];

    }
}