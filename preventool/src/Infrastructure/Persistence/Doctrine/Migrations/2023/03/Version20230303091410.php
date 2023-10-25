<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303091410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE audit_type (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', company_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', workplace_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', scope VARCHAR(50) NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, active TINYINT(1) DEFAULT true NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AA7EB92D979B1AD6 (company_id), INDEX IDX_AA7EB92D33CDA58C (creator_admin_id), INDEX IDX_AA7EB92D515DFA95 (updater_admin_id), INDEX IDX_workplace_audit (workplace_id), UNIQUE INDEX U_name_scope_audit (scope, name, company_id, workplace_id, deleted_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE audit_type ADD CONSTRAINT FK_AA7EB92D979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE audit_type ADD CONSTRAINT FK_AA7EB92DAC25FB46 FOREIGN KEY (workplace_id) REFERENCES workplace (id)');
        $this->addSql('ALTER TABLE audit_type ADD CONSTRAINT FK_AA7EB92D33CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE audit_type ADD CONSTRAINT FK_AA7EB92D515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit_type DROP FOREIGN KEY FK_AA7EB92D979B1AD6');
        $this->addSql('ALTER TABLE audit_type DROP FOREIGN KEY FK_AA7EB92DAC25FB46');
        $this->addSql('ALTER TABLE audit_type DROP FOREIGN KEY FK_AA7EB92D33CDA58C');
        $this->addSql('ALTER TABLE audit_type DROP FOREIGN KEY FK_AA7EB92D515DFA95');
        $this->addSql('DROP TABLE audit_type');
    }
}
