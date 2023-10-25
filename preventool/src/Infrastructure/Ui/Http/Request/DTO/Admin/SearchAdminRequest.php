<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Admin;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;

class SearchAdminRequest implements RequestDTO
{
    const FILTER_BY_ID = 'filterById';
    const FILTER_BY_EMAIL = 'filterByEmail';
    const FILTER_BY_CREATED_AT_FROM = 'filterByCreatedAtFrom';
    const FILTER_BY_CREATED_AT_TO = 'filterByCreatedAtTo';


    private ?string $filterById;
    private ?string $filterByEmail;
    private ?string $filterByCreatedAtFrom;
    private ?string $filterByCreatedAtTo;


    public function __construct(
        Request $request
    )
    {
        $this->filterById = $request->get(self::FILTER_BY_ID) ?? null;
        $this->filterByEmail = $request->get(self::FILTER_BY_EMAIL) ?? null;
        $this->filterByCreatedAtFrom = $request->get(self::FILTER_BY_CREATED_AT_FROM) ?? null;
        $this->filterByCreatedAtTo = $request->get(self::FILTER_BY_CREATED_AT_TO) ?? null;
    }


    public function filterById(): ?string
    {
        return $this->filterById;
    }

    public function filterByEmail(): ?string
    {
        return $this->filterByEmail;
    }

    public function filterByCreatedAtFrom(): ?string
    {
        return $this->filterByCreatedAtFrom;
    }

    public function filterByCreatedAtTo(): ?string
    {
        return $this->filterByCreatedAtTo;
    }

}