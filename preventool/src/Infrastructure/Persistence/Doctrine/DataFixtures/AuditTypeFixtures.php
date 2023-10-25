<?php

namespace Preventool\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Preventool\Domain\Admin\Model\Admin;
use Preventool\Domain\Audit\Model\AuditType;
use Preventool\Domain\Audit\Model\Value\AuditTypeScope;
use Preventool\Domain\Shared\Model\Value\MediumDescription;
use Preventool\Domain\Shared\Model\Value\Name;
use Preventool\Domain\Shared\Model\Value\Uuid;

class AuditTypeFixtures extends Fixture implements FixtureInterface
{

    const AUDIT_TYPE_SYSTEM_UUID = 'd22679f8-66ce-423b-bd6f-95304ee98249';
    const AUDIT_TYPE_SYSTEM_SCOPE = AuditTypeScope::SCOPE_SYSTEM;
    const AUDIT_TYPE_SYSTEM_NAME = 'Línea base';
    const AUDIT_TYPE_SYSTEM_DESCRIPTION = 'Estudio de Línea Base del Sistema de SST';
    const AUDIT_TYPE_SYSTEM_REFERENCE = 'audit-type-system';

    public function __construct()
    {

    }

    public function load(ObjectManager $manager): void
    {

        $auditTypeSystem = $this->createAuditType(
            self::AUDIT_TYPE_SYSTEM_UUID,
            self::AUDIT_TYPE_SYSTEM_NAME,
            self::AUDIT_TYPE_SYSTEM_SCOPE,
        );

        $auditTypeSystem->setDescription(
            new MediumDescription(self::AUDIT_TYPE_SYSTEM_DESCRIPTION)
        );

        /**
         * @var Admin $adminRootRef ;
         */
        $adminRootRef = $this->getReference(
            AdminFixtures::ROOT_ADMIN_REFERENCE
        );
        $auditTypeSystem->setCreatorAdmin(
            $adminRootRef
        );

        $manager->persist(
            $auditTypeSystem
        );
        $manager->flush();

        $this->addReference(
            self::AUDIT_TYPE_SYSTEM_REFERENCE,
            $auditTypeSystem
        );

    }

    private function createAuditType(
        string $id,
        string $name,
        string $scope

    ): AuditType
    {
        return new AuditType(
            new Uuid($id),
            new AuditTypeScope($scope),
            new Name($name),
        );
    }

}