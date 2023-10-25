<?php
declare(strict_types=1);

namespace Preventool\Domain\Process\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Process\Model\Value\ProcessDescription;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class Process extends AggregateRoot
{
    private string $id;
    private string $name;
    public ?string $description;
    private Workplace $workplace;
    private int $revisionNumber;
    private ?string $revisionOf;
    private ?string $revisedBy;
    private ?Admin $creatorAdmin;
    private ?Admin $updaterAdmin;
    private bool $active;

    private Collection $processActivities;

    public function __construct(
        Uuid $id,
        Workplace $workplace,
        LongName $name,
        Admin $creatorAdmin = null
    )
    {
        parent::__construct();
        $this->id = $id->value;
        $this->workplace = $workplace;
        $this->name = $name->value;
        $this->revisionNumber = 0;
        $this->revisionOf = null;
        $this->revisedBy = null;
        $this->active = true;
        $this->creatorAdmin = $creatorAdmin;
        $this->updaterAdmin  =null;
        $this->description = null;
        $this->processActivities = new ArrayCollection();
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

    public function getWorkplace(): Workplace
    {
        return $this->workplace;
    }

    public function getRevisionNumber(): int
    {
        return $this->revisionNumber;
    }

    public function setRevisionNumber(int $revisionNumber): void
    {
        $this->revisionNumber = $revisionNumber;
    }

    public function getRevisionOf(): ?Uuid
    {
        return $this->revisionOf ? new Uuid($this->revisionOf) : null;
    }

    public function setRevisionOf(?Uuid $revisionOf): void
    {
        $this->revisionOf = $revisionOf->value;
    }

    public function getRevisedBy(): ?Uuid
    {
        return $this->revisedBy ? new Uuid($this->revisedBy) : null;
    }

    public function setRevisedBy(?Uuid $revisedBy): void
    {
        $this->revisedBy = $revisedBy->value;
    }

    public function getCreatorAdmin(): ?Admin
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

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }


    public function setDescription(?ProcessDescription $description): void
    {
        $this->description = !empty($description) ? $description->value() : null;
    }


    public function getDescription(): ?ProcessDescription
    {
        return $this->description ? new ProcessDescription($this->description,false) : null;
    }

    /**
     * @return Collection|ProcessActivity[]
     */
    public function getProcessActivities(): Collection
    {
        return $this->processActivities;
    }


    public function addProcessActivity(ProcessActivity $processActivity): void
    {
        if ($this->processActivities->contains($processActivity)) {
            return;
        }

        $this->processActivities->add($processActivity);
    }



}