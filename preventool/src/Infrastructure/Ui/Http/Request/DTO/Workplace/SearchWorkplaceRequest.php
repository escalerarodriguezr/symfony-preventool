<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Workplace;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;

class SearchWorkplaceRequest implements RequestDTO
{
    const FILTER_BY_ID = 'filterById';
    const FILTER_BY_COMPANY_ID = 'filterByCompanyId';
    const FILTER_BY_NAME = 'filterByName';


    private ?string $filterById;
    private ?string $filterByCompanyId;
    private ?string $filterByName;


    public function __construct(
        Request $request
    )
    {
        $this->filterById = $request->get(self::FILTER_BY_ID) ?? null;
        $this->filterByCompanyId = $request->get(self::FILTER_BY_COMPANY_ID) ?? null;
        $this->filterByName = $request->get(self::FILTER_BY_NAME) ?? null;
    }

    public function filterById(): ?string
    {
        return $this->filterById;
    }

    public function getFilterByCompanyId(): ?string
    {
        return $this->filterByCompanyId;
    }

    public function filterByName(): ?string
    {
        return $this->filterByName;
    }
}