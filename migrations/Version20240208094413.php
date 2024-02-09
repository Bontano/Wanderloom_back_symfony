<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208094413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_itinary (id INT AUTO_INCREMENT NOT NULL, user_creator_id INT NOT NULL, itinary_id INT NOT NULL, INDEX IDX_79E26162C645C84A (user_creator_id), INDEX IDX_79E26162B897C559 (itinary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_itinary ADD CONSTRAINT FK_79E26162C645C84A FOREIGN KEY (user_creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_itinary ADD CONSTRAINT FK_79E26162B897C559 FOREIGN KEY (itinary_id) REFERENCES itinary (id)');
        $this->addSql('ALTER TABLE activity ADD country VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE itinary DROP FOREIGN KEY FK_21EF7F68C645C84A');
        $this->addSql('DROP INDEX IDX_21EF7F68C645C84A ON itinary');
        $this->addSql('ALTER TABLE itinary DROP user_creator_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_itinary DROP FOREIGN KEY FK_79E26162C645C84A');
        $this->addSql('ALTER TABLE user_itinary DROP FOREIGN KEY FK_79E26162B897C559');
        $this->addSql('DROP TABLE user_itinary');
        $this->addSql('ALTER TABLE activity DROP country');
        $this->addSql('ALTER TABLE itinary ADD user_creator_id INT NOT NULL');
        $this->addSql('ALTER TABLE itinary ADD CONSTRAINT FK_21EF7F68C645C84A FOREIGN KEY (user_creator_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_21EF7F68C645C84A ON itinary (user_creator_id)');
    }
}
