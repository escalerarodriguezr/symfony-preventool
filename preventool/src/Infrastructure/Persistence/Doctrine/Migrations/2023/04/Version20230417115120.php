<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230417115120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create WorkplaceHazardCategory and WorkplaceHazard models';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workplace_hazard (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', workplace_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', workplace_hazard_category_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(100) NOT NULL, description VARCHAR(300) DEFAULT NULL, active TINYINT(1) DEFAULT true NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8C478E7AC25FB46 (workplace_id), INDEX IDX_8C478E7FE9B7A0E (workplace_hazard_category_id), INDEX IDX_8C478E733CDA58C (creator_admin_id), INDEX IDX_8C478E7515DFA95 (updater_admin_id), INDEX IDX_workplace_hazard_active (active), UNIQUE INDEX U_workplace_workplace_hazard_name (workplace_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workplace_hazard_category (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', workplace_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(100) NOT NULL, description VARCHAR(300) DEFAULT NULL, active TINYINT(1) DEFAULT true NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DD6F0353AC25FB46 (workplace_id), INDEX IDX_DD6F035333CDA58C (creator_admin_id), INDEX IDX_DD6F0353515DFA95 (updater_admin_id), INDEX IDX_workplace_hazard_category_active (active), UNIQUE INDEX U_workplace_workplace_hazard_category_name (workplace_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workplace_hazard ADD CONSTRAINT FK_8C478E7AC25FB46 FOREIGN KEY (workplace_id) REFERENCES workplace (id)');
        $this->addSql('ALTER TABLE workplace_hazard ADD CONSTRAINT FK_8C478E7FE9B7A0E FOREIGN KEY (workplace_hazard_category_id) REFERENCES workplace_hazard_category (id)');
        $this->addSql('ALTER TABLE workplace_hazard ADD CONSTRAINT FK_8C478E733CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE workplace_hazard ADD CONSTRAINT FK_8C478E7515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE workplace_hazard_category ADD CONSTRAINT FK_DD6F0353AC25FB46 FOREIGN KEY (workplace_id) REFERENCES workplace (id)');
        $this->addSql('ALTER TABLE workplace_hazard_category ADD CONSTRAINT FK_DD6F035333CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE workplace_hazard_category ADD CONSTRAINT FK_DD6F0353515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workplace_hazard DROP FOREIGN KEY FK_8C478E7AC25FB46');
        $this->addSql('ALTER TABLE workplace_hazard DROP FOREIGN KEY FK_8C478E7FE9B7A0E');
        $this->addSql('ALTER TABLE workplace_hazard DROP FOREIGN KEY FK_8C478E733CDA58C');
        $this->addSql('ALTER TABLE workplace_hazard DROP FOREIGN KEY FK_8C478E7515DFA95');
        $this->addSql('ALTER TABLE workplace_hazard_category DROP FOREIGN KEY FK_DD6F0353AC25FB46');
        $this->addSql('ALTER TABLE workplace_hazard_category DROP FOREIGN KEY FK_DD6F035333CDA58C');
        $this->addSql('ALTER TABLE workplace_hazard_category DROP FOREIGN KEY FK_DD6F0353515DFA95');
        $this->addSql('DROP TABLE workplace_hazard');
        $this->addSql('DROP TABLE workplace_hazard_category');
    }
}
