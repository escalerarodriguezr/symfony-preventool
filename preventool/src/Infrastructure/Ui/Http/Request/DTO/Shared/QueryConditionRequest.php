<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\Shared;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;

class QueryConditionRequest implements RequestDTO
{
    const PAGE_SIZE = 'pageSize';
    const CURRENT_PAGE = 'currentPage';
    const ORDER_BY = 'orderBy';
    const ORDER_DIRECTION = 'orderDirection';

    const DESC = 'DESC';
    const ASC = 'ASC';

    private ?int $pageSize;
    private ?int $currentPage;
    private ?string $orderBy;
    private ?string $orderDirection;


    public function __construct(
        Request $request
    )
    {
        $this->pageSize = empty($request->query->get(self::PAGE_SIZE)) ? 10 : (int) $request->query->get(self::PAGE_SIZE);
        $this->currentPage = empty($request->query->get(self::CURRENT_PAGE)) ? 1 : (int) $request->query->get(self::CURRENT_PAGE);
        $this->orderBy = empty($request->query->get(self::ORDER_BY)) ? 'createdAt' : (string) $request->query->get(self::ORDER_BY);
        $this->orderDirection = empty($request->query->get(self::ORDER_DIRECTION)) ? 'DESC' : (string) $request->query->get(self::ORDER_DIRECTION);
    }

    public function getPageSize(): ?int
    {
        return $this->pageSize;
    }


    public function setPageSize(?int $pageSize): void
    {
        $this->pageSize = $pageSize;
    }

    public function getCurrentPage(): ?int
    {
        return $this->currentPage;
    }

    public function setCurrentPage(?int $currentPage): void
    {
        $this->currentPage = $currentPage;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function setOrderBy(?string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    public function getOrderDirection(): ?string
    {
        return $this->orderDirection;
    }

    public function setOrderDirection(?string $orderDirection): void
    {
        $this->orderDirection = $orderDirection;
    }

}