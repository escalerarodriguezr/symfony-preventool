<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Model;

use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\OccupationalRisk\Model\Value\LegalRequirement;
use Preventool\Domain\OccupationalRisk\Model\Value\TaskRiskObservations;
use Preventool\Domain\OccupationalRisk\Model\Value\TaskRiskStatus;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;

class TaskRisk extends AggregateRoot
{
    private string $id;
    private TaskHazard $taskHazard;
    private ?TaskRiskAssessment $taskRiskAssessment;
    private string $name;
    private string $status;
    private Admin $creatorAdmin;
    private ?string $observations;
    private ?string $legalRequirement;
    private ?Admin $updaterAdmin;

    public function __construct(
        Uuid $id,
        TaskHazard $taskHazard,
        LongName $longName,
        TaskRiskStatus $status,
        Admin $creatorAdmin
    )
    {
        parent::__construct();

        $this->id = $id->value;
        $this->taskHazard = $taskHazard;
        $this->name = $longName->value;
        $this->status = $status->value;
        $this->creatorAdmin = $creatorAdmin;

        $this->observations = null;
        $this->legalRequirement = null;
        $this->updaterAdmin = null;
        $this->taskRiskAssessment = null;
    }

    /**
     * @return string
     */
    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getTaskHazard(): TaskHazard
    {
        return $this->taskHazard;
    }

    public function getName(): LongName
    {
        return new LongName($this->name);
    }

    public function setName(LongName $name): void
    {
        $this->name = $name->value;
    }

    public function getStatus(): TaskRiskStatus
    {
        return new TaskRiskStatus($this->status);
    }

    public function setStatus(TaskRiskStatus $status): void
    {
        $this->status = $status->value;
    }

    public function getCreatorAdmin(): Admin
    {
        return $this->creatorAdmin;
    }

    public function setCreatorAdmin(Admin $creatorAdmin): void
    {
        $this->creatorAdmin = $creatorAdmin;
    }

    public function getObservations(): ?TaskRiskObservations
    {
        return $this->observations ? new TaskRiskObservations($this->observations) : null;
    }

    public function setObservations(?TaskRiskObservations $observations): void
    {
        $this->observations = $observations?->value;
    }

    public function getLegalRequirement(): ?LegalRequirement
    {
        return $this->legalRequirement ? new LegalRequirement($this->legalRequirement) : null;
    }

    public function setLegalRequirement(?LegalRequirement $legalRequirement): void
    {
        $this->legalRequirement = $legalRequirement?->value;
    }

    public function getUpdaterAdmin(): ?Admin
    {
        return $this->updaterAdmin;
    }

    public function setUpdaterAdmin(?Admin $updaterAdmin): void
    {
        $this->updaterAdmin = $updaterAdmin;
    }

    public function getTaskRiskAssessment(): ?TaskRiskAssessment
    {
        return $this->taskRiskAssessment;
    }

    public function setTaskRiskAssessment(?TaskRiskAssessment $taskRiskAssessment): void
    {
        $this->taskRiskAssessment = $taskRiskAssessment;
    }



}