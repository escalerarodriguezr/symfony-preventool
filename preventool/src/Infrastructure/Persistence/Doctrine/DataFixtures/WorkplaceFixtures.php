<?php

namespace Preventool\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\BaselineStudy\Service\CreateBaselineStudyComplianceOfWorkplace;
use Preventool\Domain\BaselineStudy\Service\CreateBaselineStudyOfWorkplace;
use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Company\Model\Value\Address;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Phone;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\Workplace\Model\Workplace;

class WorkplaceFixtures extends Fixture implements FixtureInterface
{

    const RIVENDEL_WORKPLACE_1_UUID = 'b1f96a86-9855-4c33-9051-a7049ae08606';
    const RIVENDEL_WORKPLACE_1_NAME = 'Rivendel-Centro_Trabaja_1';
    const RIVENDEL_WORKPLACE_1_CONTACT_PHONE = '942824021';
    const RIVENDEL_WORKPLACE_1_ADDRESS = 'Barrio de la casa de Elrond';
    const RIVENDEL_WORKPLACE_1_NUMBER_OF_WORKERS = 2000;
    const RIVENDEL_WORKPLACE_1_REFERENCE = 'company-rivendel-worjplace-1';





    public function __construct(
        private readonly CreateBaselineStudyOfWorkplace $createBaselineStudyOfWorkplace,
        private readonly CreateBaselineStudyComplianceOfWorkplace $createBaselineStudyComplianceOfWorkplace
    )
    {

    }

    public function load(ObjectManager $manager): void
    {

        /**
         * @var Company $company
         */
        $company = $this->getReference(CompanyFixtures::RIVENDEL_REFERENCE);

        $rivendelCompanyWorkplace_1 = $this->createWorkplace(
            self::RIVENDEL_WORKPLACE_1_UUID,
            $company,
            self::RIVENDEL_WORKPLACE_1_NAME,
            self::RIVENDEL_WORKPLACE_1_CONTACT_PHONE,
            self::RIVENDEL_WORKPLACE_1_ADDRESS,
            self::RIVENDEL_WORKPLACE_1_NUMBER_OF_WORKERS
        );

        /**
         * @var Admin $adminRootRef ;
         */
        $adminRootRef = $this->getReference(AdminFixtures::ROOT_ADMIN_REFERENCE);
        $rivendelCompanyWorkplace_1->setCreatorAdmin($adminRootRef);

        $manager->persist($rivendelCompanyWorkplace_1);
        $manager->flush();
        $this->addReference(self::RIVENDEL_WORKPLACE_1_REFERENCE, $rivendelCompanyWorkplace_1);

        $this->createBaselineStudyOfWorkplace->__invoke($rivendelCompanyWorkplace_1);
        $this->createBaselineStudyComplianceOfWorkplace->__invoke($rivendelCompanyWorkplace_1);
    }

    private function createWorkplace(
        string $id,
        Company $company,
        string $name,
        string $contactPhone,
        string $address,
        string $numberOfWorkers

    ): Workplace
    {
        return new Workplace(
            new Uuid($id),
            $company,
            new Name($name),
            new Phone($contactPhone),
            new Address($address),
            $numberOfWorkers
        );
    }

}