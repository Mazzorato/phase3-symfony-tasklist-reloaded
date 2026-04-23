<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260423142826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE folder_task');
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, status, is_pinned, user_id, priority_id, folder_id FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, is_pinned BOOLEAN DEFAULT 0 NOT NULL, user_id INTEGER DEFAULT NULL, priority_id INTEGER DEFAULT NULL, folder_id INTEGER DEFAULT NULL, CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_527EDB25497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_527EDB25162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO task (id, title, status, is_pinned, user_id, priority_id, folder_id) SELECT id, title, status, is_pinned, user_id, priority_id, folder_id FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
        $this->addSql('CREATE INDEX IDX_527EDB25162CB942 ON task (folder_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25A76ED395 ON task (user_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25497B19F9 ON task (priority_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE folder_task (folder_id INTEGER NOT NULL, task_id INTEGER NOT NULL, PRIMARY KEY (folder_id, task_id), CONSTRAINT FK_4BE1FD30162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4BE1FD308DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4BE1FD308DB60186 ON folder_task (task_id)');
        $this->addSql('CREATE INDEX IDX_4BE1FD30162CB942 ON folder_task (folder_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, status, is_pinned, user_id, priority_id, folder_id FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, is_pinned BOOLEAN NOT NULL, user_id INTEGER DEFAULT NULL, priority_id INTEGER DEFAULT NULL, folder_id INTEGER DEFAULT NULL, CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_527EDB25497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_527EDB25162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO task (id, title, status, is_pinned, user_id, priority_id, folder_id) SELECT id, title, status, is_pinned, user_id, priority_id, folder_id FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
        $this->addSql('CREATE INDEX IDX_527EDB25A76ED395 ON task (user_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25497B19F9 ON task (priority_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25162CB942 ON task (folder_id)');
    }
}
