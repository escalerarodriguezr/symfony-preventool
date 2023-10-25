<?php
declare(strict_types=1);

namespace Preventool\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Company\Model\HealthAndSafetyPolicy;
use Preventool\Domain\Shared\Model\Value\DocumentStatus;
use Preventool\Domain\Shared\Model\Value\Uuid;

class HealthAndSafetyPolicyWithDocumentResourceFixtures extends Fixture implements FixtureInterface
{

    const HEALTH_AND_SAFETY_POLICY_OF_COMPANY_RIVENDEL_UUID = 'd22679f8-66ce-423b-bd6f-95304ee98249';
    const HEALTH_AND_SAFETY_POLICY_OF_COMPANY_RIVENDEL_STATUS = DocumentStatus::DRAFT;
    const HEALTH_AND_SAFETY_POLICY_OF_COMPANY_RIVENDEL_DOCUMENT_RESOURCE = '24acac37993a338ad2a6aff49180e2493b22fbde.pdf';
    const HEALTH_AND_SAFETY_POLICY_WITH_DOCUMENT_RESOURCE_OF_COMPANY_RIVENDEL_REFERENCE = 'health_and_safety-policy-of-rivendel';


    public function __construct()
    {

    }

    public function load(ObjectManager $manager): void
    {
        /**
         * @var Company $companyRivendel ;
         */
        $companyRivendel = $this->getReference(CompanyFixtures::RIVENDEL_REFERENCE);

        $healthAndSafetyPolicy = $this->createHealthAndSafetyOfCompany(
            self::HEALTH_AND_SAFETY_POLICY_OF_COMPANY_RIVENDEL_UUID,
            $companyRivendel,
            self::HEALTH_AND_SAFETY_POLICY_OF_COMPANY_RIVENDEL_STATUS
        );

        /**
         * @var Admin $adminRootRef ;
         */
        $adminRootRef = $this->getReference(
            AdminFixtures::ROOT_ADMIN_REFERENCE
        );
        $healthAndSafetyPolicy->setCreatorAdmin(
            $adminRootRef
        );

        $healthAndSafetyPolicy->setDocumentResource(
            self::HEALTH_AND_SAFETY_POLICY_OF_COMPANY_RIVENDEL_DOCUMENT_RESOURCE
        );

        $manager->persist(
            $healthAndSafetyPolicy
        );
        $manager->flush();
        $this->addReference(
            self::HEALTH_AND_SAFETY_POLICY_WITH_DOCUMENT_RESOURCE_OF_COMPANY_RIVENDEL_REFERENCE,
            $healthAndSafetyPolicy
        );

    }

    private function createHealthAndSafetyOfCompany(
        string $id,
        Company $company,
        string $status,

    ): HealthAndSafetyPolicy
    {
        return new HealthAndSafetyPolicy(
            new Uuid($id),
            $company,
            new DocumentStatus($status)
        );
    }

}