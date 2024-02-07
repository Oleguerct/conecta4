<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119160409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP next_player_id');
        $this->addSql('ALTER TABLE game DROP player1_sid');
        $this->addSql('ALTER TABLE game DROP player2_sid');
        $this->addSql('ALTER TABLE game DROP turn');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d649e48fd905');
        $this->addSql('DROP INDEX idx_8d93d649e48fd905');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN game_id TO current_game_id');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6494E825C80 FOREIGN KEY (current_game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D6494E825C80 ON "user" (current_game_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6494E825C80');
        $this->addSql('DROP INDEX IDX_8D93D6494E825C80');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN current_game_id TO game_id');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d649e48fd905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8d93d649e48fd905 ON "user" (game_id)');
        $this->addSql('ALTER TABLE game ADD next_player_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD player1_sid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD player2_sid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD turn INT DEFAULT NULL');
    }
}
