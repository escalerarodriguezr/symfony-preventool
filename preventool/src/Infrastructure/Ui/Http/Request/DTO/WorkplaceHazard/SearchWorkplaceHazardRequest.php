<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\WorkplaceHazard;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;

class SearchWorkplaceHazardRequest implements RequestDTO
{
    const FILTER_BY_ID = 'filterById';
    const FILTER_BY_NOT_HAS_TASK_HAZARD_WITH_TASK_ID = 'filterByNotHasTaskHazardWithTaskId';

    private ?string $filterByNotHasTaskHazardWithTaskId;
    private ?string $filterById;
    public function __construct(Request $request)
    {
        $this->filterById = $request->get(self::FILTER_BY_ID) ?? null;
        $this->filterByNotHasTaskHazardWithTaskId = $request->get(self::FILTER_BY_NOT_HAS_TASK_HAZARD_WITH_TASK_ID) ?? null;
    }


    public function getFilterById(): ?string
    {
        return $this->filterById;
    }

    public function getFilterByNotHasTaskHazardWithTaskId(): ?string
    {
        return $this->filterByNotHasTaskHazardWithTaskId;
    }




}