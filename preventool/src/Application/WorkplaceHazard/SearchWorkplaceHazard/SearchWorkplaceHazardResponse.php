<?php
declare(strict_types=1);

namespace Preventool\Application\WorkplaceHazard\SearchWorkplaceHazard;

use Preventool\Application\Process\Response\ProcessResponse;
use Preventool\Application\WorkplaceHazard\Response\WorkplaceHazardResponse;
use Preventool\Domain\Process\Model\Process;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazard;

class SearchWorkplaceHazardResponse
{
    const TOTAL = 'total';
    const PAGES = 'pages';
    const CURRENT_PAGE = 'currentPage';
    const ITEMS = 'items';
    private array $hazards;

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
        $this->hazards = array_map(function (WorkplaceHazard $model) use($workplaceId):array{
            return (WorkplaceHazardResponse::createFromModel($model, $workplaceId))->toArray();
        }, $items->getArrayCopy());

    }

    public function toArray(): array
    {
        return [
            self::TOTAL => $this->total,
            self::PAGES => $this->pages,
            self::CURRENT_PAGE => $this->currentPage,
            self::ITEMS => $this->hazards
        ];
    }

}