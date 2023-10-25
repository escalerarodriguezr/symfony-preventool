<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Model;

use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\OccupationalRisk\Model\Value\AssessmentStatus;
use Preventool\Domain\OccupationalRisk\Model\Value\ExposureIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\PeopleExposedIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\ProcedureIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\RiskLevelIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\SeverityIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\TrainingIndex;
use Preventool\Domain\Shared\Model\AggregateRoot;
use Preventool\Domain\Shared\Model\Value\Uuid;

class TaskRiskAssessment extends AggregateRoot
{

    private string $id;
    private TaskRisk $taskRisk;
    private string $status;
    private int $revision;
    private int $riskLevelIndex;
    private int $severityIndex;
    private int $peopleExposedIndex;
    private int $procedureIndex;
    private int $trainingIndex;
    private int $exposureIndex;

    private ?Admin $approvedAdmin;
    private ?Admin $revisedAdmin;
    private ?Admin $creatorAdmin;
    private ?Admin $updaterAdmin;


    public function __construct(
        Uuid $id,
        TaskRisk $taskRisk,
        AssessmentStatus $status,
        int $revision,
        SeverityIndex $severityIndex,
        PeopleExposedIndex $peopleExposedIndex,
        ProcedureIndex $procedureIndex,
        TrainingIndex $trainingIndex,
        ExposureIndex $exposureIndex,
        Admin $creatorAdmin
    )
    {
        parent::__construct();

        $this->id = $id->value;
        $this->taskRisk = $taskRisk;
        $this->status = $status->value;
        $this->revision = $revision;
        $this->severityIndex = $severityIndex->value;
        $this->peopleExposedIndex = $peopleExposedIndex->value;
        $this->procedureIndex = $procedureIndex->value;
        $this->trainingIndex = $trainingIndex->value;
        $this->exposureIndex = $exposureIndex->value;
        $this->creatorAdmin = $creatorAdmin;
        $this->calculateAndSetRiskLevel();

    }

    public function getId(): Uuid
    {
        return new Uuid($this->id);
    }

    public function getTaskRisk(): TaskRisk
    {
        return $this->taskRisk;
    }

    public function getStatus(): AssessmentStatus
    {
        return new AssessmentStatus($this->status);
    }

    public function setStatus(AssessmentStatus $status): void
    {
        $this->status = $status->value;
    }

    public function getRevision(): int
    {
        return $this->revision;
    }

    public function setRevision(int $revision): void
    {
        $this->revision = $revision;
    }

    public function getRiskLevelIndex(): RiskLevelIndex
    {
        return new RiskLevelIndex($this->riskLevelIndex);
    }

    public function getSeverityIndex(): SeverityIndex
    {
        return new SeverityIndex($this->severityIndex);
    }

    public function setSeverityIndex(SeverityIndex $severityIndex): void
    {
        $this->severityIndex = $severityIndex->value;
        $this->calculateAndSetRiskLevel();
    }

    public function getPeopleExposedIndex(): PeopleExposedIndex
    {
        return new PeopleExposedIndex($this->peopleExposedIndex);
    }

    public function setPeopleExposedIndex(PeopleExposedIndex $peopleExposedIndex): void
    {
        $this->peopleExposedIndex = $peopleExposedIndex->value;
        $this->calculateAndSetRiskLevel();
    }

    public function getProcedureIndex(): ProcedureIndex
    {
        return new ProcedureIndex($this->procedureIndex);
    }

    public function setProcedureIndex(ProcedureIndex $procedureIndex): void
    {
        $this->procedureIndex = $procedureIndex->value;
        $this->calculateAndSetRiskLevel();
    }

    public function getTrainingIndex(): TrainingIndex
    {
        return new TrainingIndex($this->trainingIndex);
    }

    public function setTrainingIndex(TrainingIndex $trainingIndex): void
    {
        $this->trainingIndex = $trainingIndex->value;
        $this->calculateAndSetRiskLevel();
    }

    public function getExposureIndex(): ExposureIndex
    {
        return new ExposureIndex($this->exposureIndex);
    }

    public function setExposureIndex(ExposureIndex $exposureIndex): void
    {
        $this->exposureIndex = $exposureIndex->value;
        $this->calculateAndSetRiskLevel();
    }

    public function getApprovedAdmin(): ?Admin
    {
        return $this->approvedAdmin;
    }

    public function setApprovedAdmin(?Admin $approvedAdmin): void
    {
        $this->approvedAdmin = $approvedAdmin;
    }

    public function getRevisedAdmin(): ?Admin
    {
        return $this->revisedAdmin;
    }

    public function setRevisedAdmin(?Admin $revisedAdmin): void
    {
        $this->revisedAdmin = $revisedAdmin;
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


    private function calculateAndSetRiskLevel(): void
    {
        $probabilityIndex = $this->trainingIndex + $this->peopleExposedIndex + $this->exposureIndex + $this->procedureIndex;
        $level = $probabilityIndex * $this->severityIndex;
        $this->riskLevelIndex = (new RiskLevelIndex($level))->value;
    }


}