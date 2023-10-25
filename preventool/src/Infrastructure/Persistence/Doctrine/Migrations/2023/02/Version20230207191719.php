<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207191719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create `workplace` table for Workplace model';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workplace (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', company_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(100) NOT NULL, contact_phone VARCHAR(20) NOT NULL, address VARCHAR(200) NOT NULL, number_of_workers INT NOT NULL, active TINYINT(1) DEFAULT true NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D0FB92EE33CDA58C (creator_admin_id), INDEX IDX_D0FB92EE515DFA95 (updater_admin_id), INDEX IDX_workplace_company (company_id), UNIQUE INDEX U_name_workplace_company (name, company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workplace ADD CONSTRAINT FK_D0FB92EE979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE workplace ADD CONSTRAINT FK_D0FB92EE33CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE workplace ADD CONSTRAINT FK_D0FB92EE515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workplace DROP FOREIGN KEY FK_D0FB92EE979B1AD6');
        $this->addSql('ALTER TABLE workplace DROP FOREIGN KEY FK_D0FB92EE33CDA58C');
        $this->addSql('ALTER TABLE workplace DROP FOREIGN KEY FK_D0FB92EE515DFA95');
        $this->addSql('DROP TABLE workplace');
    }
}
