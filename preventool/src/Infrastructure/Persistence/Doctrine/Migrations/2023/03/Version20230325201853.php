<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230325201853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change Bug in BaselineStudyCompliance';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs;
        $this->addSql('ALTER TABLE baseline_study_compliance CHANGE planteamiento_compliance planeamiento_compliance INT NOT NULL');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE baseline_study_compliance CHANGE planeamiento_compliance planteamiento_compliance INT NOT NULL');

    }
}
