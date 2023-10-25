<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230424122607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create TaskHazard model';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task_hazard (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', process_activity_task_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', workplace_hazard_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', active TINYINT(1) DEFAULT true NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D0DFA96078250F89 (process_activity_task_id), INDEX IDX_D0DFA960B103F64A (workplace_hazard_id), INDEX IDX_D0DFA96033CDA58C (creator_admin_id), INDEX IDX_D0DFA960515DFA95 (updater_admin_id), UNIQUE INDEX U_task_hazard_task_id_hazard_id (workplace_hazard_id, process_activity_task_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task_hazard ADD CONSTRAINT FK_D0DFA96078250F89 FOREIGN KEY (process_activity_task_id) REFERENCES process_activity_task (id)');
        $this->addSql('ALTER TABLE task_hazard ADD CONSTRAINT FK_D0DFA960B103F64A FOREIGN KEY (workplace_hazard_id) REFERENCES workplace_hazard (id)');
        $this->addSql('ALTER TABLE task_hazard ADD CONSTRAINT FK_D0DFA96033CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE task_hazard ADD CONSTRAINT FK_D0DFA960515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_hazard DROP FOREIGN KEY FK_D0DFA96078250F89');
        $this->addSql('ALTER TABLE task_hazard DROP FOREIGN KEY FK_D0DFA960B103F64A');
        $this->addSql('ALTER TABLE task_hazard DROP FOREIGN KEY FK_D0DFA96033CDA58C');
        $this->addSql('ALTER TABLE task_hazard DROP FOREIGN KEY FK_D0DFA960515DFA95');
        $this->addSql('DROP TABLE task_hazard');
    }
}
