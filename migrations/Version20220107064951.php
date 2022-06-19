<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220107064951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vacancy_membersips (id CHAR(36) NOT NULL --(DC2Type:guid)
        , vacancy_id CHAR(36) NOT NULL --(DC2Type:vacancy_id)
        , person_id CHAR(36) NOT NULL --(DC2Type:person_id)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7F640A6B433B78C4 ON vacancy_membersips (vacancy_id)');
        $this->addSql('CREATE INDEX IDX_7F640A6B217BBB47 ON vacancy_membersips (person_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7F640A6B433B78C4217BBB47 ON vacancy_membersips (vacancy_id, person_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__persons AS SELECT id, date, email, person_phone, name_first, name_last FROM persons');
        $this->addSql('DROP TABLE persons');
        $this->addSql('CREATE TABLE persons (id CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:person_id)
        , date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , email VARCHAR(255) DEFAULT NULL, person_phone VARCHAR(255) DEFAULT NULL COLLATE BINARY, name_first VARCHAR(255) NOT NULL COLLATE BINARY, name_last VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO persons (id, date, email, person_phone, name_first, name_last) SELECT id, date, email, person_phone, name_first, name_last FROM __temp__persons');
        $this->addSql('DROP TABLE __temp__persons');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vacancy_membersips');
        $this->addSql('CREATE TEMPORARY TABLE __temp__persons AS SELECT id, date, email, person_phone, name_first, name_last FROM persons');
        $this->addSql('DROP TABLE persons');
        $this->addSql('CREATE TABLE persons (id CHAR(36) NOT NULL --(DC2Type:person_id)
        , date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , email VARCHAR(255) DEFAULT NULL COLLATE BINARY, person_phone VARCHAR(255) DEFAULT NULL, name_first VARCHAR(255) NOT NULL, name_last VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO persons (id, date, email, person_phone, name_first, name_last) SELECT id, date, email, person_phone, name_first, name_last FROM __temp__persons');
        $this->addSql('DROP TABLE __temp__persons');
    }
}
