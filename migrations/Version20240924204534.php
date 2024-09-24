<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924204534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE meal_addition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE meal (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE meal_addition (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE meal_choice (id INT NOT NULL, user_id INT NOT NULL, meal_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, meal_type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AEA1E79BA76ED395 ON meal_choice (user_id)');
        $this->addSql('CREATE INDEX IDX_AEA1E79B639666D6 ON meal_choice (meal_id)');
        $this->addSql('COMMENT ON COLUMN meal_choice.date IS \'(DC2Type:date)\'');
        $this->addSql('CREATE TABLE meal_choice_additions (meal_choice_id INT NOT NULL, meal_addition_id INT NOT NULL, PRIMARY KEY(meal_choice_id, meal_addition_id))');
        $this->addSql('CREATE INDEX IDX_C9C47C5827E964DA ON meal_choice_additions (meal_choice_id)');
        $this->addSql('CREATE INDEX IDX_C9C47C588F47E78A ON meal_choice_additions (meal_addition_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, full_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE meal_choice ADD CONSTRAINT FK_AEA1E79BA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meal_choice ADD CONSTRAINT FK_AEA1E79B639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meal_choice_additions ADD CONSTRAINT FK_C9C47C5827E964DA FOREIGN KEY (meal_choice_id) REFERENCES meal_choice (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meal_choice_additions ADD CONSTRAINT FK_C9C47C588F47E78A FOREIGN KEY (meal_addition_id) REFERENCES meal_addition (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE meal_addition_id_seq CASCADE');
        $this->addSql('ALTER TABLE meal_choice DROP CONSTRAINT FK_AEA1E79BA76ED395');
        $this->addSql('ALTER TABLE meal_choice DROP CONSTRAINT FK_AEA1E79B639666D6');
        $this->addSql('ALTER TABLE meal_choice_additions DROP CONSTRAINT FK_C9C47C5827E964DA');
        $this->addSql('ALTER TABLE meal_choice_additions DROP CONSTRAINT FK_C9C47C588F47E78A');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE meal_addition');
        $this->addSql('DROP TABLE meal_choice');
        $this->addSql('DROP TABLE meal_choice_additions');
        $this->addSql('DROP TABLE "user"');
    }
}
