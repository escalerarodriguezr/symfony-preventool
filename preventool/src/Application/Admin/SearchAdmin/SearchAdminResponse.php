<?php
declare(strict_types=1);

namespace Preventool\Application\Admin\SearchAdmin;

use Preventool\Application\Admin\Response\AdminResponse;
use Preventool\Domain\Admin\Model\Admin;

class SearchAdminResponse
{
    private array $admins;

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

        $this->admins = array_map(function (Admin $admin):array{
            return (new AdminResponse(
                $admin->getId()->value,
                $admin->getName()->value,
                $admin->getLastName()->value,
                $admin->getEmail()->value,
                $admin->getType()->value,
                $admin->getRole()->value,
                $admin->isActive(),
                $admin->getCreatorAdmin() ? $admin->getCreatorAdmin()->getId()->value : null,
                $admin->getUpdaterAdmin() ? $admin->getUpdaterAdmin()->getId()->value : null,
                $admin->getCreatedAt(),
                $admin->getUpdatedAt()
            ))->toArray();
        }, $items->getArrayCopy());

    }

    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'pages' => $this->pages,
            'currentPage' => $this->currentPage,
            'items' => $this->admins
        ];
    }


}