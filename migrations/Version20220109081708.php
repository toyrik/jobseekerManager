<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220109081708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_4DFF111C608487BC6A95E9C4');
        $this->addSql('DROP INDEX IDX_4DFF111C217BBB47');
        $this->addSql('CREATE TEMPORARY TABLE __temp__person_networks AS SELECT id, person_id, network, identity FROM person_networks');
        $this->addSql('DROP TABLE person_networks');
        $this->addSql('CREATE TABLE person_networks (id CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:guid)
        , person_id CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:person_id)
        , network VARCHAR(32) DEFAULT NULL COLLATE BINARY, identity VARCHAR(32) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_4DFF111C217BBB47 FOREIGN KEY (person_id) REFERENCES persons (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO person_networks (id, person_id, network, identity) SELECT id, person_id, network, identity FROM __temp__person_networks');
        $this->addSql('DROP TABLE __temp__person_networks');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4DFF111C608487BC6A95E9C4 ON person_networks (network, identity)');
        $this->addSql('CREATE INDEX IDX_4DFF111C217BBB47 ON person_networks (person_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__persons AS SELECT id, date, email, person_phone, name_first, name_last, job_title FROM persons');
        $this->addSql('DROP TABLE persons');
        $this->addSql('CREATE TABLE persons (id CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:person_id)
        , date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , email VARCHAR(255) DEFAULT NULL, person_phone VARCHAR(255) DEFAULT NULL, name_first VARCHAR(255) NOT NULL COLLATE BINARY, name_last VARCHAR(255) NOT NULL COLLATE BINARY, job_title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO persons (id, date, email, person_phone, name_first, name_last, job_title) SELECT id, date, email, person_phone, name_first, name_last, job_title FROM __temp__persons');
        $this->addSql('DROP TABLE __temp__persons');
        $this->addSql('DROP INDEX IDX_7F640A6B433B78C4');
        $this->addSql('DROP INDEX IDX_7F640A6B217BBB47');
        $this->addSql('DROP INDEX UNIQ_7F640A6B433B78C4217BBB47');
        $this->addSql('CREATE TEMPORARY TABLE __temp__vacancy_membersips AS SELECT id, vacancy_id, person_id FROM vacancy_membersips');
        $this->addSql('DROP TABLE vacancy_membersips');
        $this->addSql('CREATE TABLE vacancy_membersips (id CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:guid)
        , vacancy_id CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:vacancy_id)
        , person_id CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:person_id)
        , PRIMARY KEY(id), CONSTRAINT FK_7F640A6B433B78C4 FOREIGN KEY (vacancy_id) REFERENCES vacancies (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7F640A6B217BBB47 FOREIGN KEY (person_id) REFERENCES persons (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO vacancy_membersips (id, vacancy_id, person_id) SELECT id, vacancy_id, person_id FROM __temp__vacancy_membersips');
        $this->addSql('DROP TABLE __temp__vacancy_membersips');
        $this->addSql('CREATE INDEX IDX_7F640A6B433B78C4 ON vacancy_membersips (vacancy_id)');
        $this->addSql('CREATE INDEX IDX_7F640A6B217BBB47 ON vacancy_membersips (person_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7F640A6B433B78C4217BBB47 ON vacancy_membersips (vacancy_id, person_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_4DFF111C217BBB47');
        $this->addSql('DROP INDEX UNIQ_4DFF111C608487BC6A95E9C4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__person_networks AS SELECT id, person_id, network, identity FROM person_networks');
        $this->addSql('DROP TABLE person_networks');
        $this->addSql('CREATE TABLE person_networks (id CHAR(36) NOT NULL --(DC2Type:guid)
        , person_id CHAR(36) NOT NULL --(DC2Type:person_id)
        , network VARCHAR(32) DEFAULT NULL, identity VARCHAR(32) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO person_networks (id, person_id, network, identity) SELECT id, person_id, network, identity FROM __temp__person_networks');
        $this->addSql('DROP TABLE __temp__person_networks');
        $this->addSql('CREATE INDEX IDX_4DFF111C217BBB47 ON person_networks (person_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4DFF111C608487BC6A95E9C4 ON person_networks (network, identity)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__persons AS SELECT id, date, email, job_title, person_phone, name_first, name_last FROM persons');
        $this->addSql('DROP TABLE persons');
        $this->addSql('CREATE TABLE persons (id CHAR(36) NOT NULL --(DC2Type:person_id)
        , date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , email VARCHAR(255) DEFAULT NULL COLLATE BINARY, job_title VARCHAR(255) DEFAULT NULL COLLATE BINARY, person_phone VARCHAR(255) DEFAULT NULL COLLATE BINARY, name_first VARCHAR(255) NOT NULL, name_last VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO persons (id, date, email, job_title, person_phone, name_first, name_last) SELECT id, date, email, job_title, person_phone, name_first, name_last FROM __temp__persons');
        $this->addSql('DROP TABLE __temp__persons');
        $this->addSql('DROP INDEX IDX_7F640A6B433B78C4');
        $this->addSql('DROP INDEX IDX_7F640A6B217BBB47');
        $this->addSql('DROP INDEX UNIQ_7F640A6B433B78C4217BBB47');
        $this->addSql('CREATE TEMPORARY TABLE __temp__vacancy_membersips AS SELECT id, vacancy_id, person_id FROM vacancy_membersips');
        $this->addSql('DROP TABLE vacancy_membersips');
        $this->addSql('CREATE TABLE vacancy_membersips (id CHAR(36) NOT NULL --(DC2Type:guid)
        , vacancy_id CHAR(36) NOT NULL --(DC2Type:vacancy_id)
        , person_id CHAR(36) NOT NULL --(DC2Type:person_id)
        , PRIMARY KEY(id))');
        $this->addSql('INSERT INTO vacancy_membersips (id, vacancy_id, person_id) SELECT id, vacancy_id, person_id FROM __temp__vacancy_membersips');
        $this->addSql('DROP TABLE __temp__vacancy_membersips');
        $this->addSql('CREATE INDEX IDX_7F640A6B433B78C4 ON vacancy_membersips (vacancy_id)');
        $this->addSql('CREATE INDEX IDX_7F640A6B217BBB47 ON vacancy_membersips (person_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7F640A6B433B78C4217BBB47 ON vacancy_membersips (vacancy_id, person_id)');
    }
}
