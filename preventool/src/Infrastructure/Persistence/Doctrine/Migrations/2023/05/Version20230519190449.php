<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230519190449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create TaskRiskAssessment model';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task_risk_assessment (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', task_risk_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', approved_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', revised_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', status VARCHAR(50) NOT NULL, revision INT NOT NULL, risk_level_index INT NOT NULL, severity_index INT NOT NULL, people_exposed_index INT NOT NULL, procedure_index INT NOT NULL, training_index INT NOT NULL, exposure_index INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_BC972B14580E157C (approved_admin_id), INDEX IDX_BC972B1458B610A8 (revised_admin_id), INDEX IDX_BC972B1433CDA58C (creator_admin_id), INDEX IDX_BC972B14515DFA95 (updater_admin_id), UNIQUE INDEX U_task_risk_assessment_task_risk_id (task_risk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task_risk_assessment ADD CONSTRAINT FK_BC972B141DD49C3B FOREIGN KEY (task_risk_id) REFERENCES task_risk (id)');
        $this->addSql('ALTER TABLE task_risk_assessment ADD CONSTRAINT FK_BC972B14580E157C FOREIGN KEY (approved_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE task_risk_assessment ADD CONSTRAINT FK_BC972B1458B610A8 FOREIGN KEY (revised_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE task_risk_assessment ADD CONSTRAINT FK_BC972B1433CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE task_risk_assessment ADD CONSTRAINT FK_BC972B14515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_risk_assessment DROP FOREIGN KEY FK_BC972B141DD49C3B');
        $this->addSql('ALTER TABLE task_risk_assessment DROP FOREIGN KEY FK_BC972B14580E157C');
        $this->addSql('ALTER TABLE task_risk_assessment DROP FOREIGN KEY FK_BC972B1458B610A8');
        $this->addSql('ALTER TABLE task_risk_assessment DROP FOREIGN KEY FK_BC972B1433CDA58C');
        $this->addSql('ALTER TABLE task_risk_assessment DROP FOREIGN KEY FK_BC972B14515DFA95');
        $this->addSql('DROP TABLE task_risk_assessment');
    }
}
