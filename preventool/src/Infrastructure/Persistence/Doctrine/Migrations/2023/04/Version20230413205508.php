<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413205508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create ProcessActivityTask model';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE process_activity_task (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', process_activity_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, task_order INT NOT NULL, active TINYINT(1) DEFAULT true NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EBED833CDA58C (creator_admin_id), INDEX IDX_EBED8515DFA95 (updater_admin_id), INDEX IDX_activity_task_process_activity (process_activity_id), UNIQUE INDEX U_task_name_process_activity (name, process_activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE process_activity_task ADD CONSTRAINT FK_EBED88FB5A387 FOREIGN KEY (process_activity_id) REFERENCES process_activity (id)');
        $this->addSql('ALTER TABLE process_activity_task ADD CONSTRAINT FK_EBED833CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE process_activity_task ADD CONSTRAINT FK_EBED8515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE process_activity_task DROP FOREIGN KEY FK_EBED88FB5A387');
        $this->addSql('ALTER TABLE process_activity_task DROP FOREIGN KEY FK_EBED833CDA58C');
        $this->addSql('ALTER TABLE process_activity_task DROP FOREIGN KEY FK_EBED8515DFA95');
        $this->addSql('DROP TABLE process_activity_task');
    }
}
