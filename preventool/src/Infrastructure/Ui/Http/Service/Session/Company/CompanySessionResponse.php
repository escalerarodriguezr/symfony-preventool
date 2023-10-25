<?php

namespace Preventool\Infrastructure\Ui\Http\Service\Session\Company;

class CompanySessionResponse
{

    const ACTION_COMPANY = 'actionCompany';

    public function __construct(
        public readonly SessionCompanyResponse $actionCompanyResponse

    )
    {
    }

    public function toArray(): array
    {
        return [

            self::ACTION_COMPANY => $this->actionCompanyResponse->toArray()
        ];

    }
}