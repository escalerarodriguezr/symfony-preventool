<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Company\Model\HealthAndSafetyPolicy;
use Preventool\Domain\Process\Model\Process;
use Preventool\Domain\Process\Model\Value\ProcessDescription;
use Preventool\Domain\Shared\Model\Value\DocumentStatus;
use Preventool\Domain\Shared\Model\Value\LongName;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class ProcessFixtures extends Fixture implements FixtureInterface
{

    const CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1 = 'd262474e-b2c8-4e97-946b-57e15f9cda34';
    const CONFECCION_PROCESS_NAME_RIVENDEL_WORKPLACE_1 = 'Confección';
    const CONFECCION_PROCESS_DESCRIPTION_RIVENDEL_WORKPLACE_1 = 'Proceso de fabricación de camiseta';
    const CONFECCION_PROCESS_RIVENDEL_WORKPLACE_1_REFERENCE = 'confeccion-process-of-rivendel-workplace-1';


    public function __construct()
    {

    }

    public function load(ObjectManager $manager): void
    {
        /**
         * @var Workplace $workplace_1_Rivendel ;
         */
        $workplace_1_Rivendel = $this->getReference(WorkplaceFixtures::RIVENDEL_WORKPLACE_1_REFERENCE);

        /**
         * @var Admin $adminRootRef ;
         */
        $adminRootRef = $this->getReference(
            AdminFixtures::ROOT_ADMIN_REFERENCE
        );

        $confeccionProcessOfRivendelWorkplace_1 = $this->createProcessOfWorkplace(
            self::CONFECCION_PROCESS_UUID_RIVENDEL_WORKPLACE_1,
            $workplace_1_Rivendel,
            self::CONFECCION_PROCESS_NAME_RIVENDEL_WORKPLACE_1,
            $adminRootRef,
            self::CONFECCION_PROCESS_DESCRIPTION_RIVENDEL_WORKPLACE_1
        );


        $manager->persist(
            $confeccionProcessOfRivendelWorkplace_1
        );
        $manager->flush();
        $this->addReference(
            self::CONFECCION_PROCESS_RIVENDEL_WORKPLACE_1_REFERENCE,
            $confeccionProcessOfRivendelWorkplace_1
        );

    }

    private function createProcessOfWorkplace(
        string $id,
        Workplace $workplace,
        string $name,
        ?Admin $creatorAdmin = null,
        ?string $description = null
    ): Process
    {
        $process = new Process(
            new Uuid($id),
            $workplace,
            new LongName($name),
            $creatorAdmin
        );

        $process->setDescription(
            new ProcessDescription($description)
        );

        return $process;

    }

}