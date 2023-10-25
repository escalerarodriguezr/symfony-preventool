<?php
declare(strict_types=1);

namespace Preventool\Domain\OccupationalRisk\Service;


use Preventool\Domain\OccupationalRisk\Model\TaskHazard;
use Preventool\Domain\OccupationalRisk\Model\TaskRisk;
use Preventool\Domain\OccupationalRisk\Model\Value\TaskRiskStatus;
use Preventool\Domain\OccupationalRisk\Repository\TaskRiskRepository;
use Preventool\Domain\Shared\Model\IdentityGenerator;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;

class CreateTaskRiskService
{


    public function __construct(
        private readonly IdentityGenerator $identityGenerator,
        private readonly TaskRiskRepository $taskRiskRepository
    )
    {
    }

    public function __invoke(
        TaskHazard $taskHazard
    ): void
    {
        $taskRiskId = new Uuid($this->identityGenerator->generateId());

        $taskRisk = new TaskRisk(
            $taskRiskId,
            $taskHazard,
            new LongName(sprintf('Riesgo-%s', $taskHazard->getHazardName()->value )),
            new TaskRiskStatus(TaskRiskStatus::PENDING_ASSESSMENT),
            $taskHazard->getCreatorAdmin()
        );

        $this->taskRiskRepository->save($taskRisk);


    }


}