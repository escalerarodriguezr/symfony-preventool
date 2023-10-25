<?php

namespace Preventool\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Preventool\Domain\Shared\Model\Value\Email;
use Preventool\Domain\Shared\Model\Value\Uuid;
use Preventool\Domain\User\Model\User;
use Preventool\Domain\User\Model\Value\UserPassword;
use Preventool\Domain\User\Model\Value\UserRole;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureInterface
{

    const ROOT_UUID = '03df8a4e-4598-4033-9bbf-8cd90d7b1f99';
    const ROOT_EMAIL = 'root@preventool.com';
    const ROOT_PASSWORD = 'root-password';
    const ROOT_ROLE = UserRole::USER_ROLE_ADMIN;
    const ROOT_USER_REFERENCE = 'root-user';

    const ADMIN_UUID = AdminFixtures::ADMIN_ADMIN_UUID;
    const ADMIN_EMAIL = AdminFixtures::ADMIN_ADMIN_EMAIL;
    const ADMIN_PASSWORD = AdminFixtures::ADMIN_ADMIN_PASSWORD;
    const ADMIN_ROLE = UserRole::USER_ROLE_ADMIN;
    const ADMIN_USER_REFERENCE = 'admin-user';


    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {

    }

    public function load(ObjectManager $manager): void
    {
        $root = $this->createUser(
            self::ROOT_UUID,
            self::ROOT_EMAIL,
            self::ROOT_ROLE,
            self::ROOT_PASSWORD,
        );

        $manager->persist($root);
        $manager->flush();
        $this->addReference(self::ROOT_USER_REFERENCE, $root);

        $adminUser = $this->createUser(
            self::ADMIN_UUID,
            self::ADMIN_EMAIL,
            self::ADMIN_ROLE,
            self::ADMIN_PASSWORD,
        );

        $manager->persist($adminUser);
        $manager->flush();
        $this->addReference(self::ADMIN_USER_REFERENCE, $adminUser);
    }

    private function createUser(
        string $id,
        string $email,
        string $role,
        string $password

    ): User
    {
        $user = new User(
            new Uuid($id),
            new Email($email),
            new UserRole($role),

        );

        $password = new UserPassword($password);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password->value
        );

        $user->setPassword($hashedPassword);
        return $user;
    }

}