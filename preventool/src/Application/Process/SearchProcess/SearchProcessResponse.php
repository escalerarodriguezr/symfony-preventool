<?php
declare(strict_types=1);

namespace Preventool\Application\Process\SearchProcess;

use Preventool\Application\Process\Response\ProcessResponse;
use Preventool\Domain\Process\Model\Process;
use Preventool\Domain\Shared\Model\Value\Uuid;

class SearchProcessResponse
{
    const TOTAL = 'total';
    const PAGES = 'pages';
    const CURRENT_PAGE = 'currentPage';
    const ITEMS = 'items';
    private array $processes;

    public function __construct(
        private int $total,
        private int $pages,
        private int $currentPage,
        private \ArrayIterator $items,
        private ?Uuid $workplaceId = null

    )
    {
        $this->transformItems($this->items, $this->workplaceId);
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

    private function transformItems(\ArrayIterator $items, ?Uuid $workplaceId=null):void
    {
        $this->processes = array_map(function (Process $model) use($workplaceId):array{
            return (ProcessResponse::createFromModel($model, $workplaceId))->toArray();
        }, $items->getArrayCopy());

    }

    public function toArray(): array
    {
        return [
            self::TOTAL => $this->total,
            self::PAGES => $this->pages,
            self::CURRENT_PAGE => $this->currentPage,
            self::ITEMS => $this->processes
        ];
    }

}