<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208075405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // Check if public schema exists
        // $this->addSql('CREATE SCHEMA IF NOT EXISTS public;');
        $this->addSql('CREATE TABLE "companies" (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id),unique (name))');
        $this->addSql('CREATE TABLE "users" (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, role VARCHAR(50) NOT NULL, company_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('create index users_company_id_index on users (company_id);');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE "companies"');
        $this->addSql('DROP TABLE "users"');
    }
}
