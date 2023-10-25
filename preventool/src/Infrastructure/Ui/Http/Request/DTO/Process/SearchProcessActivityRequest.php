<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Process;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;

class SearchProcessActivityRequest implements RequestDTO
{
    const FILTER_BY_ID = 'filterById';
    const FILTER_BY_PROCESS_ID = 'filterByProcessId';

    public readonly ?string $filterById;
    public readonly ?string $filterByProcessId;

    public function __construct(Request $request)
    {
        $this->filterById = $request->query->get(self::FILTER_BY_ID) ?? null;
        $this->filterByProcessId = $request->query->get(self::FILTER_BY_PROCESS_ID) ?? null;
    }

}