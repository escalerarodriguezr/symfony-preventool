<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Process;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;

class SearchProcessRequest implements RequestDTO
{
    const FILTER_BY_ID = 'filterById';
    const FILTER_BY_WORKPLACE_ID = 'filterByWorkplaceId';
    const FILTER_BY_NAME = 'filterByName';

    public readonly ?string $filterById;
    public readonly ?string $filterByWorkplaceId;
    public readonly ?string $filterByName;

    public function __construct(Request $request)
    {
        $this->filterById = $request->query->get(self::FILTER_BY_ID) ?? null;
        $this->filterByWorkplaceId = $request->query->get(self::FILTER_BY_WORKPLACE_ID) ?? null;
        $this->filterByName = $request->query->get(self::FILTER_BY_NAME) ?? null;
    }

}