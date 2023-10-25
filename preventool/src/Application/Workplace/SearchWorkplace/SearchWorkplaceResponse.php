<?php
declare(strict_types=1);

namespace Preventool\Application\Workplace\SearchWorkplace;

use Preventool\Application\Workplace\Response\WorkplaceResponse;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class SearchWorkplaceResponse
{
    private array $collection;

    public function __construct(
        private int $total,
        private int $pages,
        private int $currentPage,
        private \ArrayIterator $items,
        private ?Uuid $companyId

    )
    {
        $this->transformItems($this->items,$this->companyId);
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

    private function transformItems(\ArrayIterator $items, ?Uuid $companyId):void
    {

        $this->collection = array_map(function (Workplace $model) use ($companyId):array{

            if(!empty($companyId)){
                return (WorkplaceResponse::createFromWorkplaceAndCompanyId($model,$companyId))->toArray();
            }

            return (WorkplaceResponse::createFromWorkplace($model))->toArray();

        }, $items->getArrayCopy());

    }

    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'pages' => $this->pages,
            'currentPage' => $this->currentPage,
            'items' => $this->collection
        ];
    }

}