<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\OccupationalRisk;

use Preventool\Domain\OccupationalRisk\Model\Value\AssessmentStatus;
use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateTaskRiskAssessmentStatusRequest implements RequestDTO
{
    const STATUS = 'status';

    const CHOICES = [
        AssessmentStatus::DRAFT,
        AssessmentStatus::REVISED,
        AssessmentStatus::APPROVED
    ];


    #[NotBlank]
    #[Choice(choices: self::CHOICES)]
    private mixed $status;


    public function __construct(Request $request)
    {
        $payload = json_decode($request->getContent(),true);
        $this->status = $payload[self::STATUS] ?? null;
    }


    public function getStatus(): string
    {
        return $this->status;
    }


}