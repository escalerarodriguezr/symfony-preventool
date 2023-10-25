<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514194659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove U_task_risk_name';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('DROP INDEX U_task_risk_name ON task_risk');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX U_task_risk_name ON task_risk (name)');
    }
}
