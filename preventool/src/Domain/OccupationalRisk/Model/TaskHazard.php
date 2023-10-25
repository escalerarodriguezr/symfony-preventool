<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Model;

use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Process\Model\ProcessActivityTask;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\MediumDescription;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazard;

class TaskHazard extends AggregateRoot
{
    private string $id;
    private ProcessActivityTask $task;
    private string $hazardName;
    private ?string $hazardDescription;
    private string $hazardCategoryName;

    private bool $active;
    private Admin $creatorAdmin;
    private ?Admin $updaterAdmin;
    private ?TaskRisk $taskRisk;

    public function __construct(
        Uuid $id,
        ProcessActivityTask $task,
        Name $hazardCategoryName,
        Name $hazardName,
        Admin $creatorAdmin
    )
    {
        parent::__construct();
        $this->id = $id->value;
        $this->task = $task;
        $this->creatorAdmin = $creatorAdmin;
        $this->hazardName = $hazardName->value;
        $this->hazardCategoryName = $hazardCategoryName->value;
        $this->active = true;
        $this->taskRisk = null;
        $this->hazardDescription = null;
    }


    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getTask(): ProcessActivityTask
    {
        return $this->task;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getCreatorAdmin(): Admin
    {
        return $this->creatorAdmin;
    }

    public function getUpdaterAdmin(): ?Admin
    {
        return $this->updaterAdmin;
    }

    public function setUpdaterAdmin(?Admin $updaterAdmin): void
    {
        $this->updaterAdmin = $updaterAdmin;
    }

    public function getTaskRisk(): ?TaskRisk
    {
        return $this->taskRisk;
    }

    public function getHazardName(): Name
    {
        return new Name($this->hazardName);
    }

    public function setHazardName(Name $hazardName): void
    {
        $this->hazardName = $hazardName->value;
    }

    public function getHazardDescription(): ?MediumDescription
    {
        return $this->hazardDescription ? new MediumDescription($this->hazardDescription) : null;
    }

    public function setHazardDescription(?MediumDescription $hazardDescription): void
    {
        $this->hazardDescription = $hazardDescription?->value;
    }

    public function getHazardCategoryName(): Name
    {
        return new Name($this->hazardCategoryName);
    }

    public function setHazardCategoryName(Name $hazardCategoryName): void
    {
        $this->hazardCategoryName = $hazardCategoryName->value;
    }

}