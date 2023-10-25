<?php

namespace Preventool\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Shared\Model\Value\MediumDescription;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;
use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazard;
use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazardCategory;


class WorkplaceHazardFixtures extends Fixture implements FixtureInterface
{
    const NOISES_ID = '64b89250-e72d-4088-8c65-ceaaf9742a61';
    const NOISES_NAME = 'Ruidos';
    const NOISES_DESCRIPTION = 'Descripción Ruidos';
    const NOISES_REFERENCE = 'workplace-hazard-category-noises';

    const TEMPERATURES_ID = '948df693-6a79-417b-9d01-08dc5bddfe3a';
    const TEMPERATURES_NAME = 'Temperaturas extremas';
    const TEMPERATURES_DESCRIPTION = 'Descripción temeperaturas extremas';
    const TEMPERATURES_REFERENCE = 'workplace-hazard-category-temperatures';

    const VIBRATIONS_ID = 'cd1f3d51-d154-4710-a8ac-1c808ba80e05';
    const VIBRATIONS_NAME = 'Vibraciones';
    const VIBRATIONS_DESCRIPTION = 'Descripción vibraciones';
    const VIBRATIONS_REFERENCE = 'workplace-hazard-category-vibraciones';



    public function __construct()
    {

    }

    public function load(ObjectManager $manager): void
    {

        /**
         * @var Workplace $workplace
         */
        $workplace = $this->getReference(WorkplaceFixtures::RIVENDEL_WORKPLACE_1_REFERENCE);

        /**
         * @var Admin $adminRootRef ;
         */
        $adminRootRef = $this->getReference(AdminFixtures::ROOT_ADMIN_REFERENCE);

        /**
         * @var WorkplaceHazardCategory $fisicosCategory
         */
        $fisicosCategory = $this->getReference(WorkplaceHazardCategoryFixtures::FISICOS_REFERENCE);

        //Ruidos
        $noises = $this->createWorkplaceHazard(
            self::NOISES_ID,
            $workplace,
            $fisicosCategory,
            self::NOISES_NAME
        );

        $noises->setDescription(new MediumDescription(self::NOISES_DESCRIPTION));


        $noises->setCreatorAdmin($adminRootRef);

        $manager->persist($noises);
        $manager->flush();
        $this->addReference(self::NOISES_REFERENCE,$noises);


        //Temperaturas
        $temperatures = $this->createWorkplaceHazard(
            self::TEMPERATURES_ID,
            $workplace,
            $fisicosCategory,
            self::TEMPERATURES_NAME
        );

        $temperatures->setDescription(new MediumDescription(self::TEMPERATURES_DESCRIPTION));


        $temperatures->setCreatorAdmin($adminRootRef);

        $manager->persist($temperatures);
        $manager->flush();
        $this->addReference(self::TEMPERATURES_REFERENCE,$temperatures);


        //Vibrations
        $vibrations = $this->createWorkplaceHazard(
            self::VIBRATIONS_ID,
            $workplace,
            $fisicosCategory,
            self::VIBRATIONS_NAME
        );

        $vibrations->setDescription(new MediumDescription(self::VIBRATIONS_DESCRIPTION));


        $vibrations->setCreatorAdmin($adminRootRef);

        $manager->persist($vibrations);
        $manager->flush();
        $this->addReference(self::VIBRATIONS_REFERENCE,$vibrations);


    }

    private function createWorkplaceHazard(
        string $id,
        Workplace $workplace,
        WorkplaceHazardCategory $category,
        string $name

    ): WorkplaceHazard
    {
        return new WorkplaceHazard(
            new Uuid($id),
            $workplace,
            $category,
            new Name($name)
        );
    }

}