<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Ui\Http\Request\DTO\OccupationalRisk;

use Preventool\Infrastructure\Ui\Http\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class CreateTaskHazardRequest implements RequestDTO
{
    const TASK_ID = 'taskId';
    const HAZARD_ID = 'hazardId';

    #[NotBlank]
    #[Uuid]
    private mixed $taskId;

    #[NotBlank]
    #[Uuid]
    private mixed $hazardId;

    public function __construct(
        Request $request
    )
    {
        $payload = json_decode($request->getContent(),true);
        $this->taskId = $payload[self::TASK_ID] ?? null;
        $this->hazardId = $payload[self::HAZARD_ID] ?? null;
    }

    public function getTaskId(): string
    {
        return $this->taskId;
    }

    public function getHazardId(): string
    {
        return $this->hazardId;
    }


}