<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309114317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create BaselineStudy model';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE baseline_study (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', workplace_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', category VARCHAR(50) NOT NULL, indicator VARCHAR(50) NOT NULL, compliance_percentage INT NOT NULL, observations TEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E74B805A33CDA58C (creator_admin_id), INDEX IDX_E74B805A515DFA95 (updater_admin_id), INDEX IDX_bl_workplace (workplace_id), UNIQUE INDEX U_bl_indicator_workplace (indicator, workplace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE baseline_study ADD CONSTRAINT FK_E74B805AAC25FB46 FOREIGN KEY (workplace_id) REFERENCES workplace (id)');
        $this->addSql('ALTER TABLE baseline_study ADD CONSTRAINT FK_E74B805A33CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE baseline_study ADD CONSTRAINT FK_E74B805A515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE baseline_study DROP FOREIGN KEY FK_E74B805AAC25FB46');
        $this->addSql('ALTER TABLE baseline_study DROP FOREIGN KEY FK_E74B805A33CDA58C');
        $this->addSql('ALTER TABLE baseline_study DROP FOREIGN KEY FK_E74B805A515DFA95');
        $this->addSql('DROP TABLE baseline_study');
    }
}
