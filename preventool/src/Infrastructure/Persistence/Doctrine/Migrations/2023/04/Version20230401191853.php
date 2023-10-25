<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230401191853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Processctivity model';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE process_activity (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', process_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, activity_order INT NOT NULL, active TINYINT(1) DEFAULT true NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5A8557DB33CDA58C (creator_admin_id), INDEX IDX_5A8557DB515DFA95 (updater_admin_id), INDEX IDX_process_activity_process (process_id), UNIQUE INDEX U_activity_name_process (name, process_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE process_activity ADD CONSTRAINT FK_5A8557DB7EC2F574 FOREIGN KEY (process_id) REFERENCES process (id)');
        $this->addSql('ALTER TABLE process_activity ADD CONSTRAINT FK_5A8557DB33CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE process_activity ADD CONSTRAINT FK_5A8557DB515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE process_activity DROP FOREIGN KEY FK_5A8557DB7EC2F574');
        $this->addSql('ALTER TABLE process_activity DROP FOREIGN KEY FK_5A8557DB33CDA58C');
        $this->addSql('ALTER TABLE process_activity DROP FOREIGN KEY FK_5A8557DB515DFA95');
        $this->addSql('DROP TABLE process_activity');
    }
}
