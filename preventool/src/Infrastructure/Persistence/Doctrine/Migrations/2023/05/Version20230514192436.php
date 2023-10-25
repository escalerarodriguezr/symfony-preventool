<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514192436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Crate TaskRisk model';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task_risk (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', task_hazard_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(100) NOT NULL, observations TEXT DEFAULT NULL, status VARCHAR(50) NOT NULL, legal_requirement VARCHAR(300) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_AB5413A473FC625 (task_hazard_id), INDEX IDX_AB5413A33CDA58C (creator_admin_id), INDEX IDX_AB5413A515DFA95 (updater_admin_id), UNIQUE INDEX U_task_risk_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task_risk ADD CONSTRAINT FK_AB5413A473FC625 FOREIGN KEY (task_hazard_id) REFERENCES task_hazard (id)');
        $this->addSql('ALTER TABLE task_risk ADD CONSTRAINT FK_AB5413A33CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE task_risk ADD CONSTRAINT FK_AB5413A515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
        ;
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_risk DROP FOREIGN KEY FK_AB5413A473FC625');
        $this->addSql('ALTER TABLE task_risk DROP FOREIGN KEY FK_AB5413A33CDA58C');
        $this->addSql('ALTER TABLE task_risk DROP FOREIGN KEY FK_AB5413A515DFA95');
        $this->addSql('DROP TABLE task_risk');
    }
}
