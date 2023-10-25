<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230114201421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Alter `admin` table for Admin model add CreatorAdmin and UpdaterAdmin and active';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD creator_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', ADD updater_admin_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', ADD active TINYINT(1) DEFAULT true NOT NULL');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D7633CDA58C FOREIGN KEY (creator_admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76515DFA95 FOREIGN KEY (updater_admin_id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX IDX_880E0D7633CDA58C ON admin (creator_admin_id)');
        $this->addSql('CREATE INDEX IDX_880E0D76515DFA95 ON admin (updater_admin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D7633CDA58C');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76515DFA95');
        $this->addSql('DROP INDEX IDX_880E0D7633CDA58C ON admin');
        $this->addSql('DROP INDEX IDX_880E0D76515DFA95 ON admin');
        $this->addSql('ALTER TABLE admin DROP creator_admin_id, DROP updater_admin_id, DROP active');
    }
}
