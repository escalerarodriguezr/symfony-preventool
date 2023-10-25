<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310143507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create BaselineStudyCompliance model';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE baseline_study_compliance (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', workplace_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', total_compliance INT NOT NULL, compromiso_compliance INT NOT NULL, politica_compliance INT NOT NULL, planteamiento_compliance INT NOT NULL, implementacion_compliance INT NOT NULL, evaluacion_compliance INT NOT NULL, verificacion_compliance INT NOT NULL, control_compliance INT NOT NULL, revision_compliance INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6E4430A833CDA58C (creator_admin_id), INDEX IDX_6E4430A8515DFA95 (updater_admin_id), UNIQUE INDEX U_blc_workplace (workplace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE baseline_study_compliance ADD CONSTRAINT FK_6E4430A8AC25FB46 FOREIGN KEY (workplace_id) REFERENCES workplace (id)');
        $this->addSql('ALTER TABLE baseline_study_compliance ADD CONSTRAINT FK_6E4430A833CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE baseline_study_compliance ADD CONSTRAINT FK_6E4430A8515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE baseline_study_compliance DROP FOREIGN KEY FK_6E4430A8AC25FB46');
        $this->addSql('ALTER TABLE baseline_study_compliance DROP FOREIGN KEY FK_6E4430A833CDA58C');
        $this->addSql('ALTER TABLE baseline_study_compliance DROP FOREIGN KEY FK_6E4430A8515DFA95');
        $this->addSql('DROP TABLE baseline_study_compliance');
    }
}
