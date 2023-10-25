<?php
declare(strict_types=1);

namespace Preventool\Application\AuditType\SearchAuditType;

use Preventool\Application\AuditType\Response\AuditTypeResponse;
use Preventool\Domain\Audit\Model\AuditType;

class SearchAuditTypeResponse
{

    const TOTAL = 'total';
    const PAGES = 'pages';
    const CURRENT_PAGE = 'currentPage';
    const ITEMS = 'items';

    /**
     * @var AuditTypeResponse[]
     */
    private array $collection;

    public function __construct(
        private readonly int $total,
        private readonly int $pages,
        private readonly int $currentPage,
        private readonly \ArrayIterator $items
    )
    {
        $this->createCollectionFromItems($this->items);
    }
    private function createCollectionFromItems(\ArrayIterator $items): void
    {
        $this->collection = array_map(function (AuditType $model):AuditTypeResponse{
            return AuditTypeResponse::createFromModel($model);
        },$items->getArrayCopy());

    }

    public function toArray(): array
    {
        return [
            self::TOTAL => $this->total,
            self::PAGES => $this->pages,
            self::CURRENT_PAGE => $this->currentPage,
            self::ITEMS => array_map(function (AuditTypeResponse $item):array{
                return $item->toArray();
            },$this->collection)

        ];
    }

}