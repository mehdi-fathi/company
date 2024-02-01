<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Enum\RoleTypeEnum;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240201064615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TYPE role_user  AS ENUM ('" . RoleTypeEnum::USER->getValue() . "','" . RoleTypeEnum::COMPANY_ADMIN->getValue() . "','" . RoleTypeEnum::SUPER_ADMIN->getValue() . "')");
        // Add other SQL statements if needed
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TYPE role_user');
        // Add other SQL statements if needed
    }
}
