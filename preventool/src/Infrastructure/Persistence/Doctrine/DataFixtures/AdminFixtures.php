<?php

namespace Preventool\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Admin\Model\Value\AdminRole;
use Preventool\Domain\Admin\Model\Value\AdminType;
use Preventool\Domain\Shared\Model\Value\Email;
use Preventool\Domain\Shared\Model\Value\LastName;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\User\Model\User;
use Preventool\Domain\User\Model\Value\UserPassword;
use Preventool\Domain\User\Model\Value\UserRole;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture implements FixtureInterface
{

    const ROOT_ADMIN_UUID = '03df8a4e-4598-4033-9bbf-8cd90d7b1f99';
    const ROOT_ADMIN_EMAIL = 'root@preventool.com';
    const ROOT_ADMIN_PASSWORD = 'root-password';
    const ROOT_ADMIN_TYPE = AdminType::ADMIN_TYPE_ADMIN;
    const ROOT_ADMIN_ROLE = AdminRole::ADMIN_ROLE_ROOT;
    const ROOT_ADMIN_REFERENCE = 'root-admin';
    const ROOT_ADMIN_NAME = 'RootName';
    const ROOT_ADMIN_LASTNAME = 'RootLastName';

    const ADMIN_ADMIN_UUID = 'aeb5b4d1-a34a-4eba-bb10-e84da4aaa0e7';
    const ADMIN_ADMIN_EMAIL = 'admin@preventool.com';
    const ADMIN_ADMIN_PASSWORD = 'admin-password';
    const ADMIN_ADMIN_TYPE = AdminType::ADMIN_TYPE_ADMIN;
    const ADMIN_ADMIN_ROLE = AdminRole::ADMIN_ROLE_ADMIN;
    const ADMIN_ADMIN_REFERENCE = 'admin-admin';
    const ADMIN_ADMIN_NAME = 'AdminName';
    const ADMIN_ADMIN_LASTNAME = 'AdminLastName';




    public function __construct()
    {

    }

    public function load(ObjectManager $manager): void
    {
        $rootAdmin = $this->createAdmin(
            self::ROOT_ADMIN_UUID,
            self::ROOT_ADMIN_EMAIL,
            self::ROOT_ADMIN_TYPE,
            self::ROOT_ADMIN_ROLE,
            self::ROOT_ADMIN_NAME,
            self::ROOT_ADMIN_LASTNAME
        );

        $manager->persist($rootAdmin);
        $manager->flush();
        $this->addReference(self::ROOT_ADMIN_REFERENCE, $rootAdmin);

        $adminAdmin = $this->createAdmin(
            self::ADMIN_ADMIN_UUID,
            self::ADMIN_ADMIN_EMAIL,
            self::ADMIN_ADMIN_TYPE,
            self::ADMIN_ADMIN_ROLE,
            self::ADMIN_ADMIN_NAME,
            self::ADMIN_ADMIN_LASTNAME

        );

        /**
         * @var Admin $adminRootRef ;
         */
        $adminRootRef = $this->getReference(self::ROOT_ADMIN_REFERENCE);
        $adminAdmin->setCreatorAdmin($adminRootRef);

        $manager->persist($adminAdmin);
        $manager->flush();
        $this->addReference(self::ADMIN_ADMIN_REFERENCE, $adminAdmin);

    }

    private function createAdmin(
        string $id,
        string $email,
        string $type,
        string $role,
        string $name,
        string $lastName

    ): Admin
    {
        return new Admin(
            new Uuid($id),
            new Email($email),
            new AdminType($type),
            new AdminRole($role),
            new Name($name),
            new LastName($lastName)
        );
    }

}