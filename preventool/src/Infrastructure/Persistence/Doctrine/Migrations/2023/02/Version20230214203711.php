<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214203711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Crate HealthAndSafetyPolicy model';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE health_and_safety_policy (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', company_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', approved_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', status VARCHAR(50) NOT NULL, document_resource VARCHAR(200) DEFAULT NULL, active TINYINT(1) DEFAULT true NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_50079D37979B1AD6 (company_id), INDEX IDX_50079D37580E157C (approved_admin_id), INDEX IDX_50079D3733CDA58C (creator_admin_id), INDEX IDX_50079D37515DFA95 (updater_admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE health_and_safety_policy ADD CONSTRAINT FK_50079D37979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE health_and_safety_policy ADD CONSTRAINT FK_50079D37580E157C FOREIGN KEY (approved_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE health_and_safety_policy ADD CONSTRAINT FK_50079D3733CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE health_and_safety_policy ADD CONSTRAINT FK_50079D37515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE health_and_safety_policy DROP FOREIGN KEY FK_50079D37979B1AD6');
        $this->addSql('ALTER TABLE health_and_safety_policy DROP FOREIGN KEY FK_50079D37580E157C');
        $this->addSql('ALTER TABLE health_and_safety_policy DROP FOREIGN KEY FK_50079D3733CDA58C');
        $this->addSql('ALTER TABLE health_and_safety_policy DROP FOREIGN KEY FK_50079D37515DFA95');
        $this->addSql('DROP TABLE health_and_safety_policy');
    }
}
