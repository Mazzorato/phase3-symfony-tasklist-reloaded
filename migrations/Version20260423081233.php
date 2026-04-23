<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260423081233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE folder_task (folder_id INTEGER NOT NULL, task_id INTEGER NOT NULL, PRIMARY KEY (folder_id, task_id), CONSTRAINT FK_4BE1FD30162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4BE1FD308DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4BE1FD30162CB942 ON folder_task (folder_id)');
        $this->addSql('CREATE INDEX IDX_4BE1FD308DB60186 ON folder_task (task_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE folder_task');
    }
}
