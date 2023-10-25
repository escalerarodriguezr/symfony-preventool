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
use Preventool\Domain\WorkplaceHazard\Model\WorkplaceHazardCategory;


class WorkplaceHazardCategoryFixtures extends Fixture implements FixtureInterface
{
    const FISICOS_ID = 'd22679f8-66ce-423b-bd6f-95304ee98249';
    const FISICOS_NAME = 'Físicos';
    const FISICOS_DESCRIPTION = 'Descripción Físicos';
    const FISICOS_REFERENCE = 'workplace-hazard-category-fisicos';

    const QUIMICOS_ID = '40b33929-a613-4cd7-a6c6-112aa085fc86';
    const QUIMICOS_NAME = 'Químicos';
    const QUIMICOS_DESCRIPTION = 'Descripción Químicos';
    const QUIMICOS_REFERENCE = 'workplace-hazard-category-quimicos';





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

        //Fisicos
        $fisicosCategory = $this->createWorkplaceHazardCategory(
            self::FISICOS_ID,
            $workplace,
            self::FISICOS_NAME
        );

        $fisicosCategory->setDescription(new MediumDescription(self::FISICOS_DESCRIPTION));


        $fisicosCategory->setCreatorAdmin($adminRootRef);

        $manager->persist($fisicosCategory);
        $manager->flush();
        $this->addReference(self::FISICOS_REFERENCE,$fisicosCategory);

        //Quimicos
        $quimicosCategory = $this->createWorkplaceHazardCategory(
            self::QUIMICOS_ID,
            $workplace,
            self::QUIMICOS_NAME
        );

        $quimicosCategory->setDescription(new MediumDescription(self::QUIMICOS_DESCRIPTION));


        $quimicosCategory->setCreatorAdmin($adminRootRef);

        $manager->persist($quimicosCategory);
        $manager->flush();
        $this->addReference(self::QUIMICOS_REFERENCE,$quimicosCategory);


    }

    private function createWorkplaceHazardCategory(
        string $id,
        Workplace $workplace,
        string $name

    ): WorkplaceHazardCategory
    {
        return new WorkplaceHazardCategory(
            new Uuid($id),
            $workplace,
            new Name($name)
        );
    }

}