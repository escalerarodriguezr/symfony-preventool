<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\AuditType;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;

class SearchAuditTypeRequest implements RequestDTO
{
    const FILTER_BY_ID = 'filterById';
    const FILTER_BY_COMPANY_ID = 'filterByCompanyId';
    const FILTER_BY_WORKPLACE_ID = 'filterByWorkplaceId';

    public readonly ?string $filterById;
    public readonly ?string $filterByCompanyId;
    public readonly ?string $filterByWorkplaceId;

    public function __construct(Request $request)
    {
        $this->filterById = $request->query->get(self::FILTER_BY_ID) ?? null;
        $this->filterByCompanyId = $request->query->get(self::FILTER_BY_COMPANY_ID) ?? null;
        $this->filterByWorkplaceId = $request->query->get(self::FILTER_BY_WORKPLACE_ID) ?? null;
    }

}