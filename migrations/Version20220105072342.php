<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220105072342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__vacancies AS SELECT id, title, description FROM vacancies');
        $this->addSql('DROP TABLE vacancies');
        $this->addSql('CREATE TABLE vacancies (id CHAR(36) NOT NULL --(DC2Type:vacancy_id)
        , title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(16) DEFAULT \'new\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO vacancies (id, title, description) SELECT id, title, description FROM __temp__vacancies');
        $this->addSql('DROP TABLE __temp__vacancies');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__vacancies AS SELECT id, title, description FROM vacancies');
        $this->addSql('DROP TABLE vacancies');
        $this->addSql('CREATE TABLE vacancies (id CHAR(36) NOT NULL --(DC2Type:vacancy_id)
        , title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO vacancies (id, title, description) SELECT id, title, description FROM __temp__vacancies');
        $this->addSql('DROP TABLE __temp__vacancies');
    }
}
