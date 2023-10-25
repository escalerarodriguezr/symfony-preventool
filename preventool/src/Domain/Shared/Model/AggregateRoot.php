<?php
declare(strict_types=1);

namespace Preventool\Domain\Shared\Model;

abstract class AggregateRoot
{
//    protected \DateTimeImmutable $createdAt;
//    protected \DateTimeImmutable $updatedAt;
//    protected ?\DateTimeImmutable $deletedAt;

    public function __construct(
        protected \DateTimeImmutable $createdAt = new \DateTimeImmutable(),
        protected \DateTimeImmutable $updatedAt = new \DateTimeImmutable(),
        protected ?\DateTimeImmutable $deletedAt = null

    )
    {
//        $this->createdAt = new \DateTimeImmutable();
//        $this->updatedAt = new \DateTimeImmutable();
//        $this->deletedAt = null;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    protected function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    protected function setDeletedAt(\DateTimeImmutable $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function markAsUpdated(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

}