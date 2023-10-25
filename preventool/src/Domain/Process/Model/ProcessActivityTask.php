<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Model;

use Doctrine\Common\Collections\Collection;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\OccupationalRisk\Model\TaskHazard;
use Preventool\Domain\Process\Model\Value\ActivityTaskDescription;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;

class ProcessActivityTask extends AggregateRoot
{
    private string $id;
    private ProcessActivity $processActivity;
    private string $name;
    private ?string $description;
    private int $taskOrder;
    private bool $active;
    private ?Admin $creatorAdmin;
    private ?Admin $updaterAdmin;
    private Collection $taskHazards;

    /**
     * @param string $id
     */
    public function __construct(
        Uuid $id,
        ProcessActivity $processActivity,
        LongName $name,
        int $taskOrder

    )
    {
        parent::__construct();
        $this->id = $id->value;
        $this->processActivity = $processActivity;
        $this->name = $name->value;
        $this->taskOrder = $taskOrder;

        $this->active = true;
        $this->creatorAdmin = null;
        $this->updaterAdmin = null;
        $this->description = null;
    }

    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getProcessActivity(): ProcessActivity
    {
        return $this->processActivity;
    }

    public function setProcessActivity(ProcessActivity $processActivity): void
    {
        $this->processActivity = $processActivity;
    }

    public function getName(): LongName
    {
        return new LongName($this->name);
    }

    public function setName(LongName $name): void
    {
        $this->name = $name->value;
    }


    public function getDescription(): ?ActivityTaskDescription
    {
        return $this->description ? new ActivityTaskDescription($this->description,false) : null;
    }


    public function setDescription(?ActivityTaskDescription $description): void
    {
        $this->description = $description?->value();
    }


    public function getTaskOrder(): int
    {
        return $this->taskOrder;
    }


    public function setTaskOrder(int $taskOrder): void
    {
        $this->taskOrder = $taskOrder;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getCreatorAdmin(): ?Admin
    {
        return $this->creatorAdmin;
    }

    public function setCreatorAdmin(?Admin $creatorAdmin): void
    {
        $this->creatorAdmin = $creatorAdmin;
    }

    public function getUpdaterAdmin(): ?Admin
    {
        return $this->updaterAdmin;
    }

    public function setUpdaterAdmin(?Admin $updaterAdmin): void
    {
        $this->updaterAdmin = $updaterAdmin;
    }

    public function getTaskHazards(): Collection
    {
        return $this->taskHazards;
    }

    public function addTaskHazard(TaskHazard $taskHazard): void
    {
        if ($this->taskHazards->contains($taskHazard)) {
            return;
        }
        $this->taskHazards->add($taskHazard);
    }


}