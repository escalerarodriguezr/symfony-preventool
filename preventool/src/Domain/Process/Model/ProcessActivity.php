<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Process\Model\Value\ProcessActivityDescription;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;

class ProcessActivity extends AggregateRoot
{
    private string $id;
    private string $name;
    public ?string $description;
    private Process $process;
    private int $activityOrder;
    private ?Admin $creatorAdmin;
    private ?Admin $updaterAdmin;
    private bool $active;

    private Collection $activityTasks;

    public function __construct(
        Uuid $id,
        Process $process,
        LongName $name,
        int $activityOrder
    )
    {
        parent::__construct();
        $this->id = $id->value;
        $this->process = $process;
        $this->name = $name->value;
        $this->activityOrder = $activityOrder;
        $this->active = true;
        $this->creatorAdmin = null;
        $this->updaterAdmin  =null;
        $this->description = null;
        $this->activityTasks = new ArrayCollection();
    }


    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getName(): LongName
    {
        return new LongName($this->name);
    }

    public function setName(LongName $name): void
    {
        $this->name = $name->value;
    }

    public function getProcess(): Process
    {
        return $this->process;
    }

    public function getActivityOrder(): int
    {
        return $this->activityOrder;
    }

    public function setActivityOrder(int $activityOrder): void
    {
        $this->activityOrder = $activityOrder;
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

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }


    public function setDescription(?ProcessActivityDescription $description): void
    {
        $this->description = !empty($description) ? $description->value() : null;
    }


    public function getDescription(): ?ProcessActivityDescription
    {
        return $this->description ? new ProcessActivityDescription($this->description,false) : null;
    }


    public function getActivityTasks(): Collection
    {
        return $this->activityTasks;
    }


    public function addActivityTask(ProcessActivityTask $activityTask): void
    {
        if($this->activityTasks->contains($activityTask)){
            return;
        }
        $this->activityTasks->add($activityTask);
    }


}