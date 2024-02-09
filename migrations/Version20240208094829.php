<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208094829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE itinary_activity (id INT AUTO_INCREMENT NOT NULL, activity_id INT DEFAULT NULL, itinary_id INT DEFAULT NULL, day_moment VARCHAR(255) NOT NULL, day VARCHAR(255) NOT NULL, INDEX IDX_2967ECD781C06096 (activity_id), INDEX IDX_2967ECD7B897C559 (itinary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE itinary_activity ADD CONSTRAINT FK_2967ECD781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE itinary_activity ADD CONSTRAINT FK_2967ECD7B897C559 FOREIGN KEY (itinary_id) REFERENCES itinary (id)');
        $this->addSql('ALTER TABLE user_itinary ADD favorite TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE itinary_activity DROP FOREIGN KEY FK_2967ECD781C06096');
        $this->addSql('ALTER TABLE itinary_activity DROP FOREIGN KEY FK_2967ECD7B897C559');
        $this->addSql('DROP TABLE itinary_activity');
        $this->addSql('ALTER TABLE user_itinary DROP favorite');
    }
}
