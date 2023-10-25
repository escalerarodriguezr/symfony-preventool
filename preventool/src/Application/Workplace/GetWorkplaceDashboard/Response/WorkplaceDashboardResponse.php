<?php

namespace Preventool\Application\Workplace\GetWorkplaceDashboard\Response;

use Preventool\Domain\BaselineStudy\Model\BaselineStudyCompliance;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository\CountOfStatusByWorkplaceQueryResponse;

class WorkplaceDashboardResponse
{
    const BASELINE_STUDY_TOTAL_COMPLIANCE = 'baselineStudyTotalCompliance';
    const TASK_RISK_TOTAL_NUMBER = 'taskRiskTotalNumber';
    const TASK_RISK_STATUS_PENDING_NUMBER = 'taskRiskStatusPendingNumber';
    const TASK_RISK_STATUS_DRAFT_NUMBER = 'taskRiskStatusDraftNumber';
    const TASK_RISK_STATUS_REVISED_NUMBER = 'taskRiskStatusRevisedNumber';
    const TASK_RISK_STATUS_APPROVED_NUMBER = 'taskRiskStatusApprovedNumber';

    public function __construct(
        public readonly int $baselineStudyTotalCompliance,
        public readonly int $taskRiskTotalNumber,
        public readonly int $taskRiskStatusPendingNumber,
        public readonly int $taskRiskStatusDraftNumber,
        public readonly int $taskRiskStatusRevisedNumber,
        public readonly int $taskRiskStatusApprovedNumber
    )
    {
    }

    public static function build(
        BaselineStudyCompliance $baselineStudyCompliance,
        CountOfStatusByWorkplaceQueryResponse $countOfStatusByWorkplaceQueryResponse
    ): self
    {
        return new self(
            $baselineStudyCompliance->getTotalCompliance()->value,
            $countOfStatusByWorkplaceQueryResponse->total,
            $countOfStatusByWorkplaceQueryResponse->pending,
            $countOfStatusByWorkplaceQueryResponse->draft,
            $countOfStatusByWorkplaceQueryResponse->revised,
            $countOfStatusByWorkplaceQueryResponse->approved
        );
    }

    public function toArray(): array
    {
        return [
            self::BASELINE_STUDY_TOTAL_COMPLIANCE => $this->baselineStudyTotalCompliance,
            self::TASK_RISK_TOTAL_NUMBER => $this->taskRiskTotalNumber,
            self::TASK_RISK_STATUS_PENDING_NUMBER => $this->taskRiskStatusPendingNumber,
            self::TASK_RISK_STATUS_DRAFT_NUMBER => $this->taskRiskStatusDraftNumber,
            self::TASK_RISK_STATUS_REVISED_NUMBER => $this->taskRiskStatusRevisedNumber,
            self::TASK_RISK_STATUS_APPROVED_NUMBER => $this->taskRiskStatusApprovedNumber
        ];
    }


}