<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330081659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add active to Process model';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE process ADD active TINYINT(1) DEFAULT true NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE process DROP active');
    }
}
