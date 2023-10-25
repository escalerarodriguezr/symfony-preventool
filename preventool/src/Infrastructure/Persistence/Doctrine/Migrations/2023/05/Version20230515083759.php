<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515083759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Delete WorkplaceHazard relation for TaskHazard model';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE task_hazard DROP FOREIGN KEY FK_D0DFA960B103F64A');
        $this->addSql('DROP INDEX IDX_D0DFA960B103F64A ON task_hazard');
        $this->addSql('ALTER TABLE task_hazard ADD hazard_name VARCHAR(100) NOT NULL, ADD hazard_description VARCHAR(300) DEFAULT NULL, ADD hazard_category_name VARCHAR(100) NOT NULL, DROP workplace_hazard_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE task_hazard ADD workplace_hazard_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', DROP hazard_name, DROP hazard_description, DROP hazard_category_name');
        $this->addSql('ALTER TABLE task_hazard ADD CONSTRAINT FK_D0DFA960B103F64A FOREIGN KEY (workplace_hazard_id) REFERENCES workplace_hazard (id)');
        $this->addSql('CREATE INDEX IDX_D0DFA960B103F64A ON task_hazard (workplace_hazard_id)');
    }
}
