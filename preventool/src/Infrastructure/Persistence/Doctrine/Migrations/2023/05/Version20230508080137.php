<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508080137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop U_task_hazard_task_id_hazard_id uniqye index';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX U_task_hazard_task_id_hazard_id ON task_hazard');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX U_task_hazard_task_id_hazard_id ON task_hazard (workplace_hazard_id, process_activity_task_id)');
    }
}
