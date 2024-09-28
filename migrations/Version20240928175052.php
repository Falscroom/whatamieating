<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240928175052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal_addition ADD meal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE meal_addition ADD CONSTRAINT FK_8EFBA8EB639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8EFBA8EB639666D6 ON meal_addition (meal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE meal_addition DROP CONSTRAINT FK_8EFBA8EB639666D6');
        $this->addSql('DROP INDEX IDX_8EFBA8EB639666D6');
        $this->addSql('ALTER TABLE meal_addition DROP meal_id');
    }
}
