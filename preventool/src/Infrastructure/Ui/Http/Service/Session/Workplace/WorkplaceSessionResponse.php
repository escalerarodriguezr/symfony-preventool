<?php

namespace Preventool\Infrastructure\Ui\Http\Service\Session\Workplace;

class WorkplaceSessionResponse
{

    const ACTION_WORKPLACE = 'actionWorkplace';

    public function __construct(
        public readonly SessionWorkplaceResponse $sessionWorkplaceResponse

    )
    {
    }

    public function toArray(): array
    {
        return [
            self::ACTION_WORKPLACE => $this->sessionWorkplaceResponse->toArray()
        ];

    }
}