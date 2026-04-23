<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260423081032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__folder AS SELECT id FROM folder');
        $this->addSql('DROP TABLE folder');
        $this->addSql('CREATE TABLE folder (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(7) NOT NULL, user_id INTEGER DEFAULT NULL, CONSTRAINT FK_ECA209CDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO folder (id) SELECT id FROM __temp__folder');
        $this->addSql('DROP TABLE __temp__folder');
        $this->addSql('CREATE INDEX IDX_ECA209CDA76ED395 ON folder (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__folder AS SELECT id FROM folder');
        $this->addSql('DROP TABLE folder');
        $this->addSql('CREATE TABLE folder (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO folder (id) SELECT id FROM __temp__folder');
        $this->addSql('DROP TABLE __temp__folder');
    }
}
