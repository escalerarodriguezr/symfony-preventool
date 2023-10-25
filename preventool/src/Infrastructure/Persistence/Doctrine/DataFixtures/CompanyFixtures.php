<?php

namespace Preventool\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Model\Value\AdminType;
use Preventool\Domain\Company\Model\Company;
use Preventool\Domain\Company\Model\Value\Address;
use Preventool\Domain\Company\Model\Value\LegalDocument;
use Preventool\Domain\Company\Model\Value\LegalName;
use Preventool\Domain\Company\Model\Value\Sector;
use Preventool\Domain\Shared\Model\Value\Email;
use Preventool\Domain\Shared\Model\Value\LastName;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\User\Model\User;
use Preventool\Domain\User\Model\Value\UserPassword;
use Preventool\Domain\User\Model\Value\UserRole;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CompanyFixtures extends Fixture implements FixtureInterface
{

    const RIVENDEL_UUID = 'be2a1167-ea3b-49ef-9375-64851a648446';
    const RIVENDEL_NAME = 'Rivendel';
    const RIVENDEL_LEGAL_NAME = 'Rivendel S.A';
    const RIVENDEL_LEGAL_DOCUMENT = '2011111111';
    const RIVENDEL_ADDRESS = 'La Tierra Media s/n';
    const RIVENDEL_SECTOR = 'Elfos';
    const RIVENDEL_REFERENCE = 'company-rivendel';





    public function __construct()
    {

    }

    public function load(ObjectManager $manager): void
    {
        $rivendelCompany = $this->createCompany(
            self::RIVENDEL_UUID,
            self::RIVENDEL_NAME,
            self::RIVENDEL_LEGAL_NAME,
            self::RIVENDEL_LEGAL_DOCUMENT,
            self::RIVENDEL_ADDRESS,
            self::RIVENDEL_SECTOR
        );

        /**
         * @var Admin $adminRootRef ;
         */
        $adminRootRef = $this->getReference(AdminFixtures::ROOT_ADMIN_REFERENCE);
        $rivendelCompany->setCreatorAdmin($adminRootRef);

        $manager->persist($rivendelCompany);
        $manager->flush();
        $this->addReference(self::RIVENDEL_REFERENCE, $rivendelCompany);

    }

    private function createCompany(
        string $id,
        string $name,
        string $legalName,
        string $legalDocument,
        string $address,
        string $sector

    ): Company
    {
        return new Company(
            new Uuid($id),
            new Name($name),
            new LegalName($legalName),
            new LegalDocument($legalDocument),
            new Address($address),
            new Sector($sector)
        );
    }

}