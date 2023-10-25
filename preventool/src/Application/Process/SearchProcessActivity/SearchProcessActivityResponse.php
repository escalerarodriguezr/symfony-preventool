<?php
declare(strict_types=1);

namespace Preventool\Application\Process\SearchProcessActivity;

use Preventool\Application\Process\Response\ProcessActivityResponse;
use Preventool\Application\Process\Response\ProcessResponse;
use Preventool\Domain\Process\Model\Process;
use Preventool\Domain\Process\Model\ProcessActivity;
use Preventool\Domain\Shared\Model\Value\Uuid;

class SearchProcessActivityResponse
{
    const TOTAL = 'total';
    const PAGES = 'pages';
    const CURRENT_PAGE = 'currentPage';
    const ITEMS = 'items';
    private array $processActivities;

    public function __construct(
        private int $total,
        private int $pages,
        private int $currentPage,
        private \ArrayIterator $items,
        private ?Uuid $processId = null

    )
    {
        $this->transformItems($this->items, $this->processId);
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

    private function transformItems(\ArrayIterator $items, ?Uuid $processId=null):void
    {
        $this->processActivities = array_map(function (ProcessActivity $model) use($processId):array{
            return (ProcessActivityResponse::createFromModel($model, $processId))->toArray();
        }, $items->getArrayCopy());

    }

    public function toArray(): array
    {
        return [
            self::TOTAL => $this->total,
            self::PAGES => $this->pages,
            self::CURRENT_PAGE => $this->currentPage,
            self::ITEMS => $this->processActivities
        ];
    }

}