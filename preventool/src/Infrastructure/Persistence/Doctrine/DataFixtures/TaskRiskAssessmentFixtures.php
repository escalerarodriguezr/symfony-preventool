<?php

namespace Preventool\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\OccupationalRisk\Model\TaskRisk;
use Preventool\Domain\OccupationalRisk\Model\TaskRiskAssessment;
use Preventool\Domain\OccupationalRisk\Model\Value\AssessmentStatus;
use Preventool\Domain\OccupationalRisk\Model\Value\ExposureIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\PeopleExposedIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\ProcedureIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\SeverityIndex;
use Preventool\Domain\OccupationalRisk\Model\Value\TaskRiskStatus;
use Preventool\Domain\OccupationalRisk\Model\Value\TrainingIndex;
use Preventool\Domain\Shared\Model\Value\Uuid;


class TaskRiskAssessmentFixtures extends Fixture implements FixtureInterface
{
    const TASK_RISK_ASSESSMENT_TASK_1_NOISES_ID = '4896fbc6-c5d0-4bf9-8b1a-49a71873dd1e';
    const TASK_RISK_ASSESSMENT_TASK_1_NOISES_ID_RERFERENCE = 'task-risk-assessment-task-1-noises-reference';

    const TASK_RISK_ASSESSMENT_TASK_1_NOISES_STATUS = AssessmentStatus::DRAFT;
    const TASK_RISK_ASSESSMENT_TASK_1_NOISES_SEVERITY_INDEX = 3;
    const TASK_RISK_ASSESSMENT_TASK_1_NOISES_PEOPLE_EXPOSED_INDEX = 3;
    const TASK_RISK_ASSESSMENT_TASK_1_NOISES_PROCEDURE_INDEX = 3;
    const TASK_RISK_ASSESSMENT_TASK_1_NOISES_TRAINING_INDEX = 3;
    const TASK_RISK_ASSESSMENT_TASK_1_NOISES_EXPOSURE_INDEX = 3;






    public function __construct()
    {

    }

    public function load(ObjectManager $manager): void
    {

        /**
         * @var TaskRisk $taskRisk
         */
        $taskRisk = $this->getReference(TaskHazardFixtures::TASK_RISK_TASK_1_NOISES_REFERENCE);

        /**
         * @var Admin $adminRootRef ;
         */
        $adminRootRef = $this->getReference(AdminFixtures::ROOT_ADMIN_REFERENCE);



        $taskRiskAssessment = $this->createTaskRiskAssessment(
            self::TASK_RISK_ASSESSMENT_TASK_1_NOISES_ID,
            $taskRisk,
            self::TASK_RISK_ASSESSMENT_TASK_1_NOISES_STATUS,
            0,
            self::TASK_RISK_ASSESSMENT_TASK_1_NOISES_SEVERITY_INDEX,
            self::TASK_RISK_ASSESSMENT_TASK_1_NOISES_PEOPLE_EXPOSED_INDEX,
            self::TASK_RISK_ASSESSMENT_TASK_1_NOISES_PROCEDURE_INDEX,
            self::TASK_RISK_ASSESSMENT_TASK_1_NOISES_EXPOSURE_INDEX,
            self::TASK_RISK_ASSESSMENT_TASK_1_NOISES_TRAINING_INDEX,
            $adminRootRef

        );

        $manager->persist($taskRiskAssessment);

        $this->addReference(self::TASK_RISK_ASSESSMENT_TASK_1_NOISES_ID_RERFERENCE,$taskRiskAssessment);


        $taskRisk->setStatus(new TaskRiskStatus(
            TaskRiskStatus::DRAFT_ASSESSMENT
        ));

        $manager->persist($taskRisk);

        $manager->flush();

    }

    private function createTaskRiskAssessment(
        string $id,
        TaskRisk $taskRisk,
        string $status,
        int $revision,
        int $severityIndex,
        int $peopleExposedIndex,
        int $procedureIndex,
        int $exposureIndex,
        int $trainingIndex,
        Admin $creatorAdmin
    ): TaskRiskAssessment
    {
        return new TaskRiskAssessment(
            new Uuid($id),
            $taskRisk,
            new AssessmentStatus($status),
            $revision,
            new SeverityIndex($severityIndex),
            new PeopleExposedIndex($peopleExposedIndex),
            new ProcedureIndex($procedureIndex),
            new TrainingIndex($trainingIndex),
            new ExposureIndex($exposureIndex),
            $creatorAdmin
        );

    }


}