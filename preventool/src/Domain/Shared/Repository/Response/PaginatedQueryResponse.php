<?php
declare(strict_types=1);

namespace Preventool\Domain\Shared\Repository\Response;

class PaginatedQueryResponse
{
    public function __construct(
        private int $total,
        private int $pages,
        private int $currentPage,
        private \ArrayIterator $items
    )
    {
    }

    public function getTotal(): int
    {
        return $this->total;
    }


    public function setTotal(int $total): void
    {
        $this->total = $total;
    }


    public function getPages(): int
    {
        return $this->pages;
    }


    public function setPages(int $pages): void
    {
        $this->pages = $pages;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function setCurrentPage(int $currentPage): void
    {
        $this->currentPage = $currentPage;
    }

    public function getItems(): \ArrayIterator
    {
        return $this->items;
    }

    public function setItems(\ArrayIterator $items): void
    {
        $this->items = $items;
    }

}