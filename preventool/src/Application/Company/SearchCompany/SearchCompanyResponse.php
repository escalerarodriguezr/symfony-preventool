<?php
declare(strict_types=1);

namespace Preventool\Application\Company\SearchCompany;

use Preventool\Application\Company\Response\CompanyResponse;
use Preventool\Domain\Company\Model\Company;

class SearchCompanyResponse
{
    private array $companies;

    public function __construct(
        private int $total,
        private int $pages,
        private int $currentPage,
        private \ArrayIterator $items,

    )
    {
        $this->transformItems($this->items);
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getItems(): \ArrayIterator
    {
        return $this->items;
    }

    private function transformItems(\ArrayIterator $items):void
    {

        $this->companies = array_map(function (Company $company):array{
            return (CompanyResponse::createFromCompany($company))->toArray();
        }, $items->getArrayCopy());

    }

    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'pages' => $this->pages,
            'currentPage' => $this->currentPage,
            'items' => $this->companies
        ];
    }

}