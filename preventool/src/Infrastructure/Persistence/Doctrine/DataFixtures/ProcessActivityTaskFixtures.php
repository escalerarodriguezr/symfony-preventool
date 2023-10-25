<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Process\Model\Process;
use Preventool\Domain\Process\Model\ProcessActivity;
use Preventool\Domain\Process\Model\ProcessActivityTask;
use Preventool\Domain\Process\Model\Value\ActivityTaskDescription;
use Preventool\Domain\Process\Model\Value\ProcessActivityDescription;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;

class ProcessActivityTaskFixtures extends Fixture implements FixtureInterface
{

    const CONFECCION_PROCESS_ACTIVITY_1_TASK_1_UUID = '010951f6-43bf-4318-b5e1-3732e492c938';
    const CONFECCION_PROCESS_ACTIVITY_1_TASK_1_NAME = 'Confección_Actividad_1_Tarea_1';
    const CONFECCION_PROCESS_ACTIVITY_1_TASK_1_DESCRIPTION = 'Descripción tarea 1 de la actividad 1 del proceso confección';
    const CONFECCION_PROCESS_ACTIVITY_1_TASK_1_ORDER = 1;
    const CONFECCION_PROCESS_ACTIVITY_1_TASK_1_REFERENCE = 'confeccion-activity-1-task-1';


    const CONFECCION_PROCESS_ACTIVITY_1_TASK_2_UUID = '16a3b6cb-2ee7-4e15-a4d0-1a3cabd1c9e4';
    const CONFECCION_PROCESS_ACTIVITY_1_TASK_2_NAME = 'Confección_Actividad_1_Tarea_2';
    const CONFECCION_PROCESS_ACTIVITY_1_TASK_2_DESCRIPTION = 'Descripción Tarea 2 de la actividad 1 del proceso coffeción';
    const CONFECCION_PROCESS_ACTIVITY_1_TASK_2_ORDER = 2;
    const CONFECCION_PROCESS_ACTIVITY_1_TASK_2_REFERENCE = 'confeccion-activity-1-task-2';


    public function __construct()
    {

    }

    public function load(ObjectManager $manager): void
    {
        /**
         * @var ProcessActivity $confeccionProcessOfRivendelActivity_1 ;
         */
        $confeccionProcessOfRivendelActivity_1 = $this->getReference(
            ProcessActivityFixtures::CONFECCION_PROCESS_ACTIVITY_1_REFERENCE
        );

        /**
         * @var Admin $adminRootRef ;
         */
        $adminRootRef = $this->getReference(
            AdminFixtures::ROOT_ADMIN_REFERENCE
        );

        $task_1 = $this->createProcessActivityTask(
            self::CONFECCION_PROCESS_ACTIVITY_1_TASK_1_UUID,
            $confeccionProcessOfRivendelActivity_1,
            self::CONFECCION_PROCESS_ACTIVITY_1_TASK_1_NAME,
            self::CONFECCION_PROCESS_ACTIVITY_1_TASK_1_ORDER,
            $adminRootRef,
            self::CONFECCION_PROCESS_ACTIVITY_1_TASK_1_DESCRIPTION
        );

        $task_2 = $this->createProcessActivityTask(
            self::CONFECCION_PROCESS_ACTIVITY_1_TASK_2_UUID,
            $confeccionProcessOfRivendelActivity_1,
            self::CONFECCION_PROCESS_ACTIVITY_1_TASK_2_NAME,
            self::CONFECCION_PROCESS_ACTIVITY_1_TASK_2_ORDER,
            $adminRootRef,
            self::CONFECCION_PROCESS_ACTIVITY_1_TASK_2_DESCRIPTION
        );


        $manager->persist(
            $task_1
        );
        $manager->persist(
            $task_2
        );

        $manager->flush();

        $this->addReference(
            self::CONFECCION_PROCESS_ACTIVITY_1_TASK_1_REFERENCE,
            $task_1
        );
        $this->addReference(
            self::CONFECCION_PROCESS_ACTIVITY_1_TASK_2_REFERENCE,
            $task_2
        );

    }

    private function createProcessActivityTask(
        string $id,
        ProcessActivity $processActivity,
        string $name,
        int $taskOrder,
        ?Admin $creatorAdmin = null,
        ?string $description = null
    ): ProcessActivityTask
    {
        $processActivityTask = new ProcessActivityTask(
            new Uuid($id),
            $processActivity,
            new LongName($name),
            $taskOrder
        );


        if($description){
            $processActivityTask->setDescription(
                new ActivityTaskDescription($description)
            );
        }

        $processActivityTask->setCreatorAdmin($creatorAdmin);


        return $processActivityTask;

    }

}