<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119153018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD plyer1_sid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD player2_sid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE game ADD turn INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE game DROP plyer1_sid');
        $this->addSql('ALTER TABLE game DROP player2_sid');
        $this->addSql('ALTER TABLE game DROP turn');
    }
}
