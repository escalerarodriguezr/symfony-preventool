<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326190407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Process model';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE process (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', workplace_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(100) NOT NULL, revision_number INT NOT NULL, revision_of CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', revised_by CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_861D189633CDA58C (creator_admin_id), INDEX IDX_861D1896515DFA95 (updater_admin_id), INDEX IDX_process_workplace (workplace_id), UNIQUE INDEX U_process_name_workplace_revision (name, workplace_id, revision_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D1896AC25FB46 FOREIGN KEY (workplace_id) REFERENCES workplace (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D189633CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D1896515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D1896AC25FB46');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D189633CDA58C');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D1896515DFA95');
        $this->addSql('DROP TABLE process');
    }
}
